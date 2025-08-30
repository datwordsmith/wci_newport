<?php

use Illuminate\Support\Facades\Route;

/* Route::get('/', function () {
    return view('welcome');
}); */

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', App\Livewire\Public\Index::class)->name('homepage');
Route::get('/about', App\Livewire\Public\About::class)->name('about');
Route::get('/wsf', App\Livewire\Public\Wsf::class)->name('wsf');
Route::get('/service-units', App\Livewire\Public\ServiceUnits::class)->name('service_units');
Route::get('/testimonies', App\Livewire\Public\Testimonies::class)->name('testimonies');
Route::get('/contact', App\Livewire\Public\Contact::class)->name('contact');

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', \App\Livewire\Admin\Dashboard::class)->name('dashboard');
    Route::get('sunday-service', \App\Livewire\Admin\SundayService::class)->name('sunday_service');
});
