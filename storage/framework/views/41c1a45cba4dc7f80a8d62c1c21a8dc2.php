<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 sidebar">
            <nav class="nav flex-column">
                <a class="nav-link fw-bold text-white <?php echo e(request()->is('barang') ? 'active' : ''); ?>"
                    href="<?php echo e(route('barang.index')); ?>">
                    Lihat Stok Barang
                </a>

                
                <a class="nav-link fw-bold text-white <?php echo e(request()->is('tambahbarang*') ? 'active' : ''); ?>"
                    href="<?php echo e(route('tambahbarang.create')); ?>">
                    Tambah Barang Baru
                </a>

                
                <div class="ms-3">
                    <a class="nav-link text-white <?php echo e(request()->is('tambahkategori') ? 'active' : ''); ?>"
                        href="<?php echo e(route('tambahkategori')); ?>">
                        📂 Tambah Kategori
                    </a>
                    <a class="nav-link text-white <?php echo e(request()->is('tambahsatuan') ? 'active' : ''); ?>"
                        href="<?php echo e(route('tambahsatuan')); ?>">
                        📏 Tambah Satuan
                    </a>
                </div>

                <a class="nav-link fw-bold text-white <?php echo e(request()->is('pelanggan') ? 'active' : ''); ?>"
                    href="<?php echo e(route('pelanggan.index')); ?>">
                    List Pelanggan
                </a>
                
                <div class="ms-3">
                    <a class="nav-link text-white <?php echo e(request()->is('tambahpelanggan') ? 'active' : ''); ?>"
                        href="<?php echo e(route('tambahpelanggan')); ?>">
                        📂 Tambah Data Pelanggan
                    </a>
                </div>

                <a class="nav-link fw-bold text-white <?php echo e(request()->is('transaksi') ? 'active' : ''); ?>"
                    href="transaksi">
                    Buat Penjualan
                </a>
                
                <div class="ms-3">
                    <a class="nav-link text-white <?php echo e(request()->is('statustransaksi') ? 'active' : ''); ?>"
                        href="<?php echo e(route('statustransaksi.index')); ?>">
                        📂 Status Transaksi
                    </a>
                </div>
                <a class="nav-link fw-bold text-white <?php echo e(request()->is('PesananBarang') ? 'active' : ''); ?>" href="#">
                    Buat Pembelian
                </a>

                <a class="nav-link fw-bold text-white <?php echo e(request()->is('penjualan') ? 'active' : ''); ?>"
                    href="<?php echo e(route('penjualan')); ?>">
                    Laporan Penjualan
                </a>

                <a class="nav-link fw-bold text-white <?php echo e(request()->is('pajak') ? 'active' : ''); ?>" href="#">
                    Pajak
                </a>

            </nav>
        </div><?php /**PATH F:\Proyek\Kuliah\Website\skripsi\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>