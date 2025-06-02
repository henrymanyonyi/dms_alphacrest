<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Data Entries</h1>
            <a href="{{ route('data.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Create New
            </a>
        </div>

        @if(session()->has('message'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                {{ session('message') }}
            </div>
        @endif

        <div class="mb-4">
            <input type="text" wire:model.debounce.300ms="search" placeholder="Search data entries..." class="w-full md:w-1/3 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('title')">
                            Title
                            @if($sortField === 'title')
                                @if($sortDirection === 'asc')
                                    <span class="ml-1">↑</span>
                                @else
                                    <span class="ml-1">↓</span>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('data_ref')">
                            Reference
                            @if($sortField === 'data_ref')
                                @if($sortDirection === 'asc')
                                    <span class="ml-1">↑</span>
                                @else
                                    <span class="ml-1">↓</span>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Summary
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('data_segment_id')">
                            Data Segment
                            @if($sortField === 'data_segment_id')
                                @if($sortDirection === 'asc')
                                    <span class="ml-1">↑</span>
                                @else
                                    <span class="ml-1">↓</span>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('created_at')">
                            Created At
                            @if($sortField === 'created_at')
                                @if($sortDirection === 'asc')
                                    <span class="ml-1">↑</span>
                                @else
                                    <span class="ml-1">↓</span>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($dataEntries as $data)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $data->title }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $data->data_ref }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ Str::limit($data->report_summary, 50) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $data->dataSegment->name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $data->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('data.edit', $data) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                <button wire:click="confirmDelete({{ $data->id }})" class="text-red-600 hover:text-red-900">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                No data entries found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $dataEntries->links() }}
        </div>

        <!-- Delete Confirmation Modal -->
        @if($confirmingDelete)
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50" x-data>
                <div class="bg-white rounded-lg p-6 max-w-md mx-auto">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Confirm Deletion</h3>
                    <p class="text-sm text-gray-500 mb-4">Are you sure you want to delete this data entry? This action cannot be undone.</p>
                    <div class="flex justify-end">
                        <button wire:click="$set('confirmingDelete', false)" class="mr-3 px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Cancel
                        </button>
                        <button wire:click="deleteData" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
