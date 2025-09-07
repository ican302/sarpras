<?php

namespace App\Http\Controllers;

use App\Models\Bangunan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BangunanExport;

class BangunanController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama_bangunan' => 'required',
                'kode_bangunan' => 'nullable',
                'nomor_register' => 'nullable',
                'kondisi' => 'nullable',
                'bertingkat' => 'nullable',
                'beton' => 'nullable',
                'luas' => 'nullable',
                'luas_lantai' => 'nullable',
                'lokasi' => 'nullable',
                'nomor' => 'nullable',
                'tanggal' => 'nullable|date',
                'status_tanah' => 'nullable',
                'kode_tanah' => 'nullable',
                'asal_usul' => 'nullable',
                'harga' => 'nullable',
                'keterangan' => 'nullable',
                'pemeliharaan' => 'nullable',
            ]);

            Bangunan::create($validated);

            return redirect()->back()->with('success', 'Bangunan berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan bangunan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Bangunan $bangunan)
    {
        try {
            $validated = $request->validate([
                'nama_bangunan' => 'required',
                'kode_bangunan' => 'nullable',
                'nomor_register' => 'nullable',
                'kondisi' => 'nullable',
                'bertingkat' => 'nullable',
                'beton' => 'nullable',
                'luas' => 'nullable',
                'luas_lantai' => 'nullable',
                'lokasi' => 'nullable',
                'nomor' => 'nullable',
                'tanggal' => 'nullable|date',
                'status_tanah' => 'nullable',
                'kode_tanah' => 'nullable',
                'asal_usul' => 'nullable',
                'harga' => 'nullable',
                'keterangan' => 'nullable',
                'pemeliharaan' => 'nullable',
            ]);

            $bangunan->update($validated);

            return redirect()->back()->with('success', 'Data Bangunan Berhasil Diubah');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengubah data bangunan: ' . $e->getMessage());
        }
    }

    public function destroy(Bangunan $bangunan)
    {
        try {
            $bangunan->delete();

            return redirect()->back()->with('success', 'Bangunan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus bangunan: ' . $e->getMessage());
        }
    }

    public function downloadAllBangunan()
    {
        try {
            return Excel::download(new BangunanExport, 'Bangunan.xlsx');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengunduh data bangunan: ' . $e->getMessage());
        }
    }
}
