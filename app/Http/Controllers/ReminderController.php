<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reminder;

class ReminderController extends Controller
{
    public function index() {
        // Dohvati sve podsetnike i sortiraj ih po 'time' (npr. opadajuće)
        $reminders = Reminder::orderBy('time', 'asc')->get();

        // Prosledi podsetnike u Blade view
        return view('reminders', compact('reminders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        Reminder::create([
            'title_en' => $request->title_en,
            'title_lat' => $request->title_en, // privremeno isto
            'title_cyr' => $request->title_en, // privremeno isto
            'time' => $request->date,
        ]);

        return redirect()->back()->with('success', 'Podsetnik je sačuvan.');
    }
}
