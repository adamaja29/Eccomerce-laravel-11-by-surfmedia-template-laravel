<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\MetodePembayaran;
use App\Models\pesanan;
use App\Models\detail_pesanan;
use App\Models\Pembelian;
use Illuminate\Support\Facades\Redirect;
use App\Models\Produk;
use App\Models\Suppliers;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\laravel\Facades\Image;
use Illuminate\Http\Request;

use function Laravel\Prompts\select;

class HomeController extends Controller
{
    public function index()
    {
        // Total counts
        $totalOrders = pesanan::count();
        $totalPembelian = Pembelian::count();
        $totalProduk = Produk::count();
        $totalSuppliers = Suppliers::count();

        // Total amount (sum of subtotal in detail_pesanan for approved orders)
        $totalAmount = DB::table('detail_pesanan')
            ->join('pesanan', 'detail_pesanan.pesanan_id', '=', 'pesanan.id')
            ->where('pesanan.status', 'approve')
            ->sum('detail_pesanan.subtotal');

        // Total pemasukan from approved orders (same as totalAmount)
        $totalPemasukan = $totalAmount;

        // Total pengeluaran from received purchases
        $totalPengeluaran = DB::table('detail_pembelian')
            ->join('pembelian', 'detail_pembelian.pembelian_id', '=', 'pembelian.id')
            ->where('pembelian.status', 'diterima')
            ->sum('detail_pembelian.subtotal');

        // Calculate revenue as pemasukan - pengeluaran
        $revenue = $totalPemasukan - $totalPengeluaran;

        // Calculate monthly total data for chart
        $dataTotal = [];
        for ($month = 1; $month <= 12; $month++) {
            $monthlyTotal = DB::table('detail_pesanan')
                ->join('pesanan', 'detail_pesanan.pesanan_id', '=', 'pesanan.id')
                ->whereYear('pesanan.created_at', date('Y'))
                ->whereMonth('pesanan.created_at', $month)
                ->where('pesanan.status', 'approve')
                ->sum('detail_pesanan.subtotal');
            $dataTotal[] = $monthlyTotal;
        }

        $recentOrders = pesanan::with(['user', 'alamat', 'detailProduk'])->orderBy('created_at', 'desc')->take(3)->get();
        
        foreach ($recentOrders as $order) {
            $order->total_items = $order->detailProduk->sum('jumlah');
            $total = 0;
            foreach ($order->detailProduk as $detail) {
                $price = $detail->harga_satuan ?? 0;
                $total += $detail->jumlah * $price;
            }
            $order->total = $total;
        }

        // Additional counts for success and canceled status
        $totalSuccess = pesanan::where('status', 'approve')->count();
        $totalCanceled = pesanan::where('status', 'cancelled')->count();

        return view('admin.dashboard', compact(
            'totalOrders', 'totalPembelian', 'totalProduk', 'totalSuppliers', 'totalPemasukan', 'totalPengeluaran', 'revenue', 'recentOrders', 'totalSuccess', 'totalCanceled', 'dataTotal'
        ));
    }

    public function dashboard(){
         // Ambil data pendapatan berdasarkan bulan
    $total = DB::table('orders')
    ->selectRaw('MONTH(created_at) as month, SUM(total) as total')
    ->groupBy('month')
    ->orderBy('month')
    ->pluck('total', 'month'); // hasil: [6 => 273.22, 7 => 208.12]

// Siapkan array data 12 bulan, default 0
$dataTotal = array_fill(0, 12, 0);

foreach ($total as $month => $value) {
    $dataTotal[$month - 1] = round($value, 2); // Index 0 = Jan
}

return view('admin.dashboard', [
    'dataTotal' => $dataTotal,
]);
    }

    public function home()
    {
        $featuredProducts = \App\Models\Produk::orderBy('created_at', 'desc')->take(8)->get();
        $categories = \App\Models\Kategori::orderBy('nama', 'asc')->get();

        return view('home', compact('featuredProducts', 'categories'));
    }
}
