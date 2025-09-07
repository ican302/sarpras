<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- NIP -->
        <div>
            <x-input-label for="nip" :value="__('NIP')" />
            <input id="nip" class="custom-input mt-1" type="text" name="nip" :value="old('nip')" required
                autofocus autocomplete="username" oninvalid="this.setCustomValidity('Kolom ini harus diisi')"
                oninput="this.setCustomValidity('')" />
            <x-input-error :messages="$errors->get('nip')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Kata Sandi')" />

            <input id="password" class="custom-input mt-1" type="password" name="password" required
                autocomplete="current-password" oninvalid="this.setCustomValidity('Kolom ini harus diisi')"
                oninput="this.setCustomValidity('')" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-3">
                {{ __('Masuk') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
