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
                {{-- <img src="{{ URL::asset('images/Logo-3.png') }}" alt="logo" class="h-16 object-contain"> --}}
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
                    {{-- <a href="{{ route('profile.show') }}" class="flex items-center px-5 py-3 text-sm hover:bg-gray-50">
                        <i class="fas fa-cog w-5 mr-3 text-center"></i>
                        Settings
                    </a> --}}

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

</html>
