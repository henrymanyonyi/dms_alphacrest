<?php

use App\Http\Controllers\DownloadController;
use App\Livewire\DataSectors\DataSectorManagement;
use App\Livewire\DataParameters\DataParameterManagement;
use App\Livewire\DataPoints\DataPointManagement;
use App\Livewire\Dashboard;
use App\Livewire\Marketplace\MarketplaceDashboard;
use App\Livewire\User\MyPurchases;
use Illuminate\Support\Facades\Route;

// Public marketplace route (no authentication required)
Route::get('/', MarketplaceDashboard::class)->name('marketplace');
Route::get('/marketplace', MarketplaceDashboard::class)->name('marketplace.index');

Route::get('/download/{orderId}', [DownloadController::class, 'download'])
    ->name('purchase.download');

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    // Data Sectors
    Route::get('/data-sectors', DataSectorManagement::class)->name('data-sectors.index');

    // Data Parameters
    Route::get('/data-parameters', DataParameterManagement::class)->name('data-parameters.index');

    // Data Points
    Route::get('/data-points', DataPointManagement::class)->name('data-points.index');

    // my purchases
    Route::get('/my-purchases', MyPurchases::class)->name('my-purchases');
});

// use Illuminate\Support\Facades\Route;

// use App\Livewire\DataSectors\DataSectorManagement;
// use App\Livewire\DataParameters\DataParameterManagement;
// use App\Livewire\DataPoints\DataPointManagement;
// use App\Livewire\Dashboard;

// Route::redirect('/', '/dashboard')->name('dashboard');

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     // Route::redirect('/dashboard', '/sectors')->name('dashboard');

//     // // Sector Routes
//     // Route::get('/sectors', \App\Livewire\Sector\Index::class)->name('sectors.index');
//     // Route::get('/sectors/create', \App\Livewire\Sector\Create::class)->name('sectors.create');
//     // Route::get('/sectors/{sector}/edit', \App\Livewire\Sector\Edit::class)->name('sectors.edit');

//     // // Data Segment Routes
//     // Route::get('/data-segments', \App\Livewire\DataSegment\Index::class)->name('data-segments.index');
//     // Route::get('/data-segments/create', \App\Livewire\DataSegment\Create::class)->name('data-segments.create');
//     // Route::get('/data-segments/{dataSegment}/edit', \App\Livewire\DataSegment\Edit::class)->name('data-segments.edit');

//     // // Data Routes
//     // Route::get('/data', \App\Livewire\Data\Index::class)->name('data.index');
//     // Route::get('/data/create', \App\Livewire\Data\Create::class)->name('data.create');
//     // Route::get('/data/{data}/edit', \App\Livewire\Data\Edit::class)->name('data.edit');

//     // Dashboard
//     Route::get('/dashboard', Dashboard::class)->name('dashboard');

//     // Data Sectors
//     Route::get('/data-sectors', DataSectorManagement::class)->name('data-sectors.index');

//     // Data Parameters
//     Route::get('/data-parameters', DataParameterManagement::class)->name('data-parameters.index');

//     // Data Points
//     Route::get('/data-points', DataPointManagement::class)->name('data-points.index');
// });
