<?php

use App\Http\Controllers\InquiryController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/living-options', [PageController::class, 'livingOptions'])->name('living-options');
Route::get('/memory-care', [PageController::class, 'memoryCare'])->name('memory-care');
Route::get('/respite-care', [PageController::class, 'respiteCare'])->name('respite-care');
Route::get('/suites-and-floor-plans', [PageController::class, 'suitesFloorPlans'])->name('suites-and-floor-plans');
Route::get('/life-at-mission-villa', [PageController::class, 'lifeAtMissionVilla'])->name('life-at-mission-villa');
Route::get('/services-and-amenities', [PageController::class, 'servicesAmenities'])->name('services-and-amenities');

// Shared inquiry form: Schedule a Visit · Request Pricing · Request a Call (CSRF via the web group).
Route::post('/inquiries', [InquiryController::class, 'store'])
    ->middleware('throttle:inquiries')
    ->name('inquiries.store');

// Internal pages are added here as each one is approved and implemented in PHP.
