{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- tailwindcss -->
    <script src="https://cdn.tailwindcss.com"></script>

        <title>{{ $title ?? 'Page Title' }}</title>
    </head>
    <body>
        {{ $slot }}
    </body>
</html> --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @livewireStyles
</head>

<body class="bg-gray-50">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen">
        <!-- Mobile Sidebar Backdrop -->
        <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="sidebarOpen = false"
            class="fixed inset-0 bg-gray-900 bg-opacity-50 z-40 lg:hidden"></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 transform transition-transform duration-300 ease-in-out lg:translate-x-0">

            <!-- Logo -->
            <div class="flex items-center justify-between h-16 px-6 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-database text-white text-lg"></i>
                    </div>
                    <span class="text-xl font-bold text-gray-900">DataHub</span>
                </div>
                <button @click="sidebarOpen = false" class="lg:hidden text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center space-x-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <i class="fas fa-home text-lg w-5"></i>
                    <span class="font-medium">Dashboard</span>
                </a>

                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Data Management</p>
                </div>

                <a href="{{ route('data-sectors.index') }}"
                    class="flex items-center space-x-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('data-sectors.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <i class="fas fa-layer-group text-lg w-5"></i>
                    <span class="font-medium">Sectors</span>
                </a>

                <a href="{{ route('data-parameters.index') }}"
                    class="flex items-center space-x-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('data-parameters.*') ? 'bg-purple-50 text-purple-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <i class="fas fa-sliders-h text-lg w-5"></i>
                    <span class="font-medium">Parameters</span>
                </a>

                <a href="{{ route('data-points.index') }}"
                    class="flex items-center space-x-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('data-points.*') ? 'bg-green-50 text-green-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <i class="fas fa-chart-line text-lg w-5"></i>
                    <span class="font-medium">Data Points</span>
                </a>

                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Marketplace</p>
                </div>

                <a href="{{ route('marketplace') }}"
                    class="flex items-center space-x-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('marketplace*') ? 'bg-orange-50 text-orange-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <i class="fas fa-store text-lg w-5"></i>
                    <span class="font-medium">Browse Data</span>
                </a>

                <a href="{{ route('my-purchases') }}"
                    class="flex items-center space-x-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('my-purchases') ? 'bg-teal-50 text-teal-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <i class="fas fa-shopping-bag text-lg w-5"></i>
                    <span class="font-medium">My Purchases</span>
                </a>
            </nav>

            <!-- User Section -->
            <div class="border-t border-gray-200 p-4">
                <div class="flex items-center space-x-3">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white font-semibold">
                        {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->name ?? 'User' }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email ?? 'user@example.com' }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center space-x-2 px-4 py-2 text-sm font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="lg:pl-64">
            <!-- Top Bar -->
            <header class="sticky top-0 z-30 bg-white border-b border-gray-200">
                <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                    <button @click="sidebarOpen = true" class="lg:hidden text-gray-500 hover:text-gray-700">
                        <i class="fas fa-bars text-xl"></i>
                    </button>

                    <div class="flex items-center space-x-4 ml-auto">
                        <div class="hidden sm:block text-right">
                            <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name ?? 'User' }}</p>
                            <p class="text-xs text-gray-500">{{ now()->format('l, F j, Y') }}</p>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 mt-auto">
                <div class="px-4 sm:px-6 lg:px-8 py-4">
                    <p class="text-center text-sm text-gray-500">
                        &copy; {{ now()->year }} DataHub. All rights reserved.
                    </p>
                </div>
            </footer>
        </div>
    </div>

    @livewireScripts
</body>

</html>


{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FSM') }}</title>
    <link rel="shortcut icon" href="{{ asset('images/Logo-3.png') }} ">

    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <link rel="icon" type="image/x-icon" href="{{ URL::asset('images/logo.png') }}">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary': '#4885ed',
                        'primary-dark': '#3b78e7',
                        'sidebar': '#f7f9fc',
                        'accent-blue': '#4872e8',
                    }
                }
            }
        }
    </script>
    <style>
        /* Custom styles for independent scrolling */
        .sidebar-scroll {
            height: calc(100vh - 60px);
            /* Adjust based on admin dropdown height */
        }
    </style>
    @stack('styles')
    <!-- Styles -->
    @livewireStyles
</head>

<body class="bg-gray-50 text-gray-800">
    <div class="flex min-h-screen">
        <!-- Sidebar with fixed height and independent scroll -->
        <aside id="sidebar"
            class="fixed h-full w-56 bg-white border-r border-gray-200 z-40 flex flex-col transform transition-transform duration-300 md:translate-x-0 -translate-x-full">
            <div class="p-3 border-b border-gray-200">
                <p>{{ env('APP_NAME') }}</p>
            </div>

            <!-- Scrollable content area -->
            @include('layouts.inc.sidemenu')

            <!-- Admin section - fixed at bottom -->
            <div class="border-t border-gray-200 mt-auto flex-shrink-0">
                <!-- Admin dropdown toggle button -->
                <div id="admin-toggle" class="cursor-pointer px-5 py-3 bg-accent-blue text-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div
                                class="w-7 h-7 bg-gray-200 rounded-full flex items-center justify-center mr-3 text-xs text-gray-800">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="font-medium text-sm">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-white">{{ Auth::user()->email }}</div>
                            </div>
                        </div>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </div>
                </div>

                <!-- Admin dropdown menu - initially hidden -->
                <div id="admin-menu" class="hidden">
                    <a href="{{ route('logout') }}" class="flex items-center px-5 py-3 text-sm hover:bg-gray-50"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt w-5 mr-3 text-center"></i>
                        Log out
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content with independent scroll -->
        <main class="flex-1 overflow-y-auto h-screen transition-all duration-300 md:ml-56">
            {{ $slot }}
        </main>
        <!-- scripts -->
        @livewireScripts
        @stack('scripts')
    </div>

    <!-- Mobile menu button -->
    <button id="mobile-menu-btn"
        class="md:hidden fixed bottom-5 right-5 w-12 h-12 bg-accent-blue text-white rounded-full shadow-lg flex items-center justify-center z-50">
        <i class="fas fa-bars"></i>
    </button>

    <script>
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const sidebar = document.getElementById('sidebar');

        mobileMenuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', (e) => {
            if (window.innerWidth < 768 &&
                !sidebar.contains(e.target) &&
                e.target !== mobileMenuBtn) {
                sidebar.classList.add('-translate-x-full');
            }
        });

        // Admin dropdown toggle
        const adminToggle = document.getElementById('admin-toggle');
        const adminMenu = document.getElementById('admin-menu');

        adminToggle.addEventListener('click', () => {
            adminMenu.classList.toggle('hidden');
        });
    </script>
</body>

</html> --}}
