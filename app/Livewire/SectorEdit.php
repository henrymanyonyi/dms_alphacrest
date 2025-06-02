<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Sector;
use Livewire\WithFileUploads;

class SectorEdit extends Component
{
    use WithFileUploads;
    
    public $sector;
    public $name;
    public $description;
    public $errors = [];

    protected $rules = [
        'name' => 'required|max:255|unique:sectors,name,{{ $this->sector->id }}',
        'description' => 'nullable|max:1000',
    ];

    public function mount(Sector $sector)
    {
        $this->sector = $sector;
        $this->name = $sector->name;
        $this->description = $sector->description;
    }

    public function updateSector()
    {
        $this->validate();

        try {
            $this->sector->update([
                'name' => $this->name,
                'description' => $this->description,
                'updated_by' => auth()->id(),
            ]);

            session()->flash('message', 'Sector updated successfully.');
            return redirect()->route('sectors.index');
        } catch (\Exception $e) {
            $this->errors = ['error' => 'Failed to update sector. Please try again.'];
        }
    }

    public function render()
    {
        return view('livewire.sector-edit');
    }
}
