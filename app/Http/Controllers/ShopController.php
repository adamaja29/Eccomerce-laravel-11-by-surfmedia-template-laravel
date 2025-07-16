<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function index(Request $request){
        $categoryId = $request->query('category');

        $categories = Kategori::all();

        if ($categoryId) {
            $produks = Produk::where('kategori_id', $categoryId)->orderBy('created_at', 'desc')->paginate(9);
        } else {
            $produks = Produk::orderBy('created_at', 'desc')->paginate(9);
        }

        $cartitems = Cart::where('user_id', Auth::id())->get();

        return view('shop', compact('produks', 'cartitems', 'categories', 'categoryId'));
    }

    public function showDetail($id){
        $cartitems = Cart::where('user_id', Auth::id())->get();
        $produk = Produk::where('id', $id)->firstOrFail();
        $produks = Produk::where('id', '<>', $id)->take(8)->get();
        // Check if the product is already in the cart
        
        return view('detail', compact('produk', 'produks', 'cartitems', ));
    }
}
