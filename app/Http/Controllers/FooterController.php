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
        // Fetch library data using LibraryDataController
        $libraryData = LibraryDataController::getLibraryData();

        return view('superAdmin.footer', [
            'libraryData' => $libraryData
        ]);
    }

    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'pib' => 'required|string|max:50',
            'phone' => 'required|string|max:50',
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
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $work_hours_formatted = array_filter(array_map('trim', explode("\n", $request->input('work_hours'))));

        $libraryData = [
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

        $oldLightPath = public_path('images/nbnp-logo.png');
        $oldDarkPath = public_path('images/nbnp-logo-dark.png');

    if ($request->hasFile('logo_light')) {
        if (file_exists($oldLightPath)) {
            try {
                unlink($oldLightPath);
            } catch (\Exception $e) {
                Log::error('Neuspešno brisanje starog svetlog loga: ' . $e->getMessage());
            }
        }

        try {
            $request->file('logo_light')->move(public_path('images'), 'nbnp-logo.png');
        } catch (\Exception $e) {
            Log::error('Neuspešno učitavanje svetlog loga: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Greška pri učitavanju svetlog loga.');
        }
    }

    // Tamni logo
    if ($request->hasFile('logo_dark')) {
        if (file_exists($oldDarkPath)) {
            try {
                unlink($oldDarkPath);
            } catch (\Exception $e) {
                Log::error('Neuspešno brisanje starog tamnog loga: ' . $e->getMessage());
            }
        }

        try {
            $request->file('logo_dark')->move(public_path('images'), 'nbnp-logo-dark.png');
        } catch (\Exception $e) {
            Log::error('Neuspešno učitavanje tamnog loga: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Greška pri učitavanju tamnog loga.');
        }
    }

        if ($request->hasFile('logo_light')) {
            try {
                $request->file('logo_light')->move(public_path('images'), 'nbnp-logo.png');
            } catch (\Exception $e) {
                Log::error('Neuspešno učitavanje svetlog loga: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Greška pri učitavanju svetlog loga.');
            }
        }

        if ($request->hasFile('logo_dark')) {
            try {
                $request->file('logo_dark')->move(public_path('images'), 'nbnp-logo-dark.png');
            } catch (\Exception $e) {
                Log::error('Neuspešno učitavanje tamnog loga: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Greška pri učitavanju tamnog loga.');
            }
        }

        $langDir = resource_path('lang');
        if (!file_exists($langDir)) {
            mkdir($langDir, 0755, true);
        }

        $srFilePath = resource_path('lang/sr.json');
        $existingSrData = file_exists($srFilePath) ? json_decode(file_get_contents($srFilePath), true) ?? [] : [];
        $existingSrData['library'] = $libraryData;

        $enFilePath = resource_path('lang/en.json');
        $existingEnData = file_exists($enFilePath) ? json_decode(file_get_contents($enFilePath), true) ?? [] : [];
        $existingEnData['library'] = $libraryData;

        try {
            file_put_contents($srFilePath, json_encode($existingSrData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
        } catch (\Exception $e) {
            Log::error('Neuspešno čuvanje JSON fajla: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Greška pri čuvanju podataka.');
        }

        try {
            file_put_contents($enFilePath, json_encode($existingEnData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
        } catch (\Exception $e) {
            Log::error('Neuspešno čuvanje JSON fajla: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Greška pri čuvanju podataka.');
        }

        return redirect()->back()->with('success', 'Podnožje uspešno ažurirano.');
    }
}