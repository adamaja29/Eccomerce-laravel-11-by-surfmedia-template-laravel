@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Pesanan</h2>

    {{-- Menampilkan pesan sukses jika ada --}}
    
        <div class="wg-box">
            <div class="wg-box-header">
                <h5 class="wg-box-title mb-0">Daftar Pesanan</h5>
            </div>
            <div class="wg-box-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Menampilkan pesan jika tidak ada pesanan --}}
                @if($orders->isEmpty())
                    <p>Tidak ada pesanan untuk divalidasi.</p>
                @else
                    <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No Pesanan</th>
                            <th>Nama Penerima</th>
                            <th>No HP Penerima</th>
                            <th>Total Item</th>
                            <th>Total</th>
                            <th>Tanggal Pesan</th>
                            <th>Status Pesanan</th>
                            <th>Deliver On</th>
                            <th>Detail</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>{{ 'ORD-' . $order->created_at->format('Ymd') . $order->id }}</td>
                            <td>{{ $order->alamat->nama_penerima ?? 'N/A' }}</td>
                            <td>{{ $order->alamat->phone ?? 'N/A' }}</td>
                            <td class="text-center">{{ $order->total_items ?? 0 }}</td>
                            <td>Rp {{ number_format($order->total ?? 0, 0, ',', '.') }}</td>
                            <td class="text-center">{{ $order->created_at->format('d-m-Y') }}</td>
                            <td class="text-center">
                                @if ($order->status === 'approve')
                                    <span class="badge bg-success">Approved</span>
                                @elseif ($order->status === 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif ($order->status === 'cancelled')
                                    <span class="badge bg-danger">Cancelled</span>
                                @else
                                    <span class="badge bg-secondary">Unknown</span>
                                @endif
                            </td>
                            <td>
                                @if($order->status !== 'pending' && $order->deliver_on)
                                    {{ \Carbon\Carbon::parse($order->deliver_on)->format('d-m-Y') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{route('admin.pesanan.show', $order->id)}}">
                                    <div class="list-icon-function view-icon">
                                        <div class="item eye">
                                            <i class="icon-eye"></i>
                                        </div>
                                    </div>
                                </a>
                            </td>
                            <td>
                                @if($order->status === 'pending')
                                <form action="{{ route('admin.validasi.pesanan.approve', $order->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menyetujui pesanan ini?')">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                </form>
                                <form action="{{ route('admin.validasi.pesanan.cancel', $order->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                                </form>
                                @else
                                <span class="text-muted">No actions available</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{-- Pagination --}}
            <div class="d-flex justify-content-center">
                {{ $orders->links() }}
            </div>
        </div>
    @endif
</div>
@endsection
