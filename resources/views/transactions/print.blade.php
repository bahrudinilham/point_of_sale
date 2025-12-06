<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt {{ $transaction->invoice_number }}</title>
    <style>
        /* Page size for thermal printer */
        @page {
            size: 80mm auto;
            margin: 0;
        }
        
        :root {
            --receipt-width: 80mm;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            font-size: 12px;
            max-width: var(--receipt-width);
            margin: 0 auto;
            padding: 15px;
            color: #000;
            line-height: 1.4;
            background: #fff;
        }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }
        .line { border-bottom: 1px dashed #000; margin: 10px 0; }
        .flex { display: flex; justify-content: space-between; }
        
        .header {
            text-align: center;
            margin-bottom: 10px;
        }
        
        .logo {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            border: 2px solid #000;
            display: inline-block;
            padding: 5px 12px;
            margin-bottom: 8px;
            letter-spacing: 1px;
        }
        
        .store-info {
            font-size: 10px;
            line-height: 1.3;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            margin-bottom: 2px;
        }
        
        .info-label {
            color: #555;
        }
        
        .info-value {
            font-weight: 500;
        }
        
        .payment-badge {
            display: inline-block;
            padding: 2px 6px;
            border: 1px solid #000;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .item {
            margin-bottom: 6px;
        }
        
        .item-name {
            font-weight: bold;
            font-size: 11px;
        }
        
        .item-detail {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            color: #333;
        }
        
        .total-section {
            margin-top: 10px;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            font-weight: bold;
        }
        
        .paid-badge {
            display: inline-block;
            border: 2px solid #000;
            padding: 3px 8px;
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 1px;
            margin-top: 8px;
        }
        
        .footer {
            text-align: center;
            margin-top: 10px;
        }
        
        .thank-you {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 4px;
        }
        
        .come-again {
            font-size: 10px;
            color: #555;
        }

        /* Print Controls - Hidden when printing */
        .print-controls {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
            background: #1a1a2e;
            padding: 12px 16px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            z-index: 100;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-family: system-ui, -apple-system, sans-serif;
            font-size: 13px;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .btn-primary {
            background: #5D5FEF;
            color: #fff;
        }
        
        .btn-primary:hover {
            background: #4b4ddb;
        }
        
        .btn-secondary {
            background: #374151;
            color: #fff;
        }
        
        .btn-secondary:hover {
            background: #4b5563;
        }
        
        .size-toggle {
            display: flex;
            background: #374151;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .size-btn {
            padding: 8px 12px;
            font-size: 11px;
            font-weight: 500;
            color: #9ca3af;
            background: transparent;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .size-btn.active {
            background: #5D5FEF;
            color: #fff;
        }
        
        .size-btn:hover:not(.active) {
            color: #fff;
        }

        /* 58mm thermal printer width */
        body.width-58mm {
            --receipt-width: 58mm;
        }
        
        body.width-58mm .logo {
            font-size: 14px;
            padding: 4px 8px;
        }
        
        body.width-58mm .store-info {
            font-size: 9px;
        }
        
        body.width-58mm .info-row,
        body.width-58mm .item-detail {
            font-size: 10px;
        }
        
        body.width-58mm .item-name {
            font-size: 10px;
        }
        
        body.width-58mm .total-row {
            font-size: 12px;
        }

        @media print {
            html, body { 
                width: var(--receipt-width) !important;
                max-width: var(--receipt-width) !important;
                margin: 0 auto !important; 
                padding: 0 !important;
                font-size: 11px !important;
            }
            .print-controls { 
                display: none !important; 
            }
        }
        
        /* Hide controls when in iframe (preview modal) */
        .in-iframe .print-controls {
            display: none !important;
        }
    </style>
</head>
<body class="width-80mm">
    <div class="header">
        <div class="logo">{{ config('app.name') }}</div>
        <div class="store-info">
            <p>Jl. Contoh No. 123, Jakarta</p>
            <p>Telp: 0812-3456-7890</p>
        </div>
    </div>

    <div class="line"></div>

    <div>
        <div class="info-row">
            <span class="info-label">Invoice:</span>
            <span class="info-value bold">{{ $transaction->invoice_number }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Tanggal:</span>
            <span class="info-value">{{ $transaction->transaction_date->format('d/m/Y H:i') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Kasir:</span>
            <span class="info-value">{{ $transaction->user->name }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Metode:</span>
            <span class="payment-badge">{{ $transaction->paymentMethod->name ?? '-' }}</span>
        </div>
    </div>

    <div class="line"></div>

    @foreach($transaction->items as $item)
        <div class="item">
            <div class="item-name">{{ $item->product->name }}</div>
            <div class="item-detail">
                <span>{{ $item->quantity }} x {{ number_format($item->unit_price, 0, ',', '.') }}</span>
                <span>{{ number_format($item->subtotal, 0, ',', '.') }}</span>
            </div>
        </div>
    @endforeach

    <div class="line"></div>

    <div class="total-section">
        <div class="total-row">
            <span>TOTAL</span>
            <span>Rp {{ number_format($transaction->final_amount, 0, ',', '.') }}</span>
        </div>
        <div class="text-center">
            <span class="paid-badge">✓ LUNAS</span>
        </div>
    </div>

    <div class="line"></div>

    <div class="footer">
        <p class="thank-you">Terima kasih!</p>
        <p class="come-again">Silakan datang kembali</p>
    </div>

    <!-- Print Controls -->
    <div class="print-controls">
        <div class="size-toggle">
            <button class="size-btn" onclick="setWidth('58mm')" id="btn58">58mm</button>
            <button class="size-btn active" onclick="setWidth('80mm')" id="btn80">80mm</button>
        </div>
        <button onclick="window.print()" class="btn btn-primary">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Cetak
        </button>
        <a href="{{ route('pos.index') }}" class="btn btn-secondary">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    <script>
        function setWidth(size) {
            const body = document.body;
            body.classList.remove('width-58mm', 'width-80mm');
            body.classList.add('width-' + size);
            
            document.getElementById('btn58').classList.remove('active');
            document.getElementById('btn80').classList.remove('active');
            document.getElementById('btn' + size.replace('mm', '')).classList.add('active');
            
            // Update @page size dynamically
            let pageStyle = document.getElementById('pageStyle');
            if (!pageStyle) {
                pageStyle = document.createElement('style');
                pageStyle.id = 'pageStyle';
                document.head.appendChild(pageStyle);
            }
            pageStyle.textContent = '@page { size: ' + size + ' auto; margin: 0; }';
        }
        
        // Detect if in iframe and hide controls
        if (window.self !== window.top) {
            document.body.classList.add('in-iframe');
        }
    </script>
</body>
</html>
