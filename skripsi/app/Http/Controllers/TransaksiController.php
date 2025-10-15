<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangPenjualan;
use App\Models\Penjualan;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    /**
     * Tampilkan daftar transaksi.
     */
    public function index()
    {
        $transaksi = Penjualan::with('barang')->orderBy('Tanggal', 'desc')->get();
        return view('transaksi.index', compact('transaksi'));
    }

    /**
     * Buat transaksi baru atau lanjutkan yang masih pending.
     */
    public function create()
    {
        $barang = Barang::all();
        $pelanggan = Pelanggan::orderBy('Nama_Pelanggan')->get();

        $penjualanId = session('penjualan_id');

        if ($penjualanId) {
            $penjualan = Penjualan::find($penjualanId);

            // Jika tidak ditemukan di DB, buat baru
            if (!$penjualan) {
                $penjualan = Penjualan::create([
                    'Harga_Keseluruhan' => 0,
                    'Tanggal' => now(),
                    'Status' => 'Pending',
                ]);
                session(['penjualan_id' => $penjualan->ID_Penjualan]);
            }
        } else {
            // Buat baru hanya kalau belum ada session aktif
            $penjualan = Penjualan::create([
                'Harga_Keseluruhan' => 0,
                'Tanggal' => now(),
                'Status' => 'Pending',
            ]);
            session(['penjualan_id' => $penjualan->ID_Penjualan]);
        }

        $transaksi = BarangPenjualan::with('barang')
            ->where('ID_Penjualan', $penjualan->ID_Penjualan)
            ->get();

        return view('transaksi', compact('barang', 'penjualan', 'transaksi', 'pelanggan'));
    }

    /**
     * Tambahkan barang ke transaksi (sementara, belum mengurangi stok).
     */
    public function addItem(Request $request)
    {
        $request->validate([
            'ID_Barang' => 'required|exists:barang,ID_Barang',
            'Jumlah' => 'required|integer|min:1',
        ]);

        $penjualanId = session('penjualan_id');
        if (!$penjualanId) {
            return response()->json(['success' => false, 'message' => 'Tidak ada transaksi aktif']);
        }

        $barang = Barang::findOrFail($request->ID_Barang);

        // Cek stok tersedia
        if ($barang->Stok_Barang < $request->Jumlah) {
            return response()->json(['success' => false, 'message' => 'Stok barang tidak mencukupi!']);
        }

        $totalHarga = $barang->Harga_Barang * $request->Jumlah;

        // Simpan item ke pivot table
        $detail = BarangPenjualan::create([
            'ID_Penjualan' => $penjualanId,
            'ID_Barang' => $request->ID_Barang,
            'Jumlah' => $request->Jumlah,
            'Total_Harga' => $totalHarga,
        ]);

        // Update total harga keseluruhan di tabel penjualan
        $grandTotal = BarangPenjualan::where('ID_Penjualan', $penjualanId)->sum('Total_Harga');
        Penjualan::where('ID_Penjualan', $penjualanId)->update(['Harga_Keseluruhan' => $grandTotal]);

        return response()->json([
            'success' => true,
            'id' => $detail->id,
            'barang' => $barang->Nama_Barang,
            'deskripsi' => $barang->Deskripsi_Barang,
            'jumlah' => $detail->Jumlah,
            'harga' => $barang->Harga_Barang,
            'total' => $detail->Total_Harga,
            'grandTotal' => $grandTotal
        ]);
    }

    /**
     * Selesaikan transaksi dan kurangi stok barang.
     */
    public function checkout(Request $request)
    {
        $penjualanId = session('penjualan_id');

        if (!$penjualanId) {
            return redirect()->back()->with('error', 'Tidak ada transaksi aktif!');
        }

        $jumlahItem = BarangPenjualan::where('ID_Penjualan', $penjualanId)->count();
        if ($jumlahItem == 0) {
            return redirect()->back()->with('error', 'Tidak bisa menyelesaikan transaksi tanpa barang!');
        }

        if (!$request->No_Telp) {
            return redirect()->back()->with('error', 'Pelanggan harus dipilih!');
        }

        DB::beginTransaction();
        try {
            $details = BarangPenjualan::where('ID_Penjualan', $penjualanId)->get();

            // Kurangi stok barang sesuai jumlah terjual
            foreach ($details as $item) {
                $barang = Barang::findOrFail($item->ID_Barang);

                if ($barang->Stok_Barang < $item->Jumlah) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Stok ' . $barang->Nama_Barang . ' tidak mencukupi!');
                }

                $barang->Stok_Barang -= $item->Jumlah;
                $barang->save();
            }

            // Update status penjualan ke "Selesai"
            Penjualan::where('ID_Penjualan', $penjualanId)->update([
                'No_Telp' => $request->No_Telp,
                'Status' => 'Selesai',
                'Tanggal' => now(),
            ]);

            DB::commit();

            // Hapus session transaksi
            session()->forget('penjualan_id');

            return redirect()->route('transaksi.create')->with('success', 'Transaksi selesai dan stok telah diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan detail transaksi.
     */
    public function show($idPenjualan)
    {
        $penjualan = Penjualan::with('barang')->findOrFail($idPenjualan);
        return view('transaksi.show', compact('penjualan'));
    }

    /**
     * Hapus item dari transaksi.
     */
    public function destroy(Request $request)
    {
        $idPenjualan = $request->input('ID_Penjualan');
        $idBarang = $request->input('ID_Barang');

        $detail = BarangPenjualan::where('ID_Penjualan', $idPenjualan)
            ->where('ID_Barang', $idBarang)
            ->firstOrFail();

        $detail->delete();

        // Recalculate total
        $grandTotal = BarangPenjualan::where('ID_Penjualan', $idPenjualan)->sum('Total_Harga');
        Penjualan::where('ID_Penjualan', $idPenjualan)
            ->update(['Harga_Keseluruhan' => $grandTotal]);

        return redirect()->back()->with('success', 'Barang berhasil dihapus!');
    }

    /**
     * Batalkan transaksi (kembalikan stok & reset data).
     */
    public function cancel()
    {
        $penjualanId = session('penjualan_id');

        if (!$penjualanId) {
            return redirect()->back()->with('error', 'Tidak ada transaksi untuk dibatalkan!');
        }

        $items = BarangPenjualan::where('ID_Penjualan', $penjualanId)->get();

        // Kembalikan stok barang
        foreach ($items as $item) {
            $barang = Barang::find($item->ID_Barang);
            if ($barang) {
                $barang->Stok_Barang += $item->Jumlah;
                $barang->save();
            }
        }

        // Hapus item di pivot
        BarangPenjualan::where('ID_Penjualan', $penjualanId)->delete();

        // Reset transaksi di tabel penjualan
        Penjualan::where('ID_Penjualan', $penjualanId)->update([
            'Harga_Keseluruhan' => 0,
            'Status' => 'Pending',
            'Tanggal' => now(),
        ]);

        return redirect()->route('transaksi.create')->with('success', 'Transaksi dibatalkan dan stok dikembalikan!');
    }

    public function batalTransaksi($id)
    {
        $penjualan = Penjualan::with('barangpenjualan')->findOrFail($id);

        // Jika sudah batal, tidak perlu diproses ulang
        if ($penjualan->Status === 'Batal') {
            return redirect()->back()->with('error', 'Transaksi ini sudah dibatalkan.');
        }

        // Kembalikan stok semua barang di transaksi ini
        foreach ($penjualan->barangpenjualan as $item) {
            $barang = Barang::find($item->ID_Barang);
            if ($barang) {
                $barang->Stok_Barang += $item->Jumlah;
                $barang->save();
            }
        }

        // Ubah status transaksi jadi "Batal"
        $penjualan->update([
            'Status' => 'Batal'
        ]);

        // Redirect kembali ke list transaksi
        return redirect()->route('statustransaksi.index')->with('success', 'Transaksi berhasil dibatalkan dan stok dikembalikan!');
    }
}
