<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;

class LibraryDataController extends Controller
{    
    public static function getLibraryData()
    {
        return Lang::get('library');
    }
}
