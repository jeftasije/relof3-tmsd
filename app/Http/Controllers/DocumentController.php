<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentCategory;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $categories = DocumentCategory::with('documents')->get();
        $activeCategoryName = $request->query('category');
        $activeCategoryId = null;

        if ($activeCategoryName) {
            $category = DocumentCategory::where('name', $activeCategoryName)->first();
            if ($category) {
                $activeCategoryId = $category->id;
            }
        }
        return view('documents', compact('categories', 'activeCategoryId'));
    }
}
