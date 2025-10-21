<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use Illuminate\Support\Facades\DB;

class PajakController extends Controller
{
    public function dashboardData(Request $request)
    {
        $filter = $request->get('filter', 'tahun'); // default: per tahun

        switch ($filter) {
            case 'bulan':
                $data = Penjualan::select(
                    DB::raw('YEAR(Tanggal) as Tahun'),
                    DB::raw('MONTH(Tanggal) as Bulan'),
                    DB::raw('SUM(Harga_Keseluruhan) as Total_Omzet')
                )
                    ->where('Status', 'Selesai')
                    ->whereYear('Tanggal', date('Y'))
                    ->groupBy(DB::raw('YEAR(Tanggal), MONTH(Tanggal)'))
                    ->orderBy(DB::raw('MONTH(Tanggal)'), 'ASC')
                    ->get();

                $labels = $data->map(fn($item) => date('F', mktime(0, 0, 0, $item->Bulan, 1)));
                break;

            case 'minggu':
                $data = Penjualan::select(
                    DB::raw('YEARWEEK(Tanggal, 1) as MingguKe'),
                    DB::raw('SUM(Harga_Keseluruhan) as Total_Omzet')
                )
                    ->where('Status', 'Selesai')
                    ->whereYear('Tanggal', date('Y'))
                    ->groupBy(DB::raw('YEARWEEK(Tanggal, 1)'))
                    ->orderBy(DB::raw('YEARWEEK(Tanggal, 1)'), 'ASC')
                    ->get();

                $labels = $data->map(fn($item) => 'Minggu ' . substr($item->MingguKe, -2));
                break;

            case 'hari':
                $data = Penjualan::select(
                    DB::raw('DATE(Tanggal) as Hari'),
                    DB::raw('SUM(Harga_Keseluruhan) as Total_Omzet')
                )
                    ->where('Status', 'Selesai')
                    ->whereMonth('Tanggal', date('m'))
                    ->groupBy(DB::raw('DATE(Tanggal)'))
                    ->orderBy(DB::raw('DATE(Tanggal)'), 'ASC')
                    ->get();

                $labels = $data->pluck('Hari');
                break;

            default: // tahun
                $data = Penjualan::select(
                    DB::raw('YEAR(Tanggal) as Tahun'),
                    DB::raw('SUM(Harga_Keseluruhan) as Total_Omzet')
                )
                    ->where('Status', 'Selesai')
                    ->groupBy(DB::raw('YEAR(Tanggal)'))
                    ->orderBy(DB::raw('YEAR(Tanggal)'), 'ASC')
                    ->get();

                $labels = $data->pluck('Tahun');
                break;
        }

        $values = $data->pluck('Total_Omzet');

        return response()->json([
            'labels' => $labels,
            'values' => $values
        ]);
    }
}
