<div class="flex flex-col md:flex-row items-center justify-between gap-2">
    <form method="GET" action="{{ route('transaksi.index') }}" class="flex items-center gap-2 max-w-md w-full md:w-auto">
        <input type="text" name="search" value="{{ request('search') }}" class="custom-input flex-grow"
            placeholder="Cari Transaksi">
        <button type="submit" class="px-4 py-2 text-white bg-black rounded-md shadow-lg whitespace-nowrap">
            Cari
        </button>
    </form>
    <a href="{{ route('transaksi.download.all') }}"
        class="flex items-center px-4 py-2 text-white bg-emerald-700 hover:bg-emerald-800 rounded-lg shadow-lg text-sm whitespace-nowrap mt-4 md:mt-0">
        <i class="fas fa-file-excel text-white mr-2"></i>
        Export ke Excel
    </a>
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
                    <th class="px-6 py-3 border border-gray-300">Tanggal Mulai</th>
                    <th class="px-6 py-3 border border-gray-300">Tanggal Selesai</th>
                    <th class="px-6 py-3 border border-gray-300">No. WhatsApp</th>
                    <th class="px-6 py-3 border border-gray-300">Keterangan</th>
                    @if (Auth::check())
                        @if (Auth::user()->role === 'Admin')
                            <th class="px-6 py-3 border border-gray-300">Aksi</th>
                        @endif
                    @endif
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
                        <td class="px-6 py-3 border border-gray-300">
                            {{ \Carbon\Carbon::parse($transaksi->tanggal_mulai)->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-3 border border-gray-300">
                            {{ \Carbon\Carbon::parse($transaksi->tanggal_selesai)->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-3 border border-gray-300">{{ $transaksi->no_wa }}</td>
                        <td class="px-6 py-3 border border-gray-300">
                            <button
                                class="flex items-center px-3 py-1.5 text-sm text-white bg-blue-700 rounded-md hover:bg-blue-800 transition"
                                onclick="lihat_keterangan_{{ $transaksi->id }}.showModal()">
                                <i class="fas fa-eye mr-2"></i>
                                Lihat
                            </button>
                        </td>
                        @if (Auth::check())
                            @if (Auth::user()->role === 'Admin')
                                <td class="px-6 py-3 border border-gray-300">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('transaksi.download', $transaksi->id) }}"
                                            class="flex items-center px-3 py-1.5 text-sm text-white bg-emerald-700 rounded-md hover:bg-emerald-800 transition">
                                            <i class="fas fa-download mr-2"></i>
                                            Download
                                        </a>
                                        <button
                                            class="flex items-center px-3 py-1.5 text-sm text-white bg-amber-500 rounded-md hover:bg-amber-600 transition"
                                            onclick="ubah_transaksi_{{ $transaksi->id }}.showModal()">
                                            <i class="fas fa-edit mr-2"></i>Ubah
                                        </button>
                                        <button
                                            class="flex items-center px-3 py-1.5 text-sm text-white bg-red-600 rounded-md hover:bg-red-700 transition"
                                            onclick="hapus_transaksi_{{ $transaksi->id }}.showModal()">
                                            <i class="fas fa-trash-alt mr-2"></i>
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            @endif
                        @endif
                    </tr>

                    <!-- Modal Lihat Keterangan -->
                    <dialog id="lihat_keterangan_{{ $transaksi->id }}" class="modal modal-middle">
                        <div class="modal-box max-w-md w-full">
                            <h3 class="text-xl font-semibold mb-4">Keterangan</h3>
                            <div class="space-y-3 text-gray-700 text-sm">
                                <div class="bg-gray-100 py-2 rounded">
                                    <p class="px-3 py-1">
                                        @if (!empty($transaksi->keterangan))
                                            {{ $transaksi->keterangan }}
                                        @else
                                            <span class="italic text-gray-500">Tidak Ada Keterangan</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="flex justify-end mt-6">
                                <button type="button"
                                    onclick="document.getElementById('lihat_keterangan_{{ $transaksi->id }}').close()"
                                    class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 text-sm font-semibold rounded-md hover:bg-gray-400 transition">
                                    <i class="fas fa-times mr-2"></i>Tutup
                                </button>
                            </div>
                        </div>
                    </dialog>
                    <!-- Ubah Modal -->
                    <dialog id="ubah_transaksi_{{ $transaksi->id }}" class="modal modal-middle">
                        <div class="modal-box max-w-md w-full">
                            <h3 class="text-xl font-semibold text-gray-800">Ubah Transaksi</h3>
                            <hr class="border-gray-800 border-1 my-4">
                            <form action="{{ route('transaksi.update', $transaksi->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="dropdown w-full relative mb-6">
                                    <label for="penyewaan_id" class="block mb-2 text-sm font-medium text-black">
                                        Nama Sarana/Prasarana
                                    </label>
                                    <div id="dropdownButtonPenyewaan_{{ $transaksi->id }}"
                                        class="custom-input cursor-pointer relative flex justify-between items-center px-4 py-2 border border-gray-300 rounded-md bg-white"
                                        onclick="toggleDropdown('dropdownMenuPenyewaan_{{ $transaksi->id }}')">
                                        <span class="text-sm py-[0.23rem] text-gray-700"
                                            id="selectedTextPenyewaan_{{ $transaksi->id }}">
                                            {{ $transaksi->penyewaan->nama ?? '-- Pilih Sarana/Prasarana --' }}
                                            @if ($transaksi->penyewaan)
                                                (Stok: {{ $transaksi->penyewaan->jumlah }})
                                            @endif
                                        </span>
                                        <i class="fas fa-chevron-down ml-2 text-gray-500"></i>
                                    </div>
                                    <div id="dropdownMenuPenyewaan_{{ $transaksi->id }}"
                                        class="dropdown-menu absolute z-10 mt-1 w-full bg-white border border-gray-200 rounded-md shadow-lg"
                                        style="display: none;">
                                        @foreach ($penyewaans as $index => $penyewaan)
                                            @php
                                                $isFirst = $loop->first;
                                                $isLast = $loop->last;
                                                $roundedClass = '';
                                                if ($isFirst) {
                                                    $roundedClass .= ' hover:rounded-t-md';
                                                }
                                                if ($isLast) {
                                                    $roundedClass .= ' hover:rounded-b-md';
                                                }
                                            @endphp
                                            <div class="dropdown-item text-sm px-4 py-2 hover:bg-gray-100 cursor-pointer{{ $roundedClass }}"
                                                onclick="selectOption('{{ $penyewaan->id }}', 'dropdownButtonPenyewaan_{{ $transaksi->id }}', 'penyewaan_id_{{ $transaksi->id }}', '{{ $penyewaan->nama }} (Stok: {{ $penyewaan->jumlah }})', 'selectedTextPenyewaan_{{ $transaksi->id }}')">
                                                {{ $penyewaan->nama }} (Stok: {{ $penyewaan->jumlah }})
                                            </div>
                                        @endforeach
                                    </div>
                                    <input type="hidden" name="penyewaan_id" id="penyewaan_id_{{ $transaksi->id }}"
                                        value="{{ $transaksi->penyewaan_id }}">
                                    <small id="error-penyewaan" class="text-red-500 text-sm hidden">
                                        Silakan pilih salah satu sarana atau prasarana terlebih dahulu
                                    </small>
                                </div>
                                <div class="mb-6">
                                    <label for="peminjam" class="block mb-2 text-sm font-medium text-gray-700">
                                        Nama Peminjam
                                    </label>
                                    <input type="text" name="peminjam" id="peminjam" class="custom-input"
                                        value="{{ $transaksi->peminjam }}" required
                                        oninvalid="this.setCustomValidity('Kolom ini harus diisi')"
                                        oninput="this.setCustomValidity('')">
                                </div>
                                <div class="mb-6">
                                    <label for="jumlah" class="block mb-2 text-sm font-medium text-gray-700">
                                        Jumlah
                                    </label>
                                    <input type="number" name="jumlah" id="jumlah" min="1"
                                        class="custom-input" value="{{ $transaksi->jumlah }}" required
                                        oninvalid="this.setCustomValidity('Kolom ini harus diisi')"
                                        oninput="this.setCustomValidity('')">
                                </div>
                                <div class="mb-6">
                                    <label for="no_wa" class="block mb-2 text-sm font-medium text-gray-700">
                                        Nomor WhatsApp
                                    </label>
                                    <input type="text" name="no_wa" id="no_wa" placeholder="08xxxxxxxxxx"
                                        class="custom-input" value="{{ $transaksi->no_wa }}" required
                                        oninvalid="this.setCustomValidity('Kolom ini harus diisi')"
                                        oninput="this.setCustomValidity('')">
                                </div>
                                <div class="mb-6">
                                    <label for="tanggal_transaksi"
                                        class="block mb-2 text-sm font-medium text-gray-700">
                                        Tanggal Transaksi
                                    </label>
                                    <input type="date" name="tanggal_transaksi" id="tanggal_transaksi"
                                        class="custom-input"
                                        value="{{ old('tanggal_transaksi', \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('Y-m-d')) }}" "
                                        required oninvalid="this.setCustomValidity('Kolom ini harus diisi')"
                                        oninput="this.setCustomValidity('')">
                                </div>
                                <div class="mb-6">
                                    <label for="tanggal_mulai" class="block mb-2 text-sm font-medium text-gray-700">
                                        Tanggal Mulai
                                    </label>
                                    <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                                        class="custom-input" value="{{ $transaksi->tanggal_mulai }}" required
                                        oninvalid="this.setCustomValidity('Kolom ini harus diisi')"
                                        oninput="this.setCustomValidity('')">
                                </div>
                                <div class="mb-6">
                                    <label for="tanggal_selesai" class="block mb-2 text-sm font-medium text-gray-700">
                                        Tanggal Selesai
                                    </label>
                                    <input type="date" name="tanggal_selesai" id="tanggal_selesai"
                                        class="custom-input" value="{{ $transaksi->tanggal_selesai }}" required
                                        oninvalid="this.setCustomValidity('Kolom ini harus diisi')"
                                        oninput="this.setCustomValidity('')">
                                </div>
                                <div class="mb-6">
                                    <label for="keterangan" class="block mb-2 text-sm font-medium text-gray-700">
                                        Keterangan
                                    </label>
                                    <textarea name="keterangan" id="keterangan" rows="4" class="custom-input"
                                        value="{{ $transaksi->keterangan }}"></textarea>
                                </div>
                                <div class="flex justify-end gap-2 mt-6">
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-emerald-700 text-white text-sm font-semibold rounded-md hover:bg-emerald-800 transition">
                                        <i class="fas fa-save mr-2"></i>Simpan
                                    </button>
                                    <button type="button"
                                        onclick="document.getElementById('ubah_transaksi_{{ $transaksi->id }}').close()"
                                        class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 text-sm font-semibold rounded-md hover:bg-gray-400 transition">
                                        <i class="fas fa-times mr-2"></i>Tutup
                                    </button>
                                </div>
                            </form>
                        </div>
                    </dialog>
                    <!-- Modal Hapus -->
                    <dialog id="hapus_transaksi_{{ $transaksi->id }}" class="modal modal-middle">
                        <div class="modal-box max-w-md w-full">
                            <h3 class="text-xl font-semibold text-red-600 mb-4">Konfirmasi Hapus</h3>
                            <p class="text-gray-700 mb-6">
                                Apakah Anda yakin ingin menghapus <span
                                    class="font-bold">{{ $transaksi->id_transaksi }}</span>?
                                Tindakan ini tidak dapat dibatalkan.
                            </p>
                            <form action="{{ route('transaksi.destroy', $transaksi->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="flex justify-end gap-2">
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-md hover:bg-red-700 transition">
                                        <i class="fas fa-trash-alt mr-2"></i>Hapus
                                    </button>
                                    <button type="button"
                                        onclick="document.getElementById('hapus_transaksi_{{ $transaksi->id }}').close()"
                                        class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 text-sm font-semibold rounded-md hover:bg-gray-400 transition">
                                        <i class="fas fa-times mr-2"></i>Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </dialog>
    @empty
                    <tr>
                        <td colspan="14" class="text-center py-4 text-gray-500">Tidak ada data transaksi</td>
                    </tr>
 @endforelse
            </tbody>
        </table>
    </div>
</div>
