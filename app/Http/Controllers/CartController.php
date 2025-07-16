<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        
        $items = Auth::user();
        $cartitems = DB::table('carts')
            ->join('produks', 'carts.produk_id', '=', 'produks.id')
            ->where('carts.user_id', $items->id)
            ->select('carts.*', 'produks.nama as nama', 'produks.harga_jual as harga', 'produks.image as foto', 'produks.images as images', 'produks.deskripsi as deskripsi')
            ->orderBy('created_at', 'desc')->get();

        return view('cart')->with('cartitems', $cartitems); 
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:produks,id',
            'quantity' => 'required|integer|min:1',
        ]);
        $cart = Cart::where('user_id', Auth::id())
            ->where('produk_id', $request->id)
            ->first();
    
        if ($cart) {
            $cart->quantity += $request->quantity;
            $cart->save();
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'produk_id' => $request->id,
                'quantity' => $request->quantity,
            ]);
        }
        return redirect()->back()->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function increase($id)
{
    $cart = Cart::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
    $cart->quantity += 1;
    $cart->save();
    return redirect()->back();
}

public function decrease($id)
{
    $cart = Cart::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
    if ($cart->quantity > 1) {
        $cart->quantity -= 1;
        $cart->save();
    } else {
        $cart->delete(); // Hapus item kalau quantity sudah 1 lalu dikurangi
    }

    return redirect()->back();
}

public function delete($id)
{
    $cart = Cart::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
    $cart->delete();
    return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang.');

}

public function prepare(Request $request)
{
    $request->validate([
        'selected_products' => 'required',
    ]);
    session(['selected_products' => json_decode($request->selected_products)]);
    return redirect()->route('checkout.page');
}

}
