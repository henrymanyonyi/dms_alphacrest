<?php

namespace App\Livewire;

use App\Models\DataSector;
use App\Models\DataParameter;
use App\Models\DataPoint;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $stats = [
            'sectors' => DataSector::count(),
            'activeSectors' => DataSector::where('is_active', true)->count(),
            'parameters' => DataParameter::count(),
            'activeParameters' => DataParameter::where('is_active', true)->count(),
            'dataPoints' => DataPoint::count(),
            'activeDataPoints' => DataPoint::where('is_active', true)->count(),
        ];

        $recentDataPoints = DataPoint::with(['parameter.sector'])
            ->latest()
            ->take(5)
            ->get();

        $recentSectors = DataSector::withCount('parameters')
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.dashboard', [
            'stats' => $stats,
            'recentDataPoints' => $recentDataPoints,
            'recentSectors' => $recentSectors
        ]);
    }
}
