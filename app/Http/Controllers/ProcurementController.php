<?php

namespace App\Http\Controllers;

use App\Models\Procurement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProcurementController extends Controller
{

    public function index()
    {
        $procurements = Procurement::orderBy('updated_at', 'desc')->get();

        return view('procurements', compact('procurements'));
    }


    public function destroy($id)
    {
        $procurement = Procurement::findOrFail($id);

        if ($procurement->file_path) {
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($procurement->file_path)) {
                $deleted = \Illuminate\Support\Facades\Storage::disk('public')->delete($procurement->file_path);
                if (!$deleted) 
                    return response()->json(['message' => 'Greška prilikom brisanja fajla iz fajl sistema'], 500);  
            }
        }

        $procurement->delete();

        return response()->json(['message' => 'Dokument uspešno obrisan']);
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $procurement = Procurement::findOrFail($id);
        $procurement->title = $request->input('title');
        $procurement->save();

        return response()->json([
            'message' => 'Dokument uspešno preimenovan',
            'title' => $procurement->title
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
            $filePath = $file->storeAs('procurements', $fileName, 'public');

            $procurement = Procurement::create([
                'title' => $file->getClientOriginalName(),
                'file_path' => $filePath,
            ]);

            return response()->json(['message' => 'Dokument uspešno otpremljen', 'title' => $procurement->title], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Greška prilikom otpremanja: ' . $e->getMessage()], 500);
        }
    }
}
