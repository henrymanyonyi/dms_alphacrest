<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alphacrest Data - Development Data Marketplace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
    @livewireStyles
</head>

<body class="bg-gray-50">
    <!-- Top Navigation -->
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="{{ route('marketplace') }}" class="flex items-center space-x-3">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center">
                        <span class="text-white font-bold text-lg">A</span>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-gray-900">Alphacrest Data</h1>
                        <p class="text-xs text-gray-500 hidden sm:block">Development Data Platform</p>
                    </div>
                </a>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('marketplace') }}"
                        class="text-sm font-medium text-gray-900 hover:text-blue-600 transition">
                        Marketplace
                    </a>
                    <a href="#sectors" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition">
                        Sectors
                    </a>
                    <a href="#about" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition">
                        About
                    </a>
                    <a href="#contact" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition">
                        Contact
                    </a>
                    <a href="{{ route('my-purchases') }}"
                        class="text-sm font-medium text-gray-900 hover:text-blue-600 transition">
                        My Purchases
                    </a>
                </div>

                <!-- Auth Buttons -->
                <div class="flex items-center space-x-3">
                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="hidden sm:inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm font-medium transition">
                            <i class="fas fa-tachometer-alt mr-2"></i>
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-sm font-medium text-gray-600 hover:text-gray-900 transition">
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium transition">
                            Get Started
                        </a>
                    @endauth

                    <!-- Mobile Menu Button -->
                    <button x-data @click="$dispatch('toggle-mobile-menu')"
                        class="md:hidden text-gray-600 hover:text-gray-900">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-data="{ open: false }" @toggle-mobile-menu.window="open = !open" x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95" class="md:hidden border-t border-gray-200">
            <div class="px-4 py-3 space-y-2">
                <a href="{{ route('marketplace') }}"
                    class="block px-4 py-2 text-sm font-medium text-gray-900 bg-gray-50 rounded-lg">
                    Marketplace
                </a>
                <a href="#sectors"
                    class="block px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg">
                    Sectors
                </a>
                <a href="#about" class="block px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg">
                    About
                </a>
                <a href="#contact"
                    class="block px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg">
                    Contact
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <!-- About -->
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center">
                            <span class="text-white font-bold text-lg">A</span>
                        </div>
                        <h3 class="text-xl font-bold">Alphacrest Data</h3>
                    </div>
                    <p class="text-gray-400 mb-4 max-w-md">
                        Your trusted source for comprehensive development data across Kenya. Access verified datasets
                        from government agencies and official sources.
                    </p>
                    <div class="flex items-center space-x-4">
                        <a href="#"
                            class="w-10 h-10 bg-gray-800 hover:bg-gray-700 rounded-lg flex items-center justify-center transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-gray-800 hover:bg-gray-700 rounded-lg flex items-center justify-center transition">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-gray-800 hover:bg-gray-700 rounded-lg flex items-center justify-center transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">About Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Data Sectors</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Pricing</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">API Access</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Support</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Help Center</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Contact Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Terms of Service</a>
                        </li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row items-center justify-between">
                <p class="text-gray-400 text-sm mb-4 md:mb-0">
                    &copy; {{ now()->year }} Alphacrest Data Platform. All rights reserved.
                </p>
                <div class="flex items-center space-x-6 text-sm text-gray-400">
                    <span><i class="fas fa-shield-alt text-green-500 mr-2"></i>Secure Payments</span>
                    <span><i class="fas fa-lock text-blue-500 mr-2"></i>Encrypted</span>
                    <span><i class="fas fa-check-circle text-green-500 mr-2"></i>Verified Data</span>
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts
    {{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}
</body>

</html>
