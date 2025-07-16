@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="my-4">Daftar Pesanan</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Pelanggan</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>BUKTI PEMABAYARAN</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $order->user_id }}</td>
                <td>{{ $order->product_name }}</td>
                <td>{{ $order->quantity }}</td>
                <td><img src="{{ asset('uploads/bukti_pembayaran/' . $order->bukti_pembayaran) }}" alt="Proof of Payment" style="max-width: 300px;"></td>
                <td>{{ $order->status }}</td>
                <td>
                    
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection