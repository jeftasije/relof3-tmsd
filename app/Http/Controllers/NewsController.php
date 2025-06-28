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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'required|string|max:2000',
            'locale' => 'required|string'
        ]);

        if ($validated['locale'] === 'en') {
            $news->update([
                'title_en' => $validated['title'],
                'summary_en' => $validated['summary'],
            ]);
        } elseif ($validated['locale'] === 'sr-Cyrl' || $validated['locale'] === 'cy') {
            $news->update([
                'title_cy' => $validated['title'],
                'summary_cy' => $validated['summary'],
            ]);
        } else {
            $news->update([
                'title' => $validated['title'],
                'summary' => $validated['summary'],
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

        $locale = app()->getLocale();
        $title_src    = $validated['title'];
        $summary_src  = $validated['summary'];
        $author_src   = $validated['author'];

        $is_cyrillic = preg_match('/[\p{Cyrillic}]/u', $title_src);

        // Transliteration & Translation
        if ($locale === 'en') {
            $title_en = $title_src;
            $summary_en = $summary_src;
            $author_en = $author_src;

            $title_lat = $this->translate->setSource('en')->setTarget('sr')->translate($title_en);
            $summary_lat = $this->translate->setSource('en')->setTarget('sr')->translate($summary_en);
            $author_lat = $this->translate->setSource('en')->setTarget('sr')->translate($author_en);

            $title_cy = $this->languageMapper->latin_to_cyrillic($title_lat);
            $summary_cy = $this->languageMapper->latin_to_cyrillic($summary_lat);
            $author_cy = $this->languageMapper->latin_to_cyrillic($author_lat);

            $news = News::create([
                'title'       => $title_lat,
                'title_en'    => $title_en,
                'title_cy'    => $title_cy,
                'summary'     => $summary_lat,
                'summary_en'  => $summary_en,
                'summary_cy'  => $summary_cy,
                'image_path'  => $validated['image_path'] ?? null,
                'author'      => $author_lat,
                'author_en'   => $author_en,
                'author_cy'   => $author_cy,
                'published_at'=> $validated['published_at'] ?? null,
            ]);
        } elseif ($is_cyrillic) {
            $title_cy = $title_src;
            $summary_cy = $summary_src;
            $author_cy = $author_src;

            $title_lat = $this->languageMapper->cyrillic_to_latin($title_cy);
            $summary_lat = $this->languageMapper->cyrillic_to_latin($summary_cy);
            $author_lat = $this->languageMapper->cyrillic_to_latin($author_cy);

            $title_en = $this->translate->setSource('sr')->setTarget('en')->translate($title_lat);
            $summary_en = $this->translate->setSource('sr')->setTarget('en')->translate($summary_lat);
            $author_en = $this->translate->setSource('sr')->setTarget('en')->translate($author_lat);

            $news = News::create([
                'title'       => $title_lat,
                'title_en'    => $title_en,
                'title_cy'    => $title_cy,
                'summary'     => $summary_lat,
                'summary_en'  => $summary_en,
                'summary_cy'  => $summary_cy,
                'image_path'  => $validated['image_path'] ?? null,
                'author'      => $author_lat,
                'author_en'   => $author_en,
                'author_cy'   => $author_cy,
                'published_at'=> $validated['published_at'] ?? null,
            ]);
        } else {
            $title_lat = $title_src;
            $summary_lat = $summary_src;
            $author_lat = $author_src;

            $title_cy = $this->languageMapper->latin_to_cyrillic($title_lat);
            $summary_cy = $this->languageMapper->latin_to_cyrillic($summary_lat);
            $author_cy = $this->languageMapper->latin_to_cyrillic($author_lat);

            $title_en = $this->translate->setSource('sr')->setTarget('en')->translate($title_lat);
            $summary_en = $this->translate->setSource('sr')->setTarget('en')->translate($summary_lat);
            $author_en = $this->translate->setSource('sr')->setTarget('en')->translate($author_lat);

            $news = News::create([
                'title'       => $title_lat,
                'title_en'    => $title_en,
                'title_cy'    => $title_cy,
                'summary'     => $summary_lat,
                'summary_en'  => $summary_en,
                'summary_cy'  => $summary_cy,
                'image_path'  => $validated['image_path'] ?? null,
                'author'      => $author_lat,
                'author_en'   => $author_en,
                'author_cy'   => $author_cy,
                'published_at'=> $validated['published_at'] ?? null,
            ]);
        }

        // EXTENDED NEWS
        $content_src = $request->input('content', '');
        $tags_src = $request->input('tags', '');
        $tags_arr = array_filter(array_map('trim', preg_split('/[,;]+/', $tags_src)));

        if ($locale === 'en') {
            $content_en = $content_src;
            $tags_en = $tags_arr;

            $content_lat = $this->translate->setSource('en')->setTarget('sr')->translate($content_en);
            $tags_lat = array_map(function ($tag) {
                return $this->translate->setSource('en')->setTarget('sr')->translate($tag);
            }, $tags_en);

            $content_cy = $this->languageMapper->latin_to_cyrillic($content_lat);
            $tags_cy = array_map(fn($tag) => $this->languageMapper->latin_to_cyrillic($tag), $tags_lat);

            $news->extended()->create([
                'content'    => $content_lat,
                'content_en' => $content_en,
                'content_cy' => $content_cy,
                'tags'       => $tags_lat,
                'tags_en'    => $tags_en,
                'tags_cy'    => $tags_cy,
            ]);
        } elseif ($is_cyrillic) {
            $content_cy = $content_src;
            $tags_cy = array_map('trim', preg_split('/[,;]+/', $tags_src));

            $content_lat = $this->languageMapper->cyrillic_to_latin($content_cy);
            $tags_lat = array_map(function ($tag) {
                return $this->languageMapper->cyrillic_to_latin($tag);
            }, $tags_cy);

            $content_en = $this->translate->setSource('sr')->setTarget('en')->translate($content_lat);
            $tags_en = array_map(function ($tag) {
                return $this->translate->setSource('sr')->setTarget('en')->translate($tag);
            }, $tags_lat);

            $news->extended()->create([
                'content'    => $content_lat,
                'content_en' => $content_en,
                'content_cy' => $content_cy,
                'tags'       => $tags_lat,
                'tags_en'    => $tags_en,
                'tags_cy'    => $tags_cy,
            ]);
        } else {
            $content_lat = $content_src;
            $tags_lat = $tags_arr;

            $content_cy = $this->languageMapper->latin_to_cyrillic($content_lat);
            $tags_cy = array_map(fn($tag) => $this->languageMapper->latin_to_cyrillic($tag), $tags_lat);

            $content_en = $this->translate->setSource('sr')->setTarget('en')->translate($content_lat);
            $tags_en = array_map(function ($tag) {
                return $this->translate->setSource('sr')->setTarget('en')->translate($tag);
            }, $tags_lat);

            $news->extended()->create([
                'content'    => $content_lat,
                'content_en' => $content_en,
                'content_cy' => $content_cy,
                'tags'       => $tags_lat,
                'tags_en'    => $tags_en,
                'tags_cy'    => $tags_cy,
            ]);
        }

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

            $content_lat = $translate->setSource('en')->setTarget('sr')->translate($content_en);
            $tags_lat = array_map(function ($tag) use ($translate) {
                return $translate->setSource('en')->setTarget('sr')->translate($tag);
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