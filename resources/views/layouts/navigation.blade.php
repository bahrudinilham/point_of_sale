<nav x-data="{ open: false }" class="bg-card border-b border-border relative z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo + App Name -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <span class="font-bold text-lg text-foreground">Mukit<span class="text-[#5D5FEF]">Cell</span></span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-1 lg:-my-px lg:ms-8 lg:flex items-center">
                    <a href="{{ route('dashboard') }}" 
                       class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200
                              {{ request()->routeIs('dashboard') 
                                 ? 'bg-indigo-100 dark:bg-indigo-900/30 text-[#5D5FEF]' 
                                 : 'text-muted hover:text-foreground hover:bg-background' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        Dashboard
                    </a>
                    
                    @if(auth()->user()->role === 'admin')
                    <a href="{{ route('transactions.index') }}" 
                       class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200
                              {{ request()->routeIs('transactions.*') 
                                 ? 'bg-indigo-100 dark:bg-indigo-900/30 text-[#5D5FEF]' 
                                 : 'text-muted hover:text-foreground hover:bg-background' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Transaksi
                    </a>
                    <a href="{{ route('products.index') }}" 
                       class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200
                              {{ request()->routeIs('products.*') 
                                 ? 'bg-indigo-100 dark:bg-indigo-900/30 text-[#5D5FEF]' 
                                 : 'text-muted hover:text-foreground hover:bg-background' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        Produk
                    </a>
                    <a href="{{ route('reports.index') }}" 
                       class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200
                              {{ request()->routeIs('reports.*') 
                                 ? 'bg-indigo-100 dark:bg-indigo-900/30 text-[#5D5FEF]' 
                                 : 'text-muted hover:text-foreground hover:bg-background' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Laporan
                    </a>
                    <a href="{{ route('settings.index') }}" 
                       class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200
                              {{ request()->routeIs('settings.*') || request()->routeIs('categories.*') || request()->routeIs('payment-methods.*') || request()->routeIs('users.*')
                                 ? 'bg-indigo-100 dark:bg-indigo-900/30 text-[#5D5FEF]' 
                                 : 'text-muted hover:text-foreground hover:bg-background' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Pengaturan
                    </a>
                    <a href="{{ route('archive.index') }}" 
                       class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200
                              {{ request()->routeIs('archive.*') 
                                 ? 'bg-indigo-100 dark:bg-indigo-900/30 text-[#5D5FEF]' 
                                 : 'text-muted hover:text-foreground hover:bg-background' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                        Arsip
                    </a>
                    @endif
                </div>
            </div>

            <!-- Right Side -->
            <div class="hidden lg:flex lg:items-center lg:gap-3">
                
                <!-- Quick POS Button -->
                @if(auth()->user()->role === 'cashier' || auth()->user()->role === 'admin')
                <a href="{{ route('pos.index') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 shadow-sm
                          {{ request()->routeIs('pos.*') 
                             ? 'bg-[#5D5FEF] text-white shadow-indigo-500/30' 
                             : 'bg-gradient-to-r from-[#5D5FEF] to-[#4b4ddb] text-white hover:shadow-lg hover:shadow-indigo-500/30 hover:scale-105' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Transaksi
                </a>
                @endif

                <!-- Theme Toggle -->
                <div x-data="{ 
                    darkMode: localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
                    toggle() {
                        this.darkMode = !this.darkMode;
                        if (this.darkMode) {
                            document.documentElement.classList.add('dark');
                            localStorage.theme = 'dark';
                        } else {
                            document.documentElement.classList.remove('dark');
                            localStorage.theme = 'light';
                        }
                        window.dispatchEvent(new Event('theme-changed'));
                    }
                }">
                    <button type="button" 
                            @click="toggle()" 
                            class="p-2 rounded-lg text-muted hover:text-foreground hover:bg-background transition-all duration-200"
                            :title="darkMode ? 'Switch to Light Mode' : 'Switch to Dark Mode'">
                        <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                        <svg x-show="darkMode" class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </button>
                </div>

                <!-- User Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 px-2 py-1.5 rounded-lg text-sm font-medium text-muted bg-card hover:bg-background border border-transparent hover:border-border focus:outline-none transition ease-in-out duration-150">
                            <!-- Avatar -->
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-[#5D5FEF] to-indigo-600 flex items-center justify-center text-white text-xs font-bold shadow-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div class="hidden xl:flex flex-col items-start">
                                <span class="text-foreground font-medium text-sm leading-tight">{{ Auth::user()->name }}</span>
                                <span class="text-[10px] text-[#5D5FEF] uppercase font-bold leading-tight">{{ auth()->user()->role }}</span>
                            </div>
                            <svg class="fill-current h-4 w-4 text-muted" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- User Info Header -->
                        <div class="px-4 py-3 border-b border-border">
                            <p class="text-sm font-medium text-foreground">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-muted truncate">{{ Auth::user()->email }}</p>
                        </div>
                        
                        <div class="py-1">
                            <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                {{ __('Profile') }}
                            </x-dropdown-link>
                            
                            @if(auth()->user()->role === 'admin')
                            <x-dropdown-link :href="route('settings.index')" class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ __('Pengaturan') }}
                            </x-dropdown-link>
                            @endif
                        </div>

                        <div class="border-t border-border py-1">
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="flex items-center gap-2 text-red-500 hover:text-red-600 hover:bg-red-500/10">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    {{ __('Keluar') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center lg:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-muted hover:text-foreground hover:bg-background focus:outline-none focus:bg-background focus:text-foreground transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Overlay with Slide-down) -->
    <div class="fixed inset-0 top-16 z-40 lg:hidden overflow-hidden" role="dialog" aria-modal="true" x-show="open" style="display: none;">
        
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity" 
             x-show="open"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="open = false"></div>

        <!-- Slide-down Panel -->
        <div class="absolute inset-x-0 top-0 z-50 flex flex-col w-full bg-card border-b border-border shadow-xl transform transition-transform"
             x-show="open"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="-translate-y-full"
             x-transition:enter-end="translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="translate-y-0"
             x-transition:leave-end="-translate-y-full">
            
            <!-- Quick POS Button (Mobile) -->
            @if(auth()->user()->role === 'cashier' || auth()->user()->role === 'admin')
            <div class="px-4 pt-4">
                <a href="{{ route('pos.index') }}" 
                   class="flex items-center justify-center gap-2 w-full px-4 py-3 text-sm font-bold rounded-xl transition-all duration-200
                          {{ request()->routeIs('pos.*') 
                             ? 'bg-[#5D5FEF] text-white' 
                             : 'bg-gradient-to-r from-[#5D5FEF] to-[#4b4ddb] text-white shadow-lg shadow-indigo-500/30' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Transaksi Baru
                </a>
            </div>
            @endif
            
            <div class="pt-2 pb-3 space-y-1">
                <div x-show="open" x-transition:enter="transition ease-out duration-300 delay-75" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="flex items-center gap-3 text-muted hover:text-foreground hover:bg-background hover:border-[#5D5FEF]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                </div>

                @if(auth()->user()->role === 'admin')
                <div x-show="open" x-transition:enter="transition ease-out duration-300 delay-100" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                    <x-responsive-nav-link :href="route('transactions.index')" :active="request()->routeIs('transactions.*')" class="flex items-center gap-3 text-muted hover:text-foreground hover:bg-background hover:border-[#5D5FEF]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        {{ __('Riwayat Transaksi') }}
                    </x-responsive-nav-link>
                </div>
                <div x-show="open" x-transition:enter="transition ease-out duration-300 delay-150" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                    <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')" class="flex items-center gap-3 text-muted hover:text-foreground hover:bg-background hover:border-[#5D5FEF]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        {{ __('Produk') }}
                    </x-responsive-nav-link>
                </div>
                <div x-show="open" x-transition:enter="transition ease-out duration-300 delay-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                    <x-responsive-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')" class="flex items-center gap-3 text-muted hover:text-foreground hover:bg-background hover:border-[#5D5FEF]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        {{ __('Laporan') }}
                    </x-responsive-nav-link>
                </div>
                <div x-show="open" x-transition:enter="transition ease-out duration-300 delay-250" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                    <x-responsive-nav-link :href="route('settings.index')" :active="request()->routeIs('settings.*') || request()->routeIs('categories.*') || request()->routeIs('payment-methods.*') || request()->routeIs('users.*')" class="flex items-center gap-3 text-muted hover:text-foreground hover:bg-background hover:border-[#5D5FEF]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        {{ __('Pengaturan') }}
                    </x-responsive-nav-link>
                </div>
                <div x-show="open" x-transition:enter="transition ease-out duration-300 delay-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                    <x-responsive-nav-link :href="route('archive.index')" :active="request()->routeIs('archive.*')" class="flex items-center gap-3 text-muted hover:text-foreground hover:bg-background hover:border-[#5D5FEF]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                        {{ __('Arsip') }}
                    </x-responsive-nav-link>
                </div>
                @endif
            </div>

            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-4 border-t border-border bg-background/50">
                <div class="px-4 flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-[#5D5FEF] to-indigo-600 flex items-center justify-center text-white font-bold text-lg shadow-lg">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    </div>
                    <div class="ml-3">
                        <div class="font-medium text-base text-foreground">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-muted">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1 px-2">
                    <!-- Mobile Theme Toggle -->
                    <div x-data="{ 
                        darkMode: localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
                        toggle() {
                            this.darkMode = !this.darkMode;
                            if (this.darkMode) {
                                document.documentElement.classList.add('dark');
                                localStorage.theme = 'dark';
                            } else {
                                document.documentElement.classList.remove('dark');
                                localStorage.theme = 'light';
                            }
                            window.dispatchEvent(new Event('theme-changed'));
                        }
                    }" class="flex items-center justify-between px-4 py-3 text-base font-medium text-muted hover:text-foreground hover:bg-card rounded-lg cursor-pointer" @click="toggle()">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path x-show="!darkMode" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                                <path x-show="darkMode" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <span x-text="darkMode ? 'Mode Terang' : 'Mode Gelap'"></span>
                        </div>
                        <div class="w-10 h-6 rounded-full transition-colors duration-200" :class="darkMode ? 'bg-[#5D5FEF]' : 'bg-gray-300'">
                            <div class="w-5 h-5 bg-white rounded-full shadow-sm transform transition-transform duration-200 mt-0.5" :class="darkMode ? 'translate-x-4.5 ml-0.5' : 'translate-x-0.5'"></div>
                        </div>
                    </div>
                    
                    <div x-show="open" x-transition:enter="transition ease-out duration-300 delay-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                        <x-responsive-nav-link :href="route('profile.edit')" class="flex items-center gap-3 rounded-lg text-muted hover:text-foreground hover:bg-card">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            {{ __('Profile') }}
                        </x-responsive-nav-link>
                    </div>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <div x-show="open" x-transition:enter="transition ease-out duration-300 delay-350" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                            <x-responsive-nav-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();" class="flex items-center gap-3 rounded-lg text-red-500 hover:text-red-600 hover:bg-red-500/10">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                {{ __('Keluar') }}
                            </x-responsive-nav-link>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Close Handle (Optional visual cue) -->
            <div class="flex justify-center pb-2" @click="open = false">
                <div class="w-12 h-1.5 bg-muted/30 rounded-full"></div>
            </div>
        </div>
    </div>
</nav>
