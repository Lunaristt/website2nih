<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/style.css', 'resources/js/app.js'])
</head>

<body>
    @include('layouts.navbar')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar')

            <div class="col-md-10 p-4">
                <h4 class="mb-4">Edit Barang</h4>

                <form action="{{ route('barang.update', $barang->ID_Barang) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="mb-3">
                            <label class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" name="Nama_Barang"
                                value="{{ $barang->Nama_Barang }}"
                                placeholder="Masukkan Nama Barang. Contoh: Keni, Semen, Baja Ringan" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kategori Barang*</label>
                            <select class="form-control select2" name="ID_Kategori" required>
                                <option value="">Pilih kategori</option>
                                @foreach($kategoribarang as $kategori)
                                    <option value="{{ $kategori->ID_Kategori }}" {{ $barang->ID_Kategori == $kategori->ID_Kategori ? 'selected' : '' }}>
                                        {{ $kategori->Kategori_Barang }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Merek Barang*</label>
                            <input type="text" class="form-control" name="Merek_Barang"
                                value="{{ $barang->Merek_Barang ?? '' }}" placeholder="Masukkan Merek barang" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Harga Barang*</label>
                            <input type="number" class="form-control" name="Harga_Barang"
                                value="{{ $barang->Harga_Barang }}" placeholder="Masukkan Harga Barang" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stok Barang*</label>
                            <input type="number" class="form-control" name="Stok_Barang"
                                value="{{ $barang->Stok_Barang }}" placeholder="Masukkan Stok Barang" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Besar Satuan*</label>
                            <input type="text" class="form-control" name="Besar_Satuan"
                                value="{{ $barang->Besar_Satuan ?? '' }}" placeholder="Contoh: 1, 1/2" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Satuan*</label>
                            <select class="form-control" name="ID_Satuan" required>
                                <option value="">Pilih satuan</option>
                                @foreach($satuanbarang as $satuan)
                                    <option value="{{ $satuan->ID_Satuan }}" {{ $barang->ID_Satuan == $satuan->ID_Satuan ? 'selected' : '' }}>
                                        {{ $satuan->Nama_Satuan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi Barang</label>
                        <input type="text" class="form-control" name="Deskripsi_Barang"
                            value="{{ $barang->Deskripsi_Barang }}"
                            placeholder="Masukkan Deskripsi barang yang lebih spesifik. Contoh: Warna barang">
                    </div>

                    <div class="d-flex justify-content-between mt-3">
                        <button type="submit" class="btn btn-save">💾 Simpan Perubahan</button>
                        <a href="{{ route('barang.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>


            </div>
        </div>
    </div>
</body>

</html>