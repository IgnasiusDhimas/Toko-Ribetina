<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $transaksi->kode_transaksi }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 14px;
            margin: 15px;
            color: #222;
        }
        h2 {
            text-align: center;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }
        .info {
            margin-bottom: 15px;
            line-height: 1.6;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 14px;
        }
        th {
            background: #f2f2f2;
            border-bottom: 2px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        .right {
            text-align: right;
        }
        .total {
            font-size: 18px;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 25px;
            font-size: 12px;
            opacity: 0.7;
        }
    </style>
</head>
<body>

<h2>INVOICE TRANSAKSI</h2>
<hr>

<div class="info">
    <b>Kode Transaksi:</b> {{ $transaksi->kode_transaksi }} <br>
    <b>Tanggal:</b> {{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d M Y H:i') }}
</div>

<table>
    <thead>
        <tr>
            <th>Barang</th>
            <th class="right">Qty</th>
            <th class="right">Harga Satuan</th>
            <th class="right">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transaksi->items as $item)
        <tr>
            <td>{{ $item->barang->nama }}</td>
            <td class="right">{{ $item->qty }}</td>
            <td class="right">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
            <td class="right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<h3 class="right total">
    Total: Rp {{ number_format($transaksi->total, 0, ',', '.') }}
</h3>

<div class="footer">
    Terima kasih telah berbelanja!<br>
    <i>Semoga hari Anda menyenangkan</i>
</div>

</body>
</html>
