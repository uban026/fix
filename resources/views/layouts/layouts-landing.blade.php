<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet" />
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .active {
            color: #F2B300;
            font-weight: bold;
        }
    </style>
    @yield('link_css')
</head>

<body class="min-h-screen bg-gray-50">
    <header x-data="{ open: false }" class="bg-white shadow-sm fixed w-full top-0 z-50">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16">
            <div class="flex items-center justify-between h-full">
                <div class="flex-shrink-0">
                    <a href="/" class="flex items-center">
                        <div
                            class="h-10 w-10 bg-gradient-to-r from-yellow-500 to-yellow-700 rounded-xl flex items-center justify-center">
                            <img src="{{ asset('assets/img/logo.png') }}" alt="">
                        </div>
                        <span class="ml-3 text-xl font-bold text-gray-900">Herchitchat</span>
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="/" class="text-gray-600 @yield('home') hover:text-yellow-600">Home</a>
                    <a href="{{ route('product') }}"
                        class="text-gray-600 @yield('product') hover:text-yellow-600">Produk</a>
                    <a href="{{ route('portofolio') }}"
                        class="text-gray-600 @yield('portofolio') hover:text-yellow-600">Portofolio</a>
                    <a href="{{ route('service') }}"
                        class="text-gray-600 @yield('service') hover:text-yellow-600">Service</a>
                    <a href="{{ route('about') }}" class="text-gray-600 @yield('about') hover:text-yellow-600">About
                        Us</a>
                </div>

                <div class="flex items-center gap-4">
                    <a href="/cart" class="relative text-gray-600 hover:text-yellow-600">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span id="cart-count"
                            class="absolute -top-2 -right-2 bg-yellow-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">0</span>
                    </a>

                    <div class="hidden md:flex items-center">
                        @guest
                            <a href="{{ route('login') }}"
                                class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white px-4 py-2 rounded-xl hover:opacity-90 ml-4">Masuk</a>
                        @else
                            <div class="relative ml-4" x-data="{ dropdownOpen: false }">
                                <button @click="dropdownOpen = !dropdownOpen" @click.away="dropdownOpen = false"
                                    class="flex items-center space-x-2 text-gray-600 hover:text-yellow-600 focus:outline-none">
                                    <i class="bi bi-person-circle text-3xl text-yellow-600"></i>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div x-show="dropdownOpen" x-transition
                                    class="absolute right-0 mt-2 w-48 py-2 bg-white rounded-xl shadow-lg border border-gray-100"
                                    style="display: none;">
                                    @if (Auth::user()->isAdmin())
                                        <a href="{{ route('admin.dashboard') }}"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-yellow-600">Dashboard</a>
                                    @endif
                                    <a href="{{ route('user.orders') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-yellow-600">Orders</a>
                                    <div class="border-t border-gray-100 my-1"></div>
                                    <form method="POST" action="{{ route('auth.logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-yellow-600">Logout</button>
                                    </form>
                                </div>
                            </div>
                        @endguest
                    </div>

                    <div class="md:hidden flex items-center">
                        <button @click="open = !open" class="text-gray-600 hover:text-yellow-600 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path :class="{ 'hidden': open, 'inline-flex': !open }" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                                <path :class="{ 'hidden': !open, 'inline-flex': open }" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div x-show="open" x-transition class="md:hidden bg-white">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                    <a href="/"
                        class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-yellow-600 hover:bg-gray-50">Home</a>
                    <a href="{{ route('product') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-yellow-600 hover:bg-gray-50">Produk</a>
                    <a href="{{ route('portofolio') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-yellow-600 hover:bg-gray-50">Portofolio</a>
                    <a href="{{ route('service') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-yellow-600 hover:bg-gray-50">Service</a>
                    <a href="{{ route('about') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-yellow-600 hover:bg-gray-50">About
                        Us</a>
                </div>
                <div class="pt-4 pb-3 border-t border-gray-200">
                    @guest
                        <div class="px-5">
                            <a href="{{ route('login') }}"
                                class="block w-full text-center px-4 py-2 bg-yellow-500 text-white rounded-md font-semibold">Masuk</a>
                        </div>
                    @else
                        <div class="px-5">
                            <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                        </div>
                        <div class="mt-3 px-2 space-y-1">
                            @if (Auth::user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}"
                                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-yellow-600 hover:bg-gray-50">Dashboard</a>
                            @endif
                            <a href="{{ route('user.orders') }}"
                                class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-yellow-600 hover:bg-gray-50">My
                                Orders</a>
                            <form method="POST" action="{{ route('auth.logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-yellow-600 hover:bg-gray-50">Logout</button>
                            </form>
                        </div>
                    @endguest
                </div>
            </div>
        </nav>
    </header>

    <main class="pt-16">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Store Info -->
                <div class="space-y-4">
                    <div class="flex items-center">
                        <img src="{{ asset('assets/img/logo.png') }}" style="width: 64px;" alt="">
                        <span class="ml-3 text-xl font-bold text-gray-900">Herchitchat</span>
                    </div>
                    <p class="text-gray-500">Design dan cetak produk berbagai kebutuhan</p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Quick Links</h3>
                    <div class="mt-4 space-y-2">
                        <a href="/" class="block text-gray-500 hover:text-yellow-600">Home</a>
                        <a href="{{ route('product') }}"
                            class="block text-gray-500 hover:text-yellow-600">Products</a>
                        <a href="{{ route('portofolio') }}"
                            class="block text-gray-500 hover:text-yellow-600">Portofolio</a>
                        <a href="{{ route('service') }}"
                            class="block text-gray-500 hover:text-yellow-600">Service</a>
                        <a href="{{ route('about') }}" class="block text-gray-500 hover:text-yellow-600">About Us</a>
                    </div>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Contact</h3>
                    <div class="mt-4 space-y-2">
                        <p class="text-gray-500">Email: support@store.com</p>
                        <p class="text-gray-500">Phone: (123) 456-7890</p>
                        <p class="text-gray-500">Address: 123 Store Street</p>
                    </div>
                </div>

                <!-- Social Links -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Temukan kami di</h3>
                    <div class="mt-4 flex space-x-4">
                        <a href="https://shopee.co.id/herchitchat" target="_blank"
                            class="text-gray-400 hover:text-yellow-600">
                            <img src="{{ asset('assets/img/shopee-seeklogo.png') }}" style="width: 32px ;"
                                alt="">
                        </a>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="mt-12 border-t border-gray-100 pt-8">
                <p class="text-center text-gray-400">© 2025 Herchitchat. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="fixed bottom-4 right-4 px-6 py-3 bg-yellow-500 text-white rounded-xl shadow-lg"
            x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" x-transition>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="fixed bottom-4 right-4 px-6 py-3 bg-red-500 text-white rounded-xl shadow-lg"
            x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" x-transition>
            {{ session('error') }}
        </div>
    @endif
    @stack('scripts')
</body>

</html>
