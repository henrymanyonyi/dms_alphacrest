<?php

namespace App\Livewire;

use App\Models\DataSegment;
use App\Models\Sector;
use Livewire\Component;
use Livewire\WithPagination;

class DataSegmentIndex extends Component
{
    use WithPagination;
    
    public $search = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';
    public $perPage = 10;
    public $confirmingDelete = false;
    public $dataSegmentToDelete = null;
    
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
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }
    
    public function confirmDelete($id)
    {
        $this->confirmingDelete = true;
        $this->dataSegmentToDelete = $id;
    }
    
    public function deleteDataSegment()
    {
        if ($this->dataSegmentToDelete) {
            $dataSegment = DataSegment::find($this->dataSegmentToDelete);
            if ($dataSegment) {
                $dataSegment->delete();
                session()->flash('message', 'Data Segment deleted successfully.');
            }
        }
        
        $this->confirmingDelete = false;
        $this->dataSegmentToDelete = null;
    }
    
    public function render()
    {
        $dataSegments = DataSegment::query()
            ->when($this->search, function ($query) {
                return $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->with('sector') // Eager load the sector relationship
            ->paginate($this->perPage);
            
        return view('livewire.data-segment-index', [
            'dataSegments' => $dataSegments,
        ]);
    }
}
