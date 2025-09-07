<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SARPRAS SMKN 1 Tirtamulya</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-montserrat antialiased bg-gray-100">
    <div class="container mx-auto text-center py-20 px-5">
        <h1 class="text-4xl font-semibold text-emerald-600">Pembayaran Berhasil!</h1>
        <p class="mt-4 text-xl">Terima kasih, transaksi Anda telah berhasil diproses.</p>
        <div class="mt-8 bg-white p-6 rounded-lg shadow-lg font-montserrat">
            <h2 class="text-2xl font-semibold mb-6 text-center">Detail Transaksi</h2>
            <table class="w-full text-left table-auto">
                <tr>
                    <td class="py-2 font-medium text-gray-600">ID Transaksi</td>
                    <td class="py-2">{{ $transaksi->id_transaksi }}</td>
                </tr>
                <tr>
                    <td class="py-2 font-medium text-gray-600">Nama Peminjam</td>
                    <td class="py-2">{{ $transaksi->peminjam }}</td>
                </tr>
                <tr>
                    <td class="py-2 font-medium text-gray-600">Nama Sarana/Prasarana</td>
                    <td class="py-2">{{ $transaksi->penyewaan->penyewaanable->nama }}</td>
                </tr>
                <tr>
                    <td class="py-2 font-medium text-gray-600">Jumlah</td>
                    <td class="py-2">{{ $transaksi->jumlah }}</td>
                </tr>
                <tr>
                    <td class="py-2 font-medium text-gray-600">Tanggal Transaksi</td>
                    <td class="py-2">
                        {{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->translatedFormat('d F Y') }}</td>
                </tr>
                <tr>
                    <td class="py-2 font-medium text-gray-600">Tanggal Mulai</td>
                    <td class="py-2">{{ \Carbon\Carbon::parse($transaksi->tanggal_mulai)->translatedFormat('d F Y') }}
                    </td>
                </tr>
                <tr>
                    <td class="py-2 font-medium text-gray-600">Tanggal Selesai</td>
                    <td class="py-2">
                        {{ \Carbon\Carbon::parse($transaksi->tanggal_selesai)->translatedFormat('d F Y') }}</td>
                </tr>
                <tr>
                    <td class="py-2 font-medium text-gray-600">Keterangan</td>
                    <td class="py-2">{{ $transaksi->keterangan ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="py-2 font-medium text-gray-600">Harga Satuan (per hari)</td>
                    <td class="py-2">Rp{{ number_format($transaksi->penyewaan->harga, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="py-2 font-medium text-gray-600">Durasi Peminjaman</td>
                    <td class="py-2">
                        {{ \Carbon\Carbon::parse($transaksi->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($transaksi->tanggal_selesai)) + 1 }}
                        hari
                    </td>
                </tr>
                <tr class="border-t">
                    <td class="py-2 font-semibold text-gray-800">Total Harga</td>
                    <td class="py-2 font-semibold text-gray-800">Rp{{ number_format($transaksi->harga, 0, ',', '.') }}
                    </td>
                </tr>
            </table>
        </div>
        <a href="{{ route('transaksi.download', ['id' => $transaksi->id]) }}"
            class="mt-4 inline-block bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-6 rounded-lg shadow-xl">
            Unduh Detail Transaksi
        </a>
        <a href="{{ route('home') }}"
            class="mt-8 inline-block bg-[#3A3A3A] hover:bg-black text-white font-semibold py-3 px-6 rounded-lg shadow-xl">Kembali
            ke Beranda</a>
    </div>
</body>

</html>
