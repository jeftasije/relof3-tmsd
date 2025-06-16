<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Procurement;
use App\Models\OrganisationalStructure;
use App\Models\Navigation;
use App\Models\News;
use App\Models\Employee;
use App\Models\Document;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = trim($request->input('q'));

        if (!$query) {
            return redirect()->back()->with('error', 'Molimo unesite pojam za pretragu.');
        }

        $searchResults = [];

        $navigations = Navigation::where('name', 'like', "%{$query}%")->get();

        foreach ($navigations as $nav) {
            $route = $this->getRouteForNavigation($nav->name);

            if ($route) {
                $searchResults[] = [
                    'title' => $nav->name,
                    'description' => 'Saznajte opširnije',
                    'route' => $route,
                ];
            }
        }

        $procurements = Procurement::where('title', 'like', "%{$query}%")->get();

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

        $news = News::where('title', 'like', "%{$query}%")
            ->orWhere('summary', 'like', "%{$query}%")
            ->orWhere('image_path', 'like', "%{$query}%")
            ->orWhere('author', 'like', "%{$query}%")
            ->orWhereRaw('CAST(published_at AS CHAR) LIKE ?', ["%{$query}%"])
            ->get();

        foreach ($news as $item) {
            $searchResults[] = [
                'title' => $item->title,
                'description' => $item->summary ? substr($item->summary, 0, 100) . '...' : 'Pogledajte detalje vesti.',
                'route' => route('news.show', $item->id),
            ];
        }

        $employees = Employee::where('name', 'like', "%{$query}%")
            ->orWhere('position', 'like', "%{$query}%")
            ->orWhere('biography', 'like', "%{$query}%")
            ->get();

        foreach ($employees as $item) {
            $searchResults[] = [
                'title' => $item->name,
                'description' => $item->biography ? substr($item->biography, 0, 100) . '...' : 'Pročitajte detaljnije.',
                'route' => route('employees.show', $item->id),
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
            'Kontakt' => route('contact'),
            'Dokumenta' => route('documents.index'),
            'Organizaciona struktura' => route('organisationalStructures.index'),
            'Zaposleni' => route('employees.index'),
        ];

        return $routeMap[$name] ?? null;
    }
}