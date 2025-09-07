<div class="flex flex-col md:flex-row flex-wrap items-center justify-between gap-4">
    <form method="GET" action="{{ route('sarana.index') }}" class="flex flex-1 max-w-md w-full md:w-auto gap-2">
        <input type="text" name="search" value="{{ request('search') }}" class="flex-grow custom-input"
            placeholder="Cari Sarana">
        <button type="submit" class="px-4 py-2 text-white bg-black rounded-md shadow-lg whitespace-nowrap">
            Cari
        </button>
    </form>
    <div class="flex flex-wrap items-center gap-2 mt-2 md:mt-0">
        @if (Auth::check())
            @if (Auth::user()->role === 'Admin' || Auth::user()->role === 'User')
                <a href="{{ route('sarana.download.all') }}"
                    class="flex items-center px-4 py-2 text-white bg-emerald-700 hover:bg-emerald-800 rounded-lg text-sm shadow-lg whitespace-nowrap">
                    <i class="fas fa-file-excel text-white mr-2"></i>
                    Export ke Excel
                </a>
            @endif
            @if (Auth::user()->role === 'Admin')
                <button
                    class="inline-flex items-center px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white text-sm font-medium rounded-lg shadow-lg transition whitespace-nowrap"
                    onclick="tambah_sarana.showModal()">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah
                </button>
            @endif
        @endif
    </div>
