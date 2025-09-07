<?php

namespace App\Http\Controllers;

use App\Models\Sarana;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SaranaExport;

class SaranaController extends Controller
{
    public function index(Request $request)
    {
        try {
            $search = $request->input('search');

            $saranaQuery = Sarana::query();

            if ($search) {
                $saranaQuery->where(function ($query) use ($search) {
                    $query->where('nama_barang', 'like', "%{$search}%")
                        ->orWhere('kategori', 'like', "%{$search}%")
                        ->orWhere('kode_barang', 'like', "%{$search}%")
                        ->orWhere('kode_sekolah', 'like', "%{$search}%")
                        ->orWhere('spesifikasi', 'like', "%{$search}%")
                        ->orWhere('sumber_dana', 'like', "%{$search}%")
                        ->orWhere('lokasi', 'like', "%{$search}%")
                        ->orWhere('kondisi', 'like', "%{$search}%");
                });
            }

            $saranas = $saranaQuery->get();

            return view('sarana', compact('saranas'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data sarana: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_barang' => 'required',
                'kategori' => 'required',
                'kode_barang' => 'nullable',
                'kode_sekolah' => 'nullable',
                'spesifikasi' => 'nullable',
                'satuan' => 'nullable',
                'sumber_dana' => 'nullable',
                'harga' => 'nullable|integer',
                'tanggal_masuk' => 'nullable|date',
                'lokasi' => 'nullable',
                'kondisi' => 'nullable',
                'jumlah' => 'nullable|integer',
                'keterangan' => 'nullable',
                'service' => 'nullable',
            ]);

            Sarana::create($request->all());

            return redirect()->back()->with('success', 'Data sarana berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan data sarana: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Sarana $sarana)
    {
        try {
            $request->validate([
                'nama_barang' => 'required',
                'kategori' => 'required',
                'kode_barang' => 'nullable',
                'kode_sekolah' => 'nullable',
                'spesifikasi' => 'nullable',
                'satuan' => 'nullable',
                'sumber_dana' => 'nullable',
                'harga' => 'nullable|integer',
                'tanggal_masuk' => 'nullable|date',
                'lokasi' => 'nullable',
                'kondisi' => 'nullable',
                'jumlah' => 'nullable|integer',
                'keterangan' => 'nullable',
                'service' => 'nullable',
            ]);

            $sarana->update($request->all());

            return redirect()->back()->with('success', 'Data sarana berhasil diubah');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengubah data sarana: ' . $e->getMessage());
        }
    }

    public function destroy(Sarana $sarana)
    {
        try {
            $sarana->delete();

            return redirect()->back()->with('success', 'Data sarana berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data sarana: ' . $e->getMessage());
        }
    }

    public function downloadAllSarana()
    {
        try {
            return Excel::download(new SaranaExport, 'Sarana.xlsx');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengunduh data sarana: ' . $e->getMessage());
        }
    }
}
