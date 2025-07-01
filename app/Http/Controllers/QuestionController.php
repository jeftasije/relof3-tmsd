<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use Stichoza\GoogleTranslate\GoogleTranslate;
use App\Http\Controllers\LanguageMapperController;

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
            $translatedToSr = $this->translate->setSource('en')->setTarget('sr')->translate($text);
            $translatedToSrLat = $this->languageMapper->cyrillic_to_latin($translatedToSr);

            if (mb_strtolower($translatedToSrLat) === mb_strtolower($text)) {
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
        $sort = $request->input('sort', 'date_desc');
        switch ($sort) {
            case 'title_asc':
                $query->orderBy('question', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('question', 'desc');
                break;
            case 'date_asc':
                $query->orderBy('created_at', 'asc');
                break;
            case 'date_desc':
            default:
                $query->orderBy('created_at', 'desc');
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
        $validated = $request->validate([
            'question'    => 'required|string|max:255',
            'answer'      => 'required|string',
        ]);

        $questionSrc = $validated['question'];
        $answerSrc = $validated['answer'];

        $questionTranslations = $this->translateQuestionAndAnswer($questionSrc);
        $answerTranslations = $this->translateQuestionAndAnswer($answerSrc);

        $question = Question::create([
            'question'    => $questionTranslations['lat'],
            'question_en' => $questionTranslations['en'],
            'question_cy' => $questionTranslations['cy'],
            'answer'      => $answerTranslations['lat'],
            'answer_en'   => $answerTranslations['en'],
            'answer_cy'   => $answerTranslations['cy'],
        ]);

        return redirect()->route('questions')->with('success', 'Question created successfully!');
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

        $questionTranslations = $this->translateQuestionAndAnswer($questionSrc);
        $answerTranslations = $this->translateQuestionAndAnswer($answerSrc);

        $question->update([
            'question'    => $questionTranslations['lat'],
            'question_en' => $questionTranslations['en'],
            'question_cy' => $questionTranslations['cy'],
            'answer'      => $answerTranslations['lat'],
            'answer_en'   => $answerTranslations['en'],
            'answer_cy'   => $answerTranslations['cy'],
        ]);

        return redirect()->route('questions')->with('success', 'Question updated successfully!');
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


}
