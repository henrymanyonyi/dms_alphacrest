<div>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 p-4 md:p-6 lg:p-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Dashboard</h1>
                <p class="text-gray-600">Overview of your data management system</p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <!-- Data Sectors Card -->
                <div
                    class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white transform transition hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium mb-1">Data Sectors</p>
                            <h3 class="text-4xl font-bold">{{ $stats['sectors'] }}</h3>
                            <p class="text-blue-100 text-sm mt-2">
                                <i class="fas fa-check-circle mr-1"></i>
                                {{ $stats['activeSectors'] }} Active
                            </p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-4">
                            <i class="fas fa-layer-group text-3xl"></i>
                        </div>
                    </div>
                    <a href="{{ route('data-sectors.index') }}"
                        class="inline-flex items-center mt-4 text-sm font-medium hover:text-blue-100 transition">
                        Manage Sectors <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <!-- Data Parameters Card -->
                <div
                    class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg p-6 text-white transform transition hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100 text-sm font-medium mb-1">Parameters</p>
                            <h3 class="text-4xl font-bold">{{ $stats['parameters'] }}</h3>
                            <p class="text-purple-100 text-sm mt-2">
                                <i class="fas fa-check-circle mr-1"></i>
                                {{ $stats['activeParameters'] }} Active
                            </p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-4">
                            <i class="fas fa-sliders-h text-3xl"></i>
                        </div>
                    </div>
                    <a href="{{ route('data-parameters.index') }}"
                        class="inline-flex items-center mt-4 text-sm font-medium hover:text-purple-100 transition">
                        Manage Parameters <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <!-- Data Points Card -->
                <div
                    class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg p-6 text-white transform transition hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm font-medium mb-1">Data Points</p>
                            <h3 class="text-4xl font-bold">{{ $stats['dataPoints'] }}</h3>
                            <p class="text-green-100 text-sm mt-2">
                                <i class="fas fa-check-circle mr-1"></i>
                                {{ $stats['activeDataPoints'] }} Active
                            </p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-4">
                            <i class="fas fa-chart-line text-3xl"></i>
                        </div>
                    </div>
                    <a href="{{ route('data-points.index') }}"
                        class="inline-flex items-center mt-4 text-sm font-medium hover:text-green-100 transition">
                        Manage Data Points <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>

            <!-- Recent Activity Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Data Points -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-900">Recent Data Points</h2>
                        <a href="{{ route('data-points.index') }}"
                            class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                            View All <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>

                    <div class="space-y-4">
                        @forelse($recentDataPoints as $point)
                            <div
                                class="flex items-start space-x-4 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                                <div
                                    class="flex-shrink-0 w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-chart-bar text-indigo-600"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $point->name }}</p>
                                    @if ($point->parameter)
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $point->parameter->name }}
                                            @if ($point->parameter->sector)
                                                <span class="text-gray-400">•
                                                    {{ $point->parameter->sector->name }}</span>
                                            @endif
                                        </p>
                                    @endif
                                    <p class="text-xs text-gray-400 mt-1">
                                        <i class="fas fa-clock mr-1"></i>
                                        {{ $point->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                <span
                                    class="flex-shrink-0 inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $point->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $point->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <i class="fas fa-inbox text-gray-300 text-4xl mb-3"></i>
                                <p class="text-gray-500">No data points yet</p>
                                <a href="{{ route('data-points.index') }}"
                                    class="inline-flex items-center mt-3 text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                                    Create your first data point <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Sectors -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-900">Recent Sectors</h2>
                        <a href="{{ route('data-sectors.index') }}"
                            class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                            View All <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>

                    <div class="space-y-4">
                        @forelse($recentSectors as $sector)
                            <div
                                class="flex items-start space-x-4 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                                <div
                                    class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-layer-group text-blue-600"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $sector->name }}</p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ Str::limit($sector->description, 60) ?? 'No description' }}
                                    </p>
                                    <div class="flex items-center mt-2 space-x-4">
                                        <span class="text-xs text-gray-400">
                                            <i class="fas fa-sliders-h mr-1"></i>
                                            {{ $sector->parameters_count }}
                                            {{ Str::plural('parameter', $sector->parameters_count) }}
                                        </span>
                                        <span class="text-xs text-gray-400">
                                            <i class="fas fa-clock mr-1"></i>
                                            {{ $sector->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                                <span
                                    class="flex-shrink-0 inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $sector->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $sector->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <i class="fas fa-inbox text-gray-300 text-4xl mb-3"></i>
                                <p class="text-gray-500">No sectors yet</p>
                                <a href="{{ route('data-sectors.index') }}"
                                    class="inline-flex items-center mt-3 text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                                    Create your first sector <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-8 bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Quick Actions</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <a href="{{ route('data-sectors.index') }}"
                        class="flex items-center p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl hover:from-blue-100 hover:to-blue-200 transition group">
                        <div
                            class="flex-shrink-0 w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center text-white group-hover:scale-110 transition">
                            <i class="fas fa-plus text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-semibold text-gray-900">New Sector</p>
                            <p class="text-xs text-gray-600">Create a data sector</p>
                        </div>
                    </a>

                    <a href="{{ route('data-parameters.index') }}"
                        class="flex items-center p-4 bg-gradient-to-r from-purple-50 to-purple-100 rounded-xl hover:from-purple-100 hover:to-purple-200 transition group">
                        <div
                            class="flex-shrink-0 w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center text-white group-hover:scale-110 transition">
                            <i class="fas fa-plus text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-semibold text-gray-900">New Parameter</p>
                            <p class="text-xs text-gray-600">Add a parameter</p>
                        </div>
                    </a>

                    <a href="{{ route('data-points.index') }}"
                        class="flex items-center p-4 bg-gradient-to-r from-green-50 to-green-100 rounded-xl hover:from-green-100 hover:to-green-200 transition group">
                        <div
                            class="flex-shrink-0 w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center text-white group-hover:scale-110 transition">
                            <i class="fas fa-plus text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-semibold text-gray-900">New Data Point</p>
                            <p class="text-xs text-gray-600">Create data entry</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
