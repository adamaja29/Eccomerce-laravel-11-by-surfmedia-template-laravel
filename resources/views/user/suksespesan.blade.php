@extends('layouts.app')
@section('content')

<div class="container mt-5">
    <section class="shop-checkout container">
        <h2 class="page-title">Order Received</h2>
        <div class="order-complete">
            <div class="order-complete__message text-center mb-4">
                <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-3">
                    <circle cx="40" cy="40" r="40" fill="#B9A16B" />
                    <path
                        d="M52.9743 35.7612C52.9743 35.3426 52.8069 34.9241 52.5056 34.6228L50.2288 32.346C49.9275 32.0446 49.5089 31.8772 49.0904 31.8772C48.6719 31.8772 48.2533 32.0446 47.952 32.346L36.9699 43.3449L32.048 38.4062C31.7467 38.1049 31.3281 37.9375 30.9096 37.9375C30.4911 37.9375 30.0725 38.1049 29.7712 38.4062L27.4944 40.683C27.1931 40.9844 27.0257 41.4029 27.0257 41.8214C27.0257 42.24 27.1931 42.6585 27.4944 42.9598L33.5547 49.0201L35.8315 51.2969C36.1328 51.5982 36.5513 51.7656 36.9699 51.7656C37.3884 51.7656 37.8069 51.5982 38.1083 51.2969L40.385 49.0201L52.5056 36.8996C52.8069 36.5982 52.9743 36.1797 52.9743 35.7612Z"
                        fill="white" />
                </svg>
                <h3>Your order is completed!</h3>
                <p>Thank you. Your order has been received.</p>
            </div>
        <div class="order-info">
            <div class="order-info__item">
                <label>Order Number</label>
                <span>{{ $order->created_at->format('Ymd') . $order->id }}</span>
            </div>
            <div class="order-info__item">
                <label>Date</label>
                <span>{{ $order->created_at->format('d/m/Y') }}</span>
            </div>
            <div class="order-info__item">
                <label>Total</label>
                <span>Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
            </div>
            <div class="order-info__item">
                <label>Payment Method</label>
                <span>{{ $order->status }}</span>
            </div>
        </div>

        <div class="order-products mt-4">
            <h5>Detail Produk</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->detailProduk as $detail)
                    <tr>
                        <td>{{ $detail->produk->nama ?? 'Produk tidak ditemukan' }}</td>
                        <td>{{ $detail->jumlah }}</td>
                        <td>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </div>
        <div class="mt-3 text-center">
            <a href="{{ route('user.pesanan') }}" class="btn btn-primary">Liat Pesanan Anda</a>
        </div>
    </section>
</div>

@endsection
