<?php

namespace App\Http\Controllers;

use App\Models\Procurement;
use Illuminate\Http\Request;

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
