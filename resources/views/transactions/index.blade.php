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
                <h1 class="text-3xl font-bold text-foreground">Riwayat Transaksi</h1>
                <p class="text-muted mt-1">Lihat dan kelola semua transaksi penjualan</p>
            </div>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-4">
        <div class="grid grid-cols-2 gap-3 sm:gap-4">
            <!-- Total Transactions (Filtered) -->
            <div class="bg-card rounded-xl p-4 border border-border flex items-center gap-3">
                <div class="p-2.5 rounded-lg bg-indigo-100 dark:bg-indigo-900/30 shrink-0">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <div class="text-xl sm:text-2xl font-bold text-foreground">{{ number_format($totalTransactions) }}</div>
                    <div class="text-[10px] sm:text-xs text-muted">Transaksi</div>
                </div>
            </div>

            <!-- Today's Transactions -->
            <div class="bg-card rounded-xl p-4 border border-border flex items-center gap-3">
                <div class="p-2.5 rounded-lg bg-amber-100 dark:bg-amber-900/30 shrink-0">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <div class="text-xl sm:text-2xl font-bold text-foreground">{{ $todayTransactions }}</div>
                    <div class="text-[10px] sm:text-xs text-muted">Hari Ini</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filters -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-4">
        <div class="bg-card rounded-xl p-4 border border-border">
            <form method="GET" action="{{ route('transactions.index') }}" class="space-y-4">
                <!-- Search Row -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <!-- Invoice Search -->
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" name="search" placeholder="Cari nomor invoice..." value="{{ request('search') }}" 
                               class="w-full bg-background border-border text-foreground rounded-lg text-sm py-2.5 pl-10 pr-4 focus:border-[#5D5FEF] focus:ring-[#5D5FEF]">
                    </div>
                    
                    <!-- Quick Date Presets -->
                    <div class="flex flex-wrap gap-2">
                        @php
                            $today = now()->format('Y-m-d');
                            $weekStart = now()->startOfWeek()->format('Y-m-d');
                            $monthStart = now()->startOfMonth()->format('Y-m-d');
                            
                            // Use preset parameter for determining active state
                            $preset = request('preset');
                            $isToday = $preset == 'today';
                            $isWeek = $preset == 'week';
                            $isMonth = $preset == 'month';
                        @endphp
                        <a href="{{ route('transactions.index', array_merge(request()->except(['start_date', 'end_date', 'preset']), ['start_date' => $today, 'end_date' => $today, 'preset' => 'today'])) }}" 
                           class="px-3 py-2 text-xs font-medium rounded-lg transition-colors {{ $isToday ? 'bg-[#5D5FEF] text-white' : 'bg-muted/20 text-muted hover:bg-muted/30' }}">
                            Hari Ini
                        </a>
                        <a href="{{ route('transactions.index', array_merge(request()->except(['start_date', 'end_date', 'preset']), ['start_date' => $weekStart, 'end_date' => $today, 'preset' => 'week'])) }}" 
                           class="px-3 py-2 text-xs font-medium rounded-lg transition-colors {{ $isWeek ? 'bg-[#5D5FEF] text-white' : 'bg-muted/20 text-muted hover:bg-muted/30' }}">
                            Minggu Ini
                        </a>
                        <a href="{{ route('transactions.index', array_merge(request()->except(['start_date', 'end_date', 'preset']), ['start_date' => $monthStart, 'end_date' => $today, 'preset' => 'month'])) }}" 
                           class="px-3 py-2 text-xs font-medium rounded-lg transition-colors {{ $isMonth ? 'bg-[#5D5FEF] text-white' : 'bg-muted/20 text-muted hover:bg-muted/30' }}">
                            Bulan Ini
                        </a>
                    </div>
                </div>

                <!-- Filter Row -->
                <div class="flex flex-col lg:flex-row gap-3">
                    <!-- Date From -->
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-muted mb-1">Dari Tanggal</label>
                        <div class="relative max-w-sm">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-muted" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                </svg>
                            </div>
                            <input datepicker datepicker-autohide datepicker-format="yyyy-mm-dd" type="text" name="start_date" value="{{ request('start_date') }}" onchange="this.form.submit()"
                                   class="w-full bg-background border border-border text-foreground text-sm rounded-lg p-2.5 ps-10 block focus:ring-1 focus:ring-[#5D5FEF] focus:border-[#5D5FEF]" placeholder="Pilih tanggal">
                        </div>
                    </div>

                    <!-- Date To -->
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-muted mb-1">Sampai Tanggal</label>
                        <div class="relative max-w-sm">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-muted" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                </svg>
                            </div>
                            <input datepicker datepicker-autohide datepicker-format="yyyy-mm-dd" type="text" name="end_date" value="{{ request('end_date') }}" onchange="this.form.submit()"
                                   class="w-full bg-background border border-border text-foreground text-sm rounded-lg p-2.5 ps-10 block focus:ring-1 focus:ring-[#5D5FEF] focus:border-[#5D5FEF]" placeholder="Pilih tanggal">
                        </div>
                    </div>

                    <!-- Cashier -->
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-muted mb-1">Kasir</label>
                        <div class="relative" x-data="{ 
                            open: false, 
                            selected: '{{ request('user_id') ?? 'all' }}', 
                            label: '{{ $users->find(request('user_id'))?->name ?? 'Semua Kasir' }}' 
                        }">
                            <input type="hidden" name="user_id" x-model="selected">
                            <button @click="open = !open" @click.away="open = false" type="button" 
                                    class="w-full bg-background border border-border text-foreground text-sm rounded-lg p-2.5 flex items-center justify-between focus:ring-1 focus:ring-[#5D5FEF] focus:border-[#5D5FEF] transition-colors">
                                <span x-text="label" class="truncate"></span>
                                <svg class="w-4 h-4 text-muted transition-transform duration-200 shrink-0" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="open" x-transition.origin.top style="display: none;" 
                                 class="absolute z-50 mt-1 w-full bg-card border border-border rounded-lg shadow-lg overflow-hidden max-h-60 overflow-y-auto">
                                <button type="button" class="w-full text-left px-3 py-2.5 text-sm hover:bg-muted/20 transition-colors"
                                        :class="{'text-[#5D5FEF] font-medium bg-[#5D5FEF]/5': selected == 'all', 'text-foreground': selected != 'all'}"
                                        @click="selected = 'all'; label = 'Semua Kasir'; open = false; $nextTick(() => $el.closest('form').submit())">
                                    Semua Kasir
                                </button>
                                @foreach($users as $user)
                                    <button type="button" class="w-full text-left px-3 py-2.5 text-sm hover:bg-muted/20 transition-colors"
                                            :class="{'text-[#5D5FEF] font-medium bg-[#5D5FEF]/5': selected == '{{ $user->id }}', 'text-foreground': selected != '{{ $user->id }}'}"
                                            @click="selected = '{{ $user->id }}'; label = '{{ $user->name }}'; open = false; $nextTick(() => $el.closest('form').submit())">
                                        {{ $user->name }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-muted mb-1">Metode Pembayaran</label>
                        <div class="relative" x-data="{ 
                            open: false, 
                            selected: '{{ request('payment_method') ?? 'all' }}', 
                            label: '{{ collect($paymentMethods)->firstWhere('slug', request('payment_method'))?->name ?? 'Semua Metode' }}' 
                        }">
                            <input type="hidden" name="payment_method" x-model="selected">
                            <button @click="open = !open" @click.away="open = false" type="button" 
                                    class="w-full bg-background border border-border text-foreground text-sm rounded-lg p-2.5 flex items-center justify-between focus:ring-1 focus:ring-[#5D5FEF] focus:border-[#5D5FEF] transition-colors">
                                <span x-text="label" class="truncate"></span>
                                <svg class="w-4 h-4 text-muted transition-transform duration-200 shrink-0" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="open" x-transition.origin.top style="display: none;" 
                                 class="absolute z-50 mt-1 w-full bg-card border border-border rounded-lg shadow-lg overflow-hidden max-h-60 overflow-y-auto">
                                <button type="button" class="w-full text-left px-3 py-2.5 text-sm hover:bg-muted/20 transition-colors"
                                        :class="{'text-[#5D5FEF] font-medium bg-[#5D5FEF]/5': selected == 'all', 'text-foreground': selected != 'all'}"
                                        @click="selected = 'all'; label = 'Semua Metode'; open = false; $nextTick(() => $el.closest('form').submit())">
                                    Semua Metode
                                </button>
                                @foreach($paymentMethods as $method)
                                    <button type="button" class="w-full text-left px-3 py-2.5 text-sm hover:bg-muted/20 transition-colors"
                                            :class="{'text-[#5D5FEF] font-medium bg-[#5D5FEF]/5': selected == '{{ $method->slug }}', 'text-foreground': selected != '{{ $method->slug }}'}"
                                            @click="selected = '{{ $method->slug }}'; label = '{{ $method->name }}'; open = false; $nextTick(() => $el.closest('form').submit())">
                                        {{ $method->name }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-end gap-2">
                        <button type="submit" class="bg-[#5D5FEF] hover:bg-[#4b4ddb] text-white font-medium py-2.5 px-4 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                        @if(request()->hasAny(['search', 'start_date', 'end_date', 'user_id', 'payment_method']))
                            <a href="{{ route('transactions.index') }}" class="flex items-center gap-1 text-muted hover:text-foreground text-sm px-3 py-2.5 rounded-lg hover:bg-muted/20 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Reset
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="pb-20 sm:pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div id="transactions-table" class="bg-card overflow-hidden shadow-xl sm:rounded-xl border border-border">
                <div class="px-4 pt-4 sm:p-6">

                    @if($transactions->count() > 0)
                        <!-- Desktop Table -->
                        <div class="hidden sm:block overflow-x-auto">
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="text-muted text-xs uppercase tracking-wider border-b border-border bg-background/50">
                                        <th class="px-4 lg:px-6 py-3 font-medium">Invoice</th>
                                        <th class="px-4 lg:px-6 py-3 font-medium">Tanggal</th>
                                        <th class="px-4 lg:px-6 py-3 font-medium">Kasir</th>
                                        <th class="px-4 lg:px-6 py-3 font-medium text-center">Items</th>
                                        <th class="px-4 lg:px-6 py-3 font-medium text-right">Total</th>
                                        <th class="px-4 lg:px-6 py-3 font-medium text-center">Metode</th>
                                        <th class="px-4 lg:px-6 py-3 font-medium text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-border bg-card">
                                    @foreach($transactions as $transaction)
                                        <tr class="text-sm group hover:bg-background/50 transition-colors">
                                            <td class="px-4 lg:px-6 py-4">
                                                <span class="text-[#5D5FEF] font-medium font-mono">{{ $transaction->invoice_number }}</span>
                                            </td>
                                            <td class="px-4 lg:px-6 py-4 text-muted">
                                                <div>{{ $transaction->transaction_date->format('d M Y') }}</div>
                                                <div class="text-xs">{{ $transaction->transaction_date->format('H:i') }}</div>
                                            </td>
                                            <td class="px-4 lg:px-6 py-4">
                                                <div class="flex items-center gap-2">
                                                    <div class="w-7 h-7 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white text-xs font-bold">
                                                        {{ strtoupper(substr($transaction->user->name ?? 'U', 0, 1)) }}
                                                    </div>
                                                    <span class="text-foreground">{{ $transaction->user->name ?? '-' }}</span>
                                                </div>
                                            </td>
                                            <td class="px-4 lg:px-6 py-4 text-center">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-muted/20 text-muted">
                                                    {{ $transaction->items->count() }} item
                                                </span>
                                            </td>
                                            <td class="px-4 lg:px-6 py-4 text-right">
                                                <span class="font-bold text-foreground">Rp {{ number_format($transaction->final_amount, 0, ',', '.') }}</span>
                                            </td>
                                            <td class="px-4 lg:px-6 py-4 text-center">
                                                @php
                                                    $colorClass = match($transaction->paymentMethod->color ?? 'gray') {
                                                        'green' => 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400',
                                                        'blue' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400',
                                                        'purple' => 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400',
                                                        'orange' => 'bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400',
                                                        default => 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-400',
                                                    };
                                                @endphp
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colorClass }}">
                                                    {{ strtoupper($transaction->paymentMethod->name ?? '-') }}
                                                </span>
                                            </td>
                                            <td class="px-4 lg:px-6 py-4">
                                                <div class="flex items-center justify-end gap-1">
                                                    <a href="{{ route('transactions.show', $transaction) }}" 
                                                       class="p-2 rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/30 text-[#5D5FEF] transition-colors" 
                                                       title="Lihat Detail">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                        </svg>
                                                    </a>
                                                    <a href="{{ route('transactions.print', $transaction) }}" target="_blank" 
                                                       class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 text-muted hover:text-foreground transition-colors" 
                                                       title="Print Struk">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Card View -->
                        <div class="grid grid-cols-1 gap-3 sm:hidden">
                            @foreach($transactions as $transaction)
                            <div class="bg-background p-4 rounded-xl border border-border shadow-sm">
                                <div class="flex justify-between items-start mb-3">
                                    <div class="min-w-0">
                                        <h3 class="font-medium text-[#5D5FEF] font-mono text-sm">{{ $transaction->invoice_number }}</h3>
                                        <p class="text-xs text-muted mt-0.5">{{ $transaction->transaction_date->format('d M Y, H:i') }}</p>
                                        <div class="flex items-center gap-2 mt-1">
                                            <div class="w-5 h-5 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white text-[10px] font-bold">
                                                {{ strtoupper(substr($transaction->user->name ?? 'U', 0, 1)) }}
                                            </div>
                                            <span class="text-xs text-foreground">{{ $transaction->user->name ?? '-' }}</span>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-lg font-bold text-foreground">Rp {{ number_format($transaction->final_amount, 0, ',', '.') }}</p>
                                        <div class="flex items-center justify-end gap-2 mt-1">
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-muted/20 text-muted">
                                                {{ $transaction->items->count() }} item
                                            </span>
                                            @php
                                                $colorClassMobile = match($transaction->paymentMethod->color ?? 'gray') {
                                                    'green' => 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400',
                                                    'blue' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400',
                                                    'purple' => 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400',
                                                    'orange' => 'bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400',
                                                    default => 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-400',
                                                };
                                            @endphp
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium {{ $colorClassMobile }}">
                                                {{ strtoupper($transaction->paymentMethod->name ?? '-') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-end gap-1 pt-3 border-t border-border">
                                    <a href="{{ route('transactions.show', $transaction) }}" class="p-2 rounded-lg bg-indigo-50 dark:bg-indigo-900/20 text-[#5D5FEF] hover:bg-[#5D5FEF] hover:text-white transition-colors" title="Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    <a href="{{ route('transactions.print', $transaction) }}" target="_blank" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-700 hover:text-white transition-colors" title="Print">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="mt-2 pb-3 sm:mt-4 sm:pb-0">
                            {{ $transactions->fragment('transactions-table')->links('vendor.pagination.custom') }}
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-16">
                            <div class="mx-auto w-16 h-16 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-foreground mb-1">
                                @if(request()->hasAny(['search', 'start_date', 'end_date', 'user_id', 'payment_method']))
                                    Transaksi tidak ditemukan
                                @else
                                    Belum ada transaksi
                                @endif
                            </h3>
                            <p class="text-sm text-muted mb-6">
                                @if(request()->hasAny(['search', 'start_date', 'end_date', 'user_id', 'payment_method']))
                                    Coba ubah filter atau rentang tanggal pencarian
                                @else
                                    Transaksi akan muncul setelah ada penjualan
                                @endif
                            </p>
                            @if(request()->hasAny(['search', 'start_date', 'end_date', 'user_id', 'payment_method']))
                                <a href="{{ route('transactions.index') }}" class="inline-flex items-center gap-2 text-[#5D5FEF] hover:text-[#4b4ddb] font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Reset Filter
                                </a>
                            @else
                                <a href="{{ route('pos.index') }}" class="inline-flex items-center gap-2 bg-[#5D5FEF] hover:bg-[#4b4ddb] text-white font-medium py-2.5 px-4 rounded-lg transition-colors shadow-lg shadow-indigo-500/25">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Buat Transaksi
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
