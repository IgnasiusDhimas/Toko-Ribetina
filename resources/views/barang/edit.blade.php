@extends('layouts.app')

@section('content')
<div class="card p-4">
    <h3 class="mb-4">Edit Barang</h3>

    <form action="/barang/{{ $barang->id_barang }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama Barang</label>
            <input type="text" name="nama" class="form-control" value="{{ $barang->nama }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Stok</label>
            <input type="number" name="stok" class="form-control" value="{{ $barang->stok }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" name="harga" step="0.01" class="form-control" value="{{ $barang->harga }}">
        </div>

        <button type="submit" class="btn btn-main px-4">Update</button>
        <a href="/barang" class="btn btn-outline-secondary px-4">Kembali</a>
    </form>
</div>
@endsection
