<!-- Primary Navigation Menu -->
<nav x-data="menuHandler()" x-init="init()"
    class="bg-white border-b border-gray-100 fixed shadow-lg z-40 w-full top-0">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative font-montserrat">
        <div class="flex justify-between items-center h-20">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 items-center">
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="flex items-center space-x-[0.35rem] md:space-x-2">
                            <span class="relative px-4 py-2 bg-black text-white font-bold rounded-md">SARPRAS</span>
                            <span class="text-black">SMKN 1 Tirtamulya</span>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Mobile Menu Button -->
            <div class="-me-2 flex items-center">
                <span class="mt-[0.10rem]">MENU</span>
                <button @click="toggleMenu"
                    class="inline-flex items-center justify-center p-2 rounded-md transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <!-- Overlay -->
    <div x-show="open" @click="toggleMenu" x-cloak class="fixed inset-0 z-30 bg-black/45">
        <p class="mt-3 text-sm text-center text-white">
            Klik pada layar kosong untuk menutup menu
        </p>
    </div>
    <!-- Mobile Menu (gunakan id agar bisa diakses GSAP) -->
    <div id="mobileSidebar" x-cloak
        class="fixed top-[3.75rem] right-0 w-64 bg-white shadow-lg z-40 rounded-tl-lg rounded-bl-lg ring-1 ring-gray-200 translate-x-full opacity-0">
        <div class="py-3 px-4">
            <div class="space-y-1">
                @if (Auth::check())
                    @if (Auth::user()->role === 'Admin')
                        <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            <i class="fa-solid fa-chart-line mr-2"></i> {{ __('Beranda') }}
                        </x-responsive-nav-link>
                    @elseif (Auth::user()->role === 'User')
                        <x-responsive-nav-link :href="route('user.dashboard')" :active="request()->routeIs('user.dashboard')">
                            <i class="fa-solid fa-chart-line mr-2"></i> {{ __('Beranda') }}
                        </x-responsive-nav-link>
                    @endif
                @endif
                <x-responsive-nav-link :href="route('sarana.index')">
                    <i class="fas fa-box mr-2"></i> {{ __('Sarana') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('prasarana.index')">
                    <i class="fas fa-building mr-2"></i> {{ __('Prasarana') }}
                </x-responsive-nav-link>
                {{-- <x-responsive-nav-link :href="route('penyewaan.index')">
                    <i class="fa-solid fa-tags mr-2"></i> {{ __('Penyewaan') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('transaksi.index')">
                    <i class="fas fa-receipt mr-2"></i> {{ __('Transaksi') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('laporan.index')">
                    <i class="fas fa-file-alt mr-2"></i> {{ __('Laporan') }}
                </x-responsive-nav-link> --}}
                @if (Auth::check())
                    @if (Auth::user()->role === 'Admin')
                        <hr class="border-gray-800 border-1">
                        <x-responsive-nav-link :href="route('admin.pengguna')" :active="request()->routeIs('admin.pengguna')">
                            <i class="fas fa-users mr-2"></i> {{ __('Pengguna') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('admin.visimisi')" :active="request()->routeIs('admin.visimisi')">
                            <i class="fas fa-flag mr-2"></i> {{ __('Visi & Misi') }}
                        </x-responsive-nav-link>
                        {{-- <x-responsive-nav-link :href="route('struktur.index')" :active="request()->routeIs('struktur.index')">
                            <i class="fas fa-sitemap mr-2"></i> {{ __('Struktur Organisasi') }}
                        </x-responsive-nav-link> --}}
                    @endif
                @endif
                <hr class="border-gray-800 border-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    <i class="fas fa-user mr-2"></i> {{ __('Profile') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="fas fa-sign-out-alt mr-2"></i> {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
