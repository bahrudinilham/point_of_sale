<x-app-layout>
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: rgba(156, 163, 175, 0.5); border-radius: 20px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background-color: rgba(75, 85, 99, 0.5); }

        /* ApexCharts Tooltip Customization */
        .apexcharts-tooltip {
            background-color: var(--bg-card) !important;
            border-color: var(--border-color) !important;
            color: var(--text-primary) !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06) !important;
        }
        .apexcharts-tooltip-title {
            background-color: var(--bg-background) !important;
            border-bottom: 1px solid var(--border-color) !important;
            font-family: inherit !important;
            color: var(--text-primary) !important;
        }
        .apexcharts-text {
            fill: var(--text-secondary) !important;
        }
        .dark .apexcharts-tooltip {
            background-color: var(--bg-card) !important;
            border-color: var(--border-color) !important;
            color: var(--text-primary) !important;
        }
        .dark .apexcharts-tooltip-title {
            background-color: var(--bg-background) !important;
            border-bottom: 1px solid var(--border-color) !important;
            color: var(--text-primary) !important;
        }
    </style>

    <div class="min-h-screen bg-background text-foreground font-sans">
        <!-- Header Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-foreground">Dashboard</h1>
                    <p class="text-muted text-sm mt-1">Selamat datang, {{ Auth::user()->name }}! 👋</p>
                </div>
                <div class="text-sm text-muted">
                    {{ now()->translatedFormat('l, d F Y') }}
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12 space-y-6">
            
            <!-- Quick Actions -->
            <div class="flex flex-wrap gap-2 sm:gap-3">
                <a href="{{ route('pos.index') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-[#5D5FEF] to-[#4b4ddb] text-white px-4 py-2.5 rounded-xl font-medium shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/40 transition-all duration-200 hover:scale-105">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    Transaksi Baru
                </a>
            </div>
            
            <!-- Stats Grid -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                <!-- Sales Today -->
                <div class="bg-card rounded-xl p-4 sm:p-5 border border-border shadow-sm">
                    <div class="flex items-start justify-between">
                        <div class="p-2 sm:p-2.5 rounded-lg bg-emerald-100 dark:bg-emerald-900/30">
                            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        @if($salesChange != 0)
                            <span class="inline-flex items-center text-xs font-medium {{ $salesChange >= 0 ? 'text-emerald-500' : 'text-red-500' }}">
                                <svg class="w-3 h-3 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $salesChange >= 0 ? 'M5 10l7-7m0 0l7 7m-7-7v18' : 'M19 14l-7 7m0 0l-7-7m7 7V3' }}"/>
                                </svg>
                                {{ abs(round($salesChange)) }}%
                            </span>
                        @endif
                    </div>
                    <div class="mt-3">
                        <h3 class="text-muted text-xs sm:text-sm font-medium">Penjualan Hari Ini</h3>
                        <div class="text-lg sm:text-2xl font-bold text-foreground mt-1">Rp {{ number_format($todaySales, 0, ',', '.') }}</div>
                    </div>
                </div>

                <!-- Transactions Today -->
                <div class="bg-card rounded-xl p-4 sm:p-5 border border-border shadow-sm">
                    <div class="flex items-start justify-between">
                        <div class="p-2 sm:p-2.5 rounded-lg bg-indigo-100 dark:bg-indigo-900/30">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        @if($transactionsChange != 0)
                            <span class="inline-flex items-center text-xs font-medium {{ $transactionsChange >= 0 ? 'text-emerald-500' : 'text-red-500' }}">
                                <svg class="w-3 h-3 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $transactionsChange >= 0 ? 'M5 10l7-7m0 0l7 7m-7-7v18' : 'M19 14l-7 7m0 0l-7-7m7 7V3' }}"/>
                                </svg>
                                {{ abs(round($transactionsChange)) }}%
                            </span>
                        @endif
                    </div>
                    <div class="mt-3">
                        <h3 class="text-muted text-xs sm:text-sm font-medium">Jumlah Transaksi</h3>
                        <div class="text-lg sm:text-2xl font-bold text-foreground mt-1">{{ $todayTransactions }}</div>
                    </div>
                </div>

                <!-- Items Sold -->
                <div class="bg-card rounded-xl p-4 sm:p-5 border border-border shadow-sm">
                    <div class="flex items-start justify-between">
                        <div class="p-2 sm:p-2.5 rounded-lg bg-purple-100 dark:bg-purple-900/30">
                            <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-3">
                        <h3 class="text-muted text-xs sm:text-sm font-medium">Item Terjual</h3>
                        <div class="text-lg sm:text-2xl font-bold text-foreground mt-1">{{ $todayItems }}</div>
                    </div>
                </div>

                <!-- Low Stock Alert -->
                <div class="bg-card rounded-xl p-4 sm:p-5 border border-border shadow-sm {{ $lowStockCount > 0 ? 'border-red-200 dark:border-red-900/50' : '' }}">
                    <div class="flex items-start justify-between">
                        <div class="p-2 sm:p-2.5 rounded-lg {{ $lowStockCount > 0 ? 'bg-red-100 dark:bg-red-900/30' : 'bg-emerald-100 dark:bg-emerald-900/30' }}">
                            <svg class="w-5 h-5 {{ $lowStockCount > 0 ? 'text-red-500' : 'text-emerald-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if($lowStockCount > 0)
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                @endif
                            </svg>
                        </div>
                    </div>
                    <div class="mt-3">
                        <h3 class="text-muted text-xs sm:text-sm font-medium">Stok Menipis</h3>
                        <div class="text-lg sm:text-2xl font-bold {{ $lowStockCount > 0 ? 'text-red-500' : 'text-emerald-500' }} mt-1">{{ $lowStockCount }}</div>
                    </div>
                </div>
            </div>

            <!-- Weekly Chart Section -->
            <div class="bg-card rounded-xl p-4 sm:p-6 border border-border shadow-sm">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-2 sm:gap-0 mb-4 sm:mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-foreground">Ringkasan Mingguan</h3>
                        <p class="text-muted text-xs mt-1">{{ $startDateWeekly->format('d M') }} - {{ $endDateWeekly->format('d M Y') }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="sm:text-right">
                            <p class="text-xs text-muted">Total Minggu Ini</p>
                            <p class="text-lg sm:text-xl font-bold text-[#5D5FEF]">Rp {{ number_format($weeklyTotal, 0, ',', '.') }}</p>
                        </div>
                        <span class="bg-[#5D5FEF]/10 text-[#5D5FEF] dark:bg-[#5D5FEF]/20 text-xs font-bold px-3 py-1 rounded-full hidden sm:inline">Mingguan</span>
                    </div>
                </div>
                <div id="weeklyChart" class="w-full"></div>
            </div>

            <!-- Middle Section: Top Products & Payment Breakdown -->

            <!-- Bottom Section: Recent Transactions & Low Stock -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
                
                <!-- Recent Transactions -->
                <div class="lg:col-span-2 bg-card rounded-xl p-4 sm:p-6 border border-border shadow-sm">
                    <div class="flex justify-between items-center mb-4 sm:mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-foreground">Transaksi Terakhir</h3>
                            <p class="text-muted text-xs mt-1">5 transaksi terbaru</p>
                        </div>
                        @if(auth()->user()->role === 'admin')
                        <a href="{{ route('transactions.index') }}" class="text-[#5D5FEF] hover:text-[#4b4ddb] text-sm font-medium flex items-center gap-1 group">
                            Lihat semua
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                        @endif
                    </div>
                    
                    <!-- Desktop Table -->
                    <div class="hidden sm:block overflow-x-auto rounded-lg border border-border">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-muted text-xs uppercase tracking-wider border-b border-border bg-muted/30">
                                    <th class="px-4 py-3 font-medium">Invoice</th>
                                    <th class="px-4 py-3 font-medium">Waktu</th>
                                    <th class="px-4 py-3 font-medium">Kasir</th>
                                    <th class="px-4 py-3 font-medium">Pembayaran</th>
                                    <th class="px-4 py-3 font-medium text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border bg-card">
                                @forelse($recentTransactions as $transaction)
                                <tr class="text-sm group hover:bg-muted/30 transition-all {{ auth()->user()->role === 'admin' ? 'cursor-pointer' : '' }}" @if(auth()->user()->role === 'admin') onclick="window.location='{{ route('transactions.show', $transaction) }}'" @endif>
                                    <td class="px-4 py-3.5">
                                        <div class="flex items-center gap-2">
                                            <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                                            <span class="text-[#5D5FEF] font-medium font-mono text-xs">{{ $transaction->invoice_number }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3.5">
                                        @php
                                            $transDate = $transaction->transaction_date;
                                            $now = now();
                                            $diffInMinutes = (int) $transDate->diffInMinutes($now);
                                            $diffInHours = (int) $transDate->diffInHours($now);
                                            $isToday = $transDate->isToday();
                                            $isYesterday = $transDate->isYesterday();
                                            
                                            if ($diffInMinutes < 1) {
                                                $relativeTime = 'Baru saja';
                                            } elseif ($diffInMinutes < 60) {
                                                $relativeTime = $diffInMinutes . ' menit lalu';
                                            } elseif ($diffInHours < 24 && $isToday) {
                                                $relativeTime = $diffInHours . ' jam lalu';
                                            } elseif ($isYesterday) {
                                                $relativeTime = 'Kemarin';
                                            } else {
                                                $relativeTime = $transDate->format('d M Y');
                                            }
                                        @endphp
                                        <div class="text-foreground text-xs">{{ $relativeTime }}</div>
                                        <div class="text-muted text-[10px]">{{ $transDate->format('H:i') }} WIB</div>
                                    </td>
                                    <td class="px-4 py-3.5">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white text-[10px] font-bold shadow-sm">
                                                {{ strtoupper(substr($transaction->user->name ?? 'U', 0, 1)) }}
                                            </div>
                                            <span class="text-foreground text-xs">{{ $transaction->user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3.5">
                                        @php
                                            $paymentName = $transaction->paymentMethod->name ?? 'Unknown';
                                            $paymentIcon = $transaction->paymentMethod->icon ?? null;
                                            
                                            // Fallback to keyword matching if no icon in database
                                            if (!$paymentIcon) {
                                                $paymentIcon = match(strtolower($paymentName)) {
                                                    'cash', 'tunai' => '💵',
                                                    'transfer', 'bank' => '🏦',
                                                    'qris', 'qr' => '📱',
                                                    'debit', 'credit', 'kartu' => '💳',
                                                    'e-wallet', 'ewallet', 'gopay', 'ovo', 'dana' => '📲',
                                                    default => '💰'
                                                };
                                            }
                                        @endphp
                                        <span class="inline-flex items-center gap-1.5 px-2 py-1 bg-muted/50 rounded-full text-[10px] font-medium text-foreground">
                                            <span>{{ $paymentIcon }}</span>
                                            {{ $paymentName }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3.5 text-right">
                                        <span class="text-emerald-600 dark:text-emerald-400 font-bold text-sm">Rp {{ number_format($transaction->final_amount, 0, ',', '.') }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div class="w-16 h-16 rounded-full bg-muted/30 flex items-center justify-center">
                                                <svg class="w-8 h-8 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                            </div>
                                            <div>
                                                <p class="text-foreground font-medium">Belum ada transaksi</p>
                                                <p class="text-muted text-sm">Transaksi akan muncul di sini</p>
                                            </div>
                                            <a href="{{ route('pos.index') }}" class="mt-2 px-4 py-2 bg-[#5D5FEF] hover:bg-[#4b4ddb] text-white text-sm font-medium rounded-lg transition-colors">
                                                Buat Transaksi
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Card View -->
                    <div class="sm:hidden space-y-3">
                        @forelse($recentTransactions as $transaction)
                        @if(auth()->user()->role === 'admin')
                        <a href="{{ route('transactions.show', $transaction) }}" class="block bg-background p-4 rounded-xl border border-border hover:border-[#5D5FEF]/50 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 group">
                            <div class="flex justify-between items-start gap-4">
                                <div class="flex-1 min-w-0">
                                    <!-- Invoice with shortened format -->
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 shadow-sm shadow-emerald-500/50"></div>
                                        @php
                                            $shortInvoice = 'INV-' . substr($transaction->invoice_number, -10);
                                        @endphp
                                        <span class="font-semibold text-[#5D5FEF] font-mono text-xs">{{ $shortInvoice }}</span>
                                    </div>
                                    
                                    <!-- Time -->
                                    @php
                                        $transDate = $transaction->transaction_date;
                                        $now = now();
                                        $diffInMinutes = (int) $transDate->diffInMinutes($now);
                                        $diffInHours = (int) $transDate->diffInHours($now);
                                        $isToday = $transDate->isToday();
                                        $isYesterday = $transDate->isYesterday();
                                        
                                        if ($diffInMinutes < 1) {
                                            $relativeTime = 'Baru saja';
                                        } elseif ($diffInMinutes < 60) {
                                            $relativeTime = $diffInMinutes . ' menit lalu';
                                        } elseif ($diffInHours < 24 && $isToday) {
                                            $relativeTime = $diffInHours . ' jam lalu';
                                        } elseif ($isYesterday) {
                                            $relativeTime = 'Kemarin';
                                        } else {
                                            $relativeTime = $transDate->format('d M Y');
                                        }
                                    @endphp
                                    <p class="text-xs text-muted mb-3">{{ $relativeTime }} • {{ $transDate->format('H:i') }}</p>
                                    
                                    <!-- User & Payment Method Row -->
                                    <div class="flex items-center gap-3 flex-wrap">
                                        <!-- User -->
                                        <div class="flex items-center gap-1.5">
                                            <div class="w-5 h-5 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white text-[8px] font-bold shadow-sm">
                                                {{ strtoupper(substr($transaction->user->name ?? 'U', 0, 1)) }}
                                            </div>
                                            <span class="text-xs text-foreground font-medium">{{ Str::limit($transaction->user->name, 12) }}</span>
                                        </div>
                                        
                                        <!-- Payment Method Badge with Colors -->
                                        @php
                                            $paymentName = $transaction->paymentMethod->name ?? 'Unknown';
                                            $paymentLower = strtolower($paymentName);
                                            $paymentConfig = match(true) {
                                                in_array($paymentLower, ['cash', 'tunai']) => ['icon' => '💵', 'bg' => 'bg-emerald-100 dark:bg-emerald-900/30', 'text' => 'text-emerald-700 dark:text-emerald-300'],
                                                in_array($paymentLower, ['transfer', 'bank']) => ['icon' => '🏦', 'bg' => 'bg-blue-100 dark:bg-blue-900/30', 'text' => 'text-blue-700 dark:text-blue-300'],
                                                in_array($paymentLower, ['qris', 'qr']) => ['icon' => '📱', 'bg' => 'bg-purple-100 dark:bg-purple-900/30', 'text' => 'text-purple-700 dark:text-purple-300'],
                                                in_array($paymentLower, ['debit', 'credit', 'kartu']) => ['icon' => '💳', 'bg' => 'bg-orange-100 dark:bg-orange-900/30', 'text' => 'text-orange-700 dark:text-orange-300'],
                                                in_array($paymentLower, ['e-wallet', 'ewallet', 'gopay', 'ovo', 'dana']) => ['icon' => '📲', 'bg' => 'bg-cyan-100 dark:bg-cyan-900/30', 'text' => 'text-cyan-700 dark:text-cyan-300'],
                                                default => ['icon' => '💰', 'bg' => 'bg-gray-100 dark:bg-gray-800', 'text' => 'text-gray-700 dark:text-gray-300'],
                                            };
                                        @endphp
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-medium {{ $paymentConfig['bg'] }} {{ $paymentConfig['text'] }}">
                                            <span>{{ $paymentConfig['icon'] }}</span>
                                            {{ $paymentName }}
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Amount & Arrow -->
                                <div class="text-right shrink-0">
                                    <p class="text-emerald-600 dark:text-emerald-400 font-bold text-base">Rp {{ number_format($transaction->final_amount, 0, ',', '.') }}</p>
                                    <div class="flex items-center justify-end gap-1 mt-1">
                                        <span class="text-[10px] text-muted opacity-0 group-hover:opacity-100 transition-opacity">Detail</span>
                                        <svg class="w-4 h-4 text-[#5D5FEF] opacity-50 group-hover:opacity-100 group-hover:translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @else
                        <div class="block bg-background p-4 rounded-xl border border-border">
                            <div class="flex justify-between items-start gap-4">
                                <div class="flex-1 min-w-0">
                                    <!-- Invoice with shortened format -->
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 shadow-sm shadow-emerald-500/50"></div>
                                        @php
                                            $shortInvoice = 'INV-' . substr($transaction->invoice_number, -10);
                                        @endphp
                                        <span class="font-semibold text-[#5D5FEF] font-mono text-xs">{{ $shortInvoice }}</span>
                                    </div>
                                    
                                    <!-- Time -->
                                    @php
                                        $transDate = $transaction->transaction_date;
                                        $now = now();
                                        $diffInMinutes = (int) $transDate->diffInMinutes($now);
                                        $diffInHours = (int) $transDate->diffInHours($now);
                                        $isToday = $transDate->isToday();
                                        $isYesterday = $transDate->isYesterday();
                                        
                                        if ($diffInMinutes < 1) {
                                            $relativeTime = 'Baru saja';
                                        } elseif ($diffInMinutes < 60) {
                                            $relativeTime = $diffInMinutes . ' menit lalu';
                                        } elseif ($diffInHours < 24 && $isToday) {
                                            $relativeTime = $diffInHours . ' jam lalu';
                                        } elseif ($isYesterday) {
                                            $relativeTime = 'Kemarin';
                                        } else {
                                            $relativeTime = $transDate->format('d M Y');
                                        }
                                    @endphp
                                    <p class="text-xs text-muted mb-3">{{ $relativeTime }} • {{ $transDate->format('H:i') }}</p>
                                    
                                    <!-- Payment Method Badge with Colors -->
                                    @php
                                        $paymentName = $transaction->paymentMethod->name ?? 'Unknown';
                                        $paymentLower = strtolower($paymentName);
                                        $paymentConfig = match(true) {
                                            in_array($paymentLower, ['cash', 'tunai']) => ['icon' => '💵', 'bg' => 'bg-emerald-100 dark:bg-emerald-900/30', 'text' => 'text-emerald-700 dark:text-emerald-300'],
                                            in_array($paymentLower, ['transfer', 'bank']) => ['icon' => '🏦', 'bg' => 'bg-blue-100 dark:bg-blue-900/30', 'text' => 'text-blue-700 dark:text-blue-300'],
                                            in_array($paymentLower, ['qris', 'qr']) => ['icon' => '📱', 'bg' => 'bg-purple-100 dark:bg-purple-900/30', 'text' => 'text-purple-700 dark:text-purple-300'],
                                            in_array($paymentLower, ['debit', 'credit', 'kartu']) => ['icon' => '💳', 'bg' => 'bg-orange-100 dark:bg-orange-900/30', 'text' => 'text-orange-700 dark:text-orange-300'],
                                            in_array($paymentLower, ['e-wallet', 'ewallet', 'gopay', 'ovo', 'dana']) => ['icon' => '📲', 'bg' => 'bg-cyan-100 dark:bg-cyan-900/30', 'text' => 'text-cyan-700 dark:text-cyan-300'],
                                            default => ['icon' => '💰', 'bg' => 'bg-gray-100 dark:bg-gray-800', 'text' => 'text-gray-700 dark:text-gray-300'],
                                        };
                                    @endphp
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-medium {{ $paymentConfig['bg'] }} {{ $paymentConfig['text'] }}">
                                        <span>{{ $paymentConfig['icon'] }}</span>
                                        {{ $paymentName }}
                                    </span>
                                </div>
                                
                                <!-- Amount -->
                                <div class="text-right shrink-0">
                                    <p class="text-emerald-600 dark:text-emerald-400 font-bold text-base">Rp {{ number_format($transaction->final_amount, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @empty
                        <div class="text-center py-12">
                            <div class="w-16 h-16 rounded-full bg-muted/30 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            </div>
                            <p class="text-foreground font-medium">Belum ada transaksi</p>
                            <p class="text-muted text-sm mb-4">Transaksi akan muncul di sini</p>
                            <a href="{{ route('pos.index') }}" class="inline-block px-4 py-2 bg-[#5D5FEF] hover:bg-[#4b4ddb] text-white text-sm font-medium rounded-lg transition-colors">
                                Buat Transaksi
                            </a>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Low Stock Products List -->
                <div class="bg-card rounded-xl p-4 sm:p-6 shadow-sm {{ $lowStockCount > 0 ? 'border-2 border-red-500/50' : 'border border-border' }}">
                    <div class="mb-4">
                        <h3 class="text-lg font-bold text-foreground flex items-center gap-2">
                            @if($lowStockCount > 0)
                                <span class="text-xl">⚠️</span>
                            @else
                                <span class="text-xl">✅</span>
                            @endif
                            Stok Menipis
                        </h3>
                        <p class="text-muted text-xs mt-1">Produk dengan stok ≤ 10</p>
                    </div>

                    <div class="space-y-3 max-h-[385px] overflow-y-auto custom-scrollbar pr-1">
                        @forelse($lowStockProducts as $product)
                        <div class="flex justify-between items-center p-3 bg-background rounded-lg border border-border">
                            <div class="flex items-center space-x-3">
                                <div class="bg-red-500/10 p-2 rounded-lg text-red-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                </div>
                                <div class="min-w-0">
                                    <div class="text-sm font-medium text-foreground truncate">{{ $product->name }}</div>
                                    <div class="text-xs text-muted">{{ $product->category->name ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="text-right shrink-0">
                                <div class="text-sm font-bold text-red-500">{{ $product->stock }}</div>
                                <div class="text-xs text-muted">Stok</div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center text-muted py-8">
                            <svg class="w-12 h-12 mx-auto mb-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-sm font-medium text-emerald-600 dark:text-emerald-400">Semua stok aman!</p>
                            <p class="text-xs mt-1">Tidak ada produk dengan stok rendah</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ApexCharts CDN -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.documentElement.style.setProperty('--text-secondary', getComputedStyle(document.documentElement).getPropertyValue('--color-muted'));
            document.documentElement.style.setProperty('--border-color', getComputedStyle(document.documentElement).getPropertyValue('--color-border'));

            var options = {
                series: [{
                    name: 'Penjualan',
                    data: @json($weeklySales)
                }],
                chart: {
                    type: 'area',
                    height: 300,
                    toolbar: { show: false },
                    zoom: { enabled: false },
                    background: 'transparent',
                    fontFamily: 'Inter, sans-serif'
                },
                dataLabels: { enabled: false },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                grid: {
                    borderColor: 'var(--border-color)',
                    strokeDashArray: 4,
                    yaxis: { lines: { show: true } },
                    xaxis: { lines: { show: false } },
                    padding: { top: 0, right: 0, bottom: 0, left: 10 }
                },
                theme: { mode: document.documentElement.classList.contains('dark') ? 'dark' : 'light' },
                xaxis: {
                    categories: @json($weeklyLabels),
                    labels: { style: { colors: 'var(--text-secondary)' } },
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                    tooltip: { enabled: false }
                },
                yaxis: {
                    labels: { 
                        style: { colors: 'var(--text-secondary)' },
                        formatter: function(val) {
                            return 'Rp ' + (val / 1000000).toFixed(1) + 'jt';
                        }
                    },
                },
                colors: ['#5D5FEF'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.1,
                        stops: [0, 90, 100]
                    }
                },
                tooltip: {
                    enabled: true,
                    theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light',
                    custom: function({series, seriesIndex, dataPointIndex, w}) {
                        const value = series[seriesIndex][dataPointIndex];
                        const date = w.globals.categoryLabels[dataPointIndex];
                        const formattedValue = new Intl.NumberFormat('id-ID').format(value);
                        
                        return `
                            <div style="background-color: var(--bg-card); border: 1px solid var(--border-color); padding: 8px 12px; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                                <div style="font-size: 11px; color: var(--text-secondary); margin-bottom: 4px;">${date}</div>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <div style="width: 8px; height: 8px; border-radius: 50%; background-color: #5D5FEF;"></div>
                                    <span style="font-weight: 600; font-size: 14px; color: var(--text-primary);">Rp ${formattedValue}</span>
                                </div>
                            </div>
                        `;
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#weeklyChart"), options);
            chart.render();

            const observer = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                    if (mutation.attributeName === 'class') {
                        const isDark = document.documentElement.classList.contains('dark');
                        const themeMode = isDark ? 'dark' : 'light';
                        
                        document.documentElement.style.setProperty('--text-secondary', getComputedStyle(document.documentElement).getPropertyValue('--color-muted'));
                        document.documentElement.style.setProperty('--border-color', getComputedStyle(document.documentElement).getPropertyValue('--color-border'));

                        const textColor = getComputedStyle(document.documentElement).getPropertyValue('--text-secondary');
                        const borderColor = getComputedStyle(document.documentElement).getPropertyValue('--border-color');
                        
                        chart.updateOptions({
                            theme: { mode: themeMode },
                            grid: { borderColor: borderColor },
                            xaxis: { labels: { style: { colors: textColor } } },
                            yaxis: { labels: { style: { colors: textColor } } },
                            tooltip: { theme: themeMode }
                        });
                    }
                });
            });
            observer.observe(document.documentElement, { attributes: true });
        });
    </script>
</x-app-layout>
