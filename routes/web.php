<?php

use App\Livewire\Pi\PiList;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    $user = Auth::user();

    if ($user->hasRole('super_admin')) {
        return view('dashboard');
    } elseif ($user->hasRole('pi')) {
        return view('piDashboard');
    } elseif ($user->hasRole('student')) {
        return view('studentDashboard');
    }

    return redirect('/login'); // Default redirect if no role matches
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');


Route::prefix('pi')->name('pi.')->group(function () {
    Route::view('/', 'pages.pi.index')
        ->middleware(['auth'])
        ->middleware( 'can:create pi')
        ->name('list');
});
Route::prefix('lab')->name('lab.')->group(function () {
    Route::view('/', 'pages.lab.index')
        ->middleware(['auth'])
        ->middleware('can:create lab')
        ->name('list');
});
Route::prefix('student')->name('student.')->group(function () {
    Route::view('/', 'pages.student.index')
        ->middleware(['auth'])
        ->middleware( 'can:create student')
        ->name('list');
});

Route::prefix('instrument')->name('instrument.')->group(function () {

    Route::view('/category', 'pages.instruments.category')
        ->middleware(['auth'])
        ->middleware( 'can:create instrumentCategory')
        ->name('instrument-category');

    Route::view('/instrument', 'pages.instruments.instrument')
        ->middleware(['auth'])
        ->middleware( 'can:view instrument')
        ->name('instrument');

    Route::view('/complaint', 'pages.instruments.complaint')
        ->middleware(['auth'])
        ->middleware( 'can:view instrument complaint')
        ->name('complaints');

//    Route::view('/service', 'pages.instruments.services')
//        ->middleware(['auth'])
//        ->middleware( 'can:view instrument services')
//        ->name('service');
    Route::view('/service', 'pages.instruments.services')
        ->middleware(['auth'])
        ->name('service');
});

Route::prefix('bookings')->name('bookings.')->group(function () {
    Route::view('/', 'pages.bookings.create')
        ->middleware(['auth'])
        ->name('create');
});

require __DIR__.'/auth.php';
