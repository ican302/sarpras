<div class="flex items-center justify-end">
    <button
        class="inline-flex items-center px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white text-sm font-medium rounded-lg shadow-lg transition"
        onclick="tambah_struktur.showModal()">
        <i class="fas fa-plus mr-2"></i>
        Tambah
    </button>
</div>
<div class="bg-white rounded shadow-lg overflow-x-auto mt-4">
    <div class="max-h-[500px] overflow-y-auto">
        <table class="min-w-full text-sm text-nowrap text-gray-700">
            <thead class="bg-black sticky top-0 z-10">
                <tr class="text-left text-white">
                    <th class="px-6 py-3 border border-gray-300">No</th>
                    <th class="px-6 py-3 border border-gray-300">Nama</th>
                    <th class="px-6 py-3 border border-gray-300">Posisi</th>
                    <th class="px-6 py-3 border border-gray-300">Foto</th>
                    <th class="px-6 py-3 border border-gray-300">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($strukturs as $index => $struktur)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-3 border border-gray-300">{{ $index + 1 }}</td>
                        <td class="px-6 py-3 border border-gray-300">{{ $struktur->nama }}</td>
                        <td class="px-6 py-3 border border-gray-300">{{ $struktur->posisi }}</td>
                        <td class="px-6 py-3 border border-gray-300">
                            <button
                                class="flex items-center px-3 py-1.5 text-sm text-white bg-blue-700 rounded-md hover:bg-blue-800 transition"
                                onclick="document.getElementById('lihat_foto_{{ $struktur->id }}').showModal()">
                                <i class="fas fa-eye mr-2"></i>
                                Lihat
                            </button>
                        </td>
                        <td class="px-6 py-3 border border-gray-300">
                            <div class="flex space-x-2">
                                <button
                                    class="flex items-center px-3 py-1.5 text-sm text-white bg-amber-500 rounded-md hover:bg-amber-600 transition"
                                    onclick="document.getElementById('ubah_struktur_{{ $struktur->id }}').showModal()">
                                    <i class="fas fa-edit mr-2"></i>
                                    Ubah
                                </button>
                                <button
                                    class="flex items-center px-3 py-1.5 text-sm text-white bg-red-600 rounded-md hover:bg-red-700 transition"
                                    onclick="hapus_struktur_{{ $struktur->id }}.showModal()">
                                    <i class="fas fa-trash-alt mr-2"></i> Hapus
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Ubah Modal -->
                    <dialog id="ubah_struktur_{{ $struktur->id }}" class="modal modal-middle">
                        <div class="modal-box max-w-md w-full">
                            <h3 class="text-xl font-semibold text-gray-800">Ubah Struktur</h3>
                            <hr class="border-gray-800 border-1 my-4">
                            <form action="{{ route('struktur.update', $struktur->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                <div class="mb-6">
                                    <label for="nama" class="block mb-2 text-sm font-medium text-gray-700">
                                        Nama
                                    </label>
                                    <input type="text" name="nama" id="nama" class="custom-input"
                                        value="{{ $struktur->nama }}" required
                                        oninvalid="this.setCustomValidity('Kolom ini harus diisi')"
                                        oninput="this.setCustomValidity('')">
                                </div>
                                <div class="mb-6">
                                    <label for="posisi" class="block mb-2 text-sm font-medium text-gray-700">
                                        Posisi
                                    </label>
                                    <input type="text" name="posisi" id="posisi" class="custom-input"
                                        value="{{ $struktur->posisi }}" required
                                        oninvalid="this.setCustomValidity('Kolom ini harus diisi')"
                                        oninput="this.setCustomValidity('')">
                                </div>
                                <div class="mb-6">
                                    <label for="foto" class="block mb-2 text-sm font-medium text-gray-700">
                                        Foto
                                    </label>
                                    @if ($struktur->foto)
                                        <div class="mb-4 flex justify-center">
                                            <img src="{{ Storage::url($struktur->foto) }}" alt="Foto Struktur"
                                                class="w-32 h-32 object-cover rounded-md">
                                        </div>
                                    @endif
                                    <input type="file" name="foto" id="foto"
                                        class="file-input custom-file-input" />
                                    <p class="mt-1 text-sm text-gray-500">
                                        Format File: jpg, jpeg, png. Maksimal 2MB
                                    </p>
                                </div>
                                <div class="flex justify-end gap-2 mt-6">
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-emerald-700 text-white text-sm font-semibold rounded-md hover:bg-emerald-800 transition">
                                        <i class="fas fa-save mr-2"></i>Simpan
                                    </button>
                                    <button type="button"
                                        onclick="document.getElementById('ubah_struktur_{{ $struktur->id }}').close()"
                                        class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 text-sm font-semibold rounded-md hover:bg-gray-400 transition">
                                        <i class="fas fa-times mr-2"></i>Tutup
                                    </button>
                                </div>
                            </form>
                        </div>
                    </dialog>
                    <!-- Lihat Foto -->
                    <dialog id="lihat_foto_{{ $struktur->id }}" class="modal modal-middle">
                        <div class="modal-box max-w-md w-full text-center">
                            <h3 class="text-lg font-semibold mb-4">Foto {{ $struktur->nama }}</h3>
                            @if ($struktur->foto)
                                <img src="{{ asset('storage/' . $struktur->foto) }}" alt="Foto {{ $struktur->nama }}"
                                    class="w-full h-auto rounded shadow-md">
                            @else
                                <p>Tidak ada foto</p>
                            @endif
                            <div class="mt-4">
                                <button onclick="document.getElementById('lihat_foto_{{ $struktur->id }}').close()"
                                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </dialog>
                    <!-- Hapus Modal -->
                    <dialog id="hapus_struktur_{{ $struktur->id }}" class="modal modal-middle">
                        <div class="modal-box max-w-md w-full">
                            <h3 class="text-xl font-semibold text-red-600 mb-4">Konfirmasi Hapus</h3>
                            <p class="text-gray-700 mb-6">
                                Apakah Anda yakin ingin menghapus <span class="font-bold">{{ $struktur->nama }}</span>?
                                Tindakan ini tidak dapat dibatalkan.
                            </p>
                            <form action="{{ route('struktur.destroy', $struktur->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="flex justify-end gap-2">
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-md hover:bg-red-700 transition">
                                        <i class="fas fa-trash-alt mr-2"></i>Hapus
                                    </button>
                                    <button type="button"
                                        onclick="document.getElementById('hapus_struktur_{{ $struktur->id }}').close()"
                                        class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 text-sm font-semibold rounded-md hover:bg-gray-400 transition">
                                        <i class="fas fa-times mr-2"></i>Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </dialog>
                @empty
                    <tr>
                        <td colspan="14" class="text-center py-4 text-gray-500">Tidak ada data struktur</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<!-- Tambah Modal -->
