<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{   
    public function index()
    {
        $messages = auth()->check() ? Contact::latest()->get() : null;
        return view('contact', compact('messages'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'nullable|email|max:255',
            'phone'      => 'nullable|string|max:20',
            'message'    => 'required|string',
        ]);

        Contact::create($validated);

        return redirect()->back()->with('success', 'Poruka je uspešno poslata!');
    }

}
