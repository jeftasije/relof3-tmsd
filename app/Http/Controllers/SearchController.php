<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Procurement;
use App\Models\OrganisationalStructure;
use App\Models\Navigation;
use App\Models\News;
use App\Models\Employee;
use App\Models\Document;
use App\Models\DocumentCategory;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    protected $languageMapper;

    public function __construct(LanguageMapperController $languageMapper)
    {
        $this->languageMapper = $languageMapper;
    }

    public function index(Request $request)
    {
        $query = trim($request->input('q'));

        $locale = app()->getLocale();
        $langPath = resource_path("lang/{$locale}.json");

        if (!$query) {
            return redirect()->back()->with('error', 'Molimo unesite pojam za pretragu.');
        }

        $searchResults = [];

        $navigations = Navigation::query()
        ->when($locale === 'en', function ($q) use ($query) {
            $q->where('name_en', 'like', "%{$query}%");
        })
        ->when($locale === 'sr', function ($q) use ($query) {
            $q->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            });
        })
        ->when($locale === 'sr-Cyrl', function ($q) use ($query) {
            $q->where(function ($q) use ($query) {
                $q->where('name_cy', 'like', "%{$query}%");
            });
        })
        ->get();


        foreach ($navigations as $nav) {
            $route = $this->getRouteForNavigation($nav->name); 

            $title = match ($locale) {
                'sr' => $nav->name,
                'sr-Cyrl' => $nav->name_cy,
                'en' => $nav->name_en,
                default => $nav->name,
            };

            if ($route) {
                $description = match (app()->getLocale()) {
                    'sr' => 'Saznajte opširnije',
                    'sr-Cyrl' => 'Сазнајте опширније',
                    'en' => 'Learn more',
                    default => 'Saznajte opširnije',
                };

                $searchResults[] = [
                    'title' => $title,
                    'description' => $description,
                    'route' => $route,
                ];
            }
        }

        $detectedScript = $this->languageMapper->detectScript($query);
        if ($detectedScript === 'cyrillic') {
            $queryLower = mb_strtolower($this->languageMapper->cyrillic_to_latin($query));
            $procurements = Procurement::where('title', 'like', "%{$queryLower}%")->get();
        } else {
            $procurements = Procurement::where('title', 'like', "%{$query}%")->get();
        }

        foreach ($procurements as $proc) {
            $fileUrl = $proc->file_path && file_exists(public_path('storage/' . $proc->file_path)) 
                ? asset('storage/' . $proc->file_path) 
                : null;

            if ($fileUrl) {
                $searchResults[] = [
                    'title' => $proc->title,
                    'description' => 'Preuzmite dokument.',
                    'route' => $fileUrl,
                ];
            } else {
                Log::warning("File not found for Procurement: {$proc->title}, path: {$proc->file_path}");
            }
        }

        $documents = Document::where('title', 'like', "%{$query}%")->get();

        if ($detectedScript === 'cyrillic') {
            $queryLower = mb_strtolower($this->languageMapper->cyrillic_to_latin($query));
            $documents = Document::where('title', 'like', "%{$queryLower}%")->get();
        } else {
            $documents = Document::where('title', 'like', "%{$query}%")->get();
        }
        
        foreach ($documents as $doc) {
            $fileUrl = $doc->file_path && file_exists(public_path('storage/' . $doc->file_path)) 
                ? asset('storage/' . $doc->file_path) 
                : null;

            if ($fileUrl) {
                $searchResults[] = [
                    'title' => $doc->title,
                    'description' => 'Preuzmite dokument.',
                    'route' => $fileUrl,
                ];
            } else {
                Log::warning("File not found for Procurement: {$doc->title}, path: {$doc->file_path}");
            }
        }

        $orgStructures = OrganisationalStructure::where('title', 'like', "%{$query}%")->get();

        foreach ($orgStructures as $org) {
            $searchResults[] = [
                'title' => $org->title,
                'description' => 'Preuzmite dokument.',
                'route' => route('organisationalStructures.index'),
            ];
        }

        $news = News::query()
        ->when($locale === 'en', function ($q) use ($query) {
            $q->where('title_en', 'like', "%{$query}%")
            ->orWhere('summary_en', 'like', "%{$query}%")
            ->orWhere('author_en', 'like', "%{$query}%");
        })
        ->when($locale === 'sr', function ($q) use ($query) {
            $q->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                ->orWhere('summary', 'like', "%{$query}%")
                ->orWhere('author', 'like', "%{$query}%");
            });
        })
        ->when($locale === 'sr-Cyrl', function ($q) use ($query) {
            $q->where(function ($q) use ($query) {
                $q->where('title_cy', 'like', "%{$query}%")
                ->orWhere('summary_cy', 'like', "%{$query}%")
                ->orWhere('author_cy', 'like', "%{$query}%");
            });
        })
        ->get();


        foreach ($news as $item) {
            $title = match ($locale) {
                'sr' => $item->title,
                'sr-Cyrl' => $item->title_cy,
                'en' => $item->title_en,
                default => $item->title,
            };

            $description = match ($locale) {
                'sr' => $item->summary,
                'sr-Cyrl' => $item->summary_cy,
                'en' => $item->summary_en,
                default => $item->summary,
            };

            $searchResults[] = [
                'title' => $title,
                'description' => $description ? substr($description, 0, 100) . '...' : 'Pogledajte detalje vesti.',
                'route' => route('news.show', $item->id),
            ];
        }

        $employees = Employee::query()
        ->when($locale === 'en', function ($q) use ($query) {
            $q->where('name_en', 'like', "%{$query}%")
            ->orWhere('position_en', 'like', "%{$query}%")
            ->orWhere('biography_en', 'like', "%{$query}%");
        })
        ->when($locale === 'sr', function ($q) use ($query) {
            $q->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                ->orWhere('position', 'like', "%{$query}%")
                ->orWhere('biography', 'like', "%{$query}%");
            });
        })
        ->when($locale === 'sr-Cyrl', function ($q) use ($query) {
            $q->where(function ($q) use ($query) {
                $q->where('name_cy', 'like', "%{$query}%")
                ->orWhere('position_cy', 'like', "%{$query}%")
                ->orWhere('biography_cy', 'like', "%{$query}%");
            });
        })
        ->get();

        foreach ($employees as $item) {
            $title = match ($locale) {
                'sr' => $item->name,
                'sr-Cyrl' => $item->name_cy,
                'en' => $item->name_en,
                default => $item->name,
            };

            $description = match ($locale) {
                'sr' => $item->biography,
                'sr-Cyrl' => $item->biography_cy,
                'en' => $item->biography_en,
                default => $item->summary,
            };

            $searchResults[] = [
                'title' => $title,
                'description' => $item->biography ? substr($item->biography, 0, 100) . '...' : 'Pročitajte detaljnije.',
                'route' => route('employees.show', $item->id),
            ];
        }

        if (file_exists($langPath)) {
            $translations = json_decode(file_get_contents($langPath), true);

            $galleryTitle = $translations["gallery.title"] ?? '';
            $galleryTitleLower = mb_strtolower($galleryTitle);

            $galleryDescription = $translations["gallery.title"] ?? '';
            $galleryDescriptionLower = mb_strtolower($galleryDescription);

            $queryLower = mb_strtolower($query);

            if (str_contains($galleryTitleLower, $queryLower) || str_contains($queryLower, $galleryTitleLower) ||
            str_contains($galleryDescriptionLower, $queryLower) || str_contains($queryLower, $galleryDescriptionLower)) {
                $searchResults[] = [
                    'title' => __('gallery.title'),
                    'description' => __('gallery.description'),
                    'route' => route('gallery.index'),
                ];
            }
        }

        if (file_exists($langPath)) {
            $translations = json_decode(file_get_contents($langPath), true);

            $historyTitle = $translations["history.title"] ?? '';
            $historyDescription = $translations["history.content"] ?? '';

            $historyTitleLower = mb_strtolower($historyTitle);
            $historyDescriptionLower = mb_strtolower($historyDescription);
            $queryLower = mb_strtolower($query);

            if (str_contains($historyTitleLower, $queryLower) || str_contains($queryLower, $historyTitleLower) || 
               str_contains($historyDescriptionLower, $queryLower) || str_contains($queryLower, $historyDescriptionLower)) {
                $searchResults[] = [
                    'title' => __('history.title'),
                    'description' => __('history.content') ? substr(__('history.content'), 0, 100) . '...' : 'Pročitajte detaljnije.',
                    'route' => route('history.show'),
                ];
            }
        }

        if (file_exists($langPath)) {
            $translations = json_decode(file_get_contents($langPath), true);

            $galleryTitle = $translations["gallery.title"] ?? '';
            $galleryTitleLower = mb_strtolower($galleryTitle);

            $galleryDescription = $translations["gallery.title"] ?? '';
            $galleryDescriptionLower = mb_strtolower($galleryDescription);

            $queryLower = mb_strtolower($query);

            if (str_contains($galleryTitleLower, $queryLower) || str_contains($queryLower, $galleryTitleLower) ||
            str_contains($galleryDescriptionLower, $queryLower) || str_contains($queryLower, $galleryDescriptionLower)) {
                $searchResults[] = [
                    'title' => __('gallery.title'),
                    'description' => __('gallery.description'),
                    'route' => route('gallery.index'),
                ];
            }
        }

        if (file_exists($langPath)) {
            $translations = json_decode(file_get_contents($langPath), true);

            $heroTitle = $translations['services']['hero_title'] ?? null;
            $heroSubtitle = $translations['services']['hero_subtitle'] ?? null;
            $mainText = $translations['services']['main_text'] ?? null;

            $queryLower = mb_strtolower($query);
            $heroTitleLower = mb_strtolower($heroTitle);
            $heroSubtitleLower = mb_strtolower($heroSubtitle);
            $mainTextLower = mb_strtolower($mainText);

            if (str_contains($heroTitleLower, $queryLower) || str_contains($queryLower, $heroTitleLower) ||
            str_contains($heroSubtitleLower, $queryLower) || str_contains($queryLower, $heroSubtitleLower) ||
            str_contains($mainTextLower, $queryLower) || str_contains($queryLower, $mainTextLower)) {
                $searchResults[] = [
                    'title' => $translations['services']['hero_title'],
                    'description' => $translations['services']['main_text'] ? substr($translations['services']['main_text'], 0, 100) . '...' : 'Pročitajte detaljnije.',
                    'route' => route('services.show'),
                ];
            }
        }

        $docCategory = DocumentCategory::query()
        ->when($locale === 'en', function ($q) use ($query) {
            $q->where('name_en', 'like', "%{$query}%");
        })
        ->when($locale === 'sr', function ($q) use ($query) {
            $q->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            });
        })
        ->when($locale === 'sr-Cyrl', function ($q) use ($query) {
            $q->where(function ($q) use ($query) {
                $q->where('name_cy', 'like', "%{$query}%");
            });
        })
        ->get();


        foreach ($docCategory as $item) {
            $title = match ($locale) {
                'sr' => $item->name,
                'sr-Cyrl' => $item->name_cy,
                'en' => $item->name_en,
                default => $item->name,
            };

            $description = match (app()->getLocale()) {
                'sr' => 'Saznajte opširnije',
                'sr-Cyrl' => 'Сазнајте опширније',
                'en' => 'Learn more',
                default => 'Saznajte opširnije',
            };

            $searchResults[] = [
                'title' => $title,
                'description' => $description,
                'route' => url('/dokumenti') . '?category=' . urlencode($item->name),
            ];
        }

        return view('searchResults', [
            'query' => $query,
            'searchResults' => $searchResults,
        ]);
    }

    private function getRouteForNavigation($name)
    {
        $routeMap = [
            'Vesti' => route('news.index'),
            'Usluge' => '/usluge',
            'Javne nabavke' => route('procurements.index'),
            'Kontakt' => route('contact.index'),
            'Dokumenta' => route('documents.index'),
            'Organizaciona struktura' => route('organisationalStructures.index'),
            'Zaposleni' => route('employees.index'),
        ];

        return $routeMap[$name] ?? null;
    }
}