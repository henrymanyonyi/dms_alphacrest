<?php

namespace App\Livewire\User;

use App\Models\Purchase;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.marketplace')]
class MyPurchases extends Component
{
    use WithPagination;

    public $statusFilter = 'all';
    public $search = '';
    public $viewingPurchase = null;

    public function render()
    {
        $purchases = Purchase::with(['dataPoint.parameter.sector', 'dataPoint.attachments'])
            ->where('user_id', auth()->id())
            ->when($this->statusFilter !== 'all', function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->search, function ($query) {
                $query->whereHas('dataPoint', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate(10);

        $stats = [
            'total' => Purchase::where('user_id', auth()->id())->count(),
            'completed' => Purchase::where('user_id', auth()->id())->where('status', 'completed')->count(),
            'pending' => Purchase::where('user_id', auth()->id())->where('status', 'pending')->count(),
            'total_spent' => Purchase::where('user_id', auth()->id())->where('status', 'completed')->sum('amount'),
        ];

        return view('livewire.user.my-purchases', [
            'purchases' => $purchases,
            'stats' => $stats
        ]);
    }

    public function viewDetails($id)
    {
        $this->viewingPurchase = Purchase::with(['dataPoint.parameter.sector', 'dataPoint.attachments'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);
    }

    public function closeDetails()
    {
        $this->viewingPurchase = null;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }
}
