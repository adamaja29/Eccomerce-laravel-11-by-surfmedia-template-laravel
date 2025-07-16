@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Laporan Pembelian</h3>
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
                    <div class="text-tiny">Laporan Pembelian</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="wg-table table-all-user mt-4">
                <div class="table-responsive">
                    @if(session('success'))
                        <p class="alert alert-success">{{ session('success') }}</p>
                    @endif
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>No Bukti</th>
                                <th>Jenis</th>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                                <th>Kode</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach($mutasi as $m)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $m['no_bukti'] }}</td>
                                <td >
                                    @if($m['jenis'] === 'pesanan')
                                        Pesanan
                                    @elseif($m['jenis'] === 'pembelian')
                                        Pembelian
                                    @else
                                        {{ $m['jenis'] }}
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($m['tanggal'])->format('d-m-Y') }}</td>
                                <td>{{ $m['jumlah'] }}</td>
                                <td>{{ number_format($m['total'], 0, ',', '.') }}</td>
                                <td class="text-center">
                                    @if(strpos($m['keterangan'], 'Supplier') !== false)
                                    <span class="badge bg-danger">K</span>
                                    @elseif(strpos($m['keterangan'], 'User') !== false)
                                    <span class="badge bg-success">M</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($m['jenis'] === 'pesanan')
                                        <a href="{{ route('admin.pesanan.show', ['id' => $m['id']]) }}">
                                    @elseif($m['jenis'] === 'pembelian')
                                        <a href="{{ route('admin.pembelian.detail', ['id' => $m['id']]) }}">
                                    @else
                                        <a href="#">
                                    @endif
                                        <div class="list-icon-function view-icon">
                                            <div class="item eye">
                                                <i class="icon-eye"></i>
                                            </div>
                                        </div>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>Saldo Awal</td>
                                <td>{{ number_format($saldoAwal, 0, ',', '.') }}</td>
                                <td></td>
                                <td>Laba</td>
                                <td>{{ number_format($labaAsli, 0, ',', '.') }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Total Laba</td>
                                <td>{{ number_format($laba, 0, ',', '.') }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="divider"></div>
            </div>
        </div>
    </div>
</div>
@endsection
