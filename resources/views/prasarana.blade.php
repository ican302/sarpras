<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <h1 class="text-3xl font-semibold">Data Prasarana</h1>
            <br>
            <hr class="border-gray-800 border-1">
            <br>
            <form method="GET" action="{{ route('prasarana.index') }}"
                class="flex items-end justify-end gap-2 w-full flex-wrap mb-8">
                <input type="text" name="search" value="{{ request('search') }}" class="max-w-sm custom-input"
                    placeholder="Cari Bangunan atau Tanah">
                <div class="dropdown w-[200px] relative z-20">
                    <div class="text-sm font-medium text-gray-700 mb-1">
                        Filter
                    </div>
                    <div id="dropdownButtonFilter"
                        class="custom-input cursor-pointer relative flex justify-between items-center px-4 py-2 border border-gray-300 rounded-md bg-white h-[2.6rem]"
                        onclick="toggleDropdown('dropdownMenuFilter')">
                        <span class="text-sm py-[0.23rem] text-gray-700" id="selectedFilterText">
                            {{ request('filter') === 'Bangunan' ? 'Bangunan' : (request('filter') === 'Tanah' ? 'Tanah' : 'Semua') }}
                        </span>
                        <i class="fas fa-chevron-down ml-2 text-gray-500"></i>
                    </div>
                    <div id="dropdownMenuFilter"
                        class="dropdown-menu absolute z-10 mt-1 w-full bg-white border border-gray-200 rounded-md shadow-lg"
                        style="display: none;">
                        <div class="dropdown-item text-sm px-4 py-2 hover:bg-gray-100 cursor-pointer rounded-t-md"
                            onclick="selectOption('Semua', 'dropdownButtonFilter', 'filter', 'Semua')">
                            Semua
                        </div>
                        <div class="dropdown-item text-sm px-4 py-2 hover:bg-gray-100 cursor-pointer"
                            onclick="selectOption('Bangunan', 'dropdownButtonFilter', 'filter', 'Bangunan')">
                            Bangunan
                        </div>
                        <div class="dropdown-item text-sm px-4 py-2 hover:bg-gray-100 cursor-pointer rounded-b-md"
                            onclick="selectOption('Tanah', 'dropdownButtonFilter', 'filter', 'Tanah')">
                            Tanah
                        </div>
                    </div>
                    <input type="hidden" name="filter" id="filter" value="{{ request('filter', 'Semua') }}">
                </div>
                <button type="submit" class="px-4 py-2 text-white bg-black rounded-md shadow-lg h-[2.55rem]">
                    Cari
                </button>
            </form>

            @include('tables.bangunan')
            <br>
            <br>
            @include('tables.tanah')
        </div>
    </div>
</x-app-layout>