</div>
<div class="bg-white rounded shadow-lg overflow-x-auto mt-4">
    <div class="max-h-[500px] overflow-y-auto">
        <table class="min-w-full text-sm text-nowrap text-gray-700">
            <thead class="bg-[#3A3A3A] sticky top-0 z-10">
                <tr class="text-left text-white">
                    <th class="px-6 py-3 border border-gray-300">No</th>
                    <th class="px-6 py-3 border border-gray-300">Nama Barang</th>
                    <th class="px-6 py-3 border border-gray-300">Kategori</th>
                    <th class="px-6 py-3 border border-gray-300">Kode Barang</th>
                    <th class="px-6 py-3 border border-gray-300">Kode Sekolah</th>
                    <th class="px-6 py-3 border border-gray-300">Spesifikasi</th>
                    <th class="px-6 py-3 border border-gray-300">Sumber Dana</th>
                    <th class="px-6 py-3 border border-gray-300">Harga</th>
                    <th class="px-6 py-3 border border-gray-300">Tanggal Masuk</th>
                    <th class="px-6 py-3 border border-gray-300">Lokasi</th>
                    <th class="px-6 py-3 border border-gray-300">Kondisi</th>
                    <th class="px-6 py-3 border border-gray-300">Jumlah</th>
                    <th class="px-6 py-3 border border-gray-300">Keterangan</th>
                    <th class="px-6 py-3 border border-gray-300">Service</th>
                    @if (Auth::check())
                        @if (Auth::user()->role === 'Admin')
                            <th class="px-6 py-3 border border-gray-300">Aksi</th>
                        @endif
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($saranas as $index => $sarana)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-3 border border-gray-300">{{ $index + 1 }}</td>
                        <td class="px-6 py-3 border border-gray-300">{{ $sarana->nama_barang }}</td>
                        <td class="px-6 py-3 border border-gray-300">{{ $sarana->kategori }}</td>
                        <td class="px-6 py-3 border border-gray-300">{{ $sarana->kode_barang }}</td>
                        <td class="px-6 py-3 border border-gray-300">{{ $sarana->kode_sekolah }}</td>
                        <td class="px-6 py-3 border border-gray-300">{{ $sarana->spesifikasi }}</td>
                        <td class="px-6 py-3 border border-gray-300">{{ $sarana->sumber_dana }}</td>
                        <td class="px-6 py-3 border border-gray-300">Rp
                            {{ number_format($sarana->harga, 0, ',', '.') }}</td>
                        <td class="px-6 py-3 border border-gray-300">
                            {{ $sarana->tanggal_masuk ? \Carbon\Carbon::parse($sarana->tanggal_masuk)->format('d-m-Y') : '-' }}
                        </td>
                        <td class="px-6 py-3 border border-gray-300">{{ $sarana->lokasi }}</td>
                        <td class="px-6 py-3 border border-gray-300">{{ $sarana->kondisi }}</td>
                        <td class="px-6 py-3 border border-gray-300">{{ $sarana->jumlah }}</td>
                        <td class="px-6 py-3 border border-gray-300">
                            <button
                                class="flex items-center px-3 py-1.5 text-sm text-white bg-blue-700 rounded-md hover:bg-blue-800 transition"
                                onclick="lihat_keterangan_{{ $sarana->id }}.showModal()">
                                <i class="fas fa-eye mr-2"></i>Lihat
                            </button>
                        </td>
                        <td class="px-6 py-3 border border-gray-300">
                            <button
                                class="flex items-center px-3 py-1.5 text-sm text-white bg-blue-700 rounded-md hover:bg-blue-800 transition"
                                onclick="lihat_service_{{ $sarana->id }}.showModal()">
                                <i class="fas fa-eye mr-2"></i>Lihat
                            </button>
                        </td>
                        @if (Auth::check())
                            @if (Auth::user()->role === 'Admin')
                                <td class="px-6 py-3 border border-gray-300">
                                    <div class="flex space-x-2">
                                        <button
                                            class="flex items-center px-3 py-1.5 text-sm text-white bg-amber-500 rounded-md hover:bg-amber-600 transition"
                                            onclick="ubah_sarana_{{ $sarana->id }}.showModal()">
                                            <i class="fas fa-edit mr-2"></i>Ubah
                                        </button>
                                        <button
                                            class="flex items-center px-3 py-1.5 text-sm text-white bg-red-600 rounded-md hover:bg-red-700 transition"
                                            onclick="hapus_sarana_{{ $sarana->id }}.showModal()">
                                            <i class="fas fa-trash-alt mr-2"></i>Hapus
                                        </button>
                                    </div>
                                </td>
                            @endif
                        @endif
                    </tr>

                    <!-- Ubah Modal -->
                    <dialog id="ubah_sarana_{{ $sarana->id }}" class="modal modal-middle">
                        <div class="modal-box max-w-md w-full">
                            <h3 class="text-xl font-semibold text-gray-800">Ubah Sarana</h3>
                            <hr class="border-gray-800 border-1 my-4">
                            <form action="{{ route('sarana.update', $sarana->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-6">
                                    <label for="nama_barang" class="block mb-2 text-sm font-medium text-gray-700">Nama
                                        Barang</label>
                                    <input type="text" name="nama_barang" class="custom-input"
                                        value="{{ old('nama_barang', $sarana->nama_barang) }}" required
                                        oninvalid="this.setCustomValidity('Kolom ini harus diisi')"
                                        oninput="this.setCustomValidity('')">
                                </div>
                                <div class="mb-6">
                                    <label for="kategori"
                                        class="block mb-2 text-sm font-medium text-gray-700">Kategori</label>
                                    <select name="kategori" id="kategori" class="custom-input" required>
                                        <option class="text-center" disabled
                                            {{ old('kategori', $sarana->kategori) ? '' : 'selected' }}>--
                                            Pilih Kategori --</option>
                                        @foreach (['Meubelair', 'Elektronik', 'Lainnya'] as $kategori)
                                            <option value="{{ $kategori }}"
                                                {{ old('kategori', $sarana->kategori) == $kategori ? 'selected' : '' }}>
                                                {{ $kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-6">
                                    <label for="kode_barang" class="block mb-2 text-sm font-medium text-gray-700">Kode
                                        Barang</label>
                                    <input type="text" name="kode_barang" class="custom-input"
                                        value="{{ old('kode_barang', $sarana->kode_barang) }}">
                                </div>
                                <div class="mb-6">
                                    <label for="kode_sekolah"
                                        class="block mb-2 text-sm font-medium text-gray-700">Kode
                                        Sekolah</label>
                                    <input type="text" name="kode_sekolah" class="custom-input"
                                        value="{{ old('kode_sekolah', $sarana->kode_sekolah) }}">
                                </div>
                                <div class="mb-6">
                                    <label for="spesifikasi"
                                        class="block mb-2 text-sm font-medium text-gray-700">Spesifikasi</label>
                                    <input type="text" name="spesifikasi" class="custom-input"
                                        value="{{ old('spesifikasi', $sarana->spesifikasi) }}">
                                </div>
                                <div class="mb-6">
                                    <label for="satuan"
                                        class="block mb-2 text-sm font-medium text-gray-700">Satuan</label>
                                    <input type="text" name="satuan" class="custom-input"
                                        value="{{ old('satuan', $sarana->satuan) }}">
                                </div>
                                <div class="mb-6">
                                    <label for="sumber_dana"
                                        class="block mb-2 text-sm font-medium text-gray-700">Sumber Dana</label>
                                    <input type="text" name="sumber_dana" class="custom-input"
                                        value="{{ old('sumber_dana', $sarana->sumber_dana) }}">
                                </div>
                                <div class="mb-6">
                                    <label for="harga"
                                        class="block mb-2 text-sm font-medium text-gray-700">Harga</label>
                                    <input type="text" name="harga" class="custom-input"
                                        value="{{ old('harga', $sarana->harga) }}">
                                </div>
                                <div class="mb-6">
                                    <label for="tanggal_masuk"
                                        class="block mb-2 text-sm font-medium text-gray-700">Tanggal Masuk</label>
                                    <input type="date" name="tanggal_masuk" class="custom-input"
                                        value="{{ old('tanggal_masuk', date('Y-m-d', strtotime($sarana->tanggal_masuk))) }}">
                                </div>
                                <div class="mb-6">
                                    <label for="lokasi"
                                        class="block mb-2 text-sm font-medium text-gray-700">Lokasi</label>
                                    <input type="text" name="lokasi" class="custom-input"
                                        value="{{ old('lokasi', $sarana->lokasi) }}">
                                </div>
                                <div class="mb-6">
                                    <label for="kondisi"
                                        class="block mb-2 text-sm font-medium text-gray-700">Kondisi</label>
                                    <select name="kondisi" id="kondisi" class="custom-input">
                                        <option class="text-center" disabled
                                            {{ old('kondisi', $sarana->kondisi) ? '' : 'selected' }}>--
                                            Pilih Kondisi --</option>
                                        @foreach (['Baik', 'Rusak Ringan', 'Rusak Sedang', 'Rusak Berat'] as $kondisi)
                                            <option value="{{ $kondisi }}"
                                                {{ old('kondisi', $sarana->kondisi) == $kondisi ? 'selected' : '' }}>
                                                {{ $kondisi }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-6">
                                    <label for="jumlah"
                                        class="block mb-2 text-sm font-medium text-gray-700">Jumlah</label>
                                    <input type="number" name="jumlah" id="jumlah" class="custom-input"
                                        value="{{ old('jumlah', $sarana->jumlah) }}">
                                </div>
                                <div class="mb-6">
                                    <label for="keterangan"
                                        class="block mb-2 text-sm font-medium text-gray-700">Keterangan</label>
                                    <textarea name="keterangan" class="custom-input h-20">{{ old('keterangan', $sarana->keterangan) }}</textarea>
                                </div>
                                <div class="mb-6">
                                    <label for="service"
                                        class="block mb-2 text-sm font-medium text-gray-700">Service</label>
                                    <textarea name="service" class="custom-input h-32">{{ old('service', $sarana->service) }}</textarea>
                                </div>
                                <div class="flex justify-end gap-2 mt-6">
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-emerald-700 text-white text-sm font-semibold rounded-md hover:bg-emerald-800 transition">
                                        <i class="fas fa-save mr-2"></i>Simpan
                                    </button>
                                    <button type="button"
                                        onclick="document.getElementById('ubah_sarana_{{ $sarana->id }}').close()"
                                        class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 text-sm font-semibold rounded-md hover:bg-gray-400 transition">
                                        <i class="fas fa-times mr-2"></i>Tutup
                                    </button>
                                </div>
                            </form>
                        </div>
                    </dialog>
                    <!-- Lihat Keterangan Modal -->
                    <dialog id="lihat_keterangan_{{ $sarana->id }}" class="modal modal-middle">
                        <div class="modal-box max-w-md w-full">
                            <h3 class="text-xl font-semibold mb-4">Keterangan</h3>
                            <div class="space-y-3 text-gray-700 text-sm">
                                <div class="bg-gray-100 py-2 rounded">
                                    <p class="px-3 py-1">
                                        @if (!empty($sarana->keterangan))
                                            {{ $sarana->keterangan }}
                                        @else
                                            <span class="italic text-gray-500">Tidak Ada Keterangan</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="flex justify-end mt-6">
                                <button type="button"
                                    onclick="document.getElementById('lihat_keterangan_{{ $sarana->id }}').close()"
                                    class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 text-sm font-semibold rounded-md hover:bg-gray-400 transition">
                                    <i class="fas fa-times mr-2"></i>Tutup
                                </button>
                            </div>
                        </div>
                    </dialog>
                    <!-- Lihat Service Modal -->
                    <dialog id="lihat_service_{{ $sarana->id }}" class="modal modal-middle">
                        <div class="modal-box max-w-md w-full">
                            <h3 class="text-xl font-semibold mb-4">Service</h3>
                            <div class="space-y-3 text-gray-700 text-sm">
                                <div class="bg-gray-100 py-2 rounded">
                                    <p class="px-3 py-1">
                                        @if (!empty($sarana->service))
                                            {{ $sarana->service }}
                                        @else
                                            <span class="italic text-gray-500">Tidak Ada Service</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="flex justify-end mt-6">
                                <button type="button"
                                    onclick="document.getElementById('lihat_service_{{ $sarana->id }}').close()"
                                    class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 text-sm font-semibold rounded-md hover:bg-gray-400 transition">
                                    <i class="fas fa-times mr-2"></i>Tutup
                                </button>
                            </div>
                        </div>
                    </dialog>
                    <!-- Hapus Modal -->
                    <dialog id="hapus_sarana_{{ $sarana->id }}" class="modal modal-middle">
                        <div class="modal-box max-w-md w-full">
                            <h3 class="text-xl font-semibold text-red-600 mb-4">Konfirmasi Hapus</h3>
                            <p class="text-gray-700 mb-6">
                                Apakah Anda yakin ingin menghapus <span class="font-bold">{{ $sarana->nama_barang }}
                                    {{ $sarana->kode_barang }}</span>?
                                Tindakan ini tidak dapat dibatalkan.
                            </p>
                            <form action="{{ route('sarana.destroy', $sarana->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="flex justify-end gap-2">
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-md hover:bg-red-700 transition">
                                        <i class="fas fa-trash-alt mr-2"></i>Hapus
                                    </button>
                                    <button type="button"
                                        onclick="document.getElementById('hapus_sarana_{{ $sarana->id }}').close()"
                                        class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 text-sm font-semibold rounded-md hover:bg-gray-400 transition">
                                        <i class="fas fa-times mr-2"></i>Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </dialog>
                @empty
                    <tr>
                        <td colspan="14" class="text-center py-4 text-gray-500">Tidak ada data sarana</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<!-- Tambah Modal -->
<dialog id="tambah_sarana" class="modal modal-middle">
    <div class="modal-box max-w-md w-full">
        <h3 class="text-xl font-semibold text-gray-800">Tambah Sarana</h3>
        <hr class="border-gray-800 border-1 my-4">
        <form action="{{ route('sarana.store') }}" method="POST">
            @csrf
            <div class="mb-6">
                <label for="nama_barang" class="block mb-2 text-sm font-medium text-gray-700">
                    Nama Barang
                </label>
                <input type="text" name="nama_barang" id="nama_barang" class="custom-input" required
                    oninvalid="this.setCustomValidity('Kolom ini harus diisi')" oninput="this.setCustomValidity('')">
            </div>
            <div class="mb-6">
                <label for="kategori" class="block mb-2 text-sm font-medium text-gray-700">
                    Kategori
                </label>
                <select name="kategori" id="kategori" class="custom-input" required>
                    <option class="text-center" disabled selected>-- Pilih Kategori --</option>
                    <option value="Meubelair">Meubelair</option>
                    <option value="Elektronik">Elektronik</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>
            <div class="mb-6">
                <label for="kode_barang" class="block mb-2 text-sm font-medium text-gray-700">
                    Kode Barang
                </label>
                <input type="text" name="kode_barang" id="kode_barang" class="custom-input">
            </div>
            <div class="mb-6">
                <label for="kode_sekolah" class="block mb-2 text-sm font-medium text-gray-700">
                    Kode Sekolah
                </label>
                <input type="text" name="kode_sekolah" id="kode_sekolah" class="custom-input">
            </div>
            <div class="mb-6">
                <label for="spesifikasi" class="block mb-2 text-sm font-medium text-gray-700">
                    Spesifikasi
                </label>
                <input type="text" name="spesifikasi" id="spesifikasi" class="custom-input">
            </div>
            <div class="mb-6">
                <label for="satuan" class="block mb-2 text-sm font-medium text-gray-700">
                    Satuan
                </label>
                <input type="text" name="satuan" id="satuan" class="custom-input">
            </div>
            <div class="mb-6">
                <label for="sumber_dana" class="block mb-2 text-sm font-medium text-gray-700">
                    Sumber Dana
                </label>
                <input type="text" name="sumber_dana" id="sumber_dana" class="custom-input">
            </div>
            <div class="mb-6">
                <label for="harga" class="block mb-2 text-sm font-medium text-gray-700">
                    Harga
                </label>
                <input type="number" name="harga" id="harga" class="custom-input">
            </div>
            <div class="mb-6">
                <label for="tanggal_masuk" class="block mb-2 text-sm font-medium text-gray-700">
                    Tanggal Masuk
                </label>
                <input type="date" name="tanggal_masuk" id="tanggal_masuk" class="custom-input">
            </div>
            <div class="mb-6">
                <label for="lokasi" class="block mb-2 text-sm font-medium text-gray-700">
                    Lokasi
                </label>
                <input type="text" name="lokasi" id="lokasi" class="custom-input">
            </div>
            <div class="mb-6">
                <label for="kondisi" class="block mb-2 text-sm font-medium text-gray-700">
                    Kondisi
                </label>
                <select name="kondisi" id="kondisi" class="custom-input">
                    <option class="text-center" disabled selected>-- Pilih Kondisi --</option>
                    <option value="Baik">Baik</option>
                    <option value="Rusak Ringan">Rusak Ringan</option>
                    <option value="Rusak Sedang">Rusak Sedang</option>
                    <option value="Rusak Berat">Rusak Berat</option>
                </select>
            </div>
            <div class="mb-6">
                <label for="jumlah" class="block mb-2 text-sm font-medium text-gray-700">
                    Jumlah
                </label>
                <input type="number" name="jumlah" id="jumlah" class="custom-input">
            </div>
            <div class="mb-6">
                <label for="keterangan" class="block mb-2 text-sm font-medium text-gray-700">
                    Keterangan
                </label>
                <input type="text" name="keterangan" id="keterangan" class="custom-input">
            </div>
            <div class="mb-6">
                <label for="service" class="block mb-2 text-sm font-medium text-gray-700">
                    Service
                </label>
                <textarea name="service" id="service" class="custom-input h-32"></textarea>
            </div>
            <div class="flex justify-end gap-2 mt-6">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-blue-700 text-white text-sm font-semibold rounded-md hover:bg-blue-800 transition">
                    <i class="fas fa-save mr-2"></i>Simpan
                </button>
                <button type="button" onclick="document.getElementById('tambah_sarana').close()"
                    class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 text-sm font-semibold rounded-md hover:bg-gray-400 transition">
                    <i class="fas fa-times mr-2"></i>Tutup
                </button>
            </div>
        </form>
    </div>
</dialog>
