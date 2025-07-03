<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;
use Stichoza\GoogleTranslate\GoogleTranslate;
use App\Http\Controllers\LanguageMapperController;

class ContactController extends Controller
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
        $text = Lang::get('contact');
        return view('contact', compact('text'));
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

        //$name = $validated['first_name'] . ' ' . $validated['last_name'];
        $message_src = $validated['message'];

        $is_cyrillic = preg_match('/[\p{Cyrillic}]/u', $message_src);

        if (app()->getLocale() === 'en') {
            $message_en = $message_src;
            $message_lat = $this->translate->setSource('en')->setTarget('sr')->translate($message_en);
            $message_cy = $this->languageMapper->latin_to_cyrillic($message_lat);
        } elseif ($is_cyrillic) {
            $message_cy = $message_src;
            $message_lat = $this->languageMapper->cyrillic_to_latin($message_cy);
            $message_en = $this->translate->setSource('sr')->setTarget('en')->translate($message_lat);
        } else {
            $message_lat = $message_src;
            $message_cy = $this->languageMapper->latin_to_cyrillic($message_lat);
            $message_en = $this->translate->setSource('sr')->setTarget('en')->translate($message_lat);
        }

        $contact = Contact::create([
            'first_name'   => $validated['first_name'],
            'last_name'    => $validated['last_name'],
            'email'        => $validated['email'],
            'phone'        => $validated['phone'] ?? null,
            'message'      => $message_lat,
            'message_en'   => $message_en,
            'message_cy'   => $message_cy,
        ]);

        return redirect()->back()->with('success', 'Poruka uspešno poslata!');
    }

    public function updateContacts(Contact $contact)
    {
        $locale = app()->getLocale();

        if ($locale === 'en') {
            $message_en = $contact->message_en;
            $message_lat = $this->translate->setSource('en')->setTarget('sr')->translate($message_en);
            $message_cy = $this->languageMapper->latin_to_cyrillic($message_lat);

        } elseif ($locale === 'sr-Cyrl') {
            $message_cy = $contact->message_cy;
            $message_lat = $this->languageMapper->cyrillic_to_latin($message_cy);
            $message_en = $this->translate->setSource('sr')->setTarget('en')->translate($message_lat);

        } else {
            $message_lat = $contact->message;
            $message_cy = $this->languageMapper->latin_to_cyrillic($message_lat);
            $message_en = $this->translate->setSource('sr')->setTarget('en')->translate($message_lat);
        }

        $contact->update([
            'message'    => $message_lat,
            'message_en' => $message_en,
            'message_cy' => $message_cy,
        ]);

        return redirect()->back()->with('success', 'Prevod poruke je uspešno ažuriran.');
    }


    public function updateAllContacts()
    {
        Contact::all()->each(function($contact) {
            $this->updateContacts($contact);
        });

        return redirect()->back()->with('success', 'Svi prevodi su uspešno ažurirani.');
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
        } else {
            $toSr = $this->translate->setSource('en')->setTarget('sr')->translate($originalText);
            $toSrLat = $this->languageMapper->cyrillic_to_latin($toSr);

            if (mb_strtolower($toSrLat) === mb_strtolower($originalText)) {
                $answerLat = $originalText;
                $answerCy  = $this->languageMapper->latin_to_cyrillic($answerLat);
                $answerEn  = $this->translate->setSource('sr')->setTarget('en')->translate($answerLat);
            } else {
                $answerEn  = $originalText;
                $answerCy  = $this->translate->setSource('en')->setTarget('sr')->translate($answerEn);
                $answerLat = $this->languageMapper->cyrillic_to_latin($answerCy);
            }
        }

        $contact = Contact::findOrFail($id);
        $contact->answer     = $answerLat;  
        $contact->answer_cy  = $answerCy;
        $contact->answer_en  = $answerEn;
        $contact->save();

        return redirect()->back()->with('success', 'Odgovor uspešno sačuvan.');
    }


    public function answerPage()
    {
        $query = contact::query();

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

        $contacts = $query->orderBy('created_at', 'desc')->paginate(3);
        $contacts->appends(request()->all());

        return view('contactAnswer', compact('contacts'));
    }


    public function update(Request $request)
    {
        $validated = $request->validate([
            'locale'          => 'required|string|in:sr,sr-Cyrl,en',
            'title'           => 'required|string',
            'description'     => 'required|string',
            'content'         => 'required|string'
        ]);

        $translate = new GoogleTranslate();
        $lm = app(LanguageMapperController::class);

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

            if (!isset($json['contact']) || !is_array($json['contact'])) {
                $json['contact'] = [];
            }
            $json['contact']['title'] = $title;
            $json['contact']['description'] = $description;
            $json['contact']['content'] = $content;

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
                
                if (!isset($json['contact']) || !is_array($json['contact'])) {
                    $json['contact'] = [];
                }
                $json['contact']['title'] = $localized[$lang]['title'];
                $json['contact']['description'] = $localized[$lang]['description'];
                $json['contact']['content'] = $localized[$lang]['content'];

                file_put_contents($path, json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
            }
        }

        return response()->json(['success' => true, 'message' => 'Tekst kontakt sekcije uspešno sačuvan!']);
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