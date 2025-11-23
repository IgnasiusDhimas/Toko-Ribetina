<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PDF;

class KasirController extends Controller
{
    public function index()
    {
        $barangs = Barang::all(); // Jangan dibatasi stok > 0, biar bisa tetap tampil tapi disabled
        return view('barang.index', compact('barangs'));
    }

    public function simpanTransaksi(Request $request)
    {
        $items = json_decode($request->items, true);

        if (!$items || count($items) === 0) {
            return redirect()->back()->with('error', 'Keranjang masih kosong!');
        }

        DB::beginTransaction();

        try {

            // VALIDASI STOK dulu
            foreach ($items as $item) {
                $barang = Barang::find($item['barang_id']);

                if ($barang->stok < $item['jumlah']) {
                    return back()->with('error', "Stok barang {$barang->nama} tidak mencukupi!");
                }
            }

            // SIMPAN TRANSAKSI
            $kode = 'TRX-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(4));

            $transaksi = Transaksi::create([
                'kode_transaksi' => $kode,
                'tanggal' => now(),
                'total' => $request->total_harga,
            ]);

            // SIMPAN DETAIL & UPDATE STOK
            foreach ($items as $item) {

                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id_transaksi,
                    'barang_id' => $item['barang_id'],
                    'qty' => $item['jumlah'],
                    'harga_satuan' => $item['harga_satuan'],
                    'subtotal' => $item['subtotal'],
                ]);

                Barang::where('id_barang', $item['barang_id'])
                        ->decrement('stok', $item['jumlah']);
            }

            DB::commit();

            // Ambil ulang transaksi dengan relasi
            $transaksi = Transaksi::with('items.barang')->findOrFail($transaksi->id_transaksi);

            // Generate PDF
            $pdf = PDF::loadView('kasir.invoice', compact('transaksi'))
                    ->setPaper('A4', 'portrait');

            session()->flash('success', 'Transaksi berhasil & invoice berhasil diunduh!');

            return $pdf->download('Invoice_'.$transaksi->kode_transaksi.'.pdf');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Error simpan transaksi: " . $e->getMessage());
            return redirect()->back()->with('error', 'Transaksi gagal diproses!');
        }
    }

    public function invoice($id_transaksi)
    {
        $transaksi = Transaksi::with('items.barang')->findOrFail($id_transaksi);
        return view('kasir.invoice', compact('transaksi'));
    }
}
