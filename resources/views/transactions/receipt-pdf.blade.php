<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Struk {{ $transaction->invoice_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            padding: 20px;
            color: #000;
            line-height: 1.5;
        }
        .receipt {
            max-width: 300px;
            margin: 0 auto;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }
        .line { 
            border-bottom: 1px dashed #333; 
            margin: 12px 0; 
        }
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
            padding: 6px 14px;
            margin-bottom: 8px;
            letter-spacing: 1px;
        }
        .store-info {
            font-size: 10px;
            color: #333;
        }
        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 4px;
        }
        .info-label {
            display: table-cell;
            width: 80px;
            color: #555;
        }
        .info-value {
            display: table-cell;
            text-align: right;
        }
        .payment-badge {
            display: inline-block;
            padding: 2px 8px;
            border: 1px solid #000;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .items {
            margin: 10px 0;
        }
        .item {
            margin-bottom: 8px;
        }
        .item-name {
            font-weight: bold;
            margin-bottom: 2px;
        }
        .item-detail {
            display: table;
            width: 100%;
        }
        .item-qty {
            display: table-cell;
            color: #555;
        }
        .item-subtotal {
            display: table-cell;
            text-align: right;
        }
        .total-section {
            margin: 10px 0;
        }
        .total-row {
            display: table;
            width: 100%;
            font-size: 14px;
            font-weight: bold;
        }
        .total-label {
            display: table-cell;
        }
        .total-value {
            display: table-cell;
            text-align: right;
        }
        .paid-badge {
            display: inline-block;
            border: 2px solid #000;
            padding: 4px 12px;
            font-size: 12px;
            font-weight: bold;
            margin-top: 8px;
        }
        .footer {
            text-align: center;
            margin-top: 15px;
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
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <div class="logo">{{ config('app.name') }}</div>
            <div class="store-info">
                <p>Jl. Contoh No. 123, Jakarta</p>
                <p>Telp: 0812-3456-7890</p>
            </div>
        </div>

        <div class="line"></div>

        <div class="info-section">
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
                <span class="info-value"><span class="payment-badge">{{ $transaction->paymentMethod->name ?? '-' }}</span></span>
            </div>
        </div>

        <div class="line"></div>

        <div class="items">
            @foreach($transaction->items as $item)
                <div class="item">
                    <div class="item-name">{{ $item->product->name }}</div>
                    <div class="item-detail">
                        <span class="item-qty">{{ $item->quantity }} x {{ number_format($item->unit_price, 0, ',', '.') }}</span>
                        <span class="item-subtotal">{{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="line"></div>

        <div class="total-section">
            <div class="total-row">
                <span class="total-label">TOTAL</span>
                <span class="total-value">Rp {{ number_format($transaction->final_amount, 0, ',', '.') }}</span>
            </div>
        </div>
        
        <div class="text-center">
            <span class="paid-badge">✓ LUNAS</span>
        </div>

        <div class="line"></div>

        <div class="footer">
            <p class="thank-you">Terima kasih!</p>
            <p class="come-again">Silakan datang kembali</p>
        </div>
    </div>
</body>
</html>
