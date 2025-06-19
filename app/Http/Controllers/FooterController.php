<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;

class FooterController extends Controller
{
    public function show()
    {
        $libraryData = LibraryDataController::getLibraryData();

        return view('superAdmin.footer', [
            'libraryData' => $libraryData
        ]);
    }

    public function edit(Request $request)
    {
        $this->validateRequest($request);

        $libraryData = $this->buildLibraryData($request);

        $this->handleLogoUpload($request, 'logo_light', 'nbnp-logo.png');
        $this->handleLogoUpload($request, 'logo_dark', 'nbnp-logo-dark.png');

        $this->saveToLangFiles($libraryData);

        return redirect()->back()->with('success', 'Podnožje uspešno ažurirano.');
    }

    private function validateRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
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
        ]);

        if ($validator->fails()) {
            redirect()->back()->withErrors($validator)->withInput()->send();
            exit; 
        }
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
                Log::error("Neuspešno brisanje starog fajla $fileName: " . $e->getMessage());
            }
        }

        try {
            $request->file($inputName)->move(public_path('images'), $fileName);
        } catch (\Exception $e) {
            Log::error("Neuspešno učitavanje loga $fileName: " . $e->getMessage());
            redirect()->back()->with('error', "Greška pri učitavanju loga $fileName.")->send();
            exit;
        }
    }

    private function saveToLangFiles(array $libraryData)
    {
        $srPath = resource_path('lang/sr.json');
        $enPath = resource_path('lang/en.json');

        $this->ensureLangDirExists();

        $this->saveLangFile($srPath, $libraryData);
        $this->saveLangFile($enPath, $libraryData);
    }

    private function ensureLangDirExists()
    {
        $langDir = resource_path('lang');
        if (!file_exists($langDir)) {
            mkdir($langDir, 0755, true);
        }
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
            redirect()->back()->with('error', 'Greška pri čuvanju podataka.')->send();
            exit;
        }
    }
}