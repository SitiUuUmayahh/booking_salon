<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel - Dsisi Salon')</title>
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Chart.js (untuk statistik) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-50" x-data="{ mobileMenuOpen: false }">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        @include('components.admin.sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-h-screen">
<!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 flex-shrink-0">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <!-- Left Side -->
                        <div class="flex items-center">
                            <!-- Mobile menu button -->
                            <button @click="mobileMenuOpen = !mobileMenuOpen" 
                                    class="md:hidden text-gray-600 hover:text-gray-900 p-2 rounded-md mr-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                            
                            <!-- Page Title -->
                            <h1 class="text-xl font-semibold text-gray-900">@yield('header', 'Admin Dashboard')</h1>
                        </div>
                        
                        <!-- Right Side -->
                        <div class="flex items-center space-x-4">
                            <!-- User Profile -->
                            <div class="flex items-center space-x-3">
                                <div class="flex items-center space-x-2">
                                    <div class="w-8 h-8 rounded-full bg-pink-600 flex items-center justify-center text-white font-semibold text-sm">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <span class="hidden sm:inline text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                                </div>
                                
                                <!-- Logout Button -->
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="text-gray-500 hover:text-red-600 p-2 rounded-md transition-colors"
                                            title="Logout">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                    <!-- Flash Messages -->
                    @if(session('success'))
                        <div class="mb-6">
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg" role="alert">
                                <span class="block sm:inline">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-6">
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg" role="alert">
                                <ul class="list-disc list-inside">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <!-- Page Content -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                        <div class="p-6">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>