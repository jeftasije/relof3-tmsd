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


    /*public function store(Request $request) {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email',
            'phone'      => 'nullable|string|max:20',
            'subject'    => 'required|string|max:255',
            'message'    => 'required|string',
        ]);

        //Complaint::create($validated);
        Complaint::create([
            'name'    => $validated['first_name'] . ' ' . $validated['last_name'],
            'email'   => $validated['email'],
            'phone'   => $validated['phone'] ?? null,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
        ]);
        
        return redirect()->back()->with('success', 'Žalba je uspešno poslata.');
    }*/
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email',
            'phone'      => 'nullable|string|max:20',
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

        $complaint = Complaint::create([
            'name'         => $name,
            'email'        => $validated['email'],
            'phone'        => $validated['phone'] ?? null,
            'subject'      => $subject_lat,
            'subject_en'   => $subject_en,
            'subject_cy'   => $subject_cy,
            'message'      => $message_lat,
            'message_en'   => $message_en,
            'message_cy'   => $message_cy,
        ]);

        return redirect()->back()->with('success', 'Žalba uspešno poslata!');
    }

    public function updateComplaints(Complaint $complaint)
    {
        $locale = app()->getLocale();

        if ($locale === 'en') {
            $subject_en = $complaint->subject_en;
            $message_en = $complaint->message_en;

            $subject_lat = $this->translate->setSource('en')->setTarget('sr')->translate($subject_en);
            $message_lat = $this->translate->setSource('en')->setTarget('sr')->translate($message_en);

            $subject_cy = $this->languageMapper->latin_to_cyrillic($subject_lat);
            $message_cy = $this->languageMapper->latin_to_cyrillic($message_lat);

        } elseif ($locale === 'sr-Cyrl') {
            $subject_cy = $complaint->subject_cy;
            $message_cy = $complaint->message_cy;

            $subject_lat = $this->languageMapper->cyrillic_to_latin($subject_cy);
            $message_lat = $this->languageMapper->cyrillic_to_latin($message_cy);

            $subject_en = $this->translate->setSource('sr')->setTarget('en')->translate($subject_lat);
            $message_en = $this->translate->setSource('sr')->setTarget('en')->translate($message_lat);

        } else {
            $subject_lat = $complaint->subject;
            $message_lat = $complaint->message;

            $subject_cy = $this->languageMapper->latin_to_cyrillic($subject_lat);
            $message_cy = $this->languageMapper->latin_to_cyrillic($message_lat);

            $subject_en = $this->translate->setSource('sr')->setTarget('en')->translate($subject_lat);
            $message_en = $this->translate->setSource('sr')->setTarget('en')->translate($message_lat);
        }

        $complaint->update([
            'subject'    => $subject_lat,
            'subject_en' => $subject_en,
            'subject_cy' => $subject_cy,
            'message'    => $message_lat,
            'message_en' => $message_en,
            'message_cy' => $message_cy,
        ]);

        return redirect()->back()->with('success', 'Prevod žalbe je uspešno ažuriran.');
    }


    public function updateAllComplaints()
    {
        Complaint::all()->each(function($complaint) {
            $this->updateComplaints($complaint);
        });

        return redirect()->back()->with('success', 'Svi prevodi su uspešno ažurirani.');
    }

    public function answer(Request $request, $id)
    {
        $request->validate([
            'answer' => 'required|string',
        ]);

        $originalText = trim($request->input('answer'));

        // Detekcija pisma (ćirilica / latinica / engleski)
        $detectedScript = $this->languageMapper->detectScript($originalText);

        $answerLat = '';
        $answerCy  = '';
        $answerEn  = '';

        if ($detectedScript === 'cyrillic') {
            $answerCy  = $originalText;
            $answerLat = $this->languageMapper->cyrillic_to_latin($answerCy);
            $answerEn  = $this->translate->setSource('sr')->setTarget('en')->translate($answerLat);
        } else {
            $toSr = $this->translate->setSource('en')->setTarget('sr')->translate($originalText);
            $toSrLat = $this->languageMapper->cyrillic_to_latin($toSr);

            if (mb_strtolower($toSrLat) === mb_strtolower($originalText)) {
                // Dakle — unos je na srpskom (latinica)
                $answerLat = $originalText;
                $answerCy  = $this->languageMapper->latin_to_cyrillic($answerLat);
                $answerEn  = $this->translate->setSource('sr')->setTarget('en')->translate($answerLat);
            } else {
                // Unos je na engleskom
                $answerEn  = $originalText;
                $answerCy  = $this->translate->setSource('en')->setTarget('sr')->translate($answerEn);
                $answerLat = $this->languageMapper->cyrillic_to_latin($answerCy);
            }
        }

        $complaint = Complaint::findOrFail($id);
        $complaint->answer     = $answerLat;  // Default prikaz (latinica)
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

        $complaints = $query->orderBy('created_at', 'desc')->paginate(10);
        $complaints->appends(request()->all());

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
