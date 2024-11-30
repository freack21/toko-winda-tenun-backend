<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        // Validasi file gambar
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Simpan gambar di folder storage/app/public/images
        $path = $request->file('image')->move(public_path('/chat-images'));

        // Buat URL untuk gambar yang disimpan
        $url = Storage::url($path);

        // Kembalikan URL dalam respons
        return response()->json([
            'success' => true,
            'message' => 'Image uploaded successfully',
            'url' => asset($url),
        ], 200);
    }
}
