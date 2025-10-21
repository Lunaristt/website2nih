<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Baru - Toko Sumber Rejeki</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Select2 (dropdown + search + add new) -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .select2-container .select2-selection--single {
            height: 38px;
            padding: 6px 12px;
            border: 1px solid #ced4da;
            border-radius: 6px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
            right: 10px;
        }
    </style>

    @vite(['resources/css/style.css', 'resources/js/app.js'])
</head>

<body>
    @include('layouts.navbar')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar')

            <div class="col-md-10 p-4">
                <h4 class="mb-4">Transaksi Baru (ID: {{ $penjualan->ID_Penjualan }})</h4>

                {{-- 🔹 Informasi Pelanggan --}}
                <div class="row mb-4">
                    <div class="col-md-4">
                        <h6 class="fw-bold">Nama Pelanggan</h6>
                        <select id="namaPelanggan" class="form-control" style="width: 100%;">
                            <option value="">-- Pilih atau Ketik Pelanggan --</option>
                            @foreach($pelanggan as $plg)
                                <option value="{{ $plg->Nama_Pelanggan }}" data-telp="{{ $plg->No_Telp }}"
                                    data-alamat="{{ $plg->Alamat }}">
                                    {{ $plg->Nama_Pelanggan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <h6 class="fw-bold">Nomor Telepon</h6>
                        <input type="text" id="noTelp" name="No_Telp" class="form-control"
                            placeholder="Nomor telepon...">
                    </div>

                    <div class="col-md-4">
                        <h6 class="fw-bold">Alamat</h6>
                        <input type="text" id="alamatPelanggan" name="Alamat" class="form-control"
                            placeholder="Alamat pelanggan...">
                    </div>
                </div>

                {{-- 🔹 Tabel Barang --}}
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
                    <tbody id="listBarang">
                        @forelse ($transaksi as $t)
                            <tr>
                                <td>{{ $t->barang->Nama_Barang }}</td>
                                <td>{{ $t->barang->Deskripsi_Barang }}</td>
                                <td>{{ $t->Jumlah }}</td>
                                <td>Rp {{ number_format($t->barang->Harga_Barang, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($t->Total_Harga, 0, ',', '.') }}</td>
                                <td>
                                    <form action="{{ route('transaksi.destroy', $t->ID_Penjualan . '-' . $t->ID_Barang) }}"
                                        method="POST" onsubmit="return confirm('Hapus {{ $t->barang->Nama_Barang }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr id="emptyRow">
                                <td colspan="6" class="text-center">Belum ada barang dalam transaksi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- 🔹 Form Tambah Barang --}}
                <form id="formAddItem" action="{{ route('transaksi.addItem') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="ID_Barang" class="form-label">Pilih Barang</label>
                        <select name="ID_Barang" id="ID_Barang" class="form-control" required>
                            <option value="">-- Pilih Barang --</option>
                            @foreach($barang as $b)
                                <option value="{{ $b->ID_Barang }}">
                                    {{ $b->Nama_Barang }} - Rp{{ number_format($b->Harga_Barang, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="Jumlah" class="form-label">Jumlah</label>
                        <input type="number" name="Jumlah" id="Jumlah" class="form-control" min="1" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah Barang</button>
                </form>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <h6 id="grandTotal" class="fw-bold">
                        Total: Rp {{ number_format($penjualan->Harga_Keseluruhan, 0, ',', '.') }}
                    </h6>
                </div>

                {{-- 🔹 Tombol --}}
                <div class="d-flex justify-content-end mt-3">
                    <form action="{{ route('transaksi.cancel') }}" method="POST" class="me-2">
                        @csrf
                        <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Apakah Anda yakin ingin membatalkan transaksi ini?')">
                            Batalkan Pesanan
                        </button>
                    </form>

                    <form action="{{ route('transaksi.checkout') }}" method="POST" id="checkoutForm">
                        @csrf
                        <input type="hidden" name="Nama_Pelanggan" id="checkoutNama">
                        <input type="hidden" name="No_Telp" id="checkoutTelp">
                        <input type="hidden" name="Alamat" id="checkoutAlamat">
                        <button type="submit" class="btn btn-success" @if($transaksi->count() == 0) disabled @endif>
                            Selesaikan Pesanan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ===================================================== --}}
    <script>
        $(document).ready(function () {
            // ====================================================
            // 🔹 FITUR DROPDOWN SELECT2 UNTUK PELANGGAN
            // ====================================================
            $('#namaPelanggan').select2({
                placeholder: 'Ketik atau pilih pelanggan...',
                tags: true, // bisa input pelanggan baru
                allowClear: true,
                width: '100%'
            });

            // Autofill data pelanggan dari option yang dipilih
            $('#namaPelanggan').on('change', function () {
                const selected = $(this).find(':selected');
                const telp = selected.data('telp') || '';
                const alamat = selected.data('alamat') || '';
                $('#noTelp').val(telp);
                $('#alamatPelanggan').val(alamat);
            });

            // Kirim data pelanggan saat checkout (pelanggan baru juga ikut tersimpan)
            $('#checkoutForm').on('submit', function () {
                $('#checkoutNama').val($('#namaPelanggan').val());
                $('#checkoutTelp').val($('#noTelp').val());
                $('#checkoutAlamat').val($('#alamatPelanggan').val());
            });

            // ====================================================
            // 🔹 FITUR TAMBAH BARANG DENGAN AJAX + SWEETALERT2
            // ====================================================
            const formAddItem = document.getElementById('formAddItem');

            formAddItem.addEventListener('submit', function (e) {
                e.preventDefault(); // Cegah reload halaman

                const formData = new FormData(formAddItem);

                fetch(formAddItem.action, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('input[name=_token]').value,
                        "Accept": "application/json"
                    },
                    body: formData
                })
                    .then(res => res.json())
                    .then(data => {
                        // Jika gagal (stok habis, tidak cukup, dsb)
                        if (!data.success) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Gagal Menambah Barang',
                                text: data.message || 'Stok barang tidak mencukupi!',
                                confirmButtonColor: '#d33'
                            });
                            return;
                        }

                        // Jika sukses
                        Swal.fire({
                            icon: 'success',
                            title: 'Barang berhasil ditambahkan!',
                            showConfirmButton: false,
                            timer: 1200
                        });

                        // Hapus baris kosong jika ada
                        const emptyRow = document.getElementById('emptyRow');
                        if (emptyRow) emptyRow.remove();

                        // Tambahkan baris baru ke tabel transaksi
                        const row = `
                        <tr>
                            <td>${data.barang}</td>
                            <td>${data.deskripsi ?? '-'}</td>
                            <td>${data.jumlah}</td>
                            <td>Rp ${parseInt(data.harga).toLocaleString('id-ID')}</td>
                            <td>Rp ${parseInt(data.total).toLocaleString('id-ID')}</td>
                            <td>
                                <form method="POST" action="/transaksi/${data.id}" onsubmit="return confirm('Hapus barang ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    `;
                        document.querySelector('#listBarang').insertAdjacentHTML('beforeend', row);

                        // Update total keseluruhan
                        document.getElementById('grandTotal').innerText =
                            'Total: Rp ' + parseInt(data.grandTotal).toLocaleString('id-ID');

                        // Aktifkan tombol checkout
                        document.querySelector('#checkoutForm button[type=submit]').disabled = false;

                        // Reset form input barang
                        formAddItem.reset();
                    })
                    .catch(err => {
                        console.error(err);
                        Swal.fire({
                            icon: 'error',
                            title: 'Kesalahan Server',
                            text: 'Terjadi kesalahan pada server. Silakan coba lagi.',
                            confirmButtonColor: '#d33'
                        });
                    });
            });

            // ====================================================
            // 🔹 CEGAH ENTER SUBMIT FORM (AGAR FETCH TIDAK SKIP)
            // ====================================================
            $('#Jumlah').on('keydown', function (e) {
                if (e.key === 'Enter') e.preventDefault();
            });
        });
    </script>


</body>

</html>