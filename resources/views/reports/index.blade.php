<x-app-layout>
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>


    <!-- Header Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-foreground">Laporan Penjualan</h1>
                <p class="text-muted mt-1">Pantau performa bisnis dengan analitik penjualan real-time</p>
            </div>
            <div class="flex items-center gap-2">
                <!-- Quick Export -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center gap-2 px-4 py-2 bg-[#5D5FEF] hover:bg-[#4b4ddb] text-white rounded-lg transition-colors shadow-lg shadow-indigo-500/25">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        <span class="text-sm font-medium">Export</span>
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition 
                         class="absolute left-0 sm:left-auto sm:right-0 mt-2 w-48 bg-card rounded-lg shadow-xl border border-border z-50">
                        <a href="{{ route('reports.print', ['type' => 'monthly', 'month' => $selectedMonth]) }}" target="_blank"
                           class="flex items-center gap-2 px-4 py-3 text-sm text-foreground hover:bg-background/50 rounded-t-lg transition-colors">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Laporan Bulanan
                        </a>
                        <a href="{{ route('reports.print', ['type' => 'weekly', 'week' => $selectedWeek, 'month' => request('month')]) }}" target="_blank"
                           class="flex items-center gap-2 px-4 py-3 text-sm text-foreground hover:bg-background/50 transition-colors">
                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Laporan Mingguan
                        </a>
                        <a href="{{ route('reports.print', ['type' => 'custom', 'start_date' => $customStartDate->format('Y-m-d'), 'end_date' => $customEndDate->format('Y-m-d')]) }}" target="_blank"
                           class="flex items-center gap-2 px-4 py-3 text-sm text-foreground hover:bg-background/50 rounded-b-lg transition-colors">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Laporan Custom
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="space-y-6">
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6">
                <!-- Today -->
                <div class="bg-gradient-to-br from-indigo-500/10 via-card to-card rounded-xl p-5 shadow-sm border border-border relative overflow-hidden group hover:shadow-md transition-shadow">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-indigo-500/5 rounded-full -mr-8 -mt-8 group-hover:scale-110 transition-transform"></div>
                    <div class="flex items-start gap-4">
                        <div class="p-3 rounded-xl bg-indigo-500/20 shrink-0">
                            <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-muted text-xs font-medium uppercase tracking-wider">Hari Ini</div>
                            <div class="text-2xl font-bold text-foreground mt-1 truncate">Rp {{ number_format($todaySales, 0, ',', '.') }}</div>
                            <div class="flex items-center gap-2 mt-2">
                                <div class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold {{ $todayGrowth >= 0 ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400' : 'bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400' }}">
                                    @if($todayGrowth >= 0)
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                        </svg>
                                        +{{ number_format($todayGrowth, 1) }}%
                                    @else
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                                        </svg>
                                        {{ number_format($todayGrowth, 1) }}%
                                    @endif
                                </div>
                                <span class="text-muted text-xs">vs Kemarin</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- This Week -->
                <div class="bg-gradient-to-br from-emerald-500/10 via-card to-card rounded-xl p-5 shadow-sm border border-border relative overflow-hidden group hover:shadow-md transition-shadow">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-500/5 rounded-full -mr-8 -mt-8 group-hover:scale-110 transition-transform"></div>
                    <div class="flex items-start gap-4">
                        <div class="p-3 rounded-xl bg-emerald-500/20 shrink-0">
                            <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-muted text-xs font-medium uppercase tracking-wider">Minggu Ini</div>
                            <div class="text-2xl font-bold text-foreground mt-1 truncate">Rp {{ number_format($currentWeekSales, 0, ',', '.') }}</div>
                            <div class="flex items-center gap-2 mt-2">
                                <div class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold {{ $weekGrowth >= 0 ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400' : 'bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400' }}">
                                    @if($weekGrowth >= 0)
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                        </svg>
                                        +{{ number_format($weekGrowth, 1) }}%
                                    @else
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                                        </svg>
                                        {{ number_format($weekGrowth, 1) }}%
                                    @endif
                                </div>
                                <span class="text-muted text-xs">vs Minggu Lalu</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- This Month -->
                <div class="bg-gradient-to-br from-amber-500/10 via-card to-card rounded-xl p-5 shadow-sm border border-border relative overflow-hidden group hover:shadow-md transition-shadow">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-amber-500/5 rounded-full -mr-8 -mt-8 group-hover:scale-110 transition-transform"></div>
                    <div class="flex items-start gap-4">
                        <div class="p-3 rounded-xl bg-amber-500/20 shrink-0">
                            <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-muted text-xs font-medium uppercase tracking-wider">Bulan Ini</div>
                            <div class="text-2xl font-bold text-foreground mt-1 truncate">Rp {{ number_format($currentMonthSales, 0, ',', '.') }}</div>
                            <div class="flex items-center gap-2 mt-2">
                                <div class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold {{ $monthGrowth >= 0 ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400' : 'bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400' }}">
                                    @if($monthGrowth >= 0)
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                        </svg>
                                        +{{ number_format($monthGrowth, 1) }}%
                                    @else
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                                        </svg>
                                        {{ number_format($monthGrowth, 1) }}%
                                    @endif
                                </div>
                                <span class="text-muted text-xs">vs Bulan Lalu</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Weekly Report Card -->
                <div class="bg-card rounded-xl p-5 sm:p-6 shadow-sm border border-border relative">
                    <div class="flex flex-col sm:flex-row justify-between items-start mb-4 gap-3">
                        <div>
                            <div class="flex items-center gap-2">
                                <div class="p-1.5 rounded-lg bg-indigo-100 dark:bg-indigo-900/30">
                                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <h3 class="text-foreground text-sm font-semibold">Penjualan Mingguan</h3>
                            </div>
                            <div class="text-2xl sm:text-3xl font-bold text-foreground mt-2">Rp {{ number_format($totalWeeklySales, 0, ',', '.') }}</div>
                            <div class="flex items-center gap-3 mt-1">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    {{ $weeklyTransactionCount }} transaksi
                                </span>
                                <span class="text-muted text-xs">{{ $startDateWeekly->format('d M') }} - {{ $endDateWeekly->format('d M Y') }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 w-full sm:w-auto">
                            <div x-data="{ open: false }" class="relative flex-1 sm:flex-none">
                                <button @click="open = !open" type="button" 
                                        class="w-full sm:w-auto flex items-center justify-between gap-2 bg-background text-foreground text-xs font-medium px-3 py-2 rounded-lg border border-border hover:border-[#5D5FEF] transition-colors">
                                    <span>{{ $weeks[$selectedWeek]['label'] }}</span>
                                    <svg class="w-4 h-4 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                <div x-show="open" @click.away="open = false" x-transition
                                     class="absolute right-0 mt-1 w-56 bg-card rounded-lg shadow-xl border border-border z-50 py-1">
                                    @foreach($weeks as $index => $week)
                                        <a href="{{ route('reports.index', array_merge(request()->except('week'), ['week' => $index])) }}"
                                           class="flex items-center gap-2 px-3 py-2 text-xs {{ $selectedWeek == $index ? 'bg-[#5D5FEF]/10 text-[#5D5FEF]' : 'text-foreground hover:bg-muted/20' }} transition-colors">
                                            @if($selectedWeek == $index)
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            @else
                                                <span class="w-3"></span>
                                            @endif
                                            {{ $week['label'] }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if($weeklyTransactionCount > 0)
                        <div id="weeklyChart" class="mt-2"></div>
                    @else
                        <div class="flex flex-col items-center justify-center py-12 text-center">
                            <div class="p-4 rounded-full bg-indigo-100 dark:bg-indigo-900/30 mb-4">
                                <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            <p class="text-sm text-muted">Belum ada data penjualan minggu ini</p>
                        </div>
                    @endif
                </div>

                <!-- Custom Date Range Report Card -->
                <div class="bg-card rounded-xl p-5 sm:p-6 shadow-sm border border-border relative overflow-hidden">
                    <div class="flex flex-col sm:flex-row sm:justify-between items-start mb-4 gap-3">
                        <div>
                            <div class="flex items-center gap-2">
                                <div class="p-1.5 rounded-lg bg-amber-100 dark:bg-amber-900/30">
                                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <h3 class="text-foreground text-sm font-semibold">Rentang Tanggal Custom</h3>
                            </div>
                            <div class="text-2xl sm:text-3xl font-bold text-foreground mt-2">Rp {{ number_format($customTotalSales, 0, ',', '.') }}</div>
                            <div class="flex items-center gap-3 mt-1">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    {{ $customTransactionCount }} transaksi
                                </span>
                            </div>
                        </div>
                        <form id="customDateForm" action="{{ route('reports.index') }}" method="GET" class="w-full sm:w-auto">
                            @if(request('week')) <input type="hidden" name="week" value="{{ request('week') }}"> @endif
                            @if(request('month')) <input type="hidden" name="month" value="{{ request('month') }}"> @endif
                            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                                <div class="relative max-w-sm">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-muted" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                        </svg>
                                    </div>
                                    <input datepicker datepicker-autohide datepicker-format="yyyy-mm-dd" type="text" name="start_date" value="{{ $customStartDate->format('Y-m-d') }}" onchange="this.form.submit()" readonly
                                           class="w-full bg-background border border-border text-foreground text-sm rounded-lg p-2.5 ps-10 block focus:ring-1 focus:ring-[#5D5FEF] focus:border-[#5D5FEF]" placeholder="Pilih tanggal">
                                </div>
                                <span class="text-muted text-center hidden sm:block">—</span>
                                <div class="relative max-w-sm">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-muted" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                        </svg>
                                    </div>
                                    <input datepicker datepicker-autohide datepicker-format="yyyy-mm-dd" type="text" name="end_date" value="{{ $customEndDate->format('Y-m-d') }}" onchange="this.form.submit()" readonly
                                           class="w-full bg-background border border-border text-foreground text-sm rounded-lg p-2.5 ps-10 block focus:ring-1 focus:ring-[#5D5FEF] focus:border-[#5D5FEF]" placeholder="Pilih tanggal">
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Quick Date Presets -->
                    <div class="flex flex-wrap gap-2 mb-4">
                        @php
                            $presets = [
                                ['label' => '7 Hari', 'start' => now()->subDays(6)->format('Y-m-d'), 'end' => now()->format('Y-m-d')],
                                ['label' => '30 Hari', 'start' => now()->subDays(29)->format('Y-m-d'), 'end' => now()->format('Y-m-d')],
                                ['label' => '90 Hari', 'start' => now()->subDays(89)->format('Y-m-d'), 'end' => now()->format('Y-m-d')],
                            ];
                        @endphp
                        @foreach($presets as $preset)
                            <a href="{{ route('reports.index', array_merge(request()->except(['start_date', 'end_date']), ['start_date' => $preset['start'], 'end_date' => $preset['end']])) }}" 
                               class="px-3 py-1 text-xs font-medium rounded-full transition-colors
                                      {{ $customStartDate->format('Y-m-d') == $preset['start'] && $customEndDate->format('Y-m-d') == $preset['end'] 
                                         ? 'bg-amber-500 text-white' 
                                         : 'bg-muted/20 text-muted hover:bg-muted/30' }}">
                                {{ $preset['label'] }}
                            </a>
                        @endforeach
                    </div>
                    
                    @if($customTransactionCount > 0)
                        <div id="customChartWrapper" class="overflow-x-auto no-scrollbar cursor-grab active:cursor-grabbing">
                            <div id="customChart"></div>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-12 text-center">
                            <div class="p-4 rounded-full bg-amber-100 dark:bg-amber-900/30 mb-4">
                                <svg class="w-8 h-8 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            <p class="text-sm text-muted">Tidak ada data untuk rentang tanggal ini</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Monthly Report & Top Products Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Monthly Report Card (Span 2 cols) -->
                <div class="lg:col-span-2 bg-card rounded-xl p-5 sm:p-6 shadow-sm border border-border relative overflow-hidden">
                    <div class="flex flex-col sm:flex-row justify-between items-start mb-4 gap-3">
                        <div>
                            <div class="flex items-center gap-2">
                                <div class="p-1.5 rounded-lg bg-emerald-100 dark:bg-emerald-900/30">
                                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                </div>
                                <h3 class="text-foreground text-sm font-semibold">Penjualan Bulanan</h3>
                            </div>
                            <div class="text-2xl sm:text-3xl font-bold text-foreground mt-2">Rp {{ number_format($totalMonthlySales, 0, ',', '.') }}</div>
                            <div class="flex items-center gap-3 mt-1">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    {{ $monthlyTransactionCount }} transaksi
                                </span>
                                <span class="text-muted text-xs">{{ $startDateMonthly->format('d M') }} - {{ $endDateMonthly->format('d M Y') }}</span>
                            </div>
                        </div>
                        <form action="{{ route('reports.index') }}" method="GET" class="w-full sm:w-auto">
                            @if(request('week'))
                                <input type="hidden" name="week" value="{{ request('week') }}">
                            @endif
                            <select name="month" onchange="this.form.submit()" class="w-full sm:w-32 bg-background text-foreground text-xs font-medium px-3 py-2 rounded-lg border border-border focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                                @foreach($months as $index => $monthName)
                                    <option value="{{ $index }}" {{ $selectedMonth == $index ? 'selected' : '' }}>
                                        {{ $monthName }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>

                    @if($monthlyTransactionCount > 0)
                        <div id="monthlyChartContainer" class="overflow-x-auto pb-2 no-scrollbar cursor-grab active:cursor-grabbing">
                            <div id="monthlyChart" class="min-w-[2500px]"></div>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-12 text-center">
                            <div class="p-4 rounded-full bg-emerald-100 dark:bg-emerald-900/30 mb-4">
                                <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            <p class="text-sm text-muted">Belum ada data penjualan bulan ini</p>
                        </div>
                    @endif
                </div>

                <!-- Top Products Card -->
                <div class="bg-card rounded-xl p-5 sm:p-6 shadow-sm border border-border">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="p-1.5 rounded-lg bg-purple-100 dark:bg-purple-900/30">
                            <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                        </div>
                        <h3 class="text-foreground text-sm font-semibold">Top 7 Produk Terlaris</h3>
                    </div>

                    @if($topProducts->count() > 0)
                        @php
                            $maxQty = $topProducts->max('total_qty');
                        @endphp
                        <div class="space-y-3">
                            @foreach($topProducts as $index => $item)
                                <div class="group">
                                    <div class="flex items-center justify-between mb-1">
                                        <div class="flex items-center gap-3 min-w-0">
                                            <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shrink-0 bg-muted/30 text-muted">
                                                {{ $index + 1 }}
                                            </div>
                                            <div class="min-w-0">
                                                <div class="text-foreground text-sm font-medium truncate">{{ $item->product->name ?? 'Produk Terhapus' }}</div>
                                            </div>
                                        </div>
                                        <div class="text-right shrink-0 ml-2">
                                            <div class="text-foreground text-sm font-bold">{{ $item->total_qty }}</div>
                                            <div class="text-muted text-xs">terjual</div>
                                        </div>
                                    </div>
                                    <!-- Progress Bar -->
                                    <div class="ml-9 h-1.5 bg-muted/20 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full transition-all duration-500 bg-gradient-to-r from-purple-400 to-purple-500"
                                             style="width: {{ ($item->total_qty / $maxQty) * 100 }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-8 text-center">
                            <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900/30 mb-3">
                                <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <p class="text-sm text-muted">Belum ada data produk</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ApexCharts CDN -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Check if there's data
        const hasWeeklyData = {{ $weeklyTransactionCount > 0 ? 'true' : 'false' }};
        const hasMonthlyData = {{ $monthlyTransactionCount > 0 ? 'true' : 'false' }};
        const hasCustomData = {{ $customTransactionCount > 0 ? 'true' : 'false' }};

        // Common Chart Options
        const commonOptions = {
            chart: {
                background: 'transparent',
                toolbar: { show: false },
                zoom: { enabled: false },
                animations: { enabled: true, easing: 'easeinout', speed: 800 }
            },
            theme: { mode: document.documentElement.classList.contains('dark') ? 'dark' : 'light' },
            stroke: { curve: 'smooth', width: 2.5 },
            dataLabels: { enabled: false },
            grid: {
                borderColor: 'rgba(128, 128, 128, 0.1)',
                strokeDashArray: 4,
                xaxis: { lines: { show: false } }
            },
            xaxis: {
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: { style: { colors: 'rgba(128, 128, 128, 0.8)', fontSize: '11px' } }
            },
            yaxis: {
                labels: {
                    style: { colors: 'rgba(128, 128, 128, 0.8)', fontSize: '11px' },
                    formatter: (value) => {
                        if (value >= 1000000) return 'Rp ' + (value / 1000000).toFixed(1) + 'jt';
                        if (value >= 1000) return 'Rp ' + (value / 1000).toFixed(0) + 'rb';
                        return 'Rp ' + value;
                    }
                }
            },
            tooltip: {
                theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light',
                y: { formatter: (value) => 'Rp ' + new Intl.NumberFormat('id-ID').format(value) }
            }
        };

        let weeklyChart, monthlyChart, customChart;

        // Theme observer
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.attributeName === 'class') {
                    const isDark = document.documentElement.classList.contains('dark');
                    [weeklyChart, monthlyChart, customChart].forEach(chart => {
                        if (chart) {
                            chart.updateOptions({ 
                                theme: { mode: isDark ? 'dark' : 'light' },
                                tooltip: { theme: isDark ? 'dark' : 'light' }
                            });
                        }
                    });
                }
            });
        });
        observer.observe(document.documentElement, { attributes: true });

        // Weekly Chart
        if (hasWeeklyData) {
            weeklyChart = new ApexCharts(document.querySelector("#weeklyChart"), {
                ...commonOptions,
                series: [{ name: 'Penjualan', data: @json($weeklySales) }],
                chart: { ...commonOptions.chart, type: 'area', height: 280 },
                xaxis: { ...commonOptions.xaxis, categories: @json($weeklyLabels) },
                colors: ['#5D5FEF'],
                fill: {
                    type: 'gradient',
                    gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05, stops: [0, 90, 100] }
                }
            });
            weeklyChart.render();
        }

        // Monthly Chart
        if (hasMonthlyData) {
            monthlyChart = new ApexCharts(document.querySelector("#monthlyChart"), {
                ...commonOptions,
                series: [{ name: 'Penjualan', data: @json($monthlySales) }],
                chart: { ...commonOptions.chart, type: 'area', height: 320 },
                xaxis: { ...commonOptions.xaxis, categories: @json($monthlyLabels) },
                colors: ['#5D5FEF'],
                fill: {
                    type: 'gradient',
                    gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05, stops: [0, 90, 100] }
                }
            });
            monthlyChart.render();

            // Drag to scroll for monthly chart
            const slider = document.querySelector('#monthlyChartContainer');
            let isDown = false, startX, scrollLeft;
            slider.addEventListener('mousedown', (e) => { isDown = true; startX = e.pageX - slider.offsetLeft; scrollLeft = slider.scrollLeft; });
            slider.addEventListener('mouseleave', () => { isDown = false; });
            slider.addEventListener('mouseup', () => { isDown = false; });
            slider.addEventListener('mousemove', (e) => { if (!isDown) return; e.preventDefault(); slider.scrollLeft = scrollLeft - (e.pageX - slider.offsetLeft - startX) * 2; });
            slider.addEventListener('wheel', (e) => { if (e.deltaY !== 0) { e.preventDefault(); slider.scrollLeft += e.deltaY; } });
        }

        // Custom Chart
        if (hasCustomData) {
            const customDataLength = @json(count($customLabels));
            const customChartWidth = Math.max(600, customDataLength * 60);

            customChart = new ApexCharts(document.querySelector("#customChart"), {
                ...commonOptions,
                series: [{ name: 'Penjualan', data: @json($customSales) }],
                chart: { ...commonOptions.chart, type: 'area', height: 250, width: customChartWidth },
                xaxis: { ...commonOptions.xaxis, categories: @json($customLabels) },
                colors: ['#5D5FEF'],
                fill: {
                    type: 'gradient',
                    gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05, stops: [0, 90, 100] }
                }
            });
            customChart.render();

            // Drag to scroll for custom chart
            const wrapper = document.querySelector('#customChartWrapper');
            let isDownC = false, startXC, scrollLeftC;
            wrapper.addEventListener('mousedown', (e) => { isDownC = true; wrapper.style.cursor = 'grabbing'; startXC = e.pageX - wrapper.offsetLeft; scrollLeftC = wrapper.scrollLeft; });
            wrapper.addEventListener('mouseleave', () => { isDownC = false; wrapper.style.cursor = 'grab'; });
            wrapper.addEventListener('mouseup', () => { isDownC = false; wrapper.style.cursor = 'grab'; });
            wrapper.addEventListener('mousemove', (e) => { if (!isDownC) return; e.preventDefault(); wrapper.scrollLeft = scrollLeftC - (e.pageX - wrapper.offsetLeft - startXC) * 2; });
            wrapper.addEventListener('wheel', (e) => { if (e.deltaY !== 0) { e.preventDefault(); wrapper.scrollLeft += e.deltaY; } });
        }
    });
</script>


</x-app-layout>
