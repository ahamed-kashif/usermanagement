<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FormResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Spatie\MediaLibrary\Support\MediaStream;
use ZipArchive;


class ResponseController extends Controller
{
    private function check($response)
    {
        $user = Auth::guard('web')->user();

        if (!$user->hasRole('admin') || !$user->uris()->where('uri', $response->uri)->exists()) {
            die('Unauthorized Access!');
        }
    }

    // Function to show paginated responses
    public function index(Request $request)
    {
        // Fetch paginated form responses (10 per page)
        $user = Auth::guard('web')->user();
        if($user->hasRole('admin')){
            $formResponses = FormResponse::paginate(10);
        }else{
            $formResponses = FormResponse::whereHas('originUrl', function($query) use ($user) {
                // Fetch only the responses linked to the user's URIs
                $query->whereIn('uri', $user->uris->pluck('uri'));
            })->paginate(10);
        }

        return Inertia::render('Responses', [
            'responses' => $formResponses,
        ]);
    }

    // Function to download all files as a zip
    public function downloadAllFiles($id)
    {
        $response = FormResponse::findOrFail($id);

        // Get all media files from both collections
        $downloadsId = $response->getMedia('id_card');
        $downloadsSelfi = $response->getMedia('selfie_id_card');

        // Check if either collection has files
        if ($downloadsId->isEmpty() && $downloadsSelfi->isEmpty()) {
            return response()->json(['error' => 'No files available for download.'], 404);
        }

        // Merge both collections
        $allMedia = $downloadsId->merge($downloadsSelfi);
//        dd($allMedia);
        // Create ZIP stream with merged media
        return MediaStream::create($response->id . '.zip')->addMedia($allMedia);
    }
}
