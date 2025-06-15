<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::all();
        $text = Lang::get('news');
        return view('news', compact('news', 'text'));
    }

    public function show(News $news)
    {
        $news->load('extended');
        return view('extendedNews', compact('news'));
    }
}
