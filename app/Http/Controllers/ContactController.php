<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\ContactContent;  

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

    public function answer()
    {
        $messages = Contact::latest()->get();
        return view('contactAnswer', compact('messages'));
    }

    public function edit()
    {
        $content = ContactContent::first();
        return view('contact', compact('content'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'text_sr' => 'required|string',
            'text_en' => 'nullable|string',
            'text_cy' => 'nullable|string',
        ]);

        $content = ContactContent::first();

        if ($content) {
            $content->update($validated);
        } else {
            ContactContent::create($validated);
        }

        return redirect()->route('contact.edit')->with('success', 'Sadržaj uspešno sačuvan!');
    }


}
