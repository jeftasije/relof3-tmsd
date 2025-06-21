<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Stichoza\GoogleTranslate\GoogleTranslate;
use App\Http\Controllers\LanguageMapperController;

class FooterController extends Controller
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

        $srContent = file_exists($srPath) ? file_get_contents($srPath) : null;
        $libraryDataSr = $srContent !== null && $srContent !== '' ? json_decode($srContent, true)['library'] ?? [] : [];

        $enContent = file_exists($enPath) ? file_get_contents($enPath) : null;
        $libraryDataEn = $enContent !== null && $enContent !== '' ? json_decode($enContent, true)['library'] ?? [] : [];
 
        return view('superAdmin.footer', [
            'libraryDataSr' => $libraryDataSr,
            'libraryDataEn' => $libraryDataEn
        ]);
    }

    public function editSr(Request $request)
    {
        $this->validateRequest($request);

        $libraryData = $this->buildLibraryData($request);

        $this->handleLogoUpload($request, 'logo_light', 'nbnp-logo.png');
        $this->handleLogoUpload($request, 'logo_dark', 'nbnp-logo-dark.png');

        $this->saveLangFile(resource_path('lang/sr.json'), $libraryData);

        $translatedData = $this->translateLibraryData($libraryData);
        $this->saveLangFile(resource_path('lang/en.json'), $translatedData);

        $cyrillicData = $this->convertToCyrillic($libraryData);
        $this->saveLangFile(resource_path('lang/sr-Cyrl.json'), $cyrillicData);

        return redirect()->back()->with('success', 'Footer edited successfully.');
    }

    private function convertToCyrillic(array $libraryData): array
    {
        $translatableFields = [
            'name',
            'address',
            'address_label',
            'pib_label',
            'phone_label',
            'work_hours_label',
            'copyrights',
        ];

        $cyrillicData = $libraryData;

        foreach ($translatableFields as $field) {
            if (isset($libraryData[$field]) && !empty($libraryData[$field])) {
                $cyrillicData[$field] = $this->languageMapper->latin_to_cyrillic($libraryData[$field]);
            }
        }

        if (isset($libraryData['work_hours_formatted']) && is_array($libraryData['work_hours_formatted'])) {
            $cyrillicData['work_hours_formatted'] = array_map(function ($line) {
                return $this->languageMapper->latin_to_cyrillic($line);
            }, $libraryData['work_hours_formatted']);
        }

        return $cyrillicData;
    }

    public function editEn(Request $request)
    {
        $this->validateRequestEn($request);
        $libraryDataEn = $this->buildLibraryDataEn($request);
        $this->saveLangFile(resource_path('lang/en.json'), $libraryDataEn);

        return redirect()->back()->with('success', 'Footer edited succesfully.');
    }

    private function validateRequest(Request $request)
    {
        $messages = [
            'name.required' => __('validation.name_required'),
            'name.string' => __('validation.name_string'),
            'name.max' => __('validation.name_max'),
            'address.required' => __('validation.address_required'),
            'address.string' => __('validation.address_string'),
            'address.max' => __('validation.address_max'),
            'pib.required' => __('validation.pib_required'),
            'pib.regex' => __('validation.pib_regex'),
            'phone.required' => __('validation.phone_required'),
            'phone.regex' => __('validation.phone_regex'),
            'phone.max' => __('validation.phone_max'),
            'email.required' => __('validation.email_required'),
            'email.email' => __('validation.email_email'),
            'email.max' => __('validation.email_max'),
            'facebook.url' => __('validation.facebook_url'),
            'facebook.max' => __('validation.facebook_max'),
            'twitter.url' => __('validation.twitter_url'),
            'twitter.max' => __('validation.twitter_max'),
            'work_hours.required' => __('validation.work_hours_required'),
            'work_hours.string' => __('validation.work_hours_string'),
            'map_embed.url' => __('validation.map_embed_url'),
            'map_embed.max' => __('validation.map_embed_max'),
            'copyrights.required' => __('validation.copyrights_required'),
            'copyrights.string' => __('validation.copyrights_string'),
            'copyrights.max' => __('validation.copyrights_max'),
            'logo_light.image' => __('validation.logo_light_image'),
            'logo_light.max' => __('validation.logo_light_max'),
            'logo_dark.image' => __('validation.logo_dark_image'),
            'logo_dark.max' => __('validation.logo_dark_max'),
        ];

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'pib' => ['required', 'regex:/^\d{8,9}$/'],
            'phone' => ['required', 'regex:/^\+?[0-9\s\-\(\)]+$/', 'max:50'],
            'email' => 'required|email|max:255',
            'facebook' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'work_hours' => 'required|string',
            'map_embed' => 'nullable|url|max:255',
            'copyrights' => 'required|string|max:255',
            'logo_light' => 'nullable|image|max:2048',
            'logo_dark' => 'nullable|image|max:2048',
        ], $messages);
    }

    private function validateRequestEn(Request $request)
    {
        $messages = [
            'name_en.string' => __('validation.name_string'),
            'name_en.max' => __('validation.name_max'),
            'address_en.string' => __('validation.address_string'),
            'address_en.max' => __('validation.address_max'),
            'work_hours_en.string' => __('validation.work_hours_string'),
            'copyrights_en.string' => __('validation.copyrights_string'),
            'copyrights_en.max' => __('validation.copyrights_max'),
            'pib.string' => __('validation.pib_string'),
            'phone.string' => __('validation.phone_string'),
            'phone.max' => __('validation.phone_max'),
            'email.email' => __('validation.email_email'),
            'email.max' => __('validation.email_max'),
            'facebook.url' => __('validation.facebook_url'),
            'facebook.max' => __('validation.facebook_max'),
            'twitter.url' => __('validation.twitter_url'),
            'twitter.max' => __('validation.twitter_max'),
            'map_embed.url' => __('validation.map_embed_url'),
            'map_embed.max' => __('validation.map_embed_max'),
            'logo_light.image' => __('validation.logo_light_image'),
            'logo_light.max' => __('validation.logo_light_max'),
            'logo_dark.image' => __('validation.logo_dark_image'),
            'logo_dark.max' => __('validation.logo_dark_max'),
        ];

        $request->validate([
            'name_en' => 'nullable|string|max:255',
            'address_en' => 'nullable|string|max:255',
            'work_hours_en' => 'nullable|string',
            'copyrights_en' => 'nullable|string|max:255',
            'pib' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'facebook' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'map_embed' => 'nullable|url|max:255',
            'logo_light' => 'nullable|image|max:2048',
            'logo_dark' => 'nullable|image|max:2048',
        ], $messages);
    }

    private function buildLibraryData(Request $request)
    {
        $work_hours_formatted = array_filter(array_map('trim', explode("\n", $request->input('work_hours'))));

        return [
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'address_label' => $request->input('address_label', 'Adresa'),
            'pib' => $request->input('pib'),
            'pib_label' => $request->input('pib_label', 'PIB'),
            'phone' => $request->input('phone'),
            'phone_label' => $request->input('phone_label', 'Kontakt'),
            'email' => $request->input('email'),
            'facebook' => $request->input('facebook'),
            'twitter' => $request->input('twitter'),
            'work_hours_formatted' => $work_hours_formatted,
            'work_hours_label' => $request->input('work_hours_label', 'Radno Vreme'),
            'map_embed' => $request->input('map_embed'),
            'copyrights' => $request->input('copyrights'),
            'logo_light' => 'images/nbnp-logo.png',
            'logo_dark' => 'images/nbnp-logo-dark.png',
        ];
    }

    private function buildLibraryDataEn(Request $request)
    {
        $work_hours_formatted = array_filter(array_map('trim', explode("\n", $request->input('work_hours_en'))));

        $srPath = resource_path('lang/sr.json');
        $srData = file_exists($srPath)
            ? json_decode(file_get_contents($srPath), true)['library'] ?? []
            : [];

        return [
            'name' => $request->input('name_en', $srData['name'] ?? ''),
            'address' => $request->input('address_en', $srData['address'] ?? ''),
            'address_label' => $request->input('address_label_en', 'Address'),
            'pib' => $request->input('pib', $srData['pib'] ?? ''),
            'pib_label' => $request->input('pib_label_en', 'Tax ID (PIB)'),
            'phone' => $request->input('phone', $srData['phone'] ?? ''),
            'phone_label' => $request->input('phone_label_en', 'Contact'),
            'email' => $request->input('email', $srData['email'] ?? ''),
            'facebook' => $request->input('facebook', $srData['facebook'] ?? ''),
            'twitter' => $request->input('twitter', $srData['twitter'] ?? ''),
            'work_hours_formatted' => $work_hours_formatted,
            'work_hours_label' => $request->input('work_hours_label_en', 'Working Hours'),
            'map_embed' => $request->input('map_embed', $srData['map_embed'] ?? ''),
            'copyrights' => $request->input('copyrights_en', $srData['copyrights'] ?? ''),
            'logo_light' => $srData['logo_light'] ?? 'images/nbnp-logo.png',
            'logo_dark' => $srData['logo_dark'] ?? 'images/nbnp-logo-dark.png',
        ];
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
            redirect()->back()->with('error', "Err while loading logo $fileName.")->send();
            exit;
        }
    }

    private function translateLibraryData(array $libraryData): array
    {
        $translatableFields = [
            'name',
            'address',
            'address_label',
            'pib_label',
            'phone_label',
            'work_hours_label',
            'copyrights',
        ];

        $translatedData = $libraryData;

        foreach ($translatableFields as $field) {
            if (isset($libraryData[$field]) && !empty($libraryData[$field])) {
                try {
                    $translatedData[$field] = $this->translate->translate($libraryData[$field]);
                } catch (\Exception $e) {
                    Log::error("err in translating $field: " . $e->getMessage());
                    $translatedData[$field] = $libraryData[$field];
                }
            }
        }

        if (isset($libraryData['work_hours_formatted']) && is_array($libraryData['work_hours_formatted'])) {
            $translatedData['work_hours_formatted'] = [];
            foreach ($libraryData['work_hours_formatted'] as $line) {
                if (!empty($line)) {
                    try {
                        $translatedData['work_hours_formatted'][] = $this->translate->translate($line);
                    } catch (\Exception $e) {
                        Log::error("err in translating workinng time: " . $e->getMessage());
                        $translatedData['work_hours_formatted'][] = $line;
                    }
                }
            }
        }

        return $translatedData;
    }

    private function saveLangFile(string $filePath, array $libraryData)
    {
        $existingData = file_exists($filePath)
            ? json_decode(file_get_contents($filePath), true) ?? []
            : [];

        $existingData['library'] = $libraryData;

        try {
            file_put_contents(
                $filePath,
                json_encode($existingData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
            );
        } catch (\Exception $e) {
            Log::error("Greška pri čuvanju fajla $filePath: " . $e->getMessage());
            redirect()->back()->with('error', 'err in loading data.')->send();
            exit;
        }
    }       
}