<?php

use Illuminate\Support\Facades\Route;

/* Route::get('/', function () {
    return view('welcome');
}); */

Auth::routes();

Route::get('/', App\Livewire\Public\Index::class)->name('homepage');
Route::get('/about', App\Livewire\Public\About::class)->name('about');
Route::get('/events', App\Livewire\Public\Events::class)->name('events');
Route::get('/wsf', App\Livewire\Public\Wsf::class)->name('wsf');
Route::get('/service-units', App\Livewire\Public\ServiceUnits::class)->name('service_units');
Route::get('/testimonies', App\Livewire\Public\Testimonies::class)->name('testimonies');
Route::get('/testimonies/create', App\Livewire\Public\CreateTestimony::class)->name('testimonies.create');
Route::get('/testimony/{id}', App\Livewire\Public\Testimony::class)->name('testimony');
Route::get('/giving', App\Livewire\Public\Giving::class)->name('giving');
Route::get('/contact', App\Livewire\Public\Contact::class)->name('contact');

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', \App\Livewire\Admin\Dashboard::class)->name('dashboard');
    Route::get('sunday-service', \App\Livewire\Admin\SundayService::class)->name('sunday_service');
    Route::get('events', \App\Livewire\Admin\Event::class)->name('events');
    Route::get('wsf', \App\Livewire\Admin\Wsf::class)->name('wsf');
    Route::get('testimonies', \App\Livewire\Admin\ManageTestimonies::class)->name('testimonies.manage');
    Route::get('testimonies/{id}', \App\Livewire\Admin\ViewTestimony::class)->name('testimonies.view');
    Route::get('contact-messages', \App\Livewire\Admin\ContactMessages::class)->name('contact_messages');
    Route::get('users', \App\Livewire\Admin\ManageUsers::class)->name('users.manage');
    Route::get('profile', \App\Livewire\Admin\MyProfile::class)->name('profile');
});
