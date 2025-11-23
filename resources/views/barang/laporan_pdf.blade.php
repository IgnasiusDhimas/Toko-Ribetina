<h2 style="font-family:Poppins;">Laporan Barang Stok Rendah (<5)</h2>
<table border="1" cellpadding="5" cellspacing="0" width="100%" style="border-collapse: collapse; font-family:Poppins;">
    <thead style="background:#03AC0E;color:#fff;">
        <tr>
            <th>Nama</th><th>Stok</th><th>Harga</th><th>Total Nilai</th>
        </tr>
    </thead>
    <tbody>
        @foreach($barangs as $barang)
        <tr>
            <td>{{ $barang->nama }}</td>
            <td>{{ $barang->stok }}</td>
            <td>Rp {{ number_format($barang->harga) }}</td>
            <td>Rp {{ number_format($barang->total_nilai) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
