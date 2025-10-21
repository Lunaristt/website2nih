<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/style.css', 'resources/js/app.js'])
</head>

<body>
    <!-- Navbar -->
    @include('layouts.navbar')

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @include('layouts.sidebar')

            <!-- Content -->
            <div class="col-md-10 p-4">
                <h4 class="mb-4">Daftar Pelanggan</h4>

                {{-- Tombol Tambah --}}

                {{-- Tabel Pelanggan --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Nama</th>
                                <th>Nomor Telepon</th>
                                <th>Alamat</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pelanggan as $p)
                                <tr>
                                    <td>{{ $p->Nama_Pelanggan }}</td>
                                    <td>{{ $p->No_Telp }}</td>
                                    <td>{{ $p->Alamat }}</td>
                                    <td class="text-center">
                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('pelanggan.edit', $p->No_Telp) }}"
                                            class="btn btn-warning btn-sm text-black">
                                            ✏️ Edit
                                        </a>

                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('pelanggan.destroy', $p->No_Telp) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Hapus pelanggan {{ $p->Nama_Pelanggan }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada data pelanggan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <a href="{{ route('pelanggan.create') }}" class="btn btn-primary mb-3">Tambah Pelanggan</a>
            </div>
        </div>
    </div>
</body>

</html>