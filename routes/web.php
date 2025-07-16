<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [HomeController::class, 'home'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/account-dashboard', [UserController::class, 'index'])->name('user.dashboard');
    Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
    Route::get('/shop/{id}', [ShopController::class, 'showDetail'])->name('shop.detail');

    Route::get('/cart', [CartController::class, 'index'])->name('shop.cart');
    Route::post('/cart', [CartController::class, 'addToCart'])->name('cart.add');
    Route::put('/cart/increase/{id}', [CartController::class, 'increase'])->name('cart.increase');
    Route::put('/cart/decrease/{id}', [CartController::class, 'decrease'])->name('cart.decrease');
    Route::delete('/cart/{id}/delete', [CartController::class, 'delete'])->name('cart.delete');


// simpan produk yang dipilih ke session dan redirect ke halaman checkout
Route::post('/cart/prepare-checkout', [cartController::class, 'prepare'])->name('checkout.prepare');

// tampilkan halaman checkout (GET)
Route::get('/cart/checkout', [CheckoutController::class, 'index'])->name('checkout.page');
Route::post('/pilih-alamat', [CheckoutController::class, 'pilih'])->name('user.alamat.pilih');
Route::post('/alamat/store', [CheckoutController::class, 'storeAlamat'])->name('user.alamat.store');

Route::post('/checkout/store', [CheckoutController::class, 'checkoutStore'])->name('checkout.store');


Route::get('/checkout/sukses/{orderId}', [CheckoutController::class, 'suksesPesan'])->name('checkout.sukses');

    Route::get('/pesanan', [UserController::class, 'pesanan'])->name('user.pesanan');
    Route::get('/pesanan/{id}', [CheckoutController::class, 'detailPesanan'])->name('user.detail.pesanan');

    // New API route for order details modal
    Route::get('/api/order-details/{id}', [UserController::class, 'orderDetails'])->name('api.order.details');

    Route::get('/user/order-details/{id}', [UserController::class, 'showOrderDetails'])->name('user.order.details');
});

//ini admin middleware ya
Route::middleware(['auth', AuthMiddleware::class])->group(function () {
    Route::get('/admin', [HomeController::class, 'index'])->name('admin.dashboard');
    
    Route::get('/admin/kategori', [AdminController::class, 'Kategori'])->name('admin.kategori');
    Route::get('/admin/kategori/create', [AdminController::class, 'KategoriCreate'])->name('admin.create.kategori');
    Route::post('/admin/kategori/store', [AdminController::class, 'KategoriStore'])->name('admin.store.kategori');
    Route::get('/admin/kategori/{id}/edit', [AdminController::class, 'KategoriEdit'])->name('admin.edit.kategori');
    Route::put('/admin/kategori/update', [AdminController::class, 'KategoriUpdate'])->name('admin.update.kategori');
    Route::delete('/admin/kategori/{id}/delete', [AdminController::class, 'KategoriDelete'])->name('admin.delete.kategori');

    Route::get('admin/produk', [AdminController::class, 'Produk'])->name('admin.produk');
    Route::get('admin/produk/create', [AdminController::class, 'ProdukCreate'])->name('admin.create.produk');
    Route::post('admin/produk/store', [AdminController::class, 'ProdukStore'])->name('admin.store.produk');
    Route::get('admin/produk/{id}/edit', [AdminController::class, 'ProdukEdit'])->name('admin.edit.produk');
    Route::put('admin/produk/update', [AdminController::class, 'ProdukUpdate'])->name('admin.update.produk');
    Route::delete('admin/produk/{id}/delete', [AdminController::class, 'ProdukDelete'])->name('admin.delete.produk');

    Route::get('admin/metode-pembayaran', [AdminController::class, 'MetodePembayaran'])->name('admin.metode.pembayaran');
    Route::get('admin/metode-pembayaran/create', [AdminController::class, 'createMethod'])->name('admin.create.metode');
    Route::post('admin/metode-pembayaran/store', [AdminController::class, 'store'])->name('store.metode');
    route::get('admin/metode-pembayaran/{id}/edit', [AdminController::class, 'editMethod'])->name('edit.metode');
    Route::put('admin/metode-pembayaran/update', [AdminController::class, 'updateMethod'])->name('update.metode');
    Route::delete('admin/metode-pembayaran/{id}/delete', [AdminController::class, 'deleteMethod'])->name('delete.metode');

    Route::get('admin/supplier', [AdminController::class, 'Supplier'])->name('admin.supplier');
    Route::get('admin/supplier/create', [AdminController::class, 'createSupplier'])->name('admin.create.supplier');
    Route::post('admin/supplier/store', [AdminController::class, 'storeSupplier'])->name('admin.store.supplier');
    Route::get('admin/supplier/{id}/edit', [AdminController::class, 'editSupplier'])->name('edit.supplier');
    Route::put('admin/supplier/update', [AdminController::class, 'updateSupplier'])->name('update.supplier');
    Route::delete('admin/supplier/{id}/delete', [AdminController::class, 'deleteSupplier'])->name('delete.supplier');

    Route::get('admin/validasi-pesanan', [TransaksiController::class, 'ValidasiPesanan'])->name('admin.validasi.pesanan');
    Route::get('admin/detail-pesanan/{id}', [TransaksiController::class, 'showOrder'])->name('admin.pesanan.show');
    Route::post('admin/validasi-pesanan/{id}/approve', [TransaksiController::class, 'approveOrder'])->name('admin.validasi.pesanan.approve');
    Route::post('admin/validasi-pesanan/{id}/cancel', [TransaksiController::class, 'cancelOrder'])->name('admin.validasi.pesanan.cancel');

    Route::get('admin/pembelian', [TransaksiController::class, 'Pembelian'])->name('admin.pembelian');
    Route::post('admin/pembelian/{id}/update-status', [TransaksiController::class, 'updatePembelianStatus'])->name('admin.pembelian.update.status');
    Route::post('admin/pembelian/{id}/approve', [TransaksiController::class, 'approvePembelian'])->name('admin.pembelian.approve');
    Route::post('admin/pembelian/{id}/cancel', [TransaksiController::class, 'cancelPembelian'])->name('admin.pembelian.cancel');
    Route::get('admin/pembelian/create', [TransaksiController::class, 'createPembelian'])->name('admin.pembelian.create');
    Route::post('admin/pembelian', [TransaksiController::class, 'storePembelian'])->name('admin.pembelian.store');
    Route::get('admin/pembelian/{id}/detail', [TransaksiController::class, 'DetailPembelian'])->name('admin.pembelian.detail');

    Route::get('admin/laporan', [LaporanController::class, 'laporan'])->name('admin.laporan');

    Route::get('admin/tes', [TransaksiController::class, 'tes'])->name('admin.tes');
});
