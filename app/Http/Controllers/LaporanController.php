<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Penyewaan;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Transaksi::with('penyewaan');

            if ($request->has('search') && $request->search !== null) {
                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->where('id_transaksi', 'like', "%{$search}%")
                        ->orWhere('peminjam', 'like', "%{$search}%")
                        ->orWhereHas('penyewaan', function ($q) use ($search) {
                            $q->whereHasMorph('penyewaanable', [
                                \App\Models\Bangunan::class,
                                \App\Models\Sarana::class,
                                \App\Models\Tanah::class
                            ], function ($q2, $type) use ($search) {
                                if ($type === \App\Models\Bangunan::class) {
                                    $q2->where('nama_bangunan', 'like', "%{$search}%");
                                } elseif ($type === \App\Models\Sarana::class) {
                                    $q2->where('nama_barang', 'like', "%{$search}%");
                                } elseif ($type === \App\Models\Tanah::class) {
                                    $q2->where('nama', 'like', "%{$search}%");
                                }
                            });
                        });
                });
            }

            if ($request->filled('day')) {
                $query->whereDay('tanggal_transaksi', $request->day);
            }

            if ($request->filled('month')) {
                $query->whereMonth('tanggal_transaksi', $request->month);
            }

            if ($request->filled('year')) {
                $query->whereYear('tanggal_transaksi', $request->year);
            }

            $transaksis = $query->get();
            $penyewaans = Penyewaan::all();

            return view('laporan', compact('transaksis', 'penyewaans'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data laporan: ' . $e->getMessage());
        }
    }

    public function downloadAllLaporan(Request $request)
    {
        try {
            return Excel::download(
                new LaporanExport($request->day, $request->month, $request->year),
                'Laporan.xlsx'
            );
        } catch (\Exception $e) {
            return redirect()->route('laporan.index')->with('error', 'Terjadi kesalahan saat mengunduh data laporan: ' . $e->getMessage());
        }
    }

    public function cetakPdf(Request $request)
    {
        try {
            $query = Transaksi::with('penyewaan.penyewaanable');

            if ($request->filled('day')) {
                $query->whereDay('tanggal_transaksi', $request->day);
            }

            if ($request->filled('month')) {
                $query->whereMonth('tanggal_transaksi', $request->month);
            }

            if ($request->filled('year')) {
                $query->whereYear('tanggal_transaksi', $request->year);
            }

            $transaksis = $query->get();

            $pdf = PDF::loadView('transaksi.laporan', compact('transaksis'))->setPaper('a4', 'landscape');
            return $pdf->stream('Laporan Transaksi.pdf');
        } catch (\Exception $e) {
            return redirect()->route('laporan.index')->with('error', 'Gagal mencetak PDF: ' . $e->getMessage());
        }
    }
}
