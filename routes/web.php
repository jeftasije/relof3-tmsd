<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LibraryDataController;
use App\Http\Controllers\ProcurementController;
use App\Http\Controllers\NavigationController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\OrganisationalStructureController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\HomepageController;
use App\Models\News;

Route::get('/', [HomepageController::class, 'showWelcome'])->name('welcome');

Route::get('/kontrolni-panel', function () {
    return view('superAdmin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::put('/zaposleni/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('/zaposleni/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
    Route::post('/zaposleni/{employee}/dodaj-sliku', [EmployeeController::class, 'uploadImage'])->name('employees.uploadImage');
    Route::post('/zaposleni', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/zaposleni/{employee}/izmeni', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('/zaposleni/{employee}/prosirena-biografija', [EmployeeController::class, 'updateExtendedBiography'])->name('employees.updateExtendedBiography');

    Route::get('/vesti', [NewsController::class, 'index'])->name('news.index');
    Route::get('/vesti/{news}', [NewsController::class, 'show'])->name('news.show');
    Route::post('/vesti', [NewsController::class, 'store'])->name('news.store');
    Route::put('/vesti/{news}', [NewsController::class, 'update'])->name('news.update');
    Route::delete('/vesti/{news}', [NewsController::class, 'destroy'])->name('news.destroy');
    Route::get('/vesti/kreiraj', [NewsController::class, 'create'])->name('news.create');
    Route::put('/vesti/{news}/prosirena', [NewsController::class, 'updateExtendedNews'])->name('news.updateExtendedNews');
    Route::post('/vesti/{news}/izmeni-sliku', [NewsController::class, 'uploadImage'])->name('news.uploadImage');
    Route::post('/zaposleni/{employee}/izmeni-sliku', [EmployeeController::class, 'uploadImage'])->name('employees.uploadImage');

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
    Route::patch('/podnozje/sr', [FooterController::class, 'editSr'])->name('footer.edit.sr');
    Route::patch('/podnozje/en', [FooterController::class, 'editEn'])->name('footer.edit.en');

    Route::patch('/navigacija/redosled', [NavigationController::class, 'saveOrder'])->name('navigation.save-order');
    Route::post('/navigacija', [NavigationController::class, 'store'])->name('navigation.store');
    Route::delete('/navigacija', [NavigationController::class, 'destroy'])->name('navigation.destroy');

    Route::get('/kontaktiranja', [ContactController::class, 'answer'])->name('contact.answer');

    Route::get('/pregled-zalbi', [ComplaintController::class, 'answerPage'])->name('complaints.answer');
  
    Route::post('/galerija/upload', [GalleryController::class, 'upload'])->name('gallery.upload');
    Route::delete('/galerija/{item}', [GalleryController::class, 'destroy'])->name('gallery.destroy');

    Route::get('/relof-indeks', function() {return view('relofIndex');})->name('relofIndex');

    Route::get('/podsetnici', [ReminderController::class, 'index'])->name('reminders.index');
    Route::post('/podsetnici', [ReminderController::class, 'store'])->name('reminders.store');
    Route::patch('/podsetnici/{id}/preimenuj', [ReminderController::class, 'update'])->name('reminders.edit');
    Route::delete('/podsetnici/{id}', [ReminderController::class, 'destroy'])->name('reminders.destroy');
    Route::get('/podsetnici/aktivni', [ReminderController::class, 'getActiveReminders']);
    Route::get('/podsetnici/aktivni/broj', [ReminderController::class, 'getActiveRemindersCount']);

    Route::get('/naslovna', [HomepageController::class, 'show'])->name('homePage.show');
    Route::post('/naslovna/sr', [HomepageController::class, 'updateSr'])->name('homepage.updateSr');
    Route::post('/naslovna/en', [HomepageController::class, 'updateEn'])->name('homepage.updateEn');
    Route::post('/naslovna/vesti/sr', [HomepageController::class, 'updateNewsSr'])->name('homepage.updateNewsSr');
    Route::post('/naslovna/vesti/en', [HomepageController::class, 'updateNewsEn'])->name('homepage.updateNewsEn');
    Route::post('/naslovna/kontakt/sr', [HomepageController::class, 'updateContactSr'])->name('homepage.updateContactSr');
    Route::post('/naslovna/kontakt/en', [HomepageController::class, 'updateContactEn'])->name('homepage.updateContactEn');
    Route::post('/naslovna/cobiss/sr', [HomepageController::class, 'updateCobissSr'])->name('homepage.updateCobissSr');
    Route::post('/naslovna/cobiss/en', [HomepageController::class, 'updateCobissEn'])->name('homepage.updateCobissEn');

    Route::post('/vidljivost-vesti', [HomepageController::class, 'toggleNewsVisibility'])->name('homepage.toggleNewsVisibility');
    Route::post('/vidljivost-kontakt', [HomepageController::class, 'toggleContactVisibility'])->name('homepage.toggleContactVisibility');
    Route::post('/vidljivost-cobiss', [HomepageController::class, 'toggleCobissVisibility'])->name('homepage.toggleCobissVisibility');

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

Route::post('/komentari', [CommentController::class, 'store'])->name('comments.store');

Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{news}', [NewsController::class, 'show'])->name('news.show');

Route::get('/nabavke', [ProcurementController::class, 'index'])->name('procurements.index');

Route::get('/dokumenti', [DocumentController::class, 'index'])->name('documents.index');

Route::get('/lang/{locale}', function ($locale) {
    if (!in_array($locale, ['sr', 'en', 'sr-Cyrl'])) {
        abort(400);
    }
    session(['locale' => $locale]);
    return redirect()->back();
})->name('lang.switch');

Route::get('/organizaciona-struktura', [OrganisationalStructureController::class, 'index'])->name('organisationalStructures.index');

Route::get('/search', [SearchController::class, 'index'])->name('search.index');
Route::get('/search-results', [SearchController::class, 'search'])->name('search.results');

Route::get('/galerija', [GalleryController::class, 'index'])->name('gallery.index');

Route::get('/istorijat', [HistoryController::class, 'show'])->name('history.show');
Route::post('/istorijat/izmena', [HistoryController::class, 'update'])->middleware('auth')->name('history.update');

Route::get('/galerija', [GalleryController::class, 'index'])->name('gallery.index');

require __DIR__.'/auth.php';
