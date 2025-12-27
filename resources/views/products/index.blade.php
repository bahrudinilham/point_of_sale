<x-app-layout>
    <!-- Header Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-foreground">Produk</h1>
                <p class="text-muted mt-1">Kelola inventaris dan stok produk Anda</p>
            </div>
            <a href="{{ route('products.create') }}" class="bg-[#5D5FEF] hover:bg-[#4b4ddb] text-white font-medium py-2.5 px-4 rounded-lg transition duration-150 ease-in-out flex items-center shadow-lg shadow-indigo-500/25">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Produk
            </a>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-4">
        <div class="grid grid-cols-2 gap-3 sm:gap-4">
            <!-- Total Products -->
            <div class="bg-card rounded-xl p-4 border border-border flex items-center gap-3">
                <div class="p-2.5 rounded-lg bg-indigo-100 dark:bg-indigo-900/30 shrink-0">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <div class="text-xl sm:text-2xl font-bold text-foreground">{{ $totalProducts }}</div>
                    <div class="text-[10px] sm:text-xs text-muted">Total Produk</div>
                </div>
            </div>

            <!-- Low Stock -->
            <div class="bg-card rounded-xl p-4 border border-border flex items-center gap-3 {{ $lowStockCount > 0 ? 'border-amber-200 dark:border-amber-800/50' : '' }}">
                <div class="p-2.5 rounded-lg {{ $lowStockCount > 0 ? 'bg-amber-100 dark:bg-amber-900/30' : 'bg-muted/20' }} shrink-0">
                    <svg class="w-5 h-5 {{ $lowStockCount > 0 ? 'text-amber-500' : 'text-muted' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <div class="text-xl sm:text-2xl font-bold {{ $lowStockCount > 0 ? 'text-amber-600 dark:text-amber-400' : 'text-foreground' }}">{{ $lowStockCount }}</div>
                    <div class="text-[10px] sm:text-xs text-muted">Stok Rendah</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filters -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-4">
        <div class="bg-card rounded-xl border border-border">
            <form method="GET" action="{{ route('products.index') }}">
                <!-- Search Row -->
                <div class="p-4 border-b border-border">
                    <div class="flex gap-2">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text" name="search" placeholder="Cari produk berdasarkan nama..." value="{{ request('search') }}" 
                                   class="w-full bg-background border border-border text-foreground rounded-lg text-sm py-3 pl-12 pr-4 focus:ring-2 focus:ring-[#5D5FEF]/20 focus:border-[#5D5FEF] transition-all placeholder:text-gray-400/40 dark:placeholder:text-gray-600/60">
                        </div>
                        <button type="submit" class="bg-[#5D5FEF] hover:bg-[#4b4ddb] text-white font-medium py-3 px-4 rounded-lg transition-colors shadow-lg shadow-indigo-500/25 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Filters Row -->
                <div class="px-4 py-3 bg-muted/20">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                        <!-- Filter Label -->
                        <div class="flex items-center gap-2 text-sm text-muted shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                            </svg>
                            <span class="font-medium">Filter:</span>
                        </div>
                        
                        <!-- Filter Controls -->
                        <div class="flex flex-wrap items-center gap-2 flex-1">
                            <!-- Category Filter -->
                            <div class="relative" x-data="{ 
                                open: false, 
                                selected: '{{ request('category_id') }}', 
                                label: '{{ $categories->firstWhere('id', request('category_id'))?->name ?? 'Semua Kategori' }}' 
                            }">
                                <input type="hidden" name="category_id" x-model="selected">
                                <button @click="open = !open" @click.away="open = false" type="button" 
                                        class="bg-background border border-border text-foreground rounded-full text-xs font-medium py-2 pl-3 pr-2.5 flex items-center gap-1 focus:border-[#5D5FEF] focus:ring-[#5D5FEF] hover:border-[#5D5FEF]/50 transition-colors min-w-[140px] justify-between"
                                        :class="{'border-[#5D5FEF] bg-[#5D5FEF]/5': selected}">
                                    <span x-text="label" class="truncate"></span>
                                    <svg class="w-3.5 h-3.5 text-muted transition-transform duration-200 shrink-0" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                <div x-show="open" x-transition.origin.top.left style="display: none;" 
                                     class="absolute z-50 mt-1 w-full bg-card border border-border rounded-xl shadow-lg overflow-hidden py-1 min-w-[160px]">
                                    <button type="button" class="w-full text-left px-3 py-2 text-xs hover:bg-muted/20 transition-colors"
                                            :class="{'text-[#5D5FEF] font-medium bg-[#5D5FEF]/5': !selected, 'text-foreground': selected}"
                                            @click="selected = ''; label = 'Semua Kategori'; open = false; $nextTick(() => $el.closest('form').submit())">
                                        Semua Kategori
                                    </button>
                                    @foreach($categories as $category)
                                        <button type="button" class="w-full text-left px-3 py-2 text-xs hover:bg-muted/20 transition-colors"
                                                :class="{'text-[#5D5FEF] font-medium bg-[#5D5FEF]/5': selected == '{{ $category->id }}', 'text-foreground': selected != '{{ $category->id }}'}"
                                                @click="selected = '{{ $category->id }}'; label = '{{ $category->name }}'; open = false; $nextTick(() => $el.closest('form').submit())">
                                            {{ $category->name }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Divider -->
                            <div class="hidden sm:block w-px h-5 bg-border"></div>

                            <!-- Sort Filter -->
                            <div class="relative" x-data="{ 
                                open: false, 
                                selected: '{{ request('sort') }}', 
                                label: '{{ match(request('sort')) { 'name_asc' => 'Nama A-Z', 'name_desc' => 'Nama Z-A', 'stock_desc' => 'Stok Tertinggi', 'stock_asc' => 'Stok Terendah', default => 'Urutkan' } }}' 
                            }">
                                <input type="hidden" name="sort" x-model="selected">
                                <button @click="open = !open" @click.away="open = false" type="button" 
                                        class="bg-background border border-border text-foreground rounded-full text-xs font-medium py-2 pl-3 pr-2.5 flex items-center gap-1 focus:border-[#5D5FEF] focus:ring-[#5D5FEF] hover:border-[#5D5FEF]/50 transition-colors min-w-[120px] justify-between"
                                        :class="{'border-[#5D5FEF] bg-[#5D5FEF]/5': selected}">
                                    <span x-text="label" class="truncate"></span>
                                    <svg class="w-3.5 h-3.5 text-muted transition-transform duration-200 shrink-0" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                <div x-show="open" x-transition.origin.top.left style="display: none;" 
                                     class="absolute z-50 mt-1 w-full bg-card border border-border rounded-xl shadow-lg overflow-hidden py-1 min-w-[140px]">
                                    <button type="button" class="w-full text-left px-3 py-2 text-xs hover:bg-muted/20 transition-colors"
                                            :class="{'text-[#5D5FEF] font-medium bg-[#5D5FEF]/5': !selected, 'text-foreground': selected}"
                                            @click="selected = ''; label = 'Urutkan'; open = false; $nextTick(() => $el.closest('form').submit())">
                                        Urutkan
                                    </button>
                                    @foreach([
                                        'name_asc' => 'Nama A-Z',
                                        'name_desc' => 'Nama Z-A',
                                        'stock_desc' => 'Stok Tertinggi',
                                        'stock_asc' => 'Stok Terendah'
                                    ] as $value => $label)
                                        <button type="button" class="w-full text-left px-3 py-2 text-xs hover:bg-muted/20 transition-colors"
                                                :class="{'text-[#5D5FEF] font-medium bg-[#5D5FEF]/5': selected == '{{ $value }}', 'text-foreground': selected != '{{ $value }}'}"
                                                @click="selected = '{{ $value }}'; label = '{{ $label }}'; open = false; $nextTick(() => $el.closest('form').submit())">
                                            {{ $label }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                            
                            <!-- Spacer -->
                            <div class="hidden sm:block flex-1"></div>

                            <!-- Reset All -->
                            @if(request('search') || request('category_id') || request('sort'))
                                <a href="{{ route('products.index') }}" class="inline-flex items-center gap-1.5 text-xs font-medium text-rose-500 hover:text-rose-600 py-2 px-2 sm:px-3 rounded-full bg-rose-50 dark:bg-rose-900/20 hover:bg-rose-100 dark:hover:bg-rose-900/30 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    Reset <span class="hidden sm:inline">Filter</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Active Filters Display -->

            </form>
        </div>
    </div>

    <!-- Product Table -->
    <div class="pb-20 sm:pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div id="products-table" class="bg-card overflow-hidden shadow-xl sm:rounded-xl border border-border">
                <div class="px-4 pt-4 sm:p-6">
                    
                    @if(session('success'))
                        <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 px-4 py-3 rounded-lg relative mb-4 flex items-center gap-2" role="alert">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    @if($products->count() > 0)
                        <!-- Desktop Table -->
                        <div class="hidden sm:block overflow-x-auto">
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="text-muted text-xs uppercase tracking-wider border-b border-border bg-background/50">
                                        <th class="px-4 lg:px-6 py-3 font-medium">Produk</th>
                                        <th class="px-4 lg:px-6 py-3 font-medium">Kategori</th>
                                        <th class="px-4 lg:px-6 py-3 font-medium text-right">Harga</th>
                                        <th class="px-4 lg:px-6 py-3 font-medium text-center">Stok</th>
                                        <th class="px-4 lg:px-6 py-3 font-medium text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-border bg-card">
                                    @foreach($products as $product)
                                        <tr class="text-sm group hover:bg-background/50 transition-colors {{ !$product->is_active ? 'opacity-50' : '' }}">
                                            <td class="px-4 lg:px-6 py-4">
                                                <div class="min-w-0">
                                                    <div class="font-medium text-foreground truncate flex items-center gap-2">
                                                        {{ $product->name }}
                                                        @if(!$product->is_active)
                                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-gray-100 dark:bg-gray-800 text-gray-500">Nonaktif</span>
                                                        @endif
                                                    </div>
                                                    @if($product->description)
                                                        <div class="text-xs text-muted truncate max-w-[200px]">{{ $product->description }}</div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-4 lg:px-6 py-4">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400">
                                                    {{ $product->category->name ?? '-' }}
                                                </span>
                                            </td>
                                            <td class="px-4 lg:px-6 py-4 text-right">
                                                <span class="font-semibold text-foreground">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</span>
                                            </td>
                                            <td class="px-4 lg:px-6 py-4 text-center">
                                                @php
                                                    $stockClass = ($product->stock == 0 ? 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400' 
                                                            : ($product->stock <= 10 
                                                            ? 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400' 
                                                            : 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400'));
                                                @endphp
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $stockClass }}">
                                                    {{ $product->stock }}
                                                </span>
                                            </td>
                                            <td class="px-4 lg:px-6 py-4">
                                                <div class="flex items-center justify-end gap-1">
                                                    <!-- Toggle Active -->
                                                    <form action="{{ route('products.toggle', $product) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" 
                                                                class="p-2 rounded-lg hover:bg-{{ $product->is_active ? 'amber' : 'green' }}-50 dark:hover:bg-{{ $product->is_active ? 'amber' : 'green' }}-900/30 text-{{ $product->is_active ? 'amber' : 'green' }}-500 transition-colors" 
                                                                title="{{ $product->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                            @if($product->is_active)
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                                                </svg>
                                                            @else
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                                </svg>
                                                            @endif
                                                        </button>
                                                    </form>
                                                    <a href="{{ route('products.edit', $product) }}" 
                                                       class="p-2 rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/30 text-[#5D5FEF] transition-colors" 
                                                       title="Edit">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                        </svg>
                                                    </a>
                                                    <button type="button" 
                                                            onclick="confirmDelete('delete-form-{{ $product->id }}')" 
                                                            class="p-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/30 text-red-400 transition-colors" 
                                                            title="Hapus">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>
                                                    <form id="delete-form-{{ $product->id }}" action="{{ route('products.destroy', $product) }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Card View -->
                        <div class="grid grid-cols-1 gap-3 sm:hidden">
                            @foreach($products as $product)
                            <div class="bg-background p-4 rounded-xl border border-border shadow-sm">
                                <div class="flex justify-between items-start mb-3">
                                    <div class="min-w-0">
                                        <h3 class="font-medium text-foreground truncate">{{ $product->name }}</h3>
                                        <p class="text-xs text-muted">{{ $product->category->name ?? '-' }}</p>
                                    </div>
                                    @php
                                        $stockClass = $product->stock <= 10 
                                            ? 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400' 
                                            : ($product->stock <= 50 
                                                ? 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400' 
                                                : 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400');
                                    @endphp
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold {{ $stockClass }}">
                                        {{ $product->stock }}
                                    </span>
                                </div>
                                
                                <div class="flex items-center justify-between pt-3 border-t border-border">
                                    <div class="text-lg font-bold text-[#5D5FEF]">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</div>
                                    <div class="flex items-center gap-1">
                                        <a href="{{ route('products.edit', $product) }}" class="p-2 rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/30 text-[#5D5FEF] transition-colors" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        <button type="button" class="p-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/30 text-red-400 transition-colors" onclick="confirmDelete('delete-form-mobile-{{ $product->id }}')" title="Delete">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                        <form id="delete-form-mobile-{{ $product->id }}" action="{{ route('products.destroy', $product) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="mt-2 pb-3 sm:mt-4 sm:pb-0">
                            {{ $products->fragment('products-table')->links('vendor.pagination.custom') }}
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-16">
                            <div class="mx-auto w-16 h-16 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-foreground mb-1">
                                @if(request('search') || request('category_id'))
                                    Produk tidak ditemukan
                                @else
                                    Belum ada produk
                                @endif
                            </h3>
                            <p class="text-sm text-muted mb-6">
                                @if(request('search') || request('category_id'))
                                    Coba ubah kata kunci atau filter pencarian
                                @else
                                    Mulai dengan menambahkan produk pertama Anda
                                @endif
                            </p>
                            @if(request('search') || request('category_id'))
                                <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 text-[#5D5FEF] hover:text-[#4b4ddb] font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Reset Filter
                                </a>
                            @else
                                <a href="{{ route('products.create') }}" class="inline-flex items-center gap-2 bg-[#5D5FEF] hover:bg-[#4b4ddb] text-white font-medium py-2.5 px-4 rounded-lg transition-colors shadow-lg shadow-indigo-500/25">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Tambah Produk
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(formId) {
            const isDark = document.documentElement.classList.contains('dark');
            Swal.fire({
                title: 'Hapus Produk?',
                text: "Data produk yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: isDark ? '#1f2937' : '#ffffff',
                color: isDark ? '#ffffff' : '#374151',
                customClass: {
                    popup: 'rounded-xl border border-gray-200 dark:border-gray-700 shadow-xl'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            })
        }
    </script>
</x-app-layout>
