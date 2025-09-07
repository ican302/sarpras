@if (Auth::check())
    <div class="flex flex-row justify-end gap-2">
        @if (Auth::user()->role === 'Admin' || Auth::user()->role === 'User')
            <a href="{{ route('tanah.download.all') }}"
                class="flex items-center px-4 py-2 text-white bg-emerald-700 hover:bg-emerald-800 rounded-lg text-sm shadow-lg whitespace-nowrap">
                <i class="fas fa-file-excel text-white mr-2"></i>
                Export ke Excel
            </a>
        @endif
        @if (Auth::user()->role === 'Admin')
            <button
                class="inline-flex items-center px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white text-sm font-medium rounded-lg shadow-lg transition whitespace-nowrap"
                onclick="tambah_tanah.showModal()">
                <i class="fas fa-plus mr-2"></i>
                Tambah
            </button>
        @endif
    </div>
@endif
<div class="bg-white rounded shadow-lg overflow-x-auto mt-4">
    <div class="max-h-[500px] overflow-y-auto">
        <table class="min-w-full text-sm text-nowrap text-gray-700">
            <thead class="bg-[#3A3A3A] sticky top-0 z-10 text-white text-sm">
                <tr>
                    <th class="px-6 py-2 text-center border border-gray-300 align-middle" rowspan="3">No</th>
                    <th class="px-6 py-2 text-center border border-gray-300 align-middle" rowspan="3">
                        Nama/Jenis Tanah
                    </th>
                    <th class="px-6 py-2 text-center border border-gray-300" colspan="2">Nomor</th>
                    <th class="px-6 py-2 text-center border border-gray-300 align-middle" rowspan="3">Luas (M2)</th>
                    <th class="px-6 py-2 text-center border border-gray-300 align-middle" rowspan="3">
                        Tahun Pengadaan
                    </th>
                    <th class="px-6 py-2 text-center border border-gray-300 align-middle" rowspan="3">Lokasi</th>
                    <th class="px-6 py-2 text-center border border-gray-300" colspan="3">Status Tanah</th>
                    <th class="px-6 py-2 text-center border border-gray-300 align-middle" rowspan="3">Penggunaan</th>
                    <th class="px-6 py-2 text-center border border-gray-300 align-middle" rowspan="3">Asal-Usul</th>
                    <th class="px-6 py-2 text-center border border-gray-300 align-middle" rowspan="3">Harga</th>
                    <th class="px-6 py-2 text-center border border-gray-300 align-middle" rowspan="3">Keterangan</th>
                    <th class="px-6 py-2 text-center border border-gray-300 align-middle" rowspan="3">
                        Pemeliharaan
                    </th>
                    @if (Auth::check())
                        @if (Auth::user()->role === 'Admin')
                            <th class="px-6 py-2 text-center border border-gray-300 align-middle" rowspan="3">Aksi
                            </th>
                        @endif
                    @endif
                </tr>
                <tr>
                    <th class="px-6 py-2 border border-gray-300 align-middle" rowspan="2">Kode Tanah</th>
                    <th class="px-6 py-2 border border-gray-300 align-middle" rowspan="2">Register</th>
                    <th class="px-6 py-2 border border-gray-300 align-middle" rowspan="2">Hak</th>
                    <th class="px-6 py-2 border border-gray-300 text-center" colspan="2">Sertifikat</th>
                </tr>
                <tr>
                    <th class="px-6 py-2 border border-gray-300 text-center">Tanggal</th>
                    <th class="px-6 py-2 border border-gray-300 text-center">Nomor</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($tanahs as $index => $tanah)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-2 border border-gray-300">{{ $index + 1 }}</td>
                        <td class="px-6 py-2 border border-gray-300">{{ $tanah->nama }}</td>
                        <td class="px-6 py-2 border border-gray-300">{{ $tanah->kode }}</td>
                        <td class="px-6 py-2 border border-gray-300">{{ $tanah->nomor_register }}</td>
                        <td class="px-6 py-2 border border-gray-300">{{ $tanah->luas }}</td>
                        <td class="px-6 py-2 border border-gray-300">{{ $tanah->tahun_pengadaan }}</td>
                        <td class="px-6 py-2 border border-gray-300">{{ $tanah->lokasi }}</td>
                        <td class="px-6 py-2 border border-gray-300">{{ $tanah->status_tanah }}</td>
                        <td class="px-6 py-2 border border-gray-300">{{ $tanah->tanggal }}</td>
                        <td class="px-6 py-2 border border-gray-300">{{ $tanah->nomor }}</td>
                        <td class="px-6 py-2 border border-gray-300">{{ $tanah->penggunaan }}</td>
                        <td class="px-6 py-2 border border-gray-300">{{ $tanah->asal_usul }}</td>
                        <td class="px-6 py-2 border border-gray-300">
                            Rp {{ number_format($tanah->harga, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-2 border border-gray-300">
                            <div class="flex space-x-2">
                                <button
                                    class="flex items-center px-3 py-1.5 text-sm text-white bg-blue-700 rounded-md hover:bg-blue-800 transition"
                                    onclick="lihat_keterangan_{{ $tanah->id }}.showModal()">
                                    <i class="fas fa-eye mr-2"></i>Lihat
                                </button>
                            </div>
                        </td>
                        <td class="px-6 py-2 border border-gray-300">
                            <div class="flex space-x-2">
                                <button
                                    class="flex items-center px-3 py-1.5 text-sm text-white bg-blue-700 rounded-md hover:bg-blue-800 transition"
                                    onclick="lihat_pemeliharaan_{{ $tanah->id }}.showModal()">
                                    <i class="fas fa-eye mr-2"></i>Lihat
                                </button>
                            </div>
                        </td>
                        @if (Auth::check())
                            @if (Auth::user()->role === 'Admin')
                                <td class="px-6 py-2 border border-gray-300">
                                    <div class="flex space-x-2">
                                        <button
                                            class="flex items-center px-3 py-1.5 text-sm text-white bg-amber-500 rounded-md hover:bg-amber-600 transition"
                                            onclick="ubah_tanah_{{ $tanah->id }}.showModal()">
                                            <i class="fas fa-edit mr-2"></i>Ubah
                                        </button>
                                        <button
                                            class="flex items-center px-3 py-1.5 text-sm text-white bg-red-600 rounded-md hover:bg-red-700 transition"
                                            onclick="hapus_tanah_{{ $tanah->id }}.showModal()">
                                            <i class="fas fa-trash-alt mr-2"></i>Hapus
                                        </button>
                                    </div>
                                </td>
                            @endif
                        @endif
                    </tr>

                    <!-- Ubah Modal -->
                    <dialog id="ubah_tanah_{{ $tanah->id }}" class="modal modal-middle">
                        <div class="modal-box max-w-md w-full">
                            <h3 class="text-xl font-semibold text-gray-800">Ubah Tanah</h3>
                            <hr class="border-gray-800 border-1 my-4">
                            <form action="{{ route('tanah.update', $tanah->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-6">
                                    <label for="nama" class="block mb-2 text-sm font-medium text-gray-700">
                                        Nama Tanah
                                    </label>
                                    <input type="text" name="nama" id="nama" class="custom-input"
                                        value="{{ $tanah->nama }}" required
                                        oninvalid="this.setCustomValidity('Kolom ini harus diisi')"
                                        oninput="this.setCustomValidity('')">
                                </div>
                                <div class="mb-6">
                                    <label for="kode" class="block mb-2 text-sm font-medium text-gray-700">
                                        Kode Tanah
                                    </label>
                                    <input type="text" name="kode" id="kode" class="custom-input"
                                        value="{{ $tanah->kode }}">
                                </div>
                                <div class="mb-6">
                                    <label for="nomor_register" class="block mb-2 text-sm font-medium text-gray-700">
                                        Nomor Register
                                    </label>
                                    <input type="text" name="nomor_register" id="nomor_register"
                                        class="custom-input" value="{{ $tanah->nomor_register }}">
                                </div>
                                <div class="mb-6">
                                    <label for="luas" class="block mb-2 text-sm font-medium text-gray-700">
                                        Luas (M2)
                                    </label>
                                    <input type="text" name="luas" id="luas" class="custom-input"
                                        value="{{ $tanah->luas }}">
                                </div>
                                <div class="mb-6">
                                    <label for="tahun_pengadaan" class="block mb-2 text-sm font-medium text-gray-700">
                                        Tahun Pengadaaan
                                    </label>
                                    <input type="text" name="tahun_pengadaan" id="tahun_pengadaan"
                                        class="custom-input" value="{{ $tanah->tahun_pengadaan }}">
                                </div>
                                <div class="mb-6">
                                    <label for="lokasi" class="block mb-2 text-sm font-medium text-gray-700">
                                        Lokasi
                                    </label>
                                    <input type="text" name="lokasi" id="lokasi" class="custom-input"
                                        value="{{ $tanah->lokasi }}">
                                </div>
                                <div class="mb-6">
                                    <label for="status_tanah"
                                        class="block mb-2 text-sm font-medium text-gray-700">Hak</label>
                                    <select name="status_tanah" id="status_tanah" class="custom-input">
                                        <option class="text-center" disabled
                                            {{ old('status_tanah') ? '' : 'selected' }}>-- Pilih Status --
                                        </option>
                                        @foreach (['Hak Milik', 'Hak Guna Bangunan', 'Hak Guna Usaha', 'Hak Pakai', 'Hak Pengelolaan', 'Tanah Girik', 'Tanah Terlantar'] as $status)
                                            <option value="{{ $status }}"
                                                {{ old('status_tanah') == $status ? 'selected' : '' }}>
                                                {{ $status }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-6">
                                    <label for="tanggal" class="block mb-2 text-sm font-medium text-gray-700">
                                        Tanggal
                                    </label>
                                    <input type="date" name="tanggal" id="tanggal" class="custom-input"
                                        value="{{ $tanah->tanggal }}">
                                </div>
                                <div class="mb-6">
                                    <label for="nomor" class="block mb-2 text-sm font-medium text-gray-700">
                                        Nomor
                                    </label>
                                    <input type="text" name="nomor" id="nomor" class="custom-input"
                                        value="{{ $tanah->nomor }}">
                                </div>
                                <div class="mb-6">
                                    <label for="penggunaan" class="block mb-2 text-sm font-medium text-gray-700">
                                        Penggunaan
                                    </label>
                                    <input type="text" name="penggunaan" id="penggunaan" class="custom-input"
                                        value="{{ $tanah->penggunaan }}">
                                </div>
                                <div class="mb-6">
                                    <label for="asal_usul" class="block mb-2 text-sm font-medium text-gray-700">
                                        Asal Usul
                                    </label>
                                    <input type="text" name="asal_usul" id="asal_usul" class="custom-input"
                                        value="{{ $tanah->asal_usul }}">
                                </div>
                                <div class="mb-6">
                                    <label for="harga" class="block mb-2 text-sm font-medium text-gray-700">
                                        Harga
                                    </label>
                                    <input type="number" name="harga" id="harga" class="custom-input"
                                        value="{{ $tanah->harga }}">
                                </div>
                                <div class="mb-6">
                                    <label for="keterangan" class="block mb-2 text-sm font-medium text-gray-700">
                                        Keterangan
                                    </label>
                                    <input type="text" name="keterangan" id="keterangan" class="custom-input"
                                        value="{{ $tanah->keterangan }}">
                                </div>
                                <div class="mb-6">
                                    <label for="pemeliharaan" class="block mb-2 text-sm font-medium text-gray-700">
                                        Pemeliharaan
                                    </label>
                                    <input type="text" name="pemeliharaan" id="pemeliharaan" class="custom-input"
                                        value="{{ $tanah->pemeliharaan }}">
                                </div>
                                <div class="flex justify-end gap-2 mt-6">
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-blue-700 text-white text-sm font-semibold rounded-md hover:bg-blue-800 transition">
                                        <i class="fas fa-save mr-2"></i>Simpan
                                    </button>
                                    <button type="button"
                                        onclick="document.getElementById('ubah_tanah_{{ $tanah->id }}').close()"
                                        class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 text-sm font-semibold rounded-md hover:bg-gray-400 transition">
                                        <i class="fas fa-times mr-2"></i>Tutup
                                    </button>
                                </div>
                            </form>
                        </div>
                    </dialog>
                    <!-- Lihat Keterangan Modal -->
                    <dialog id="lihat_keterangan_{{ $tanah->id }}" class="modal modal-middle">
                        <div class="modal-box max-w-md w-full">
                            <h3 class="text-xl font-semibold mb-4">Keterangan</h3>
                            <div class="space-y-3 text-gray-700 text-sm">
                                <div class="bg-gray-100 py-2 rounded">
                                    @if (!empty($tanah->keterangan))
                                        {{ $tanah->keterangan }}
                                    @else
                                        <span class="italic text-gray-500">Tidak Ada Keterangan</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex justify-end mt-6">
                                <button type="button"
                                    onclick="document.getElementById('lihat_keterangan_{{ $tanah->id }}').close()"
                                    class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 text-sm font-semibold rounded-md hover:bg-gray-400 transition">
                                    <i class="fas fa-times mr-2"></i>Tutup
                                </button>
                            </div>
                        </div>
                    </dialog>
                    <!-- Lihat Pemeliharaan Modal -->
                    <dialog id="lihat_pemeliharaan_{{ $tanah->id }}" class="modal modal-middle">
                        <div class="modal-box max-w-md w-full">
                            <h3 class="text-xl font-semibold mb-4">Pemeliharaan</h3>
                            <div class="space-y-3 text-gray-700 text-sm">
                                <div class="bg-gray-100 py-2 rounded">
                                    @if (!empty($tanah->pemeliharaan))
                                        {{ $tanah->pemeliharaan }}
                                    @else
                                        <span class="italic text-gray-500">Tidak Ada Pemeliharaan</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex justify-end mt-6">
                                <button type="button"
                                    onclick="document.getElementById('lihat_pemeliharaan_{{ $tanah->id }}').close()"
                                    class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 text-sm font-semibold rounded-md hover:bg-gray-400 transition">
                                    <i class="fas fa-times mr-2"></i>Tutup
                                </button>
                            </div>
                        </div>
                    </dialog>
                    <!-- Hapus Modal -->
                    <dialog id="hapus_tanah_{{ $tanah->id }}" class="modal modal-middle">
                        <div class="modal-box max-w-md w-full">
                            <h3 class="text-xl font-semibold text-red-600 mb-4">Konfirmasi Hapus</h3>
                            <p class="text-gray-700 mb-6">
                                Apakah Anda yakin ingin menghapus <span class="font-bold">{{ $tanah->nama }}</span>?
                                Tindakan ini tidak dapat dibatalkan.
                            </p>
                            <form action="{{ route('tanah.destroy', $tanah->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="flex justify-end gap-2">
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-md hover:bg-red-700 transition">
                                        <i class="fas fa-trash-alt mr-2"></i>Hapus
                                    </button>
                                    <button type="button"
                                        onclick="document.getElementById('hapus_tanah_{{ $tanah->id }}').close()"
                                        class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 text-sm font-semibold rounded-md hover:bg-gray-400 transition">
                                        <i class="fas fa-times mr-2"></i>Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </dialog>
                @empty
                    <tr>
                        <td colspan="16" class="text-center py-4 text-gray-500">Tidak ada data tanah</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<!-- Tambah Modal -->
<dialog id="tambah_tanah" class="modal modal-middle">
    <div class="modal-box max-w-md w-full">
        <h3 class="text-xl font-semibold text-gray-800">Tambah Tanah</h3>
        <hr class="border-gray-800 border-1 my-4">
        <form action="{{ route('tanah.store') }}" method="POST">
            @csrf
            <div class="mb-6">
                <label for="nama" class="block mb-2 text-sm font-medium text-gray-700">
                    Nama Tanah
                </label>
                <input type="text" name="nama" id="nama" class="custom-input" required
                    oninvalid="this.setCustomValidity('Kolom ini harus diisi')" oninput="this.setCustomValidity('')"
                    value="{{ old('nama') }}">
            </div>
            <div class="mb-6">
                <label for="kode" class="block mb-2 text-sm font-medium text-gray-700">
                    Kode Tanah
                </label>
                <input type="text" name="kode" id="kode" class="custom-input"
                    value="{{ old('kode') }}">
            </div>
            <div class="mb-6">
                <label for="nomor_register" class="block mb-2 text-sm font-medium text-gray-700">
                    Nomor Register
                </label>
                <input type="text" name="nomor_register" id="nomor_register" class="custom-input"
                    value="{{ old('nomor_register') }}">
            </div>
            <div class="mb-6">
                <label for="luas" class="block mb-2 text-sm font-medium text-gray-700">
                    Luas (M2)
                </label>
                <input type="text" name="luas" id="luas" class="custom-input"
                    value="{{ old('luas') }}">
            </div>
            <div class="mb-6">
                <label for="tahun_pengadaan" class="block mb-2 text-sm font-medium text-gray-700">
                    Tahun Pengadaaan
                </label>
                <input type="text" name="tahun_pengadaan" id="tahun_pengadaan" class="custom-input"
                    value="{{ old('tahun_pengadaan') }}">
            </div>
            <div class="mb-6">
                <label for="lokasi" class="block mb-2 text-sm font-medium text-gray-700">
                    Lokasi
                </label>
                <input type="text" name="lokasi" id="lokasi" class="custom-input"
                    value="{{ old('lokasi') }}">
            </div>
            <div class="mb-6">
                <label for="status_tanah" class="block mb-2 text-sm font-medium text-gray-700">
                    Status Tanah
                </label>
                <select name="status_tanah" id="status_tanah" class="custom-input">
                    <option class="text-center" value="" disabled selected>-- Pilih Status --</option>
                    <option value="Hak Milik">Hak Milik</option>
                    <option value="Hak Guna Bangunan">Hak Guna Bangunan</option>
                    <option value="Hak Guna Usaha">Hak Guna Usaha</option>
                    <option value="Hak Pakai">Hak Pakai</option>
                    <option value="Hak Pengelolaan">Hak Pengelolaan</option>
                    <option value="Tanah Girik">Tanah Girik</option>
                    <option value="Tanah Terlantar">Tanah Terlantar</option>
                </select>
            </div>
            <div class="mb-6">
                <label for="tanggal" class="block mb-2 text-sm font-medium text-gray-700">
                    Tanggal
                </label>
                <input type="date" name="tanggal" id="tanggal" class="custom-input"
                    value="{{ old('tanggal') }}">
            </div>
            <div class="mb-6">
                <label for="nomor" class="block mb-2 text-sm font-medium text-gray-700">
                    Nomor
                </label>
                <input type="text" name="nomor" id="nomor" class="custom-input"
                    value="{{ old('nomor') }}">
            </div>
            <div class="mb-6">
                <label for="penggunaan" class="block mb-2 text-sm font-medium text-gray-700">
                    Penggunaan
                </label>
                <input type="text" name="penggunaan" id="penggunaan" class="custom-input"
                    value="{{ old('penggunaan') }}">
            </div>
            <div class="mb-6">
                <label for="asal_usul" class="block mb-2 text-sm font-medium text-gray-700">
                    Asal Usul
                </label>
                <input type="text" name="asal_usul" id="asal_usul" class="custom-input"
                    value="{{ old('asal_usul') }}">
            </div>
            <div class="mb-6">
                <label for="harga" class="block mb-2 text-sm font-medium text-gray-700">
                    Harga
                </label>
                <input type="number" name="harga" id="harga" class="custom-input"
                    value="{{ old('harga') }}">
            </div>
            <div class="mb-6">
                <label for="keterangan" class="block mb-2 text-sm font-medium text-gray-700">
                    Keterangan
                </label>
                <input type="text" name="keterangan" id="keterangan" class="custom-input"
                    value="{{ old('keterangan') }}">
            </div>
            <div class="mb-6">
                <label for="pemeliharaan" class="block mb-2 text-sm font-medium text-gray-700">
                    Pemeliharaan
                </label>
                <input type="text" name="pemeliharaan" id="pemeliharaan" class="custom-input"
                    value="{{ old('pemeliharaan') }}">
            </div>
            <div class="flex justify-end gap-2 mt-6">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-blue-700 text-white text-sm font-semibold rounded-md hover:bg-blue-800 transition">
                    <i class="fas fa-save mr-2"></i>Simpan
                </button>
                <button type="button" onclick="document.getElementById('tambah_tanah').close()"
                    class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 text-sm font-semibold rounded-md hover:bg-gray-400 transition">
                    <i class="fas fa-times mr-2"></i>Tutup
                </button>
            </div>
        </form>
    </div>
</dialog>
