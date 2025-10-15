<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/style.css', 'resources/js/app.js'])
</head>

<body>
    <!-- Navbar -->
    @include('layouts.navbar')

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @include('layouts.sidebar')

            <!-- Content -->
            <div class="col-md-10 p-4">

                <!-- Judul Transaksi -->
                <h4 class="mb-4">Transaksi Baru (ID: {{ $penjualan->ID_Penjualan }})</h4>

                <!-- Informasi Pelanggan -->
                <div class="row mb-4">
                    <div class="col">
                        <h6 class="fw-bold">Nama Pelanggan</h6>
                        <select id="namaPelanggan" class="form-control">
                            <option value="">-- Pilih Pelanggan --</option>
                            @foreach($pelanggan as $plg)
                                <option value="{{ $plg->No_Telp }}" data-nama="{{ $plg->Nama_Pelanggan }}"
                                    data-alamat="{{ $plg->Alamat }}">
                                    {{ $plg->Nama_Pelanggan }}
                                </option>
                            @endforeach
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

                <!-- Form Tambah Barang -->
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

                <!-- Total -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <h6 id="grandTotal" class="fw-bold">
                        Total: Rp {{ number_format($penjualan->Harga_Keseluruhan, 0, ',', '.') }}
                    </h6>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    {{-- Tombol Batalkan --}}
                    <form action="{{ route('transaksi.cancel') }}" method="POST" class="me-2">
                        @csrf
                        <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Apakah Anda yakin ingin membatalkan transaksi ini?')">
                            Batalkan Pesanan
                        </button>
                    </form>

                    {{-- Tombol Selesaikan --}}
                    <form action="{{ route('transaksi.checkout') }}" method="POST" id="checkoutForm">
                        @csrf
                        <!-- hidden No_Telp untuk dikirim -->
                        <input type="hidden" name="No_Telp" id="checkoutNoTelp">
                        <button type="submit" class="btn btn-success" @if($transaksi->count() == 0) disabled @endif>
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
                                    @csrf
                                    @method('DELETE')
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

</html>