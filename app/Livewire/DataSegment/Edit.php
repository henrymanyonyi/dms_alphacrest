<?php

namespace App\Livewire\DataSegment;

use App\Models\DataSegment;
use App\Models\Sector;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;
    
    public $dataSegment;
    public $name;
    public $description;
    public $sector_id;
    public $sectors;

    protected $rules = [
        'name' => 'required|max:255',
        'description' => 'nullable|max:1000',
        'sector_id' => 'required|exists:sectors,id',
    ];

    public function mount(DataSegment $dataSegment)
    {
        $this->dataSegment = $dataSegment;
        $this->name = $dataSegment->name;
        $this->description = $dataSegment->description;
        $this->sector_id = $dataSegment->sector_id;
        $this->sectors = Sector::pluck('name', 'id');
    }

    public function updateDataSegment()
    {
        // Update validation rule for name to ignore the current record
        $this->rules['name'] = 'required|max:255|unique:data_segments,name,' . $this->dataSegment->id;
        
        $this->validate();

        try {
            $this->dataSegment->update([
                'name' => $this->name,
                'description' => $this->description,
                'sector_id' => $this->sector_id,
                'updated_by' => auth()->id(),
            ]);

            session()->flash('message', 'Data Segment updated successfully.');
            return redirect()->route('data-segments.index');
        } catch (\Exception $e) {
            $this->addError('error', 'Failed to update data segment. Please try again.');
        }
    }

    public function deleteDataSegment()
    {
        if ($this->dataSegment) {
            $this->dataSegment->delete();
            session()->flash('message', 'Data Segment deleted successfully.');
            return redirect()->route('data-segments.index');
        }
    }

    public function render()
    {
        return view('livewire.data-segment.edit');
    }
}
