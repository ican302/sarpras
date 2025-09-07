<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 space-y-6">
            <!-- Kartu Ringkasan -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Card Pengguna -->
                <div class="bg-white p-5 rounded-lg shadow-lg flex flex-col justify-between">
                    <div>
                        <h3 class="mb-2">Pengguna</h3>
                        <p class="text-2xl font-semibold">{{ $jumlahPengguna }}</p>
                    </div>
                    <a href="{{ route('admin.pengguna') }}"
                        class="mt-4 self-end px-3 py-1 text-sm bg-[#3A3A3A] hover:bg-black text-white rounded-md transition">
                        <i class="fas fa-eye mr-1"></i>
                        Lihat
                    </a>
                </div>
                <!-- Card Data Sarana -->
                <div class="bg-white p-5 rounded-lg shadow-lg flex flex-col justify-between">
                    <div>
                        <h3 class="mb-2">Data Sarana</h3>
                        <p class="text-2xl font-semibold">{{ $jumlahSarana }}</p>
                    </div>
                    <a href="{{ route('sarana.index') }}"
                        class="mt-4 self-end px-3 py-1 text-sm bg-[#3A3A3A] hover:bg-black text-white rounded-md transition">
                        <i class="fas fa-eye mr-1"></i>
                        Lihat
                    </a>
                </div>
                <!-- Card Data Prasarana -->
                <div class="bg-white p-5 rounded-lg shadow-lg flex flex-col justify-between">
                    <div>
                        <h3 class="mb-2">Data Prasarana</h3>
                        <p class="text-2xl font-semibold">
                            {{ $dataPrasarana->sum() }}
                        </p>
                    </div>
                    <a href="{{ route('prasarana.index') }}"
                        class="mt-4 self-end px-3 py-1 text-sm bg-[#3A3A3A] hover:bg-black text-white rounded-md transition">
                        <i class="fas fa-eye mr-1"></i>
                        Lihat
                    </a>
                </div>
            </div>
            <!-- Kartu Ringkasan -->
            {{-- <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Card Penyewaan -->
                <div class="bg-white p-5 rounded-lg shadow-lg flex flex-col justify-between">
                    <div>
                        <h3 class="mb-2">Penyewaan</h3>
                        <p class="text-3xl font-semibold">{{ $jumlahPenyewaan }}</p>
                    </div>
                    <a href="{{ route('penyewaan.index') }}"
                        class="mt-4 self-end px-3 py-1 text-sm bg-[#3A3A3A] hover:bg-black text-white rounded-md transition">
                        <i class="fas fa-eye mr-1"></i>
                        Lihat
                    </a>
                </div>
                <!-- Card Transaksi -->
                <div class="bg-white p-5 rounded-lg shadow-lg flex flex-col justify-between">
                    <div>
                        <h3 class="mb-2">Transaksi</h3>
                        <p class="text-3xl font-semibold">{{ $jumlahTransaksi }}</p>
                    </div>
                    <a href="{{ route('transaksi.index') }}"
                        class="mt-4 self-end px-3 py-1 text-sm bg-[#3A3A3A] hover:bg-black text-white rounded-md transition">
                        <i class="fas fa-eye mr-1"></i>
                        Lihat
                    </a>
                </div>
            </div> --}}

            <!-- Statistik Sarana -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-lg font-semibold mb-4">Statistik Sarana</h3>
                <canvas id="saranaChart" height="100"></canvas>
            </div>
            <!-- Statistik Prasarana -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-lg font-semibold mb-4">Statistik Prasarana</h3>
                <canvas id="prasaranaChart" height="100"></canvas>
            </div>
            <!-- Grafik Transaksi -->
            {{-- <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-lg font-semibold mb-4">Grafik Transaksi</h3>
                <canvas id="transaksiBulananChart" height="100"></canvas>
            </div> --}}
        </div>
    </div>
</x-app-layout>

<script>
    // Grafik Sarana
    const saranaLabels = {!! json_encode($dataSarana->keys()) !!};
    const saranaData = {!! json_encode($dataSarana->values()) !!};

    const ctx = document.getElementById('saranaChart').getContext('2d');
    const saranaChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: saranaLabels,
            datasets: [{
                label: 'Jumlah Sarana',
                data: saranaData,
                backgroundColor: [
                    'rgba(59, 130, 246, 0.7)',
                    'rgba(16, 185, 129, 0.7)',
                    'rgba(234, 179, 8, 0.7)',
                    'rgba(239, 68, 68, 0.7)',
                    'rgba(96, 165, 250, 0.7)',
                    'rgba(132, 204, 22, 0.7)'
                ],
                borderRadius: 6
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Grafik Prasarana
    const prasaranaLabels = {!! json_encode($dataPrasarana->keys()) !!};
    const prasaranaData = {!! json_encode($dataPrasarana->values()) !!};

    const ctxPrasarana = document.getElementById('prasaranaChart').getContext('2d');
    const prasaranaChart = new Chart(ctxPrasarana, {
        type: 'bar',
        data: {
            labels: prasaranaLabels,
            datasets: [{
                label: 'Jumlah Prasarana',
                data: prasaranaData,
                backgroundColor: [
                    'rgba(59, 130, 246, 0.7)',
                    'rgba(72, 187, 120, 0.7)'
                ],
                borderRadius: 6
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Grafik Transaksi
    const bulanLabels = {!! json_encode($bulanLabels) !!};
    const transaksiBulananData = {!! json_encode($transaksiPerBulanComplete) !!};

    const ctxTransaksiBulanan = document.getElementById('transaksiBulananChart').getContext('2d');
    const transaksiBulananChart = new Chart(ctxTransaksiBulanan, {
        type: 'line',
        data: {
            labels: bulanLabels,
            datasets: [{
                label: 'Jumlah Transaksi Per Bulan',
                data: transaksiBulananData,
                borderColor: 'rgba(59, 130, 246, 0.7)',
                backgroundColor: 'rgba(59, 130, 246, 0.7)',
                borderWidth: 2,
                fill: true,
                stepped: true
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 5
                    }
                }
            }
        }
    });
</script>
