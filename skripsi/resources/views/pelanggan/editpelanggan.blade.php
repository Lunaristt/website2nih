<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Pelanggan - Toko Sumber Rejeki</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/style.css', 'resources/js/app.js'])
</head>

<body>
    @include('layouts.navbar')
    @include('layouts.sidebar')

    <div class="col-md-10 content p-4">
        <h4 class="fw-bold mb-4">Edit Pelanggan</h4>

        <!-- Form Edit Pelanggan -->
        <form action="{{ route('pelanggan.update', $pelanggan->No_Telp) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="Nama_Pelanggan" class="form-label">Nama</label>
                    <input type="text" name="Nama_Pelanggan" id="Nama_Pelanggan" class="form-control"
                        value="{{ old('Nama_Pelanggan', $pelanggan->Nama_Pelanggan) }}" required>
                </div>
                <div class="col-md-6">
                    <label for="NoTelp_Pelanggan" class="form-label">Nomor Telepon</label>
                    <input type="text" name="NoTelp_Pelanggan" id="NoTelp_Pelanggan" class="form-control"
                        value="{{ old('NoTelp_Pelanggan', $pelanggan->No_Telp) }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="Alamat_Pelanggan" class="form-label">Alamat</label>
                <textarea name="Alamat_Pelanggan" id="Alamat_Pelanggan" class="form-control"
                    required>{{ old('Alamat_Pelanggan', $pelanggan->Alamat) }}</textarea>
            </div>

            <button type="submit" class="btn btn-success">💾 Simpan Perubahan</button>
            <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>