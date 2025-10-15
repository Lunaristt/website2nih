<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi</title>
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

                <!-- Judul Transaksi -->
                <h4 class="mb-4">Transaksi Baru (ID: <?php echo e($penjualan->ID_Penjualan); ?>)</h4>

                <!-- Informasi Pelanggan -->
                <div class="row mb-4">
                    <div class="col">
                        <h6 class="fw-bold">Nama Pelanggan</h6>
                        <select id="namaPelanggan" class="form-control">
                            <option value="">-- Pilih Pelanggan --</option>
                            <?php $__currentLoopData = $pelanggan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($plg->No_Telp); ?>" data-nama="<?php echo e($plg->Nama_Pelanggan); ?>"
                                    data-alamat="<?php echo e($plg->Alamat); ?>">
                                    <?php echo e($plg->Nama_Pelanggan); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col">
                        <h6 class="fw-bold">Nomor Telepon</h6>
                        <input type="text" id="noTelp" class="form-control" readonly>
                        <!-- Hidden supaya ikut terkirim -->
                        <input type="hidden" name="No_Telp" id="hiddenNoTelp">
                    </div>
                </div>

                <!-- Alamat -->
                <div class="row mb-4">
                    <div class="col">
                        <h6 class="fw-bold">Alamat</h6>
                        <input type="text" id="alamatPelanggan" class="form-control" readonly>
                    </div>
                </div>

                <!-- Tabel Barang -->
                <table class="table table-borderless align-middle">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Deskripsi</th>
                            <th>Jumlah Barang</th>
                            <th>Harga Satuan</th>
                            <th>Total Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="listBarang">
                        <?php $__empty_1 = true; $__currentLoopData = $transaksi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($t->barang->Nama_Barang); ?></td>
                                <td><?php echo e($t->barang->Deskripsi_Barang); ?></td>
                                <td><?php echo e($t->Jumlah); ?></td>
                                <td>Rp <?php echo e(number_format($t->barang->Harga_Barang, 0, ',', '.')); ?></td>
                                <td>Rp <?php echo e(number_format($t->Total_Harga, 0, ',', '.')); ?></td>
                                <td>
                                    <form action="<?php echo e(route('transaksi.destroy', $t->ID_Penjualan . '-' . $t->ID_Barang)); ?>"
                                        method="POST" onsubmit="return confirm('Hapus <?php echo e($t->barang->Nama_Barang); ?>?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr id="emptyRow">
                                <td colspan="6" class="text-center">Belum ada barang dalam transaksi</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <!-- Form Tambah Barang -->
                <form id="formAddItem" action="<?php echo e(route('transaksi.addItem')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label for="ID_Barang" class="form-label">Pilih Barang</label>
                        <select name="ID_Barang" id="ID_Barang" class="form-control" required>
                            <option value="">-- Pilih Barang --</option>
                            <?php $__currentLoopData = $barang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($b->ID_Barang); ?>">
                                    <?php echo e($b->Nama_Barang); ?> - Rp<?php echo e(number_format($b->Harga_Barang, 0, ',', '.')); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="Jumlah" class="form-label">Jumlah</label>
                        <input type="number" name="Jumlah" id="Jumlah" class="form-control" min="1" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah Barang</button>
                </form>

                <!-- Total -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <h6 id="grandTotal" class="fw-bold">
                        Total: Rp <?php echo e(number_format($penjualan->Harga_Keseluruhan, 0, ',', '.')); ?>

                    </h6>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    
                    <form action="<?php echo e(route('transaksi.cancel')); ?>" method="POST" class="me-2">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Apakah Anda yakin ingin membatalkan transaksi ini?')">
                            Batalkan Pesanan
                        </button>
                    </form>

                    
                    <form action="<?php echo e(route('transaksi.checkout')); ?>" method="POST" id="checkoutForm">
                        <?php echo csrf_field(); ?>
                        <!-- hidden No_Telp untuk dikirim -->
                        <input type="hidden" name="No_Telp" id="checkoutNoTelp">
                        <button type="submit" class="btn btn-success" <?php if($transaksi->count() == 0): ?> disabled <?php endif; ?>>
                            Selesaikan Pesanan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script>
        // Autofill pelanggan
        document.getElementById('namaPelanggan').addEventListener('change', function () {
            let selected = this.options[this.selectedIndex];
            let noTelp = selected.value;
            let alamat = selected.getAttribute('data-alamat') ?? '';

            document.getElementById('noTelp').value = noTelp;
            document.getElementById('alamatPelanggan').value = alamat;
            document.getElementById('checkoutNoTelp').value = noTelp; // simpan ke hidden input
        });

        // Tambah barang via AJAX
        document.getElementById('formAddItem').addEventListener('submit', function (e) {
            e.preventDefault();

            let form = e.target;
            let formData = new FormData(form);

            fetch(form.action, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('input[name=_token]').value,
                    "Accept": "application/json"
                },
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        let emptyRow = document.getElementById('emptyRow');
                        if (emptyRow) emptyRow.remove();

                        let row = `
                        <tr>
                            <td>${data.barang}</td>
                            <td>${data.deskripsi ?? '-'}</td>
                            <td>${data.jumlah}</td>
                            <td>Rp ${parseInt(data.harga).toLocaleString('id-ID')}</td>
                            <td>Rp ${parseInt(data.total).toLocaleString('id-ID')}</td>
                            <td>
                                <form method="POST" action="/transaksi/${data.id}" onsubmit="return confirm('Hapus barang ini?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    `;
                        document.querySelector('#listBarang').insertAdjacentHTML('beforeend', row);

                        document.getElementById('grandTotal').innerText =
                            'Total: Rp ' + parseInt(data.grandTotal).toLocaleString('id-ID');

                        // ✅ Aktifkan tombol checkout
                        document.querySelector('#checkoutForm button[type=submit]').disabled = false;

                        form.reset();
                    } else {
                        alert("Gagal menambah barang!");
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert("Terjadi error pada server.");
                });
        });
    </script>

</body>

</html><?php /**PATH F:\Proyek\Kuliah\Website\skripsi\resources\views/transaksi.blade.php ENDPATH**/ ?>