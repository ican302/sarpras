<?php

namespace App\Http\Controllers;

use App\Models\Tanah;
use App\Models\Bangunan;
use Illuminate\Http\Request;

class PrasaranaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', null);
        $filter = $request->input('filter', 'Semua');

        $bangunans = collect();
        $tanahs = collect();

        if ($filter === 'Bangunan' || $filter === 'Semua' || $filter === 'Tanah') {
            $bangunanQuery = Bangunan::query();

            if ($search && $filter !== 'Tanah') {
                $bangunanQuery->where(function ($query) use ($search) {
                    $query->where('nama_bangunan', 'like', "%{$search}%")
                        ->orWhere('kode_bangunan', 'like', "%{$search}%")
                        ->orWhere('lokasi', 'like', "%{$search}%")
                        ->orWhere('status_tanah', 'like', "%{$search}%")
                        ->orWhere('kode_tanah', 'like', "%{$search}%")
                        ->orWhere('asal_usul', 'like', "%{$search}%")
                        ->orWhere('nomor_register', 'like', "%{$search}%")
                        ->orWhere('nomor', 'like', "%{$search}%");
                });
            }

            $bangunans = $bangunanQuery->get();
        }

        if ($filter === 'Tanah' || $filter === 'Semua' || $filter === 'Bangunan') {
            $tanahQuery = Tanah::query();

            if ($search && $filter !== 'Bangunan') {
                $tanahQuery->where(function ($query) use ($search) {
                    $query->where('nama', 'like', "%{$search}%")
                        ->orWhere('kode', 'like', "%{$search}%")
                        ->orWhere('nomor_register', 'like', "%{$search}%")
                        ->orWhere('lokasi', 'like', "%{$search}%")
                        ->orWhere('status_tanah', 'like', "%{$search}%")
                        ->orWhere('nomor', 'like', "%{$search}%")
                        ->orWhere('penggunaan', 'like', "%{$search}%")
                        ->orWhere('asal_usul', 'like', "%{$search}%")
                        ->orWhere('tahun_pengadaan', 'like', "%{$search}%");
                });
            }

            $tanahs = $tanahQuery->get();
        }

        return view('prasarana', compact('bangunans', 'tanahs'));
    }
}
