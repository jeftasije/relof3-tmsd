<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class LibraryDataController extends Controller
{
    public static function getLibraryData()
    {
        $path = storage_path('app/public/library.json');
        if (file_exists($path)) {
            return json_decode(file_get_contents($path), true);
        }
        return [];
    }
}

