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
            'summary' => 'required|string|max:2000',
            'summary_en' => 'nullable|string|max:2000',
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
            'tags' => [],
            'tags_en' => [],
        ]);

        return redirect()->route('news.index')->with('success', 'Vest uspešno dodata!');
    }

    public function updateExtendedNews(Request $request, News $news)
    {
        $validated = $request->validate([
            'content' => 'nullable|string',
            'content_en' => 'nullable|string',
            'tags' => 'nullable|string',
            'tags_en' => 'nullable|string',
        ]);

        $updateData = [];

        if ($request->has('content')) {
            $updateData['content'] = $validated['content'];
        }
        if ($request->has('content_en')) {
            $updateData['content_en'] = $validated['content_en'];
        }
        if ($request->has('tags')) {
            $updateData['tags'] = $validated['tags'] ? array_map('trim', explode(',', $validated['tags'])) : [];
        }
        if ($request->has('tags_en')) {
            $updateData['tags_en'] = $validated['tags_en'] ? array_map('trim', explode(',', $validated['tags_en'])) : [];
        }

        if (!$news->extended) {
            $news->extended()->create([]);
            $news->refresh();
        }
        $news->extended->update($updateData);

        return redirect()->route('news.show', $news->id)
            ->with('success', 'Extended news updated successfully.');
    }

}