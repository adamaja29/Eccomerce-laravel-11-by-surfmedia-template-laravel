@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="tf-section-2 mb-30">
            <div class="flex gap20 flex-wrap-mobile">
                <!-- Left Column -->
                <div class="w-half">
                    <!-- Total Orders -->
                    <div class="wg-chart-default mb-20">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-shopping-bag"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">Total Pesanan</div>
                                    <h4>{{$totalOrders}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Amount -->
                    <div class="wg-chart-default mb-20">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-dollar-sign"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">Total Pemasukan</div>
                                    <h4>Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Orders -->
                    <div class="wg-chart-default mb-20">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-shopping-bag"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">Success Orders</div>
                                    <h4>{{$totalSuccess}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Orders Amount -->
                    <div class="wg-chart-default">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-dollar-sign"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">Canceled Orders</div>
                                    <h4>{{$totalCanceled}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="w-half">
                    <!-- Delivered Orders -->
                    <div class="wg-chart-default mb-20">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-shopping-bag"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">Total Pembelian</div>
                                    <h4>{{$totalPembelian}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delivered Orders Amount -->
                    <div class="wg-chart-default mb-20">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-dollar-sign"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">Total Pengeluaran</div>
                                    <h4>Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Canceled Orders -->
                    <div class="wg-chart-default mb-20">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-shopping-bag"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">Suppliers</div>
                                    <h4>{{$totalSuppliers}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Canceled Orders Amount -->
                    <div class="wg-chart-default">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-dollar-sign"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">Total Produk</div>
                                    <h4>{{$totalProduk}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings Revenue -->
            <div class="wg-box">
                <div class="flex items-center justify-between">
                    <h5>Earnings revenue</h5>
                    <div class="dropdown default">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="icon-more"><i class="icon-more-horizontal"></i></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a href="javascript:void(0);">This Week</a></li>
                            <li><a href="javascript:void(0);">Last Week</a></li>
                        </ul>
                    </div>
                </div>
                <div class="flex flex-wrap gap40">
                    <div>
                        <div class="mb-2">
                            <div class="block-legend">
                                <div class="dot t1"></div>
                                <div class="text-tiny">Revenue</div>
                            </div>
                        </div>
                        <div class="flex items-center gap10">
                            <h4>Rp {{ number_format($revenue, 0, ',', '.') }}</h4>
                            <div class="box-icon-trending up">
                                <i class="icon-trending-up"></i>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="mb-2">
                            <div class="block-legend">
                                <div class="dot t2"></div>
                                <div class="text-tiny">Order</div>
                            </div>
                        </div>
                        <div class="flex items-center gap10">
                            <h4>Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h4>
                            <div class="box-icon-trending up">
                                <i class="icon-trending-up"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="line-chart-8"></div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="tf-section mb-30">
            <div class="wg-box">
                <div class="flex items-center justify-between">
                    <h5>Recent orders</h5>
                    <div class="dropdown default">
                        <a class="btn btn-secondary dropdown-toggle" href="{{route('admin.validasi.pesanan')}}">
                            <span class="view-all">View all</span>
                        </a>
                    </div>
                </div>
                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 80px">OrderNo</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Phone</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Order Date</th>
                                    <th class="text-center">Total Items</th>
                                    <th class="text-center">Delivered On</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                <tr>
                                    <td class="text-center">{{ 'ORD-' . $order->created_at->format('Ymd') . $order->id }}</td>
                                    <td class="text-center">{{ $order->alamat->nama_penerima }}</td>
                                    <td class="text-center">{{ $order->alamat->phone }}</td>
                                    <td class="text-center">${{ number_format($order->total, 2) }}</td>
                                    <td class="text-center">{{ ucfirst($order->status) }}</td>
                                    <td class="text-center">{{ $order->created_at }}</td>
                                    <td class="text-center">{{ $order->total_items }}</td>
                                    <td>{{$order->updated_at}}</td>
                                    <td class="text-center">
                                        <a href="#">
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
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="bottom-page">
        <div class="body-text">Copyright © 2025 Dams Store</div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    var chartDataTotal = @json($dataTotal);

    (function ($) {
        var tfLineChart = (function () {
            var chartBar = function () {
                var options = {
                    series: [{
                        name: 'Total',
                        data: chartDataTotal
                    }],
                    chart: {
                        type: 'bar',
                        height: 325,
                        toolbar: { show: false },
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '10px',
                            endingShape: 'rounded'
                        }
                    },
                    xaxis: {
                        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                                     'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                    },
                    colors: ['#2377FC'],
                    tooltip: {
                        y: {
                            formatter: function (val) {
                                return "$ " + val;
                            }
                        }
                    }
                };

                var chart = new ApexCharts(document.querySelector("#line-chart-8"), options);
                chart.render();
            };

            return {
                load: function () {
                    chartBar();
                }
            };
        })();

        $(window).on("load", function () {
            tfLineChart.load();
        });
    })(jQuery);
</script>

@endpush
