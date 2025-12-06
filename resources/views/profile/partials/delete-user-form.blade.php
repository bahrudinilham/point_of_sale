<section class="space-y-6">
    <header>
        <div class="flex items-center gap-3 mb-2">
            <div class="p-2 rounded-lg bg-red-100 dark:bg-red-900/30">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <h2 class="text-lg font-bold text-red-600 dark:text-red-400">
                Zona Berbahaya
            </h2>
        </div>
        <p class="text-sm text-muted">
            Setelah akun Anda dihapus, semua data dan informasi akan dihapus secara permanen. Pastikan Anda telah mengunduh data yang ingin disimpan sebelum menghapus akun.
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="inline-flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white font-medium py-2.5 px-5 rounded-lg shadow-sm transition-all duration-200"
    >
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
        Hapus Akun
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <div class="flex items-center gap-3 mb-4">
                <div class="p-2 rounded-full bg-red-100 dark:bg-red-900/30">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h2 class="text-lg font-bold text-foreground">
                    Apakah Anda yakin ingin menghapus akun?
                </h2>
            </div>

            <p class="text-sm text-muted mb-6">
                Setelah akun dihapus, semua data akan hilang secara permanen. Masukkan password Anda untuk mengkonfirmasi penghapusan akun.
            </p>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-foreground mb-1.5">Password</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="w-full bg-background border border-border text-foreground rounded-lg px-4 py-2.5 focus:ring-red-500 focus:border-red-500 transition-colors"
                    placeholder="Masukkan password Anda"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="inline-flex items-center gap-2 bg-card hover:bg-background text-foreground border border-border font-medium py-2.5 px-5 rounded-lg transition-all duration-200">
                    Batal
                </button>

                <button type="submit" class="inline-flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white font-medium py-2.5 px-5 rounded-lg shadow-sm transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Ya, Hapus Akun
                </button>
            </div>
        </form>
    </x-modal>
</section>
