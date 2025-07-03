<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GalleryItem;
use Illuminate\Support\Facades\Storage;
use Stichoza\GoogleTranslate\GoogleTranslate;
use App\Http\Controllers\LanguageMapperController;
use Illuminate\Support\Facades\File;




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

        $locale = app()->getLocale();
        $galleryDescription = __('gallery.description', [], $locale);

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
        if (strstr($mime, "video/")) {
            $type = 'video';
        } else if (strstr($mime, "image/")) {
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
            'value' => 'required|string'
        ]);

        $originalText = trim($request->input('value'));
        $detectedScript = $this->languageMapper->detectScript($originalText);

        if ($detectedScript === 'cyrillic') {
            $value_cy = $originalText;
            $value_lat = $this->languageMapper->cyrillic_to_latin($value_cy);
            $value_en = $this->translate->setSource('sr')->setTarget('en')->translate($value_lat);
        } elseif (app()->getLocale() === 'sr') {
            $value_lat = $originalText;
            $value_cy = $this->languageMapper->latin_to_cyrillic($value_lat);
            $value_en = $this->translate->setSource('sr')->setTarget('en')->translate($value_lat);
        } else {
            $value_en = $originalText;
            $this->updateLangFile('en', ['gallery.description' => $value_en]);
            return back()->with('success', 'Opis galerije je uspešno ažuriran.');
        }

        $this->updateLangFile('sr', ['gallery.description' => $value_lat]);
        $this->updateLangFile('sr-Cyrl', ['gallery.description' => $value_cy]);
        $this->updateLangFile('en', ['gallery.description' => $value_en]);

        return back()->with('success', 'Opis galerije je uspešno ažuriran.');
    }

    protected function updateLangFile($locale, array $data)
    {
        $path = resource_path("lang/{$locale}.json");

        if (!File::exists($path)) {
            File::put($path, '{}');
        }

        $translations = json_decode(File::get($path), true) ?? [];

        $translations = array_merge($translations, $data);

        File::put($path, json_encode($translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}
