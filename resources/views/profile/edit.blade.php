<x-app-layout>
    <!-- Header Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-foreground">Pengaturan Profil</h1>
            <p class="text-muted text-sm mt-1">Kelola informasi akun dan keamanan Anda</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        <!-- Profile Header Card -->
        <div class="bg-card rounded-xl border border-border shadow-sm p-6 mb-6">
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
                <!-- Large Avatar -->
                <div class="w-24 h-24 rounded-full bg-gradient-to-br from-[#5D5FEF] to-indigo-600 flex items-center justify-center text-white text-3xl font-bold shadow-lg shadow-indigo-500/30">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                
                <!-- User Info -->
                <div class="text-center sm:text-left flex-1">
                    <h2 class="text-2xl font-bold text-foreground">{{ Auth::user()->name }}</h2>
                    <p class="text-muted mt-1">{{ Auth::user()->email }}</p>
                    <div class="flex flex-wrap items-center justify-center sm:justify-start gap-3 mt-3">
                        <span class="inline-flex items-center gap-1.5 bg-indigo-100 dark:bg-indigo-900/30 text-[#5D5FEF] px-3 py-1 rounded-full text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            {{ ucfirst(Auth::user()->role) }}
                        </span>
                        <span class="inline-flex items-center gap-1.5 text-muted text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Bergabung {{ Auth::user()->created_at->translatedFormat('F Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Two Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Profile Information -->
            <div class="bg-card rounded-xl border border-border shadow-sm p-6">
                @include('profile.partials.update-profile-information-form')
            </div>

            <!-- Update Password -->
            <div class="bg-card rounded-xl border border-border shadow-sm p-6">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="bg-red-50 dark:bg-red-900/10 rounded-xl border border-red-200 dark:border-red-900/30 shadow-sm p-6">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-app-layout>
