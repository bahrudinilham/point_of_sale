<x-app-layout>
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

    <!-- Header Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-foreground">Pengaturan</h1>
                <p class="text-muted mt-1">Kelola kategori produk, metode pembayaran, dan pengguna</p>
            </div>
        </div>
    </div>

    <div class="sm:pb-12" x-data="{ 
        activeTab: new URLSearchParams(window.location.search).get('tab') || 'categories',
        categorySearch: '',
        paymentSearch: '',
        userSearch: '',
        updateTab(tab) {
            this.activeTab = tab;
            const url = new URL(window.location);
            url.searchParams.set('tab', tab);
            window.history.pushState({}, '', url);
        }
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Tabs with Icons and Badges -->
            <div class="mb-6 overflow-x-auto no-scrollbar">
                <div class="flex space-x-1 border-b border-border min-w-max px-4 sm:px-0">
                    <!-- Categories Tab -->
                    <button @click="updateTab('categories')" 
                            :class="activeTab === 'categories' ? 'border-[#5D5FEF] text-[#5D5FEF] bg-indigo-50/50 dark:bg-indigo-900/20' : 'border-transparent text-muted hover:text-foreground hover:bg-background/50'"
                            class="py-3 px-4 border-b-2 font-medium text-sm transition-all duration-200 rounded-t-lg flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        <span>Kategori</span>
                        <span class="ml-1 bg-muted/20 text-muted text-xs px-2 py-0.5 rounded-full" :class="activeTab === 'categories' && 'bg-indigo-100 dark:bg-indigo-900/50 text-[#5D5FEF]'">{{ $categories->total() }}</span>
                    </button>

                    <!-- Payment Methods Tab -->
                    <button @click="updateTab('payment-methods')" 
                            :class="activeTab === 'payment-methods' ? 'border-[#5D5FEF] text-[#5D5FEF] bg-indigo-50/50 dark:bg-indigo-900/20' : 'border-transparent text-muted hover:text-foreground hover:bg-background/50'"
                            class="py-3 px-4 border-b-2 font-medium text-sm transition-all duration-200 rounded-t-lg flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        <span>Pembayaran</span>
                        <span class="ml-1 bg-muted/20 text-muted text-xs px-2 py-0.5 rounded-full" :class="activeTab === 'payment-methods' && 'bg-indigo-100 dark:bg-indigo-900/50 text-[#5D5FEF]'">{{ $paymentMethods->total() }}</span>
                    </button>

                    <!-- Users Tab -->
                    <button @click="updateTab('users')" 
                            :class="activeTab === 'users' ? 'border-[#5D5FEF] text-[#5D5FEF] bg-indigo-50/50 dark:bg-indigo-900/20' : 'border-transparent text-muted hover:text-foreground hover:bg-background/50'"
                            class="py-3 px-4 border-b-2 font-medium text-sm transition-all duration-200 rounded-t-lg flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span>Pengguna</span>
                        <span class="ml-1 bg-muted/20 text-muted text-xs px-2 py-0.5 rounded-full" :class="activeTab === 'users' && 'bg-indigo-100 dark:bg-indigo-900/50 text-[#5D5FEF]'">{{ $users->total() }}</span>
                    </button>
                </div>
            </div>

            <div class="bg-card overflow-hidden shadow-xl sm:rounded-xl border border-border">
                <div class="p-4 sm:p-6">
                    
                    @if(session('success'))
                        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 px-4 py-3 rounded-lg relative mb-4 flex items-center gap-2" role="alert">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 px-4 py-3 rounded-lg relative mb-4 flex items-center gap-2" role="alert">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    <!-- ==================== CATEGORIES TAB ==================== -->
                    <div x-show="activeTab === 'categories'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" x-data="{ 
                            isEdit: false, 
                            formAction: '{{ route('categories.store') }}',
                            formMethod: 'POST',
                            category: {},
                            resetForm() {
                                this.isEdit = false;
                                this.formAction = '{{ route('categories.store') }}';
                                this.formMethod = 'POST';
                                this.category = {};
                            },
                            editCategory(data) {
                                this.isEdit = true;
                                this.formAction = '{{ route('categories.index') }}/' + data.id;
                                this.formMethod = 'PUT';
                                this.category = data;
                            }
                        }">
                            
                            <!-- Left Column: Table -->
                            <div class="lg:col-span-2 order-2 lg:order-1">
                                <!-- Search -->
                                <div class="mb-4 relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                    </div>
                                    <input type="text" x-model="categorySearch" placeholder="Cari kategori..." 
                                           class="w-full sm:w-64 bg-background border-border text-foreground rounded-lg text-sm py-2 pl-9 pr-4 focus:border-[#5D5FEF] focus:ring-[#5D5FEF]">
                                </div>

                                @if($categories->count() > 0)
                                    <div class="overflow-x-auto rounded-lg border border-border">
                                        <table class="w-full text-left">
                                            <thead>
                                                <tr class="text-muted text-xs uppercase tracking-wider border-b border-border bg-background/50">
                                                    <th class="px-4 sm:px-6 py-3 font-medium">Nama</th>
                                                    <th class="px-4 sm:px-6 py-3 font-medium">Jumlah Produk</th>
                                                    <th class="px-4 sm:px-6 py-3 font-medium text-right">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-border bg-card">
                                                @foreach($categories as $category)
                                                    <tr class="text-sm group hover:bg-background/50 transition-colors"
                                                        x-show="categorySearch === '' || '{{ strtolower($category->name) }}'.includes(categorySearch.toLowerCase())">
                                                        <td class="px-4 sm:px-6 py-4 text-foreground font-medium">{{ $category->name }}</td>
                                                        <td class="px-4 sm:px-6 py-4">
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400">
                                                                {{ $category->products_count }} Produk
                                                            </span>
                                                        </td>
                                                        <td class="px-4 sm:px-6 py-4">
                                                            <div class="flex items-center justify-end gap-1">
                                                                <button @click="editCategory({{ $category }})" 
                                                                        class="p-2 rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/30 text-[#5D5FEF] transition-colors" 
                                                                        title="Edit">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                                    </svg>
                                                                </button>
                                                                <button type="button" 
                                                                        onclick="confirmDelete('category-{{ $category->id }}')" 
                                                                        class="p-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/30 text-red-400 transition-colors" 
                                                                        title="Hapus">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                                    </svg>
                                                                </button>
                                                                <form id="delete-form-category-{{ $category->id }}" action="{{ route('categories.destroy', $category) }}" method="POST" style="display: none;">
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
                                    <div class="mt-4">
                                        {{ $categories->appends(['tab' => 'categories'])->links('vendor.pagination.custom') }}
                                    </div>
                                @else
                                    <!-- Empty State -->
                                    <div class="text-center py-12 bg-background/30 rounded-xl border border-dashed border-border">
                                        <svg class="mx-auto h-12 w-12 text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                        <h3 class="mt-4 text-sm font-medium text-foreground">Belum ada kategori</h3>
                                        <p class="mt-1 text-sm text-muted">Mulai dengan menambahkan kategori pertama.</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Right Column: Form -->
                            <div class="lg:col-span-1 order-1 lg:order-2">
                                <div class="bg-gradient-to-br from-background to-background/50 rounded-xl p-5 border border-border sticky top-6">
                                    <div class="flex items-center gap-2 mb-4">
                                        <div class="p-2 rounded-lg bg-indigo-100 dark:bg-indigo-900/30">
                                            <svg class="w-4 h-4 text-[#5D5FEF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x-show="!isEdit" d="M12 4v16m8-8H4"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x-show="isEdit" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </div>
                                        <h2 class="text-lg font-bold text-foreground" x-text="isEdit ? 'Edit Kategori' : 'Tambah Kategori'"></h2>
                                    </div>
                                    
                                    <form :action="formAction" method="POST">
                                        @csrf
                                        <input type="hidden" name="_method" :value="formMethod">
                                        
                                        <div class="space-y-4">
                                            <div>
                                                <x-input-label for="cat_name" value="Nama Kategori" class="text-sm" />
                                                <x-text-input id="cat_name" name="name" type="text" class="mt-1.5 block w-full" x-model="category.name" required placeholder="Contoh: Aksesoris, Voucher, Kartu Perdana" />
                                            </div>

                                            <div class="flex justify-end gap-2 pt-2">
                                                <button type="button" x-show="isEdit" @click="resetForm()" class="px-4 py-2 text-sm font-medium text-muted hover:text-foreground transition-colors rounded-lg hover:bg-background">
                                                    Batal
                                                </button>
                                                <button type="submit" class="bg-[#5D5FEF] hover:bg-[#4b4ddb] text-white font-medium py-2.5 px-5 rounded-lg transition duration-150 ease-in-out shadow-lg shadow-indigo-500/25 flex items-center gap-2">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                    <span x-text="isEdit ? 'Perbarui' : 'Simpan'"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- ==================== PAYMENT METHODS TAB ==================== -->
                    <div x-show="activeTab === 'payment-methods'" style="display: none;" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" x-data="{ 
                            isEdit: false, 
                            formAction: '{{ route('payment-methods.store') }}',
                            formMethod: 'POST',
                            method: { is_active: 1 },
                            resetForm() {
                                this.isEdit = false;
                                this.formAction = '{{ route('payment-methods.store') }}';
                                this.formMethod = 'POST';
                                this.method = { is_active: 1 };
                            },
                            editMethod(data) {
                                this.isEdit = true;
                                this.formAction = '{{ route('payment-methods.index') }}/' + data.id;
                                this.formMethod = 'PUT';
                                this.method = data;
                            }
                        }">
                            
                            <!-- Left Column: Table -->
                            <div class="lg:col-span-2 order-2 lg:order-1">
                                <!-- Search -->
                                <div class="mb-4 relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                    </div>
                                    <input type="text" x-model="paymentSearch" placeholder="Cari metode pembayaran..." 
                                           class="w-full sm:w-64 bg-background border-border text-foreground rounded-lg text-sm py-2 pl-9 pr-4 focus:border-[#5D5FEF] focus:ring-[#5D5FEF]">
                                </div>

                                @if($paymentMethods->count() > 0)
                                    <div class="overflow-x-auto rounded-lg border border-border">
                                        <table class="w-full text-left">
                                            <thead>
                                                <tr class="text-muted text-xs uppercase tracking-wider border-b border-border bg-background/50">
                                                    <th class="px-4 sm:px-6 py-3 font-medium">Nama</th>
                                                    <th class="px-4 sm:px-6 py-3 font-medium text-center">Status</th>
                                                    <th class="px-4 sm:px-6 py-3 font-medium text-right">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-border bg-card">
                                                @foreach($paymentMethods as $method)
                                                    <tr class="text-sm group hover:bg-background/50 transition-colors {{ !$method->is_active ? 'opacity-60' : '' }}"
                                                        x-show="paymentSearch === '' || '{{ strtolower($method->name) }}'.includes(paymentSearch.toLowerCase())">
                                                        <td class="px-4 sm:px-6 py-4">
                                                            <div class="flex items-center gap-3">
                                                                <div class="w-8 h-8 rounded-lg {{ $method->is_active ? 'bg-green-100 dark:bg-green-900/30' : 'bg-gray-100 dark:bg-gray-800' }} flex items-center justify-center text-lg">
                                                                    {{ $method->icon ?? '💳' }}
                                                                </div>
                                                                <span class="font-medium text-foreground">{{ $method->name }}</span>
                                                            </div>
                                                        </td>
                                                        <td class="px-4 sm:px-6 py-4 text-center">
                                                            @if($method->is_active)
                                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400">
                                                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                                                    Aktif
                                                                </span>
                                                            @else
                                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400">
                                                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                                                    Nonaktif
                                                                </span>
                                                            @endif
                                                        </td>
                                                        <td class="px-4 sm:px-6 py-4">
                                                            <div class="flex items-center justify-end gap-1">
                                                                <!-- Toggle Active Button -->
                                                                <form action="{{ route('payment-methods.toggle', $method) }}" method="POST" class="inline">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <button type="submit" 
                                                                            class="p-2 rounded-lg hover:bg-amber-50 dark:hover:bg-amber-900/30 {{ $method->is_active ? 'text-amber-500' : 'text-green-500' }} transition-colors" 
                                                                            title="{{ $method->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                                        @if($method->is_active)
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
                                                                <button @click="editMethod({{ $method }})" 
                                                                        class="p-2 rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/30 text-[#5D5FEF] transition-colors" 
                                                                        title="Edit">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                                    </svg>
                                                                </button>
                                                                <button type="button" 
                                                                        onclick="confirmDelete('payment-{{ $method->id }}')" 
                                                                        class="p-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/30 text-red-400 transition-colors" 
                                                                        title="Hapus">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                                    </svg>
                                                                </button>
                                                                <form id="delete-form-payment-{{ $method->id }}" action="{{ route('payment-methods.destroy', $method) }}" method="POST" style="display: none;">
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
                                    <div class="mt-4">
                                        {{ $paymentMethods->appends(['tab' => 'payment-methods'])->links('vendor.pagination.custom') }}
                                    </div>
                                @else
                                    <!-- Empty State -->
                                    <div class="text-center py-12 bg-background/30 rounded-xl border border-dashed border-border">
                                        <svg class="mx-auto h-12 w-12 text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                        </svg>
                                        <h3 class="mt-4 text-sm font-medium text-foreground">Belum ada metode pembayaran</h3>
                                        <p class="mt-1 text-sm text-muted">Tambahkan metode pembayaran seperti Tunai, QRIS, dll.</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Right Column: Form -->
                            <div class="lg:col-span-1 order-1 lg:order-2">
                                <div class="bg-gradient-to-br from-background to-background/50 rounded-xl p-5 border border-border sticky top-6">
                                    <div class="flex items-center gap-2 mb-4">
                                        <div class="p-2 rounded-lg bg-green-100 dark:bg-green-900/30">
                                            <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x-show="!isEdit" d="M12 4v16m8-8H4"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x-show="isEdit" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </div>
                                        <h2 class="text-lg font-bold text-foreground" x-text="isEdit ? 'Edit Metode' : 'Tambah Metode'"></h2>
                                    </div>
                                    
                                    <form :action="formAction" method="POST">
                                        @csrf
                                        <input type="hidden" name="_method" :value="formMethod">
                                        
                                        <div class="space-y-4">
                                            <div>
                                                <x-input-label for="pm_name" value="Nama Metode" class="text-sm" />
                                                <x-text-input id="pm_name" name="name" type="text" class="mt-1.5 block w-full" x-model="method.name" required placeholder="Contoh: Tunai, QRIS, Transfer" />
                                            </div>

                                            <div class="flex justify-end gap-2 pt-2">
                                                <button type="button" x-show="isEdit" @click="resetForm()" class="px-4 py-2 text-sm font-medium text-muted hover:text-foreground transition-colors rounded-lg hover:bg-background">
                                                    Batal
                                                </button>
                                                <button type="submit" class="bg-[#5D5FEF] hover:bg-[#4b4ddb] text-white font-medium py-2.5 px-5 rounded-lg transition duration-150 ease-in-out shadow-lg shadow-indigo-500/25 flex items-center gap-2">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                    <span x-text="isEdit ? 'Perbarui' : 'Simpan'"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- ==================== USERS TAB ==================== -->
                    <div x-show="activeTab === 'users'" style="display: none;" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" x-data="{ 
                            isEdit: false, 
                            formAction: '{{ route('users.store') }}',
                            formMethod: 'POST',
                            user: { role: 'cashier' },
                            resetForm() {
                                this.isEdit = false;
                                this.formAction = '{{ route('users.store') }}';
                                this.formMethod = 'POST';
                                this.user = { role: 'cashier' };
                            },
                            editUser(data) {
                                this.isEdit = true;
                                this.formAction = '{{ route('users.index') }}/' + data.id;
                                this.formMethod = 'PUT';
                                this.user = data;
                            }
                        }">
                            
                            <!-- Left Column: Table -->
                            <div class="lg:col-span-2 order-2 lg:order-1">
                                <!-- Search -->
                                <div class="mb-4 relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                    </div>
                                    <input type="text" x-model="userSearch" placeholder="Cari pengguna..." 
                                           class="w-full sm:w-64 bg-background border-border text-foreground rounded-lg text-sm py-2 pl-9 pr-4 focus:border-[#5D5FEF] focus:ring-[#5D5FEF]">
                                </div>

                                @if($users->count() > 0)
                                    <div class="overflow-x-auto rounded-lg border border-border">
                                        <table class="w-full text-left">
                                            <thead>
                                                <tr class="text-muted text-xs uppercase tracking-wider border-b border-border bg-background/50">
                                                    <th class="px-4 sm:px-6 py-3 font-medium">Pengguna</th>
                                                    <th class="px-4 sm:px-6 py-3 font-medium hidden sm:table-cell">Email</th>
                                                    <th class="px-4 sm:px-6 py-3 font-medium">Role</th>
                                                    <th class="px-4 sm:px-6 py-3 font-medium text-center">Status</th>
                                                    <th class="px-4 sm:px-6 py-3 font-medium text-right">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-border bg-card">
                                                @foreach($users as $user)
                                                    <tr class="text-sm group hover:bg-background/50 transition-colors {{ !$user->is_active ? 'opacity-60' : '' }}"
                                                        x-show="userSearch === '' || '{{ strtolower($user->name) }}'.includes(userSearch.toLowerCase()) || '{{ strtolower($user->email) }}'.includes(userSearch.toLowerCase())">
                                                        <td class="px-4 sm:px-6 py-4">
                                                            <div class="flex items-center gap-3">
                                                                <div class="w-8 h-8 rounded-full {{ $user->is_active ? 'bg-gradient-to-br from-[#5D5FEF] to-[#7c7eff]' : 'bg-gray-400' }} flex items-center justify-center text-white text-sm font-medium">
                                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                                </div>
                                                                <div>
                                                                    <div class="font-medium text-foreground">{{ $user->name }}</div>
                                                                    <div class="text-xs text-muted sm:hidden">{{ $user->email }}</div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="px-4 sm:px-6 py-4 text-muted hidden sm:table-cell">{{ $user->email }}</td>
                                                        <td class="px-4 sm:px-6 py-4">
                                                            <span class="px-2.5 py-1 inline-flex text-xs leading-4 font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400' : 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400' }}">
                                                                {{ ucfirst($user->role) }}
                                                            </span>
                                                        </td>
                                                        <td class="px-4 sm:px-6 py-4 text-center">
                                                            @if($user->is_active)
                                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400">
                                                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                                                    Aktif
                                                                </span>
                                                            @else
                                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400">
                                                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                                                    Nonaktif
                                                                </span>
                                                            @endif
                                                        </td>
                                                        <td class="px-4 sm:px-6 py-4">
                                                            <div class="flex items-center justify-end gap-1">
                                                                @if($user->id !== auth()->id())
                                                                    <!-- Toggle Active Button -->
                                                                    <form action="{{ route('users.toggle', $user) }}" method="POST" class="inline">
                                                                        @csrf
                                                                        @method('PATCH')
                                                                        <button type="submit" 
                                                                                class="p-2 rounded-lg hover:bg-amber-50 dark:hover:bg-amber-900/30 {{ $user->is_active ? 'text-amber-500' : 'text-green-500' }} transition-colors" 
                                                                                title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                                            @if($user->is_active)
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
                                                                @endif
                                                                <button @click="editUser({{ $user }})" 
                                                                        class="p-2 rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/30 text-[#5D5FEF] transition-colors" 
                                                                        title="Edit">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                                    </svg>
                                                                </button>
                                                                @if($user->id !== auth()->id())
                                                                    <button type="button" 
                                                                            onclick="confirmDelete('user-{{ $user->id }}')" 
                                                                            class="p-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/30 text-red-400 transition-colors" 
                                                                            title="Hapus">
                                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                                        </svg>
                                                                    </button>
                                                                    <form id="delete-form-user-{{ $user->id }}" action="{{ route('users.destroy', $user) }}" method="POST" style="display: none;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                    </form>
                                                                @else
                                                                    <span class="p-2 text-muted text-xs">(Anda)</span>
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="mt-4">
                                        {{ $users->appends(['tab' => 'users'])->links('vendor.pagination.custom') }}
                                    </div>
                                @else
                                    <!-- Empty State -->
                                    <div class="text-center py-12 bg-background/30 rounded-xl border border-dashed border-border">
                                        <svg class="mx-auto h-12 w-12 text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                        </svg>
                                        <h3 class="mt-4 text-sm font-medium text-foreground">Belum ada pengguna lain</h3>
                                        <p class="mt-1 text-sm text-muted">Tambahkan pengguna baru untuk mengelola kasir.</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Right Column: Form -->
                            <div class="lg:col-span-1 order-1 lg:order-2">
                                <div class="bg-gradient-to-br from-background to-background/50 rounded-xl p-5 border border-border sticky top-6">
                                    <div class="flex items-center gap-2 mb-4">
                                        <div class="p-2 rounded-lg bg-purple-100 dark:bg-purple-900/30">
                                            <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x-show="!isEdit" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x-show="isEdit" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </div>
                                        <h2 class="text-lg font-bold text-foreground" x-text="isEdit ? 'Edit Pengguna' : 'Tambah Pengguna'"></h2>
                                    </div>
                                    
                                    <form :action="formAction" method="POST">
                                        @csrf
                                        <input type="hidden" name="_method" :value="formMethod">
                                        
                                        @if($errors->any())
                                        <div class="mb-4 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                                            <p class="text-sm font-medium text-red-700 dark:text-red-400 mb-1">Terjadi kesalahan:</p>
                                            <ul class="text-xs text-red-600 dark:text-red-400 list-disc list-inside space-y-0.5">
                                                @foreach($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        @endif
                                        
                                        <div class="space-y-4">
                                            <div>
                                                <x-input-label for="user_name" value="Nama" class="text-sm" />
                                                <x-text-input id="user_name" name="name" type="text" class="mt-1.5 block w-full" x-model="user.name" required placeholder="Nama lengkap" />
                                            </div>

                                            <div>
                                                <x-input-label for="user_email" value="Email" class="text-sm" />
                                                <x-text-input id="user_email" name="email" type="email" class="mt-1.5 block w-full" x-model="user.email" required placeholder="email@example.com" />
                                            </div>

                                            <div>
                                                <x-input-label for="user_role" value="Role" class="text-sm" />
                                                <select id="user_role" name="role" class="mt-1.5 block w-full border-border bg-background text-foreground focus:border-[#5D5FEF] focus:ring-[#5D5FEF] rounded-lg shadow-sm" x-model="user.role" required>
                                                    <option value="cashier" :selected="user.role === 'cashier'">Kasir</option>
                                                    <option value="admin" :selected="user.role === 'admin'">Admin</option>
                                                </select>
                                            </div>

                                            <div>
                                                <x-input-label for="user_password" value="Password" class="text-sm" />
                                                <x-text-input id="user_password" name="password" type="password" class="mt-1.5 block w-full" x-bind:required="!isEdit" placeholder="••••••••" />
                                                <p class="text-xs text-muted mt-1.5" x-show="isEdit">Kosongkan jika tidak ingin mengubah password</p>
                                            </div>

                                            <div>
                                                <x-input-label for="user_password_confirmation" value="Konfirmasi Password" class="text-sm" />
                                                <x-text-input id="user_password_confirmation" name="password_confirmation" type="password" class="mt-1.5 block w-full" x-bind:required="!isEdit" placeholder="••••••••" />
                                            </div>

                                            <div class="flex justify-end gap-2 pt-2">
                                                <button type="button" x-show="isEdit" @click="resetForm()" class="px-4 py-2 text-sm font-medium text-muted hover:text-foreground transition-colors rounded-lg hover:bg-background">
                                                    Batal
                                                </button>
                                                <button type="submit" class="bg-[#5D5FEF] hover:bg-[#4b4ddb] text-white font-medium py-2.5 px-5 rounded-lg transition duration-150 ease-in-out shadow-lg shadow-indigo-500/25 flex items-center gap-2">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                    <span x-text="isEdit ? 'Perbarui' : 'Simpan'"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Hapus Data?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#5D5FEF',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
</x-app-layout>
