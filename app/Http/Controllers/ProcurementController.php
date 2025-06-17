<?php

namespace App\Http\Controllers;

use App\Models\Procurement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProcurementController extends Controller
{
    public function index(Request $request)
    {
        $query = Procurement::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $procurements = $query->latest()->get();

        return view('procurements', compact('procurements'));
    }

public function destroy($id)
{
    $procurement = Procurement::findOrFail($id);

    if ($procurement->file_path) {
        // Provera da li fajl postoji pre brisanja
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($procurement->file_path)) {
            $deleted = \Illuminate\Support\Facades\Storage::disk('public')->delete($procurement->file_path);
            if (!$deleted) {
                return response()->json(['message' => 'Greška prilikom brisanja fajla iz fajl sistema'], 500);
            }
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
}
