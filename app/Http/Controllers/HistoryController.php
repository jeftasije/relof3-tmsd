<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function show()
    {
        $history = History::first(); 
        return view('history', compact('history'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $history = History::first();
        $history->update([
            'content' => $request->content
        ]);

        return redirect()->route('history.show')->with('success', 'Tekst istorijata je uspešno izmenjen.');
    }
}

