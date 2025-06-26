<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function show()
    {
        $servicesData = \Lang::get('services');
        return view('services', compact('servicesData'));
    }

    public function index()
    {
        $servicesData = Lang::get('services');
        return view('services', compact('servicesData'));
    }
}
