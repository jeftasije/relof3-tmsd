<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Auth;
use Stichoza\GoogleTranslate\GoogleTranslate;
use App\Http\Controllers\LanguageMapperController;


class CommentController extends Controller
{

    protected $translate;
    protected $languageMapper;

    public function __construct(LanguageMapperController $languageMapper)
    {
        $this->translate = new GoogleTranslate();
        $this->translate->setSource('sr');
        $this->translate->setTarget('en');

        $this->languageMapper = $languageMapper;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'comment' => 'required|string',
            'parent_id' => 'nullable|exists:comments,id'
        ]);
        $comment = $request->comment;
        $detectedScript = $this->languageMapper->detectScript($comment);
        if ($detectedScript === 'cyrillic') {
            $comment_cy = $comment;
            $comment_lat = $this->languageMapper->cyrillic_to_latin($comment);
            $comment_en = $this->translate->setSource('sr')->setTarget('en')->translate($comment);
        }else {
            $toSr = $this->translate->setSource('en')->setTarget('sr')->translate($comment);
            $toSrLatin = $this->languageMapper->cyrillic_to_latin($toSr);

            if (mb_strtolower($toSrLatin) === mb_strtolower($comment)) {                              //input in serbian latin
                $comment_cy = $this->languageMapper->latin_to_cyrillic($comment);
                $comment_lat = $comment;
                $comment_en = $this->translate->setSource('sr')->setTarget('en')->translate($comment);
            } else {
                $comment_en = $comment;
                $comment_cy = $this->translate->setSource('en')->setTarget('sr')->translate($comment);
                $comment_lat = $this->languageMapper->cyrillic_to_latin($comment_cy);
            }
        }

        Comment::create([
            'name' => $request->name,
            'comment' => $request->comment,
            'comment_lat' => $comment_lat,
            'comment_cy' => $comment_cy,
            'comment_en' => $comment_en,
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
