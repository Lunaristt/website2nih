<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/style.css', 'resources/js/app.js']); ?>
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
                <h4 class="mb-4">Status Transaksi</h4>

                
                <?php if(session('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo e(session('success')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID Penjualan</th>
                                <th>Nama Pelanggan</th>
                                <th>Nomor Telepon</th>
                                <th>Harga Keseluruhan</th>
                                <th>Tanggal</th>
                                <th>Status Transaksi</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $penjualan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($p->ID_Penjualan); ?></td>
                                    <td><?php echo e($p->Nama_Pelanggan); ?></td>
                                    <td><?php echo e($p->No_Telp); ?></td>
                                    <td>Rp. <?php echo e(number_format($p->Harga_Keseluruhan, 0, ',', '.')); ?></td>
                                    <td><?php echo e(\Carbon\Carbon::parse($p->Tanggal)->format('d M Y')); ?></td>
                                    <td>
                                        <?php if($p->Status === 'Selesai'): ?>
                                            <span class="badge bg-success">Selesai</span>
                                        <?php elseif($p->Status_Transaksi === 'proses'): ?>
                                            <span class="badge bg-warning text-dark">Proses</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Batal</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($p->Status === 'Batal'): ?>
                                            <button class="btn btn-secondary" disabled>Batal</button>
                                        <?php else: ?>
                                            <form action="<?php echo e(route('transaksi.batal', $p->ID_Penjualan)); ?>" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin membatalkan transaksi ini?');">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-danger text-white">Batal</button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Belum ada data penjualan</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</body>

</html><?php /**PATH F:\Proyek\Kuliah\Website\skripsi\resources\views/listpenjualan.blade.php ENDPATH**/ ?>