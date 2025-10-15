<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Toko Sumber Rejeki - Dashboard</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <?php echo app('Illuminate\Foundation\Vite')(['resources/css/style.css', 'resources/js/app.js']); ?>
</head>

<body>
  <?php echo $__env->make('layouts.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  <?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  <!-- Content -->
  <div class="col-md-10 content">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <!-- Form Search -->
      <form action="<?php echo e(route('barang.index')); ?>" method="GET" class="d-flex flex-grow-1">
        <input type="text" name="search" class="form-control me-2" placeholder="Cari barang..."
          value="<?php echo e(request('search')); ?>">
        <button type="submit" class="btn btn-primary">Cari</button>
      </form>

      <!-- Tombol Tambah Barang -->
      <a href="<?php echo e(route('tambahbarang.create')); ?>" class="btn btn-add-item ms-2">Tambah Barang Baru</a>
    </div>

    <!-- Tabel Barang -->
    <table class="table table-hover align-middle">
      <thead>
        <tr>
          <th>Nama Barang</th>
          <th>Merek Barang</th>
          <th>Berat/Ukuran</th>
          <th>Deskripsi</th>
          <th>Harga</th>
          <th>QTY</th>
          <th class="text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $__currentLoopData = $barang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <tr>
            <td><?php echo e($b->Nama_Barang); ?></td>
            <td><?php echo e($b->Merek_Barang ?? '-'); ?></td>
            <td><?php echo e($b->Besar_Satuan ?? '-'); ?></td>
            <td><?php echo e($b->Deskripsi_Barang ?? '-'); ?></td>
            <td>Rp. <?php echo e(number_format($b->Harga_Barang, 0, ',', '.')); ?>,-</td>
            <td><?php echo e($b->Stok_Barang); ?> <?php echo e($b->satuanbarang->Nama_Satuan); ?></td>
            <td>
              <div class="d-flex justify-content-center align-items-center gap-2">

                
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                  data-bs-target="#modalStok<?php echo e($b->ID_Barang); ?>">
                  ➕ Tambah Stok
                </button>

                
                <a href="<?php echo e(route('barang.edit', $b->ID_Barang)); ?>" class="btn btn-warning btn-sm text-black">
                  ✏️ Edit
                </a>

                
                <form action="<?php echo e(route('barang.destroy', $b->ID_Barang)); ?>" method="POST"
                  onsubmit="return confirm('Hapus <?php echo e($b->Nama_Barang); ?>?')">
                  <?php echo csrf_field(); ?>
                  <?php echo method_field('DELETE'); ?>
                  <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                </form>
              </div>

              <!-- Modal Tambah Stok -->
              <div class="modal fade" id="modalStok<?php echo e($b->ID_Barang); ?>" tabindex="-1"
                aria-labelledby="modalLabel<?php echo e($b->ID_Barang); ?>" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <form action="<?php echo e(route('barang.tambahStok', $b->ID_Barang)); ?>" method="POST">
                      <?php echo csrf_field(); ?>
                      <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel<?php echo e($b->ID_Barang); ?>">
                          Tambah Stok - <?php echo e($b->Nama_Barang); ?>

                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <input type="number" name="jumlah" class="form-control" placeholder="Masukkan jumlah stok" min="1"
                          required>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </tbody>
    </table>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html><?php /**PATH F:\Proyek\Kuliah\Website\skripsi\resources\views/barang.blade.php ENDPATH**/ ?>