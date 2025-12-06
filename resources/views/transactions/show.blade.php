<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ showPrintPreview: false }">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Detail Transaksi</h1>
            </div>
            <a href="{{ route('transactions.index') }}" class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-900 dark:text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out text-sm flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Items (2/3 width) -->
            <div class="lg:col-span-2 space-y-6">
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
                                    @foreach($transaction->items as $item)
                                        <tr class="text-sm hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                            <td class="px-6 py-4 text-foreground font-medium">{{ $item->note ?? $item->product->name }}</td>
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
                            @foreach($transaction->items as $item)
                                <div class="bg-background rounded-lg p-4 border border-border">
                                    <div class="flex justify-between items-start mb-2">
                                        <div class="pr-4">
                                            <h4 class="text-sm font-bold text-foreground line-clamp-2">{{ $item->note ?? $item->product->name }}</h4>
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
                                <span class="text-[#5D5FEF] font-mono font-medium text-sm">{{ $transaction->invoice_number }}</span>
                            </div>
                            <div class="flex justify-between border-b border-gray-200 dark:border-gray-800 pb-2">
                                <span class="text-gray-500 dark:text-gray-400">Tanggal</span>
                                <span class="text-gray-900 dark:text-white text-sm">{{ $transaction->transaction_date->format('d M Y H:i') }}</span>
                            </div>
                            <div class="flex justify-between border-b border-gray-200 dark:border-gray-800 pb-2">
                                <span class="text-gray-500 dark:text-gray-400">Kasir</span>
                                <span class="text-gray-900 dark:text-white text-sm">{{ $transaction->user->name }}</span>
                            </div>
                            <div class="flex justify-between border-b border-gray-200 dark:border-gray-800 pb-2">
                                <span class="text-gray-500 dark:text-gray-400">Metode</span>
                                @php
                                    $method = strtolower($transaction->paymentMethod->name ?? '');
                                    $methodColors = [
                                        'cash' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',
                                        'tunai' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',
                                        'qris' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                        'transfer' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
                                        'bank' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
                                        'debit' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
                                        'kredit' => 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400',
                                        'credit' => 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400',
                                    ];
                                    $colorClass = $methodColors[$method] ?? 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300';
                                @endphp
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold uppercase {{ $colorClass }}">
                                    {{ $transaction->paymentMethod->name ?? '-' }}
                                </span>
                            </div>
                            <div class="flex justify-between text-sm text-muted">
                                <span>Total Item</span>
                                <span>{{ $transaction->items->sum('quantity') }} item</span>
                            </div>
                        </div>

                        <!-- Total Amount -->
                        <div class="bg-gradient-to-r from-[#5D5FEF]/10 to-[#5D5FEF]/5 rounded-lg p-4 mb-6 text-center border border-[#5D5FEF]/20">
                            <div class="text-gray-500 dark:text-gray-400 text-sm mb-1">Total Pembayaran</div>
                            <div class="text-3xl font-bold text-[#5D5FEF]">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</div>
                        </div>

                        <!-- Primary Actions -->
                        <div class="space-y-3 mb-4">
                            <!-- Print Preview Button -->
                            <button @click="showPrintPreview = true" class="w-full bg-[#5D5FEF] hover:bg-[#4b4ddb] text-white font-medium py-3 px-4 rounded-lg shadow-lg shadow-indigo-500/30 transition duration-150 ease-in-out flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                Cetak Struk
                            </button>

                            <!-- Download PDF -->
                            <a href="{{ route('transactions.download-pdf', $transaction) }}" class="w-full bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 font-medium py-3 px-4 rounded-lg transition duration-150 ease-in-out flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Unduh PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Print Preview Modal -->
        <div x-show="showPrintPreview" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">
                <!-- Background overlay -->
                <div x-show="showPrintPreview" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/60 transition-opacity" @click="showPrintPreview = false"></div>

                <!-- Modal panel -->
                <div x-show="showPrintPreview" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative bg-white dark:bg-gray-900 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full">
                    
                    <!-- Header -->
                    <div class="bg-gray-50 dark:bg-gray-800 px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Preview Struk</h3>
                        <button @click="showPrintPreview = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <!-- Preview Content -->
                    <div class="p-6 max-h-[60vh] overflow-y-auto bg-white">
                        <iframe src="{{ route('transactions.print', $transaction) }}" class="w-full h-[400px] border border-gray-200 rounded-lg" frameborder="0"></iframe>
                    </div>

                    <!-- Footer Actions -->
                    <div class="bg-gray-50 dark:bg-gray-800 px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex gap-3">
                        <button @click="showPrintPreview = false" class="flex-1 px-4 py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg font-medium hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                            Batal
                        </button>
                        <a href="{{ route('transactions.print', $transaction) }}" target="_blank" class="flex-1 px-4 py-2.5 bg-[#5D5FEF] text-white rounded-lg font-medium hover:bg-[#4b4ddb] transition-colors flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                            Cetak
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
