<x-app-layout>
    <style>
        input[type="date"]::-webkit-calendar-picker-indicator {
            cursor: pointer;
            opacity: 0.6;
            filter: invert(0);
        }
        .dark input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(1);
        }
    </style>

    <!-- Header Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-foreground">Arsip Transaksi</h1>
                <p class="text-muted mt-1">Kelola data transaksi yang sudah diarsipkan</p>
            </div>
            <a href="{{ route('transactions.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-muted/20 text-muted hover:text-foreground hover:bg-muted/30 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Transaksi Aktif
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-4">
        <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
            <!-- Archived Count -->
            <div class="bg-card rounded-xl p-4 border border-border flex items-center gap-3">
                <div class="p-2.5 rounded-lg bg-purple-100 dark:bg-purple-900/30 shrink-0">
                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <div class="text-xl sm:text-2xl font-bold text-foreground">{{ number_format($totalArchived) }}</div>
                    <div class="text-[10px] sm:text-xs text-muted">Total Diarsipkan</div>
                </div>
            </div>

            <!-- Active Count -->
            <div class="bg-card rounded-xl p-4 border border-border flex items-center gap-3">
                <div class="p-2.5 rounded-lg bg-blue-100 dark:bg-blue-900/30 shrink-0">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <div class="text-xl sm:text-2xl font-bold text-foreground">{{ number_format($totalActive) }}</div>
                    <div class="text-[10px] sm:text-xs text-muted">Transaksi Aktif</div>
                </div>
            </div>

            <!-- Date Range -->
            <div class="bg-card rounded-xl p-4 border border-border flex items-center gap-3 col-span-2 lg:col-span-1">
                <div class="p-2.5 rounded-lg bg-amber-100 dark:bg-amber-900/30 shrink-0">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    @if($oldestArchived && $newestArchived)
                        <div class="text-sm font-bold text-foreground">{{ \Carbon\Carbon::parse($oldestArchived)->format('M Y') }} - {{ \Carbon\Carbon::parse($newestArchived)->format('M Y') }}</div>
                    @else
                        <div class="text-sm font-bold text-foreground">-</div>
                    @endif
                    <div class="text-[10px] sm:text-xs text-muted">Rentang Arsip</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Archive Action Card -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-4">
        <div class="bg-card rounded-xl p-4 sm:p-6 border border-border">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h3 class="text-lg font-bold text-foreground flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#5D5FEF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                        </svg>
                        Arsipkan Transaksi Lama
                    </h3>
                    <p class="text-muted text-sm mt-1">Pindahkan transaksi lama ke arsip untuk menjaga performa database</p>
                </div>
                <form action="{{ route('archive.run') }}" method="POST" class="flex items-center gap-3" data-confirm-archive>
                    @csrf
                    <div class="flex items-center gap-2" x-data="{ open: false, selected: '6', label: '6 bulan' }">
                        <label class="text-sm text-muted whitespace-nowrap">Lebih dari</label>
                        <div class="relative">
                            <input type="hidden" name="months" x-model="selected">
                            <button @click="open = !open" @click.away="open = false" type="button" class="bg-background border border-border text-foreground text-sm rounded-lg p-2.5 min-w-[120px] flex justify-between items-center focus:ring-2 focus:ring-[#5D5FEF] focus:border-[#5D5FEF] transition-all">
                                <span x-text="label"></span>
                                <svg class="w-4 h-4 text-muted transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="open" x-transition.origin.top.left class="absolute z-50 mt-1 w-full bg-card border border-border rounded-lg shadow-lg overflow-hidden py-1">
                                <template x-for="option in [
                                    {val: '3', text: '3 bulan'},
                                    {val: '6', text: '6 bulan'},
                                    {val: '12', text: '1 tahun'},
                                    {val: '24', text: '2 tahun'}
                                ]">
                                    <button type="button" class="w-full text-left px-3 py-2 text-sm hover:bg-muted/20 transition-colors" 
                                            :class="{'text-[#5D5FEF] font-medium bg-[#5D5FEF]/5': selected == option.val, 'text-foreground': selected != option.val}"
                                            @click="selected = option.val; label = option.text; open = false">
                                        <span x-text="option.text"></span>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="bg-[#5D5FEF] hover:bg-[#4b4ddb] text-white font-medium py-2.5 px-4 rounded-lg transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                        </svg>
                        Arsipkan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Purge Action Card -->
    @if($totalArchived > 0)
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-4">
        <div class="bg-card rounded-xl p-4 sm:p-6 border-2 border-red-500/30">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h3 class="text-lg font-bold text-foreground flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Hapus Permanen Data Arsip
                    </h3>
                    <p class="text-muted text-sm mt-1">⚠️ Data yang dihapus tidak dapat dikembalikan!</p>
                </div>
                <form action="{{ route('archive.purge') }}" method="POST" class="flex items-center gap-3" data-confirm-purge>
                    @csrf
                    <div class="flex items-center gap-2" x-data="{ open: false, selected: '12', label: '1 tahun' }">
                        <label class="text-sm text-muted whitespace-nowrap">Lebih dari</label>
                        <div class="relative">
                            <input type="hidden" name="months" x-model="selected">
                            <button @click="open = !open" @click.away="open = false" type="button" class="bg-background border border-border text-foreground text-sm rounded-lg p-2.5 min-w-[120px] flex justify-between items-center focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all">
                                <span x-text="label"></span>
                                <svg class="w-4 h-4 text-muted transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="open" x-transition.origin.top.left class="absolute z-50 mt-1 w-full bg-card border border-border rounded-lg shadow-lg overflow-hidden py-1">
                                <template x-for="option in [
                                    {val: '6', text: '6 bulan'},
                                    {val: '12', text: '1 tahun'},
                                    {val: '24', text: '2 tahun'},
                                    {val: '36', text: '3 tahun'},
                                    {val: '60', text: '5 tahun'}
                                ]">
                                    <button type="button" class="w-full text-left px-3 py-2 text-sm hover:bg-muted/20 transition-colors" 
                                            :class="{'text-red-500 font-medium bg-red-500/5': selected == option.val, 'text-foreground': selected != option.val}"
                                            @click="selected = option.val; label = option.text; open = false">
                                        <span x-text="option.text"></span>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2.5 px-4 rounded-lg transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- Search & Filters -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-4">
        <div class="bg-card rounded-xl p-4 border border-border">
            <form method="GET" action="{{ route('archive.index') }}" class="flex flex-col lg:flex-row gap-3">
                <!-- Search -->
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" name="search" placeholder="Cari nomor invoice..." value="{{ request('search') }}" 
                           class="w-full bg-background border-border text-foreground rounded-lg text-sm py-2.5 pl-10 pr-4 focus:border-[#5D5FEF] focus:ring-[#5D5FEF]">
                </div>

                <!-- Date From -->
                <div class="flex-1">
                    <div class="relative max-w-sm">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-muted" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                            </svg>
                        </div>
                        <input datepicker datepicker-autohide datepicker-format="yyyy-mm-dd" type="text" name="start_date" value="{{ request('start_date') }}"
                               class="w-full bg-background border border-border text-foreground text-sm rounded-lg p-2.5 ps-10 block focus:ring-1 focus:ring-[#5D5FEF] focus:border-[#5D5FEF]" placeholder="Dari Tanggal">
                    </div>
                </div>

                <!-- Date To -->
                <div class="flex-1">
                    <div class="relative max-w-sm">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-muted" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                            </svg>
                        </div>
                        <input datepicker datepicker-autohide datepicker-format="yyyy-mm-dd" type="text" name="end_date" value="{{ request('end_date') }}"
                               class="w-full bg-background border border-border text-foreground text-sm rounded-lg p-2.5 ps-10 block focus:ring-1 focus:ring-[#5D5FEF] focus:border-[#5D5FEF]" placeholder="Sampai Tanggal">
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-2">
                    <button type="submit" class="bg-[#5D5FEF] hover:bg-[#4b4ddb] text-white font-medium py-2.5 px-4 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                    @if(request()->hasAny(['search', 'start_date', 'end_date']))
                        <a href="{{ route('archive.index') }}" class="flex items-center gap-1 text-muted hover:text-foreground text-sm px-3 py-2.5 rounded-lg hover:bg-muted/20 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Archived Transactions Table -->
    <div class="pb-20 sm:pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div id="archive-table" class="bg-card overflow-hidden shadow-xl sm:rounded-xl border border-border">
                <div class="px-4 pt-4 sm:p-6">
                    @if($archivedTransactions->isEmpty())
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-muted mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                            </svg>
                            <h3 class="text-lg font-medium text-foreground">Belum Ada Data Arsip</h3>
                            <p class="text-muted mt-2">Transaksi lama yang diarsipkan akan muncul di sini</p>
                        </div>
                    @else
                        <!-- Mobile Card Layout -->
                        <div class="lg:hidden space-y-3">
                            @foreach($archivedTransactions as $transaction)
                            <div class="bg-purple-500/5 rounded-xl p-4 border border-purple-500/20">
                                <!-- Header: Invoice & Amount -->
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-purple-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                        </svg>
                                        <span class="text-purple-500 font-medium text-sm">...{{ substr($transaction->invoice_number, -6) }}</span>
                                    </div>
                                    <span class="font-bold text-foreground">Rp {{ number_format($transaction->final_amount, 0, ',', '.') }}</span>
                                </div>
                                
                                <!-- Details Row -->
                                <div class="flex items-center gap-2 text-sm text-muted mb-3">
                                    <span>{{ $transaction->transaction_date->format('d M Y') }}</span>
                                    <span>•</span>
                                    <div class="flex items-center gap-1">
                                        <div class="w-5 h-5 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center text-purple-600 dark:text-purple-400 text-[10px] font-bold">
                                            {{ strtoupper(substr($transaction->cashier_name, 0, 1)) }}
                                        </div>
                                        <span>{{ $transaction->cashier_name }}</span>
                                    </div>
                                </div>
                                
                                <!-- Tags Row -->
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="px-2 py-1 text-xs font-medium bg-muted/30 text-muted rounded">
                                        {{ $transaction->items->count() }} item
                                    </span>
                                    <span class="px-2 py-1 text-xs font-medium bg-muted/30 text-muted rounded">
                                        {{ $transaction->payment_method_name_display }}
                                    </span>
                                </div>
                                
                                <!-- Actions -->
                                <div class="flex items-center gap-2 pt-3 border-t border-border">
                                    <a href="{{ route('archive.show', $transaction) }}" 
                                       class="flex-1 flex items-center justify-center gap-1 py-2 text-sm text-muted hover:text-foreground bg-muted/20 hover:bg-muted/30 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Detail
                                    </a>
                                    <form action="{{ route('archive.restore', $transaction) }}" method="POST" class="flex-1" data-confirm-restore>
                                        @csrf
                                        <button type="submit" class="w-full flex items-center justify-center gap-1 py-2 text-sm text-emerald-500 hover:text-emerald-600 bg-emerald-500/10 hover:bg-emerald-500/20 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                            </svg>
                                            Pulihkan
                                        </button>
                                    </form>
                                    <form action="{{ route('archive.destroy', $transaction) }}" method="POST" data-confirm-delete>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-500 hover:text-red-600 bg-red-500/10 hover:bg-red-500/20 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Desktop Table Layout -->
                        <div class="hidden lg:block overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="text-xs uppercase bg-muted/30 text-muted">
                                    <tr>
                                        <th class="px-4 lg:px-6 py-3 font-medium">Invoice</th>
                                        <th class="px-4 lg:px-6 py-3 font-medium">Tanggal</th>
                                        <th class="px-4 lg:px-6 py-3 font-medium">Kasir</th>
                                        <th class="px-4 lg:px-6 py-3 font-medium">Items</th>
                                        <th class="px-4 lg:px-6 py-3 font-medium">Total</th>
                                        <th class="px-4 lg:px-6 py-3 font-medium">Metode</th>
                                        <th class="px-4 lg:px-6 py-3 font-medium text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-border">
                                    @foreach($archivedTransactions as $transaction)
                                    <tr class="bg-purple-500/5 hover:bg-purple-500/10 transition-colors">
                                        <td class="px-4 lg:px-6 py-3">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4 text-purple-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                                </svg>
                                                <span class="text-purple-500 font-medium" title="{{ $transaction->invoice_number }}">
                                                    ...{{ substr($transaction->invoice_number, -6) }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-4 lg:px-6 py-3 text-muted text-sm">
                                            {{ $transaction->transaction_date->format('d M Y') }}<br>
                                            <span class="text-xs">{{ $transaction->transaction_date->format('H:i') }}</span>
                                        </td>
                                        <td class="px-4 lg:px-6 py-3">
                                            <div class="flex items-center gap-2">
                                                <div class="w-7 h-7 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center text-purple-600 dark:text-purple-400 text-xs font-bold">
                                                    {{ strtoupper(substr($transaction->cashier_name, 0, 1)) }}
                                                </div>
                                                <span class="text-foreground text-sm">{{ $transaction->cashier_name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-4 lg:px-6 py-3 text-muted text-sm">
                                            {{ $transaction->items->count() }} item
                                        </td>
                                        <td class="px-4 lg:px-6 py-3">
                                            <span class="font-bold text-foreground">Rp {{ number_format($transaction->final_amount, 0, ',', '.') }}</span>
                                        </td>
                                        <td class="px-4 lg:px-6 py-3">
                                            <span class="px-2 py-1 text-xs font-medium bg-muted/30 text-muted rounded">
                                                {{ $transaction->payment_method_name_display }}
                                            </span>
                                        </td>
                                        <td class="px-4 lg:px-6 py-3">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('archive.show', $transaction) }}" 
                                                   class="p-2 text-muted hover:text-foreground hover:bg-muted/20 rounded-lg transition-colors" title="Lihat Detail">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                </a>
                                                <form action="{{ route('archive.restore', $transaction) }}" method="POST" class="inline" data-confirm-restore>
                                                    @csrf
                                                    <button type="submit" class="p-2 text-emerald-500 hover:text-emerald-600 hover:bg-emerald-100 dark:hover:bg-emerald-900/30 rounded-lg transition-colors" title="Pulihkan">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                                <form action="{{ route('archive.destroy', $transaction) }}" method="POST" class="inline" data-confirm-delete>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-2 text-red-500 hover:text-red-600 hover:bg-red-100 dark:hover:bg-red-900/30 rounded-lg transition-colors" title="Hapus Permanen">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-2 pb-3 sm:mt-6 sm:pb-0">
                            {{ $archivedTransactions->fragment('archive-table')->links('vendor.pagination.custom') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // SweetAlert2 Toast Configuration
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });

        // Show session alerts
        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            });
        @endif

        @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: '{{ session('error') }}'
            });
        @endif

        @if(session('info'))
            Toast.fire({
                icon: 'info',
                title: '{{ session('info') }}'
            });
        @endif

        // Archive confirmation
        document.querySelectorAll('form[data-confirm-archive]').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Arsipkan Transaksi?',
                    text: 'Transaksi lama akan dipindahkan ke arsip',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#5D5FEF',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Arsipkan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // Purge confirmation (dangerous action)
        document.querySelectorAll('form[data-confirm-purge]').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Hapus Permanen?',
                    html: '<p class="text-red-500 font-bold">⚠️ PERINGATAN!</p><p>Data yang dihapus <strong>TIDAK DAPAT</strong> dikembalikan!</p>',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Hapus Permanen!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // Restore confirmation
        document.querySelectorAll('form[data-confirm-restore]').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Pulihkan Transaksi?',
                    text: 'Transaksi akan dikembalikan ke data aktif',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#10b981',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Pulihkan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // Delete single confirmation
        document.querySelectorAll('form[data-confirm-delete]').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Hapus Arsip Ini?',
                    text: 'Data tidak dapat dikembalikan setelah dihapus!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
</x-app-layout>
