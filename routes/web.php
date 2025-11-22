<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\PropertyListing;
use App\Livewire\PropertyShow;
use App\Livewire\ContactForm;

Route::get('/', function () {
    return view('welcome');
});

Route::get('properties', PropertyListing::class)->name('properties.listing');

// Property details by slug (implicit binding via getRouteKeyName)
Route::get('properties/{property:slug}', PropertyShow::class)->name('properties.show');
Route::get('properties/{property:slug}/contact', ContactForm::class)->name('properties.contact');
