<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Navigation;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function show($slug)
    {
        $page = Page::where('slug', $slug)->where('is_active', true)->firstOrFail();

        return view('templates.template' . $page->template_id, [
            'page' => $page,
            'content' => json_decode($page->content, true),
        ]);
    }

    public function builder(Request $request)
    {
        $templateId = $request->query('sablon');
        $mainSections = Navigation::whereNull('parent_id')
            ->orderBy('order')
            ->get();

        $subSections = Navigation::whereNotNull('parent_id')
            ->whereNull('redirect_url')
            ->get()
            ->groupBy('parent_id');

        return view('superAdmin.pagesCreate', [
            'templateId' => $templateId,
            'mainSections' => $mainSections,
            'subSections' => $subSections,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'template_id' => 'required|exists:templates,id',
            'title'  => 'required|string',
            'slug'        => 'required|alpha_dash|unique:pages,slug',
            'navigation'  => 'array',
            'content'     => 'required|array',
        ]);

        $data = $request->input('content');
        foreach ($request->file('content', []) as $k => $f) {
            $data[$k] = $f->store('uploads', 'public');
        }

        $page = Page::create([
            'template_id' => $request->template_id,
            'title'  => $request->title,
            'slug'        => Str::slug($request->slug),
            'content'     => json_encode($data),
            'is_active'   => $request->action === 'publish',
        ]);

        if ($request->has('navigation')) {
            $navigationIds = $request->navigation;

            if (count($navigationIds) > 1) {
                $subSectionId = $navigationIds[1];

                $newNavigation = new Navigation();
                $newNavigation->parent_id = $subSectionId;
                $newNavigation->name = $page->title;
                $newNavigation->redirect_url = '/stranica' . $page->slug;
                $newNavigation->save();

            } else {
                $mainSectionId = $navigationIds[0];
                $mainSection = Navigation::find($mainSectionId);
                if ($mainSection) {
                    $mainSection->redirect_url = '/' . $page->slug;
                    $mainSection->save();
                }
            }
        }

        return redirect()->route('page.show', $page->slug);
    }
}
