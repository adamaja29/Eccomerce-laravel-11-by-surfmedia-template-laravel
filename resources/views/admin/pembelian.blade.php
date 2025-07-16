@extends('layouts.admin')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Pembelian</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap5">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Pembelian</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <form class="form-search" method="GET" action="#">
                        <fieldset class="nama">
                            <input type="text" name="search" placeholder="Search supplier/invoice..." value="{{ request('search') }}" required>
                        </fieldset>
                        <div class="button-submit">
                            <button type="submit"><i class="icon-search"></i></button>
                        </div>
                    </form>
                </div>
                <a class="tf-button style-1 w208" href="{{ route('admin.pembelian.create') }}">
                    <i class="icon-plus"></i>Tambah Pembelian
                </a>
            </div>

            <div class="wg-table table-all-user mt-4">
                <div class="table-responsive">
                    @if(session('success'))
                        <p class="alert alert-success">{{ session('success') }}</p>
                    @endif

                    @if($pembelians->isEmpty())
                        <p class="text-muted">Tidak ada pembelian.</p>
                    @else
                        <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th >Nama Supplier</th>
                            <th>Nomor Invoice</th>
                            <th>Tanggal Pembelian</th>
                            <th>Jumlah Produk</th>
                            <th>Subtotal</th>
                            <th>Status</th>
                            <th>Detail</th>
                            <th>Diterima/cancel</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pembelians as $pembelian)
                        <tr>
                            <td>{{ $pembelian->id }}</td>
                            <td>{{ $pembelian->supplier->nama ?? '-' }}</td>
                            <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{$pembelian->nomor_invoice}}">{{ $pembelian->nomor_invoice }}</td>
                            <td>{{ \Carbon\Carbon::parse($pembelian->tanggal_pembelian)->format('d-m-Y') }}</td>
                            <td>{{ $pembelian->total_products ?? 0 }}</td>
                            <td>Rp {{ number_format($pembelian->total_price, 0, ',', '.') }}</td>
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
                            <td class="text-center">
                                <a href="{{route('admin.pembelian.detail', $pembelian->id)}}">
                                    <div class="list-icon-function view-icon">
                                        <div class="item eye">
                                            <i class="icon-eye"></i>
                                        </div>
                                    </div>
                                </a>
                            </td>
                            <td>
                                @if ($pembelian->status !== 'dipesan' && $pembelian->updated_at)
                                    {{ \Carbon\Carbon::parse($pembelian->updated_at)->format('d-m-Y H:i') }}
                                @else
                                    -
                                @endif
                            </td></td>
                            <td>
                                @if($pembelian->status === 'dipesan')
                                <form action="{{ route('admin.pembelian.approve', $pembelian->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menyetujui pembelian ini?')">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Diterima</button>
                                </form>
                                <form action="{{ route('admin.pembelian.cancel', $pembelian->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pembelian ini?')">
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
                @endif
            </div>

            <div class="divider"></div>
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                {{ $pembelians->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
    </div>
</div>
@endsection
