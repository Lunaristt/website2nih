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
                <h4 class="mb-4">Tambah Barang</h4>
                <form action="<?php echo e(route('tambahbarang.store')); ?> " method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="mb-3">
                            <label class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" name="Nama_Barang"
                                placeholder="Masukkan Nama Barang. Contoh: Keni, Semen, Baja Ringan">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kategori Barang*</label>
                            <select class="form-control select2" name="ID_Kategori" required>
                                <option value="">Pilih kategori</option>
                                <?php $__currentLoopData = $kategoribarang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kategori): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($kategori->ID_Kategori); ?>"><?php echo e($kategori->Kategori_Barang); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Merek Barang*</label>
                            <input type="text" class="form-control" name="Merek_Barang"
                                placeholder="Masukkan Merek barang" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Harga Barang*</label>
                            <input type="number" class="form-control" name="Harga_Barang"
                                placeholder="Masukkan Harga Barang" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stok Barang*</label>
                            <input type="number" class="form-control" name="Stok_Barang"
                                placeholder="Masukkan Stok Barang" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Besar Satuan*</label>
                            <input type="text" class="form-control" name="Besar_Satuan" placeholder="Contoh: 1, 1/2">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Satuan*</label>
                            <select class="form-control" name="ID_Satuan" required>
                                <option value="">Pilih satuan</option>
                                <?php $__currentLoopData = $satuanbarang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $satuan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($satuan->ID_Satuan); ?>"><?php echo e($satuan->Nama_Satuan); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi Barang</label>
                            <input type="text" class="form-control" name="Deskripsi_Barang"
                                placeholder="Masukkan Deskripsi barang yang lebih spesifik. Contoh: Warna barang">
                        </div>
                        <button type="submit" class="btn btn-save mt-3">Save</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html><?php /**PATH F:\Proyek\Kuliah\Website\skripsi\resources\views/tambahbarang.blade.php ENDPATH**/ ?>