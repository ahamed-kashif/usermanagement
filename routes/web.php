<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
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
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
Route::prefix('users')->middleware(['auth','admin'])->group(function () {
    Route::get('/',[RegisteredUserController::class,'index'])->name('users.index');
    Route::post('store/',[RegisteredUserController::class,'store'])->name('users.store');
    Route::get('/{id}',[RegisteredUserController::class,'edit'])->name('users.edit');
    Route::put('update/{id}',[RegisteredUserController::class,'update'])->name('users.update');
    Route::delete('delete/{id}',[RegisteredUserController::class,'destroy'])->name('users.delete');
});
