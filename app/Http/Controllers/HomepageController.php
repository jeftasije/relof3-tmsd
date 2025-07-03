<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stichoza\GoogleTranslate\GoogleTranslate;
use App\Http\Controllers\LanguageMapperController;
use Illuminate\Support\Facades\File;
use App\Models\News;
use App\Models\Employee;
use Illuminate\Support\Facades\Storage;

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

        $our_team_title_en = $enJson['our_team_title'] ?? '';
        $our_team_subtitle_en = $enJson['our_team_subtitle'] ?? '';

        $our_team_title_sr_lat = $srLatJson['our_team_title'] ?? '';
        $our_team_subtitle_sr_lat = $srLatJson['our_team_subtitle'] ?? '';

        $our_team_title_sr_cyr = $srCyrJson['our_team_title'] ?? '';
        $our_team_subtitle_sr_cyr = $srCyrJson['our_team_subtitle'] ?? '';
        
        $templateImages = [
            'template1' => 'images/ourTeam.png',
            'template2' => 'images/template2.png',
            'template3' => 'images/template3.png',
            'template4' => 'images/template4.png',
        ];

        $employees = Employee::all();
        $ourTeamVisible = $data['our_team_visible'] ?? true;
        $ourTeamIsSelected = $data['our_team_is_selected'] ?? true;
        $visibilityJson = json_decode(file_get_contents(storage_path('app/public/homepageVisibility.json')), true);
        $selectedEmployees = $visibilityJson['visible_employees'] ?? [];

        return view('superAdmin.homePage', compact('title_en', 'subtitle_en', 'title_sr_lat', 
        'subtitle_sr_lat', 'title_sr_cyr', 'subtitle_sr_cyr', 'news_title_en', 'news_title_sr_lat', 
        'news_title_sr_cyr', 'contact_title_en', 'contact_subtitle_en', 'contact_title_sr_lat',
        'contact_subtitle_sr_lat', 'contact_title_sr_cyr', 'contact_subtitle_sr_cyr',
        'cobiss_title_en', 'cobiss_subtitle_en', 'cobiss_title_sr_lat', 'cobiss_subtitle_sr_lat', 
        'cobiss_title_sr_cyr', 'cobiss_subtitle_sr_cyr', 'templateImages', 'employees',
        'our_team_title_en', 'our_team_subtitle_en', 'our_team_title_sr_lat', 'our_team_subtitle_sr_lat',
         'our_team_title_sr_cyr', 'our_team_subtitle_sr_cyr', 'ourTeamVisible', 'ourTeamIsSelected',
        'selectedEmployees'));
    }

    public function showWelcome()
    {
        $jsonPath = storage_path('app/public/homepageVisibility.json');
        $data = file_exists($jsonPath) ? json_decode(file_get_contents($jsonPath), true) : [];

        $visibilityPath = storage_path('app/public/homepageVisibility.json');
        $visibilityJson = file_exists($visibilityPath) ? json_decode(file_get_contents($visibilityPath), true) : [];

        $heroImage = $visibilityJson['hero_image'];

        $order = $data['component_order'] ?? [];
        $newsVisible = $data['news_visible'] ?? true;
        $contactVisible = $data['contact_visible'] ?? true;
        $cobissVisible = $data['cobiss_visible'] ?? true;
        $ourTeamVisible = $data['our_team_visible'] ?? true;
        $visibleEmployeeIds = $data['visible_employees'] ?? [];

        $news = News::latest()->take(5)->get();
        $visibleEmployees = Employee::whereIn('id', $visibleEmployeeIds)->get();

        return view('welcome', compact('order', 'news', 'newsVisible', 'contactVisible', 'cobissVisible',
        'ourTeamVisible', 'visibleEmployees', 'heroImage'));
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

            // Ažuriraj tekstove bez slike
            $this->updateJsonContent($srLatJson, $titleLat, $subtitleLat);
            $this->updateJsonContent($srCyrJson, $titleCyr, $subtitleCyr);
            $this->updateJsonContent($enJson, $titleEn, $subtitleEn);
        }

        $this->writeJson($srPath, $srLatJson);
        $this->writeJson($srCyrPath, $srCyrJson);
        $this->writeJson($enPath, $enJson);

        // NOVO: upis putanje slike u posebni fajl
        if ($imagePath) {
            $visibilityPath = storage_path('app/public/homepageVisibility.json');
            $visibilityJson = file_exists($visibilityPath) ? json_decode(file_get_contents($visibilityPath), true) : [];

            $visibilityJson['hero_image'] = $imagePath;

            file_put_contents($visibilityPath, json_encode($visibilityJson, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        }

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

        $enJson['homepage_title'] = $title_en;
        $enJson['homepage_subtitle'] = $subtitle_en;

        file_put_contents($enPath, json_encode($enJson, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        return response()->json(['success' => true]);
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

        $detectedScript = $this->languageMapper->detectScript($originalTitle);              
        if ($detectedScript === 'cyrillic') {
            $newsTitleCyr = $originalTitle;
            $newsTitleLat = $this->languageMapper->cyrillic_to_latin($originalTitle);
            $newsTitleEn = $this->translate->setSource('sr')->setTarget('en')->translate($originalTitle);
        } else {
            $newsTitleLat = $originalTitle;
            $newsTitleCyr = $this->languageMapper->latin_to_cyrillic($originalTitle);
            $newsTitleEn = $this->translate->setSource('sr')->setTarget('en')->translate($originalTitle);
        }

        $enJson['homepage_news_title'] = $newsTitleEn;
        $srCyrJson['homepage_news_title'] = $newsTitleCyr;
        $srLatJson['homepage_news_title'] = $newsTitleLat;

        file_put_contents($enPath, json_encode($enJson, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        file_put_contents($srPath, json_encode($srLatJson, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        file_put_contents($srCyrPath, json_encode($srCyrJson, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        return response()->json(['success' => true]);
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

        $originalTitle = $request->input('contact_title_sr');               
        $originalSubtitle = $request->input('contact_subtitle_sr');

        $detectedScriptTitle = $this->languageMapper->detectScript($originalTitle);
        $detectedScriptSubtitle = $this->languageMapper->detectScript($originalSubtitle); 

        if ($detectedScriptTitle === 'cyrillic' || $detectedScriptSubtitle === 'cyrillic') {
            $contactTitleCyr = $originalTitle;
            $contactTitleLat = $this->languageMapper->cyrillic_to_latin($originalTitle);
            $contactTitleEn = $this->translate->setSource('sr')->setTarget('en')->translate($originalTitle);

            $contactSubtitleCyr = $originalSubtitle;
            $contactSubtitleLat = $this->languageMapper->cyrillic_to_latin($originalSubtitle);
            $contactSubtitleEn = $this->translate->setSource('sr')->setTarget('en')->translate($originalSubtitle);

        } else {
            $contactTitleLat = $originalTitle;
            $contactTitleCyr = $this->languageMapper->latin_to_cyrillic($originalTitle);
            $contactTitleEn = $this->translate->setSource('sr')->setTarget('en')->translate($originalTitle);

            $contactSubtitleLat = $originalSubtitle;
            $contactSubtitleCyr = $this->languageMapper->latin_to_cyrillic($originalSubtitle);
            $contactSubtitleEn = $this->translate->setSource('sr')->setTarget('en')->translate($originalSubtitle);
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

        return response()->json(['success' => true]);
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

        $enJson['homepage_contact_title'] = $title_en;
        $enJson['homepage_contact_subtitle'] = $subtitle_en;

        file_put_contents($enPath, json_encode($enJson, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        return response()->json(['success' => true]);
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

        return response()->json(['success' => true]);
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

        $originalTitle = $request->input('cobiss_title_sr');               
        $originalSubtitle = $request->input('cobiss_subtitle_sr');

        $detectedScriptTitle = $this->languageMapper->detectScript($originalTitle);
        $detectedScriptSubtitle = $this->languageMapper->detectScript($originalSubtitle); 

        if ($detectedScriptTitle === 'cyrillic' || $detectedScriptSubtitle === 'cyrillic') {
            $cobissTitleCyr = $originalTitle;
            $cobissTitleLat = $this->languageMapper->cyrillic_to_latin($originalTitle);
            $cobissTitleEn = $this->translate->setSource('sr')->setTarget('en')->translate($originalTitle);

            $cobissSubtitleCyr = $originalSubtitle;
            $cobissSubtitleLat = $this->languageMapper->cyrillic_to_latin($originalSubtitle);
            $cobissSubtitleEn = $this->translate->setSource('sr')->setTarget('en')->translate($originalSubtitle);

        } else {      
            $cobissTitleLat = $originalTitle;
            $cobissTitleCyr = $this->languageMapper->latin_to_cyrillic($originalTitle);
            $cobissTitleEn = $this->translate->setSource('sr')->setTarget('en')->translate($originalTitle);

            $cobissSubtitleLat = $originalSubtitle;
            $cobissSubtitleCyr = $this->languageMapper->latin_to_cyrillic($originalSubtitle);
            $cobissSubtitleEn = $this->translate->setSource('sr')->setTarget('en')->translate($originalSubtitle);
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

        return response()->json(['success' => true]);
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

        return response()->json(['success' => true]);
    }

    public function updateOurTeamSr(Request $request)
    { 
        $request->validate([
            'our_team_title_sr' => 'nullable|string',
            'our_team_subtitle_sr' => 'nullable|string',
            'employees' => 'nullable|array',
            'employees.*' => 'integer|exists:employees,id'
        ]);

        $srPath = resource_path('lang/sr.json');
        $srCyrPath = resource_path('lang/sr-Cyrl.json');
        $enPath = resource_path('lang/en.json');
        $visibilityPath = storage_path('app/public/homepageVisibility.json');

        $srLatJson = $this->readJson($srPath);
        $srCyrJson = $this->readJson($srCyrPath);
        $enJson = $this->readJson($enPath);
        $visibilityJson = json_decode(file_get_contents($visibilityPath), true);

        $originalTitle = $request->input('our_team_title_sr');               
        $originalSubtitle = $request->input('our_team_subtitle_sr');

        $detectedScriptTitle = $this->languageMapper->detectScript($originalTitle);
        $detectedScriptSubtitle = $this->languageMapper->detectScript($originalSubtitle); 

        if ($detectedScriptTitle === 'cyrillic' || $detectedScriptSubtitle === 'cyrillic') {
            $ourTeamTitleCyr = $originalTitle;
            $ourTeamTitleLat = $this->languageMapper->cyrillic_to_latin($originalTitle);
            $ourTeamTitleEn = $this->translate->setSource('sr')->setTarget('en')->translate($originalTitle);

            $ourTeamSubtitleCyr = $originalSubtitle;
            $ourTeamSubtitleLat = $this->languageMapper->cyrillic_to_latin($originalSubtitle);
            $ourTeamSubtitleEn = $this->translate->setSource('sr')->setTarget('en')->translate($originalSubtitle);

        } else {       
            $ourTeamTitleLat = $originalTitle;
            $ourTeamTitleCyr = $this->languageMapper->latin_to_cyrillic($originalTitle);
            $ourTeamTitleEn = $this->translate->setSource('sr')->setTarget('en')->translate($originalTitle);

            $ourTeamSubtitleLat = $originalSubtitle;
            $ourTeamSubtitleCyr = $this->languageMapper->latin_to_cyrillic($originalSubtitle);
            $ourTeamSubtitleEn = $this->translate->setSource('sr')->setTarget('en')->translate($originalSubtitle);
        }

        $enJson['our_team_title'] = $ourTeamTitleEn;
        $srCyrJson['our_team_title'] = $ourTeamTitleCyr;
        $srLatJson['our_team_title'] = $ourTeamTitleLat;

        $enJson['our_team_subtitle'] = $ourTeamSubtitleEn;
        $srCyrJson['our_team_subtitle'] = $ourTeamSubtitleCyr;
        $srLatJson['our_team_subtitle'] = $ourTeamSubtitleLat;

        file_put_contents($enPath, json_encode($enJson, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        file_put_contents($srPath, json_encode($srLatJson, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        file_put_contents($srCyrPath, json_encode($srCyrJson, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        if ($request->has('employees')) {
            $visibilityJson['visible_employees'] = $request->input('employees');
        } else {
            $visibilityJson['visible_employees'] = []; 
        }

        file_put_contents($visibilityPath, json_encode($visibilityJson, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

            return response()->json(['success' => true]);
        }

        public function updateOurTeamEn(Request $request)
    {
        $request->validate([
            'our_team_title_en' => 'nullable|string',
            'our_team_subtitle_en' => 'nullable|string'
        ]);

        $enPath = resource_path('lang/en.json');

        $enJson = $this->readJson($enPath);

        $title_en = $request->input('our_team_title_en');
        $subtitle_en = $request->input('our_team_subtitle_en');

        $enJson['our_team_title'] = $title_en;
        $enJson['our_team_subtitle'] = $subtitle_en;

        file_put_contents($enPath, json_encode($enJson, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        return response()->json(['success' => true]);
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
        $imageDir = public_path('images');
        $imagePath = $imageDir . '/' . $imageName;

        foreach (glob($imageDir . '/herosection.*') as $existingFile) {
            try {
                unlink($existingFile);
            } catch (\Exception $e) {
                \Log::error("Could not delete old hero image {$existingFile}: " . $e->getMessage());
            }
        }

        $image->move($imageDir, $imageName);

        return 'images/' . $imageName;
    }


    private function readJson($path)
    {
        return File::exists($path) ? json_decode(file_get_contents($path), true) : [];
    }

    private function writeJson($path, $data)
    {
        file_put_contents($path, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }

    private function updateJsonContent(&$json, $title, $subtitle)
    {
        $json['homepage_title'] = $title;
        $json['homepage_subtitle'] = $subtitle;
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
            $titleLat = $originalTitle;
            $titleCyr = $this->languageMapper->latin_to_cyrillic($originalTitle);
            $titleEn = $this->translate->setSource('sr')->setTarget('en')->translate($originalTitle);

            $subtitleLat = $originalSubtitle;
            $subtitleCyr = $this->languageMapper->latin_to_cyrillic($originalSubtitle);
            $subtitleEn = $this->translate->setSource('sr')->setTarget('en')->translate($originalSubtitle);

        }

        return [$titleLat, $titleCyr, $titleEn, $subtitleLat, $subtitleCyr, $subtitleEn];
    }

    public function toggleNewsVisibility()
    {
        $path = storage_path('app/public/homepageVisibility.json');
        $data = file_exists($path) ? json_decode(file_get_contents($path), true) : [];
        $data['news_visible'] = !($data['news_visible'] ?? true); // toggle

        file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return response()->json(['success' => true]);
    }

    public function toggleContactVisibility()
    {
        $path = storage_path('app/public/homepageVisibility.json');
        $data = file_exists($path) ? json_decode(file_get_contents($path), true) : [];
        $data['contact_visible'] = !($data['contact_visible'] ?? true); 

        file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return response()->json(['success' => true]);
    }

    public function toggleCobissVisibility()
    {
        $path = storage_path('app/public/homepageVisibility.json');
        $data = file_exists($path) ? json_decode(file_get_contents($path), true) : [];
        $data['cobiss_visible'] = !($data['cobiss_visible'] ?? true); 

        file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return response()->json(['success' => true]);
    }

    public function toggleOurTeamVisibility()
    {
        $path = storage_path('app/public/homepageVisibility.json');
        $data = file_exists($path) ? json_decode(file_get_contents($path), true) : [];
        $data['our_team_visible'] = !($data['our_team_visible'] ?? true); 

        file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return response()->json(['success' => true]);
    }

    public function updateComponentOrder(Request $request)
    {
        $components = $request->input('components', []);
        
        if (empty($components) || $components[0] !== 'hero') {
            return back()->with('error', 'Hero section must be the first one in the order.');
        }

        $path = storage_path('app/public/homepageVisibility.json');
        $data = file_exists($path) ? json_decode(file_get_contents($path), true) : [];

        $data['component_order'] = $components;

        file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return back()->with('success', 'Order saved successfully.');
    }

    public function saveTeamVisibility(Request $request)
    {
        $request->validate([
            'employees' => 'required|array',
            'employees.*' => 'integer',
        ]);

        $jsonPath = storage_path('app/public/homepageVisibility.json');

        $data = file_exists($jsonPath) ? json_decode(file_get_contents($jsonPath), true) : [];

        $data['our_team_visible'] = true;
        $data['our_team_is_selected'] = true;
        $data['visible_employees'] = $request->input('employees');

        if (!isset($data['component_order'])) {
            $data['component_order'] = [];
        }

        if (!in_array('our_team', $data['component_order'])) {
            $data['component_order'][] = 'our_team';
        }

        file_put_contents($jsonPath, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        return redirect()->back()->with('success', 'Team visibility updated successfully!');
    }



}
