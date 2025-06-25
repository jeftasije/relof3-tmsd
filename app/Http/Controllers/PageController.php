<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Page;
use App\Models\Navigation;
use Illuminate\Support\Str;


class PageController extends Controller
{
    protected array $controllerMap = [
        'vesti' => [NewsController::class, 'index'],
        'zalbe' => [ComplaintController::class, 'index'],
        'dokumenti' => [DocumentController::class, 'index'],
        'zaposleni' => [EmployeeController::class, 'index'],
        'organizaciona-struktura' => [OrganisationalStructureController::class, 'index'],
        'nabavke' => [ProcurementController::class, 'index'],
    ];

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
            'template_id' => 'nullable|exists:templates,id',
            'title'       => 'required|string|max:255',
            'slug'        => $slugRule,
            'navigation.0' => 'required|exists:navigations,id', // main
            'navigation.1' => 'nullable|exists:navigations,id', // sub
            'content'     => 'nullable|array',
        ], [
            'title.required' => __('title_required'),
            'slug.required' => __('page_slug_required'),
            'slug.unique' => __('page_slug_unique'),
            'slug.alpha_dash' => __('page_slug_alpha_dash'),
            'navigation.0.required' => __('page_navigation_main_required'),
            'navigation.0.exists' => __('page_navigation_main_exists'),
            'navigation.1.exists' => __('page_navigation_sub_exists'),
        ]);

        if ($request->has('navigation')) {
            $navigationIds = $request->navigation;
            $mainSectionId = $navigationIds[0];
            $mainSection = Navigation::find($mainSectionId);
            if ($mainSection->children()->count() !== 0 &&  $navigationIds[1] === null) {
                return back()
                    ->withErrors(['navigation.1' => __('subsection_required')])
                    ->withInput();
            }
        }
        if ($request->query('slug')) {
            $page = Page::where('slug', $request->query('slug'))->firstOrFail();
            if ($page && !$page->is_deletable && $navigationIds[1] !== null) {
                $subNavigationId = $navigationIds[1];
                $subNavigation = Navigation::find($subNavigationId);
                $existingNav = Navigation::where('redirect_url', '/' .  $page->slug)->first();
                if ($existingNav->parent_id !== $subNavigation->id) {
                    $existingNav->parent_id = $subNavigation->id;
                    $existingNav->save();
                }
                return redirect()->back()->with('success', 'Page saved');
            }
        }

        $data = $request->input('content');
        
        if (
            !isset($request->file('content')['image']) &&
            isset($data['image_existing']) &&
            !isset($data['image'])
        ) {
            $data['image'] = $data['image_existing'];
        }
        unset($data['image_existing']);

        foreach ($request->file('content', []) as $k => $f) {
            $data[$k] = $f->store('uploads', 'public');
        }

        $oldSlug = null;
        if ($request->query('slug')) {
            $page = Page::where('slug', $request->query('slug'))->firstOrFail();
            $oldSlug = $page->slug;
            $page->update([
                'title'     => $request->title,
                'slug'      => Str::slug($request->slug),
                'content'   => json_encode($data),
                'is_active' => $page->is_active ? true : ($request->action === 'publish'),
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

                $existingNav = Navigation::where('redirect_url', '/stranica/' . ($oldSlug ?? $page->slug))->first();

                if ($existingNav) {
                    $existingNav->update([
                        'parent_id' => $subSectionId,
                        'name' => $page->title,
                        'is_active' => $page->is_active ? true : ($request->action === 'publish'),
                        'redirect_url' => '/stranica/' . $page->slug
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

    public function destroy($id)
    {
        if (!$id) {
            return response()->json([
                'success' => false,
                'message' => 'No ID provided.'
            ], 422);
        }

        $page = Page::find($id);

        if (!$page) {
            return response()->json([
                'success' => false,
                'message' => 'Page not found.'
            ], 404);
        }
        if ($page->is_deletable) {
            Navigation::where('redirect_url', '/stranica/' . $page->slug)->delete();
            $page->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }

    public function edit(string $slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        $mainSections = Navigation::whereNull('parent_id')->orderBy('order')->get();
        $subSections  = Navigation::whereNotNull('parent_id')
            ->whereNull('redirect_url')
            ->get()
            ->groupBy('parent_id');


        $link = Navigation::where('redirect_url', '/stranica/' . $page->slug)
            ->orWhere('redirect_url', '/' . $page->slug)
            ->first();
        $currentSection = null;
        $parentSection  = null;

        if ($link) {
            if ($link->parent_id) {
                $currentSection = Navigation::find($link->parent_id);

                $parentSection = $currentSection->parent_id
                    ? Navigation::find($currentSection->parent_id)
                    : null;
            } else {
                $currentSection = $link;
            }
        }
        if (!$page->is_deletable) {
            [$controllerClass, $method] = $this->controllerMap[$page->slug] ?? [null, null];
            $controllerInstance = app($controllerClass);
            $response = app()->call([$controllerInstance, $method]);
            $basePageContent = $response->render();

            return view('superAdmin.pagesCreate', [
                'templateId'     => $page->template_id,
                'mainSections'   => $mainSections,
                'subSections'    => $subSections,
                'currentSection' => $currentSection,
                'parentSection'  => $parentSection,
                'page'           => $page,
                'basePageContent' => $basePageContent,
                'title'          => $page->title,
                'slug'           => $page->slug,
                'isDraft'        => true,
            ]);
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
