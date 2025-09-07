<?php

namespace App\Http\Controllers;

use App\Models\Struktur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StrukturController extends Controller
{
    public function index()
    {
        try {
            $strukturs = Struktur::all();
            return view('admin.struktur', compact('strukturs'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data struktur: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required',
                'posisi' => 'required',
                'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            ]);

            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('struktur', 'public');
            }

            Struktur::create([
                'nama' => $request->nama,
                'posisi' => $request->posisi,
                'foto' => $fotoPath,
            ]);

            return redirect()->back()->with('success', 'Struktur berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan struktur: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nama' => 'required',
                'posisi' => 'required',
                'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            ]);

            $struktur = Struktur::findOrFail($id);
            $struktur->nama = $request->nama;
            $struktur->posisi = $request->posisi;

            if ($request->hasFile('foto')) {
                if ($struktur->foto) {
                    Storage::disk('public')->delete($struktur->foto);
                }
                $struktur->foto = $request->file('foto')->store('struktur', 'public');
            }

            $struktur->save();

            return redirect()->route('struktur.index')->with('success', 'Struktur berhasil diubah');
        } catch (\Exception $e) {
            return redirect()->route('struktur.index')->with('error', 'Terjadi kesalahan saat mengubah struktur: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $struktur = Struktur::findOrFail($id);
            if ($struktur->foto) {
                Storage::disk('public')->delete($struktur->foto);
            }
            $struktur->delete();
            return redirect()->back()->with('success', 'Struktur berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus struktur: ' . $e->getMessage());
        }
    }
}
