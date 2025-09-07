<?php

namespace App\Http\Controllers;

use App\Models\Tanah;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TanahExport;

class TanahController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama' => 'required',
                'kode' => 'nullable',
                'nomor_register' => 'nullable',
                'luas' => 'nullable',
                'tahun_pengadaan' => 'nullable',
                'lokasi' => 'nullable',
                'status_tanah' => 'nullable',
                'tanggal' => 'nullable',
                'nomor' => 'nullable',
                'penggunaan' => 'nullable',
                'asal_usul' => 'nullable',
                'harga' => 'nullable',
                'keterangan' => 'nullable',
                'pemeliharaan' => 'nullable',
            ]);

            Tanah::create($validated);

            return redirect()->back()->with('success', 'Data tanah berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan data tanah: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Tanah $tanah)
    {
        try {
            $validated = $request->validate([
                'nama' => 'required',
                'kode' => 'nullable',
                'nomor_register' => 'nullable',
                'luas' => 'nullable',
                'tahun_pengadaan' => 'nullable',
                'lokasi' => 'nullable',
                'status_tanah' => 'nullable',
                'tanggal' => 'nullable',
                'nomor' => 'nullable',
                'penggunaan' => 'nullable',
                'asal_usul' => 'nullable',
                'harga' => 'nullable',
                'keterangan' => 'nullable',
                'pemeliharaan' => 'nullable',
            ]);

            $tanah->update($validated);

            return redirect()->back()->with('success', 'Data tanah berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data tanah: ' . $e->getMessage());
        }
    }

    public function destroy(Tanah $tanah)
    {
        try {
            $tanah->delete();

            return redirect()->back()->with('success', 'Data tanah berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data tanah: ' . $e->getMessage());
        }
    }

    public function downloadAllTanah()
    {
        try {
            return Excel::download(new TanahExport, 'Tanah.xlsx');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengunduh data tanah: ' . $e->getMessage());
        }
    }
}
