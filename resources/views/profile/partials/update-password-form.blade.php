<section>
    <header class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <div class="p-2 rounded-lg bg-indigo-100 dark:bg-indigo-900/30">
                <svg class="w-5 h-5 text-[#5D5FEF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            </div>
            <h2 class="text-lg font-bold text-foreground">
                Ubah Password
            </h2>
        </div>
        <p class="text-sm text-muted">
            Pastikan akun Anda menggunakan password yang kuat dan aman.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-sm font-medium text-foreground mb-1.5">Password Saat Ini</label>
            <input id="update_password_current_password" name="current_password" type="password" 
                   class="w-full bg-background border border-border text-foreground rounded-lg px-4 py-2.5 focus:ring-[#5D5FEF] focus:border-[#5D5FEF] transition-colors" 
                   autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password" class="block text-sm font-medium text-foreground mb-1.5">Password Baru</label>
            <input id="update_password_password" name="password" type="password" 
                   class="w-full bg-background border border-border text-foreground rounded-lg px-4 py-2.5 focus:ring-[#5D5FEF] focus:border-[#5D5FEF] transition-colors" 
                   autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-medium text-foreground mb-1.5">Konfirmasi Password</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" 
                   class="w-full bg-background border border-border text-foreground rounded-lg px-4 py-2.5 focus:ring-[#5D5FEF] focus:border-[#5D5FEF] transition-colors" 
                   autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="inline-flex items-center gap-2 bg-gradient-to-r from-[#5D5FEF] to-[#4b4ddb] hover:from-[#4b4ddb] hover:to-[#3a3bca] text-white font-medium py-2.5 px-5 rounded-lg shadow-sm transition-all duration-200 hover:shadow-lg hover:shadow-indigo-500/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Perbarui Password
            </button>

            @if (session('status') === 'password-updated')
                <div x-data="{ show: true }"
                     x-show="show"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     x-init="setTimeout(() => show = false, 3000)"
                     class="inline-flex items-center gap-2 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 px-3 py-1.5 rounded-lg text-sm font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Password berhasil diperbarui!
                </div>
            @endif
        </div>
    </form>
</section>
