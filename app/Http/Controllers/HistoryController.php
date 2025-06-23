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
        if ($history) {
            $history->update([
                'content' => $request->input('content'),
            ]);
        } else {
            History::create([
                'content' => $request->input('content'),
            ]);
        }

        return redirect()->route('history.show')->with('success', 'Tekst istorijata je uspešno izmenjen.');
    }
}

