@extends('layouts.app')

@section('content')
<h2 class="mb-4">Barang dengan Stok Rendah (< 5)</h2>

<div class="mb-3">
    <a href="/barang" class="btn btn-outline-secondary">Kembali</a>
    <a href="/barang/stok-rendah/pdf" class="btn btn-danger">PDF</a>
    <a href="/barang/stok-rendah/excel-manual" class="btn btn-success">Excel</a>
</div>

<table class="table table-bordered table-hover bg-white">
    <thead>
        <tr><th>Nama</th><th>Stok</th><th>Harga</th><th>Total Nilai</th></tr>
    </thead>
    <tbody>
        @foreach($barangs as $barang)
        <tr>
            <td>{{ $barang->nama }}</td>
            <td>{{ $barang->stok }}</td>
            <td>Rp {{ number_format($barang->harga,0,',','.') }}</td>
            <td>Rp {{ number_format($barang->total_nilai,0,',','.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
