<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::all();
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
            'title_en' => 'nullable|string|max:255',
            'title_cy' => 'nullable|string|max:255',
            'summary' => 'required|string|max:2000',
            'summary_en' => 'nullable|string|max:2000',
            'summary_cy' => 'nullable|string|max:2000',
            'author' => 'required|string|max:255',
            'published_at' => 'nullable|date',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $validated['image_path'] = 'images/' . $filename;
        }

        $news = News::create($validated);

        \App\Models\ExtendedNews::create([
            'news_id' => $news->id,
            'content' => '',
            'content_en' => '',
            'content_cy' => '',
            'tags' => [],
            'tags_en' => [],
            'tags_cy' => [],
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

        $updateData = [];

        // Odredi koja verzija se menja na osnovu locale
        if ($validated['locale'] === 'en') {
            $updateData['content_en'] = $validated['content_en'] ?? $validated['content'] ?? '';
            $updateData['tags_en'] = !empty($validated['tags_en']) ? array_map('trim', explode(',', $validated['tags_en'])) : [];
        } elseif ($validated['locale'] === 'sr-Cyrl' || $validated['locale'] === 'cy') {
            $updateData['content_cy'] = $validated['content_cy'] ?? $validated['content'] ?? '';
            $updateData['tags_cy'] = !empty($validated['tags_cy']) ? array_map('trim', explode(',', $validated['tags_cy'])) : [];
        } else {
            $updateData['content'] = $validated['content'] ?? '';
            $updateData['tags'] = !empty($validated['tags']) ? array_map('trim', explode(',', $validated['tags'])) : [];
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