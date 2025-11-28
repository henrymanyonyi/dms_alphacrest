<?php

namespace App\Livewire\DataSectors;

use App\Models\DataSector;
use Livewire\Component;
use Livewire\WithPagination;

class DataSectorManagement extends Component
{
    use WithPagination;

    public $name, $description, $is_active = true;
    public $editingId = null;
    public $showModal = false;
    public $search = '';
    public $deleteId = null;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'is_active' => 'boolean',
    ];

    public function render()
    {
        $sectors = DataSector::with('creator')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.data-sectors.data-sector-management', [
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
        $sector = DataSector::findOrFail($id);
        $this->editingId = $id;
        $this->name = $sector->name;
        $this->description = $sector->description;
        $this->is_active = $sector->is_active;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->editingId) {
            $sector = DataSector::findOrFail($this->editingId);
            $sector->update([
                'name' => $this->name,
                'description' => $this->description,
                'is_active' => $this->is_active,
            ]);
            session()->flash('message', 'Sector updated successfully.');
        } else {
            DataSector::create([
                'name' => $this->name,
                'description' => $this->description,
                'is_active' => $this->is_active,
                'created_by' => auth()->id(),
            ]);
            session()->flash('message', 'Sector created successfully.');
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
            DataSector::findOrFail($this->deleteId)->delete();
            session()->flash('message', 'Sector deleted successfully.');
            $this->deleteId = null;
        }
    }

    public function toggleStatus($id)
    {
        $sector = DataSector::findOrFail($id);
        $sector->update(['is_active' => !$sector->is_active]);
        session()->flash('message', 'Status updated successfully.');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->reset(['name', 'description', 'is_active', 'editingId']);
        $this->is_active = true;
        $this->resetValidation();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
