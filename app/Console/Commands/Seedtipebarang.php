<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\tipebarang;

class Seedtipebarang extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:seed-tipebarang';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Memasukkan data Nama_Satuan wajib ke tabel tipe_barang';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $satuan = [
            'kilogram',
            'kantong',
            'botol',
            'lembar',
            'kaleng',
            'buah',
            'set',
            'sak',
            'kol',
            'kotak',
            'ember',
            'rol',
            'meter',
            'Liter',
            'ML',
            'CC',
        ];
        foreach ($satuan as $nama) {
            TipeBarang::firstOrCreate(['Nama_Satuan' => $nama]);
        }
    }
}