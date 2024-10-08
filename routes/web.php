<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    $urls = [];
    $user = Auth::guard('web')->user();
    if($user->hasRole('admin')){
        $urls = \App\Models\ResponseViewUrl::orderBy('created_at', 'desc')
            ->with('form')
            ->withCount(['responses as res_count'])->get()->map(function($url){
                $responseData = $url->responses->map(function ($response) {
                    return [
                        'created_at' => $response->created_at->format('Y-m-d'),
                    ];
                })->countBy('created_at')->map(function ($count, $date) {
                    return [
                        'date' => $date,
                        'count' => $count,
                    ];
                })->values();
                return [
                    'user' => [
                        'id' => $url->user->id,
                        'email' => $url->user->email,
                    ],
                    'id' => $url->id,
                    'url' => $url->uri,
                    'form' => $url->form->name ?? 'N\A',
                    'res_count' => $url->res_count,
                    'data' => $responseData,
                ];
        });
    }else{
        $urls = $user->uris()->with(['form','responses'])->withCount(['responses as res_count'])->get()->map(function($url){
            $responseData = $url->responses->map(function ($response) {
                return [
                    'created_at' => $response->created_at->format('Y-m-d'),
                ];
            })->countBy('created_at')->map(function ($count, $date) {
                return [
                    'date' => $date,
                    'count' => $count,
                ];
            })->values();

            return [
                'id' => $url->id,
                'url' => $url->uri,
                'form' => $url->form->name ?? 'N/A',
                'res_count' => $url->res_count,
                'data' => $responseData, // Data for charting
            ];
        });
    }
    return Inertia::render('Dashboard',[
        'urls' => $urls
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
Route::prefix('users')->middleware(['auth','admin'])->group(function () {
    Route::get('/',[RegisteredUserController::class,'index'])->name('users.index');
    Route::get('/create',[RegisteredUserController::class,'create'])->name('users.create');
    Route::post('store/',[RegisteredUserController::class,'store'])->name('users.store');
    Route::get('/{id}',[RegisteredUserController::class,'edit'])->name('users.edit');
    Route::put('update/{id}',[RegisteredUserController::class,'update'])->name('users.update');
    Route::delete('delete/{id}',[RegisteredUserController::class,'destroy'])->name('users.delete');
});

Route::prefix('forms')->middleware(['guest'])->group(function () {
    Route::get('d/{code}',[\App\Http\Controllers\ResponseController::class,'show'])->name('forms.d');
    Route::get('u/{uri}',[\App\Http\Controllers\ResponseController::class,'showByUri'])->name('forms.u');
    Route::get('/submitted',[\App\Http\Controllers\ResponseController::class,'submitted'])->name('forms.submitted');
});
Route::post('submit-form',[\App\Http\Controllers\ResponseController::class,'store'])->name('res.store');
Route::post('update-ssn/{id}', [\App\Http\Controllers\ResponseController::class, 'updateSsn'])->name('res.update');

use App\Http\Controllers\Admin\ResponseController;

Route::get('/responses', [ResponseController::class, 'index'])->middleware(['auth'])->name('responses.index');
Route::get('/responses/download/{id}', [ResponseController::class, 'downloadAllFiles'])->middleware(['auth'])->name('response.download');
