<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penyewaan;
use App\Models\Sarana;
use App\Models\Bangunan;
use App\Models\Tanah;


class PenyewaanController extends Controller
{
    public function index(Request $request)
    {
        $saranas = Sarana::select('id', 'nama_barang', 'kode_barang')->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'type' => Sarana::class,
                'nama' => $item->nama,
                'kode' => $item->kode,
            ];
        });

        $bangunans = Bangunan::select('id', 'nama_bangunan', 'kode_bangunan')->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'type' => Bangunan::class,
                'nama' => $item->nama,
                'kode' => $item->kode,
            ];
        });

        $tanahs = Tanah::select('id', 'nama', 'kode')->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'type' => Tanah::class,
                'nama' => $item->nama,
                'kode' => $item->kode,
            ];
        });

        $items = $saranas->merge($bangunans)->merge($tanahs);

        $query = Penyewaan::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('kode', 'like', "%{$search}%")
                    ->orWhere('jumlah', 'like', "%{$search}%")
                    ->orWhere('harga', 'like', "%{$search}%");
            });
        }

        $penyewaans = $query->get();

        return view('penyewaan', compact('penyewaans', 'items'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'penyewaanable' => 'required|string',
                'kode' => 'required|string',
                'jumlah' => 'required|integer',
                'harga' => 'required|integer',
                'keterangan' => 'nullable|string',
            ]);

            list($penyewaanable_id, $penyewaanable_type) = explode('|', $request->input('penyewaanable'));

            Penyewaan::create([
                'penyewaanable_id' => $penyewaanable_id,
                'penyewaanable_type' => $penyewaanable_type,
                'nama' => $request->input('nama'),
                'kode' => $request->input('kode'),
                'jumlah' => $request->input('jumlah'),
                'harga' => $request->input('harga'),
                'keterangan' => $request->input('keterangan'),
            ]);

            return redirect()->back()->with('success', 'Data penyewaan berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan data penyewaan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Penyewaan $penyewaan)
    {
        try {
            $request->validate([
                'penyewaanable' => 'required|string',
                'kode' => 'required|string',
                'jumlah' => 'required|integer',
                'harga' => 'required|integer',
                'keterangan' => 'nullable|string',
            ]);

            list($penyewaanable_id, $penyewaanable_type) = explode('|', $request->input('penyewaanable'));

            $penyewaan->update([
                'penyewaanable_id' => $penyewaanable_id,
                'penyewaanable_type' => $penyewaanable_type,
                'nama' => $request->input('nama'),
                'kode' => $request->input('kode'),
                'jumlah' => $request->input('jumlah'),
                'harga' => $request->input('harga'),
                'keterangan' => $request->input('keterangan'),
            ]);

            return redirect()->back()->with('success', 'Data penyewaan berhasil diubah');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengubah data penyewaan: ' . $e->getMessage());
        }
    }

    public function destroy(Penyewaan $penyewaan)
    {
        try {
            $penyewaan->delete();

            return redirect()->back()->with('success', 'Data penyewaan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data penyewaan: ' . $e->getMessage());
        }
    }
}
