<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Detail Arsip</h1>
            </div>
            <div class="flex gap-2">
                <form action="{{ route('archive.restore', $archivedTransaction) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" onclick="return confirm('Pulihkan transaksi ini ke data aktif?')"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Pulihkan
                    </button>
                </form>
                <a href="{{ route('archive.index') }}" class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-900 dark:text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out text-sm flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Items (2/3 width) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Archive Badge -->
                <div class="bg-purple-100 dark:bg-purple-900/30 px-4 py-3 rounded-xl border border-purple-200 dark:border-purple-800">
                    <div class="flex items-center gap-2 text-purple-700 dark:text-purple-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                        </svg>
                        <span class="font-medium">Diarsipkan pada {{ $archivedTransaction->archived_at->format('d M Y, H:i') }}</span>
                    </div>
                </div>

                <div class="bg-card overflow-hidden shadow-sm rounded-xl border border-border">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-foreground mb-4">Item Transaksi</h3>
                        <!-- Desktop Table View -->
                        <div class="hidden sm:block overflow-x-auto">
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="text-muted text-xs uppercase tracking-wider border-b border-border">
                                        <th class="px-6 py-3 font-medium">Produk</th>
                                        <th class="px-6 py-3 font-medium text-right">Harga</th>
                                        <th class="px-6 py-3 font-medium text-center">Qty</th>
                                        <th class="px-6 py-3 font-medium text-right">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-border">
                                    @foreach($archivedTransaction->items as $item)
                                        <tr class="text-sm hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                            <td class="px-6 py-4 text-foreground font-medium">
                                                {{ $item->note ?? $item->product_name_display }}
                                            </td>
                                            <td class="px-6 py-4 text-muted text-right">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                            <td class="px-6 py-4 text-foreground text-center">{{ $item->quantity }}</td>
                                            <td class="px-6 py-4 text-foreground font-bold text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Card View -->
                        <div class="sm:hidden space-y-4">
                            @foreach($archivedTransaction->items as $item)
                                <div class="bg-background rounded-lg p-4 border border-border">
                                    <div class="flex justify-between items-start mb-2">
                                        <div class="pr-4">
                                            <h4 class="text-sm font-bold text-foreground line-clamp-2">{{ $item->note ?? $item->product_name_display }}</h4>
                                            <p class="text-xs text-muted mt-1">
                                                @ Rp {{ number_format($item->unit_price, 0, ',', '.') }}
                                            </p>
                                        </div>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300">
                                            x{{ $item->quantity }}
                                        </span>
                                    </div>
                                    <div class="flex justify-end items-center pt-2 border-t border-border mt-2">
                                        <span class="text-xs text-muted mr-2">Subtotal:</span>
                                        <span class="text-sm font-bold text-[#5D5FEF]">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Summary (1/3 width) -->
            <div class="lg:col-span-1">
                <div class="bg-card overflow-hidden shadow-sm rounded-xl border border-border sticky top-6">
                    <div class="p-6">
                        <!-- Header with LUNAS Badge -->
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Ringkasan</h3>
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                LUNAS
                            </span>
                        </div>
                        
                        <!-- Transaction Info -->
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between border-b border-gray-200 dark:border-gray-800 pb-2">
                                <span class="text-gray-500 dark:text-gray-400">Invoice</span>
                                <span class="text-[#5D5FEF] font-mono font-medium text-sm">{{ $archivedTransaction->invoice_number }}</span>
                            </div>
                            <div class="flex justify-between border-b border-gray-200 dark:border-gray-800 pb-2">
                                <span class="text-gray-500 dark:text-gray-400">Tanggal</span>
                                <span class="text-gray-900 dark:text-white text-sm">{{ $archivedTransaction->transaction_date->format('d M Y H:i') }}</span>
                            </div>
                            <div class="flex justify-between border-b border-gray-200 dark:border-gray-800 pb-2">
                                <span class="text-gray-500 dark:text-gray-400">Kasir</span>
                                <span class="text-gray-900 dark:text-white text-sm">{{ $archivedTransaction->cashier_name }}</span>
                            </div>
                            <div class="flex justify-between border-b border-gray-200 dark:border-gray-800 pb-2">
                                <span class="text-gray-500 dark:text-gray-400">Metode</span>
                                @php
                                    $method = strtolower($archivedTransaction->payment_method_name_display ?? '');
                                    $methodColors = [
                                        'cash' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',
                                        'tunai' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',
                                        'qris' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                        'transfer' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
                                        'transfer mandiri' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
                                        'transfer bca' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
                                        'bank' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
                                        'debit' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
                                        'kredit' => 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400',
                                        'credit' => 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400',
                                    ];
                                    $colorClass = $methodColors[$method] ?? 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300';
                                @endphp
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold uppercase {{ $colorClass }}">
                                    {{ $archivedTransaction->payment_method_name_display ?? '-' }}
                                </span>
                            </div>
                            <div class="flex justify-between text-sm text-muted">
                                <span>Total Item</span>
                                <span>{{ $archivedTransaction->items->sum('quantity') }} item</span>
                            </div>
                        </div>

                        <!-- Total Amount -->
                        <div class="bg-gradient-to-r from-[#5D5FEF]/10 to-[#5D5FEF]/5 rounded-lg p-4 mb-6 text-center border border-[#5D5FEF]/20">
                            <div class="text-gray-500 dark:text-gray-400 text-sm mb-1">Total Pembayaran</div>
                            <div class="text-3xl font-bold text-[#5D5FEF]">Rp {{ number_format($archivedTransaction->final_amount, 0, ',', '.') }}</div>
                        </div>

                        <!-- Additional Info -->
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between text-muted">
                                <span>Tunai</span>
                                <span>Rp {{ number_format($archivedTransaction->cash_received, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
