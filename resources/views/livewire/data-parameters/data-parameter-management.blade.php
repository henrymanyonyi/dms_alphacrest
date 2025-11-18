<div>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 p-4 md:p-6 lg:p-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">Data Parameters</h1>
                        <p class="text-gray-600">Manage parameters within sectors</p>
                    </div>
                    <button wire:click="create"
                        class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-sm transition duration-150 ease-in-out transform hover:scale-105">
                        <i class="fas fa-plus mr-2"></i>
                        New Parameter
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
                        <input wire:model.live="search" type="text" placeholder="Search parameters..."
                            class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                    </div>
                    <div class="relative">
                        <i class="fas fa-filter absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <select wire:model.live="filterSector"
                            class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition appearance-none">
                            <option value="">All Sectors</option>
                            @foreach ($sectors as $sector)
                                <option value="{{ $sector->id }}">{{ $sector->name }}</option>
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
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden lg:table-cell">
                                    Sector</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden md:table-cell">
                                    Description</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($parameters as $parameter)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-900">{{ $parameter->name }}</div>
                                        <div class="text-sm text-gray-500 lg:hidden mt-1">
                                            @if ($parameter->sector)
                                                <span
                                                    class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
                                                    {{ $parameter->sector->name }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 hidden lg:table-cell">
                                        @if ($parameter->sector)
                                            <span
                                                class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                                {{ $parameter->sector->name }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 text-sm">No sector</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 hidden md:table-cell">
                                        <div class="text-sm text-gray-600">
                                            {{ Str::limit($parameter->description, 60) ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <button wire:click="toggleStatus({{ $parameter->id }})"
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium transition {{ $parameter->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                            <i class="fas fa-circle text-xs mr-1"></i>
                                            {{ $parameter->is_active ? 'Active' : 'Inactive' }}
                                        </button>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-2">
                                            <button wire:click="edit({{ $parameter->id }})"
                                                class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button wire:click="confirmDelete({{ $parameter->id }})"
                                                class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <i class="fas fa-database text-gray-300 text-5xl mb-4"></i>
                                        <p class="text-gray-500 text-lg">No parameters found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $parameters->links() }}
                </div>
            </div>
        </div>

        <!-- Create/Edit Modal -->
        @if ($showModal)
            <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: @entangle('showModal') }">
                <div class="flex items-center justify-center min-h-screen px-4">
                    <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity" wire:click="closeModal">
                    </div>

                    <div class="relative bg-white rounded-2xl shadow-xl max-w-2xl w-full p-6 transform transition-all">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-2xl font-bold text-gray-900">
                                {{ $editingId ? 'Edit Parameter' : 'Create New Parameter' }}
                            </h3>
                            <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600 transition">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>

                        <form wire:submit.prevent="save" class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
                                <input wire:model="name" type="text"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                                    placeholder="Enter parameter name">
                                @error('name')
                                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Sector</label>
                                <select wire:model="data_sector_id"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                                    <option value="">Select a sector</option>
                                    @foreach ($sectors as $sector)
                                        <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                                    @endforeach
                                </select>
                                @error('data_sector_id')
                                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                <textarea wire:model="description" rows="4"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                                    placeholder="Enter description"></textarea>
                                @error('description')
                                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="flex items-center">
                                <input wire:model="is_active" type="checkbox" id="is_active"
                                    class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <label for="is_active" class="ml-3 text-sm font-medium text-gray-700">Active</label>
                            </div>

                            <div class="flex items-center justify-end gap-3 pt-4">
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
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Delete Parameter</h3>
                            <p class="text-gray-600 mb-6">Are you sure you want to delete this parameter? This action
                                cannot be undone.</p>

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
