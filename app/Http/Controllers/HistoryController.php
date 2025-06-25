<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;
use Stichoza\GoogleTranslate\GoogleTranslate;
use App\Http\Controllers\LanguageMapperController;

class HistoryController extends Controller
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

    public function show()
    {
        $history = History::first();
        return view('history', compact('history'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $content_src = $request->input('content');
        $locale = app()->getLocale();
        $is_cyrillic = preg_match('/[\p{Cyrillic}]/u', $content_src);

        if ($locale === 'en') {
            $content_en = $content_src;
            $content_lat = $this->translate->setSource('en')->setTarget('sr')->translate($content_en);
            $content_cy = $this->languageMapper->latin_to_cyrillic($content_lat);
        } elseif ($is_cyrillic) {
            $content_cy = $content_src;
            $content_lat = $this->languageMapper->cyrillic_to_latin($content_cy);
            $content_en = $this->translate->setSource('sr')->setTarget('en')->translate($content_lat);
        } else {
            $content_lat = $content_src;
            $content_cy = $this->languageMapper->latin_to_cyrillic($content_lat);
            $content_en = $this->translate->setSource('sr')->setTarget('en')->translate($content_lat);
        }

        $history = History::first();
        if ($history) {
            $history->update([
                'content' => $content_lat,
                'content_cy' => $content_cy,
                'content_en' => $content_en,
            ]);
        } else {
            History::create([
                'content' => $content_lat,
                'content_cy' => $content_cy,
                'content_en' => $content_en,
            ]);
        }

        return redirect()->route('history.show')->with('success', 'Istorijat je uspešno ažuriran.');
    }
}
