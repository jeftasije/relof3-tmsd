<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reminder;
use Carbon\Carbon;
use Stichoza\GoogleTranslate\GoogleTranslate;
use App\Http\Controllers\LanguageMapperController;

class ReminderController extends Controller
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

    private function detectLang($text): string
    {
        return $this->translate->detect($text);
    }

    public function index(Request $request) {
        $search = $request->input('search');
        $sort = $request->input('sort', 'asc'); 

        $query = Reminder::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title_en', 'like', "%$search%")
                ->orWhere('title_lat', 'like', "%$search%")
                ->orWhere('title_cyr', 'like', "%$search%");
            });
        }

        if ($sort === 'asc') 
            $query->orderBy('time', 'desc');
        elseif ($sort === 'desc') 
            $query->orderBy('time', 'asc');
         else 
            $query->orderBy('time', 'asc'); 
        
        $reminders = $query->get();

        return view('reminders', compact('reminders', 'search', 'sort'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'date' => 'required|string',
        ]);

        $parsedTime = Carbon::createFromFormat('d.m.Y H:i', $request->date);
        $originalTitle = $request->title_en;

        $detectedScript = $this->languageMapper->detectScript($originalTitle);
        if($detectedScript === 'cyrillic') {                                                            //input in serbian cyrillic
            $titleCyr = $originalTitle;
            $titleLat = $this->languageMapper->cyrillic_to_latin($titleCyr);
            $titleEn = $this->translate->setSource('sr')->setTarget('en')->translate($originalTitle);

            $this->create_reminder($titleEn, $titleLat, $titleCyr, $parsedTime);
            return redirect()->back()->with('success', 'Reminder created successfully.');
        }

        $toSr = $this->translate->setSource('en')->setTarget('sr')->translate($originalTitle);
        $toSrLatin = $this->languageMapper->cyrillic_to_latin($toSr);

        if (mb_strtolower($toSrLatin) === mb_strtolower($originalTitle)) {                              //input in serbian latin
            $titleCyr = $this->languageMapper->latin_to_cyrillic($originalTitle);
            $titleLat = $originalTitle;
            $titleEn = $this->translate->setSource('sr')->setTarget('en')->translate($originalTitle);

            $this->create_reminder($titleEn, $titleLat, $titleCyr, $parsedTime);
            return redirect()->back()->with('success', 'Reminder created successfully.');
        }

        $titleEn = $originalTitle;
        $titleCyr = $this->translate->setSource('en')->setTarget('sr')->translate($originalTitle);
        $titleLat = $this->languageMapper->cyrillic_to_latin($titleCyr);

        $this->create_reminder($titleEn, $titleLat, $titleCyr, $parsedTime);
        return redirect()->back()->with('success', 'Reminder created successfully.');
    }

    protected function create_reminder($titleEn, $titleLat, $titleCyr, $parsedTime)
    {
        Reminder::create([
            'title_en' => $titleEn,
            'title_lat' => $titleLat,
            'title_cyr' => $titleCyr,
            'time' => $parsedTime,
        ]);
    }

}

