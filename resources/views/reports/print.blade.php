<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan - {{ $periodText }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { -webkit-print-color-adjust: exact; }
            .no-print { display: none; }
        }
    </style>
</head>
<body class="bg-white text-gray-900 p-8" onload="window.print()">
    
    <!-- Header -->
    <div class="flex justify-between items-center mb-8 border-b pb-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Laporan Penjualan</h1>
            <p class="text-sm text-gray-500">Periode: {{ $periodText }}</p>
        </div>
        <div class="text-right">
            <div class="text-sm font-bold text-gray-900">{{ config('app.name', 'Kasir App') }}</div>
            <div class="text-xs text-gray-500">Dicetak pada: {{ now()->format('d M Y H:i') }}</div>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="grid grid-cols-2 gap-8 mb-8">
        <div class="bg-gray-50 p-4 rounded-lg border">
            <div class="text-xs font-bold text-gray-500 uppercase">Total Penjualan</div>
            <div class="text-2xl font-bold text-gray-900 mt-1">Rp {{ number_format($totalSales, 0, ',', '.') }}</div>
        </div>
        <div class="bg-gray-50 p-4 rounded-lg border">
            <div class="text-xs font-bold text-gray-500 uppercase">Total Transaksi</div>
            <div class="text-2xl font-bold text-gray-900 mt-1">{{ $transactionCount }}</div>
        </div>
    </div>

    <!-- Top Products -->
    <div class="mb-8">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Top 7 Produk Terlaris</h3>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="py-2 text-xs font-bold text-gray-500 uppercase">No</th>
                    <th class="py-2 text-xs font-bold text-gray-500 uppercase">Produk</th>
                    <th class="py-2 text-xs font-bold text-gray-500 uppercase text-right">Terjual</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topProducts as $index => $item)
                <tr class="border-b border-gray-100">
                    <td class="py-2 text-sm text-gray-900">{{ $index + 1 }}</td>
                    <td class="py-2 text-sm text-gray-900">{{ $item->product->name }}</td>
                    <td class="py-2 text-sm text-gray-900 text-right">{{ $item->total_qty }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Daily Breakdown -->
    <div>
        <h3 class="text-lg font-bold text-gray-900 mb-4">Rincian Harian</h3>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="py-2 text-xs font-bold text-gray-500 uppercase">Tanggal</th>
                    <th class="py-2 text-xs font-bold text-gray-500 uppercase text-right">Penjualan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($labels as $index => $label)
                <tr class="border-b border-gray-100">
                    <td class="py-2 text-sm text-gray-900">{{ $label }}</td>
                    <td class="py-2 text-sm text-gray-900 text-right">Rp {{ number_format($sales[$index], 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>
