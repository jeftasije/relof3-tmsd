<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class ServicesController extends Controller
{
    public function show()
    {
        $text = Lang::get('services');
        return view('services', compact('text'));
    }

    public function index()
    {
        $servicesData = Lang::get('services');
        return view('services', compact('servicesData'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'locale'        => 'string|in:sr,sr-Cyrl,en',
            'hero_title'    => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string|max:255',
            'main_text'     => 'nullable|string',
            'images'        => 'nullable|array',
            'images.*'      => 'nullable|string',
        ]);

        $translate = new \Stichoza\GoogleTranslate\GoogleTranslate();
        $lm = app(\App\Http\Controllers\LanguageMapperController::class);

        $src = $validated['locale'] ?? 'sr';

        $langFiles = [
            'sr'      => resource_path('lang/sr.json'),
            'sr-Cyrl' => resource_path('lang/sr-Cyrl.json'),
            'en'      => resource_path('lang/en.json'),
        ];

        $oldData = file_exists($langFiles[$src]) ? json_decode(file_get_contents($langFiles[$src]), true) : [];
        $servicesData = $oldData['services'] ?? [];

        foreach (['hero_title', 'hero_subtitle', 'main_text'] as $field) {
            if (array_key_exists($field, $validated)) {
                $servicesData[$field] = $validated[$field];
            }
        }

        // Dodaj i slike iz zahteva (prepisuje stari niz)
        if (array_key_exists('images', $validated)) {
            $servicesData['images'] = $validated['images'];
        }

        // Početna vrednost za sva tri jezika
        $localized = [
            'sr'      => $servicesData,
            'sr-Cyrl' => $servicesData,
            'en'      => $servicesData,
        ];

        // Dinamički source: šta god da menjaš, koristiš to kao izvor
        if ($src === 'sr') {
            foreach (['hero_title', 'hero_subtitle', 'main_text'] as $field) {
                if (isset($servicesData[$field])) {
                    $localized['sr-Cyrl'][$field] = $lm->latin_to_cyrillic($servicesData[$field]);
                }
            }
            if (isset($servicesData['images'])) {
                $localized['sr-Cyrl']['images'] = $servicesData['images'];
            }
            $translate->setSource('sr')->setTarget('en');
            foreach (['hero_title', 'hero_subtitle', 'main_text'] as $field) {
                if (isset($servicesData[$field])) {
                    $localized['en'][$field] = $translate->translate($servicesData[$field]);
                }
            }
            if (isset($servicesData['images'])) {
                $localized['en']['images'] = $servicesData['images'];
            }
        } elseif ($src === 'sr-Cyrl') {
            foreach (['hero_title', 'hero_subtitle', 'main_text'] as $field) {
                if (isset($servicesData[$field])) {
                    $localized['sr'][$field] = $lm->cyrillic_to_latin($servicesData[$field]);
                }
            }
            if (isset($servicesData['images'])) {
                $localized['sr']['images'] = $servicesData['images'];
            }
            $translate->setSource('sr')->setTarget('en');
            foreach (['hero_title', 'hero_subtitle', 'main_text'] as $field) {
                if (isset($localized['sr'][$field])) {
                    $localized['en'][$field] = $translate->translate($localized['sr'][$field]);
                }
            }
            if (isset($servicesData['images'])) {
                $localized['en']['images'] = $servicesData['images'];
            }
        } elseif ($src === 'en') {
            $translate->setSource('en')->setTarget('sr');
            foreach (['hero_title', 'hero_subtitle', 'main_text'] as $field) {
                if (isset($servicesData[$field])) {
                    // Prvo prevedi na srpski (ne znaš da li je ćirilica ili latinica)
                    $translated = $translate->translate($servicesData[$field]);
                    // Latinicu FORSIRAJ transliteracijom, izbegavaš ćirilicu
                    $localized['sr'][$field] = $lm->cyrillic_to_latin($translated);
                    // Ćirilica iz latinice
                    $localized['sr-Cyrl'][$field] = $lm->latin_to_cyrillic($localized['sr'][$field]);
                }
            }
            if (isset($servicesData['images'])) {
                $localized['sr']['images'] = $servicesData['images'];
                $localized['sr-Cyrl']['images'] = $servicesData['images'];
            }
        }

        foreach ($langFiles as $lang => $path) {
            $json = file_exists($path) ? json_decode(file_get_contents($path), true) : [];
            $json['services'] = $localized[$lang];
            file_put_contents($path, json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        }

        return response()->json(['success' => true, 'message' => 'Usluge su ažurirane na svim jezicima!']);
    }


    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:4096',
        ]);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = uniqid('service_') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            // Samo vrati path
            return response()->json([
                'success' => true,
                'image_path' => '/images/' . $filename, // Samo path
            ]);
        }
        return response()->json(['success' => false, 'error' => 'No image uploaded'], 400);
    }

    public function deleteImage(Request $request, $index)
    {
        $locale = $request->input('locale', 'sr'); // podrazumevano sr

        $langFiles = [
            'sr'      => resource_path('lang/sr.json'),
            'sr-Cyrl' => resource_path('lang/sr-Cyrl.json'),
            'en'      => resource_path('lang/en.json'),
        ];

        if (!isset($langFiles[$locale])) {
            return response()->json(['success' => false, 'error' => 'Nepoznat jezik.'], 400);
        }

        $path = $langFiles[$locale];
        if (!file_exists($path)) {
            return response()->json(['success' => false, 'error' => 'Fajl ne postoji.'], 404);
        }

        $json = json_decode(file_get_contents($path), true);
        if (!isset($json['services']['images']) || !is_array($json['services']['images'])) {
            return response()->json(['success' => false, 'error' => 'Niz slika ne postoji.'], 400);
        }

        if (!isset($json['services']['images'][$index])) {
            return response()->json(['success' => false, 'error' => 'Slika ne postoji.'], 404);
        }

        // Opcionalno: Obrisi i fajl sa diska ako treba!
        //$imagePath = public_path(parse_url($json['services']['images'][$index], PHP_URL_PATH));
        //if (file_exists($imagePath)) {
        //    @unlink($imagePath);
        //}

        array_splice($json['services']['images'], $index, 1);

        file_put_contents($path, json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        return response()->json(['success' => true, 'message' => 'Slika uspešno obrisana.']);
    }

}
