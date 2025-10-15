<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Toko Sumber Rejeki - Login</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <?php echo app('Illuminate\Foundation\Vite')(['resources/css/style.css', 'resources/js/app.js']); ?>
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Toko Sumber Rejeki</a>
    </div>
    <div class="ms-auto me-2">
      <a href="<?php echo e(route('register')); ?>" class="btn btn-light fw-bold">Daftar</a>
    </div>
  </nav>

  <!-- Login Form -->
  <div class="container d-flex justify-content-center align-items-center" style="min-height: 85vh;">
    <div class="col-lg-6 col-md-8 col-sm-10">
      <div class="login-card">

        
        <?php if(session('error')): ?>
          <div class="alert alert-danger">
            <?php echo e(session('error')); ?>

          </div>
        <?php endif; ?>

        
        <form method="POST" action="<?php echo e(route('login.process')); ?>">
          <?php echo csrf_field(); ?>
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="nama" placeholder="Enter username" required>
          </div>
          <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password"
              required>
          </div>
          <button type="submit" class="btn btn-login">Login</button>
        </form>
      </div>
    </div>
  </div>
</body>

</html><?php /**PATH F:\Proyek\Kuliah\Website\skripsi\resources\views/login.blade.php ENDPATH**/ ?>