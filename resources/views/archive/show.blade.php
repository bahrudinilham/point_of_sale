<x-app-layout>
    <!-- Header Section -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-foreground">Detail Arsip</h1>
                <p class="text-muted mt-1">{{ $archivedTransaction->invoice_number }}</p>
            </div>
            <div class="flex gap-2">
                <form action="{{ route('archive.restore', $archivedTransaction) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" onclick="return confirm('Pulihkan transaksi ini ke data aktif?')"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Pulihkan
                    </button>
                </form>
                <a href="{{ route('archive.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-muted/20 text-muted hover:text-foreground hover:bg-muted/30 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Transaction Details -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        <div class="bg-card rounded-xl border border-border overflow-hidden">
            <!-- Archive Badge -->
            <div class="bg-purple-100 dark:bg-purple-900/30 px-6 py-3 border-b border-border">
                <div class="flex items-center gap-2 text-purple-700 dark:text-purple-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                    </svg>
                    <span class="font-medium">Diarsipkan pada {{ $archivedTransaction->archived_at->format('d M Y, H:i') }}</span>
                </div>
            </div>

            <!-- Transaction Info -->
            <div class="p-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div>
                        <p class="text-xs text-muted uppercase tracking-wider">Invoice</p>
                        <p class="text-foreground font-bold">{{ $archivedTransaction->invoice_number }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-muted uppercase tracking-wider">Tanggal Transaksi</p>
                        <p class="text-foreground font-medium">{{ $archivedTransaction->transaction_date->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-muted uppercase tracking-wider">Kasir</p>
                        <p class="text-foreground font-medium">{{ $archivedTransaction->cashier_name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-muted uppercase tracking-wider">Metode Pembayaran</p>
                        <p class="text-foreground font-medium">{{ $archivedTransaction->payment_method_name_display }}</p>
                    </div>
                </div>

                <!-- Items Table -->
                <div class="border border-border rounded-lg overflow-hidden">
                    <table class="w-full">
                        <thead class="bg-muted/30">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-muted uppercase">Produk</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-muted uppercase">Qty</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-muted uppercase">Harga</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-muted uppercase">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @foreach($archivedTransaction->items as $item)
                            <tr>
                                <td class="px-4 py-3">
                                    <span class="text-foreground font-medium">{{ $item->product_name_display }}</span>
                                    @if($item->note)
                                        <p class="text-xs text-muted mt-1">{{ $item->note }}</p>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center text-muted">{{ $item->quantity }}</td>
                                <td class="px-4 py-3 text-right text-muted">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-right text-foreground font-medium">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Totals -->
                <div class="mt-6 flex justify-end">
                    <div class="w-full max-w-xs space-y-2">
                        <div class="flex justify-between text-muted">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($archivedTransaction->total_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold text-foreground border-t border-border pt-2">
                            <span>Total</span>
                            <span>Rp {{ number_format($archivedTransaction->final_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-muted text-sm">
                            <span>Tunai</span>
                            <span>Rp {{ number_format($archivedTransaction->cash_received, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-muted text-sm">
                            <span>Kembalian</span>
                            <span>Rp {{ number_format($archivedTransaction->change_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
