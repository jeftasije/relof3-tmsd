<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Navigation;
use App\Models\Page;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        View::composer('layouts.header', function ($view) {
            $mainSections = Navigation::whereNull('parent_id')->orderBy('order')->get();
            $subSections = Navigation::whereNotNull('parent_id')->with('children')->get()->groupBy('parent_id');
            $view->with('mainSections', $mainSections);
            $view->with('subSections', $subSections);
        });

        View::composer('layouts.navigation', function ($view) {
            $mainSections = Navigation::whereNull('parent_id')->orderBy('order')->get();
            $subSections = Navigation::whereNotNull('parent_id')->with('children')->get()->groupBy('parent_id');
            $unfinishedPages = Page::where('is_active', false)->get();
            $finishedPages = Page::where('is_active', true)->get();
            $view->with('mainSections', $mainSections);
            $view->with('subSections', $subSections);
            $view->with('unfinishedPages', $unfinishedPages);
            $view->with('finishedPages', $finishedPages);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
