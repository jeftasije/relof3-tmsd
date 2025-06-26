<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function show()
    {
        $jsonPath = resource_path('lang/sr.json');
        $jsonData = file_exists($jsonPath)
            ? json_decode(file_get_contents($jsonPath), true)
            : [];
        
        $servicesData = $jsonData['services'] ?? [];

        return view('services', compact('servicesData'));
    }
}
