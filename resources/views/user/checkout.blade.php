<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="surfside media" />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Allura&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/swiper.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
          integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw=="
          crossorigin="anonymous" referrerpolicy="no-referrer">
    @stack('styles')
</head>
<body>
<main class="mt-5">
    <div class="container">
        <h2 class="page-title mb-3">Checkout</h2>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if($products->count() > 0)
            <form action="{{ route('checkout.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card mb-3">
                    <div class="card-header">Alamat Pengiriman</div>
                    <div class="card-body">
                        @if($alamatAktif)
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>
                                            <strong>{{ $alamatAktif->nama_penerima }}</strong><br>
                                            {{ $alamatAktif->phone }}
                                        </td>
                                        <td>{{ $alamatAktif->provinsi }} {{ $alamatAktif->kota }} {{ $alamatAktif->kecamatan }} {{ $alamatAktif->full_address }}</td>
                                        <td>
                                            <button type="button" class="btn btn-link" data-toggle="modal" data-target="#modalPilihAlamat" style="font-weight: bold;">Ubah Alamat</button>
                                            <input type="hidden" name="alamat_id" value="{{ $alamatAktif->id }}">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        @else
                            <p class="text-danger">Kamu belum punya alamat pengiriman.</p>
                            <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#modalTambahAlamat" id="btnTambahAlamatCheckout">Tambah Alamat Baru</button>
                        @endif
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Image</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $grandTotal = 0; @endphp
                                @foreach($products as $cart)
                                    @php
                                        $product = $cart->produk;
                                        $subtotal = $product->harga_jual * $cart->quantity;
                                        $grandTotal += $subtotal;
                                    @endphp
                                    <tr>
                                        <td>{{ $product->nama }}</td>
                                        <td>
                                            <img loading="lazy" src="{{ asset('uploads/produk/' . $product->image) }}" width="80" />
                                        </td>
                                        <td>{{ $cart->quantity }}</td>
                                        <td>Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                    <input type="hidden" name="product_ids[]" value="{{ $product->id }}">
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-end">Grand Total</th>
                                    <th>Rp {{ number_format($grandTotal, 0, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="card mt-3 mb-3">
                    <div class="card-header">Metode Pembayaran dan Bukti Pembayaran</div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="payment_method">Pilih Metode Pembayaran</label>
                            <select class="form-control" id="payment_method" name="payment_method" onchange="showPaymentDetails(this)">
                                <option value="" disabled selected>Pilih Metode</option>
                                @foreach($metode as $item)
                                    <option value="{{ $item->id }}" data-description="{{ $item->deskripsi }}" data-image="{{ $item->image ? asset('uploads/pembayaran/' . $item->image) : '' }}">
                                        {{ $item->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div id="payment_details" class="mt-3" style="display: none;">
                            <p id="payment_description"></p>
                            <img id="payment_image" src="" alt="Metode Pembayaran" style="max-width: 100%; height: auto; display: none;">
                        </div>
                        <div class="form-group mb-3">
                            <label for="payment_proof">Upload Bukti Pembayaran</label>
                            <input type="file" class="form-control" id="bukti_pembayaran" name="bukti_pembayaran" accept="image/*">

                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success mb-5">Buat Pesanan</button>
            </form>
        @else
            <p>No selected products found.</p>
            <a href="{{ route('shop.cart') }}" class="btn btn-primary">Back to Cart</a>
        @endif
    </div>
</main>

@include('components.modal_pilihalamat')
@include('components.modal-tambah-alamat')


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>


<script src="{{ asset('js/checkout.js') }}"></script>
</body>
</html>

