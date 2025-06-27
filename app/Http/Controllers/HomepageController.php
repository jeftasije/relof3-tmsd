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

        $srLCyrContent = file_exists($srCyrPath) ? file_get_contents($srCyrPath) : null;
        $srCyrJson = $srLCyrContent !== null && $srLCyrContent !== '' ? json_decode($srLCyrContent, true) : [];

        $enContent = file_exists($enPath) ? file_get_contents($enPath) : null;
        $enJson = $enContent !== null && $enContent !== '' ? json_decode($enContent, true) : [];

        $srLatContent = file_exists($srPath) ? file_get_contents($srPath) : null;
        $srLatJson = $srLatContent !== null && $srLatContent !== '' ? json_decode($srLatContent, true) : [];

        
        $title_en = $enJson['homepage_title'] ?? '';
        $subtitle_en = $enJson['homepage_subtitle'] ?? '';

        $title_sr_lat = $srLatJson['homepage_title'] ?? '';
        $subtitle_sr_lat = $srLatJson['homepage_subtitle'] ?? '';

        $title_sr_cyr = $srCyrJson['homepage_title'] ?? '';
        $subtitle_sr_cyr = $srCyrJson['homepage_subtitle'] ?? '';

        $news_title_en = $enJson['homepage_news_title'] ?? '';
        $news_title_sr_lat = $srLatJson['homepage_news_title'] ?? '';
        $news_title_sr_cyr = $srCyrJson['homepage_news_title'] ?? '';

        $contact_title_en = $enJson['homepage_contact_title'] ?? '';
        $contact_subtitle_en = $enJson['homepage_contact_subtitle'] ?? '';

        $contact_title_sr_lat = $srLatJson['homepage_contact_title'] ?? '';
        $contact_subtitle_sr_lat = $srLatJson['homepage_contact_subtitle'] ?? '';

        $contact_title_sr_cyr = $srCyrJson['homepage_contact_title'] ?? '';
        $contact_subtitle_sr_cyr = $srCyrJson['homepage_contact_subtitle'] ?? '';

        $cobiss_title_en = $enJson['cobiss_title'] ?? '';
        $cobiss_subtitle_en = $enJson['cobiss_subtitle'] ?? '';

        $cobiss_title_sr_lat = $srLatJson['cobiss_title'] ?? '';
        $cobiss_subtitle_sr_lat = $srLatJson['cobiss_subtitle'] ?? '';

        $cobiss_title_sr_cyr = $srCyrJson['cobiss_title'] ?? '';
        $cobiss_subtitle_sr_cyr = $srCyrJson['cobiss_subtitle'] ?? '';

        //dd($cobiss_title_en, $cobiss_subtitle_en);

        return view('superAdmin.homePage', compact('title_en', 'subtitle_en', 'title_sr_lat', 
        'subtitle_sr_lat', 'title_sr_cyr', 'subtitle_sr_cyr', 'news_title_en', 'news_title_sr_lat', 
        'news_title_sr_cyr', 'contact_title_en', 'contact_subtitle_en', 'contact_title_sr_lat',
        'contact_subtitle_sr_lat', 'contact_title_sr_cyr', 'contact_subtitle_sr_cyr',
        'cobiss_title_en', 'cobiss_subtitle_en', 'cobiss_title_sr_lat', 'cobiss_subtitle_sr_lat', 
        'cobiss_title_sr_cyr', 'cobiss_subtitle_sr_cyr'));
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

        file_put_contents($enPath, json_encode($enJson, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        return redirect()->back()->with('success', 'Hero sekcija je uspešno ažurirana!');
    }

    public function updateNewsSr(Request $request)
    {
        $request->validate([
            'news_title_sr' => 'nullable|string'
        ]);

        $srPath = resource_path('lang/sr.json');
        $srCyrPath = resource_path('lang/sr-Cyrl.json');
        $enPath = resource_path('lang/en.json');

        $srLatJson = $this->readJson($srPath);
        $srCyrJson = $this->readJson($srCyrPath);
        $enJson = $this->readJson($enPath);

        $newsTitleCyr = '';
        $newsTitleLat = '';
        $newsTitleEn = '';
        $originalTitle = $request->input('news_title_sr');

        $detectedScript = $this->languageMapper->detectScript($originalTitle);              //greska, ispravi
        if ($detectedScript === 'cyrillic') {
            $newsTitleCyr = $originalTitle;
            $newsTitleLat = $this->languageMapper->cyrillic_to_latin($originalTitle);
            $newsTitleEn = $this->translate->setSource('sr')->setTarget('en')->translate($originalTitle);
        } else {
            $toSr = $this->translate->setSource('en')->setTarget('sr')->translate($originalTitle);
            $toSrLatin = $this->languageMapper->cyrillic_to_latin($toSr);

            if (mb_strtolower($toSrLatin) === mb_strtolower($originalTitle)) {
                $newsTitleLat = $originalTitle;
                $newsTitleCyr = $this->languageMapper->latin_to_cyrillic($originalTitle);
                $newsTitleEn = $this->translate->setSource('sr')->setTarget('en')->translate($originalTitle);
            } else {
                $newsTitleEn = $originalTitle;
                $newsTitleCyr = $this->translate->setSource('en')->setTarget('sr')->translate($originalTitle);
                $newsTitleLat = $this->languageMapper->cyrillic_to_latin($newsTitleCyr);
            }
        }

        $enJson['homepage_news_title'] = $newsTitleEn;
        $srCyrJson['homepage_news_title'] = $newsTitleCyr;
        $srLatJson['homepage_news_title'] = $newsTitleLat;

        file_put_contents($enPath, json_encode($enJson, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        file_put_contents($srPath, json_encode($srLatJson, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        file_put_contents($srCyrPath, json_encode($srCyrJson, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        return redirect()->back()->with('success', 'Hero sekcija je uspešno ažurirana!');
    }

    public function updateContactSr(Request $request)
    {
        $request->validate([
            'contact_title_sr' => 'nullable|string',
            'contact_subtitle_sr' => 'nullable|string'
        ]);

        $srPath = resource_path('lang/sr.json');
        $srCyrPath = resource_path('lang/sr-Cyrl.json');
        $enPath = resource_path('lang/en.json');

        $srLatJson = $this->readJson($srPath);
        $srCyrJson = $this->readJson($srCyrPath);
        $enJson = $this->readJson($enPath);

        //ovdje sam stala

        $originalTitle = $request->input('contact_title_sr');               //moram da provjerim za oba da l su na cirilici, mozda mijenja samo jedan
        $originalSubtitle = $request->input('contact_subtitle_sr');

        //dd($originalTitle, $originalSubtitle);

        $detectedScriptTitle = $this->languageMapper->detectScript($originalTitle);
        $detectedScriptSubtitle = $this->languageMapper->detectScript($originalSubtitle); //ovdje sam stala

        if ($detectedScriptTitle === 'cyrillic' || $detectedScriptSubtitle === 'cyrillic') {
            $contactTitleCyr = $originalTitle;
            $contactTitleLat = $this->languageMapper->cyrillic_to_latin($originalTitle);
            $contactTitleEn = $this->translate->setSource('sr')->setTarget('en')->translate($originalTitle);

            $contactSubtitleCyr = $originalSubtitle;
            $contactSubtitleLat = $this->languageMapper->cyrillic_to_latin($originalSubtitle);
            $contactSubtitleEn = $this->translate->setSource('sr')->setTarget('en')->translate($originalSubtitle);

        } else {
            $toSr = $this->translate->setSource('en')->setTarget('sr')->translate($originalTitle);
            $toSrLatin = $this->languageMapper->cyrillic_to_latin($toSr);

            $toSrSubtitle = $this->translate->setSource('en')->setTarget('sr')->translate($originalSubtitle);
            $toSrLatinSubtitle = $this->languageMapper->cyrillic_to_latin($toSrSubtitle);

            if (mb_strtolower($toSrLatin) === mb_strtolower($originalTitle) || mb_strtolower($toSrSubtitle) === mb_strtolower($toSrLatinSubtitle)) {        //i ovo mora da se doda
                $contactTitleLat = $originalTitle;
                $contactTitleCyr = $this->languageMapper->latin_to_cyrillic($originalTitle);
                $contactTitleEn = $this->translate->setSource('sr')->setTarget('en')->translate($originalTitle);

                $contactSubtitleLat = $originalSubtitle;
                $contactSubtitleCyr = $this->languageMapper->latin_to_cyrillic($originalSubtitle);
                $contactSubtitleEn = $this->translate->setSource('sr')->setTarget('en')->translate($originalSubtitle);

            } else {
                $contactTitleEn = $originalTitle;
                $contactTitleCyr = $this->translate->setSource('en')->setTarget('sr')->translate($originalTitle);
                $contactTitleLat = $this->languageMapper->cyrillic_to_latin($contactTitleCyr);

                $contactSubtitleEn = $originalSubtitle;
                $contactSubtitleCyr = $this->translate->setSource('en')->setTarget('sr')->translate($originalSubtitle);
                $contactSubtitleLat = $this->languageMapper->cyrillic_to_latin($contactSubtitleCyr);
            }
        }

        $enJson['homepage_contact_title'] = $contactTitleEn;
        $srCyrJson['homepage_contact_title'] = $contactTitleCyr;
        $srLatJson['homepage_contact_title'] = $contactTitleLat;

        $enJson['homepage_contact_subtitle'] = $contactSubtitleEn;
        $srCyrJson['homepage_contact_subtitle'] = $contactSubtitleCyr;
        $srLatJson['homepage_contact_subtitle'] = $contactSubtitleLat;

        file_put_contents($enPath, json_encode($enJson, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        file_put_contents($srPath, json_encode($srLatJson, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        file_put_contents($srCyrPath, json_encode($srCyrJson, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        return redirect()->back()->with('success', 'Hero sekcija je uspešno ažurirana!');
    }

    public function updateContactEn(Request $request)
    {
        $request->validate([
            'contact_title_en' => 'nullable|string',
            'contact_subtitle_en' => 'nullable|string'
        ]);

        $enPath = resource_path('lang/en.json');
        $enJson = $this->readJson($enPath);

        $title_en = $request->input('contact_title_en');
        $subtitle_en = $request->input('contact_subtitle_en');

        //dd($title_en, $subtitle_en);

        $enJson['homepage_contact_title'] = $title_en;
        $enJson['homepage_contact_subtitle'] = $subtitle_en;

        file_put_contents($enPath, json_encode($enJson, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        return redirect()->back()->with('success', 'Hero sekcija je uspešno ažurirana!');
    }

    public function updateNewsEn(Request $request)
    {
        $request->validate([
            'news_title_en' => 'nullable|string'
        ]);

        $enPath = resource_path('lang/en.json');
        $enJson = $this->readJson($enPath);

        $title_en = $request->input('news_title_en');

        $enJson['homepage_news_title'] = $title_en;

        file_put_contents($enPath, json_encode($enJson, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        return redirect()->back()->with('success', 'Hero sekcija je uspešno ažurirana!');
    }

    public function updateCobissSr(Request $request)
    { 
        $request->validate([
            'cobiss_title_sr' => 'nullable|string',
            'cobiss_subtitle_sr' => 'nullable|string'
        ]);

        $srPath = resource_path('lang/sr.json');
        $srCyrPath = resource_path('lang/sr-Cyrl.json');
        $enPath = resource_path('lang/en.json');

        $srLatJson = $this->readJson($srPath);
        $srCyrJson = $this->readJson($srCyrPath);
        $enJson = $this->readJson($enPath);

        $cobissSubileEn = '';

        $originalTitle = $request->input('cobiss_title_sr');               //moram da provjerim za oba da l su na cirilici, mozda mijenja samo jedan
        $originalSubtitle = $request->input('cobiss_subtitle_sr');

        //dd($originalTitle, $originalSubtitle);

        $detectedScriptTitle = $this->languageMapper->detectScript($originalTitle);
        $detectedScriptSubtitle = $this->languageMapper->detectScript($originalSubtitle); //ovdje sam stala

        if ($detectedScriptTitle === 'cyrillic' || $detectedScriptSubtitle === 'cyrillic') {
            $cobissTitleCyr = $originalTitle;
            $cobissTitleLat = $this->languageMapper->cyrillic_to_latin($originalTitle);
            $cobissTitleEn = $this->translate->setSource('sr')->setTarget('en')->translate($originalTitle);

            $cobissSubtitleCyr = $originalSubtitle;
            $cobissSubtitleLat = $this->languageMapper->cyrillic_to_latin($originalSubtitle);
            $cobissSubtitleEn = $this->translate->setSource('sr')->setTarget('en')->translate($originalSubtitle);

        } else {
            $toSr = $this->translate->setSource('en')->setTarget('sr')->translate($originalTitle);
            $toSrLatin = $this->languageMapper->cyrillic_to_latin($toSr);

            $toSrSubtitle = $this->translate->setSource('en')->setTarget('sr')->translate($originalSubtitle);
            $toSrLatinSubtitle = $this->languageMapper->cyrillic_to_latin($toSrSubtitle);

            if (mb_strtolower($toSrLatin) === mb_strtolower($originalTitle) || mb_strtolower($toSrSubtitle) === mb_strtolower($toSrLatinSubtitle)) {        //i ovo mora da se doda
                $cobissTitleLat = $originalTitle;
                $cobissTitleCyr = $this->languageMapper->latin_to_cyrillic($originalTitle);
                $cobissTitleEn = $this->translate->setSource('sr')->setTarget('en')->translate($originalTitle);

                $cobissSubtitleLat = $originalSubtitle;
                $cobissSubtitleCyr = $this->languageMapper->latin_to_cyrillic($originalSubtitle);
                $cobissSubtitleEn = $this->translate->setSource('sr')->setTarget('en')->translate($originalSubtitle);

            } else {
                $cobissTitleEn = $originalTitle;
                $cobissTitleCyr = $this->translate->setSource('en')->setTarget('sr')->translate($originalTitle);
                $cobissTitleLat = $this->languageMapper->cyrillic_to_latin($contactTitleCyr);

                $cobissSubtitleEn = $originalSubtitle;
                $cobissSubtitleCyr = $this->translate->setSource('en')->setTarget('sr')->translate($originalSubtitle);
                $cobissSubtitleLat = $this->languageMapper->cyrillic_to_latin($cobissSubtitleCyr);
            }
        }

        $enJson['cobiss_title'] = $cobissTitleEn;
        $srCyrJson['cobiss_title'] = $cobissTitleCyr;
        $srLatJson['cobiss_title'] = $cobissTitleLat;

        $enJson['cobiss_subtitle'] = $cobissSubtitleEn;
        $srCyrJson['cobiss_subtitle'] = $cobissSubtitleCyr;
        $srLatJson['cobiss_subtitle'] = $cobissSubtitleLat;

        file_put_contents($enPath, json_encode($enJson, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        file_put_contents($srPath, json_encode($srLatJson, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        file_put_contents($srCyrPath, json_encode($srCyrJson, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        return redirect()->back()->with('success', 'Hero sekcija je uspešno ažurirana!');
    }

    public function updateCobissEn(Request $request)
    {
        $request->validate([
            'cobiss_title_en' => 'nullable|string',
            'cobiss_subtitle_en' => 'nullable|string'
        ]);

        $enPath = resource_path('lang/en.json');

        $enJson = $this->readJson($enPath);

        $title_en = $request->input('cobiss_title_en');
        $subtitle_en = $request->input('cobiss_subtitle_en');

        $enJson['cobiss_title'] = $title_en;
        $enJson['cobiss_subtitle'] = $subtitle_en;

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
