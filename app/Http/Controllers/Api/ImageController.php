<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class ImageController extends Controller
{
    public function show($filename)
    {
        $path = storage_path("app/public/posts/{$filename}");

        if (!file_exists($path)) {
            abort(404);
        }

        $file = file_get_contents($path);

        return new Response($file, 200, [
            'Content-Type' => 'image/jpeg', // Adjust the content type based on your image format
        ]);
    }
}
