<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;
use Stichoza\GoogleTranslate\GoogleTranslate;
use App\Http\Controllers\LanguageMapperController;

class ComplaintController extends Controller
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

    public function index()
    {
        $text = Lang::get('complaints');
        return view('complaints', compact('text'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email',
            'phone' => ['nullable', 'regex:/^\d+$/', 'max:20'],
            'subject'    => 'required|string|max:255',
            'message'    => 'required|string',
        ]);

        $name = $validated['first_name'] . ' ' . $validated['last_name'];
        $subject_src = $validated['subject'];
        $message_src = $validated['message'];

        $is_cyrillic = preg_match('/[\p{Cyrillic}]/u', $subject_src);

        if (app()->getLocale() === 'en') {
            $subject_en = $subject_src;
            $message_en = $message_src;

            $subject_lat = $this->translate->setSource('en')->setTarget('sr')->translate($subject_en);
            $message_lat = $this->translate->setSource('en')->setTarget('sr')->translate($message_en);

            $subject_cy = $this->languageMapper->latin_to_cyrillic($subject_lat);
            $message_cy = $this->languageMapper->latin_to_cyrillic($message_lat);
        } elseif ($is_cyrillic) {
            $subject_cy = $subject_src;
            $message_cy = $message_src;

            $subject_lat = $this->languageMapper->cyrillic_to_latin($subject_cy);
            $message_lat = $this->languageMapper->cyrillic_to_latin($message_cy);

            $subject_en = $this->translate->setSource('sr')->setTarget('en')->translate($subject_lat);
            $message_en = $this->translate->setSource('sr')->setTarget('en')->translate($message_lat);
        } else {
            $subject_lat = $subject_src;
            $message_lat = $message_src;

            $subject_cy = $this->languageMapper->latin_to_cyrillic($subject_lat);
            $message_cy = $this->languageMapper->latin_to_cyrillic($message_lat);

            $subject_en = $this->translate->setSource('sr')->setTarget('en')->translate($subject_lat);
            $message_en = $this->translate->setSource('sr')->setTarget('en')->translate($message_lat);
        }

        Complaint::create([
            'name'         => $name,
            'email'        => $validated['email'],
            'phone'        => $validated['phone'] ?? null,
            'subject'      => $subject_src,
            'subject_lat'  => $subject_lat,
            'subject_en'   => $subject_en,
            'subject_cy'   => $subject_cy,
            'message'      => $message_src,
            'message_lat'  => $message_lat,
            'message_en'   => $message_en,
            'message_cy'   => $message_cy,
        ]);

        return redirect()->back()->with('success', 'Žalba uspešno poslata!');
    }

    public function answer(Request $request, $id)
    {
        $request->validate([
            'answer' => 'required|string',
        ]);

        $originalText = trim($request->input('answer'));

        $detectedScript = $this->languageMapper->detectScript($originalText);

        $answerLat = '';
        $answerCy  = '';
        $answerEn  = '';

        if ($detectedScript === 'cyrillic') {
            $answerCy  = $originalText;
            $answerLat = $this->languageMapper->cyrillic_to_latin($answerCy);
            $answerEn  = $this->translate->setSource('sr')->setTarget('en')->translate($answerLat);
        } elseif (app()->getLocale() === 'sr') {
            $answerLat = $originalText;
            $answerCy  = $this->languageMapper->latin_to_cyrillic($answerLat);
            $answerEn  = $this->translate->setSource('sr')->setTarget('en')->translate($answerLat);
        } else {
            $answerEn  = $originalText;
            $answerCy  = $this->translate->setSource('en')->setTarget('sr')->translate($answerEn);
            $answerLat = $this->languageMapper->cyrillic_to_latin($answerCy);
        }

        $complaint = Complaint::findOrFail($id);
        $complaint->answer     = $originalText;
        $complaint->answer_lat = $answerLat;
        $complaint->answer_cy  = $answerCy;
        $complaint->answer_en  = $answerEn;
        $complaint->save();

        return redirect()->back()->with('success', 'Odgovor uspešno sačuvan.');
    }

    public function answerPage()
    {
        $query = Complaint::query();

        if (request()->filled('date_from')) {
            $query->whereDate('created_at', '>=', request('date_from'));
        }

        if (request()->filled('date_to')) {
            $query->whereDate('created_at', '<=', request('date_to'));
        }

        if (request()->filled('has_answer')) {
            if (request('has_answer') == '1') {
                $query->whereNotNull('answer');
            } elseif (request('has_answer') == '0') {
                $query->whereNull('answer');
            }
        }

        $complaints = $query->orderBy('created_at', 'desc')->paginate(3);
        $complaints->appends(request()->all());

        return view('complaintAnswer', compact('complaints'));
    }

    public function updateContent(Request $request)
    {
        $validated = $request->validate([
            'locale'      => 'required|string|in:sr,sr-Cyrl,en',
            'title'       => 'required|string',
            'description' => 'required|string',
            'content'     => 'required|string'
        ]);

        $translate = new \Stichoza\GoogleTranslate\GoogleTranslate();
        $lm = app(\App\Http\Controllers\LanguageMapperController::class);

        $src = $validated['locale'];
        $title = $validated['title'];
        $description = $validated['description'];
        $content = $validated['content'];

        $langFiles = [
            'sr'      => resource_path('lang/sr.json'),
            'sr-Cyrl' => resource_path('lang/sr-Cyrl.json'),
            'en'      => resource_path('lang/en.json'),
        ];

        if ($src === 'en') {
            $path = $langFiles['en'];
            $json = file_exists($path) ? json_decode(file_get_contents($path), true) : [];
            if (!isset($json['complaints']) || !is_array($json['complaints'])) {
                $json['complaints'] = [];
            }
            $json['complaints']['title'] = $title;
            $json['complaints']['description'] = $description;
            $json['complaints']['content'] = $content;
            file_put_contents($path, json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        } else {
            $localized = [
                'sr'      => ['title' => $title, 'description' => $description, 'content' => $content],
                'sr-Cyrl' => ['title' => $title, 'description' => $description, 'content' => $content],
                'en'      => ['title' => $title, 'description' => $description, 'content' => $content],
            ];

            if ($src === 'sr') {
                $localized['sr-Cyrl']['title'] = $lm->latin_to_cyrillic($title);
                $localized['sr-Cyrl']['description'] = $lm->latin_to_cyrillic($description);
                $localized['sr-Cyrl']['content'] = $lm->latin_to_cyrillic($content);

                $translate->setSource('sr')->setTarget('en');
                $localized['en']['title'] = $translate->translate($title);
                $localized['en']['description'] = $translate->translate($description);
                $localized['en']['content'] = $translate->translate($content);
            } elseif ($src === 'sr-Cyrl') {
                $localized['sr']['title'] = $lm->cyrillic_to_latin($title);
                $localized['sr']['description'] = $lm->cyrillic_to_latin($description);
                $localized['sr']['content'] = $lm->cyrillic_to_latin($content);

                $translate->setSource('sr')->setTarget('en');
                $localized['en']['title'] = $translate->translate($localized['sr']['title']);
                $localized['en']['description'] = $translate->translate($localized['sr']['description']);
                $localized['en']['content'] = $translate->translate($localized['sr']['content']);
            }

            foreach ($langFiles as $lang => $path) {
                $json = file_exists($path) ? json_decode(file_get_contents($path), true) : [];
                if (!isset($json['complaints']) || !is_array($json['complaints'])) {
                    $json['complaints'] = [];
                }
                $json['complaints']['title'] = $localized[$lang]['title'];
                $json['complaints']['description'] = $localized[$lang]['description'];
                $json['complaints']['content'] = $localized[$lang]['content'];

                file_put_contents($path, json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
            }
        }

        return response()->json(['success' => true, 'message' => 'Tekst uspešno sačuvan!']);
    }
}
