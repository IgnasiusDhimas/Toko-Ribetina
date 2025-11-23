@extends('layouts.app')

@section('content')
<div class="card p-4">
    <h3 class="mb-4">Tambah Barang Baru</h3>

    <form action="/barang" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nama Barang</label>
            <input type="text" name="nama" class="form-control" placeholder="Masukkan nama barang">
        </div>

        <div class="mb-3">
            <label class="form-label">Stok</label>
            <input type="number" name="stok" class="form-control" placeholder="Jumlah stok tersedia">
        </div>

        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" name="harga" step="0.01" class="form-control" placeholder="Harga satuan">
        </div>

        <button type="submit" class="btn btn-main px-4">Simpan</button>
        <a href="/barang" class="btn btn-outline-secondary px-4">Kembali</a>
    </form>
</div>
@endsection
