<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\pesanan;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function laporan()
    {
        $pembelians = Pembelian::with(['detailPembelian.produk'])
            ->where('status', 'diterima')
            ->get();

        $pesanan = pesanan::with(['detailProduk.produk'])
            ->where('status', 'approve')
            ->get();

        $mutasi = new Collection();

        $totalPembelian = 0;
        $totalPesanan = 0;

        // Mutasi dari pembelian (aggregated)
        foreach ($pembelians as $pembelian) {
            $distinctProducts = $pembelian->detailPembelian->unique('produk_id')->count();
            $total = $pembelian->detailPembelian->sum(function ($detail) {
                return $detail->jumlah * $detail->harga_satuan;
            });

            $totalPembelian += $total;

            $mutasi->push([
                'id' => $pembelian->id,
                'no_bukti' => $pembelian->nomor_invoice,
                'tanggal' => Carbon::parse($pembelian->updated_at),
                'jenis' => 'pembelian',
                'produk' => $distinctProducts . ' produk',
                'jumlah' => $distinctProducts,
                'total' => $total,
                'keterangan' => 'Dari Supplier ID ' . $pembelian->supplier_id,
            ]);
        }

        // Mutasi dari penjualan (aggregated)
        foreach ($pesanan as $pesan) {
            $distinctProducts = $pesan->detailProduk->unique('produk_id')->count();
            $total = $pesan->detailProduk->sum(function ($detail) {
                return $detail->jumlah * $detail->harga_satuan;
            });

            $totalPesanan += $total;

            $mutasi->push([
                'id' => $pesan->id,
                'no_bukti' => 'ORD-' . $pesan->created_at->format('Ymd') . $pesan->id,
                'tanggal' => Carbon::parse($pesan->updated_at),
                'jenis' => 'pesanan',
                'produk' => $distinctProducts . ' produk',
                'jumlah' => $distinctProducts,
                'total' => $total,
                'keterangan' => 'Ke User ID ' . $pesan->user_id,
            ]);
        }

        // Urutkan berdasarkan tanggal terbaru
        $mutasi = $mutasi->sortByDesc('tanggal')->values();

        $saldoAwal = 10000000; // saldo awal 10 juta
        $labaAsli = $totalPesanan - $totalPembelian;
        $laba = $saldoAwal + $labaAsli;

        return view('admin.laporan', compact('mutasi', 'laba', 'saldoAwal', 'labaAsli'));
    }
}
