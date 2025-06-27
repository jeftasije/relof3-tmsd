<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Navigation;
use Illuminate\Support\Str;
use Stichoza\GoogleTranslate\GoogleTranslate;
use App\Http\Controllers\LanguageMapperController;

use DOMDocument;
use DOMXPath;



class PageController extends Controller
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
            'content' => $page->translate('content')
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


        $originalTitle = $request->title;
        $detectedScript = $this->languageMapper->detectScript($originalTitle);
        if ($detectedScript === 'cyrillic') {                                                            //input in serbian cyrillic
            $page_titleCyr = $originalTitle;
            $page_titleLat = $this->languageMapper->cyrillic_to_latin($page_titleCyr);
            $page_titleEn = $this->translate->setSource('sr')->setTarget('en')->translate($originalTitle);
        } else {
            $toSr = $this->translate->setSource('en')->setTarget('sr')->translate($originalTitle);
            $toSrLatin = $this->languageMapper->cyrillic_to_latin($toSr);

            if (mb_strtolower($toSrLatin) === mb_strtolower($originalTitle)) {                              //input in serbian latin
                $page_titleCyr = $this->languageMapper->latin_to_cyrillic($originalTitle);
                $page_titleLat = $originalTitle;
                $page_titleEn = $this->translate->setSource('sr')->setTarget('en')->translate($originalTitle);
            } else {
                $page_titleEn = $originalTitle;
                $page_titleCyr = $this->translate->setSource('en')->setTarget('sr')->translate($originalTitle);
                $page_titleLat = $this->languageMapper->cyrillic_to_latin($page_titleCyr);
            }
        }
        if ($request->query('slug'))
            $page = Page::where('slug', $request->query('slug'))->firstOrFail();
        $plainTextForTranslation = isset($data['text']) ? strip_tags($data['text']) : '';
        $title = $data['title'];
        $language = $request->get('language-radio-button');
        $detectedScript = $this->languageMapper->detectScript($title);
        if ($language === 'sr') {
            if ($detectedScript === 'cyrillic') {
                if ($title !== null) {
                    $titleCy = $title;
                    $titleLat = $this->languageMapper->cyrillic_to_latin($title);
                    $titleEn = $this->translate->setSource('sr')->setTarget('en')->translate($title);
                }
                if ($plainTextForTranslation !== null) {
                    $textCy = $plainTextForTranslation;
                    $textLat = $this->translateWithHtmlPreserved($data['text'], 'sr-cyr', 'sr-lat');
                    $textEn = $this->translateWithHtmlPreserved($data['text'], 'sr', 'en');
                }
            } else {
                if ($title !== null) {
                    $titleLat = $title;
                    $titleCy = $this->languageMapper->latin_to_cyrillic($title);
                    $titleEn = $this->translate->setSource('sr')->setTarget('en')->translate($title);
                }
                if ($plainTextForTranslation !== null) {
                    $textLat = $plainTextForTranslation;
                    $textEn = $this->translateWithHtmlPreserved($data['text'], 'sr', 'en');
                    $textCy = $this->translateWithHtmlPreserved($data['text'], 'sr-lat', 'sr-cyr');
                }
            }
            $content = $data;
            $content['title'] = $titleLat;
            $content['text'] = $textLat;

            $content_en = $data;
            $content_en['title'] = $titleEn;
            $content_en['text'] = $textEn;

            $content_cy = $data;
            $content_cy['title'] = $titleCy;
            $content_cy['text'] = $textCy;

            if ($request->query('slug')) {
                $page->update([
                    'title'     => $page_titleLat,
                    'title_cy'     => $page_titleCyr,
                    'title_en'     => $page_titleEn,
                    'content'   => $content,
                    'content_en'   => $content_en,
                    'content_cy'   => $content_cy,
                ]);
            }
        } else {
            $content_en = $data;
            if ($request->query('slug')) {
                $page->update([
                    'title_en'     => $request->title,
                    'content_en'   => $content_en
                ]);
            }
        }

        $oldSlug = null;
        if ($request->query('slug')) {
            $page = Page::where('slug', $request->query('slug'))->firstOrFail();
            $oldSlug = $page->slug;
            $page->update([
                'slug'      => Str::slug($request->slug),
                'is_active' => $page->is_active ? true : ($request->action === 'publish'),
            ]);
        } else {
            $page = Page::create([
                'template_id' => $request->template_id,
                'title'       => $page_titleLat,
                'title_cy'       => $page_titleCyr,
                'title_en'       => $page_titleEn,
                'slug'        => Str::slug($request->slug),
                'content'     => $content,
                'content_en'   => $content_en,
                'content_cy'   => $content_cy,
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

    private function translateWithHtmlPreserved($html, $sourceLang, $targetLang)
    {
        if (empty($html)) {
            return '';
        }

        $html = mb_convert_encoding($html, 'UTF-8', 'auto');

        $doc = new DOMDocument();
        $wrappedHtml = '<div>' . $html . '</div>';
        if (@$doc->loadHTML('<?xml encoding="UTF-8">' . $wrappedHtml, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD)) {
            $xpath = new DOMXPath($doc);
            $textNodes = $xpath->query('//text()[normalize-space(.)]');

            foreach ($textNodes as $node) {
                $text = trim($node->nodeValue);
                if ($text !== '') {
                    if (in_array($sourceLang, ['sr-cyr', 'sr-lat']) && in_array($targetLang, ['sr-cyr', 'sr-lat'])) {
                        $processedText = $sourceLang === 'sr-cyr'
                            ? $this->languageMapper->cyrillic_to_latin($text)
                            : $this->languageMapper->latin_to_cyrillic($text);
                    } else {
                        $processedText = $this->translate->setSource($sourceLang)->setTarget($targetLang)->translate($text);
                    }
                    $node->nodeValue = $processedText;
                }
            }

            $body = $doc->getElementsByTagName('div')->item(0);
            $result = '';
            foreach ($body->childNodes as $child) {
                $result .= $doc->saveHTML($child);
            }
            return $result;
        }

        $plainText = strip_tags($html);
        $processedText = in_array($sourceLang, ['sr-cyr', 'sr-lat']) && in_array($targetLang, ['sr-cyr', 'sr-lat'])
            ? ($sourceLang === 'sr-cyr'
                ? $this->languageMapper->cyrillic_to_latin($plainText)
                : $this->languageMapper->latin_to_cyrillic($plainText))
            : $this->translate->setSource($sourceLang)->setTarget($targetLang)->translate($plainText);

        $patterns = [
            '/<div>(.*?)<\/div>/i' => '<div>%s</div>',
            '/<strong>(.*?)<\/strong>/i' => '<strong>%s</strong>',
            '/<em>(.*?)<\/em>/i' => '<em>%s</em>',
            '/<p>(.*?)<\/p>/i' => '<p>%s</p>',
            '/<br\s*\/?>/i' => '<br>',
        ];
        $result = $html;
        foreach ($patterns as $pattern => $replacement) {
            if (preg_match($pattern, $html)) {
                $result = preg_replace($pattern, sprintf($replacement, $processedText), $html);
                break;
            }
        }
        return $result ?: $processedText;
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

    //This is edit for super admin
    public function edit(Request $request, string $slug)
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
                'title'          => $page->translate('title'),
                'slug'           => $page->slug,
                'isDraft'        => true,
            ]);
        }
        $isEnglish = $request->query('en') === 'true';
        if ($isEnglish) {
            $viewData = [
                'templateId'     => $page->template_id,
                'mainSections'   => $mainSections,
                'subSections'    => $subSections,
                'currentSection' => $currentSection,
                'parentSection'  => $parentSection,
                'page'           => $page,
                'content'        => $page->content_en, true,
                'title'          => $page->title_en,
                'slug'           => $page->slug,
                'isDraft'        => true,
            ];
            return view('superAdmin.pagesCreate', $viewData);
        }

        return view('superAdmin.pagesCreate', [
            'templateId'     => $page->template_id,
            'mainSections'   => $mainSections,
            'subSections'    => $subSections,
            'currentSection' => $currentSection,
            'parentSection'  => $parentSection,
            'page'           => $page,
            'content'        => $page->translate('content'),
            'title'          => $page->translate('title'),
            'slug'           => $page->slug,
            'isDraft'        => true,
        ]);
    }

    //this is edit for editor
    public function update(Request $request, string $slug)
    {
        $request->validate([
            'content'     => 'nullable|array',
            'content_en'     => 'nullable|array',
        ]);
        $page = Page::where('slug', $slug)->firstOrFail();

        $content    = $page->content;
        $content_en = $page->content_en;
        $content_cy = $page->content_cy;

        $language = $request->get('language');
        $data = $request->input('content');
        if ($language === 'sr') {
            $detectedScript = $this->languageMapper->detectScript($request->content['text']);
            $plainTextForTranslation = isset($data['text']) ? strip_tags($data['text']) : '';
            if ($detectedScript === 'cyrillic') {
                if ($plainTextForTranslation !== null) {
                    $textCy = $plainTextForTranslation;
                    $textLat = $this->translateWithHtmlPreserved($data['text'], 'sr-cyr', 'sr-lat');
                    $textEn = $this->translateWithHtmlPreserved($data['text'], 'sr', 'en');
                }
            } else {
                if ($plainTextForTranslation !== null) {
                    $textLat = $plainTextForTranslation;
                    $textEn = $this->translateWithHtmlPreserved($data['text'], 'sr', 'en');
                    $textCy = $this->translateWithHtmlPreserved($data['text'], 'sr-lat', 'sr-cyr');
                }
            }
            $content['text']    = $textLat;
            $content_en['text'] = $textEn;
            $content_cy['text'] = $textCy;
        } else {
            $content_en['text'] = $request->content_en['text'];
        }

        if ($slug) {
            $page->update([
                'content'     => $content,
                'content_en'  => $content_en,
                'content_cy'  => $content_cy,
            ]);
            return redirect()->back()->with('success', 'Page saved');
        }
    }
}
