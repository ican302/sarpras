<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SARPRAS SMKN 1 Tirtamulya</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Tailwindcss -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/ScrollTrigger.min.js"></script>

    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

    <style>
        html {
            scroll-behavior: smooth;
        }

        .custom-input {
            background-color: #F9FAFB;
            border: 1px solid #D1D5DB;
            color: #000;
            border-radius: 0.5rem;
            padding: 0.5rem;
            width: 100%;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .custom-input:focus {
            border-color: #1F2937;
            box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.5);
            outline: none;
        }
    </style>
</head>

<body class="font-montserrat antialiased">
    <!-- Headbar -->
    <div class="bg-white border-b border-gray-100 fixed shadow-lg z-40 w-full top-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-[0.35rem] md:space-x-2">
                        <span class="relative px-4 py-2 bg-black text-white font-bold rounded-md">SARPRAS</span>
                        <span class="text-black hidden md:block">SMKN 1 Tirtamulya</span>
                    </a>
                </div>
                <div class="flex items-center">
                    @auth
                        @if (Auth::user()->role === 'Admin')
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-[0.35rem] text-black">
                                <i class="fas fa-sign-in-alt"></i>
                                Beranda
                            </a>
                        @elseif (Auth::user()->role === 'User')
                            <a href="{{ route('user.dashboard') }}" class="flex items-center gap-[0.35rem] text-black">
                                Beranda
                                <i class="fas fa-sign-in-alt"></i>
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="flex items-center gap-[0.35rem] text-black">
                            Masuk
                            <i class="fas fa-sign-in-alt"></i>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Hero -->
    <section class="relative bg-white text-black h-screen flex items-center justify-center bg-cover bg-center">
        <div class="relative z-10 text-center px-4">
            <img src="{{ asset('images/logo.png') }}" alt="Logo"
                class="w-40 h-40 mx-auto mt-20 mb-10 object-contain">
            <h1 class="text-3xl md:text-4xl font-extrabold leading-tight mt-10 md:mt-0">
                Selamat Datang di<br>Sarana & Prasarana SMKN 1 Tirtamulya
            </h1>
            <p class="mt-10 text-lg text-black">
                Mengelola sarana dan prasarana sekolah dengan mudah dan efisien
            </p>
            {{-- <a href="#peminjaman"
                class="mt-10 inline-block bg-[#3A3A3A] hover:bg-black text-white font-semibold py-3 px-6 rounded-lg shadow-xl">
                Ajukan Peminjaman
            </a> --}}
        </div>
    </section>

    @if ($visiMisi && ($visiMisi->visi || $visiMisi->misi))
        <section class="py-20 bg-black">
            <div class="max-w-6xl mx-auto px-6 text-center">
                <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-12">
                    Visi & Misi
                </h2>
                <div class="grid md:grid-cols-2 gap-12 items-stretch">
                    @if ($visiMisi->visi)
                        <div
                            class="bg-white p-8 rounded-xl shadow-xl h-full flex flex-col transform transition-transform duration-300 hover:scale-105">
                            <h3 class="text-2xl font-bold text-black mb-4">Visi</h3>
                            <p class="text-gray-600 leading-relaxed">
                                {!! nl2br(e($visiMisi->visi)) !!}
                            </p>
                        </div>
                    @endif
                    @if ($visiMisi->misi)
                        <div
                            class="bg-white p-8 rounded-xl shadow-xl h-full flex flex-col transform transition-transform duration-300 hover:scale-105">
                            <h3 class="text-2xl font-bold text-black mb-4">Misi</h3>
                            <p class="text-gray-600 leading-relaxed">
                                {!! nl2br(e($visiMisi->misi)) !!}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    {{-- @if ($ketua || $wakilKetua || $staffAdmin || ($staff && $staff->count()))
        <!-- Struktur Organisasi -->
        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-6">
                <h2 class="text-3xl md:text-4xl font-extrabold text-center text-black mb-16">
                    Struktur Organisasi
                </h2>
                <!-- Ketua & Wakil -->
                <div class="flex flex-col md:flex-row justify-center items-center gap-16 mb-16">
                    @if ($ketua)
                        <div class="text-center transform transition-transform duration-300 hover:scale-105">
                            <img src="{{ $ketua->foto ? Storage::url($ketua->foto) : asset('images/default.png') }}"
                                alt="Ketua" class="w-32 h-32 rounded-full object-cover mx-auto mb-4">
                            <h3 class="text-xl font-semibold text-gray-800">{{ $ketua->nama }}</h3>
                            <p class="text-gray-600 text-sm">{{ $ketua->posisi }}</p>
                        </div>
                    @endif
                    @if ($wakilKetua)
                        <div class="text-center transform transition-transform duration-300 hover:scale-105">
                            <img src="{{ $wakilKetua->foto ? Storage::url($wakilKetua->foto) : asset('images/default.png') }}"
                                alt="Wakil Ketua" class="w-32 h-32 rounded-full object-cover mx-auto mb-4">
                            <h3 class="text-xl font-semibold text-gray-800">{{ $wakilKetua->nama }}</h3>
                            <p class="text-gray-600 text-sm">{{ $wakilKetua->posisi }}</p>
                        </div>
                    @endif
                </div>
                <!-- Staff Admin -->
                <div class="flex flex-col md:flex-row justify-center items-center gap-16 mb-16">
                    @if ($staffAdmin)
                        <div class="text-center transform transition-transform duration-300 hover:scale-105">
                            <img src="{{ $staffAdmin->foto ? Storage::url($staffAdmin->foto) : asset('images/default.png') }}"
                                alt="Staff Admin" class="w-28 h-28 rounded-full object-cover mx-auto mb-4">
                            <h3 class="text-xl font-semibold text-gray-800">{{ $staffAdmin->nama }}</h3>
                            <p class="text-gray-600 text-sm">{{ $staffAdmin->posisi }}</p>
                        </div>
                    @endif
                </div>
                <!-- Staff -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-12 text-center">
                    @foreach ($staff as $s)
                        <div class="transform transition-transform duration-300 hover:scale-105">
                            <img src="{{ $s->foto ? Storage::url($s->foto) : asset('images/default.png') }}"
                                alt="Staff" class="w-28 h-28 rounded-full object-cover mx-auto mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">{{ $s->nama }}</h3>
                            <p class="text-gray-600 text-sm">{{ $s->posisi }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif --}}

    <!-- Ajukan Peminjaman -->
    {{-- <section id="peminjaman" class="py-20 bg-black">
        <div class="max-w-4xl mx-auto px-6">
            <h2 class="text-3xl md:text-4xl font-extrabold text-center text-white mb-12">
                Ajukan Peminjaman Sarana dan Prasarana
            </h2>
            <p class="text-lg text-white text-center mb-10">
                Silakan isi formulir di bawah ini untuk mengajukan peminjaman fasilitas sekolah
            </p>
            <form id="form-peminjaman" action="javascript:void(0)" enctype="multipart/form-data"
                class="bg-white p-8 md:p-10 rounded-2xl shadow-xl" target="_blank">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="dropdown w-full relative">
                        <label for="penyewaan_id" class="block mb-2 text-sm font-medium text-black">
                            Nama Sarana/Prasarana
                        </label>
                        <div id="dropdownButtonPenyewaan"
                            class="custom-input cursor-pointer h-[2.60rem] relative flex justify-between items-center px-4 border border-gray-300 rounded-md bg-white"
                            onclick="toggleDropdown('dropdownMenuPenyewaan')">
                            <span class="text-sm text-gray-700" id="selectedTextPenyewaan">
                                -- Pilih Sarana/Prasarana --
                            </span>
                            <i class="fas fa-chevron-down ml-2 text-gray-500"></i>
                        </div>
                        <div id="dropdownMenuPenyewaan"
                            class="dropdown-menu absolute z-10 mt-1 w-full bg-white border border-gray-200 rounded-md shadow-lg"
                            style="display: none;">
                            @foreach ($penyewaans as $penyewaan)
                                <div class="dropdown-item text-sm px-4 py-2 hover:bg-gray-100 cursor-pointer"
                                    onclick="selectOption('{{ $penyewaan->id }}', 'dropdownButtonPenyewaan', 'penyewaan_id', '{{ $penyewaan->penyewaanable->nama ?? 'Nama Tidak Diketahui' }} (Stok: {{ $penyewaan->jumlah }})')">
                                    {{ $penyewaan->penyewaanable->nama ?? 'Nama Tidak Diketahui' }} (Stok:
                                    {{ $penyewaan->jumlah }})
                                </div>
                            @endforeach
                        </div>
                        <input type="hidden" name="penyewaan_id" id="penyewaan_id" value="">
                        <small id="error-penyewaan" class="text-red-500 text-sm hidden">
                            Silakan pilih salah satu sarana atau prasarana terlebih dahulu
                        </small>
                    </div>
                    <div>
                        <label for="peminjam" class="block mb-2 text-sm font-medium text-black">
                            Nama Peminjam
                        </label>
                        <input type="text" name="peminjam" id="peminjam" class="custom-input" required
                            oninvalid="this.setCustomValidity('Kolom ini harus diisi')"
                            oninput="this.setCustomValidity('')">
                    </div>
                    <div>
                        <label for="jumlah" class="block mb-2 text-sm font-medium text-black">
                            Jumlah
                        </label>
                        <input type="number" name="jumlah" id="jumlah" min="1" class="custom-input"
                            required oninvalid="this.setCustomValidity('Kolom ini harus diisi')"
                            oninput="this.setCustomValidity('')">
                    </div>
                    <div>
                        <label for="no_wa" class="block mb-2 text-sm font-medium text-black">
                            Nomor WhatsApp
                        </label>
                        <input type="number" name="no_wa" id="no_wa" placeholder="08xxxxxxxxxx"
                            class="custom-input" required oninvalid="this.setCustomValidity('Kolom ini harus diisi')"
                            oninput="this.setCustomValidity('')">
                    </div>
                    <div>
                        <label for="tanggal_mulai" class="block mb-2 text-sm font-medium text-black">
                            Tanggal Mulai
                        </label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="custom-input" required
                            oninvalid="this.setCustomValidity('Kolom ini harus diisi')"
                            oninput="this.setCustomValidity('')">
                    </div>
                    <div>
                        <label for="tanggal_selesai" class="block mb-2 text-sm font-medium text-black">
                            Tanggal Selesai
                        </label>
                        <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="custom-input"
                            required oninvalid="this.setCustomValidity('Kolom ini harus diisi')"
                            oninput="this.setCustomValidity('')">
                    </div>
                    <div id="estimasi-harga" class="item-center text-black font-semibold hidden">
                        Estimasi Total Harga: <span id="total-harga" class="text-green-600">Rp 0</span>
                    </div>
                    <div class="md:col-span-2">
                        <label for="keterangan" class="block mb-2 text-sm font-medium text-black">
                            Keterangan
                        </label>
                        <textarea name="keterangan" id="keterangan" rows="4" class="custom-input"></textarea>
                    </div>
                </div>
                <div class="flex justify-center mt-8">
                    <button type="submit"
                        class="mt-8 inline-block bg-[#3A3A3A] hover:bg-black text-white font-semibold py-3 px-6 rounded-lg shadow-xl">
                        Ajukan Peminjaman
                    </button>
                </div>
            </form>
        </div>
    </section> --}}

    {{-- <a href="https://wa.me/628558359732" target="_blank"
        class="fixed bottom-3 right-3 z-30 bg-[#3A3A3A] hover:bg-black text-white rounded-full w-16 p-3 shadow-lg transition duration-300 flex items-center justify-center"
        data-aos="fade-left" data-aos-easing="ease-in-sine" data-aos-duration="700">
        <i class="fa-brands fa-whatsapp text-4xl"></i>
    </a> --}}

    <!-- Footer -->
    <footer class="bg-white text-black border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-6 py-10 grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Info Sekolah -->
            <div>
                <h2 class="text-lg font-semibold mb-3">Sarana & Prasarana</h2>
                <p class="text-sm mb-1">SMKN 1 Tirtamulya</p>
                <p class="text-sm text-gray-600">&copy; 2025. All rights reserved.</p>
            </div>
            <!-- Kontak -->
            <div>
                <h2 class="text-lg font-semibold mb-3">Kontak</h2>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-gray-600 mt-0.5" fill="none" stroke="currentColor"
                            stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.5 3.75v1.5a.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75v-1.5M4.5 6.75h15a1.5 1.5 0 011.5 1.5v10.5a1.5 1.5 0 01-1.5 1.5h-15a1.5 1.5 0 01-1.5-1.5V8.25a1.5 1.5 0 011.5-1.5z" />
                        </svg>
                        <a href="mailto:smkn1tirtamulya@gmail.com"
                            class="hover:underline transition duration-150 ease-in-out">
                            smkn1tirtamulya@gmail.com
                        </a>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-gray-600 mt-0.5" fill="none" stroke="currentColor"
                            stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 6.75v-1.5A1.5 1.5 0 013.75 3.75h16.5a1.5 1.5 0 011.5 1.5v1.5m-19.5 0h19.5m-19.5 0v10.5a1.5 1.5 0 001.5 1.5h16.5a1.5 1.5 0 001.5-1.5V6.75m-19.5 0l9.75 6.375L21.75 6.75" />
                        </svg>
                        <a href="tel:08561939668" class="hover:underline transition duration-150 ease-in-out">
                            0856-1939-668
                        </a>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-gray-600 mt-0.5" fill="none" stroke="currentColor"
                            stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.5 10.5c0 4.694-4.5 9-4.5 9s-4.5-4.306-4.5-9a4.5 4.5 0 119 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 13.5a3 3 0 100-6 3 3 0 000 6z" />
                        </svg>
                        <p>
                            Jl. Raya Parakan, Tirtamulya,<br>
                            Kabupaten Karawang, Jawa Barat 41372
                        </p>
                    </li>
                </ul>
            </div>
        </div>
    </footer>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script>
        // Dropdown Toggle
        function toggleDropdown(menuId) {
            const menu = document.getElementById(menuId);
            menu.style.display = menu.style.display === "none" || menu.style.display === "" ? "block" : "none";
        }

        // Dropdown Select Option
        function selectOption(value, buttonId, inputId, label = null) {
            const button = document.getElementById(buttonId);
            const span = button.querySelector('span');
            const input = document.getElementById(inputId);

            if (span) span.textContent = label || value;
            if (input) input.value = value;

            const dropdownMenus = document.querySelectorAll('.dropdown-menu');
            dropdownMenus.forEach(menu => menu.style.display = 'none');
        }

        // Dropdown Event Listener
        document.addEventListener('click', function(event) {
            const isClickInside = event.target.closest('.dropdown');
            if (!isClickInside) {
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    menu.style.display = 'none';
                });
            }
        });
    </script>

    {{-- <script>
        // Form Submit & Payment
        document.querySelector('form').addEventListener('submit', async function(e) {
            e.preventDefault();

            const penyewaanId = document.getElementById('penyewaan_id').value;
            if (!penyewaanId) {
                document.getElementById('error-penyewaan').classList.remove('hidden');
                return;
            } else {
                document.getElementById('error-penyewaan').classList.add('hidden');
            }

            const formData = new FormData(this);

            const snapRes = await fetch("{{ route('get.snap.token') }}", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            });

            const snapData = await snapRes.json();

            window.snap.pay(snapData.snapToken, {

                onSuccess: async function(result) {
                    const transaksiData = new FormData(document.querySelector('form'));
                    transaksiData.append('order_id', snapData.order_id);

                    await fetch("{{ route('simpan.transaksi') }}", {
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: transaksiData
                    });

                    window.location.href = "{{ route('pembayaran.sukses') }}?order_id=" + snapData
                        .order_id;
                },

                onPending: function(result) {
                    alert("Menunggu Pembayaran");
                },
                onError: function(result) {
                    alert("Pembayaran Gagal");
                },
            });
        });

        // Hitung Total Harga
        const hargaPerBarang = @json($penyewaans->pluck('harga', 'id'));
        const penyewaanSelect = document.getElementById('penyewaan_id');
        const jumlahInput = document.getElementById('jumlah');
        const tanggalMulaiInput = document.getElementById('tanggal_mulai');
        const tanggalSelesaiInput = document.getElementById('tanggal_selesai');
        const totalHargaText = document.getElementById('total-harga');
        const estimasiHargaDiv = document.getElementById('estimasi-harga');

        function hitungTotalHarga() {
            const penyewaanId = penyewaanSelect.value;
            const jumlah = parseInt(jumlahInput.value);
            const tanggalMulai = new Date(tanggalMulaiInput.value);
            const tanggalSelesai = new Date(tanggalSelesaiInput.value);

            if (penyewaanId && jumlah && tanggalMulai && tanggalSelesai && tanggalSelesai >= tanggalMulai) {
                const harga = hargaPerBarang[penyewaanId];
                const selisihHari = Math.floor((tanggalSelesai - tanggalMulai) / (1000 * 60 * 60 * 24)) + 1;
                const total = harga * jumlah * selisihHari;
                totalHargaText.innerText = `Rp ${total.toLocaleString('id-ID')}`;
                estimasiHargaDiv.classList.remove('hidden');
            } else {
                estimasiHargaDiv.classList.add('hidden');
            }
        }

        // // Harga Event Listener
        penyewaanSelect.addEventListener('change', hitungTotalHarga);
        jumlahInput.addEventListener('input', hitungTotalHarga);
        tanggalMulaiInput.addEventListener('change', hitungTotalHarga);
        tanggalSelesaiInput.addEventListener('change', hitungTotalHarga);
    </script> --}}

</body>

</html>
