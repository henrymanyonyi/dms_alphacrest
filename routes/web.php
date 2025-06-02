<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Sector Routes
    Route::get('/sectors', \App\Livewire\SectorIndex::class)->name('sectors.index');
    Route::get('/sectors/create', \App\Livewire\SectorCreate::class)->name('sectors.create');
    Route::get('/sectors/{sector}/edit', \App\Livewire\SectorEdit::class)->name('sectors.edit');

    // Data Segment Routes
    Route::get('/data-segments', \App\Livewire\DataSegmentIndex::class)->name('data-segments.index');
    Route::get('/data-segments/create', \App\Livewire\DataSegmentCreate::class)->name('data-segments.create');
    Route::get('/data-segments/{dataSegment}/edit', \App\Livewire\DataSegmentEdit::class)->name('data-segments.edit');

    // Data Routes
    Route::get('/data', \App\Livewire\DataIndex::class)->name('data.index');
    Route::get('/data/create', \App\Livewire\DataCreate::class)->name('data.create');
    Route::get('/data/{data}/edit', \App\Livewire\DataEdit::class)->name('data.edit');
});
