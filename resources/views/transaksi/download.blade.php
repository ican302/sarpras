<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Detail Transaksi</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
            margin: 20px;
        }

        h2 {
            text-align: center;
            color: #16a34a;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: auto;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px 12px;
            text-align: left;
        }

        th {
            background-color: #e5e7eb;
        }
    </style>
</head>

<body>
    <h2>Detail Transaksi</h2>
    <table>
        <tr>
            <th>Detail</th>
            <th>Informasi</th>
        </tr>
        <tr>
            <td>ID Transaksi</td>
            <td>{{ $transaksi->id_transaksi }}</td>
        </tr>
        <tr>
            <td>Nama Peminjam</td>
            <td>{{ $transaksi->peminjam }}</td>
        </tr>
        <tr>
            <td>Nama Sarana/Prasarana</td>
            <td>{{ $transaksi->penyewaan->penyewaanable->nama }}</td>
        </tr>
        <tr>
            <td>Jumlah</td>
            <td>{{ $transaksi->jumlah }}</td>
        </tr>
        <tr>
            <td>Harga Satuan</td>
            <td>{{ number_format($transaksi->penyewaan->harga, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Tanggal Transaksi</td>
            <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td>Tanggal Mulai</td>
            <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_mulai)->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td>Tanggal Selesai</td>
            <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_selesai)->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td>Durasi Peminjaman</td>
            <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($transaksi->tanggal_selesai)) + 1 }}
                hari</td>
        </tr>
        <tr>
            <td>Total Harga</td>
            <td>{{ number_format($transaksi->penyewaan->harga * $transaksi->jumlah, 0, ',', '.') }}</td>
        </tr>
    </table>
</body>

</html>
