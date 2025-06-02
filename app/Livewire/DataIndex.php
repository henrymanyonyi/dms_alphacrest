<?php

namespace App\Livewire;

use App\Models\Data;
use App\Models\DataSegment;
use Livewire\Component;
use Livewire\WithPagination;

class DataIndex extends Component
{
    use WithPagination;
    
    public $search = '';
    public $sortField = 'title';
    public $sortDirection = 'asc';
    public $perPage = 10;
    public $confirmingDelete = false;
    public $dataToDelete = null;
    
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
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }
    
    public function confirmDelete($id)
    {
        $this->confirmingDelete = true;
        $this->dataToDelete = $id;
    }
    
    public function deleteData()
    {
        if ($this->dataToDelete) {
            $data = Data::find($this->dataToDelete);
            if ($data) {
                $data->delete();
                session()->flash('message', 'Data entry deleted successfully.');
            }
        }
        
        $this->confirmingDelete = false;
        $this->dataToDelete = null;
    }
    
    public function render()
    {
        $dataEntries = Data::query()
            ->when($this->search, function ($query) {
                return $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('data_ref', 'like', '%' . $this->search . '%')
                    ->orWhere('report_summary', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->with('dataSegment') // Eager load the dataSegment relationship
            ->paginate($this->perPage);
            
        return view('livewire.data-index', [
            'dataEntries' => $dataEntries,
        ]);
    }
}
