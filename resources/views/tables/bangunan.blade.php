<div class="flex flex-col md:flex-row items-start md:items-center justify-end gap-2">
    @if (Auth::check())
        @if (Auth::user()->role === 'Admin' || Auth::user()->role === 'User')
            <a href="{{ route('bangunan.download.all') }}"
                class="flex items-center px-4 py-2 text-white bg-emerald-700 hover:bg-emerald-800 rounded-lg text-sm shadow-lg whitespace-nowrap">
                <i class="fas fa-file-excel text-white mr-2"></i>
                Export ke Excel
            </a>
        @endif
        @if (Auth::user()->role === 'Admin')
            <button
                class="inline-flex items-center px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white text-sm font-medium rounded-lg shadow-lg transition whitespace-nowrap"
                onclick="tambah_gedung_bangunan.showModal()">
                <i class="fas fa-plus mr-2"></i>
                Tambah
            </button>
        @endif
    @endif
</div>
<div class="bg-white rounded shadow-lg overflow-x-auto mt-4">
    <div class="max-h-[500px] overflow-y-auto">
        <table class="min-w-full text-sm text-nowrap text-gray-700">
            <thead class="bg-[#3A3A3A] sticky top-0 z-10 text-white">
                <tr class="text-left">
                    <th class="px-6 py-2 align-middle text-center border border-gray-300" rowspan="2">No</th>
                    <th class="px-6 py-2 align-middle text-center border border-gray-300" rowspan="2">
                        Nama/Jenis Bangunan
                    </th>
                    <th class="px-6 py-2 text-center border border-gray-300" colspan="2">Nomor</th>
                    <th class="px-6 py-2 align-middle text-center border border-gray-300" rowspan="2">Kondisi</th>
                    <th class="px-6 py-2 text-center border border-gray-300" colspan="2">Konstruksi Bangunan</th>
                    <th class="px-6 py-2 align-middle text-center border border-gray-300" rowspan="2">Luas Lantai
                        (M2)</th>
                    <th class="px-6 py-2 align-middle text-center border border-gray-300" rowspan="2">Lokasi</th>
                    <th class="px-6 py-2 text-center border border-gray-300" colspan="2">Dokumen Gedung</th>
                    <th class="px-6 py-2 align-middle text-center border border-gray-300" rowspan="2">Luas (M2)</th>
                    <th class="px-6 py-2 align-middle text-center border border-gray-300" rowspan="2">Status Tanah
                    </th>
                    <th class="px-6 py-2 align-middle text-center border border-gray-300" rowspan="2">
                        Nomor Kode Tanah
                    </th>
                    <th class="px-6 py-2 align-middle text-center border border-gray-300" rowspan="2">Asal Usul</th>
                    <th class="px-6 py-2 align-middle text-center border border-gray-300" rowspan="2">Harga</th>
                    <th class="px-6 py-2 align-middle text-center border border-gray-300" rowspan="2">Keterangan</th>
                    <th class="px-6 py-2 align-middle text-center border border-gray-300" rowspan="2">
                        Pemeliharaan
                    </th>
                    @if (Auth::check())
                        @if (Auth::user()->role === 'Admin')
                            <th class="px-6 py-2 align-middle text-center border border-gray-300" rowspan="2">
                                Aksi
                            </th>
                        @endif
                    @endif
                </tr>
                <tr class="text-left">
                    <th class="px-6 py-2 border border-gray-300">Kode Bangunan</th>
                    <th class="px-6 py-2 border border-gray-300">Register</th>
                    <th class="px-6 py-2 border border-gray-300">Bertingkat/Tidak</th>
                    <th class="px-6 py-2 border border-gray-300">Beton/Tidak</th>
                    <th class="px-6 py-2 border border-gray-300">Nomor</th>
                    <th class="px-6 py-2 border border-gray-300">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($bangunans as $index => $bangunan)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-2 border border-gray-300">{{ $index + 1 }}</td>
                        <td class="px-6 py-2 border border-gray-300">{{ $bangunan->nama_bangunan }}</td>
                        <td class="px-6 py-2 border border-gray-300">{{ $bangunan->kode_bangunan }}</td>
                        <td class="px-6 py-2 border border-gray-300">{{ $bangunan->nomor_register }}</td>
                        <td class="px-6 py-2 border border-gray-300">{{ $bangunan->kondisi }}</td>
                        <td class="px-6 py-2 border border-gray-300">{{ $bangunan->bertingkat }}</td>
                        <td class="px-6 py-2 border border-gray-300">{{ $bangunan->beton }}</td>
                        <td class="px-6 py-2 border border-gray-300">{{ $bangunan->luas_lantai }}</td>
                        <td class="px-6 py-2 border border-gray-300">{{ $bangunan->lokasi }}</td>
                        <td class="px-6 py-2 border border-gray-300">{{ $bangunan->nomor }}</td>
                        <td class="px-6 py-2 border border-gray-300">
                            {{ $bangunan->tanggal ? \Carbon\Carbon::parse($bangunan->tanggal)->format('d-m-Y') : '-' }}
                        </td>
                        <td class="px-6 py-2 border border-gray-300">{{ $bangunan->luas }}</td>
                        <td class="px-6 py-2 border border-gray-300">{{ $bangunan->status_tanah }}</td>
                        <td class="px-6 py-2 border border-gray-300">{{ $bangunan->kode_tanah }}</td>
                        <td class="px-6 py-2 border border-gray-300">{{ $bangunan->asal_usul }}</td>
                        <td class="px-6 py-2 border border-gray-300">
                            Rp {{ number_format($bangunan->harga, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-2 border border-gray-300">
                            <button
                                class="flex items-center px-3 py-1.5 text-sm text-white bg-blue-700 rounded-md hover:bg-blue-800 transition"
                                onclick="lihat_keterangan_{{ $bangunan->id }}.showModal()">
                                <i class="fas fa-eye mr-2"></i>Lihat
                            </button>
                        </td>
                        <td class="px-6 py-2 border border-gray-300">
                            <button
                                class="flex items-center px-3 py-1.5 text-sm text-white bg-blue-700 rounded-md hover:bg-blue-800 transition"
                                onclick="lihat_pemeliharaan_{{ $bangunan->id }}.showModal()">
                                <i class="fas fa-eye mr-2"></i>Lihat
                            </button>
                        </td>
                        @if (Auth::check())
                            @if (Auth::user()->role === 'Admin')
                                <td class="px-6 py-2 border border-gray-300">
                                    <div class="flex space-x-2">
                                        <button
                                            class="flex items-center px-3 py-1.5 text-sm text-white bg-amber-500 rounded-md hover:bg-amber-600 transition"
                                            onclick="ubah_gedung_bangunan_{{ $bangunan->id }}.showModal()">
                                            <i class="fas fa-edit mr-2"></i>
                                            Ubah
                                        </button>
                                        <button
                                            class="flex items-center px-3 py-1.5 text-sm text-white bg-red-600 rounded-md hover:bg-red-700 transition"
                                            onclick="hapus_gedung_bangunan_{{ $bangunan->id }}.showModal()">
                                            <i class="fas fa-trash-alt mr-2"></i>
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            @endif
                        @endif
                    </tr>

                    <!-- Ubah Modal -->
                    <dialog id="ubah_gedung_bangunan_{{ $bangunan->id }}" class="modal modal-middle">
                        <div class="modal-box max-w-md w-full">
                            <h3 class="text-xl font-semibold text-gray-800">Ubah Bangunan</h3>
                            <hr class="border-gray-800 border-1 my-4">
                            <form action="{{ route('bangunan.update', $bangunan->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-6">
                                    <label for="nama_bangunan" class="block mb-2 text-sm font-medium text-gray-700">
                                        Nama Bangunan
                                    </label>
                                    <input type="text" name="nama_bangunan" id="nama_bangunan" class="custom-input"
                                        value="{{ $bangunan->nama_bangunan }}" required
                                        oninvalid="this.setCustomValidity('Kolom ini harus diisi')"
                                        oninput="this.setCustomValidity('')">
                                </div>
                                <div class="mb-6">
                                    <label for="kode_bangunan" class="block mb-2 text-sm font-medium text-gray-700">
                                        Kode Bangunan
                                    </label>
                                    <input type="text" name="kode_bangunan" id="kode_bangunan"
                                        class="custom-input" value="{{ $bangunan->kode_bangunan }}">
                                </div>
                                <div class="mb-6">
                                    <label for="nomor_register" class="block mb-2 text-sm font-medium text-gray-700">
                                        Nomor Register
                                    </label>
                                    <input type="text" name="nomor_register" id="nomor_register"
                                        class="custom-input" value="{{ $bangunan->nomor_register }}">
                                </div>
                                <div class="mb-6">
                                    <label for="kondisi"
                                        class="block mb-2 text-sm font-medium text-gray-700">Kondisi</label>
                                    <select name="kondisi" id="kondisi" class="custom-input">
                                        <option class="text-center" disabled
                                            {{ old('kondisi', $bangunan->kondisi) ? '' : 'selected' }}>--
                                            Pilih Kondisi --</option>
                                        @foreach (['Baik', 'Rusak Ringan', 'Rusak Sedang', 'Rusak Berat'] as $kondisi)
                                            <option value="{{ $kondisi }}"
                                                {{ old('kondisi', $bangunan->kondisi) == $kondisi ? 'selected' : '' }}>
                                                {{ $kondisi }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-6">
                                    <label for="bertingkat" class="block mb-2 text-sm font-medium text-gray-700">
                                        Bertingkat
                                    </label>
                                    <input type="text" name="bertingkat" id="bertingkat" class="custom-input"
                                        value="{{ $bangunan->bertingkat }}">
                                </div>
                                <div class="mb-6">
                                    <label for="beton" class="block mb-2 text-sm font-medium text-gray-700">
                                        Beton
                                    </label>
                                    <input type="text" name="beton" id="beton" class="custom-input"
                                        value="{{ $bangunan->beton }}">
                                </div>
                                <div class="mb-6">
                                    <label for="luas_lantai" class="block mb-2 text-sm font-medium text-gray-700">
                                        Luas Lantai (M2)
                                    </label>
                                    <input type="text" name="luas_lantai" id="luas_lantai" class="custom-input"
                                        value="{{ $bangunan->luas_lantai }}">
                                </div>
                                <div class="mb-6">
                                    <label for="lokasi" class="block mb-2 text-sm font-medium text-gray-700">
                                        Lokasi
                                    </label>
                                    <input type="text" name="lokasi" id="lokasi" class="custom-input"
                                        value="{{ $bangunan->lokasi }}">
                                </div>
                                <div class="mb-6">
                                    <label for="nomor" class="block mb-2 text-sm font-medium text-gray-700">
                                        Nomor
                                    </label>
                                    <input type="text" name="nomor" id="nomor" class="custom-input"
                                        value="{{ $bangunan->nomor }}">
                                </div>
                                <div class="mb-6">
                                    <label for="tanggal" class="block mb-2 text-sm font-medium text-gray-700">
                                        Tanggal
                                    </label>
                                    <input type="date" name="tanggal" id="tanggal" class="custom-input"
                                        value="{{ $bangunan->tanggal }}">
                                </div>
                                <div class="mb-6">
                                    <label for="status_tanah"
                                        class="block mb-2 text-sm font-medium text-gray-700">Status Tanah</label>
                                    <select name="status_tanah" id="status_tanah" class="custom-input">
                                        <option class="text-center" disabled
                                            {{ old('status_tanah', $bangunan->status_tanah) ? '' : 'selected' }}>--
                                            Pilih Status --</option>
                                        @foreach (['Hak Milik', 'Hak Guna Bangunan', 'Hak Guna Usaha', 'Hak Pakai', 'Hak Pengelolaan'] as $status)
                                            <option value="{{ $status }}"
                                                {{ old('status_tanah', $bangunan->status_tanah) == $status ? 'selected' : '' }}>
                                                {{ $status }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-6">
                                    <label for="kode_tanah" class="block mb-2 text-sm font-medium text-gray-700">
                                        Kode Tanah
                                    </label>
                                    <input type="text" name="kode_tanah" id="kode_tanah" class="custom-input"
                                        value="{{ $bangunan->kode_tanah }}">
                                </div>
                                <div class="mb-6">
                                    <label for="asal_usul" class="block mb-2 text-sm font-medium text-gray-700">
                                        Asal Usul
                                    </label>
                                    <input type="text" name="asal_usul" id="asal_usul" class="custom-input"
                                        value="{{ $bangunan->asal_usul }}">
                                </div>
                                <div class="mb-6">
                                    <label for="harga" class="block mb-2 text-sm font-medium text-gray-700">
                                        Harga
                                    </label>
                                    <input type="number" name="harga" id="harga" class="custom-input"
                                        value="{{ $bangunan->harga }}">
                                </div>
                                <div class="mb-6">
                                    <label for="keterangan" class="block mb-2 text-sm font-medium text-gray-700">
                                        Keterangan
                                    </label>
                                    <input type="text" name="keterangan" id="keterangan" class="custom-input"
                                        value="{{ $bangunan->keterangan }}">
                                </div>
                                <div class="mb-6">
                                    <label for="pemeliharaan" class="block mb-2 text-sm font-medium text-gray-700">
                                        Pemeliharaan
                                    </label>
                                    <input type="text" name="pemeliharaan" id="pemeliharaan" class="custom-input"
                                        value="{{ $bangunan->pemeliharaan }}">
                                </div>
                                <div class="flex justify-end gap-2 mt-6">
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-blue-700 text-white text-sm font-semibold rounded-md hover:bg-blue-800 transition">
                                        <i class="fas fa-save mr-2"></i>Simpan
                                    </button>
                                    <button type="button"
                                        onclick="document.getElementById('ubah_gedung_bangunan_{{ $bangunan->id }}').close()"
                                        class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 text-sm font-semibold rounded-md hover:bg-gray-400 transition">
                                        <i class="fas fa-times mr-2"></i>Tutup
                                    </button>
                                </div>
                            </form>
                        </div>
                    </dialog>
                    <!-- Lihat Keterangan Modal -->
                    <dialog id="lihat_keterangan_{{ $bangunan->id }}" class="modal modal-middle">
                        <div class="modal-box max-w-md w-full">
                            <h3 class="text-xl font-semibold mb-4">Keterangan</h3>
                            <div class="space-y-3 text-gray-700 text-sm">
                                <div class="bg-gray-100 py-2 rounded">
                                    @if (!empty($bangunan->keterangan))
                                        {{ $bangunan->keterangan }}
                                    @else
                                        <span class="italic text-gray-500">Tidak Ada Keterangan</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex justify-end mt-6">
                                <button type="button"
                                    onclick="document.getElementById('lihat_keterangan_{{ $bangunan->id }}').close()"
                                    class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 text-sm font-semibold rounded-md hover:bg-gray-400 transition">
                                    <i class="fas fa-times mr-2"></i>Tutup
                                </button>
                            </div>
                        </div>
                    </dialog>
                    <!-- Lihat Pemeliharaan Modal -->
                    <dialog id="lihat_pemeliharaan_{{ $bangunan->id }}" class="modal modal-middle">
                        <div class="modal-box max-w-md w-full">
                            <h3 class="text-xl font-semibold mb-4">Pemeliharaan</h3>
                            <div class="space-y-3 text-gray-700 text-sm">
                                <div class="bg-gray-100 py-2 rounded">
                                    @if (!empty($bangunan->pemeliharaan))
                                        {{ $bangunan->pemeliharaan }}
                                    @else
                                        <span class="italic text-gray-500">Tidak Ada Pemeliharaan</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex justify-end mt-6">
                                <button type="button"
                                    onclick="document.getElementById('lihat_pemeliharaan_{{ $bangunan->id }}').close()"
                                    class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 text-sm font-semibold rounded-md hover:bg-gray-400 transition">
                                    <i class="fas fa-times mr-2"></i>Tutup
                                </button>
                            </div>
                        </div>
                    </dialog>
                    <!-- Hapus Modal -->
                    <dialog id="hapus_gedung_bangunan_{{ $bangunan->id }}" class="modal modal-middle">
                        <div class="modal-box max-w-md w-full">
                            <h3 class="text-xl font-semibold text-red-600 mb-4">Konfirmasi Hapus</h3>
                            <p class="text-gray-700 mb-6">
                                Apakah Anda yakin ingin menghapus <span
                                    class="font-bold">{{ $bangunan->nama_bangunan }}</span>?
                                Tindakan ini tidak dapat dibatalkan.
                            </p>
                            <form action="{{ route('bangunan.destroy', $bangunan->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="flex justify-end gap-2">
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-md hover:bg-red-700 transition">
                                        <i class="fas fa-trash-alt mr-2"></i>Hapus
                                    </button>
                                    <button type="button"
                                        onclick="document.getElementById('hapus_gedung_bangunan_{{ $bangunan->id }}').close()"
                                        class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 text-sm font-semibold rounded-md hover:bg-gray-400 transition">
                                        <i class="fas fa-times mr-2"></i>Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </dialog>
                @empty
                    <tr>
                        <td colspan="19" class="text-center py-4 text-gray-500">Tidak ada data bangunan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<!-- Tambah Modal -->
<dialog id="tambah_gedung_bangunan" class="modal modal-middle">
    <div class="modal-box max-w-md w-full">
        <h3 class="text-xl font-semibold text-gray-800">Tambah Bangunan</h3>
        <hr class="border-gray-800 border-1 my-4">
        <form action="{{ route('bangunan.store') }}" method="POST">
            @csrf
            <div class="mb-6">
                <label for="nama_bangunan" class="block mb-2 text-sm font-medium text-gray-700">
                    Nama/Jenis Bangunan
                </label>
                <input type="text" name="nama_bangunan" id="nama_bangunan" class="custom-input" required
                    oninvalid="this.setCustomValidity('Kolom ini harus diisi')" oninput="this.setCustomValidity('')">
            </div>
            <div class="mb-6">
                <label for="kode_bangunan" class="block mb-2 text-sm font-medium text-gray-700">
                    Kode Bangunan
                </label>
                <input type="text" name="kode_bangunan" id="kode_bangunan" class="custom-input">
            </div>
            <div class="mb-6">
                <label for="nomor_register" class="block mb-2 text-sm font-medium text-gray-700">
                    Nomor Register
                </label>
                <input type="text" name="nomor_register" id="nomor_register" class="custom-input">
            </div>
            <div class="mb-6">
                <label for="kondisi" class="block mb-2 text-sm font-medium text-gray-700">
                    Kondisi
                </label>
                <select name="kondisi" id="kondisi" class="custom-input">
                    <option class="text-center" value="" disabled selected>-- Pilih Kondisi --</option>
                    <option value="Baik">Baik</option>
                    <option value="Rusak Ringan">Rusak Ringan</option>
                    <option value="Rusak Sedang">Rusak Sedang</option>
                    <option value="Rusak Berat">Rusak Berat</option>
                </select>
            </div>
            <div class="mb-6">
                <label for="bertingkat" class="block mb-2 text-sm font-medium text-gray-700">
                    Bertingkat/Tidak
                </label>
                <input type="text" name="bertingkat" id="bertingkat" class="custom-input">
            </div>
            <div class="mb-6">
                <label for="beton" class="block mb-2 text-sm font-medium text-gray-700">
                    Beton/Tidak
                </label>
                <input type="text" name="beton" id="beton" class="custom-input">
            </div>
            <div class="mb-6">
                <label for="luas_lantai" class="block mb-2 text-sm font-medium text-gray-700">
                    Luas Lantai (M2)
                </label>
                <input type="text" name="luas_lantai" id="luas_lantai" class="custom-input">
            </div>
            <div class="mb-6">
                <label for="lokasi" class="block mb-2 text-sm font-medium text-gray-700">
                    Lokasi
                </label>
                <input type="text" name="lokasi" id="lokasi" class="custom-input">
            </div>
            <div class="mb-6">
                <label for="nomor" class="block mb-2 text-sm font-medium text-gray-700">
                    Nomor
                </label>
                <input type="text" name="nomor" id="nomor" class="custom-input">
            </div>
            <div class="mb-6">
                <label for="tanggal" class="block mb-2 text-sm font-medium text-gray-700">
                    Tanggal
                </label>
                <input type="date" name="tanggal" id="tanggal" class="custom-input">
            </div>
            <div class="mb-6">
                <label for="luas" class="block mb-2 text-sm font-medium text-gray-700">
                    Luas (M2)
                </label>
                <input type="text" name="luas" id="luas" class="custom-input">
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
                </select>
            </div>
            <div class="mb-6">
                <label for="kode_tanah" class="block mb-2 text-sm font-medium text-gray-700">
                    Nomor Kode Tanah
                </label>
                <input type="text" name="kode_tanah" id="kode_tanah" class="custom-input">
            </div>
            <div class="mb-6">
                <label for="asal_usul" class="block mb-2 text-sm font-medium text-gray-700">
                    Asal Usul
                </label>
                <input type="text" name="asal_usul" id="asal_usul" class="custom-input">
            </div>
            <div class="mb-6">
                <label for="harga" class="block mb-2 text-sm font-medium text-gray-700">
                    Harga
                </label>
                <input type="number" name="harga" id="harga" class="custom-input">
            </div>
            <div class="mb-6">
                <label for="keterangan" class="block mb-2 text-sm font-medium text-gray-700">
                    Keterangan
                </label>
                <input type="text" name="keterangan" id="keterangan" class="custom-input">
            </div>
            <div class="mb-6">
                <label for="pemeliharaan" class="block mb-2 text-sm font-medium text-gray-700">
                    Pemeliharaan
                </label>
                <input type="text" name="pemeliharaan" id="pemeliharaan" class="custom-input">
            </div>
            <div class="flex justify-end gap-2 mt-6">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-blue-700 text-white text-sm font-semibold rounded-md hover:bg-blue-800 transition">
                    <i class="fas fa-save mr-2"></i>Simpan
                </button>
                <button type="button" onclick="document.getElementById('tambah_gedung_bangunan').close()"
                    class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 text-sm font-semibold rounded-md hover:bg-gray-400 transition">
                    <i class="fas fa-times mr-2"></i>Tutup
                </button>
            </div>
        </form>
    </div>
</dialog>
