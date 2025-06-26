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
            'locale' => 'required|string|in:sr,sr-Cyrl,en',
            'header' => 'required|string|max:255',
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'required|string|max:255',
            'sections' => 'required|array',
        ]);

        $translate = new \Stichoza\GoogleTranslate\GoogleTranslate();
        $lm = app(\App\Http\Controllers\LanguageMapperController::class);

        // Pripremi podatke za editovani jezik
        $servicesData = [
            'header'       => $validated['header'],
            'hero_title'   => $validated['hero_title'],
            'hero_subtitle'=> $validated['hero_subtitle'],
            'sections'     => $validated['sections'],
            'from_label'   => 'od',
            'to_label'     => 'do',
            'price_unit_label' => 'po komadu'
        ];

        // Lokalizuj za svaki jezik
        $localized = [
            'sr'      => [],
            'sr-Cyrl' => [],
            'en'      => [],
        ];

        // --- SR verzija ---
        $localized['sr'] = $servicesData;

        // --- CYRILLIC verzija ---
        $localized['sr-Cyrl'] = $servicesData;
        foreach (['header','hero_title','hero_subtitle','from_label','to_label','price_unit_label'] as $field) {
            $localized['sr-Cyrl'][$field] = $lm->latin_to_cyrillic($servicesData[$field]);
        }
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

        // --- EN verzija ---
        $translate->setSource('sr')->setTarget('en');
        $localized['en'] = $servicesData;
        foreach (['header','hero_title','hero_subtitle','from_label','to_label','price_unit_label'] as $field) {
            $localized['en'][$field] = $translate->translate($servicesData[$field]);
        }
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

        $files = [
            'sr'      => resource_path('lang/sr.json'),
            'sr-Cyrl' => resource_path('lang/sr-Cyrl.json'),
            'en'      => resource_path('lang/en.json'),
        ];

        foreach ($files as $lang => $path) {
            $json = file_exists($path) ? json_decode(file_get_contents($path), true) : [];
            $json['services'] = $localized[$lang];
            file_put_contents($path, json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        }

        return back()->with('success', 'Usluge su ažurirane na svim jezicima!');
    }

}
