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
    ]);

    $translate = new \Stichoza\GoogleTranslate\GoogleTranslate();
    $lm = app(\App\Http\Controllers\LanguageMapperController::class);

    $src = $validated['locale'] ?? 'sr';

    $langFiles = [
        'sr'      => resource_path('lang/sr.json'),
        'sr-Cyrl' => resource_path('lang/sr-Cyrl.json'),
        'en'      => resource_path('lang/en.json'),
    ];

    // Učitaj postojeći json (ako postoji)
    $oldData = file_exists($langFiles[$src]) ? json_decode(file_get_contents($langFiles[$src]), true) : [];
    $servicesData = $oldData['services'] ?? [];

    // Updateuj samo prosleđene vrednosti
    foreach (['hero_title', 'hero_subtitle', 'main_text'] as $field) {
        if (array_key_exists($field, $validated)) {
            $servicesData[$field] = $validated[$field];
        }
    }

    // Pripremi za sva tri jezika
    $localized = [
        'sr'      => $servicesData,
        'sr-Cyrl' => $servicesData,
        'en'      => $servicesData,
    ];

    // Srpska ćirilica
    foreach (['hero_title', 'hero_subtitle', 'main_text'] as $field) {
        if (isset($servicesData[$field])) {
            $localized['sr-Cyrl'][$field] = $lm->latin_to_cyrillic($servicesData[$field]);
        }
    }

    // Engleski prevod
    $translate->setSource('sr')->setTarget('en');
    foreach (['hero_title', 'hero_subtitle', 'main_text'] as $field) {
        if (isset($servicesData[$field])) {
            $localized['en'][$field] = $translate->translate($servicesData[$field]);
        }
    }

    // Sačuvaj za svaki jezik
    foreach ($langFiles as $lang => $path) {
        $json = file_exists($path) ? json_decode(file_get_contents($path), true) : [];
        $json['services'] = $localized[$lang];
        file_put_contents($path, json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

    return response()->json(['success' => true, 'message' => 'Usluge su ažurirane na svim jezicima!']);
}


    public function uploadSectionImage(Request $request, $sectionIndex)
    {
        $request->validate([
            'image' => 'required|image|max:4096',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'service_section_' . $sectionIndex . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);

            return response()->json([
                'success' => true,
                'image_path' => asset('images/' . $filename)
            ]);
        }

        return response()->json([
            'success' => false,
            'error' => 'No image uploaded'
        ], 400);
    }
}