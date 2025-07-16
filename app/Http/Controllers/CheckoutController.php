<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\detail_pesanan;
use App\Models\pesanan;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserAddress;

class CheckoutController extends Controller
{
    public function index()
{
    // Ambil ID produk yang dipilih dari session
    $selectedProductIds = session('selected_products');

    // Cek jika kosong atau bukan array
    if (empty($selectedProductIds) || !is_array($selectedProductIds)) {
        return redirect()->route('shop.cart')->with('error', 'Tidak ada produk yang dipilih');
    }

    // Ambil produk dari cart milik user yang dipilih
    $products = Cart::with('produk')
        ->where('user_id', Auth::id())
        ->whereIn('id', $selectedProductIds)
        ->get();

    // Ambil user login
    $user = Auth::user();
    $userId = $user->id;

    // Ambil alamat terpilih dari session
    $alamatAktif = null;
    if (session('alamat_terpilih')) {
        $alamatAktif = DB::table('user_addresses')
            ->where('id', session('alamat_terpilih'))
            ->where('user_id', $userId)
            ->first();
    }
    // fallback ke alamat pertama user jika belum ada alamat aktif
    if (!$alamatAktif) {
        $alamatAktif = DB::table('user_addresses')
            ->where('user_id', $userId)
            ->orderBy('id', 'asc')
            ->first();
    }

    // Ambil semua alamat user
    $semuaAlamat = DB::table('user_addresses')
        ->where('user_id', $userId)
        ->orderBy('id', 'asc')
        ->get();

    // Ambil metode pembayaran
    $metode = DB::table('metode_pembayaran')->get();

    return view('user.checkout', compact('products', 'alamatAktif', 'semuaAlamat', 'metode'));
}

public function pilih(Request $request)
{
    $request->validate([
        'address_id' => 'required|exists:user_addresses,id',
    ]);

    $alamat = UserAddress::where('id', $request->address_id)
        ->where('user_id', Auth::id())
        ->first();

    if (!$alamat) {
        return redirect()->back()->with('error', 'Alamat tidak valid.');
    }

    // Simpan alamat terpilih ke session
    session(['alamat_terpilih' => $alamat->id]);

    return redirect()->back()->with('success', 'Alamat berhasil dipilih.');
}

public function storeAlamat(Request $request)
{
    $request->validate([
        'nama_penerima' => 'required',
        'phone' => 'required',
        'provinsi' => 'required',
        'kota' => 'required',
        'kecamatan' => 'required',
        'full_address' => 'required',
    ]);

    UserAddress::create([
        'user_id' => Auth::id(),
        'nama_penerima' => $request->nama_penerima,
        'phone' => $request->phone,
        'provinsi' => $request->provinsi,
        'kota' => $request->kota,
        'kecamatan' => $request->kecamatan,
        'full_address' => $request->full_address,
    ]);

    return redirect()->back()->with('success', 'Alamat baru berhasil ditambahkan.');
}

public function checkoutStore(Request $request)
{
    $request->validate([
        'alamat_id' => 'required|exists:user_addresses,id',
        'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    $user = Auth::user();
    $userId = $user->id;
    $selectedProductIds = session('selected_products');

    if (empty($selectedProductIds) || !is_array($selectedProductIds)) {
        return redirect()->route('shop.cart')->with('error', 'Tidak ada produk yang dipilih');
    }

    $cartItems = Cart::with('produk')
        ->where('user_id', $userId)
        ->whereIn('id', $selectedProductIds)
        ->get();

    if ($cartItems->isEmpty()) {
        return redirect()->route('shop.cart')->with('error', 'Keranjang kosong atau produk tidak ditemukan');
    }

    // Buat folder jika belum ada
    $uploadPath = public_path('uploads/bukti_pembayaran');
    if (!file_exists($uploadPath)) {
        mkdir($uploadPath, 0755, true);
    }

    // Simpan file dengan nama unik
    $file = $request->file('bukti_pembayaran');
    $fileName = time() . '_' . $file->getClientOriginalName();
    $file->move($uploadPath, $fileName);
    $filePath = $fileName;

    DB::beginTransaction();

    try {
        // Simpan ke tabel pesanan
        $pesananId = DB::table('pesanan')->insertGetId([
            'user_id' => $userId,
            'alamat_id' => $request->alamat_id,
            'metode_pembayaran' => $request->payment_method, // ID metode
            'bukti_pembayaran' => $filePath,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Simpan ke detail_pesanan
        foreach ($cartItems as $item) {
            $product = Produk::find($item->produk_id);
            $stokAwal = $product ? $product->stok : 0;
            DB::table('detail_pesanan')->insert([
                'pesanan_id' => $pesananId,
                'produk_id' => $item->produk_id,
                'jumlah' => $item->quantity, 
                'harga_satuan' => $item->produk->harga_jual,
                'subtotal' => $item->quantity  * $item->produk->harga_jual,
                'stok_awal' => $stokAwal,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Hapus item dari cart
        Cart::whereIn('id', $selectedProductIds)->delete();

        // Bersihkan session
        session()->forget(['selected_products', 'alamat_terpilih']);

        DB::commit();

        return redirect()->route('checkout.sukses', ['orderId' => $pesananId])
            ->with('success', 'Pesanan berhasil dibuat!');
    } catch (\Exception $e) {
        DB::rollBack();


        return redirect()->route('checkout.sukses')->with('error', 'Gagal menyimpan pesanan: ' . $e->getMessage());
    }
}

public function suksesPesan($orderId)
{
    $order = pesanan::with(['user', 'alamat', 'detailProduk'])->find($orderId);

    if (!$order) {
        return redirect()->route('shop.cart')->with('error', 'Pesanan tidak ditemukan.');
    }

    // Calculate total price
    $totalPrice = 0;
    foreach ($order->detailProduk as $detail) {
        $totalPrice += $detail->subtotal;
    }

    return view('user.suksespesan', ['order' => $order, 'totalPrice' => $totalPrice]);
}
}
