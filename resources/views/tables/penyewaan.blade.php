@if (Auth::check())
    <div class="flex flex-col md:flex-row items-center justify-between gap-2">
        <form method="GET" action="{{ route('penyewaan.index') }}"
            class="flex items-center gap-2 max-w-md w-full md:w-auto">
            <input type="text" name="search" value="{{ request('search') }}" class="custom-input flex-grow"
                placeholder="Cari Sarana/Prasarana">
            <button type="submit" class="px-4 py-2 text-white bg-black rounded-md shadow-lg whitespace-nowrap">
                Cari
            </button>
        </form>
        @if (Auth::user()->role === 'Admin')
            <button onclick="tambah_penyewaan.showModal()"
                class="inline-flex items-center px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white text-sm font-medium rounded-lg shadow-lg transition whitespace-nowrap mt-4 md:mt-0">
                <i class="fas fa-plus mr-2"></i>
                Tambah
            </button>
        @endif
    </div>
@endif
<div class="bg-white rounded shadow-lg overflow-x-auto mt-4">
    <div class="max-h-[500px] overflow-y-auto">
        <table class="min-w-full text-sm text-nowrap text-gray-700">
            <thead class="bg-black sticky top-0 z-10">
                <tr class="text-left text-white">
                    <th class="px-6 py-3 border border-gray-300">No</th>
                    <th class="px-6 py-3 border border-gray-300">Nama Sarana/Prasarana</th>
                    <th class="px-6 py-3 border border-gray-300">Kode Sarana/Prasarana</th>
                    <th class="px-6 py-3 border border-gray-300">Jumlah</th>
                    <th class="px-6 py-3 border border-gray-300">Harga</th>
                    <th class="px-6 py-3 border border-gray-300">Keterangan</th>
                    @if (Auth::check())
                        @if (Auth::user()->role === 'Admin')
                            <th class="px-6 py-3 border border-gray-300">Aksi</th>
                        @endif
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($penyewaans as $index => $penyewaan)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-3 border border-gray-300">{{ $index + 1 }}</td>
                        <td class="px-6 py-3 border border-gray-300">
                            @php
                                $item = $penyewaan->penyewaanable;
                            @endphp

                            {{ $item->nama ?? ($item->nama_barang ?? ($item->nama_bangunan ?? '-')) }}
                        </td>
                        <td class="px-6 py-3 border border-gray-300">
                            {{ $item->kode ?? ($item->kode_barang ?? ($item->kode_bangunan ?? '-')) }}
                        </td>
                        <td class="px-6 py-3 border border-gray-300">{{ $penyewaan->jumlah }}</td>
                        <td class="px-6 py-3 border border-gray-300">Rp
                            {{ number_format($penyewaan->harga, 0, ',', '.') }}</td>
                        <td class="px-6 py-3 border border-gray-300">
                            <button onclick="lihat_keterangan_{{ $penyewaan->id }}.showModal()"
                                class="flex items-center px-3 py-1.5 text-sm text-white bg-blue-700 rounded-md hover:bg-blue-800 transition">
                                <i class="fas fa-eye mr-2"></i>Lihat
                            </button>
                        </td>
                        @if (Auth::check())
                            @if (Auth::user()->role === 'Admin')
                                <td class="px-6 py-3 border border-gray-300">
                                    <div class="flex space-x-2">
                                        <button onclick="ubah_penyewaan_{{ $penyewaan->id }}.showModal()"
                                            class="flex items-center px-3 py-1.5 text-sm text-white bg-amber-500 rounded-md hover:bg-amber-600 transition">
                                            <i class="fas fa-edit mr-2"></i>Ubah
                                        </button>
                                        <button onclick="hapus_penyewaan_{{ $penyewaan->id }}.showModal()"
                                            class="flex items-center px-3 py-1.5 text-sm text-white bg-red-600 rounded-md hover:bg-red-700 transition">
                                            <i class="fas fa-trash-alt mr-2"></i>Hapus
                                        </button>
                                    </div>
                                </td>
                            @endif
                        @endif
                    </tr>

                    <!-- Ubah Modal -->
                    <dialog id="ubah_penyewaan_{{ $penyewaan->id }}" class="modal modal-middle">
                        <div class="modal-box max-w-md w-full">
                            <h3 class="text-xl font-semibold text-gray-800">Ubah Transaksi</h3>
                            <hr class="border-gray-800 border-1 my-4">
                            <form action="{{ route('penyewaan.update', $penyewaan->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-4">
                                    <label for="nama-{{ $penyewaan->id }}"
                                        class="block mb-2 text-sm font-medium text-gray-700">
                                        Nama Sarana/Prasarana
                                    </label>
                                    <select name="nama" id="nama-{{ $penyewaan->id }}" class="custom-input" required
                                        oninvalid="this.setCustomValidity('Kolom ini harus diisi')"
                                        oninput="this.setCustomValidity('')">
                                        <option class="text-center" value="" disabled>
                                            -- Pilih Sarana/Prasarana --
                                        </option>
                                        @foreach ($items as $item)
                                            <option value="{{ $item['nama'] }}" data-kode="{{ $item['kode'] }}"
                                                data-id="{{ $item['id'] }}" data-type="{{ $item['type'] }}"
                                                {{ $item['nama'] == $penyewaan->nama ? 'selected' : '' }}>
                                                {{ $item['nama'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="hidden" name="penyewaanable" id="penyewaanable-{{ $penyewaan->id }}"
                                    value="{{ $penyewaan->penyewaanable_id }}|{{ $penyewaan->penyewaanable_type }}">
                                <div class="mb-4">
                                    <label for="kode-{{ $penyewaan->id }}"
                                        class="block mb-2 text-sm font-medium text-gray-700">
                                        Kode Sarana/Prasarana
                                    </label>
                                    <input type="text" name="kode" id="kode-{{ $penyewaan->id }}"
                                        class="custom-input" value="{{ $penyewaan->kode }}" readonly required
                                        oninvalid="this.setCustomValidity('Kolom ini harus diisi')"
                                        oninput="this.setCustomValidity('')">
                                </div>
                                <div class="mb-4">
                                    <label for="jumlah-{{ $penyewaan->id }}"
                                        class="block mb-2 text-sm font-medium text-gray-700">
                                        Jumlah
                                    </label>
                                    <input type="number" name="jumlah" id="jumlah-{{ $penyewaan->id }}"
                                        class="custom-input" value="{{ $penyewaan->jumlah }}" min="1" required>
                                </div>
                                <div class="mb-4">
                                    <label for="harga-{{ $penyewaan->id }}"
                                        class="block mb-2 text-sm font-medium text-gray-700">
                                        Harga
                                    </label>
                                    <input type="number" name="harga" id="harga-{{ $penyewaan->id }}"
                                        class="custom-input" value="{{ $penyewaan->harga }}" min="1" required>
                                </div>
                                <div class="mb-4">
                                    <label for="keterangan-{{ $penyewaan->id }}"
                                        class="block mb-2 text-sm font-medium text-gray-700">
                                        Keterangan
                                    </label>
                                    <input type="text" name="keterangan" id="keterangan-{{ $penyewaan->id }}"
                                        class="custom-input" value="{{ $penyewaan->keterangan }}">
                                </div>
                                <div class="flex justify-end gap-2 mt-6">
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-blue-700 text-white text-sm font-semibold rounded-md hover:bg-blue-800 transition">
                                        <i class="fas fa-save mr-2"></i>Simpan
                                    </button>
                                    <button type="button" onclick="ubah_penyewaan_{{ $penyewaan->id }}.close()"
                                        class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 text-sm font-semibold rounded-md hover:bg-gray-400 transition">
                                        <i class="fas fa-times mr-2"></i>Tutup
                                    </button>
                                </div>
                            </form>

                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const select = document.getElementById('nama-{{ $penyewaan->id }}');
                                    const kodeInput = document.getElementById('kode-{{ $penyewaan->id }}');
                                    const penyewaanableInput = document.getElementById('penyewaanable-{{ $penyewaan->id }}');

                                    function updateFieldsFromSelectedOption() {
                                        const selected = select.options[select.selectedIndex];
                                        const kode = selected.getAttribute('data-kode');
                                        const id = selected.getAttribute('data-id');
                                        const type = selected.getAttribute('data-type');

                                        kodeInput.value = kode || '';
                                        penyewaanableInput.value = `${id}|${type}`;
                                    }

                                    updateFieldsFromSelectedOption();

                                    select.addEventListener('change', updateFieldsFromSelectedOption);
                                });
                            </script>
                        </div>
                    </dialog>
                    <!-- Lihat Keterangan Modal -->
                    <dialog id="lihat_keterangan_{{ $penyewaan->id }}" class="modal modal-middle">
                        <div class="modal-box max-w-md w-full">
                            <h3 class="text-xl font-semibold mb-4">Keterangan</h3>
                            <div class="space-y-3 text-gray-700 text-sm">
                                <div class="bg-gray-100 py-2 rounded">
                                    <p class="px-3 py-1">
                                        @if (!empty($penyewaan->keterangan))
                                            {{ $penyewaan->keterangan }}
                                        @else
                                            <span class="italic text-gray-500">Tidak Ada Keterangan</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="flex justify-end mt-6">
                                <button type="button"
                                    onclick="document.getElementById('lihat_keterangan_{{ $penyewaan->id }}').close()"
                                    class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 text-sm font-semibold rounded-md hover:bg-gray-400 transition">
                                    <i class="fas fa-times mr-2"></i>Tutup
                                </button>
                            </div>
                        </div>
                    </dialog>
                    <!-- Hapus Modal -->
                    <dialog id="hapus_penyewaan_{{ $penyewaan->id }}" class="modal modal-middle">
                        <div class="modal-box max-w-md w-full">
                            <h3 class="text-xl font-semibold text-red-600 mb-4">Konfirmasi Hapus</h3>
                            <p class="text-gray-700 mb-6">
                                Apakah Anda yakin ingin menghapus <span
                                    class="font-bold">{{ $penyewaan->nama }}</span>?
                                Tindakan ini tidak dapat dibatalkan.
                            </p>
                            <form action="{{ route('penyewaan.destroy', $penyewaan->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="flex justify-end gap-2">
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-md hover:bg-red-700 transition">
                                        <i class="fas fa-trash-alt mr-2"></i>Hapus
                                    </button>
                                    <button type="button"
                                        onclick="document.getElementById('hapus_penyewaan_{{ $penyewaan->id }}').close()"
                                        class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 text-sm font-semibold rounded-md hover:bg-gray-400 transition">
                                        <i class="fas fa-times mr-2"></i>Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </dialog>
                @empty
                    <tr>
                        <td colspan="14" class="text-center py-4 text-gray-500">Tidak ada data penyewaan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<!-- Tambah Modal -->
<dialog id="tambah_penyewaan" class="modal modal-middle">
    <div class="modal-box max-w-md w-full">
        <h3 class="text-xl font-semibold text-gray-800">Tambah Penyewaan</h3>
        <hr class="border-gray-800 border-1 my-4">
        <form action="{{ route('penyewaan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="nama" class="block mb-2 text-sm font-medium text-gray-700">
                    Nama Sarana/Prasarana
                </label>
                <select name="penyewaanable" id="penyewaanable" class="custom-input" required
                    oninvalid="this.setCustomValidity('Kolom ini harus diisi')" oninput="this.setCustomValidity('')">
                    <option class="text-center" value="" selected disabled>-- Pilih Sarana/Prasarana --</option>
                    @foreach ($items as $item)
                        <option value="{{ $item['id'] }}|{{ $item['type'] }}" data-kode="{{ $item['kode'] }}">
                            {{ $item['nama'] }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="kode" class="block mb-2 text-sm font-medium text-gray-700">
                    Kode Sarana/Prasarana
                </label>
                <input type="text" name="kode" id="kode" class="custom-input" readonly
                    oninvalid="this.setCustomValidity('Kolom ini harus diisi')" oninput="this.setCustomValidity('')">
            </div>
            <div class="mb-4">
                <label for="jumlah" class="block mb-2 text-sm font-medium text-gray-700">
                    Jumlah
                </label>
                <input type="number" name="jumlah" id="jumlah" class="custom-input" min="1" required
                    oninvalid="this.setCustomValidity('Kolom ini harus diisi')" oninput="this.setCustomValidity('')">
            </div>
            <div class="mb-4">
                <label for="harga" class="block mb-2 text-sm font-medium text-gray-700">
                    Harga
                </label>
                <input type="number" name="harga" id="harga" class="custom-input" min="1" required
                    oninvalid="this.setCustomValidity('Kolom ini harus diisi')" oninput="this.setCustomValidity('')">
            </div>
            <div class="mb-4">
                <label for="keterangan" class="block mb-2 text-sm font-medium text-gray-700">
                    Keterangan
                </label>
                <input type="text" name="keterangan" id="keterangan" class="custom-input">
            </div>
            <div class="flex justify-end gap-2 mt-6">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-blue-700 text-white text-sm font-semibold rounded-md hover:bg-blue-800 transition">
                    <i class="fas fa-save mr-2"></i>Simpan
                </button>
                <button type="button" onclick="tambah_penyewaan.close()"
                    class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 text-sm font-semibold rounded-md hover:bg-gray-400 transition">
                    <i class="fas fa-times mr-2"></i>Tutup
                </button>
            </div>
        </form>

        <script>
            document.getElementById('penyewaanable').addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const kode = selectedOption.getAttribute('data-kode') || '';
                document.getElementById('kode').value = kode;
            });
        </script>
    </div>
</dialog>
