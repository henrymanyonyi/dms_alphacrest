<?php

namespace App\Livewire\Data;

use App\Models\Data;
use App\Models\DataSegment;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;
    
    public $data;
    public $title;
    public $data_ref;
    public $report_summary;
    public $table_of_contents;
    public $metadata;
    public $segmentations;
    public $reference_links;
    public $data_segment_id;
    public $historical_start;
    public $historical_end;
    public $dataSegments;
    
    protected $rules = [
        'title' => 'required|max:255',
        'data_ref' => 'required|max:100',
        'report_summary' => 'nullable|max:2000',
        'table_of_contents' => 'nullable',
        'metadata' => 'nullable',
        'segmentations' => 'nullable',
        'reference_links' => 'nullable',
        'data_segment_id' => 'required|exists:data_segments,id',
        'historical_start' => 'nullable|date',
        'historical_end' => 'nullable|date|after_or_equal:historical_start',
    ];
    
    protected function validateJsonField($field)
    {
        if (empty($this->$field)) {
            return true;
        }
        
        try {
            json_decode($this->$field);
            return json_last_error() === JSON_ERROR_NONE;
        } catch (\Exception $e) {
            return false;
        }
    }
    
    public function updated($propertyName)
    {
        if ($propertyName === 'metadata' && !$this->validateJsonField('metadata')) {
            $this->addError('metadata', 'The metadata must be a valid JSON string.');
        }
        
        if ($propertyName === 'reference_links' && !$this->validateJsonField('reference_links')) {
            $this->addError('reference_links', 'The reference links must be a valid JSON string.');
        }
        
        // Special validation for data_ref uniqueness excluding the current record
        if ($propertyName === 'data_ref') {
            $this->validateOnly($propertyName, [
                'data_ref' => 'required|max:100|unique:data,data_ref,' . $this->data->id
            ]);
        }
    }
    
    public function mount(Data $data)
    {
        $this->data = $data;
        $this->title = $data->title;
        $this->data_ref = $data->data_ref;
        $this->report_summary = $data->report_summary;
        $this->table_of_contents = $data->table_of_contents;
        $this->metadata = $data->metadata;
        $this->segmentations = $data->segmentations;
        $this->reference_links = $data->reference_links;
        $this->data_segment_id = $data->data_segment_id;
        $this->historical_start = $data->historical_start;
        $this->historical_end = $data->historical_end;
        
        // Load data segments for dropdown
        $this->dataSegments = DataSegment::pluck('name', 'id');
    }
    
    public function updateData()
    {
        // Update validation rule for data_ref to ignore the current record
        $this->rules['data_ref'] = 'required|max:100|unique:data,data_ref,' . $this->data->id;
        
        $this->validate();
        
        // Validate JSON fields before submission
        $jsonFields = ['metadata', 'reference_links'];
        $hasJsonErrors = false;
        
        foreach ($jsonFields as $field) {
            if (!empty($this->$field) && !$this->validateJsonField($field)) {
                $this->addError($field, "The {$field} must be a valid JSON string.");
                $hasJsonErrors = true;
            }
        }
        
        if ($hasJsonErrors || $this->getErrorBag()->isNotEmpty()) {
            return;
        }
        
        try {
            // Prepare JSON fields with default empty arrays if needed
            $metadata = !empty($this->metadata) ? $this->metadata : json_encode([]);
            // Segmentations is a text field, not JSON
            $segmentations = $this->segmentations;
            $referenceLinks = !empty($this->reference_links) ? $this->reference_links : json_encode([]);
            
            $this->data->update([
                'title' => $this->title,
                'data_ref' => $this->data_ref,
                'report_summary' => $this->report_summary,
                'table_of_contents' => $this->table_of_contents,
                'metadata' => $metadata,
                'segmentations' => $segmentations,
                'reference_links' => $referenceLinks,
                'data_segment_id' => $this->data_segment_id,
                'historical_start' => $this->historical_start,
                'historical_end' => $this->historical_end,
                'updated_by' => auth()->id(),
            ]);
            
            session()->flash('message', 'Data entry updated successfully.');
            return redirect()->route('data.index');
        } catch (\Exception $e) {
            $this->addError('error', 'Failed to update data entry. Please try again. ' . $e->getMessage());
        }
    }
    
    public function deleteData()
    {
        if ($this->data) {
            $this->data->delete();
            session()->flash('message', 'Data entry deleted successfully.');
            return redirect()->route('data.index');
        }
    }
    
    public function render()
    {
        return view('livewire.data.edit');
    }
}
