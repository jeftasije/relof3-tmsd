<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrganisationalStructure;
use Illuminate\Support\Facades\Storage;

class OrganisationalStructureController extends Controller
{
    public function index() {
        $structure = OrganisationalStructure::latest()->first(); 
        return view('organisationalStructure', compact('structure'));
    }

    public function destroy($id)
    {
        $structure = OrganisationalStructure::findOrFail($id);

        if ($structure->file_path) {
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($structure->file_path)) {
                $deleted = \Illuminate\Support\Facades\Storage::disk('public')->delete($structure->file_path);
                if (!$deleted) 
                    return response()->json(['message' => 'Err while deleting file from file system'], 500);  
            }
        }

        $structure->delete();

        return response()->json(['message' => 'doc deleted succesfully']);
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $structure = OrganisationalStructure::findOrFail($id);
        $structure->title = $request->input('title');
        $structure->save();

        return response()->json([
            'message' => 'Dokument uspešno preimenovan',
            'title' => $structure->title
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,xlsx,xls|max:2048', 
        ]);

        try {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('structures', $fileName, 'public');

            $structure = OrganisationalStructure::create([
                'title' => $file->getClientOriginalName(),
                'file_path' => $filePath,
            ]);

            return response()->json(['message' => 'doc uploaded succesfully', 'title' => $structure->title], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'err while uploading doc: ' . $e->getMessage()], 500);
        }
    }
}
