<?php

namespace App\Livewire\Data;

use App\Models\Data;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    
    public $search = '';
    public $sortField = 'title';
    public $sortDirection = 'asc';
    public $confirmingDataDeletion = false;
    public $dataIdBeingDeleted = null;
    
    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'title'],
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
    
    public function confirmDataDeletion($id)
    {
        $this->confirmingDataDeletion = true;
        $this->dataIdBeingDeleted = $id;
    }
    
    public function deleteData()
    {
        Data::find($this->dataIdBeingDeleted)->delete();
        $this->confirmingDataDeletion = false;
        $this->dataIdBeingDeleted = null;
        session()->flash('message', 'Data deleted successfully.');
    }
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        $dataEntries = Data::query()
            ->with('dataSegment')
            ->when($this->search, function ($query, $search) {
                return $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('data_ref', 'like', '%' . $search . '%')
                    ->orWhere('report_summary', 'like', '%' . $search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);
        
        return view('livewire.data.index', [
            'dataEntries' => $dataEntries,
        ]);
    }
}
