<div class="flex flex-col gap-4">
    {{-- Form Pencarian --}}
    <form method="GET" action="{{ route('laporan.index') }}" class="flex flex-wrap items-end gap-2">
        <div class="flex flex-col">
            <input type="text" name="search" id="search" value="{{ request('search') }}" class="custom-input max-w-xs"
                placeholder="Cari Transaksi">
        </div>
        <button type="submit"
            class="px-4 py-2 text-white bg-black rounded-md shadow hover:bg-gray-900 transition h-[2.58rem]">
            Cari
        </button>
    </form>
    {{-- Form Filter + Tombol Download --}}
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6">
        {{-- Form Filter Tanggal --}}
        <form method="GET" action="{{ route('laporan.index') }}" class="flex flex-wrap gap-4 items-end">
            <div class="flex flex-col">
                <label for="day" class="text-sm font-medium text-gray-700">Tanggal</label>
                <select name="day" id="day" class="custom-input" style="width: 65px !important;">
                    <option value="">--</option>
                    @for ($i = 1; $i <= 31; $i++)
                        <option value="{{ $i }}" {{ request('day') == $i ? 'selected' : '' }}>
                            {{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="flex flex-col">
                <label for="month" class="text-sm font-medium text-gray-700">Bulan</label>
                <select name="month" id="month" class="custom-input" style="width: 135px !important;">
                    <option value="">--</option>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="flex flex-col">
                <label for="year" class="text-sm font-medium text-gray-700">Tahun</label>
                <select name="year" id="year" class="custom-input" style="width: 85px !important;">
                    <option value="">--</option>
                    @for ($i = date('Y'); $i >= 2020; $i--)
                        <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>
                            {{ $i }}</option>
                    @endfor
                </select>
            </div>
            <button type="submit"
                class="px-5 py-2 text-white bg-black rounded-lg shadow hover:bg-gray-900 transition h-[2.58rem]">
                Filter
            </button>
        </form>
        {{-- Tombol PDF & Excel --}}
        <div class="flex gap-2">
            {{-- PDF --}}
            <form action="{{ route('laporan.cetak.pdf') }}" method="GET" target="_blank"
                class="flex gap-2 items-center">
                <input type="hidden" name="day" value="{{ request('day') }}">
                <input type="hidden" name="month" value="{{ request('month') }}">
                <input type="hidden" name="year" value="{{ request('year') }}">
                <button type="submit"
                    class="flex items-center px-4 py-2 text-white bg-red-600 hover:bg-red-700 rounded-lg shadow-lg text-sm">
                    <i class="fas fa-file-pdf text-white mr-2"></i>
                    Download PDF
                </button>
            </form>
            {{-- Excel --}}
            <form action="{{ route('laporan.download.all') }}" method="GET" class="flex gap-2 items-center">
                <input type="hidden" name="day" value="{{ request('day') }}">
                <input type="hidden" name="month" value="{{ request('month') }}">
                <input type="hidden" name="year" value="{{ request('year') }}">
                <button type="submit"
                    class="flex items-center px-4 py-2 text-white bg-emerald-700 hover:bg-emerald-800 rounded-lg shadow-lg text-sm">
                    <i class="fas fa-file-excel text-white mr-2"></i>
                    Download Excel
                </button>
            </form>
        </div>
    </div>
</div>
<div class="bg-white rounded shadow-lg overflow-x-auto mt-4">
    <div class="max-h-[500px] overflow-y-auto">
        <table class="min-w-full text-sm text-nowrap text-gray-700">
            <thead class="bg-black sticky top-0 z-10">
                <tr class="text-left text-white">
                    <th class="px-6 py-3 border border-gray-300">No</th>
                    <th class="px-6 py-3 border border-gray-300">ID Transaksi</th>
                    <th class="px-6 py-3 border border-gray-300">Nama Sarana/Prasarana</th>
                    <th class="px-6 py-3 border border-gray-300">Nama Peminjam</th>
                    <th class="px-6 py-3 border border-gray-300">Jumlah</th>
                    <th class="px-6 py-3 border border-gray-300">Harga</th>
                    <th class="px-6 py-3 border border-gray-300">Tanggal Transaksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($transaksis as $index => $transaksi)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-3 border border-gray-300">{{ $index + 1 }}</td>
                        <td class="px-6 py-3 border border-gray-300">{{ $transaksi->id_transaksi }}</td>
                        <td class="px-6 py-3 border border-gray-300">
                            {{ $transaksi->penyewaan->penyewaanable->nama }}
                        </td>
                        <td class="px-6 py-3 border border-gray-300">{{ $transaksi->peminjam }}</td>
                        <td class="px-6 py-3 border border-gray-300">{{ $transaksi->jumlah }}</td>
                        <td class="px-6 py-3 border border-gray-300">
                            Rp {{ number_format($transaksi->harga, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-3 border border-gray-300">
                            {{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d/m/Y') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="14" class="text-center py-4 text-gray-500">Tidak ada data transaksi</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
