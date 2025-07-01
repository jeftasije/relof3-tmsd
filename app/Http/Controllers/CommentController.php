<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'comment' => 'required|string',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        Comment::create([
            'name' => $request->name,
            'comment' => $request->comment,
            'parent_id' => $request->parent_id,
            'is_official' => Auth::check(),
        ]);

        return redirect()->back()->with('success', 'Komentar je uspešno dodat!');
    }

    public function index()
    {
        $libary_name = Lang::get('library')['name'];
        $comments = Comment::with('replies')->whereNull('parent_id')->latest()->paginate(5);
        return view('comments', compact('comments', 'libary_name'));
    }
}
