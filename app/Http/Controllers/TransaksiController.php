<?php

namespace App\Http\Controllers;

use App\Models\detail_pesanan;
use App\Models\DetailPembelian;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\pesanan;
use App\Models\Produk;
use App\Models\Pembelian;
use App\Models\Suppliers;

class TransaksiController extends Controller
{
    public function ValidasiPesanan()
    {
        // Fetch paginated orders with user, address, and detailProduk relations, ordered by latest created_at
        $orders = pesanan::with(['user', 'alamat', 'detailProduk'])->orderBy('created_at', 'desc')->paginate(10);

        // Calculate total items and total price for each order
        foreach ($orders as $order) {
            $order->total_items = $order->detailProduk->sum('jumlah');

            // Calculate total as sum of jumlah * harga_satuan from detailProduk
            $total = 0;
            foreach ($order->detailProduk as $detail) {
                $price = $detail->harga_satuan ?? 0;
                $total += $detail->jumlah * $price;
            }
            $order->total = $total;

            // Calculate deliver_on date if status is not pending (3 days after created_at)
            if ($order->status !== 'pending') {
                $order->deliver_on = $order->created_at->addDays(3)->format('Y-m-d');
            } else {
                $order->deliver_on = null;
            }
        }

        return view('admin.validasi_pesanan', compact('orders'));
    }

    public function approveOrder($id)
{
    $order = Pesanan::with('detailProduk.produk')->findOrFail($id);

    foreach ($order->detailProduk as $detail) {
        $produk = $detail->produk;

        if ($produk) {
            // Pastikan stok cukup
            if ($produk->stok < $detail->jumlah) {
                return redirect()->back()->with('error', 'Stok produk "' . $produk->nama . '" tidak mencukupi.');
            }

            // Kurangi stok
            $produk->stok -= $detail->jumlah;
            $produk->save();

            // Simpan stok akhir ke detail pesanan
            $detail->stok_akhir = $produk->stok;
            $detail->save();
        }
    }

    // Set status pesanan jadi "approve"
    $order->status = 'approve';
    $order->save();

    return redirect()->route('admin.validasi.pesanan')->with('success', 'Pesanan berhasil disetujui dan stok diperbarui.');
}

    public function cancelOrder($id)
    {
        $order = pesanan::findOrFail($id);
        $order->status = 'cancelled';
        $order->save();

        return redirect()->route('admin.validasi.pesanan')->with('success', 'Order cancelled successfully.');
    }

    public function showOrder($id)
    {
        return view('admin.detail_pesanan', [
            'order' => pesanan::with(['user', 'alamat', 'detailProduk', 'metodePembayaran'])->findOrFail($id),
            'detailPesanan' => detail_pesanan::where('pesanan_id', $id)->get(),
        ]);
    }

    public function Pembelian()
    {
        $pembelians = Pembelian::with('supplier')->orderBy('created_at', 'desc')->paginate(10);

        // Add total_products and total_price attributes to each pembelian
        foreach ($pembelians as $pembelian) {
            $pembelian->total_products = $pembelian->detailPembelian()->count();
            $pembelian->total_price = $pembelian->detailPembelian->sum(function ($detail) {
            return $detail->jumlah * $detail->harga_satuan;
            });
        }

        return view('admin.pembelian', compact('pembelians'));
    }

    public function createPembelian(Request $request)
    {
        $supplier_id = $request->query('supplier_id');
        $produk_id = $request->query('produk_id');

        if ($supplier_id) {
            $produks = Produk::where('supplier_id', $supplier_id)->get();
        } else {
            $produks = Produk::all();
        }

        if ($produk_id) {
            $produk = Produk::find($produk_id);
            if ($produk) {
                $supplier_id = $produk->supplier_id;
            }
        }

        $suppliers = Suppliers::all();
        return view('admin.create_pembelian', compact('produks', 'suppliers', 'supplier_id', 'produk_id'));
    }


    public function storePembelian(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'tanggal_pembelian' => 'required|date',
            'produk_id' => 'required|array',
            'produk_id.*' => 'required|exists:produks,id',
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|integer|min:1',
            'harga_beli' => 'required|array',
            'harga_beli.*' => 'required|numeric|min:0',
        ]);

        // Create Pembelian
        $pembelian = Pembelian::create([
            'supplier_id' => $validated['supplier_id'],
            'tanggal_pembelian' => $validated['tanggal_pembelian'],
            'nomor_invoice' => 'INV-' . date('YmdHis') . '-' . $validated['supplier_id'],
            'status' => 'dipesan',
        ]);

        // Create DetailPembelian for each produk
        foreach ($validated['produk_id'] as $index => $produkId) {
            $produk = Produk::find($produkId);
            $stok_awal = $produk ? $produk->stok : 0;

            DetailPembelian::create([
                'pembelian_id' => $pembelian->id,
                'produk_id' => $produkId,
                'jumlah' => $validated['jumlah'][$index],
                'harga_satuan' => $validated['harga_beli'][$index],
                'subtotal' => $validated['jumlah'][$index] * $validated['harga_beli'][$index],
                'stok_awal' => $stok_awal,
            ]);
        }

        return redirect()->route('admin.pembelian')->with('success', 'Pembelian berhasil ditambahkan.');
    }

    public function approvePembelian($id)
{
    $pembelian = Pembelian::with('detailPembelian')->findOrFail($id);
    $pembelian->status = 'diterima';

    foreach ($pembelian->detailPembelian as $detail) {
        $produk = Produk::find($detail->produk_id);
        if ($produk) {
            // Tambahkan jumlah ke stok produk
            $produk->stok += $detail->jumlah;
            $produk->save();

            // Simpan stok akhir ke detail pembelian
            $detail->stok_akhir = $produk->stok;
            $detail->save();
        }
    }

    $pembelian->save();

    return redirect()->route('admin.pembelian')->with('success', 'Pembelian berhasil diterima dan stok diperbarui.');
}

    public function cancelPembelian($id)
    {
        $pembelian = Pembelian::findOrFail($id);
        $pembelian->status = 'ditolak';
        $pembelian->save();

        return redirect()->route('admin.pembelian')->with('success', 'Pembelian cancelled successfully.');
    }

    public function DetailPembelian($id)
    {

        return view('admin.detail_pembelian', [
            'pembelian' => pembelian::with(['detailPembelian', 'supplier'])->findOrFail($id),
            'detail_pembelian' => DetailPembelian::where('pembelian_id', $id)->get(),
        ]);
    }

    public function tes()
    {
        $orders = pesanan::get();
        return view('admin.tes', compact('orders'));
    }
    
}
