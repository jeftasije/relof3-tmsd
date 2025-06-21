<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;


class CommentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'comment' => 'required|string',
        ]);

        Comment::create($validated);

        return redirect()->route('complaints.index')->with('success_comment', 'Komentar je uspešno dodat!');
    }

}
