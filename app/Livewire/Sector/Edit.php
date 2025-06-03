<?php

namespace App\Livewire\Sector;

use App\Models\Sector;
use Livewire\Component;

class Edit extends Component
{
    public $sector;
    public $name;
    public $description;

    protected $rules = [
        'name' => 'required|max:255',
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
        // Update validation rule for name to ignore the current record
        $this->rules['name'] = 'required|max:255|unique:sectors,name,' . $this->sector->id;
        
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
            $this->addError('error', 'Failed to update sector. Please try again.');
        }
    }

    public function deleteSector()
    {
        if ($this->sector) {
            $this->sector->delete();
            session()->flash('message', 'Sector deleted successfully.');
            return redirect()->route('sectors.index');
        }
    }

    public function render()
    {
        return view('livewire.sector.edit');
    }
}
