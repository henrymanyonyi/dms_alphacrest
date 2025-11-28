<?php

namespace App\Livewire\DataParameters;

use App\Models\DataParameter;
use App\Models\DataSector;
use Livewire\Component;
use Livewire\WithPagination;

class DataParameterManagement extends Component
{
    use WithPagination;

    public $name, $description, $is_active = true, $data_sector_id;
    public $editingId = null;
    public $showModal = false;
    public $search = '';
    public $deleteId = null;
    public $filterSector = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'is_active' => 'boolean',
        'data_sector_id' => 'nullable|exists:data_sectors,id',
    ];

    public function render()
    {
        $parameters = DataParameter::with(['sector', 'creator'])
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterSector, function ($query) {
                $query->where('data_sector_id', $this->filterSector);
            })
            ->latest()
            ->paginate(10);

        $sectors = DataSector::where('is_active', true)->get();

        return view('livewire.data-parameters.data-parameter-management', [
            'parameters' => $parameters,
            'sectors' => $sectors
        ]);
    }

    public function create()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit($id)
    {
        $parameter = DataParameter::findOrFail($id);
        $this->editingId = $id;
        $this->name = $parameter->name;
        $this->description = $parameter->description;
        $this->is_active = $parameter->is_active;
        $this->data_sector_id = $parameter->data_sector_id;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->editingId) {
            $parameter = DataParameter::findOrFail($this->editingId);
            $parameter->update([
                'name' => $this->name,
                'description' => $this->description,
                'is_active' => $this->is_active,
                'data_sector_id' => $this->data_sector_id,
            ]);
            session()->flash('message', 'Parameter updated successfully.');
        } else {
            DataParameter::create([
                'name' => $this->name,
                'description' => $this->description,
                'is_active' => $this->is_active,
                'data_sector_id' => $this->data_sector_id,
                'created_by' => auth()->id(),
            ]);
            session()->flash('message', 'Parameter created successfully.');
        }

        $this->closeModal();
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
    }

    public function delete()
    {
        if ($this->deleteId) {
            DataParameter::findOrFail($this->deleteId)->delete();
            session()->flash('message', 'Parameter deleted successfully.');
            $this->deleteId = null;
        }
    }

    public function toggleStatus($id)
    {
        $parameter = DataParameter::findOrFail($id);
        $parameter->update(['is_active' => !$parameter->is_active]);
        session()->flash('message', 'Status updated successfully.');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->reset(['name', 'description', 'is_active', 'data_sector_id', 'editingId']);
        $this->is_active = true;
        $this->resetValidation();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterSector()
    {
        $this->resetPage();
    }
}
