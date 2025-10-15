<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/style.css', 'resources/js/app.js']); ?>
    <!-- 
    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->

</head>

<body>
    <!-- Navbar -->
    <?php echo $__env->make('layouts.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- Content -->
            <div class="col-md-10 p-4">
                <h4 class="mb-4">Tambah Kategori</h4>
                <form action="<?php echo e(route('barang.tambahkategori')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="mb-3">
                            <label class="form-label">Nama Satuan Barang</label>
                            <input type="text" class="form-control" name="Nama_Kategori"
                                placeholder="Masukkan Nama Satuan Baru." required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-save mt-3">Save</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html><?php /**PATH F:\Proyek\Kuliah\Website\skripsi\resources\views/tambahsatuan.blade.php ENDPATH**/ ?>