<?php

namespace App\Livewire\DataSegment;

use App\Models\DataSegment;
use App\Models\Sector;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;
    
    public $name;
    public $description;
    public $sector_id;
    public $sectors;

    protected $rules = [
        'name' => 'required|max:255|unique:data_segments',
        'description' => 'nullable|max:1000',
        'sector_id' => 'required|exists:sectors,id',
    ];

    public function mount()
    {
        $this->sectors = Sector::pluck('name', 'id');
    }

    public function createDataSegment()
    {
        $this->validate();

        try {
            DataSegment::create([
                'name' => $this->name,
                'description' => $this->description,
                'sector_id' => $this->sector_id,
                'created_by' => auth()->id(),
            ]);

            session()->flash('message', 'Data Segment created successfully.');
            return redirect()->route('data-segments.index');
        } catch (\Exception $e) {
            $this->addError('error', 'Failed to create data segment. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.data-segment.create');
    }
}
