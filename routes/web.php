<?php

use App\Livewire\Pi\PiList;
use Illuminate\Support\Facades\Route;


Route::view('/', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');


Route::prefix('pi')->name('pi.')->group(function () {
    Route::view('/', 'pages.pi.index')
        ->middleware(['auth'])
        ->name('list');
});
Route::prefix('lab')->name('lab.')->group(function () {
    Route::view('/', 'pages.lab.index')
        ->middleware(['auth'])
        ->name('list');
});
Route::prefix('student')->name('student.')->group(function () {
    Route::view('/', 'pages.student.index')
        ->middleware(['auth'])
        ->name('list');
});
Route::prefix('instrument')->name('instrument.')->group(function () {
    Route::view('/category', 'pages.instruments.category')
        ->middleware(['auth'])
        ->name('instrument-category');
    Route::view('/instrument', 'pages.instruments.instrument')
        ->middleware(['auth'])
        ->name('instrument');
});

Route::prefix('bookings')->name('bookings.')->group(function () {
    Route::view('/', 'pages.bookings.create')
        ->middleware(['auth'])
        ->name('create');
});

require __DIR__.'/auth.php';
