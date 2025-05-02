<?php

namespace App\Http\Controllers;

use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        // Validate the request
        $request->validate([
        'document' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);
        // Store the file
        $path = $request->file('document')->store('uploads');
        // Return a response
        return response()->json(['path' => $path], 200);
    }

    public function uploadMinio(Request $request)
    {
        // Validate the request
        $request->validate([
        'document' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $doc = $request->file('document');
        $filename = uniqid() . '.' . $doc->getClientOriginalExtension();

        try {
            $path = $doc->storeAs('uploads', $filename, ['disk' => 'minio']);
            return response()->json(['path' => $path], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
        'image' => 'required|image|max:2048' // Validation rules for upload
        ]);
        $image = $request->file('image');
        $fileName = uniqid() . '.' . $image->getClientOriginalExtension();

        $path = $image->storeAs('uploads', $fileName); // Store the original image

        // (Optional) Using Intervention Image
        $thumbnailPath = 'thumbnails/' . $fileName;
        $intervention = Image::make($image->getRealPath());
        $intervention->fit(200, 200, function ($constraint) {
            $constraint->aspectRatio();
        })->save(storage_path('app/' . $thumbnailPath));

        // (Alternative) Using pure Imagick
        // $imagick = new Imagick(storage_path('app/uploads/' . $fileName));
        // $imagick->resizeImage(200, 200, Imagick::FILTER_TRIANGLE, 1);
        // $imagick->writeImage(storage_path('app/thumbnails/' . $fileName));
        // Update your Image model to store original and thumbnail paths (if ap
        return redirect()->route('gallery.index')->with('success', 'Image uploaded');
    }

}
