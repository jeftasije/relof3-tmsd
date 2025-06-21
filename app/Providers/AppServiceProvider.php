<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Navigation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $locale = session('locale', config('app.locale'));
        if (in_array($locale, ['sr', 'en', 'sr-Cyrl'])) {
            app()->setLocale($locale);
        }

        View::composer('*', function ($view) {
            $data = \App\Http\Controllers\LibraryDataController::getLibraryData();
            $view->with('libraryData', $data);
        });

        view()->composer('*', function ($view) {
            $view->with('navigations', Navigation::whereNull('parent_id')->get());
        });
    }
}
