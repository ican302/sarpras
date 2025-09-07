<div class="flex items-center justify-end">
    <button
        class="inline-flex items-center px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white text-sm font-medium rounded-lg shadow-lg transition"
        onclick="tambah_pengguna.showModal()">
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
                    <th class="px-6 py-3 border border-gray-300">NIP</th>
                    <th class="px-6 py-3 border border-gray-300">Nama Pengguna</th>
                    <th class="px-6 py-3 border border-gray-300">Posisi</th>
                    <th class="px-6 py-3 border border-gray-300">Tugas</th>
                    <th class="px-6 py-3 border border-gray-300">Role</th>
                    <th class="px-6 py-3 border border-gray-300">Foto</th>
                    <th class="px-6 py-3 border border-gray-300">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($users as $index => $user)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-3 border border-gray-300">{{ $index + 1 }}</td>
                        <td class="px-6 py-3 border border-gray-300">{{ $user->nip }}</td>
                        <td class="px-6 py-3 border border-gray-300">{{ $user->nama_pengguna }}</td>
                        <td class="px-6 py-3 border border-gray-300">{{ $user->posisi }}</td>
                        <td class="px-6 py-3 border border-gray-300">{{ $user->tugas }}</td>
                        <td class="px-6 py-3 border border-gray-300">{{ $user->role }}</td>
                        <td class="px-6 py-3 border border-gray-300">
                            <button
                                class="flex items-center px-3 py-1.5 text-sm text-white bg-blue-700 rounded-md hover:bg-blue-800 transition"
                                onclick="lihat_foto_{{ $user->id }}.showModal()">
                                <i class="fas fa-eye mr-2"></i>
                                Lihat
                            </button>
                        </td>
                        <td class="px-6 py-3 border border-gray-300">
                            <div class="flex space-x-2">
                                <button
                                    class="flex items-center px-3 py-1.5 text-sm text-white bg-amber-500 rounded-md hover:bg-amber-600 transition"
                                    onclick="ubah_pengguna_{{ $user->id }}.showModal()">
                                    <i class="fas fa-edit mr-2"></i>
                                    Ubah
                                </button>
                                <button
                                    class="flex items-center px-3 py-1.5 text-sm text-white bg-red-600 rounded-md hover:bg-red-700 transition"
                                    onclick="hapus_pengguna_{{ $user->id }}.showModal()">
                                    <i class="fas fa-trash-alt mr-2"></i>
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Ubah Modal -->
                    <dialog id="ubah_pengguna_{{ $user->id }}" class="modal">
                        <div class="modal-box max-w-md w-full">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4">Ubah Pengguna</h3>
                            <hr class="border-gray-800 border-1 my-4">
                            <form action="{{ route('admin.pengguna.edit', $user->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="mb-6">
                                    <label for="nip"
                                        class="block mb-2 text-sm font-medium text-gray-700">NIP</label>
                                    <input type="text" name="nip" id="nip" value="{{ $user->nip }}"
                                        class="custom-input" required
                                        oninvalid="this.setCustomValidity('Kolom ini harus diisi')"
                                        oninput="this.setCustomValidity('')">
                                </div>
                                <div class="mb-6">
                                    <label for="nama_pengguna" class="block mb-2 text-sm font-medium text-gray-700">Nama
                                        Pengguna</label>
                                    <input type="text" name="nama_pengguna" id="nama_pengguna"
                                        value="{{ $user->nama_pengguna }}" class="custom-input" required
                                        oninvalid="this.setCustomValidity('Kolom ini harus diisi')"
                                        oninput="this.setCustomValidity('')">
                                </div>
                                <div class="mb-6">
                                    <label for="posisi"
                                        class="block mb-2 text-sm font-medium text-gray-700">Posisi</label>
                                    <input type="text" name="posisi" id="posisi" value="{{ $user->posisi }}"
                                        class="custom-input" required
                                        oninvalid="this.setCustomValidity('Kolom ini harus diisi')"
                                        oninput="this.setCustomValidity('')">
                                </div>
                                <div class="mb-6">
                                    <label for="tugas"
                                        class="block mb-2 text-sm font-medium text-gray-700">Tugas</label>
                                    <input type="text" name="tugas" id="tugas" value="{{ $user->tugas }}"
                                        class="custom-input" required
                                        oninvalid="this.setCustomValidity('Kolom ini harus diisi')"
                                        oninput="this.setCustomValidity('')">
                                </div>
                                <div class="mb-6">
                                    <label for="role_{{ $user->id }}"
                                        class="block mb-2 text-sm font-medium text-gray-700">Role</label>
                                    <select name="role" id="role_{{ $user->id }}" class="custom-input" required>
                                        <option class="text-center" value="" disabled
                                            {{ $user->role ? '' : 'selected' }}>-- Pilih
                                            Role --</option>
                                        <option value="Admin" {{ $user->role == 'Admin' ? 'selected' : '' }}>
                                            Admin
                                        </option>
                                        <option value="User" {{ $user->role == 'User' ? 'selected' : '' }}>
                                            User
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-6">
                                    <label for="foto"
                                        class="block mb-2 text-sm font-medium text-gray-700">Foto</label>
                                    @if ($user->foto)
                                        <div class="mb-4 flex justify-center">
                                            <img src="{{ Storage::url($user->foto) }}" alt="Foto User"
                                                class="w-32 h-32 object-cover rounded-md">
                                        </div>
                                    @endif
                                    <input type="file" name="foto" id="foto"
                                        class="file-input custom-file-input">
                                    <p class="mt-1 text-sm text-gray-500">
                                        Format File: jpg, jpeg, png. Maksimal 2MB
                                    </p>
                                </div>
                                <div class="mb-6">
                                    <label for="password"
                                        class="block mb-2 text-sm font-medium text-gray-700">Password</label>
                                    <input type="password" name="password" id="password" class="custom-input"
                                        placeholder="Kosongkan jika tidak diubah">
                                </div>
                                <div class="flex justify-end gap-2 mt-6">
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-emerald-700 text-white text-sm font-semibold rounded-md hover:bg-emerald-800 transition">
                                        <i class="fas fa-save mr-2"></i>Simpan
                                    </button>
                                    <button type="button"
                                        onclick="document.getElementById('ubah_pengguna_{{ $user->id }}').close()"
                                        class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 text-sm font-semibold rounded-md hover:bg-gray-400 transition">
                                        <i class="fas fa-times mr-2"></i>Tutup
                                    </button>
                                </div>
                            </form>
                        </div>
                    </dialog>
                    <!-- Lihat Foto -->
                    <dialog id="lihat_foto_{{ $user->id }}" class="modal">
                        <div class="modal-box max-w-md w-full">
                            <h3 class="text-xl font-semibold mb-4">Foto</h3>
                            <hr class="border-gray-800 border-1 my-4">
                            <div class="flex justify-center items-center text-gray-700 text-sm">
                                @if ($user->foto)
                                    <img src="{{ asset('storage/' . $user->foto) }}"
                                        alt="Foto {{ $user->nama_pengguna }}"
                                        class="w-60 h-60 object-cover rounded-md shadow-md">
                                @else
                                    <p class="text-sm text-gray-500">Tidak ada foto yang tersedia</p>
                                @endif
                            </div>
                            <div class="flex justify-end mt-6">
                                <button type="button"
                                    onclick="document.getElementById('lihat_foto_{{ $user->id }}').close()"
                                    class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 text-sm font-semibold rounded-md hover:bg-gray-400 transition">
                                    <i class="fas fa-times mr-2"></i>Tutup
                                </button>
                            </div>
                        </div>
                    </dialog>
                    <!-- Hapus Modal -->
                    <dialog id="hapus_pengguna_{{ $user->id }}" class="modal">
                        <div class="modal-box max-w-md w-full">
                            <h3 class="text-xl font-semibold text-red-600 mb-4">Konfirmasi Hapus</h3>
                            <p class="text-gray-700 mb-6">
                                Apakah Anda yakin ingin menghapus <span
                                    class="font-bold">{{ $user->nama_pengguna }}</span>?
                                Tindakan ini tidak dapat dibatalkan
                            </p>
                            <form action="{{ route('admin.pengguna.hapus', $user->id) }}" method="POST"
                                class="mt-6 flex justify-end gap-2">
                                @csrf
                                @method('DELETE')
                                <div class="flex justify-end gap-2">
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-md hover:bg-red-700 transition">
                                        <i class="fas fa-trash-alt mr-2"></i>Hapus
                                    </button>
                                    <button type="button"
                                        onclick="document.getElementById('hapus_pengguna_{{ $user->id }}').close()"
                                        class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 text-sm font-semibold rounded-md hover:bg-gray-400 transition">
                                        <i class="fas fa-times mr-2"></i>Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </dialog>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Tambah Modal -->
