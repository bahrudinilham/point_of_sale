<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan - {{ $periodText }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .no-print { display: none; }
        }
        @page { margin: 1cm; }
    </style>
</head>
<body class="bg-white text-gray-900 p-8" onload="window.print()">
    
    <!-- Header -->
    <div class="flex justify-between items-start mb-6 border-b-2 border-gray-900 pb-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Laporan Penjualan</h1>
            <p class="text-sm text-gray-600 mt-1">Periode: <span class="font-semibold">{{ $periodText }}</span></p>
        </div>
        <div class="text-right">
            <div class="text-xl font-bold text-gray-900">MukitCell</div>
            <div class="text-xs text-gray-500 mt-1">Dicetak: {{ now()->format('d M Y, H:i') }}</div>
        </div>
    </div>

    <!-- Summary Stats - Plain Design -->
    <div class="grid grid-cols-3 gap-4 mb-8">
        <div class="p-4 border border-gray-300 rounded-lg">
            <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Penjualan</div>
            <div class="text-xl font-bold text-gray-900 mt-1">Rp {{ number_format($totalSales, 0, ',', '.') }}</div>
        </div>
        <div class="p-4 border border-gray-300 rounded-lg">
            <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Transaksi</div>
            <div class="text-xl font-bold text-gray-900 mt-1">{{ $transactionCount }}</div>
        </div>
        <div class="p-4 border border-gray-300 rounded-lg">
            <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Rata-rata/Hari</div>
            <div class="text-xl font-bold text-gray-900 mt-1">Rp {{ count($sales) > 0 ? number_format($totalSales / count($sales), 0, ',', '.') : 0 }}</div>
        </div>
    </div>

    <!-- Daily Breakdown -->
    <div class="mb-8">
        <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Rincian Harian</h3>
        
        <div class="grid grid-cols-3 gap-x-8 gap-y-1">
            @foreach($labels as $index => $label)
            <div class="flex items-center justify-between py-1.5 border-b border-gray-100">
                <span class="text-sm text-gray-700">{{ $label }}</span>
                <span class="text-sm font-semibold text-gray-900">
                    Rp {{ number_format($sales[$index], 0, ',', '.') }}
                </span>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Footer -->
    <div class="border-t pt-4 mt-8 text-center text-xs text-gray-400">
        Dokumen ini digenerate otomatis oleh sistem MukitCell &bull; {{ now()->format('d M Y H:i:s') }}
    </div>

</body>
</html>
