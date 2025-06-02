<?php

namespace App\Livewire\DataSegment;

use App\Models\DataSegment;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    
    public $search = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';
    public $confirmingDataSegmentDeletion = false;
    public $dataSegmentIdBeingDeleted = null;
    
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
    
    public function confirmDataSegmentDeletion($id)
    {
        $this->confirmingDataSegmentDeletion = true;
        $this->dataSegmentIdBeingDeleted = $id;
    }
    
    public function deleteDataSegment()
    {
        DataSegment::find($this->dataSegmentIdBeingDeleted)->delete();
        $this->confirmingDataSegmentDeletion = false;
        $this->dataSegmentIdBeingDeleted = null;
        session()->flash('message', 'Data Segment deleted successfully.');
    }
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        $dataSegments = DataSegment::query()
            ->with('sector')
            ->when($this->search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);
        
        return view('livewire.data-segment.index', [
            'dataSegments' => $dataSegments,
        ]);
    }
}
