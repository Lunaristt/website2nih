<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangPembelian;
use App\Models\Pembelian;
use App\Models\Distributor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    /**
     * Menampilkan daftar semua transaksi pembelian.
     */
    public function index()
    {
        $pembelian = Pembelian::with('barang', 'distributor')
            ->orderBy('Tanggal', 'desc')
            ->get();

        return view('pembelian.index', compact('pembelian'));
    }

    /**
     * Membuat transaksi pembelian baru atau melanjutkan yang pending.
     */
    public function create()
    {
        $barang = Barang::all();
        $distributor = Distributor::orderBy('Nama_Distributor')->get();

        // Cek apakah ada pembelian aktif (Pending)
        $pembelianId = session('pembelian_id');

        if ($pembelianId) {
            $pembelian = Pembelian::find($pembelianId);

            // Jika tidak ditemukan (misal sudah dihapus)
            if (!$pembelian) {
                $pembelian = Pembelian::create([
                    'Harga_Keseluruhan' => 0,
                    'Tanggal' => now(),
                    'Status' => 'Pending',
                ]);
                session(['pembelian_id' => $pembelian->ID_Pembelian]);
            }
        } else {
            // Buat pembelian baru
            $pembelian = Pembelian::create([
                'Harga_Keseluruhan' => 0,
                'Tanggal' => now(),
                'Status' => 'Pending',
            ]);
            session(['pembelian_id' => $pembelian->ID_Pembelian]);
        }

        $transaksi = BarangPembelian::with('barang')
            ->where('ID_Pembelian', $pembelian->ID_Pembelian)
            ->get();

        return view('pembelian.create', compact('barang', 'pembelian', 'transaksi', 'distributor'));
    }

    /**
     * Tambahkan barang ke dalam pembelian (sementara).
     */
    public function addItem(Request $request)
    {
        $request->validate([
            'ID_Barang' => 'required|exists:barang,ID_Barang',
            'Jumlah_Pesanan' => 'required|integer|min:1',
        ]);

        $pembelianId = session('pembelian_id');

        if (!$pembelianId) {
            return response()->json(['success' => false, 'message' => 'Tidak ada transaksi pembelian aktif.']);
        }

        $barang = Barang::findOrFail($request->ID_Barang);
        $totalHarga = $barang->Harga_Barang * $request->Jumlah_Pesanan;

        // Simpan ke tabel pivot BarangPembelian
        $detail = BarangPembelian::create([
            'ID_Pembelian' => $pembelianId,
            'ID_Barang' => $request->ID_Barang,
            'Jumlah_Pesanan' => $request->Jumlah_Pesanan,
            'Total_Harga' => $totalHarga,
        ]);

        // Hitung total keseluruhan pembelian
        $grandTotal = BarangPembelian::where('ID_Pembelian', $pembelianId)->sum('Total_Harga');
        Pembelian::where('ID_Pembelian', $pembelianId)->update(['Harga_Keseluruhan' => $grandTotal]);

        return response()->json([
            'success' => true,
            'barang' => $barang->Nama_Barang,
            'deskripsi' => $barang->Deskripsi_Barang,
            'jumlah' => $detail->Jumlah_Pesanan,
            'harga' => $barang->Harga_Barang,
            'total' => $detail->Total_Harga,
            'grandTotal' => $grandTotal,
        ]);
    }

    /**
     * Menyelesaikan pembelian dan menambah stok barang.
     */
    public function checkout(Request $request)
    {
        $pembelianId = session('pembelian_id');

        if (!$pembelianId) {
            return redirect()->back()->with('error', 'Tidak ada transaksi pembelian aktif!');
        }

        $jumlahItem = BarangPembelian::where('ID_Pembelian', $pembelianId)->count();
        if ($jumlahItem == 0) {
            return redirect()->back()->with('error', 'Tidak dapat menyelesaikan pembelian tanpa barang!');
        }

        if (!$request->ID_Distributor) {
            return redirect()->back()->with('error', 'Distributor harus dipilih!');
        }

        DB::beginTransaction();
        try {
            $details = BarangPembelian::where('ID_Pembelian', $pembelianId)->get();

            // Tambahkan stok barang sesuai jumlah pembelian
            foreach ($details as $item) {
                $barang = Barang::findOrFail($item->ID_Barang);
                $barang->Stok_Barang += $item->Jumlah_Pesanan;
                $barang->save();
            }

            // Update status pembelian
            Pembelian::where('ID_Pembelian', $pembelianId)->update([
                'ID_Distributor' => $request->ID_Distributor,
                'Status' => 'Selesai',
                'Tanggal' => now(),
            ]);

            DB::commit();

            session()->forget('pembelian_id');

            return redirect()->route('pembelian.index')->with('success', 'Pembelian selesai dan stok berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus barang dari pembelian.
     */
    public function destroy(Request $request)
    {
        $idPembelian = $request->input('ID_Pembelian');
        $idBarang = $request->input('ID_Barang');

        $detail = BarangPembelian::where('ID_Pembelian', $idPembelian)
            ->where('ID_Barang', $idBarang)
            ->firstOrFail();

        $detail->delete();

        // Update total keseluruhan
        $grandTotal = BarangPembelian::where('ID_Pembelian', $idPembelian)->sum('Total_Harga');
        Pembelian::where('ID_Pembelian', $idPembelian)->update(['Harga_Keseluruhan' => $grandTotal]);

        return redirect()->back()->with('success', 'Barang berhasil dihapus dari pembelian.');
    }

    /**
     * Batalkan transaksi pembelian (hapus item dan reset total).
     */
    public function cancel()
    {
        $pembelianId = session('pembelian_id');

        if (!$pembelianId) {
            return redirect()->back()->with('error', 'Tidak ada pembelian untuk dibatalkan.');
        }

        BarangPembelian::where('ID_Pembelian', $pembelianId)->delete();

        Pembelian::where('ID_Pembelian', $pembelianId)->update([
            'Harga_Keseluruhan' => 0,
            'Status' => 'Pending',
            'Tanggal' => now(),
        ]);

        return redirect()->route('pembelian.create')->with('success', 'Transaksi pembelian dibatalkan dan data telah direset.');
    }

    /**
     * Membatalkan transaksi pembelian tertentu dan rollback stok.
     */
    public function batalPembelian($id)
    {
        $pembelian = Pembelian::with('barangpembelian')->findOrFail($id);

        if ($pembelian->Status === 'Batal') {
            return redirect()->back()->with('error', 'Transaksi ini sudah dibatalkan sebelumnya.');
        }

        // Rollback stok barang
        foreach ($pembelian->barangpembelian as $item) {
            $barang = Barang::find($item->ID_Barang);
            if ($barang) {
                $barang->Stok_Barang -= $item->Jumlah_Pesanan;
                $barang->save();
            }
        }

        $pembelian->update(['Status' => 'Batal']);

        return redirect()->route('pembelian.index')->with('success', 'Transaksi pembelian berhasil dibatalkan dan stok dikembalikan.');
    }
}
