<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tanah;
use App\Models\Sarana;
use App\Models\Bangunan;
use App\Models\Penyewaan;
use App\Models\Transaksi;
use App\Models\VisiMisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        try {
            $dataSarana = Sarana::select('kategori', DB::raw('COUNT(*) as jumlah'))
                ->groupBy('kategori')
                ->pluck('jumlah', 'kategori');

            $jumlahBangunan = Bangunan::count();
            $jumlahTanah = Tanah::count();
            $dataPrasarana = collect([
                'Bangunan' => $jumlahBangunan,
                'Tanah' => $jumlahTanah,
            ]);

            $jumlahPengguna = User::count();
            $jumlahSarana = Sarana::count();
            $jumlahPenyewaan = Penyewaan::count();

            $transaksiPerBulan = Transaksi::select(DB::raw('MONTH(tanggal_transaksi) as bulan'), DB::raw('COUNT(*) as jumlah'))
                ->groupBy(DB::raw('MONTH(tanggal_transaksi)'))
                ->orderBy(DB::raw('MONTH(tanggal_transaksi)'))
                ->pluck('jumlah', 'bulan');

            $jumlahTransaksi = Transaksi::count();

            $bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            $transaksiPerBulanComplete = [];
            foreach (range(1, 12) as $month) {
                $transaksiPerBulanComplete[] = $transaksiPerBulan->get($month, 0);
            }

            return view('admin.dashboard', compact(
                'jumlahPengguna',
                'jumlahSarana',
                'dataPrasarana',
                'jumlahPenyewaan',
                'jumlahTransaksi',
                'dataSarana',
                'bulanLabels',
                'transaksiPerBulanComplete'
            ));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat dashboard: ' . $e->getMessage());
        }
    }

    public function pengguna()
    {
        try {
            $users = User::all();
            return view('admin.pengguna', compact('users'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memuat data pengguna: ' . $e->getMessage());
        }
    }

    public function simpanPengguna(Request $request)
    {
        try {
            $request->validate([
                'nip' => 'required|unique:users',
                'nama_pengguna' => 'required',
                'posisi' => 'required',
                'tugas' => 'required',
                'role' => 'required',
                'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            ], [
                'nip.unique' => 'NIP sudah digunakan',
            ]);

            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('foto_pengguna', 'public');
            } else {
                $fotoPath = 'foto_pengguna/default.png';
            }

            User::create([
                'nip' => $request->nip,
                'nama_pengguna' => $request->nama_pengguna,
                'posisi' => $request->posisi,
                'tugas' => $request->tugas,
                'role' => $request->role,
                'foto' => $fotoPath,
                'password' => Hash::make('sarprastirtamulya'),
            ]);

            return redirect()->back()->with('success', 'Pengguna berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan, pengguna gagal ditambahkan: ' . $e->getMessage());
        }
    }

    public function editPengguna(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $nipRule = 'required|unique:users,nip,' . $user->id;

            $request->validate([
                'nip' => $nipRule,
                'nama_pengguna' => 'required',
                'posisi' => 'required',
                'tugas' => 'required',
                'role' => 'required',
                'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
                'password' => 'nullable|min:6',
            ]);

            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('foto_pengguna', 'public');
                $user->foto = $fotoPath;
            }

            if ($request->nip !== $user->nip) {
                $user->nip = $request->nip;
            }

            $user->nama_pengguna = $request->nama_pengguna;
            $user->posisi = $request->posisi;
            $user->tugas = $request->tugas;
            $user->role = $request->role;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            return redirect()->back()->with('success', 'Data pengguna berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan, pengguna gagal diperbarui: ' . $e->getMessage());
        }
    }

    public function hapusPengguna($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->back()->with('success', 'Pengguna berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan, pengguna gagal dihapus: ' . $e->getMessage());
        }
    }

    public function struktur()
    {
        try {
            return view('admin.struktur');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memuat struktur organisasi: ' . $e->getMessage());
        }
    }

    public function visimisi()
    {
        try {
            $visiMisi = VisiMisi::first();
            return view('admin.visimisi', compact('visiMisi'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memuat visi misi: ' . $e->getMessage());
        }
    }

    public function updateVisiMisi(Request $request)
    {
        try {
            $request->validate([
                'visi' => 'nullable|string',
                'misi' => 'nullable|string',
            ]);

            $visiMisi = VisiMisi::first();
            if (!$visiMisi) {
                $visiMisi = new VisiMisi();
            }

            $visiMisi->visi = $request->visi;
            $visiMisi->misi = $request->misi;
            $visiMisi->save();

            return redirect()->back()->with('success', 'Visi & Misi berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui Visi & Misi: ' . $e->getMessage());
        }
    }
}
