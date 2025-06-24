<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reminder;
use Carbon\Carbon;

class ReminderController extends Controller
{
    public function index() {
        $reminders = Reminder::orderBy('time', 'asc')->get();
        return view('reminders', compact('reminders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'date' => 'required|string', 
        ]);

        // conversion from "d.m.Y H:i" to datetime format
        $parsedTime = Carbon::createFromFormat('d.m.Y H:i', $request->date);

        Reminder::create([
            'title_en' => $request->title_en,
            'title_lat' => $request->title_en,
            'title_cyr' => $request->title_en,
            'time' => $parsedTime, 
        ]);

        return redirect()->back()->with('success', 'Podsetnik je sačuvan.');
    }

}
