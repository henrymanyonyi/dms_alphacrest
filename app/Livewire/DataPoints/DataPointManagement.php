<?php

namespace App\Livewire\DataPoints;

use App\Models\DataPoint;
use App\Models\DataParameter;
use App\Models\DataPointAttachment;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class DataPointManagement extends Component
{
    use WithPagination, WithFileUploads;

    public $name, $description, $data_source, $data_indicator, $is_active = true;
    public $data_parameter_id, $source_url, $data_date;
    public $editingId = null;
    public $showModal = false;
    public $search = '';
    public $deleteId = null;
    public $filterParameter = '';

    // File upload
    public $files = [];
    public $fileDescriptions = [];
    public $viewingAttachments = null;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'data_source' => 'nullable|string',
        'data_indicator' => 'nullable|string',
        'is_active' => 'boolean',
        'data_parameter_id' => 'nullable|exists:data_parameters,id',
        'source_url' => 'nullable|url',
        'data_date' => 'nullable|date',
        'files.*' => 'nullable|file|max:10240', // 10MB max
    ];

    public function render()
    {
        $dataPoints = DataPoint::with(['parameter.sector', 'creator', 'attachments'])
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%')
                    ->orWhere('data_source', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterParameter, function ($query) {
                $query->where('data_parameter_id', $this->filterParameter);
            })
            ->latest()
            ->paginate(10);

        $parameters = DataParameter::where('is_active', true)->with('sector')->get();

        return view('livewire.data-points.data-point-management', [
            'dataPoints' => $dataPoints,
            'parameters' => $parameters
        ]);
    }

    public function create()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit($id)
    {
        $dataPoint = DataPoint::findOrFail($id);
        $this->editingId = $id;
        $this->name = $dataPoint->name;
        $this->description = $dataPoint->description;
        $this->data_source = $dataPoint->data_source;
        $this->data_indicator = $dataPoint->data_indicator;
        $this->is_active = $dataPoint->is_active;
        $this->data_parameter_id = $dataPoint->data_parameter_id;
        $this->source_url = $dataPoint->source_url;
        $this->data_date = $dataPoint->data_date ? Carbon::parse($dataPoint->data_date)->format('Y-m-d') : null;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->editingId) {
            $dataPoint = DataPoint::findOrFail($this->editingId);
            $dataPoint->update([
                'name' => $this->name,
                'description' => $this->description,
                'data_source' => $this->data_source,
                'data_indicator' => $this->data_indicator,
                'is_active' => $this->is_active,
                'data_parameter_id' => $this->data_parameter_id,
                'source_url' => $this->source_url,
                'data_date' => $this->data_date,
            ]);
            session()->flash('message', 'Data point updated successfully.');
        } else {
            $dataPoint = DataPoint::create([
                'name' => $this->name,
                'description' => $this->description,
                'data_source' => $this->data_source,
                'data_indicator' => $this->data_indicator,
                'is_active' => $this->is_active,
                'data_parameter_id' => $this->data_parameter_id,
                'source_url' => $this->source_url,
                'data_date' => $this->data_date,
                'created_by' => auth()->id(),
            ]);
            session()->flash('message', 'Data point created successfully.');
        }

        // Handle file uploads
        if (!empty($this->files)) {
            foreach ($this->files as $index => $file) {
                $fileName = $file->getClientOriginalName();
                $filePath = $file->store('data-point-attachments', 'public');

                DataPointAttachment::create([
                    'data_point_id' => $dataPoint->id,
                    'file_name' => $fileName,
                    'file_path' => $filePath,
                    'file_type' => $file->getClientOriginalExtension(),
                    'file_size' => $file->getSize(),
                    'description' => $this->fileDescriptions[$index] ?? null,
                    'uploaded_by' => auth()->id(),
                ]);
            }
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
            $dataPoint = DataPoint::findOrFail($this->deleteId);

            // Delete associated files
            foreach ($dataPoint->attachments as $attachment) {
                Storage::disk('public')->delete($attachment->file_path);
                $attachment->delete();
            }

            $dataPoint->delete();
            session()->flash('message', 'Data point deleted successfully.');
            $this->deleteId = null;
        }
    }

    public function deleteAttachment($attachmentId)
    {
        $attachment = DataPointAttachment::findOrFail($attachmentId);
        Storage::disk('public')->delete($attachment->file_path);
        $attachment->delete();
        session()->flash('message', 'Attachment deleted successfully.');
    }

    public function viewAttachments($id)
    {
        $this->viewingAttachments = DataPoint::with('attachments')->findOrFail($id);
    }

    public function toggleStatus($id)
    {
        $dataPoint = DataPoint::findOrFail($id);
        $dataPoint->update(['is_active' => !$dataPoint->is_active]);
        session()->flash('message', 'Status updated successfully.');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->reset([
            'name',
            'description',
            'data_source',
            'data_indicator',
            'is_active',
            'data_parameter_id',
            'source_url',
            'data_date',
            'editingId',
            'files',
            'fileDescriptions'
        ]);
        $this->is_active = true;
        $this->resetValidation();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterParameter()
    {
        $this->resetPage();
    }
}
