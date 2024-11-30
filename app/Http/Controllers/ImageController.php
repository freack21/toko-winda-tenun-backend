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

        // Ambil file gambar dari request
        $file = $request->file('image');

        // Simpan gambar dengan nama asli di folder public/chat-images
        $filename = time() . '_' . $file->getClientOriginalName(); // Pastikan nama file unik
        $path = $file->move(public_path('chat-images'), $filename);

        // Buat URL untuk gambar yang disimpan
        $url = asset('chat-images/' . $filename);

        // Kembalikan URL dalam respons
        return response()->json([
            'success' => true,
            'message' => 'Image uploaded successfully',
            'url' => asset($url),
        ], 200);
    }
}
