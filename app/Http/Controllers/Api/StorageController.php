<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class StorageController extends Controller
{
    /**
     * Ambil file cover dari storage/public/covers
     * Contoh URL: /api/covers/nama-file.jpg
     */
    public function cover(string $filename, Request $request): Response
    {
        $path = 'covers/' . $filename;

        // cek file ada atau tidak
        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'File not found.');
        }

        $file = Storage::disk('public')->get($path);
        $mime = Storage::disk('public')->mimeType($path);

        return response($file, 200)
            ->header('Content-Type', $mime);
        // header CORS akan otomatis ditambah oleh middleware CORS
    }
}
