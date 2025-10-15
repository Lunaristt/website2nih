<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Toko Sumber Rejeki - Home</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/style.css', 'resources/js/app.js']); ?>
</head>

<body>
    <?php echo $__env->make('layouts.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Content -->
    <div class="col-md-10 content">
        <h5 class="fw-bold">Informasi Terbaru:</h5>
        <p>Semen Merdeka Tersisa 5 Sak</p>
        <p>Semen Merdeka Tersisa 5 Sak</p>

        <div class="mt-5 text-center">
            <a href="<?php echo e(route('transaksi.create')); ?>" class="btn btn-order">Buat Pesanan Baru</a>
        </div>
    </div>
    </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html><?php /**PATH F:\Proyek\Kuliah\Website\skripsi\resources\views/home.blade.php ENDPATH**/ ?>