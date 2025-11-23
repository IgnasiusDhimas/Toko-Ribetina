<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
//use App\Exports\StokRendahExport;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Response;



class BarangController extends Controller
{
    public function index() {
        $barangs = Barang::all();
        return view('barang.index', compact('barangs'));
    }

    public function create() {
        return view('barang.create');
    }

    public function store(Request $request) {
    $harga = $request->harga;
    $stok = $request->stok;
    $total_nilai = $harga * $stok;

    Barang::create([
        'nama' => $request->nama,
        'stok' => $stok,
        'harga' => $harga,
        'total_nilai' => $total_nilai,
    ]);

    return redirect('/barang');
    }

    public function edit($id_barang)
    {
        $barang = Barang::findOrFail($id_barang);
        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, $id_barang)
    {
        $barang = Barang::findOrFail($id_barang);

        $barang->update([
            'nama' => $request->nama,
            'stok' => $request->stok,
            'harga' => $request->harga,
            'total_nilai' => $request->stok * $request->harga,
        ]);

        return redirect('/barang');
    }

    public function destroy($id_barang)
    {
        $barang = Barang::findOrFail($id_barang);
        $barang->delete();

        return redirect('/barang')->with('success', 'Barang berhasil dihapus.');
    }

    public function stokRendah()
    {
        $barangs = Barang::where('stok', '<', 5)->get();
        return view('barang.stok_rendah', compact('barangs'));
    }

    public function exportPdf()
    {
        $barangs = Barang::where('stok', '<', 5)->get();
        $pdf = Pdf::loadView('barang.laporan_pdf', compact('barangs'));
        return $pdf->download('stok-rendah.pdf');
    }

    /* public function exportExcel()
    {
        return Excel::download(new StokRendahExport, 'stok-rendah.xlsx');
    } */

    public function exportExcelManual()
    {
        $barangs = Barang::where('stok', '<', 5)->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'Nama');
        $sheet->setCellValue('B1', 'Stok');
        $sheet->setCellValue('C1', 'Harga');
        $sheet->setCellValue('D1', 'Total Nilai');

        // Data
        $row = 2;
        foreach ($barangs as $barang) {
            $sheet->setCellValue("A{$row}", $barang->nama);
            $sheet->setCellValue("B{$row}", $barang->stok);
            $sheet->setCellValue("C{$row}", $barang->harga);
            $sheet->setCellValue("D{$row}", $barang->total_nilai);
            $row++;
        }

        // Output
        $writer = new Xlsx($spreadsheet);
        $filename = 'stok-rendah.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $filename);
        $writer->save($temp_file);

        return response()->download($temp_file, $filename)->deleteFileAfterSend(true);
    }

}