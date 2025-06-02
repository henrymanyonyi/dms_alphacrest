<?php

namespace App\Livewire\Sector;

use App\Models\Sector;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    
    public $search = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';
    public $confirmingSectorDeletion = false;
    public $sectorIdBeingDeleted = null;
    
    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'name'],
        'sortDirection' => ['except' => 'asc'],
    ];
    
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        
        $this->sortField = $field;
    }
    
    public function confirmSectorDeletion($id)
    {
        $this->confirmingSectorDeletion = true;
        $this->sectorIdBeingDeleted = $id;
    }
    
    public function cancelSectorDeletion()
    {
        $this->confirmingSectorDeletion = false;
        $this->sectorIdBeingDeleted = null;
    }
    
    public function deleteSector()
    {
        Sector::find($this->sectorIdBeingDeleted)->delete();
        $this->confirmingSectorDeletion = false;
        $this->sectorIdBeingDeleted = null;
        session()->flash('message', 'Sector deleted successfully.');
    }
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        $sectors = Sector::query()
            ->when($this->search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);
        
        return view('livewire.sector.index', [
            'sectors' => $sectors,
        ]);
    }
}
