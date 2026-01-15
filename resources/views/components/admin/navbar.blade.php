<nav class="bg-white shadow-lg border-b border-gray-200" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo and Brand -->
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-gray-800">
                        Salon Admin
                    </a>
                </div>
                
                <!-- Main Navigation -->
                <div class="hidden md:ml-8 md:flex md:space-x-8">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-200
                              {{ request()->routeIs('admin.dashboard') ? 'border-blue-500 text-blue-600' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                        </svg>
                        Dashboard
                    </a>
                    
                    <a href="{{ route('admin.bookings.index') }}" 
                       class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-200
                              {{ request()->routeIs('admin.bookings.*') ? 'border-blue-500 text-blue-600' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v16a2 2 0 002 2z"/>
                        </svg>
                        Bookings
                    </a>
                    
                    <a href="{{ route('admin.services.index') }}" 
                       class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-200
                              {{ request()->routeIs('admin.services.*') ? 'border-blue-500 text-blue-600' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        Services
                    </a>
                    
                    <a href="{{ route('admin.users.index') }}" 
                       class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-200
                              {{ request()->routeIs('admin.users.*') ? 'border-blue-500 text-blue-600' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                        </svg>
                        Users
                    </a>
                </div>
            </div>

            <!-- Right Side Navigation -->
            <div class="flex items-center space-x-4">
                <!-- Notifications -->
                <button class="text-gray-400 hover:text-gray-500 focus:outline-none focus:text-gray-500 transition-colors duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span class="sr-only">View notifications</span>
                </button>

                <!-- Profile Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <div>
                        <button @click="open = !open" 
                                class="bg-white rounded-full flex text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200" 
                                id="user-menu-button" 
                                aria-expanded="false" 
                                aria-haspopup="true">
                            <span class="sr-only">Open user menu</span>
                            <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center">
                                <span class="text-white text-sm font-medium">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </span>
                            </div>
                        </button>
                    </div>

                    <div x-show="open" 
                         @click.away="open = false"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50" 
                         role="menu" 
                         aria-orientation="vertical" 
                         aria-labelledby="user-menu-button" 
                         tabindex="-1">
                        
                        <div class="px-4 py-2 border-b border-gray-100">
                            <p class="text-sm text-gray-700 font-medium">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                        </div>
                        
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200" 
                           role="menuitem" 
                           tabindex="-1">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Your Profile
                        </a>
                        
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200" 
                           role="menuitem" 
                           tabindex="-1">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Settings
                        </a>
                        
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit" 
                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200" 
                                    role="menuitem" 
                                    tabindex="-1">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Sign out
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        type="button" 
                        class="bg-white inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500"
                        aria-controls="mobile-menu" 
                        aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="mobileMenuOpen" 
         class="md:hidden" 
         id="mobile-menu">
        <div class="pt-2 pb-3 space-y-1 border-t border-gray-200">
            <a href="{{ route('admin.dashboard') }}" 
               class="block pl-3 pr-4 py-2 text-base font-medium transition-colors duration-200
                      {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 border-blue-500 text-blue-700 border-l-4' : 'text-gray-600 hover:text-gray-800 hover:bg-gray-50 border-l-4 border-transparent' }}">
                Dashboard
            </a>
            
            <a href="{{ route('admin.bookings.index') }}" 
               class="block pl-3 pr-4 py-2 text-base font-medium transition-colors duration-200
                      {{ request()->routeIs('admin.bookings.*') ? 'bg-blue-50 border-blue-500 text-blue-700 border-l-4' : 'text-gray-600 hover:text-gray-800 hover:bg-gray-50 border-l-4 border-transparent' }}">
                Bookings
            </a>
            
            <a href="{{ route('admin.services.index') }}" 
               class="block pl-3 pr-4 py-2 text-base font-medium transition-colors duration-200
                      {{ request()->routeIs('admin.services.*') ? 'bg-blue-50 border-blue-500 text-blue-700 border-l-4' : 'text-gray-600 hover:text-gray-800 hover:bg-gray-50 border-l-4 border-transparent' }}">
                Services
            </a>
            
            <a href="{{ route('admin.users.index') }}" 
               class="block pl-3 pr-4 py-2 text-base font-medium transition-colors duration-200
                      {{ request()->routeIs('admin.users.*') ? 'bg-blue-50 border-blue-500 text-blue-700 border-l-4' : 'text-gray-600 hover:text-gray-800 hover:bg-gray-50 border-l-4 border-transparent' }}">
                Users
            </a>
        </div>
    </div>
</nav>
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        User Dashboard
                    </a>
                    <div class="border-t border-gray-200 my-2"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>th stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                        </svg>
                        Dashboard
                    </a>
                    
                    <a href="{{ route('admin.bookings.index') }}" 
                       class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-200
                              {{ request()->routeIs('admin.bookings.*') ? 'border-blue-500 text-blue-600' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v16a2 2 0 002 2z"/>
                        </svg>
                        Bookings
                    </a>
                    
                    <a href="{{ route('admin.services.index') }}" 
                       class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-200
                              {{ request()->routeIs('admin.services.*') ? 'border-blue-500 text-blue-600' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        Services
                    </a>
                    
                    <a href="{{ route('admin.users.index') }}" 
                       class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-200
                              {{ request()->routeIs('admin.users.*') ? 'border-blue-500 text-blue-600' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                        </svg>
                        Users
                    </a>
                </div>
            </div>

            <!-- Right Side Navigation -->
            <div class="flex items-center space-x-4">
                <!-- Notifications -->
                <button class="text-gray-400 hover:text-gray-500 focus:outline-none focus:text-gray-500 transition-colors duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span class="sr-only">View notifications</span>
                </button>

                <!-- Profile Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <div>
                        <button @click="open = !open" 
                                class="bg-white rounded-full flex text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200" 
                                id="user-menu-button" 
                                aria-expanded="false" 
                                aria-haspopup="true">
                            <span class="sr-only">Open user menu</span>
                            <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center">
                                <span class="text-white text-sm font-medium">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </span>
                            </div>
                        </button>
                    </div>

                    <div x-show="open" 
                         @click.away="open = false"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50" 
                         role="menu" 
                         aria-orientation="vertical" 
                         aria-labelledby="user-menu-button" 
                         tabindex="-1">
                        
                        <div class="px-4 py-2 border-b border-gray-100">
                            <p class="text-sm text-gray-700 font-medium">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                        </div>
                        
                        <a href="{{ route('admin.profile') }}" 
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200" 
                           role="menuitem" 
                           tabindex="-1">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Your Profile
                        </a>
                        
                        <a href="{{ route('admin.settings') }}" 
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200" 
                           role="menuitem" 
                           tabindex="-1">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Settings
                        </a>
                        
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit" 
                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200" 
                                    role="menuitem" 
                                    tabindex="-1">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Sign out
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        type="button" 
                        class="bg-white inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500"
                        aria-controls="mobile-menu" 
                        aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="mobileMenuOpen" 
         x-data="{ mobileMenuOpen: false }"
         class="md:hidden" 
         id="mobile-menu">
        <div class="pt-2 pb-3 space-y-1 border-t border-gray-200">
            <a href="{{ route('admin.dashboard') }}" 
               class="block pl-3 pr-4 py-2 text-base font-medium transition-colors duration-200
                      {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 border-blue-500 text-blue-700 border-l-4' : 'text-gray-600 hover:text-gray-800 hover:bg-gray-50 border-l-4 border-transparent' }}">
                Dashboard
            </a>
            
            <a href="{{ route('admin.bookings.index') }}" 
               class="block pl-3 pr-4 py-2 text-base font-medium transition-colors duration-200
                      {{ request()->routeIs('admin.bookings.*') ? 'bg-blue-50 border-blue-500 text-blue-700 border-l-4' : 'text-gray-600 hover:text-gray-800 hover:bg-gray-50 border-l-4 border-transparent' }}">
                Bookings
            </a>
            
            <a href="{{ route('admin.services.index') }}" 
               class="block pl-3 pr-4 py-2 text-base font-medium transition-colors duration-200
                      {{ request()->routeIs('admin.services.*') ? 'bg-blue-50 border-blue-500 text-blue-700 border-l-4' : 'text-gray-600 hover:text-gray-800 hover:bg-gray-50 border-l-4 border-transparent' }}">
                Services
            </a>
            
            <a href="{{ route('admin.users.index') }}" 
               class="block pl-3 pr-4 py-2 text-base font-medium transition-colors duration-200
                      {{ request()->routeIs('admin.users.*') ? 'bg-blue-50 border-blue-500 text-blue-700 border-l-4' : 'text-gray-600 hover:text-gray-800 hover:bg-gray-50 border-l-4 border-transparent' }}">
                Users
            </a>
        </div>
    </div>
</nav>