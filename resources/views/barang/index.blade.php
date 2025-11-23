@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h2 class="fw-bold">📦 Daftar Barang</h2>
    <div>
        <a href="/barang/create" class="btn btn-primary">➕ Tambah Barang</a>
        <a href="/barang/stok-rendah" class="btn btn-warning">⚠ Stok Rendah</a>
    </div>
</div>

<div class="card p-3 mb-4 shadow-sm">
    <h4 class="fw-bold">Ekspor Data Stok Rendah</h4>
    <p>Unduh data barang stok < 5 dalam format Excel.</p>
    <a href="/barang/stok-rendah/excel-manual" class="btn btn-success">
        📥 Ekspor ke Excel
    </a>
</div>

<table class="table table-bordered table-hover bg-white shadow-sm">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Stok</th>
            <th>Harga</th>
            <th>Total Nilai</th>
            <th>Update</th>
            <th>Hapus</th>
        </tr>
    </thead>
    <tbody>
        @foreach($barangs as $barang)
        <tr>
            <td>{{ $barang->nama }}</td>
            <td>{{ $barang->stok }}</td>
            <td>Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
            <td>Rp {{ number_format($barang->total_nilai, 0, ',', '.') }}</td>
            <td>
                <a href="/barang/{{ $barang->id_barang }}/edit"
                   class="btn btn-sm btn-warning">✏ Edit</a>
            </td>
            <td>
                <form action="/barang/{{ $barang->id_barang }}" method="POST"
                      onsubmit="return confirm('Yakin ingin hapus barang ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">🗑 Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<hr class="my-4">

<h3 class="fw-bold">🧾 Form Kasir</h3>

<form id="form-kasir" class="card p-4 shadow-sm" action="{{ route('kasir.simpan') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label class="form-label">Nama Pembeli</label>
        <input type="text" name="nama" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Pilih Barang</label>
        <select id="barangSelect" class="form-select">
            <option value="">-- Pilih Barang --</option>
            @foreach($barangs as $barang)
                <option value="{{ $barang->id_barang }}"
                        data-nama="{{ $barang->nama }}"
                        data-harga="{{ $barang->harga }}"
                        @if($barang->stok <= 0) disabled @endif>
                    {{ $barang->nama }} (Stok: {{ $barang->stok }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Jumlah</label>
        <input type="number" id="qtyInput" class="form-control" min="1">
    </div>

    <button type="button" class="btn btn-secondary mb-3" onclick="tambahKeKeranjang()">➕ Tambah ke Keranjang</button>

    <table class="table table-bordered">
        <thead>
            <tr><th>Barang</th><th>Qty</th><th>Harga</th><th>Subtotal</th></tr>
        </thead>
        <tbody id="keranjang"></tbody>
    </table>

    <input type="hidden" name="items" id="items_json">
    <input type="hidden" name="total_harga" id="total_harga">

    <button type="submit" class="btn btn-success">💾 Simpan Transaksi</button>
</form>

@endsection

@section('scripts')
<script>
    const keranjang = [];
    const tbody = document.getElementById('keranjang');

    function tambahKeKeranjang() {
        const select = document.getElementById('barangSelect');
        const qty = parseInt(document.getElementById('qtyInput').value);
        const barang_id = select.value;

        if (!barang_id || !qty || qty <= 0) return alert('Pilih barang dan jumlah valid');

        const stok = parseInt(select.options[select.selectedIndex].text.match(/Stok: (\d+)/)[1]);
        const nama = select.options[select.selectedIndex].dataset.nama;
        const harga = parseInt(select.options[select.selectedIndex].dataset.harga);

        const existing = keranjang.find(item => item.barang_id === barang_id);
        const totalQty = existing ? existing.jumlah + qty : qty;

        if (totalQty > stok)
            return alert(`Stok tidak cukup! Stok tersedia ${stok}, total pembelian menjadi ${totalQty}`);

        if (existing) {
            existing.jumlah += qty;
            existing.subtotal = existing.jumlah * harga;
        } else {
            keranjang.push({ barang_id, harga_satuan: harga, jumlah: qty, subtotal: harga * qty });
        }

        renderKeranjang();
    }

    function renderKeranjang() {
        tbody.innerHTML = "";
        keranjang.forEach(item => {
            const namaBarang = document.querySelector(`#barangSelect option[value='${item.barang_id}']`).dataset.nama;
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${namaBarang}</td>
                <td>${item.jumlah}</td>
                <td>Rp ${item.harga_satuan.toLocaleString()}</td>
                <td>Rp ${(item.harga_satuan * item.jumlah).toLocaleString()}</td>
            `;
            tbody.appendChild(row);
        });

        document.getElementById('items_json').value = JSON.stringify(keranjang);
        document.getElementById('total_harga').value =
            keranjang.reduce((s, i) => s + i.subtotal, 0);
    }
</script>
@endsection