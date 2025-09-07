<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        h2,
        h4 {
            text-align: center;
            margin: 0;
        }
    </style>
</head>

<body>
    <div style="text-align: center; margin-bottom: 10px;">
        <img src="{{ public_path('images/logo.png') }}" alt="Logo" height="80">
    </div>

    <h2 style="margin-top: 20px;">Laporan Transaksi Penyewaan Sarana & Prasarana</h2>
    <h4 style="margin-top: 15px;">SMKN 1 Tirtamulya</h4>
    <h4 style="margin-top: 5px;">Jl. Raya, Parakan, Kec. Tirtamulya, Karawang, Jawa Barat 41372</h4>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Transaksi</th>
                <th>Nama Sarana/Prasarana</th>
                <th>Nama Peminjam</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Tanggal Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transaksis as $i => $t)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $t->id_transaksi }}</td>
                    <td>{{ $t->penyewaan->penyewaanable->nama ?? '-' }}</td>
                    <td>{{ $t->peminjam }}</td>
                    <td>{{ $t->jumlah }}</td>
                    <td>Rp {{ number_format($t->harga, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($t->tanggal_transaksi)->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Data tidak tersedia.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
