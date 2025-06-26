<?php

namespace App\Http\Controllers;

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
        'locale'         => 'string|in:sr,sr-Cyrl,en',
        'header'         => 'nullable|string|max:255',
        'hero_title'     => 'nullable|string|max:255',
        'hero_subtitle'  => 'nullable|string|max:255',
        'sections'       => 'nullable|array',
        'from_label'     => 'nullable|string|max:255',
        'to_label'       => 'nullable|string|max:255',
        'price_unit_label' => 'nullable|string|max:255',
    ]);

    $translate = new \Stichoza\GoogleTranslate\GoogleTranslate();
    $lm = app(\App\Http\Controllers\LanguageMapperController::class);

    // Učitaj postojeći sadržaj
    $src = $validated['locale'] ?? 'sr';

    // Prvo pročitaj ceo fajl da dobiješ stari services
    $langFiles = [
        'sr'      => resource_path('lang/sr.json'),
        'sr-Cyrl' => resource_path('lang/sr-Cyrl.json'),
        'en'      => resource_path('lang/en.json'),
    ];
    $oldData = file_exists($langFiles[$src]) ? json_decode(file_get_contents($langFiles[$src]), true) : [];
    $servicesData = $oldData['services'] ?? [];

    // Ažuriraj samo ono što je stiglo u requestu (ostalo ostaje)
    foreach (['header', 'hero_title', 'hero_subtitle', 'sections', 'from_label', 'to_label', 'price_unit_label'] as $field) {
        if (array_key_exists($field, $validated)) {
            $servicesData[$field] = $validated[$field];
        }
    }

    // Lokalizacija kao i ranije
    $localized = [
        'sr'      => $servicesData,
        'sr-Cyrl' => $servicesData,
        'en'      => $servicesData,
    ];

    // SR-Cyrl
    foreach (['header','hero_title','hero_subtitle','from_label','to_label','price_unit_label'] as $field) {
        if (isset($servicesData[$field])) {
            $localized['sr-Cyrl'][$field] = $lm->latin_to_cyrillic($servicesData[$field]);
        }
    }
    if (isset($servicesData['sections'])) {
        foreach ($servicesData['sections'] as $i => $section) {
            foreach ($section as $key => $value) {
                if (is_string($value)) {
                    $localized['sr-Cyrl']['sections'][$i][$key] = $lm->latin_to_cyrillic($value);
                } elseif (is_array($value)) {
                    $localized['sr-Cyrl']['sections'][$i][$key] = array_map(function($v) use ($lm) {
                        return is_string($v) ? $lm->latin_to_cyrillic($v) : $v;
                    }, $value);
                }
            }
        }
    }

    // EN
    $translate->setSource('sr')->setTarget('en');
    foreach (['header','hero_title','hero_subtitle','from_label','to_label','price_unit_label'] as $field) {
        if (isset($servicesData[$field])) {
            $localized['en'][$field] = $translate->translate($servicesData[$field]);
        }
    }
    if (isset($servicesData['sections'])) {
        foreach ($servicesData['sections'] as $i => $section) {
            foreach ($section as $key => $value) {
                if (is_string($value)) {
                    $localized['en']['sections'][$i][$key] = $translate->translate($value);
                } elseif (is_array($value)) {
                    $localized['en']['sections'][$i][$key] = array_map(function($v) use ($translate) {
                        return is_string($v) ? $translate->translate($v) : $v;
                    }, $value);
                }
            }
        }
    }

    // Sačuvaj u sva tri fajla
    foreach ($langFiles as $lang => $path) {
        $json = file_exists($path) ? json_decode(file_get_contents($path), true) : [];
        $json['services'] = $localized[$lang];
        file_put_contents($path, json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

    return back()->with('success', 'Usluge su ažurirane na svim jezicima!');
}


}
