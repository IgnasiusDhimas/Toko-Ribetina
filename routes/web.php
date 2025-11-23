<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KasirController;

Route::get('/', [BarangController::class, 'index']);
Route::get('/barang', [BarangController::class, 'index']);
Route::get('/barang/create', [BarangController::class, 'create']);
Route::post('/barang', [BarangController::class, 'store']);
Route::get('/barang/{id_barang}/edit', [BarangController::class, 'edit']);
Route::put('/barang/{id_barang}', [BarangController::class, 'update']);
Route::delete('/barang/{id_barang}', [BarangController::class, 'destroy']);
Route::get('/barang/stok-rendah', [BarangController::class, 'stokRendah']);
Route::get('/barang/stok-rendah/pdf', [BarangController::class, 'exportPdf']);
Route::get('/barang/stok-rendah/excel', [BarangController::class, 'exportExcel']);
Route::get('/barang/stok-rendah/excel-manual', [BarangController::class, 'exportExcelManual']);

Route::get('/kasir', [KasirController::class, 'index']);
Route::post('/kasir/simpan', [KasirController::class, 'simpanTransaksi'])->name('kasir.simpan');
Route::get('/kasir/invoice/{id_transaksi}', [KasirController::class, 'invoice'])->name('kasir.invoice');
