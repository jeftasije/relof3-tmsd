<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function destroy($id)
    {
        $document = Document::findOrFail($id);
        $document->delete();

        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        return response()->json(['message' => 'Document deleted successfully']);
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $document = Document::findOrFail($id);
        $document->title = $request->input('title');
        $document->save();

        return response()->json(['message' => 'Document renamed successfully', 'title' => $document->title]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,xlsx,xls|max:2048',
            'category_id' => 'required|exists:document_categories,id',
        ]);

        $file = $request->file('file');
        $filePath = $file->store('documents', 'public');
        $title = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        $document = Document::create([
            'title' => $title,
            'file_path' => $filePath,
            'category_id' => $request->input('category_id'),
        ]);

        return response()->json([
            'message' => 'Document uploaded successfully',
            'document' => [
                'id' => $document->id,
                'title' => $document->title,
                'file_path' => $document->file_path,
                'category_id' => $document->category_id,
            ],
        ]);
    }
}
