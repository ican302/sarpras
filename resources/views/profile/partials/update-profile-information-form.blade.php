<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informasi Profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Perbarui informasi profil, NIP, dan foto akun Anda') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="nama_pengguna" :value="__('Nama Lengkap')" />
            <input id="nama_pengguna" name="nama_pengguna" type="text" class="custom-input mt-1"
                value="{{ old('nama_pengguna', $user->nama_pengguna) }}" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('nama_pengguna')" />
        </div>

        <div>
            <x-input-label for="nip" :value="__('NIP')" />
            <input id="nip" name="nip" type="text" class="custom-input mt-1"
                value="{{ old('nip', $user->nip) }}" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('nip')" />
        </div>

        <div>
            <div class="mb-6">
                <label for="foto" class="block mb-2 text-sm font-medium text-gray-700">
                    Foto
                </label>
                <input type="file" name="foto" id="foto" class="file-input custom-file-input" />
                <x-input-error class="mt-2" :messages="$errors->get('foto')" />
            </div>

            @if ($user->foto)
                <div class="mt-6">
                    <p class="text-sm text-gray-600 mb-2">Foto Saat Ini:</p>
                    <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto Profil" class="w-40 h-40 object-cover">
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Tersimpan') }}</p>
            @endif
        </div>
    </form>
</section>
