<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stichoza\GoogleTranslate\GoogleTranslate;
use App\Http\Controllers\LanguageMapperController;
use Illuminate\Support\Facades\File;

class HomepageController extends Controller
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

    public function show()
    {
        $srPath = resource_path('lang/sr.json');
        $enPath = resource_path('lang/en.json');
        $srCyrPath = resource_path('lang/sr-Cyrl.json');

        $enContent = file_exists($enPath) ? file_get_contents($enPath) : null;
        $enJson = $enContent !== null && $enContent !== '' ? json_decode($enContent, true) : [];

        $srLatContent = file_exists($srPath) ? file_get_contents($srPath) : null;
        $srLatJson = $srLatContent !== null && $srLatContent !== '' ? json_decode($srLatContent, true) : [];

        $srLCyrContent = file_exists($srCyrPath) ? file_get_contents($enPath) : null;
        $srCyrJson = $srLCyrContent !== null && $srLCyrContent !== '' ? json_decode($srLCyrContent, true) : [];

        $title_en = $enJson['homepage_title'] ?? '';
        $subtitle_en = $enJson['homepage_subtitle'] ?? '';

        $title_sr_lat = $srLatJson['homepage_title'] ?? '';
        $subtitle_sr_lat = $srLatJson['homepage_subtitle'] ?? '';

        $title_sr_cyr = $srCyrJson['homepage_title'] ?? '';
        $subtitle_sr_cyr = $srCyrJson['homepage_subtitle'] ?? '';

        return view('superAdmin.homePage', compact('title_en', 'subtitle_en', 'title_sr_lat', 'subtitle_sr_lat', 'title_sr_cyr', 'subtitle_sr_cyr'));
    }

    public function updateSr(Request $request)
    {
        $validated = $this->validateRequest($request);

        $imagePath = $this->handleImageUpload($request->file('image'));

        $srPath = resource_path('lang/sr.json');
        $srCyrPath = resource_path('lang/sr-Cyrl.json');
        $enPath = resource_path('lang/en.json');

        $srLatJson = $this->readJson($srPath);
        $srCyrJson = $this->readJson($srCyrPath);
        $enJson = $this->readJson($enPath);

        if ($validated['title_sr']) {
            [$titleLat, $titleCyr, $titleEn, $subtitleLat, $subtitleCyr, $subtitleEn] =
                $this->generateLocalizedTexts($validated['title_sr'], $validated['subtitle_sr']);

            $this->updateJsonContent($srLatJson, $titleLat, $subtitleLat, $imagePath);
            $this->updateJsonContent($srCyrJson, $titleCyr, $subtitleCyr, $imagePath);
            $this->updateJsonContent($enJson, $titleEn, $subtitleEn, $imagePath);
        }

        $this->writeJson($srPath, $srLatJson);
        $this->writeJson($srCyrPath, $srCyrJson);
        $this->writeJson($enPath, $enJson);

        $title_en = $enJson['homepage_title'] ?? '';
        $subtitle_en = $enJson['homepage_subtitle'] ?? '';

        return redirect()->back()->with('success', 'Hero sekcija je uspešno ažurirana!');
    }

    public function updateEn(Request $request)
    {
        $request->validate([
            'title_en' => 'nullable|string',
            'subtitle_en' => 'nullable|string'
        ]);

        $enPath = resource_path('lang/en.json');

        $enJson = $this->readJson($enPath);

        $title_en = $request->input('title_en');
        $subtitle_en = $request->input('subtitle_en');

        $enJson['homepage_title'] = $title_en;
        $enJson['homepage_subtitle'] = $subtitle_en;

        //dd($title_en, $subtitle_en);

        file_put_contents($enPath, json_encode($enJson, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        return redirect()->back()->with('success', 'Hero sekcija je uspešno ažurirana!');
    }

    private function validateRequest(Request $request)
    {
        return $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'title_sr' => 'nullable|string',
            'subtitle_sr' => 'nullable|string',
        ]);
    }

    private function handleImageUpload($image)
    {
        if (!$image) return null;

        $imageName = 'herosection.' . $image->getClientOriginalExtension();
        $imagePath = 'images/' . $imageName;
        $image->move(public_path('images'), $imageName);

        return $imagePath;
    }

    private function readJson($path)
    {
        return File::exists($path) ? json_decode(file_get_contents($path), true) : [];
    }

    private function writeJson($path, $data)
    {
        file_put_contents($path, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }

    private function updateJsonContent(&$json, $title, $subtitle, $imagePath)
    {
        $json['homepage_title'] = $title;
        $json['homepage_subtitle'] = $subtitle;

        if ($imagePath) {
            $json['homepage_hero_image_path'] = $imagePath;
        }
    }

    private function generateLocalizedTexts($originalTitle, $originalSubtitle)
    {
        $detectedScript = $this->languageMapper->detectScript($originalTitle);

        if ($detectedScript === 'cyrillic') {
            $titleCyr = $originalTitle;
            $titleLat = $this->languageMapper->cyrillic_to_latin($titleCyr);
            $titleEn = $this->translate->setSource('sr')->setTarget('en')->translate($titleCyr);

            $subtitleCyr = $originalSubtitle;
            $subtitleLat = $this->languageMapper->cyrillic_to_latin($subtitleCyr);
            $subtitleEn = $this->translate->setSource('sr')->setTarget('en')->translate($subtitleCyr);
        } else {
            $toSr = $this->translate->setSource('en')->setTarget('sr')->translate($originalTitle);
            $toSrLatin = $this->languageMapper->cyrillic_to_latin($toSr);

            if (mb_strtolower($toSrLatin) === mb_strtolower($originalTitle)) {
                $titleLat = $originalTitle;
                $titleCyr = $this->languageMapper->latin_to_cyrillic($originalTitle);
                $titleEn = $this->translate->setSource('sr')->setTarget('en')->translate($originalTitle);

                $subtitleLat = $originalSubtitle;
                $subtitleCyr = $this->languageMapper->latin_to_cyrillic($originalSubtitle);
                $subtitleEn = $this->translate->setSource('sr')->setTarget('en')->translate($originalSubtitle);
            } else {
                $titleEn = $originalTitle;
                $titleCyr = $this->translate->setSource('en')->setTarget('sr')->translate($originalTitle);
                $titleLat = $this->languageMapper->cyrillic_to_latin($titleCyr);

                $subtitleEn = $originalSubtitle;
                $subtitleCyr = $this->translate->setSource('en')->setTarget('sr')->translate($originalSubtitle);
                $subtitleLat = $this->languageMapper->cyrillic_to_latin($subtitleCyr);
            }
        }

        return [$titleLat, $titleCyr, $titleEn, $subtitleLat, $subtitleCyr, $subtitleEn];
    }



}
