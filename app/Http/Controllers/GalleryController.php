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
        $file = $request->file('file');
        $filePath = $file->store('gallery', 'public'); 
        $mime = $file->getMimeType();
        if(strstr($mime, "video/")){
            $type = 'video';
        }else if(strstr($mime, "image/")){
            $type = 'image';

        }
        

        GalleryItem::create([
            'path' => $filePath,
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
