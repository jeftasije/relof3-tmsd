<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Navigation;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        View::composer('layouts.header', function ($view) {
            $mainSections = Navigation::whereNull('parent_id')->orderBy('id')->get();
            $subSections = Navigation::whereNotNull('parent_id')->with('children')->get()->groupBy('parent_id');
            $view->with('mainSections', $mainSections);
            $view->with('subSections', $subSections);
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
