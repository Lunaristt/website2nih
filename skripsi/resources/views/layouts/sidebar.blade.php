<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 sidebar">
            <nav class="nav flex-column">
                <a class="nav-link fw-bold text-white {{ request()->is('barang') ? 'active' : '' }}"
                    href="{{ route('barang.index') }}">
                    Lihat Stok Barang
                </a>

                {{-- Default Tambah Barang Baru --}}
                <a class="nav-link fw-bold text-white {{ request()->is('tambahbarang*') ? 'active' : '' }}"
                    href="{{ route('tambahbarang.create') }}">
                    Tambah Barang Baru
                </a>

                {{-- Dropdown Tambah Kategori --}}
                <div class="ms-3">
                    <a class="nav-link text-white {{ request()->is('tambahkategori') ? 'active' : '' }}"
                        href="{{ route('tambahkategori') }}">
                        📂 Tambah Kategori
                    </a>
                    <a class="nav-link text-white {{ request()->is('tambahsatuan') ? 'active' : '' }}"
                        href="{{ route('tambahsatuan') }}">
                        📏 Tambah Satuan
                    </a>
                </div>

                <a class="nav-link fw-bold text-white {{ request()->is('pelanggan') ? 'active' : '' }}"
                    href="{{ route('pelanggan.index') }}">
                    List Pelanggan
                </a>
                {{-- Dropdown Tambah data pelanggan --}}
                <div class="ms-3">
                    <a class="nav-link text-white {{ request()->is('tambahpelanggan') ? 'active' : '' }}"
                        href="{{ route('tambahpelanggan') }}">
                        📂 Tambah Data Pelanggan
                    </a>
                </div>

                <a class="nav-link fw-bold text-white {{ request()->is('transaksi') ? 'active' : '' }}"
                    href="transaksi">
                    Buat Penjualan
                </a>
                {{-- Dropdown Tambah Kategori --}}
                <div class="ms-3">
                    <a class="nav-link text-white {{ request()->is('statustransaksi') ? 'active' : '' }}"
                        href="{{ route('statustransaksi.index') }}">
                        📂 Status Transaksi
                    </a>
                </div>
                <a class="nav-link fw-bold text-white {{ request()->is('PesananBarang') ? 'active' : '' }}" href="#">
                    Buat Pembelian
                </a>

                <a class="nav-link fw-bold text-white {{ request()->is('penjualan') ? 'active' : '' }}"
                    href="{{ route('penjualan') }}">
                    Laporan Penjualan
                </a>

                <a class="nav-link fw-bold text-white {{ request()->is('pajak') ? 'active' : '' }}" href="#">
                    Pajak
                </a>

            </nav>
        </div>