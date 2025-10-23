<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
    public function store(Request $request)
    {
        if (!$request->hasFile('file')) {
            return response()->json(['error' => 'No file uploaded'], 400);
        }

        $file = $request->file('file');

        // Validate image type
        $request->validate([
            'file' => 'required|image|max:2048', // max 2MB
        ]);

        // Store image
        $path = $file->store('uploads/quill', 'public');

        return response()->json([
            'url' => Storage::url($path),
        ]);
    }
}
