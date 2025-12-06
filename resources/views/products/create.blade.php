<x-app-layout>
    <!-- Header Section -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('products.index') }}" class="p-2 rounded-lg bg-card border border-border hover:bg-muted/50 transition-colors">
                <svg class="w-5 h-5 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-foreground">Tambah Produk Baru</h1>
                <p class="text-muted text-sm mt-1">Lengkapi informasi produk untuk menambahkan ke inventaris</p>
            </div>
        </div>
    </div>

    <div class="pb-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <form action="{{ route('products.store') }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <!-- Product Information Section -->
                    <div class="bg-card rounded-xl border border-border overflow-hidden">
                        <div class="px-6 py-4 border-b border-border bg-muted/30">
                            <div class="flex items-center gap-3">
                                <div class="p-2 rounded-lg bg-indigo-100 dark:bg-indigo-900/30">
                                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-foreground">Informasi Produk</h3>
                                    <p class="text-xs text-muted">Detail produk dan harga</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 space-y-5">
                            <!-- Product Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-foreground mb-2">
                                    Nama Produk <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                                           placeholder="Masukkan nama produk..."
                                           class="w-full bg-background border border-border text-foreground rounded-lg py-3 pl-11 pr-4 focus:border-[#5D5FEF] focus:ring-[#5D5FEF] transition-colors">
                                </div>
                                @error('name')
                                    <p class="mt-2 text-sm text-rose-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-foreground mb-2">
                                    Kategori <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                    </div>
                                    <select id="category_id" name="category_id" required
                                            class="w-full appearance-none bg-background border border-border text-foreground rounded-lg py-3 pl-11 pr-10 focus:border-[#5D5FEF] focus:ring-[#5D5FEF] cursor-pointer transition-colors">
                                        <option value="">Pilih kategori...</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </div>
                                @error('category_id')
                                    <p class="mt-2 text-sm text-rose-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Selling Price and Stock Row -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <!-- Selling Price -->
                                <div>
                                    <label for="selling_price" class="block text-sm font-medium text-foreground mb-2">
                                        Harga Jual <span class="text-rose-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-muted font-medium">Rp</span>
                                        </div>
                                        <input type="number" id="selling_price" name="selling_price" 
                                               value="{{ old('selling_price') }}" required min="0"
                                               placeholder="0"
                                               class="w-full bg-background border border-border text-foreground rounded-lg py-3 pl-11 pr-4 focus:border-[#5D5FEF] focus:ring-[#5D5FEF] transition-colors">
                                    </div>
                                    @error('selling_price')
                                        <p class="mt-2 text-sm text-rose-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Stock -->
                                <div>
                                    <label for="stock" class="block text-sm font-medium text-foreground mb-2">
                                        Jumlah Stok <span class="text-rose-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                            </svg>
                                        </div>
                                        <input type="number" id="stock" name="stock" value="{{ old('stock', 0) }}" required min="0"
                                               placeholder="0"
                                               class="w-full bg-background border border-border text-foreground rounded-lg py-3 pl-11 pr-14 focus:border-[#5D5FEF] focus:ring-[#5D5FEF] transition-colors">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <span class="text-muted text-sm">unit</span>
                                        </div>
                                    </div>
                                    @error('stock')
                                        <p class="mt-2 text-sm text-rose-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden purchase_price field with default value -->
                    <input type="hidden" name="purchase_price" value="0">

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row items-center justify-end gap-3 pt-4">
                        <a href="{{ route('products.index') }}" 
                           class="w-full sm:w-auto px-6 py-3 text-center text-muted hover:text-foreground border border-border rounded-lg hover:bg-muted/20 transition-colors">
                            Batal
                        </a>
                        <button type="submit" 
                                class="w-full sm:w-auto px-8 py-3 bg-gradient-to-r from-[#5D5FEF] to-[#7879F1] hover:from-[#4b4ddb] hover:to-[#6668e0] text-white font-medium rounded-lg transition-all shadow-lg shadow-indigo-500/25 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Simpan Produk
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
