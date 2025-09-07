<?php

namespace App\Http\Controllers;

use App\Models\Penyewaan;
use App\Models\VisiMisi;
use App\Models\Struktur;

class HomeController extends Controller
{
    public function index()
    {
        try {
            // $penyewaans = Penyewaan::with('penyewaanable')->get();
            $visiMisi = VisiMisi::first();

            // $ketua = Struktur::where('posisi', 'Ketua')->first();
            // $wakilKetua = Struktur::where('posisi', 'Wakil Ketua')->first();
            // $staffAdmin = Struktur::where('posisi', 'Staff Admin')->first();
            // $staff = Struktur::where('posisi', 'Staff')->get();

            return view('home', compact('visiMisi'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat halaman beranda: ' . $e->getMessage());
        }
    }
}
