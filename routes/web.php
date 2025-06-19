<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LibraryDataController;
use App\Http\Controllers\ProcurementController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\OrganisationalStructureController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\FooterController;


Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/kontrolni-panel', function () {
    return view('superAdmin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::delete('dokumenti/{id}', [DocumentController::class, 'destroy'])->name('documents.delete');
    Route::patch('dokumenti/{id}', [DocumentController::class, 'edit'])->name('documents.edit');
    Route::post('dokumenti', [DocumentController::class, 'store'])->name('documents.store');

    Route::delete('/nabavke/{id}', [ProcurementController::class, 'destroy'])->name('procurements.delete');
    Route::patch('/nabavke/{id}', [ProcurementController::class, 'edit'])->name('procurements.edit');
    Route::post('/nabavke', [ProcurementController::class, 'store'])->name('procurements.store');

    Route::delete('/organizaciona-struktura/{id}', [OrganisationalStructureController::class, 'destroy'])->name('organisationalStructures.delete');
    Route::patch('/organizaciona-struktura/{id}', [OrganisationalStructureController::class, 'edit'])->name('organisationalStructures.edit');
    Route::post('/organizaciona-struktura', [OrganisationalStructureController::class, 'store'])->name('organisationalStructures.store');

    Route::get('/podnozje', [FooterController::class, 'show'])->name('footer.show');
    Route::patch('/podnozje', [FooterController::class, 'edit'])->name('footer.edit');
    Route::post('/footer/translate', [App\Http\Controllers\FooterController::class, 'translate'])->name('footer.translate');
});

Route::get('/usluge', function () {
    return view('user.services');
});

Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
Route::get('/employees/{employee}', [EmployeeController::class, 'show'])->name('employees.show');

Route::get('/kontakt', [ContactController::class, 'index'])->name('contact.index');
Route::post('/kontakt', [ContactController::class, 'store'])->name('contact.store');

Route::get('/zalbe', [ComplaintController::class, 'index'])->name('complaints.index');
Route::post('/zalbe', [ComplaintController::class, 'store'])->name('complaints.store');

Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{news}', [NewsController::class, 'show'])->name('news.show');

Route::get('/nabavke', [ProcurementController::class, 'index'])->name('procurements.index');

Route::get('/dokumenti', [DocumentController::class, 'index'])->name('documents.index');

Route::get('/lang/{locale}', function ($locale) {
    if (!in_array($locale, ['sr', 'en'])) {
        abort(400);
    }
    session(['locale' => $locale]);
    return redirect()->back();
})->name('lang.switch');

Route::get('/organizaciona-struktura', [OrganisationalStructureController::class, 'index'])->name('organisationalStructures.index');

Route::get('/search', [SearchController::class, 'index'])->name('search.index');
Route::get('/search-results', [SearchController::class, 'search'])->name('search.results');

require __DIR__.'/auth.php';