<dialog id="tambah_pengguna" class="modal">
    <div class="modal-box max-w-md w-full">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Tambah Pengguna</h3>
        <hr class="border-gray-800 border-1 my-4">
        <form action="{{ route('admin.pengguna.tambah') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-6">
                <label for="nip" class="block mb-2 text-sm font-medium text-gray-700">
                    NIP
                </label>
                <input type="text" name="nip" id="nip" class="custom-input" required
                    oninvalid="this.setCustomValidity('Kolom ini harus diisi')" oninput="this.setCustomValidity('')">
            </div>
            <div class="mb-6">
                <label for="nama_pengguna" class="block mb-2 text-sm font-medium text-gray-700">
                    Nama Pengguna
                </label>
                <input type="text" name="nama_pengguna" id="nama_pengguna" class="custom-input" required
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
                <label for="tugas" class="block mb-2 text-sm font-medium text-gray-700">
                    Tugas
                </label>
                <input type="text" name="tugas" id="tugas" class="custom-input" required
                    oninvalid="this.setCustomValidity('Kolom ini harus diisi')" oninput="this.setCustomValidity('')">
            </div>
            <div class="mb-6">
                <label for="role" class="block mb-2 text-sm font-medium text-gray-700">
                    Role
                </label>
                <select name="role" id="role" class="custom-input" required>
                    <option class="text-center" value="" disabled selected>-- Pilih Role --</option>
                    <option value="Admin">Admin</option>
                    <option value="User">User</option>
                </select>
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
                <button type="button" onclick="document.getElementById('tambah_pengguna').close()"
                    class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 text-sm font-semibold rounded-md hover:bg-gray-400 transition">
                    <i class="fas fa-times mr-2"></i>Tutup
                </button>
            </div>
        </form>
    </div>
</dialog>
