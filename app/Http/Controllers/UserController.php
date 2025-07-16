<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        
        return view('user.dashboard');
    }

    public function pesanan(){
        $userId = Auth::id();
        $orders = DB::table('pesanan')
            ->join('detail_pesanan', 'pesanan.id', '=', 'detail_pesanan.pesanan_id')
            ->join('produks', 'detail_pesanan.produk_id', '=', 'produks.id')
            ->join('user_addresses', 'pesanan.alamat_id', '=', 'user_addresses.id')
            ->select(
                'pesanan.id',
                'user_addresses.nama_penerima as name',
                'user_addresses.phone',
                DB::raw('SUM(detail_pesanan.jumlah * detail_pesanan.harga_satuan) as subtotal'),
                DB::raw('SUM(detail_pesanan.jumlah * detail_pesanan.harga_satuan) * 1.1 as total'),
                'pesanan.status',
                'pesanan.created_at',
                DB::raw('COUNT(detail_pesanan.produk_id) as items_count'),
                'pesanan.updated_at as delivered_on'
            )
            ->where('pesanan.user_id', $userId)
            ->groupBy('pesanan.id', 'user_addresses.nama_penerima', 'user_addresses.phone', 'pesanan.status', 'pesanan.created_at', 'pesanan.updated_at')
            ->orderBy('pesanan.created_at', 'desc')
            ->get();

        return view('user.pesanan', compact('orders'));
    }

    public function orderDetails($id){
        $userId = Auth::id();
        $orderDetails = DB::table('detail_pesanan')
            ->join('produks', 'detail_pesanan.produk_id', '=', 'produks.id')
            ->select(
                'produks.nama',
                'produks.image',
                'detail_pesanan.jumlah',
                'detail_pesanan.harga_satuan',
                DB::raw('(detail_pesanan.jumlah * detail_pesanan.harga_satuan) as total_price')
            )
            ->where('detail_pesanan.pesanan_id', $id)
            ->get();

        return response()->json($orderDetails);
    }
}
