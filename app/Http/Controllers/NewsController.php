<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\ExtendedNews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\File;
use Stichoza\GoogleTranslate\GoogleTranslate;
use App\Http\Controllers\LanguageMapperController;

class NewsController extends Controller
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
        $news = News::orderByDesc('published_at')->paginate(6);
        $text = Lang::get('news');
        return view('news', compact('news', 'text'));
    }

    public function show(News $news)
    {
        $news->load('extended');
        return view('extendedNews', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $translate = $this->translate;
        $lm = $this->languageMapper;

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'required|string|max:2000',
            'locale' => 'required|string'
        ]);

        if ($validated['locale'] === 'en') {
            $title_en = $validated['title'];
            $summary_en = $validated['summary'];

            $title_lat = $lm->cyrillic_to_latin($translate->setSource('en')->setTarget('sr')->translate($title_en));
            $summary_lat = $lm->cyrillic_to_latin($translate->setSource('en')->setTarget('sr')->translate($summary_en));

            $title_cy = $lm->latin_to_cyrillic($title_lat);
            $summary_cy = $lm->latin_to_cyrillic($summary_lat);

            $news->update([
                'title_en' => $title_en,
                'summary_en' => $summary_en,
                'title' => $title_lat,
                'summary' => $summary_lat,
                'title_cy' => $title_cy,
                'summary_cy' => $summary_cy,
            ]);
        } elseif ($validated['locale'] === 'sr-Cyrl' || $validated['locale'] === 'cy') {
            $title_cy = $validated['title'];
            $summary_cy = $validated['summary'];

            $title_lat = $lm->cyrillic_to_latin($title_cy);
            $summary_lat = $lm->cyrillic_to_latin($summary_cy);

            $title_en = $translate->setSource('sr')->setTarget('en')->translate($title_lat);
            $summary_en = $translate->setSource('sr')->setTarget('en')->translate($summary_lat);

            $news->update([
                'title_cy' => $title_cy,
                'summary_cy' => $summary_cy,
                'title' => $title_lat,
                'summary' => $summary_lat,
                'title_en' => $title_en,
                'summary_en' => $summary_en,
            ]);
        } else {
            $title_lat = $validated['title'];
            $summary_lat = $validated['summary'];

            $title_cy = $lm->latin_to_cyrillic($title_lat);
            $summary_cy = $lm->latin_to_cyrillic($summary_lat);

            $title_en = $translate->setSource('sr')->setTarget('en')->translate($title_lat);
            $summary_en = $translate->setSource('sr')->setTarget('en')->translate($summary_lat);

            $news->update([
                'title' => $title_lat,
                'summary' => $summary_lat,
                'title_cy' => $title_cy,
                'summary_cy' => $summary_cy,
                'title_en' => $title_en,
                'summary_en' => $summary_en,
            ]);
        }

        return response()->json(['message' => 'News updated']);
    }

    public function destroy(News $news)
    {
        $news->delete();
        return redirect()->route('news.index')->with('success', 'Vest uspešno obrisana.');
    }

    public function store(Request $request)
    {
        $locale = $request->input('locale', app()->getLocale());

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'required|string|max:2000',
            'image' => 'nullable|image|max:2048',
            'author' => 'required|string|max:255',
            'published_at' => 'nullable|date',
            'content' => 'nullable|string',
            'tags' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $validated['image_path'] = 'images/' . $filename;
        }

        $title_src    = $validated['title'];
        $summary_src  = $validated['summary'];
        $author_src   = $validated['author'];
        $content_src  = $validated['content'] ?? '';
        $tags_src     = $validated['tags'] ?? '';
        $tags_arr     = array_filter(array_map('trim', preg_split('/[,;]+/', $tags_src)));

        $translate = $this->translate;
        $lm = $this->languageMapper;

        // Prvo odredi latinicu/cirilicu
        if (preg_match('/[\p{Cyrillic}]/u', $title_src)) {
            // Polazna je ćirilica
            $title_cy = $title_src;
            $summary_cy = $summary_src;
            $author_cy = $author_src;
            $content_cy = $content_src;
            $tags_cy = $tags_arr;

            $title_lat = $lm->cyrillic_to_latin($title_cy);
            $summary_lat = $lm->cyrillic_to_latin($summary_cy);
            $author_lat = $lm->cyrillic_to_latin($author_cy);
            $content_lat = $lm->cyrillic_to_latin($content_cy);
            $tags_lat = array_map(fn($t) => $lm->cyrillic_to_latin($t), $tags_cy);

        } else {
            // Polazna je latinica
            $title_lat = $title_src;
            $summary_lat = $summary_src;
            $author_lat = $author_src;
            $content_lat = $content_src;
            $tags_lat = $tags_arr;

            $title_cy = $lm->latin_to_cyrillic($title_lat);
            $summary_cy = $lm->latin_to_cyrillic($summary_lat);
            $author_cy = $lm->latin_to_cyrillic($author_lat);
            $content_cy = $lm->latin_to_cyrillic($content_lat);
            $tags_cy = array_map(fn($t) => $lm->latin_to_cyrillic($t), $tags_lat);
        }

        // Engleski prevod iz latinice (uvek šalji latinicu na prevod)
        $title_en = $translate->setSource('sr')->setTarget('en')->translate($title_lat);
        $summary_en = $translate->setSource('sr')->setTarget('en')->translate($summary_lat);
        $author_en = $translate->setSource('sr')->setTarget('en')->translate($author_lat);
        $content_en = $translate->setSource('sr')->setTarget('en')->translate($content_lat);
        $tags_en = array_map(fn($t) => $translate->setSource('sr')->setTarget('en')->translate($t), $tags_lat);

        // Upis
        $news = News::create([
            'title'        => $title_lat,
            'title_en'     => $title_en,
            'title_cy'     => $title_cy,
            'summary'      => $summary_lat,
            'summary_en'   => $summary_en,
            'summary_cy'   => $summary_cy,
            'image_path'   => $validated['image_path'] ?? null,
            'author'       => $author_lat,
            'author_en'    => $author_en,
            'author_cy'    => $author_cy,
            'published_at' => $validated['published_at'] ?? null,
        ]);

        $news->extended()->create([
            'content'    => $content_lat,
            'content_en' => $content_en,
            'content_cy' => $content_cy,
            'tags'       => $tags_lat,
            'tags_en'    => $tags_en,
            'tags_cy'    => $tags_cy,
        ]);

        return redirect()->route('news.index')->with('success', 'Vest uspešno dodata!');
    }

    public function updateExtendedNews(Request $request, News $news)
    {
        $validated = $request->validate([
            'locale' => 'required|string',
            'content' => 'nullable|string',
            'content_en' => 'nullable|string',
            'content_cy' => 'nullable|string',
            'tags' => 'nullable|string',
            'tags_en' => 'nullable|string',
            'tags_cy' => 'nullable|string',
        ]);

        $translate = $this->translate;
        $lm = $this->languageMapper;

        $updateData = [];

        if ($validated['locale'] === 'en') {
            $content_en = $validated['content_en'] ?? $validated['content'] ?? '';
            $tags_en = !empty($validated['tags_en']) ? array_map('trim', explode(',', $validated['tags_en'])) : [];

            // Ispravno: uvek konvertuj rezultat na latinicu!
            $translated = $translate->setSource('en')->setTarget('sr')->translate($content_en);
            $content_lat = $lm->cyrillic_to_latin($translated);
            $tags_lat = array_map(function ($tag) use ($translate, $lm) {
                $translated_tag = $translate->setSource('en')->setTarget('sr')->translate($tag);
                return $lm->cyrillic_to_latin($translated_tag);
            }, $tags_en);

            $content_cy = $lm->latin_to_cyrillic($content_lat);
            $tags_cy = array_map(fn($tag) => $lm->latin_to_cyrillic($tag), $tags_lat);

            $updateData['content_en'] = $content_en;
            $updateData['tags_en'] = $tags_en;
            $updateData['content'] = $content_lat;
            $updateData['tags'] = $tags_lat;
            $updateData['content_cy'] = $content_cy;
            $updateData['tags_cy'] = $tags_cy;
        }
        elseif ($validated['locale'] === 'sr-Cyrl' || $validated['locale'] === 'cy') {
            $content_cy = $validated['content_cy'] ?? $validated['content'] ?? '';
            $tags_cy = !empty($validated['tags_cy']) ? array_map('trim', explode(',', $validated['tags_cy'])) : [];

            $content_lat = $lm->cyrillic_to_latin($content_cy);
            $tags_lat = array_map(fn($tag) => $lm->cyrillic_to_latin($tag), $tags_cy);

            $content_en = $translate->setSource('sr')->setTarget('en')->translate($content_lat);
            $tags_en = array_map(function ($tag) use ($translate) {
                return $translate->setSource('sr')->setTarget('en')->translate($tag);
            }, $tags_lat);

            $updateData['content_cy'] = $content_cy;
            $updateData['tags_cy'] = $tags_cy;
            $updateData['content'] = $content_lat;
            $updateData['tags'] = $tags_lat;
            $updateData['content_en'] = $content_en;
            $updateData['tags_en'] = $tags_en;
        }
        else { 
            $content_lat = $validated['content'] ?? '';
            $tags_lat = !empty($validated['tags']) ? array_map('trim', explode(',', $validated['tags'])) : [];

            $content_cy = $lm->latin_to_cyrillic($content_lat);
            $tags_cy = array_map(fn($tag) => $lm->latin_to_cyrillic($tag), $tags_lat);

            $content_en = $translate->setSource('sr')->setTarget('en')->translate($content_lat);
            $tags_en = array_map(function ($tag) use ($translate) {
                return $translate->setSource('sr')->setTarget('en')->translate($tag);
            }, $tags_lat);

            $updateData['content'] = $content_lat;
            $updateData['tags'] = $tags_lat;
            $updateData['content_cy'] = $content_cy;
            $updateData['tags_cy'] = $tags_cy;
            $updateData['content_en'] = $content_en;
            $updateData['tags_en'] = $tags_en;
        }

        if (!$news->extended) {
            $news->extended()->create([]);
            $news->refresh();
        }
        $news->extended->update($updateData);

        return redirect()->route('news.show', $news->id)
            ->with('success', 'Extended news updated successfully.');
    }

    public function uploadImage(Request $request, News $news)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $news->image_path = 'images/' . $filename;
            $news->save();
            return response()->json(['image_path' => asset($news->image_path)]);
        }
        return response()->json(['error' => 'No image uploaded'], 400);
    }
}