<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stichoza\GoogleTranslate\GoogleTranslate;
use App\Http\Controllers\LanguageMapperController;
use Illuminate\Support\Facades\File;

class HeaderController extends Controller
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

        $srLCyrContent = file_exists($srCyrPath) ? file_get_contents($srCyrPath) : null;
        $srCyrJson = $srLCyrContent !== null && $srLCyrContent !== '' ? json_decode($srLCyrContent, true) : [];

        $enContent = file_exists($enPath) ? file_get_contents($enPath) : null;
        $enJson = $enContent !== null && $enContent !== '' ? json_decode($enContent, true) : [];

        $srLatContent = file_exists($srPath) ? file_get_contents($srPath) : null;
        $srLatJson = $srLatContent !== null && $srLatContent !== '' ? json_decode($srLatContent, true) : [];

        $title_en = $enJson['header_title'] ?? '';
        $subtitle_en = $enJson['header_subtitle'] ?? '';

        $title_sr_lat = $srLatJson['header_title'] ?? '';
        $subtitle_sr_lat = $srLatJson['header_subtitle'] ?? '';

        $title_sr_cyr = $srCyrJson['header_title'] ?? '';
        $subtitle_sr_cyr = $srCyrJson['header_subtitle'] ?? '';

        return view('superAdmin.header', compact('title_en', 'subtitle_en', 'title_sr_lat', 'subtitle_sr_lat',
         'title_sr_cyr', 'subtitle_sr_cyr'));
    }

    public function updateSr(Request $request)
    {
        $validated = $this->validateRequest($request);

        $this->handleLogoUpload($request, 'logo_light', 'nbnp-logo-dark.png');
        $this->handleLogoUpload($request, 'logo_dark', 'nbnp-logo.png');

        $srPath = resource_path('lang/sr.json');
        $srCyrPath = resource_path('lang/sr-Cyrl.json');
        $enPath = resource_path('lang/en.json');

        $srLatJson = $this->readJson($srPath);
        $srCyrJson = $this->readJson($srCyrPath);
        $enJson = $this->readJson($enPath);

        $originalTitle = $request->input('title_sr');               
        $originalSubtitle = $request->input('subtitle_sr');

        $detectedScriptTitle = $this->languageMapper->detectScript($originalTitle);
        $detectedScriptSubtitle = $this->languageMapper->detectScript($originalSubtitle); 

        if ($detectedScriptTitle === 'cyrillic' || $detectedScriptSubtitle === 'cyrillic') {                                //cyrillic input
            $titleCyr = $originalTitle;
            $titleLat = $this->languageMapper->cyrillic_to_latin($originalTitle);
            $titleEn = $this->translate->setSource('sr')->setTarget('en')->translate($originalTitle);

            $subtitleCyr = $originalSubtitle;
            $subtitleLat = $this->languageMapper->cyrillic_to_latin($originalSubtitle);
            $subtitleEn = $this->translate->setSource('sr')->setTarget('en')->translate($originalSubtitle);

        } else {                                                                                                            //latin input     
            $titleLat = $originalTitle;
            $titleCyr = $this->languageMapper->latin_to_cyrillic($originalTitle);
            $titleEn = $this->translate->setSource('sr')->setTarget('en')->translate($originalTitle);

            $subtitleLat = $originalSubtitle;
            $subtitleCyr = $this->languageMapper->latin_to_cyrillic($originalSubtitle);
            $subtitleEn = $this->translate->setSource('sr')->setTarget('en')->translate($originalSubtitle);
        }

        $enJson['header_title'] = $titleEn;
        $srCyrJson['header_title'] = $titleCyr;
        $srLatJson['header_title'] = $titleLat;

        $enJson['header_subtitle'] = $subtitleEn;
        $srCyrJson['header_subtitle'] = $subtitleCyr;
        $srLatJson['header_subtitle'] = $subtitleLat;

        file_put_contents($enPath, json_encode($enJson, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        file_put_contents($srPath, json_encode($srLatJson, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        file_put_contents($srCyrPath, json_encode($srCyrJson, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        return response()->json(['success' => true]);
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

        $enJson['header_title'] = $title_en;
        $enJson['header_subtitle'] = $subtitle_en;

        file_put_contents($enPath, json_encode($enJson, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        return response()->json(['success' => true]);
    }

    private function validateRequest(Request $request)
    {
        return $request->validate([
            'title_sr' => 'nullable|string',
            'subtitle_sr' => 'nullable|string',
            'logo_light' => 'nullable|image|max:2048',
            'logo_dark' => 'nullable|image|max:2048'
        ]);
    }

    private function handleLogoUpload(Request $request, $inputName, $fileName)
    {
        if (!$request->hasFile($inputName)) {
            return;
        }

        $filePath = public_path("images/{$fileName}");

        if (file_exists($filePath)) {
            try {
                unlink($filePath);
            } catch (\Exception $e) {
                Log::error("Err while deleting file $fileName: " . $e->getMessage());
            }
        }

        try {
            $request->file($inputName)->move(public_path('images'), $fileName);
        } catch (\Exception $e) {
            Log::error("Neuspešno učitavanje loga $fileName: " . $e->getMessage());
            throw new \Exception("Error while uploading logo $fileName.");
        }
    }

    
    private function readJson($path)
    {
        return File::exists($path) ? json_decode(file_get_contents($path), true) : [];
    }
}
