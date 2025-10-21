<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pajak Bulanan - Toko Sumber Rejeki</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/style.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    @include('layouts.navbar')
    @include('layouts.sidebar')

    <!-- Content -->
    <div class="col-md-10 content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">Laporan Pajak Bulanan (PPh Final 0,5%)</h4>
            <a href="{{ route('pajak') }}" class="btn btn-primary ms-2">🔄 Refresh</a>
        </div>

        <!-- Info -->
        <div class="alert alert-info mb-4">
            <strong>Keterangan:</strong> Pajak UMKM sebesar <b>0,5%</b> dihitung dari omzet bulanan apabila total omzet
            tahunan melebihi <b>Rp 500.000.000</b>.
        </div>

        <!-- Grafik Omzet -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h5 class="card-title text-center mb-3">Grafik Omzet Bulanan</h5>
                <canvas id="omzetChart" height="120"></canvas>
            </div>
        </div>

        <!-- Tabel Pajak Bulanan -->
        <div class="table-responsive">
            <table class="table table-hover align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Tahun</th>
                        <th>Bulan</th>
                        <th>Total Omzet Bulanan</th>
                        <th>PPh Final (0,5%)</th>
                        <th>Status Pajak</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $row)
                        <tr>
                            <td>{{ $row->Tahun }}</td>
                            <td>{{ $row->Nama_Bulan }}</td>
                            <td class="text-end">Rp {{ number_format($row->Total_Omzet, 0, ',', '.') }}</td>
                            <td class="text-end">
                                @if($row->PPh_Final > 0)
                                    Rp {{ number_format($row->PPh_Final, 0, ',', '.') }}
                                @else
                                    Rp 0
                                @endif
                            </td>
                            <td>
                                @if($row->Total_Omzet > 500000000)
                                    <span class="badge bg-danger">Wajib Bayar</span>
                                @else
                                    <span class="badge bg-success">Tidak Kena Pajak</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada data penjualan yang selesai.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Chart.js Script -->
    <script>
        const ctx = document.getElementById('omzetChart').getContext('2d');
        const omzetChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                    label: 'Total Omzet Bulanan (Rp)',
                    data: {!! json_encode($values) !!},
                    backgroundColor: 'rgba(139, 13, 24, 0.8)',
                    borderColor: 'rgba(139, 13, 24, 1)',
                    borderWidth: 1,
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom'
                    },
                    title: {
                        display: false
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function (value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>