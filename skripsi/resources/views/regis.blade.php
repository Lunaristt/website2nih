<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Toko Sumber Rejeki - Login</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  @vite(['resources/css/style.css', 'resources/js/app.js'])
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Toko Sumber Rejeki</a>
    </div>
    <div class="ms-auto me-2">
      <a href="{{ route('login') }}" class="btn btn-light fw-bold">Login</a>
    </div>
  </nav>

  <!-- Login Form -->
  <div class="container d-flex justify-content-center align-items-center" style="min-height: 85vh;">
    <div class="col-lg-6 col-md-8 col-sm-10">
      <div class="login-card">

        {{-- Pesan error jika login gagal --}}
        @if(session('error'))
          <div class="alert alert-danger">
            {{ session('error') }}
          </div>
        @endif

        {{-- Form login dengan koneksi ke route login.process --}}
        <form method="POST" action="{{ route('register.store') }}">
          @csrf
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="Nama" placeholder="Masukkan username" required>
          </div>
          <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="Password" placeholder="Masukkan password"
              required>
          </div>
          <div class="mb-4">
            <label for="notelp" class="form-label">Nomor Telepon</label>
            <input type="notelp" class="form-control" id="notelp" name="No_Telp" placeholder="Masukkan Nomor Telepon"
              required>
          </div>
          <button type="submit" class="btn btn-login">Daftar</button>
        </form>
      </div>
    </div>
  </div>
</body>

</html>