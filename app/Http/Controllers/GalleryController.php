<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GalleryItem;
use Illuminate\Support\Facades\Storage;



class GalleryController extends Controller
{
    public function index()
    {
        $images = GalleryItem::where('type', 'image')->get();
        $videos = GalleryItem::where('type', 'video')->get();

        return view('gallery', compact('images', 'videos'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png,mp4,mov,avi|max:51200',
        ]);

        $file = $request->file('file');
        $path = $file->store('public/gallery');
        $type = str_starts_with($file->getMimeType(), 'video') ? 'video' : 'image';

        GalleryItem::create([
            'path' => $path,
            'type' => $type,
        ]);

        return back()->with('success', 'Fajl dodat.');
    }

    public function destroy(GalleryItem $item)
    {
        Storage::delete($item->path);
        $item->delete();

        return back()->with('success', 'Fajl obrisan.');
    }

}
