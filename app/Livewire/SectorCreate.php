<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Sector;
use Livewire\WithFileUploads;

class SectorCreate extends Component
{
    use WithFileUploads;
    
    public $name;
    public $description;

    protected $rules = [
        'name' => 'required|max:255|unique:sectors',
        'description' => 'nullable|max:1000',
    ];

    public function createSector()
    {
        try {
            Sector::create([
                'name' => $this->name,
                'description' => $this->description,
                'created_by' => auth()->id(),
            ]);

            session()->flash('message', 'Sector created successfully.');
            return redirect()->route('sectors.index');
        } catch (\Exception $e) {
            $this->addError('error', 'Failed to create sector. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.sector-create');
    }
}
