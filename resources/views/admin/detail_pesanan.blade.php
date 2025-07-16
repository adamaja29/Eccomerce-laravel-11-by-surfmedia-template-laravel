@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Order Details</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ url('admin/orders') }}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Order Items</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <h5>Ordered Items</h5>
                </div>
                <a class="tf-button style-1 w208" href="{{ route('admin.validasi.pesanan') }}">Back</a>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Subtotal</th>
                            <th class="text-center">Category</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($detailPesanan as $item)
                        <tr>
                            <td class="pname">
                                <div class="image">
                                    <img src="{{ asset('uploads/produk/' . $item->produk->image) }}" alt="{{ $item->produk->nama }}" class="image" style="max-width: 80px;">
                                </div>
                                <div class="name">
                                    <a href="#" target="_blank" class="body-title-2">{{ $item->produk->nama }}</a>
                                </div>
                            </td>
                            <td class="text-center">{{ number_format($item->produk->harga_jual, 2) }}</td>
                            <td class="text-center">{{ $item->jumlah }}</td>
                            <td class="text-center">{{ number_format($item->produk->harga_jual * $item->jumlah, 2) }}</td>
                            <td class="text-center">{{ $item->produk->kategori->nama ?? '-' }}</td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="divider"></div>
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">

            </div>
        </div>

        <div class="wg-box mt-5">
            <h5>Shipping Address</h5>
            <div class="my-account__address-item col-md-6">
                <div class="my-account__address-item__detail">
                    <p>Penerima: {{ $order->alamat->nama_penerima }}</p>
                    <p>{{ $order->alamat->alamat_lengkap ?? '' }}</p>
                    <p>{{ $order->alamat->kota ?? '' }}, {{ $order->alamat->provinsi ?? '' }}, {{$order->alamat->kecamatan}}</p>
                    <p>{{$order->alamat->full_address}}</p>
                    <p>{{ $order->alamat->kode_pos ?? '' }}</p>
                    <br>
                    <p>No HP Penerima : {{ $order->alamat->phone ?? '-' }}</p>
                </div>
            </div>
        </div>

        <div class="wg-box mt-5">
            <h5>Transactions</h5>
            <table class="table table-striped table-bordered table-transaction">
                    <tbody>
                        <tr>
                            <th>Subtotal</th>
                            <td>{{ number_format($order->detailProduk->sum(function($item) { return $item->jumlah * $item->harga_satuan; }), 2) }}</td>
                            <th>Stok Awal</th>
                            <td>{{ $item->stok_awal }}</td>
                            <th>Stok Akhir</th>
                            <td>{{ $item->stok_akhir ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <td>{{ number_format($order->detailProduk->sum(function($item) { return $item->jumlah * $item->harga_satuan; }), 2) }}</td>
                            <th>Payment Mode</th>
                            <td>{{ $order->metodePembayaran->nama }}</td>
                            <th>Status</th>
                            <td>{{ ucfirst($order->status) }}</td>
                        </tr>
                        <tr>
                            <th>Order Date</th>
                            <td>{{ $order->created_at }}</td>
                            <th>Delivered Date</th>
                            <td>{{ $order->delivered_on ?? '-' }}</td>
                            <th>Canceled Date</th>
                            <td>{{ $order->canceled_at ?? '-' }}</td>
                        </tr>
                    </tbody>
            </table>
        </div>

            <div class="wg-box mt-5">
                <h5>Bukti Pembayaran</h5>
                @if($order->bukti_pembayaran)
                <img src="{{ asset('uploads/bukti_pembayaran/' . rawurlencode($order->bukti_pembayaran)) }}" alt="Proof of Payment" style="max-width: 300px;">
                @else
                <p>Tidak ada Bukti Pembayaran</p>
                @endif
            </div>
    </div>
</div>
@endsection
