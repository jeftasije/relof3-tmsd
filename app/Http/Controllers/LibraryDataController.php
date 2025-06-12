<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LibraryDataController extends Controller
{
    public static function getLibraryData()
    {
        $path = config_path('library.json');
        if (file_exists($path)) {
            return json_decode(file_get_contents($path), true);
        }
        return [];
    }
}
