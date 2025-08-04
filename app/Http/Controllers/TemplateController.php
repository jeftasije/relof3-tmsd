<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Template;

class TemplateController extends Controller
{
     public function index()
    {
        $templates = Template::all();
        return view('superAdmin.templates', compact('templates'));
    }
}
