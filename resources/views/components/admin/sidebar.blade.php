<aside class="w-64 bg-gradient-to-b from-pink-600 to-purple-700 text-white flex-shrink-0 hidden md:flex flex-col" x-data="{ open: true }">
    <!-- Logo -->
    <div class="flex items-center justify-center h-16 border-b border-pink-500">
        <span class="text-2xl font-bold">Dsisi Admin</span>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-white text-pink-600' : 'text-white hover:bg-pink-500' }}">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span class="font-semibold">Dashboard</span>
        </a>

        <!-- Bookings -->
        <a href="{{ route('admin.bookings.index') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.bookings.*') ? 'bg-white text-pink-600' : 'text-white hover:bg-pink-500' }}">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <span class="font-semibold">Manage Bookings</span>
        </a>

        <!-- Customers -->
        <a href="{{ route('admin.customers') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.customers*') ? 'bg-white text-pink-600' : 'text-white hover:bg-pink-500' }}">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <span class="font-semibold">Customers</span>
        </a>

        <!-- Services -->
        <a href="{{ route('admin.services') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.services') ? 'bg-white text-pink-600' : 'text-white hover:bg-pink-500' }}">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            <span class="font-semibold">Services</span>
        </a>
    </nav>

    <!-- User Info -->
    <div class="px-4 py-4 border-t border-pink-500">
        <div class="flex items-center">
            <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-pink-600 font-bold">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="ml-3">
                <p class="text-sm font-semibold">{{ Auth::user()->name }}</p>
                <p class="text-xs text-pink-200">Administrator</p>
            </div>
        </div>
    </div>
</aside>

<!-- Mobile Sidebar Toggle -->
<div class="md:hidden fixed bottom-4 right-4 z-50">
    <button @click="mobileMenu = !mobileMenu" class="bg-pink-600 text-white p-4 rounded-full shadow-lg">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>
</div>