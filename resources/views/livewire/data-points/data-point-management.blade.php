<div>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 p-4 md:p-6 lg:p-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">Data Points</h1>
                        <p class="text-gray-600">Manage individual data entries and attachments</p>
                    </div>
                    <button wire:click="create"
                        class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-sm transition duration-150 ease-in-out transform hover:scale-105">
                        <i class="fas fa-plus mr-2"></i>
                        New Data Point
                    </button>
                </div>
            </div>

            <!-- Flash Message -->
            @if (session()->has('message'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-lg" x-data="{ show: true }"
                    x-show="show" x-init="setTimeout(() => show = false, 3000)">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <p class="text-green-800 font-medium">{{ session('message') }}</p>
                    </div>
                </div>
            @endif

            <!-- Search and Filter Bar -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="relative">
                        <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input wire:model.live="search" type="text"
                            placeholder="Search data points..."
                            class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                    </div>
                    <div class="relative">
                        <i class="fas fa-filter absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <select wire:model.live="filterParameter"
                            class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition appearance-none">
                            <option value="">All Parameters</option>
                            @foreach ($parameters as $parameter)
                                <option value="{{ $parameter->id }}">{{ $parameter->name }} @if ($parameter->sector)
                                        ({{ $parameter->sector->name }})
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Name</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden xl:table-cell">
                                    Parameter</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden lg:table-cell">
                                    Source</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Files</th>
                                <th
                                    class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($dataPoints as $point)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-900">{{ $point->name }}</div>
                                        <div class="text-sm text-gray-500 mt-1">
                                            @if ($point->data_date)
                                                <i class="fas fa-calendar text-xs mr-1"></i>
                                                {{ \Carbon\Carbon::parse($point->data_date)->format('M d, Y') }}
                                            @endif
                                        </div>
                                        <div class="text-sm text-gray-500 xl:hidden mt-1">
                                            @if ($point->parameter)
                                                <span
                                                    class="inline-flex items-center px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs">
                                                    {{ $point->parameter->name }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 hidden xl:table-cell">
                                        @if ($point->parameter)
                                            <div>
                                                <span
                                                    class="inline-flex items-center px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-medium">
                                                    {{ $point->parameter->name }}
                                                </span>
                                                @if ($point->parameter->sector)
                                                    <div class="text-xs text-gray-500 mt-1">
                                                        {{ $point->parameter->sector->name }}</div>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-gray-400 text-sm">No parameter</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 hidden lg:table-cell">
                                        <div class="text-sm text-gray-600">
                                            {{ Str::limit($point->data_source, 40) ?? 'N/A' }}</div>
                                        @if ($point->source_url)
                                            <a href="{{ $point->source_url }}" target="_blank"
                                                class="text-xs text-blue-600 hover:text-blue-800 mt-1 inline-block">
                                                <i class="fas fa-external-link-alt mr-1"></i>View Source
                                            </a>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <button wire:click="toggleStatus({{ $point->id }})"
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium transition {{ $point->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                            <i class="fas fa-circle text-xs mr-1"></i>
                                            {{ $point->is_active ? 'Active' : 'Inactive' }}
                                        </button>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if ($point->attachments->count() > 0)
                                            <button wire:click="viewAttachments({{ $point->id }})"
                                                class="inline-flex items-center px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-xs font-medium hover:bg-indigo-200 transition">
                                                <i class="fas fa-paperclip mr-1"></i>
                                                {{ $point->attachments->count() }}
                                            </button>
                                        @else
                                            <span class="text-gray-400 text-xs">No files</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-2">
                                            <button wire:click="edit({{ $point->id }})"
                                                class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button wire:click="confirmDelete({{ $point->id }})"
                                                class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <i class="fas fa-chart-line text-gray-300 text-5xl mb-4"></i>
                                        <p class="text-gray-500 text-lg">No data points found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $dataPoints->links() }}
                </div>
            </div>
        </div>

        <!-- Create/Edit Modal -->
        @if ($showModal)
            <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: @entangle('showModal') }">
                <div class="flex items-center justify-center min-h-screen px-4 py-8">
                    <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity" wire:click="closeModal">
                    </div>

                    <div
                        class="relative bg-white rounded-2xl shadow-xl max-w-4xl w-full p-6 transform transition-all max-h-[90vh] overflow-y-auto">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-2xl font-bold text-gray-900">
                                {{ $editingId ? 'Edit Data Point' : 'Create New Data Point' }}
                            </h3>
                            <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600 transition">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>

                        <form wire:submit.prevent="save" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
                                    <input wire:model="name" type="text"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                                        placeholder="Enter data point name">
                                    @error('name')
                                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Parameter</label>
                                    <select wire:model="data_parameter_id"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                                        <option value="">Select a parameter</option>
                                        @foreach ($parameters as $parameter)
                                            <option value="{{ $parameter->id }}">
                                                {{ $parameter->name }}@if ($parameter->sector)
                                                    - {{ $parameter->sector->name }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('data_parameter_id')
                                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Data Date</label>
                                    <input wire:model="data_date" type="date"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                                    @error('data_date')
                                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Data Source</label>
                                    <input wire:model="data_source" type="text"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                                        placeholder="Enter data source">
                                    @error('data_source')
                                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Source URL</label>
                                    <input wire:model="source_url" type="url"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                                        placeholder="https://example.com">
                                    @error('source_url')
                                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Data Indicator</label>
                                    <input wire:model="data_indicator" type="text"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                                        placeholder="Enter data indicator">
                                    @error('data_indicator')
                                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                    <textarea wire:model="description" rows="4"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                                        placeholder="Enter description"></textarea>
                                    @error('description')
                                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Attachments</label>
                                    <input wire:model="files" type="file" multiple
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                                    <p class="text-xs text-gray-500 mt-1">Upload files (Max 10MB each). Supported: PDF,
                                        Excel, Images, CSV</p>
                                    @error('files.*')
                                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="md:col-span-2 flex items-center">
                                    <input wire:model="is_active" type="checkbox" id="is_active"
                                        class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                    <label for="is_active"
                                        class="ml-3 text-sm font-medium text-gray-700">Active</label>
                                </div>
                            </div>

                            <div class="flex items-center justify-end gap-3 pt-4 border-t">
                                <button type="button" wire:click="closeModal"
                                    class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 font-medium transition">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-medium transition">
                                    <i class="fas fa-save mr-2"></i>
                                    {{ $editingId ? 'Update' : 'Create' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        <!-- View Attachments Modal -->
        @if ($viewingAttachments)
            <div class="fixed inset-0 z-50 overflow-y-auto">
                <div class="flex items-center justify-center min-h-screen px-4">
                    <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity"
                        wire:click="$set('viewingAttachments', null)"></div>

                    <div class="relative bg-white rounded-2xl shadow-xl max-w-3xl w-full p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-2xl font-bold text-gray-900">Attachments for
                                {{ $viewingAttachments->name }}</h3>
                            <button wire:click="$set('viewingAttachments', null)"
                                class="text-gray-400 hover:text-gray-600 transition">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>

                        <div class="space-y-3 max-h-96 overflow-y-auto">
                            @forelse($viewingAttachments->attachments as $attachment)
                                <div
                                    class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                                    <div class="flex items-center space-x-4 flex-1">
                                        <div
                                            class="flex-shrink-0 w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                                            <i
                                                class="fas fa-file-{{ $attachment->file_type }} text-indigo-600 text-xl"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                {{ $attachment->file_name }}</p>
                                            <p class="text-xs text-gray-500">
                                                {{ number_format($attachment->file_size / 1024, 2) }} KB</p>
                                            @if ($attachment->description)
                                                <p class="text-xs text-gray-600 mt-1">{{ $attachment->description }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ Storage::url($attachment->file_path) }}" target="_blank"
                                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <button wire:click="deleteAttachment({{ $attachment->id }})"
                                            class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <i class="fas fa-folder-open text-gray-300 text-4xl mb-3"></i>
                                    <p class="text-gray-500">No attachments</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Delete Confirmation Modal -->
        @if ($deleteId)
            <div class="fixed inset-0 z-50 overflow-y-auto">
                <div class="flex items-center justify-center min-h-screen px-4">
                    <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity"
                        wire:click="$set('deleteId', null)"></div>

                    <div class="relative bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
                        <div class="text-center">
                            <div
                                class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                                <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Delete Data Point</h3>
                            <p class="text-gray-600 mb-6">Are you sure you want to delete this data point and all its
                                attachments? This action cannot be undone.</p>

                            <div class="flex items-center justify-center gap-3">
                                <button wire:click="$set('deleteId', null)"
                                    class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 font-medium transition">
                                    Cancel
                                </button>
                                <button wire:click="delete"
                                    class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-medium transition">
                                    <i class="fas fa-trash mr-2"></i>
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
