<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Comment;
use Illuminate\Http\Request;
use Stichoza\GoogleTranslate\GoogleTranslate;
use App\Http\Controllers\LanguageMapperController;
use Illuminate\Support\Facades\File;

class ComplaintController extends Controller
{
    /*public function index()
    {
        $comments = \App\Models\Comment::latest()->get();
        return view('complaints', compact('comments'));
    }*/

    protected $translate;
    protected $languageMapper;

    public function __construct(LanguageMapperController $languageMapper)
    {
        $this->translate = new GoogleTranslate();
        $this->translate->setSource('sr');
        $this->translate->setTarget('en');
        $this->languageMapper = $languageMapper;
    }

    public function index()
    {
        $locale = app()->getLocale();
        $complaintsContent = __('complaints.content', [], $locale);
        return view('complaints', compact('complaintsContent'));
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

    public function answerPage()
    {
        $complaints = Complaint::latest()->get();
        return view('complaintAnswer', compact('complaints'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $originalText = trim($request->input('content'));

        $detectedScript = $this->languageMapper->detectScript($originalText);

        $content_cy = '';
        $content_lat = '';
        $content_en = '';

        if ($detectedScript === 'cyrillic') {
            $content_cy = $originalText;
            $content_lat = $this->languageMapper->cyrillic_to_latin($content_cy);
            $content_en = $this->translate->setSource('sr')->setTarget('en')->translate($content_lat);
        } else {
            $toSr = $this->translate->setSource('en')->setTarget('sr')->translate($originalText);
            $toSrLatin = $this->languageMapper->cyrillic_to_latin($toSr);

            if (mb_strtolower($toSrLatin) === mb_strtolower($originalText)) {
                $content_lat = $originalText;
                $content_cy = $this->languageMapper->latin_to_cyrillic($content_lat);
                $content_en = $this->translate->setSource('sr')->setTarget('en')->translate($content_lat);
            } else {
                $content_en = $originalText;
                $content_cy = $this->translate->setSource('en')->setTarget('sr')->translate($content_en);
                $content_lat = $this->languageMapper->cyrillic_to_latin($content_cy);
            }
        }

        $this->updateLangFile('sr', [' complaints.content' => $content_lat]);
        $this->updateLangFile('sr-Cyrl', [' complaints.content' => $content_cy]);
        $this->updateLangFile('en', [' complaints.content' => $content_en]);

        return back()->with('success', 'Opis istorije je uspešno ažuriran.');
    }

    protected function updateLangFile($locale, array $data)
    {
        $path = resource_path("lang/{$locale}.json");

        if (!File::exists($path)) {
            File::put($path, '{}');
        }

        $translations = json_decode(File::get($path), true) ?? [];

        $translations = array_merge($translations, $data);

        File::put($path, json_encode($translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}
