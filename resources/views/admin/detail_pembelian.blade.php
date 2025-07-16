@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Detail Pembelian</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ route('admin.pembelian') }}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Detail Pembelian</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <h5>Detail Produk Pembelian</h5>
                </div>
                <a class="tf-button style-1 w208" href="{{ route('admin.pembelian') }}">Back</a>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th class="text-center">Harga Satuan</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-center">Subtotal</th>
                            <th class="text-center">Stok Awal</th>
                            <th class="text-center">Stok Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($detail_pembelian as $item)
                        <tr>
                            <td class="pname">
                                <div class="name">
                                    {{ $item->produk->nama ?? '-' }}
                                </div>
                            </td>
                            <td class="text-center">{{ number_format($item->harga_satuan, 2) }}</td>
                            <td class="text-center">{{ $item->jumlah }}</td>
                            <td class="text-center">{{ number_format($item->subtotal, 2) }}</td>
                            <td class="text-center">{{ $item->stok_awal ?? '-' }}</td>
                            <td class="text-center">{{ $item->stok_akhir ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="wg-box mt-5">
            <h5>Informasi Pembelian</h5>
            <table class="table table-striped table-bordered">
                <tbody>
                    <tr>
                        <th>Supplier</th>
                        <td>{{ $pembelian->supplier->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Pembelian</th>
                        <td>{{ $pembelian->tanggal_pembelian }}</td>
                    </tr>
                    <tr>
                        <th>Nomor Invoice</th>
                        <td>{{ $pembelian->nomor_invoice }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if ($pembelian->status === 'dipesan')
                                <span class="badge bg-warning">Dipesan</span>
                            @elseif ($pembelian->status === 'diterima')
                                <span class="badge bg-info">Restok</span>
                            @elseif ($pembelian->status === 'ditolak')
                                <span class="badge bg-danger">Dibatalkan</span>
                            @else
                                <span class="badge bg-secondary">Unknown</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <td>{{ number_format($detail_pembelian->sum('subtotal'), 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
