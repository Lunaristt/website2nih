<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pembelian Barang - Toko Sumber Rejeki</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/style.css', 'resources/js/app.js'])
</head>

<body>
    @include('layouts.navbar')
    @include('layouts.sidebar')

    <div class="col-md-10 content p-4">
        <h4 class="fw-bold mb-4">🧾 Form Pembelian Barang dari Distributor</h4>

        <!-- Pesan sukses / error -->
        @if(session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="alert alert-danger text-center">{{ session('error') }}</div>
        @endif

        <!-- FORM PEMBELIAN -->
        <form action="{{ route('pembelian.checkout') }}" method="POST" id="formPembelian">
            @csrf

            <!-- Informasi Distributor -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="ID_Distributor" class="form-label fw-semibold">Nama Distributor</label>
                    <select id="ID_Distributor" name="ID_Distributor" class="form-select bg-secondary-subtle border-0"
                        required>
                        <option value="">-- Pilih Distributor --</option>

                    </select>
                </div>

                <div class="col-md-6">
                    <label for="Notelp_Salesman" class="form-label fw-semibold">Nomor Telepon Sales</label>
                    <input type="text" id="Notelp_Salesman" class="form-control bg-secondary-subtle border-0" readonly>
                </div>
            </div>

            <div class="mb-3">
                <label for="Nama_Salesman" class="form-label fw-semibold">Nama Salesman</label>
                <input type="text" id="Nama_Salesman" class="form-control bg-secondary-subtle border-0" readonly>
            </div>

            <hr class="my-4">

            <!-- Tabel Barang -->
            <h5 class="fw-semibold mb-3">Daftar Barang yang Dibeli</h5>
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nama Barang</th>
                        <th>Deskripsi</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Total Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="daftarBarang">
                    <tr>
                        <td colspan="6" class="text-muted">Belum ada barang dalam transaksi</td>
                    </tr>
                </tbody>
            </table>

            <!-- Input Barang -->
            <div class="row g-3 align-items-end mt-3">
                <div class="col-md-6">
                    <label for="ID_Barang" class="form-label fw-semibold">Pilih Barang</label>
                    <select id="ID_Barang" class="form-select bg-secondary-subtle border-0">
                        <option value="">-- Pilih Barang --</option>

                    </select>
                </div>

                <div class="col-md-3">
                    <label for="Jumlah" class="form-label fw-semibold">Jumlah</label>
                    <input type="number" id="Jumlah" min="1" class="form-control bg-secondary-subtle border-0"
                        placeholder="Masukkan jumlah">
                </div>

                <div class="col-md-3">
                    <button type="button" id="btnTambahBarang" class="btn btn-primary fw-semibold w-100">Tambah
                        Barang</button>
                </div>
            </div>

            <div class="text-end mt-4">
                <h5 class="fw-bold">Total: <span id="totalHarga">Rp 0</span></h5>
            </div>

            <!-- Tombol Aksi -->
            <div class="text-end mt-3">
                <a href="{{ route('pembelian.cancel') }}" class="btn btn-danger fw-semibold px-4 me-2">Batalkan
                    Pembelian</a>
                <button type="submit" class="btn btn-success fw-semibold px-4">Selesaikan Pembelian</button>
            </div>
        </form>
    </div>

    <!-- SCRIPT -->
    <script>
        const distributorSelect = document.getElementById('ID_Distributor');
        const telpSalesInput = document.getElementById('Notelp_Salesman');
        const namaSalesInput = document.getElementById('Nama_Salesman');
        const barangSelect = document.getElementById('ID_Barang');
        const daftarBarang = document.getElementById('daftarBarang');
        const totalHargaDisplay = document.getElementById('totalHarga');
        const formPembelian = document.getElementById('formPembelian');
        let total = 0;

        // 🔹 Autofill data dari distributor
        distributorSelect.addEventListener('change', function () {
            const selected = this.options[this.selectedIndex];
            telpSalesInput.value = selected.getAttribute('data-telp') || '';
            namaSalesInput.value = selected.getAttribute('data-sales') || '';
        });

        // 🔹 Tambah barang ke daftar
        document.getElementById('btnTambahBarang').addEventListener('click', function () {
            const selected = barangSelect.options[barangSelect.selectedIndex];
            const id = selected.value;
            const nama = selected.text;
            const harga = parseFloat(selected.getAttribute('data-harga') || 0);
            const deskripsi = selected.getAttribute('data-deskripsi') || '-';
            const jumlah = parseInt(document.getElementById('Jumlah').value) || 0;

            if (!id || jumlah <= 0) {
                alert('Pilih barang dan masukkan jumlah yang valid!');
                return;
            }

            const subtotal = harga * jumlah;
            total += subtotal;
            totalHargaDisplay.textContent = 'Rp ' + total.toLocaleString('id-ID');

            if (daftarBarang.children[0].textContent.includes('Belum ada')) {
                daftarBarang.innerHTML = '';
            }

            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${nama}<input type="hidden" name="barang[]" value="${id}"></td>
                <td>${deskripsi}</td>
                <td>${jumlah}<input type="hidden" name="jumlah[]" value="${jumlah}"></td>
                <td>Rp ${harga.toLocaleString('id-ID')}</td>
                <td>Rp ${subtotal.toLocaleString('id-ID')}</td>
                <td><button type="button" class="btn btn-danger btn-sm btnHapus">Hapus</button></td>
            `;
            daftarBarang.appendChild(row);
            document.getElementById('Jumlah').value = '';
        });

        // 🔹 Hapus barang dari daftar
        daftarBarang.addEventListener('click', function (e) {
            if (e.target.classList.contains('btnHapus')) {
                const row = e.target.closest('tr');
                const subtotal = parseFloat(row.children[4].textContent.replace(/[^\d]/g, ''));
                total -= subtotal;
                totalHargaDisplay.textContent = 'Rp ' + total.toLocaleString('id-ID');
                row.remove();

                if (daftarBarang.children.length === 0) {
                    daftarBarang.innerHTML = '<tr><td colspan="6" class="text-muted">Belum ada barang dalam transaksi</td></tr>';
                }
            }
        });

        // 🔹 Validasi sebelum submit
        formPembelian.addEventListener('submit', function (e) {
            if (daftarBarang.children[0].textContent.includes('Belum ada')) {
                e.preventDefault();
                alert('Tambahkan minimal satu barang sebelum menyelesaikan pembelian!');
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>