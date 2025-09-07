<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <h1 class="text-3xl font-semibold">Visi & Misi</h1>
            <br>
            <hr class="border-gray-800 border-1">
            <br>
            <div class="flex items-center justify-end mb-6">
                <button
                    class="inline-flex items-center px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white text-sm font-medium rounded-lg shadow-lg transition"
                    onclick="ubah_visimisi.showModal()">
                    <i class="fas fa-edit mr-2"></i>
                    Ubah
                </button>
            </div>
            <div class="flex flex-col md:flex-row gap-6">
                <div class="bg-white shadow-lg rounded-lg p-6 flex-1">
                    <h2 class="text-xl font-bold mb-2">Visi</h2>
                    <p class="text-gray-700">
                        {!! nl2br(e($visiMisi->visi ?? 'Belum ada visi yang ditambahkan')) !!}
                    </p>
                </div>
                <div class="bg-white shadow-lg rounded-lg p-6 flex-1">
                    <h2 class="text-xl font-bold mb-2">Misi</h2>
                    <p class="text-gray-700">
                        {!! nl2br(e($visiMisi->misi ?? 'Belum ada misi yang ditambahkan')) !!}
                    </p>
                </div>

                <!-- Ubah Modal -->
                <dialog id="ubah_visimisi" class="modal modal-middle">
                    <div class="modal-box max-w-md w-full">
                        <h3 class="text-xl font-semibold text-gray-800">Ubah Visi & Misi</h3>
                        <hr class="border-gray-800 border-1 my-4">
                        <form action="{{ route('admin.visimisi.update') }}" method="POST">
                            @csrf
                            <div class="mb-6">
                                <label for="visi" class="block mb-2 text-sm font-medium text-gray-700">
                                    Visi
                                </label>
                                <textarea name="visi" id="visi" cols="30" rows="10" class="custom-input">{{ old('visi', $visiMisi->visi ?? '') }}</textarea>
                            </div>
                            <div class="mb-6">
                                <label for="misi" class="block mb-2 text-sm font-medium text-gray-700">
                                    Misi
                                </label>
                                <textarea name="misi" id="misi" cols="30" rows="10" class="custom-input">{{ old('misi', $visiMisi->misi ?? '') }}</textarea>
                            </div>
                            <div class="flex justify-end gap-2 mt-6">
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-emerald-700 text-white text-sm font-semibold rounded-md hover:bg-emerald-800 transition">
                                    <i class="fas fa-save mr-2"></i>Simpan
                                </button>
                                <button type="button" onclick="document.getElementById('ubah_visimisi').close()"
                                    class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 text-sm font-semibold rounded-md hover:bg-gray-400 transition">
                                    <i class="fas fa-times mr-2"></i>Tutup
                                </button>
                            </div>
                        </form>
                    </div>
                </dialog>
            </div>
        </div>
    </div>
</x-app-layout>
