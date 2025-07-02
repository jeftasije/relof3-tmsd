<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use Illuminate\Support\Facades\File;
use Stichoza\GoogleTranslate\GoogleTranslate;
use App\Http\Controllers\LanguageMapperController;
use Illuminate\Support\Facades\App;
use Termwind\Components\Dd;

class QuestionController extends Controller
{
    protected $translate;
    protected $languageMapper;

    public function __construct(LanguageMapperController $languageMapper)
    {
        $this->translate = new GoogleTranslate();
        $this->languageMapper = $languageMapper;
    }

    private function translateQuestionAndAnswer(string $text): array
    {
        $isCyrillic = preg_match('/[\p{Cyrillic}]/u', $text);

        if ($isCyrillic) {
            $cy = $text;
            $lat = $this->languageMapper->cyrillic_to_latin($cy);
            $en = $this->translate->setSource('sr')->setTarget('en')->translate($lat);
        } else {
            if (app()->getLocale() === 'sr') {
                $lat = $text;
                $cy = $this->languageMapper->latin_to_cyrillic($lat);
                $en = $this->translate->setSource('sr')->setTarget('en')->translate($lat);
            } else {
                $en = $text;
                $cy = $this->translate->setSource('en')->setTarget('sr')->translate($en);
                $lat = $this->languageMapper->cyrillic_to_latin($cy);
            }
        }

        return compact('lat', 'cy', 'en');
    }

    public function index(Request $request)
    {
        $query = Question::query();

        // Pretraga po tekstu
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('question', 'like', "%{$search}%")
                    ->orWhere('question_en', 'like', "%{$search}%")
                    ->orWhere('question_cy', 'like', "%{$search}%");
            });
        }

        // Sortiranje po odabiru
        $sort = $request->input('sort');
        switch ($sort) {
            case 'title_desc':
                $query->orderBy('question', 'desc');
                break;
            default:
                $query->orderBy('question', 'asc');
                break;
        }

        $questions = $query->paginate(10)->withQueryString();

        // Uhvati ID pitanja koje treba da bude otvoreno (ako postoji)
        $activeQuestionId = $request->input('open'); // npr. /pitanja?open=5

        // Prosledi i activeQuestionId u view
        return view('questions', compact('questions', 'activeQuestionId'));
    }


    // Dodavanje novog pitanja sa automatskim prevodom
    public function store(Request $request)
    {
        // Validacija ulaznih podataka
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answer'   => 'required|string',
        ]);

        $questionSrc = $validated['question'];
        $answerSrc = $validated['answer'];

        // Dobijamo prevode za pitanje i odgovor
        $questionTranslations = $this->translateQuestionAndAnswer($questionSrc);
        $answerTranslations = $this->translateQuestionAndAnswer($answerSrc);

        // Kreiramo novo pitanje sa svim prevodima
        $question = Question::create([
            'question'    => $questionTranslations['lat'],  // Latinica ili default
            'question_en' => $questionTranslations['en'],   // Engleski prevod
            'question_cy' => $questionTranslations['cy'],   // Ćirilica
            'answer'      => $answerTranslations['lat'],
            'answer_en'   => $answerTranslations['en'],
            'answer_cy'   => $answerTranslations['cy'],
        ]);

        // Preusmeravamo nazad sa porukom o uspehu
        return redirect()->back()->with('success', __('Question created successfully!'));
    }

    // Update pitanja sa prevodom
    public function update(Request $request, Question $question)
    {
        $validated = $request->validate([
            'question'    => 'required|string|max:255',
            'answer'      => 'required|string',
        ]);

        $questionSrc = $validated['question'];
        $answerSrc = $validated['answer'];

        if (app()->getLocale() === 'en') {
            $questionTranslations['en'] = $questionSrc;
            $answerTranslations['en'] = $answerSrc;

            $question->update([
                'question_en'   => $questionTranslations['en'],
                'answer_en'   => $answerTranslations['en']
            ]);

            return back()->with('success', 'Question updated successfully!');
        } else {
            $questionTranslations = $this->translateQuestionAndAnswer($questionSrc);
            $answerTranslations = $this->translateQuestionAndAnswer($answerSrc);
        }

        $question->update([
            'question'    => $questionTranslations['lat'],
            'question_en' => $questionTranslations['en'],
            'question_cy' => $questionTranslations['cy'],
            'answer'      => $answerTranslations['lat'],
            'answer_en'   => $answerTranslations['en'],
            'answer_cy'   => $answerTranslations['cy'],
        ]);

        return back()->with('success', 'Question updated successfully!');
    }

    // Brisanje pitanja
    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->back()->with('success', 'Pitanje uspešno obrisano.');
    }

    public function edit(Question $question)
    {
        // Možeš dodati autorizaciju ako je potrebno
        return view('questions.edit', compact('question'));
    }

    public function getQuestionAttribute()
    {
        $lang = app()->getLocale();
        return match ($lang) {
            'en' => $this->question_en ?: $this->question,
            'cy' => $this->question_cy ?: $this->question,
            default => $this->question,
        };
    }

    public function getAnswerAttribute()
    {
        $lang = app()->getLocale();
        return match ($lang) {
            'en' => $this->answer_en ?: $this->answer,
            'cy' => $this->answer_cy ?: $this->answer,
            default => $this->answer,
        };
    }

    public function updateDescription(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
        ]);

        $originalText = trim($request->input('description'));
        $detectedScript = $this->languageMapper->detectScript($originalText);
        if ($detectedScript === 'cyrillic') {
            $content_cy = $originalText;
            $content_lat = $this->languageMapper->cyrillic_to_latin($content_cy);
            $content_en = $this->translate->setSource('sr')->setTarget('en')->translate($content_lat);
        } else {
            if (app()->getLocale() === 'sr') {
                dd('SrLatin');
                $content_lat = $originalText;
                $content_cy = $this->languageMapper->latin_to_cyrillic($content_lat);
                $content_en = $this->translate->setSource('sr')->setTarget('en')->translate($content_lat);
            } else {
                $content_en = $originalText;
                $this->updateLangFile('en', ['question.description' => $content_en]);
                return redirect()->back()->with('success', 'Prevod poruke je uspešno ažuriran.');
            }
        }

        $this->updateLangFile('sr', ['question.description' => $content_lat]);
        $this->updateLangFile('sr-Cyrl', ['question.description' => $content_cy]);
        $this->updateLangFile('en', ['question.description' => $content_en]);

        return redirect()->back()->with('success', 'Prevod poruke je uspešno ažuriran.');
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
