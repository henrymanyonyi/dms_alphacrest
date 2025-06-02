<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-6">Create New Data Entry</h1>

        @if($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session()->has('message'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                {{ session('message') }}
            </div>
        @endif

        <form wire:submit.prevent="createData">
            <div class="space-y-6">
                <!-- Data Segment Selection -->
                <div>
                    <label for="data_segment_id" class="block text-sm font-medium text-gray-700">Data Segment</label>
                    <select id="data_segment_id" wire:model="data_segment_id" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('data_segment_id') border-red-500 @enderror">
                        <option value="">Select a data segment</option>
                        @foreach($dataSegments as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('data_segment_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" id="title" wire:model="title" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Data Reference -->
                <div>
                    <label for="data_ref" class="block text-sm font-medium text-gray-700">Data Reference</label>
                    <input type="text" id="data_ref" wire:model="data_ref" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('data_ref') border-red-500 @enderror">
                    @error('data_ref')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Report Summary -->
                <div>
                    <label for="report_summary" class="block text-sm font-medium text-gray-700">Report Summary</label>
                    <textarea id="report_summary" rows="4" wire:model="report_summary" 
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('report_summary') border-red-500 @enderror"></textarea>
                    @error('report_summary')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Table of Contents -->
                <div>
                    <label for="table_of_contents" class="block text-sm font-medium text-gray-700">Table of Contents</label>
                    <textarea id="table_of_contents" rows="4" wire:model="table_of_contents" 
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('table_of_contents') border-red-500 @enderror"></textarea>
                    @error('table_of_contents')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Metadata -->
                <div>
                    <label for="metadata" class="block text-sm font-medium text-gray-700">Metadata (JSON format)</label>
                    <textarea id="metadata" rows="4" wire:model="metadata" 
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('metadata') border-red-500 @enderror"
                              placeholder='{"key": "value", "another_key": "another_value"}'></textarea>
                    <p class="mt-1 text-xs text-gray-500">Enter valid JSON format. Example: {"key": "value"}</p>
                    @error('metadata')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Segmentations -->
                <div>
                    <label for="segmentations" class="block text-sm font-medium text-gray-700">Segmentations</label>
                    <textarea id="segmentations" rows="4" wire:model="segmentations" 
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('segmentations') border-red-500 @enderror"
                              placeholder='Enter segmentation information here'></textarea>
                    <p class="mt-1 text-xs text-gray-500">Enter segmentation details as plain text.</p>
                    @error('segmentations')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Reference Links -->
                <div>
                    <label for="reference_links" class="block text-sm font-medium text-gray-700">Reference Links (JSON format)</label>
                    <textarea id="reference_links" rows="4" wire:model="reference_links" 
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('reference_links') border-red-500 @enderror"
                              placeholder='{"links": ["https://example.com", "https://another-example.com"]}'></textarea>
                    <p class="mt-1 text-xs text-gray-500">Enter valid JSON format. Example: {"links": ["https://example.com"]}</p>
                    @error('reference_links')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Historical Date Range -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="historical_start" class="block text-sm font-medium text-gray-700">Historical Start Date</label>
                        <input type="date" id="historical_start" wire:model="historical_start" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('historical_start') border-red-500 @enderror">
                        @error('historical_start')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="historical_end" class="block text-sm font-medium text-gray-700">Historical End Date</label>
                        <input type="date" id="historical_end" wire:model="historical_end" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('historical_end') border-red-500 @enderror">
                        @error('historical_end')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-between">
                    <button type="submit" 
                            class="flex-1 flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-2">
                        Create Data Entry
                    </button>
                    <a href="{{ route('data.index') }}" 
                       class="flex-1 flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
