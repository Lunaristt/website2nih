<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Toko Sumber Rejeki - Home</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/style.css', 'resources/js/app.js'])
</head>

<body>
    @include('layouts.navbar')
    @include('layouts.sidebar')

    <!-- Content -->
    <div class="col-md-10 content">
        <h5 class="fw-bold">Informasi Terbaru:</h5>
        <p>Semen Merdeka Tersisa 5 Sak</p>
        <p>Semen Merdeka Tersisa 5 Sak</p>

        <div class="mt-5 text-center">
            <a href="{{ route('transaksi.create') }}" class="btn btn-order">Buat Pesanan Baru</a>
        </div>
    </div>
    </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>