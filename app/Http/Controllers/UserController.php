<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tanah;
use App\Models\Sarana;
use App\Models\Bangunan;
use App\Models\Penyewaan;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function dashboard()
    {
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

        return view('user.dashboard', compact(
            'jumlahPengguna',
            'jumlahSarana',
            'dataPrasarana',
            'jumlahPenyewaan',
            'jumlahTransaksi',
            'dataSarana',
            'bulanLabels',
            'transaksiPerBulanComplete'
        ));
    }
}
