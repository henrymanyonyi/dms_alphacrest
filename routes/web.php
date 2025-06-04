<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/sectors')->name('dashboard');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::redirect('/dashboard', '/sectors')->name('dashboard');

    // Sector Routes
    Route::get('/sectors', \App\Livewire\Sector\Index::class)->name('sectors.index');
    Route::get('/sectors/create', \App\Livewire\Sector\Create::class)->name('sectors.create');
    Route::get('/sectors/{sector}/edit', \App\Livewire\Sector\Edit::class)->name('sectors.edit');

    // Data Segment Routes
    Route::get('/data-segments', \App\Livewire\DataSegment\Index::class)->name('data-segments.index');
    Route::get('/data-segments/create', \App\Livewire\DataSegment\Create::class)->name('data-segments.create');
    Route::get('/data-segments/{dataSegment}/edit', \App\Livewire\DataSegment\Edit::class)->name('data-segments.edit');

    // Data Routes
    Route::get('/data', \App\Livewire\Data\Index::class)->name('data.index');
    Route::get('/data/create', \App\Livewire\Data\Create::class)->name('data.create');
    Route::get('/data/{data}/edit', \App\Livewire\Data\Edit::class)->name('data.edit');
});
