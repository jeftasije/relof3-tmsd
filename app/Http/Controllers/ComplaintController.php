<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Comment;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    /*public function index()
    {
        $comments = \App\Models\Comment::latest()->get();
        return view('complaints', compact('comments'));
    }*/

    public function index()
    {
        $comments = Comment::latest()->get();

        return view('complaints', compact('comments'));
    }


    public function store(Request $request) {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email',
            'phone'      => 'nullable|string|max:20',
            'message'    => 'required|string',
        ]);

        //Complaint::create($validated);
        Complaint::create([
            'name'    => $validated['first_name'] . ' ' . $validated['last_name'],
            'email'   => $validated['email'],
            'phone'   => $validated['phone'] ?? null,
            'message' => $validated['message'],
        ]);
        
        return redirect()->back()->with('success', 'Žalba je uspešno poslata.');
    }
}