<dialog id="tambah_struktur" class="modal modal-middle">
    <div class="modal-box max-w-md w-full">
        <h3 class="text-xl font-semibold text-gray-800">Tambah Struktur</h3>
        <hr class="border-gray-800 border-1 my-4">
        <form action="{{ route('struktur.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-6">
                <label for="nama" class="block mb-2 text-sm font-medium text-gray-700">
                    Nama
                </label>
                <input type="text" name="nama" id="nama" class="custom-input" required
                    oninvalid="this.setCustomValidity('Kolom ini harus diisi')" oninput="this.setCustomValidity('')">
            </div>
            <div class="mb-6">
                <label for="posisi" class="block mb-2 text-sm font-medium text-gray-700">
                    Posisi
                </label>
                <input type="text" name="posisi" id="posisi" class="custom-input" required
                    oninvalid="this.setCustomValidity('Kolom ini harus diisi')" oninput="this.setCustomValidity('')">
            </div>
            <div class="mb-6">
                <label for="foto" class="block mb-2 text-sm font-medium text-gray-700">
                    Foto
                </label>
                <input type="file" name="foto" id="foto" class="file-input custom-file-input" />
                <p class="mt-1 text-sm text-gray-500">
                    Format File: jpg, jpeg, png. Maksimal 2MB
                </p>
            </div>
            <div class="flex justify-end gap-2 mt-6">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-emerald-700 text-white text-sm font-semibold rounded-md hover:bg-emerald-800 transition">
                    <i class="fas fa-save mr-2"></i>Simpan
                </button>
                <button type="button" onclick="document.getElementById('tambah_struktur').close()"
                    class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 text-sm font-semibold rounded-md hover:bg-gray-400 transition">
                    <i class="fas fa-times mr-2"></i>Tutup
                </button>
            </div>
        </form>
    </div>
</dialog>
