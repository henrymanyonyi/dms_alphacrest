<div>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-gray-50">
        <!-- Hero Section -->
        <section class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 text-white py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">Data Marketplace</h1>
                    <p class="text-xl text-blue-100 max-w-3xl mx-auto">
                        Access comprehensive development data across 9 major sectors. Purchase verified datasets with
                        instant downloads.
                    </p>
                </div>

                <!-- Stats Bar -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                    <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-xl p-4 text-center">
                        <div class="text-3xl font-bold mb-1">{{ $stats['total_datasets'] }}</div>
                        <div class="text-sm text-blue-100">Available Datasets</div>
                    </div>
                    <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-xl p-4 text-center">
                        <div class="text-3xl font-bold mb-1">{{ $stats['sectors'] }}</div>
                        <div class="text-sm text-blue-100">Data Sectors</div>
                    </div>
                    <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-xl p-4 text-center">
                        <div class="text-3xl font-bold mb-1">{{ number_format($stats['total_downloads']) }}+</div>
                        <div class="text-sm text-blue-100">Downloads</div>
                    </div>
                    <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-xl p-4 text-center">
                        <div class="text-3xl font-bold mb-1">{{ $stats['avg_rating'] }}<i
                                class="fas fa-star text-yellow-300 text-sm ml-1"></i></div>
                        <div class="text-sm text-blue-100">Avg Rating</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Purchase Success Message -->
        @if (session()->has('purchase_success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg" x-data="{ show: true }"
                    x-show="show" x-init="setTimeout(() => show = false, 5000)">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 text-2xl mr-3"></i>
                        <div>
                            <p class="text-green-800 font-medium">{{ session('purchase_success') }}</p>
                            <p class="text-green-700 text-sm mt-1">Check your email for the download link and receipt.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <!-- Filters Sidebar -->
                <aside class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sticky top-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-bold text-gray-900">Filters</h3>
                            @if ($search || $selectedSector || $selectedParameter || $priceRange !== 'all')
                                <button wire:click="clearFilters"
                                    class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                                    Clear All
                                </button>
                            @endif
                        </div>

                        <!-- Search -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                            <div class="relative">
                                <i
                                    class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <input wire:model.live.debounce.300ms="search" type="text"
                                    placeholder="Search datasets..."
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                            </div>
                        </div>

                        <!-- Sector Filter -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sector</label>
                            <select wire:model.live="selectedSector"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                <option value="">All Sectors</option>
                                @foreach ($sectors as $sector)
                                    <option value="{{ $sector->id }}">{{ $sector->name }}
                                        ({{ $sector->parameters_count }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Parameter Filter -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Parameter</label>
                            <select wire:model.live="selectedParameter"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                <option value="">All Parameters</option>
                                @foreach ($parameters as $parameter)
                                    <option value="{{ $parameter->id }}">{{ $parameter->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Price Range -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Price Range</label>
                            <select wire:model.live="priceRange"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                <option value="all">All Prices</option>
                                <option value="0-500">Under KES 500</option>
                                <option value="500-1000">KES 500 - 1,000</option>
                                <option value="1000-2000">KES 1,000 - 2,000</option>
                                <option value="2000+">Above KES 2,000</option>
                            </select>
                        </div>

                        <!-- Sort -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                            <select wire:model.live="sortBy"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                <option value="latest">Latest First</option>
                                <option value="oldest">Oldest First</option>
                                <option value="name">Name (A-Z)</option>
                            </select>
                        </div>

                        <!-- Featured Badge -->
                        <div
                            class="mt-6 p-4 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl border border-blue-100">
                            <div class="flex items-center space-x-2 mb-2">
                                <i class="fas fa-shield-alt text-blue-600"></i>
                                <span class="text-sm font-semibold text-gray-900">Verified Data</span>
                            </div>
                            <p class="text-xs text-gray-600">All datasets are verified and sourced from official
                                government agencies.</p>
                        </div>
                    </div>
                </aside>

                <!-- Main Content Area -->
                <main class="lg:col-span-3">
                    <!-- View Controls -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 mb-6">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-600">
                                    Showing <span class="font-semibold text-gray-900">{{ $dataPoints->count() }}</span>
                                    of
                                    <span class="font-semibold text-gray-900">{{ $dataPoints->total() }}</span>
                                    datasets
                                </span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button wire:click="$set('viewMode', 'grid')"
                                    class="p-2 rounded-lg transition {{ $viewMode === 'grid' ? 'bg-blue-100 text-blue-600' : 'text-gray-500 hover:bg-gray-100' }}">
                                    <i class="fas fa-th-large"></i>
                                </button>
                                <button wire:click="$set('viewMode', 'list')"
                                    class="p-2 rounded-lg transition {{ $viewMode === 'list' ? 'bg-blue-100 text-blue-600' : 'text-gray-500 hover:bg-gray-100' }}">
                                    <i class="fas fa-list"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Data Points Grid/List -->
                    @if ($viewMode === 'grid')
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
                            @forelse($dataPoints as $dataPoint)
                                <div
                                    class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                    <!-- Card Header with Badge -->
                                    <div class="relative h-32 bg-gradient-to-br from-blue-500 to-indigo-600 p-4">
                                        <div class="absolute top-4 right-4">
                                            @if ($dataPoint->attachments->count() > 0)
                                                <span
                                                    class="inline-flex items-center px-3 py-1 bg-white bg-opacity-90 rounded-full text-xs font-semibold text-gray-900">
                                                    <i class="fas fa-file-alt mr-1"></i>
                                                    {{ $dataPoint->attachments->count() }}
                                                    {{ Str::plural('file', $dataPoint->attachments->count()) }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="absolute bottom-4 left-4">
                                            @if ($dataPoint->parameter && $dataPoint->parameter->sector)
                                                <span
                                                    class="inline-flex items-center px-3 py-1 bg-white bg-opacity-20 backdrop-blur-sm text-white rounded-full text-xs font-medium">
                                                    {{ $dataPoint->parameter->sector->name }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Card Body -->
                                    <div class="p-6">
                                        <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">
                                            {{ $dataPoint->name }}</h3>

                                        @if ($dataPoint->parameter)
                                            <p class="text-sm text-blue-600 mb-3">
                                                <i class="fas fa-tag mr-1"></i>
                                                {{ $dataPoint->parameter->name }}
                                            </p>
                                        @endif

                                        <p class="text-sm text-gray-600 mb-4 line-clamp-3">
                                            {{ Str::limit($dataPoint->description, 100) ?? 'No description available' }}
                                        </p>

                                        <div class="flex items-center justify-between mb-4 text-xs text-gray-500">
                                            <span>
                                                <i class="fas fa-calendar mr-1"></i>
                                                {{ $dataPoint->created_at->format('M d, Y') }}
                                            </span>
                                            <span>
                                                <i class="fas fa-download mr-1"></i>
                                                {{ rand(10, 500) }} downloads
                                            </span>
                                        </div>

                                        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                                            <div>
                                                <div class="text-2xl font-bold text-gray-900">KES
                                                    {{ number_format($this->getPrice($dataPoint)) }}</div>
                                                <div class="text-xs text-gray-500">One-time purchase</div>
                                            </div>
                                            <button wire:click="previewData({{ $dataPoint->id }})"
                                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition">
                                                Preview
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full">
                                    <div
                                        class="bg-white rounded-2xl shadow-sm border border-gray-200 p-12 text-center">
                                        <i class="fas fa-search text-gray-300 text-6xl mb-4"></i>
                                        <h3 class="text-xl font-semibold text-gray-900 mb-2">No datasets found</h3>
                                        <p class="text-gray-600 mb-6">Try adjusting your filters or search terms</p>
                                        <button wire:click="clearFilters"
                                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition">
                                            Clear Filters
                                        </button>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    @else
                        <!-- List View -->
                        <div class="space-y-4 mb-8">
                            @forelse($dataPoints as $dataPoint)
                                <div
                                    class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition">
                                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                                        <div class="flex-1">
                                            <div class="flex items-start gap-4">
                                                <div
                                                    class="flex-shrink-0 w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                                                    <i class="fas fa-database text-white text-2xl"></i>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <h3 class="text-lg font-bold text-gray-900 mb-1">
                                                        {{ $dataPoint->name }}</h3>
                                                    <div class="flex items-center gap-3 mb-2">
                                                        @if ($dataPoint->parameter && $dataPoint->parameter->sector)
                                                            <span
                                                                class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-medium">
                                                                {{ $dataPoint->parameter->sector->name }}
                                                            </span>
                                                        @endif
                                                        @if ($dataPoint->parameter)
                                                            <span class="text-sm text-gray-600">
                                                                <i class="fas fa-tag mr-1"></i>
                                                                {{ $dataPoint->parameter->name }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <p class="text-sm text-gray-600 line-clamp-2">
                                                        {{ Str::limit($dataPoint->description, 150) ?? 'No description available' }}
                                                    </p>
                                                    <div class="flex items-center gap-4 mt-3 text-xs text-gray-500">
                                                        <span><i
                                                                class="fas fa-calendar mr-1"></i>{{ $dataPoint->created_at->format('M d, Y') }}</span>
                                                        <span><i class="fas fa-download mr-1"></i>{{ rand(10, 500) }}
                                                            downloads</span>
                                                        @if ($dataPoint->attachments->count() > 0)
                                                            <span><i
                                                                    class="fas fa-paperclip mr-1"></i>{{ $dataPoint->attachments->count() }}
                                                                files</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex flex-col items-end gap-2">
                                            <div class="text-right">
                                                <div class="text-2xl font-bold text-gray-900">KES
                                                    {{ number_format($this->getPrice($dataPoint)) }}</div>
                                                <div class="text-xs text-gray-500">One-time purchase</div>
                                            </div>
                                            <button wire:click="previewData({{ $dataPoint->id }})"
                                                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition">
                                                Preview & Buy
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-12 text-center">
                                    <i class="fas fa-search text-gray-300 text-6xl mb-4"></i>
                                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No datasets found</h3>
                                    <p class="text-gray-600 mb-6">Try adjusting your filters or search terms</p>
                                    <button wire:click="clearFilters"
                                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition">
                                        Clear Filters
                                    </button>
                                </div>
                            @endforelse
                        </div>
                    @endif

                    <!-- Pagination -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4">
                        {{ $dataPoints->links() }}
                    </div>
                </main>
            </div>
        </div>

        <!-- Preview Modal -->
        @if ($showPreview && $previewingDataPoint)
            <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: @entangle('showPreview') }">
                <div class="flex items-center justify-center min-h-screen px-4 py-8">
                    <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" wire:click="closePreview">
                    </div>

                    <div
                        class="relative bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden transform transition-all">
                        <!-- Modal Header -->
                        <div class="sticky top-0 bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-6 z-10">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="text-2xl font-bold mb-2">{{ $previewingDataPoint->name }}</h3>
                                    <div class="flex items-center gap-3">
                                        @if ($previewingDataPoint->parameter && $previewingDataPoint->parameter->sector)
                                            <span
                                                class="inline-flex items-center px-3 py-1 bg-white bg-opacity-20 backdrop-blur-sm rounded-full text-sm font-medium">
                                                {{ $previewingDataPoint->parameter->sector->name }}
                                            </span>
                                        @endif
                                        @if ($previewingDataPoint->parameter)
                                            <span class="text-sm text-blue-100">
                                                <i class="fas fa-tag mr-1"></i>
                                                {{ $previewingDataPoint->parameter->name }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <button wire:click="closePreview"
                                    class="text-white hover:text-gray-200 transition ml-4">
                                    <i class="fas fa-times text-2xl"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Modal Body -->
                        <div class="p-6 overflow-y-auto max-h-[calc(90vh-200px)]">
                            <!-- Price Banner -->
                            <div
                                class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-4 mb-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="text-3xl font-bold text-gray-900">KES
                                            {{ number_format($this->getPrice($previewingDataPoint)) }}</div>
                                        <div class="text-sm text-gray-600">One-time purchase • Lifetime access</div>
                                    </div>
                                    <button wire:click="initiatePurchase({{ $previewingDataPoint->id }})"
                                        class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl font-semibold transition transform hover:scale-105">
                                        <i class="fas fa-shopping-cart mr-2"></i>
                                        Purchase Now
                                    </button>
                                </div>
                            </div>

                            <!-- Data Info Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <div class="text-sm text-gray-600 mb-1">Data Source</div>
                                    <div class="font-semibold text-gray-900">
                                        {{ $previewingDataPoint->data_source ?? 'Not specified' }}</div>
                                </div>
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <div class="text-sm text-gray-600 mb-1">Data Date</div>
                                    <div class="font-semibold text-gray-900">
                                        @if ($previewingDataPoint->data_date)
                                            {{ \Carbon\Carbon::parse($previewingDataPoint->data_date)->format('F d, Y') }}
                                        @else
                                            Not specified
                                        @endif
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <div class="text-sm text-gray-600 mb-1">Created</div>
                                    <div class="font-semibold text-gray-900">
                                        {{ $previewingDataPoint->created_at->format('F d, Y') }}</div>
                                </div>
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <div class="text-sm text-gray-600 mb-1">Downloads</div>
                                    <div class="font-semibold text-gray-900">{{ rand(10, 500) }}+ purchases</div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="mb-6">
                                <h4 class="text-lg font-bold text-gray-900 mb-3">Description</h4>
                                <div class="prose prose-sm max-w-none text-gray-600">
                                    {{ $previewingDataPoint->description ?? 'No description available for this dataset.' }}
                                </div>
                            </div>

                            <!-- Data Indicator -->
                            @if ($previewingDataPoint->data_indicator)
                                <div class="mb-6">
                                    <h4 class="text-lg font-bold text-gray-900 mb-3">Data Indicator</h4>
                                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                                        <p class="text-gray-700">{{ $previewingDataPoint->data_indicator }}</p>
                                    </div>
                                </div>
                            @endif

                            <!-- Source URL -->
                            @if ($previewingDataPoint->source_url)
                                <div class="mb-6">
                                    <h4 class="text-lg font-bold text-gray-900 mb-3">Source Reference</h4>
                                    <a href="{{ $previewingDataPoint->source_url }}" target="_blank"
                                        class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium">
                                        <i class="fas fa-external-link-alt mr-2"></i>
                                        View Original Source
                                    </a>
                                </div>
                            @endif

                            <!-- Attachments Preview -->
                            @if ($previewingDataPoint->attachments->count() > 0)
                                <div class="mb-6">
                                    <h4 class="text-lg font-bold text-gray-900 mb-3">
                                        Included Files ({{ $previewingDataPoint->attachments->count() }})
                                    </h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        @foreach ($previewingDataPoint->attachments as $attachment)
                                            <div
                                                class="flex items-center space-x-3 p-3 bg-gray-50 rounded-xl border border-gray-200">
                                                <div
                                                    class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                                    <i
                                                        class="fas fa-file-{{ $attachment->file_type }} text-blue-600"></i>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-900 truncate">
                                                        {{ $attachment->file_name }}</p>
                                                    <p class="text-xs text-gray-500">
                                                        {{ number_format($attachment->file_size / 1024, 2) }} KB</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- What You Get -->
                            <div
                                class="bg-gradient-to-br from-indigo-50 to-purple-50 border border-indigo-200 rounded-xl p-6">
                                <h4 class="text-lg font-bold text-gray-900 mb-4">What You'll Get</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="flex items-start space-x-3">
                                        <i class="fas fa-check-circle text-green-600 text-xl mt-1"></i>
                                        <div>
                                            <div class="font-medium text-gray-900">Instant Download</div>
                                            <div class="text-sm text-gray-600">Immediate access after payment</div>
                                        </div>
                                    </div>
                                    <div class="flex items-start space-x-3">
                                        <i class="fas fa-check-circle text-green-600 text-xl mt-1"></i>
                                        <div>
                                            <div class="font-medium text-gray-900">Multiple Formats</div>
                                            <div class="text-sm text-gray-600">Excel, PDF, CSV available</div>
                                        </div>
                                    </div>
                                    <div class="flex items-start space-x-3">
                                        <i class="fas fa-check-circle text-green-600 text-xl mt-1"></i>
                                        <div>
                                            <div class="font-medium text-gray-900">Verified Data</div>
                                            <div class="text-sm text-gray-600">From official sources</div>
                                        </div>
                                    </div>
                                    <div class="flex items-start space-x-3">
                                        <i class="fas fa-check-circle text-green-600 text-xl mt-1"></i>
                                        <div>
                                            <div class="font-medium text-gray-900">Lifetime Access</div>
                                            <div class="text-sm text-gray-600">Re-download anytime</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="sticky bottom-0 bg-gray-50 border-t border-gray-200 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-2xl font-bold text-gray-900">KES
                                        {{ number_format($this->getPrice($previewingDataPoint)) }}</div>
                                    <div class="text-sm text-gray-600">Secure payment • Instant access</div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <button wire:click="closePreview"
                                        class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 font-medium transition">
                                        Close
                                    </button>
                                    <button wire:click="initiatePurchase({{ $previewingDataPoint->id }})"
                                        class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl font-semibold transition transform hover:scale-105">
                                        <i class="fas fa-lock mr-2"></i>
                                        Secure Purchase
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Purchase Modal -->
        @if ($showPurchase && $purchasingDataPoint)
            <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: @entangle('showPurchase') }">
                <div class="flex items-center justify-center min-h-screen px-4 py-8">
                    <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity"
                        wire:click="closePurchase"></div>

                    <div class="relative bg-white rounded-2xl shadow-2xl max-w-2xl w-full transform transition-all">
                        <!-- Header -->
                        <div class="bg-gradient-to-r from-green-600 to-emerald-600 text-white p-6 rounded-t-2xl">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-2xl font-bold mb-1">Complete Your Purchase</h3>
                                    <p class="text-green-100 text-sm">Secure payment processing</p>
                                </div>
                                <button wire:click="closePurchase" class="text-white hover:text-gray-200 transition">
                                    <i class="fas fa-times text-2xl"></i>
                                </button>
                            </div>
                        </div>

                        <form wire:submit.prevent="processPurchase" class="p-6">
                            <!-- Order Summary -->
                            <div class="bg-gray-50 rounded-xl p-4 mb-6">
                                <h4 class="font-semibold text-gray-900 mb-3">Order Summary</h4>
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex-1">
                                        <p class="font-medium text-gray-900">{{ $purchasingDataPoint->name }}</p>
                                        <p class="text-sm text-gray-600 mt-1">
                                            @if ($purchasingDataPoint->parameter && $purchasingDataPoint->parameter->sector)
                                                {{ $purchasingDataPoint->parameter->sector->name }} •
                                            @endif
                                            {{ $purchasingDataPoint->attachments->count() }}
                                            {{ Str::plural('file', $purchasingDataPoint->attachments->count()) }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xl font-bold text-gray-900">KES
                                            {{ number_format($this->getPrice($purchasingDataPoint)) }}</p>
                                    </div>
                                </div>
                                <div class="border-t border-gray-200 pt-3 flex items-center justify-between">
                                    <span class="font-semibold text-gray-900">Total Amount</span>
                                    <span class="text-2xl font-bold text-green-600">KES
                                        {{ number_format($this->getPrice($purchasingDataPoint)) }}</span>
                                </div>
                            </div>

                            <!-- Payment Method -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-3">Select Payment
                                    Method</label>
                                <div class="grid grid-cols-1 gap-3">
                                    <!-- M-Pesa -->
                                    <label
                                        class="relative flex items-center p-4 border-2 rounded-xl cursor-pointer transition {{ $paymentMethod === 'mpesa' ? 'border-green-600 bg-green-50' : 'border-gray-200 hover:border-gray-300' }}">
                                        <input wire:model.live="paymentMethod" type="radio" value="mpesa"
                                            class="w-5 h-5 text-green-600 focus:ring-green-500">
                                        <div class="ml-4 flex-1">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <span class="font-semibold text-gray-900">M-Pesa</span>
                                                    <p class="text-sm text-gray-600">Pay with your mobile money</p>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <div
                                                        class="w-12 h-8 bg-green-600 rounded flex items-center justify-center">
                                                        <span class="text-white font-bold text-xs">M-PESA</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </label>

                                    {{-- <!-- Card Payment -->
                                    <label
                                        class="relative flex items-center p-4 border-2 rounded-xl cursor-pointer transition {{ $paymentMethod === 'card' ? 'border-blue-600 bg-blue-50' : 'border-gray-200 hover:border-gray-300' }}">
                                        <input wire:model.live="paymentMethod" type="radio" value="card"
                                            class="w-5 h-5 text-blue-600 focus:ring-blue-500">
                                        <div class="ml-4 flex-1">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <span class="font-semibold text-gray-900">Credit/Debit Card</span>
                                                    <p class="text-sm text-gray-600">Visa, Mastercard accepted</p>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <i class="fab fa-cc-visa text-blue-600 text-2xl"></i>
                                                    <i class="fab fa-cc-mastercard text-red-600 text-2xl"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </label>

                                    <!-- PayPal -->
                                    <label
                                        class="relative flex items-center p-4 border-2 rounded-xl cursor-pointer transition {{ $paymentMethod === 'paypal' ? 'border-blue-600 bg-blue-50' : 'border-gray-200 hover:border-gray-300' }}">
                                        <input wire:model.live="paymentMethod" type="radio" value="paypal"
                                            class="w-5 h-5 text-blue-600 focus:ring-blue-500">
                                        <div class="ml-4 flex-1">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <span class="font-semibold text-gray-900">PayPal</span>
                                                    <p class="text-sm text-gray-600">Pay with PayPal balance</p>
                                                </div>
                                                <i class="fab fa-paypal text-blue-600 text-3xl"></i>
                                            </div>
                                        </div>
                                    </label> --}}
                                </div>
                                @error('paymentMethod')
                                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- M-Pesa Phone Number -->
                            @if ($paymentMethod === 'mpesa')
                                <div class="mb-6">
                                    <label class="block text-sm font-semibold text-gray-900 mb-2">M-Pesa Phone
                                        Number</label>
                                    <div class="relative">
                                        <span
                                            class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-600 font-medium">+254</span>
                                        <input wire:model="phoneNumber" type="text" placeholder="712345678"
                                            maxlength="9"
                                            class="w-full pl-16 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent text-lg">
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        You will receive an STK push prompt on your phone
                                    </p>
                                    @error('phoneNumber')
                                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif

                            <!-- Terms and Conditions -->
                            <div class="mb-6">
                                <label class="flex items-start cursor-pointer">
                                    <input wire:model="agreedToTerms" type="checkbox"
                                        class="w-5 h-5 text-green-600 border-gray-300 rounded focus:ring-green-500 mt-0.5">
                                    <span class="ml-3 text-sm text-gray-700">
                                        I agree to the <a href="#"
                                            class="text-blue-600 hover:text-blue-700 font-medium">Terms of Service</a>
                                        and
                                        <a href="#"
                                            class="text-blue-600 hover:text-blue-700 font-medium">Privacy Policy</a>. I
                                        understand this is a one-time payment for lifetime access to the dataset.
                                    </span>
                                </label>
                                @error('agreedToTerms')
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Security Notice -->
                            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
                                <div class="flex items-start space-x-3">
                                    <i class="fas fa-shield-alt text-blue-600 text-xl mt-1"></i>
                                    <div class="flex-1">
                                        <h5 class="font-semibold text-gray-900 mb-1">Secure Payment</h5>
                                        <p class="text-sm text-gray-700">Your payment information is encrypted and
                                            secure. We never store your payment details.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex items-center justify-between gap-3">
                                <button type="button" wire:click="closePurchase"
                                    class="flex-1 px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 font-semibold transition">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="flex-1 px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white rounded-xl font-semibold transition transform hover:scale-105 shadow-lg">
                                    <i class="fas fa-lock mr-2"></i>
                                    Pay KES {{ number_format($this->getPrice($purchasingDataPoint)) }}
                                </button>
                            </div>

                            <!-- After Purchase Info -->
                            <div class="mt-6 text-center">
                                <p class="text-xs text-gray-500">
                                    <i class="fas fa-download mr-1"></i>
                                    After payment, you'll receive instant download access via email
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        <!-- Floating Help Button -->
        <div class="fixed bottom-8 right-8 z-40">
            <button
                class="w-14 h-14 bg-blue-600 hover:bg-blue-700 text-white rounded-full shadow-2xl flex items-center justify-center transition transform hover:scale-110">
                <i class="fas fa-question text-xl"></i>
            </button>
        </div>
    </div>
</div>
