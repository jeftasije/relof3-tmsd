<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentCategory;

class DocumentController extends Controller
{
    public function index()
    {
        $categories = DocumentCategory::with('documents')->get();
        return view('documents', compact('categories'));
    }                                               
}