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
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'required|string|max:255',
            'sections' => 'required|array',
        ]);

        $translate = new \Stichoza\GoogleTranslate\GoogleTranslate();
        $lm = app(\App\Http\Controllers\LanguageMapperController::class);

        // Svi fajlovi i jezici
        $files = [
            'sr'      => resource_path('lang/sr.json'),
            'sr-Cyrl' => resource_path('lang/sr-Cyrl.json'),
            'en'      => resource_path('lang/en.json'),
        ];

        // Prvo pokupi podatke sa editovanog jezika
        $src = $validated['locale'];
        $data = [
            'hero_title'    => $validated['hero_title'],
            'hero_subtitle' => $validated['hero_subtitle'],
            'sections'      => $validated['sections'],
        ];

        // Napravi verzije za sva tri jezika
        $localized = [
            'sr'      => [],
            'sr-Cyrl' => [],
            'en'      => [],
        ];

        if ($src === 'sr') {
            $localized['sr'] = $data;
            $localized['sr-Cyrl']['hero_title']    = $lm->latin_to_cyrillic($data['hero_title']);
            $localized['sr-Cyrl']['hero_subtitle'] = $lm->latin_to_cyrillic($data['hero_subtitle']);
            $localized['en']['hero_title']    = $translate->setSource('sr')->setTarget('en')->translate($data['hero_title']);
            $localized['en']['hero_subtitle'] = $translate->setSource('sr')->setTarget('en')->translate($data['hero_subtitle']);
            // Sections
            foreach ($data['sections'] as $i => $s) {
                // Title — ne prevodi za prva dva!
                $localized['sr']['sections'][$i]['title'] = $s['title'];
                $localized['sr-Cyrl']['sections'][$i]['title'] = $i <= 1 ? $this->getSectionTitleFromJson('sr-Cyrl', $i) : $lm->latin_to_cyrillic($s['title']);
                $localized['en']['sections'][$i]['title'] = $i <= 1 ? $this->getSectionTitleFromJson('en', $i) : $translate->setSource('sr')->setTarget('en')->translate($s['title']);
                // Ostali podaci prevodi
                foreach ($s as $key => $val) {
                    if ($key == 'title') continue;
                    $localized['sr']['sections'][$i][$key]      = $val;
                    $localized['sr-Cyrl']['sections'][$i][$key] = is_array($val) 
                        ? array_map(fn($x) => is_string($x) ? $lm->latin_to_cyrillic($x) : $x, $val)
                        : (is_string($val) ? $lm->latin_to_cyrillic($val) : $val);
                    $localized['en']['sections'][$i][$key] = is_array($val)
                        ? array_map(fn($x) => is_string($x) ? $translate->setSource('sr')->setTarget('en')->translate($x) : $x, $val)
                        : (is_string($val) ? $translate->setSource('sr')->setTarget('en')->translate($val) : $val);
                }
            }
        } elseif ($src === 'sr-Cyrl') {
            $localized['sr-Cyrl'] = $data;
            $localized['sr']['hero_title']    = $lm->cyrillic_to_latin($data['hero_title']);
            $localized['sr']['hero_subtitle'] = $lm->cyrillic_to_latin($data['hero_subtitle']);
            $localized['en']['hero_title']    = $translate->setSource('sr')->setTarget('en')->translate($localized['sr']['hero_title']);
            $localized['en']['hero_subtitle'] = $translate->setSource('sr')->setTarget('en')->translate($localized['sr']['hero_subtitle']);
            foreach ($data['sections'] as $i => $s) {
                $localized['sr-Cyrl']['sections'][$i]['title'] = $s['title'];
                $localized['sr']['sections'][$i]['title'] = $i <= 1 ? $this->getSectionTitleFromJson('sr', $i) : $lm->cyrillic_to_latin($s['title']);
                $localized['en']['sections'][$i]['title'] = $i <= 1 ? $this->getSectionTitleFromJson('en', $i) : $translate->setSource('sr')->setTarget('en')->translate($lm->cyrillic_to_latin($s['title']));
                foreach ($s as $key => $val) {
                    if ($key == 'title') continue;
                    $localized['sr-Cyrl']['sections'][$i][$key] = $val;
                    $localized['sr']['sections'][$i][$key] = is_array($val)
                        ? array_map(fn($x) => is_string($x) ? $lm->cyrillic_to_latin($x) : $x, $val)
                        : (is_string($val) ? $lm->cyrillic_to_latin($val) : $val);
                    $localized['en']['sections'][$i][$key] = is_array($val)
                        ? array_map(fn($x) => is_string($x) ? $translate->setSource('sr')->setTarget('en')->translate($lm->cyrillic_to_latin($x)) : $x, $val)
                        : (is_string($val) ? $translate->setSource('sr')->setTarget('en')->translate($lm->cyrillic_to_latin($val)) : $val);
                }
            }
        } else { // en
            $localized['en'] = $data;
            $localized['sr']['hero_title']    = $translate->setSource('en')->setTarget('sr')->translate($data['hero_title']);
            $localized['sr']['hero_subtitle'] = $translate->setSource('en')->setTarget('sr')->translate($data['hero_subtitle']);
            $localized['sr-Cyrl']['hero_title']    = $lm->latin_to_cyrillic($localized['sr']['hero_title']);
            $localized['sr-Cyrl']['hero_subtitle'] = $lm->latin_to_cyrillic($localized['sr']['hero_subtitle']);
            foreach ($data['sections'] as $i => $s) {
                $localized['en']['sections'][$i]['title'] = $s['title'];
                $localized['sr']['sections'][$i]['title'] = $i <= 1 ? $this->getSectionTitleFromJson('sr', $i) : $translate->setSource('en')->setTarget('sr')->translate($s['title']);
                $localized['sr-Cyrl']['sections'][$i]['title'] = $i <= 1 ? $this->getSectionTitleFromJson('sr-Cyrl', $i) : $lm->latin_to_cyrillic($localized['sr']['sections'][$i]['title']);
                foreach ($s as $key => $val) {
                    if ($key == 'title') continue;
                    $localized['en']['sections'][$i][$key] = $val;
                    $localized['sr']['sections'][$i][$key] = is_array($val)
                        ? array_map(fn($x) => is_string($x) ? $translate->setSource('en')->setTarget('sr')->translate($x) : $x, $val)
                        : (is_string($val) ? $translate->setSource('en')->setTarget('sr')->translate($val) : $val);
                    $localized['sr-Cyrl']['sections'][$i][$key] = is_array($val)
                        ? array_map(fn($x) => is_string($x) ? $lm->latin_to_cyrillic($translate->setSource('en')->setTarget('sr')->translate($x)) : $x, $val)
                        : (is_string($val) ? $lm->latin_to_cyrillic($translate->setSource('en')->setTarget('sr')->translate($val)) : $val);
                }
            }
        }

        foreach ($files as $lang => $file) {
            $json = json_decode(\File::get($file), true);
            $json['services']['hero_title'] = $localized[$lang]['hero_title'];
            $json['services']['hero_subtitle'] = $localized[$lang]['hero_subtitle'];
            foreach ($localized[$lang]['sections'] as $i => $s) {
                foreach ($s as $k => $v) {
                    $json['services']['sections'][$i][$k] = $v;
                }
            }
            \File::put($file, json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        }

        return back()->with('success', 'Usluge su ažurirane na svim jezicima!');
    }

    private function getSectionTitleFromJson($lang, $index)
    {
        $path = resource_path("lang/{$lang}.json");
        $json = json_decode(\File::get($path), true);
        return $json['services']['sections'][$index]['title'] ?? '';
    }

}
