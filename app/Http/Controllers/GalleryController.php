<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GalleryItem;
use Illuminate\Support\Facades\Storage;
use App\Models\GalleryDescription;
use Stichoza\GoogleTranslate\GoogleTranslate;
use App\Http\Controllers\LanguageMapperController;



class GalleryController extends Controller
{
    protected $translate;
    protected $languageMapper;

    public function __construct(LanguageMapperController $languageMapper)
    {
        $this->translate = new GoogleTranslate();
        $this->translate->setSource('sr');
        $this->translate->setTarget('en');
        $this->languageMapper = $languageMapper;
    }

    public function index()
    {
        $images = GalleryItem::where('type', 'image')->get();
        $videos = GalleryItem::where('type', 'video')->get();
        
        $galleryDescription = GalleryDescription::first(); 

        


        return view('gallery', compact('images', 'videos', 'galleryDescription'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpeg,jpg,png,gif,mp4,mov,avi|max:2048', 
        ], [
            'file.required' => 'Morate izabrati fajl za upload.',
            'file.mimes' => 'Dozvoljeni formati su: jpeg, jpg, png, gif, mp4, mov, avi.',
            'file.max' => 'Vaš fajl ne sme biti veći od 2 MB.',
        ]);

        $file = $request->file('file');
        if ($file->getSize() > 2097152) { 
            return back()->with('error', 'Vaš fajl ne sme biti veći od 2 MB.');
        }

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

    public function updateDescription(Request $request)
    {
        $request->validate([
            'value' => 'required|string',
        ]);

        $value = $request->input('value');
        $locale = app()->getLocale();

        $isCyrillic = preg_match('/[\p{Cyrillic}]/u', $value);

        if ($locale === 'en') {
            $value_en = $value;
            $value_lat = $this->translate->setSource('en')->setTarget('sr')->translate($value_en);
            $value_cy = $this->languageMapper->latin_to_cyrillic($value_lat);
        } elseif ($isCyrillic) {
            $value_cy = $value;
            $value_lat = $this->languageMapper->cyrillic_to_latin($value_cy);
            $value_en = $this->translate->setSource('sr')->setTarget('en')->translate($value_lat);
        } else {
            $value_lat = $value;
            $value_cy = $this->languageMapper->latin_to_cyrillic($value_lat);
            $value_en = $this->translate->setSource('sr')->setTarget('en')->translate($value_lat);
        }

        $galleryDescription = GalleryDescription::first();
        if ($galleryDescription) {
            $galleryDescription->update([
                'value'    => $value_lat,
                'value_en' => $value_en,
                'value_cy' => $value_cy,
            ]);
        } else {
            GalleryDescription::create([
                'value'    => $value_lat,
                'value_en' => $value_en,
                'value_cy' => $value_cy,
            ]);
        }


        return back()->with('success', 'Opis galerije uspešno ažuriran na svim jezicima.');
    }


}
