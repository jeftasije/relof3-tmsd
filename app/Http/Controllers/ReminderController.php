<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reminder;
use Carbon\Carbon;

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
            'date' => 'required|string', // jer je u formatu koji nije "date"
        ]);

        // Konverzija iz "d.m.Y H:i" u pravi datetime objekat
        $parsedTime = Carbon::createFromFormat('d.m.Y H:i', $request->date);

        Reminder::create([
            'title_en' => $request->title_en,
            'title_lat' => $request->title_en,
            'title_cyr' => $request->title_en,
            'time' => $parsedTime, // ✅ sad je u pravilnom formatu
        ]);

        return redirect()->back()->with('success', 'Podsetnik je sačuvan.');
    }

}
