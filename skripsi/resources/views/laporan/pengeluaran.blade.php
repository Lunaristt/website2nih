<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Pengeluaran Bulanan - Toko Sumber Rejeki</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/style.css', 'resources/js/app.js'])
</head>

<body>
    @include('layouts.navbar')
    @include('layouts.sidebar')

    <div class="col-md-10 content p-4">
        <h4 class="fw-bold mb-4">📊 Laporan Pengeluaran Bulanan</h4>

        <!-- Filter Bulan -->
        <form method="GET" action="{{ route('laporan.pengeluaran') }}" class="row g-3 mb-4">
            <div class="col-md-3">
                <label for="bulan" class="form-label fw-semibold">Pilih Bulan</label>
                <input type="month" id="bulan" name="bulan" class="form-control"
                    value="{{ request('bulan', now()->format('Y-m')) }}">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary fw-semibold">Tampilkan</button>
            </div>
        </form>

        @if(isset($pembelian) && count($pembelian) > 0)
            <div class="card shadow-sm p-3">
                <h5 class="fw-bold mb-3">
                    Periode: {{ \Carbon\Carbon::parse($bulan . '-01')->translatedFormat('F Y') }}
                </h5>

                <table class="table table-striped align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Tanggal</th>
                            <th>Nama Distributor</th>
                            <th>Salesman</th>
                            <th>Total Pembelian (Rp)</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $totalBulan = 0; @endphp
                        @foreach($pembelian as $p)
                                    <tr>
                                        <td class="text-center">{{ \Carbon\Carbon::parse($p->Tanggal)->format('d/m/Y') }}</td>
                                        <td>{{ $p->distributor->Nama_Distributor ?? '-' }}</td>
                                        <td>{{ $p->distributor->Nama_Salesman ?? '-' }}</td>
                                        <td class="text-end">{{ number_format($p->Harga_Keseluruhan, 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            <span class="badge 
                                                        {{ $p->Status === 'Selesai' ? 'bg-success' :
                            ($p->Status === 'Pending' ? 'bg-warning text-dark' : 'bg-danger') }}">
                                                {{ $p->Status }}
                                            </span>
                                        </td>
                                    </tr>
                                    @php $totalBulan += $p->Harga_Keseluruhan; @endphp
                        @endforeach
                    </tbody>
                    <tfoot class="fw-bold">
                        <tr class="table-light">
                            <td colspan="3" class="text-end">Total Pengeluaran Bulan Ini:</td>
                            <td class="text-end">Rp {{ number_format($totalBulan, 0, ',', '.') }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @else
            <div class="alert alert-info mt-3 text-center">
                Tidak ada data pembelian pada bulan ini.
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>