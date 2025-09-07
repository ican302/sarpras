<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Penyewaan;
use Midtrans\Snap;
use Midtrans\Config;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransaksiExport;
use Barryvdh\DomPDF\Facade\Pdf;

class TransaksiController extends Controller
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
                        ->orWhereHas('penyewaan', function ($q2) use ($search) {
                            $q2->where('nama', 'like', "%{$search}%");
                        });
                });
            }

            $transaksis = $query->get();
            $penyewaans = Penyewaan::all();

            return view('transaksi', compact('transaksis', 'penyewaans'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data transaksi: ' . $e->getMessage());
        }
    }

    public function getSnapToken(Request $request)
    {
        try {
            $request->validate([
                'penyewaan_id' => 'required|exists:penyewaans,id',
                'jumlah' => 'required|integer|min:1',
                'tanggal_mulai' => 'required|date',
                'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            ]);

            $penyewaan = Penyewaan::with('penyewaanable')->findOrFail($request->penyewaan_id);

            $tanggalMulai = new \DateTime($request->tanggal_mulai);
            $tanggalSelesai = new \DateTime($request->tanggal_selesai);
            $durasiHari = $tanggalMulai->diff($tanggalSelesai)->days + 1;

            $hargaTotal = $penyewaan->harga * $request->jumlah * $durasiHari;

            $tanggalTransaksi = now()->format('dmy');
            $kode = $penyewaan->penyewaanable->kode ?? 'UNKNOWN';
            $prefixId = $kode . '-' . $tanggalTransaksi;
            $uniqueSuffix = substr(str_replace([' ', ':', '-'], '', now()->format('Hisv')), 0, 6);
            $order_id = $prefixId . '-' . $uniqueSuffix;

            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = false;
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $params = [
                'transaction_details' => [
                    'order_id' => $order_id,
                    'gross_amount' => $hargaTotal,
                ],
                'item_details' => [
                    [
                        'id' => $kode,
                        'price' => $hargaTotal,
                        'quantity' => $request->jumlah,
                        'name' => $penyewaan->penyewaanable->nama,
                    ]
                ],
                'customer_details' => [
                    'first_name' => $request->peminjam,
                    'phone' => $request->no_wa,
                ],
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($params);

            return response()->json([
                'snapToken' => $snapToken,
                'order_id' => $order_id,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat memproses transaksi: ' . $e->getMessage()], 500);
        }
    }

    public function simpanTransaksi(Request $request)
    {
        try {
            $request->validate([
                'penyewaan_id' => 'required|exists:penyewaans,id',
                'jumlah' => 'required|integer|min:1',
                'peminjam' => 'required|string|max:255',
                'no_wa' => 'required|string|max:20',
                'tanggal_mulai' => 'required|date',
                'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
                'order_id' => 'required|string|unique:transaksis,id_transaksi',
                'keterangan' => 'nullable|string',
            ]);

            $penyewaan = Penyewaan::findOrFail($request->penyewaan_id);

            if ($penyewaan->jumlah < $request->jumlah) {
                return response()->json(['message' => 'Stok tidak mencukupi'], 400);
            }

            $tanggalMulai = new \DateTime($request->tanggal_mulai);
            $tanggalSelesai = new \DateTime($request->tanggal_selesai);
            $durasiHari = $tanggalMulai->diff($tanggalSelesai)->days + 1;

            $hargaTotal = $penyewaan->harga * $request->jumlah * $durasiHari;

            $transaksi = new Transaksi();
            $transaksi->id_transaksi = $request->order_id;
            $transaksi->penyewaan_id = $penyewaan->id;
            $transaksi->jumlah = $request->jumlah;
            $transaksi->harga = $hargaTotal;
            $transaksi->peminjam = $request->peminjam;
            $transaksi->no_wa = $request->no_wa;
            $transaksi->keterangan = $request->keterangan;
            $transaksi->tanggal_mulai = $request->tanggal_mulai;
            $transaksi->tanggal_selesai = $request->tanggal_selesai;
            $transaksi->save();

            $penyewaan->jumlah -= $request->jumlah;
            $penyewaan->save();

            return response()->json(['message' => 'Transaksi berhasil disimpan dan stok dikurangi']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menyimpan transaksi: ' . $e->getMessage()], 500);
        }
    }

    public function sukses(Request $request)
    {
        try {
            $transaksi = Transaksi::with('penyewaan.penyewaanable')
                ->where('id_transaksi', $request->order_id)
                ->first();

            if (!$transaksi) {
                return redirect()->route('home')->with('error', 'Transaksi tidak ditemukan.');
            }

            return view('transaksi.sukses', compact('transaksi'));
        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Terjadi kesalahan saat memproses transaksi: ' . $e->getMessage());
        }
    }

    public function downloadTransaksi($id)
    {
        try {
            $transaksi = Transaksi::with('penyewaan')->findOrFail($id);

            $pdf = Pdf::loadView('transaksi.download', compact('transaksi'));

            $fileName = 'Detail_Transaksi_' . $transaksi->id . '.pdf';

            return $pdf->download($fileName);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat mengunduh transaksi: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'penyewaan_id' => 'required|exists:penyewaans,id',
                'jumlah' => 'required|integer|min:1',
                'peminjam' => 'required|string|max:255',
                'no_wa' => 'required|string|max:20',
                'tanggal_transaksi' => 'required|date',
                'tanggal_mulai' => 'required|date',
                'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
                'keterangan' => 'nullable|string',
            ]);

            $transaksi = Transaksi::findOrFail($id);
            $penyewaanBaru = Penyewaan::findOrFail($request->penyewaan_id);
            $penyewaanLama = $transaksi->penyewaan;

            if ($penyewaanLama) {
                $penyewaanLama->jumlah += $transaksi->jumlah;
                $penyewaanLama->save();
            }

            if ($penyewaanBaru->jumlah < $request->jumlah) {
                return redirect()->back()->with('error', 'Stok tidak mencukupi untuk jumlah yang diminta.');
            }

            $tanggalMulai = new \DateTime($request->tanggal_mulai);
            $tanggalSelesai = new \DateTime($request->tanggal_selesai);
            $durasiHari = $tanggalMulai->diff($tanggalSelesai)->days + 1;

            $hargaTotal = $penyewaanBaru->harga * $request->jumlah * $durasiHari;

            $transaksi->penyewaan_id = $request->penyewaan_id;
            $transaksi->jumlah = $request->jumlah;
            $transaksi->harga = $hargaTotal;
            $transaksi->peminjam = $request->peminjam;
            $transaksi->no_wa = $request->no_wa;
            $transaksi->tanggal_transaksi = $request->tanggal_transaksi;
            $transaksi->tanggal_mulai = $request->tanggal_mulai;
            $transaksi->tanggal_selesai = $request->tanggal_selesai;
            $transaksi->keterangan = $request->keterangan;
            $transaksi->save();

            $penyewaanBaru->jumlah -= $request->jumlah;
            $penyewaanBaru->save();

            return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui transaksi: ' . $e->getMessage());
        }
    }


    public function destroy(Transaksi $transaksi)
    {
        try {
            $penyewaan = $transaksi->penyewaan;
            if ($penyewaan) {
                $penyewaan->jumlah += $transaksi->jumlah;
                $penyewaan->save();
            }

            $transaksi->delete();

            return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('transaksi.index')->with('error', 'Terjadi kesalahan saat menghapus transaksi: ' . $e->getMessage());
        }
    }

    public function downloadAllTransaksi()
    {
        try {
            return Excel::download(new TransaksiExport, 'Transaksi.xlsx');
        } catch (\Exception $e) {
            return redirect()->route('transaksi.index')->with('error', 'Terjadi kesalahan saat mengunduh data transaksi: ' . $e->getMessage());
        }
    }
}
