<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Navigation;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Log;


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

    public function create(Request $request)
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
            'templateId'   => $templateId,
            'mainSections' => $mainSections,
            'subSections'  => $subSections,
            'title'        => '',
            'slug'         => '',
            'currentSection' => null,
            'parentSection'  => null,
            'content'      => [],
            'isDraft'      => false,
        ]);
    }

    public function store(Request $request)
    {
        $slugRule = 'required|alpha_dash|unique:pages,slug';
        if ($request->query('slug')) {
            $pageForSlug = Page::where('slug', $request->query('slug'))->firstOrFail();
            $slugRule = "required|alpha_dash|unique:pages,slug,{$pageForSlug->id}";
        }

        $request->validate([
            'template_id' => 'required|exists:templates,id',
            'title'       => 'required|string|max:255',
            'slug'        => $slugRule,
            'navigation'  => 'array',
            'content'     => 'required|array',
        ]);

        $data = $request->input('content');
        foreach ($request->file('content', []) as $k => $f) {
            $data[$k] = $f->store('uploads', 'public');
        }

        if ($request->query('slug')) {
            $page = Page::where('slug', $request->query('slug'))
                ->where('is_active', false)
                ->firstOrFail();
            $page->update([
                'title'     => $request->title,
                'slug'      => Str::slug($request->slug),
                'content'   => json_encode($data),
                'is_active' => $request->action === 'publish',
            ]);
        } else {
            $page = Page::create([
                'template_id' => $request->template_id,
                'title'       => $request->title,
                'slug'        => Str::slug($request->slug),
                'content'     => json_encode($data),
                'is_active'   => $request->action === 'publish',
            ]);
        }

        if ($request->has('navigation')) {
            $navigationIds = $request->navigation;
            if ($navigationIds[1] !== null) {
                $subSectionId = $navigationIds[1];

                $existingNav = Navigation::where('redirect_url', '/stranica/' . $page->slug)->first();

                if ($existingNav) {
                    $existingNav->update([
                        'parent_id' => $subSectionId,
                        'name' => $page->title,
                        'is_active' => $request->action === 'publish',
                    ]);
                } else {
                    $newNavigation = new Navigation();
                    $newNavigation->parent_id = $subSectionId;
                    $newNavigation->name = $page->title;
                    $newNavigation->redirect_url = '/stranica/' . $page->slug;
                    $newNavigation->is_active = $request->action === 'publish';
                    $newNavigation->save();
                }
            } else {
                $mainSectionId = $navigationIds[0];
                $mainSection = Navigation::find($mainSectionId);

                if ($mainSection) {
                    $mainSection->update([
                        $mainSection->redirect_url = '/stranica/' . $page->slug,
                        $mainSection->is_active = $request->action === 'publish',
                    ]);   
                }
            }
        }


        if ($request->action === 'draft') {
            return redirect()
                ->route('page.edit', ['slug' => $page->slug, 'sablon' => $page->template_id])
                ->withInput()
                ->with('status', 'Draft saved.');
        }

        return redirect()->route('page.show', $page->slug);
    }

    public function destroy(Request $request)
    {
        $ids = $request->input('ids', []);

        if (!is_array($ids) || empty($ids)) {
            return response()->json([
                'success' => false,
                'message' => 'No IDs provided.'
            ], 422);
        }

        $pages = Page::whereIn('id', $ids)->get();

        foreach ($pages as $page) {
            Navigation::where('redirect_url', '/stranica/' . $page->slug)
                ->delete();
        }

        Page::whereIn('id', $ids)->delete();


        return response()->json(['success' => true]);
    }

    public function edit(string $slug)
    {
        $page = Page::where('slug', $slug)
            ->where('is_active', false)
            ->firstOrFail();

        $mainSections = Navigation::whereNull('parent_id')->orderBy('order')->get();
        $subSections  = Navigation::whereNotNull('parent_id')
            ->whereNull('redirect_url')
            ->get()
            ->groupBy('parent_id');


        $link = Navigation::where('redirect_url', '/stranica/' . $page->slug)->first();
        $currentSection = null;
        $parentSection  = null;

        if ($link) {
            if ($link->parent_id) {
                $currentSection = Navigation::find($link->parent_id);

                $parentSection = $currentSection->parent_id
                    ? Navigation::find($currentSection->parent_id)
                    : null;
            }
        }

        return view('superAdmin.pagesCreate', [
            'templateId'     => $page->template_id,
            'mainSections'   => $mainSections,
            'subSections'    => $subSections,
            'currentSection' => $currentSection,
            'parentSection'  => $parentSection,
            'page'           => $page,
            'content'        => json_decode($page->content, true),
            'title'          => $page->title,
            'slug'           => $page->slug,
            'isDraft'        => true,
        ]);
    }
}
