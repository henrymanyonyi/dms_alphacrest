<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Sector;
use Livewire\WithPagination;

class SectorIndex extends Component
{
    use WithPagination;
    
    public $search = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';
    public $perPage = 10;
    
    protected $queryString = [
        'search' => ['except' => ''],
        'sortBy' => ['except' => 'name'],
        'sortDirection' => ['except' => 'asc'],
        'perPage' => ['except' => 10]
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function deleteSector($id)
    {
        if ($id) {
            Sector::find($id)->delete();
            session()->flash('message', 'Sector deleted successfully.');
        }
    }

    public function render()
    {
        return view('livewire.sector-index', [
            'sectors' => Sector::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%')
                ->orderBy($this->sortBy, $this->sortDirection)
                ->paginate($this->perPage)
        ]);
    }
}
