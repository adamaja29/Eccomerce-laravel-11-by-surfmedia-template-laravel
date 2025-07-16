@extends('layouts.app')
@section('content')
<main class="pt-90" style="padding-top: 0px;">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
        <h2 class="page-title">Orders</h2>
        <div class="row">
        <div class="col-lg-2">
            @include('user.nav_account')
        </div>

            <div class="col-lg-10">
                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>OrderNo</th>
                                <th>Name</th>
                                <th class="text-center">Phone</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Order Date</th>
                                <th class="text-center">Items</th>
                                <th class="text-center">Delivered On</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($order->created_at)->format('Ymd') . $order->id }}</td>
                                    <td class="text-center">{{ $order->name }}</td>
                                    <td class="text-center">{{ $order->phone }}</td>
                                    <td class="text-center">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        @if($order->status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($order->status == 'completed')
                                            <span class="badge bg-success">Completed</span>
                                        @elseif($order->status == 'canceled')
                                            <span class="badge bg-danger">Canceled</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($order->created_at)->format('Y-m-d') }}</td>
                                    <td class="text-center">{{ $order->items_count }}</td>
                                    <td class="text-center">
                                        @if($order->status == 'pending')
                                            -
                                        @else
                                            {{ $order->delivered_on ? \Carbon\Carbon::parse($order->delivered_on)->format('Y-m-d') : '-' }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0);" class="order-detail-btn" data-order-id="{{ $order->id }}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        </table>                
                    </div>
                </div>
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">                
                    
                </div>
            </div>
            
        </div>
    </section>
</main>

<!-- Order Details Modal -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="orderDetailsModalLabel">Order Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered" id="orderDetailsTable">
          <thead>
            <tr>
              <th>Product Image</th>
              <th>Product Name</th>
              <th>Quantity</th>
              <th>Unit Price</th>
              <th>Total Price</th>
            </tr>
          </thead>
          <tbody>
            <!-- Order details will be populated here -->
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const orderDetailButtons = document.querySelectorAll('.order-detail-btn');
    const orderDetailsModal = new bootstrap.Modal(document.getElementById('orderDetailsModal'));
    const orderDetailsTableBody = document.querySelector('#orderDetailsTable tbody');

    orderDetailButtons.forEach(button => {
        button.addEventListener('click', function () {
            const orderId = this.getAttribute('data-order-id');
            fetch(`/api/order-details/${orderId}`)
                .then(response => response.json())
                .then(data => {
                    orderDetailsTableBody.innerHTML = '';
                    if (data.length === 0) {
                        orderDetailsTableBody.innerHTML = '<tr><td colspan="5" class="text-center">No details found.</td></tr>';
                    } else {
                        data.forEach(item => {
                            const row = document.createElement('tr');
                            const imageUrl = item.image ? `/uploads/produk/${item.image}` : '/assets/images/default.png';
                            row.innerHTML = `
                                <td><img src="${imageUrl}" alt="${item.nama}" style="width: 60px; height: auto;"></td>
                                <td>${item.nama}</td>
                                <td>${item.jumlah}</td>
                                <td>Rp ${item.harga_satuan.toLocaleString('id-ID')}</td>
                                <td>Rp ${item.total_price.toLocaleString('id-ID')}</td>
                            `;
                            orderDetailsTableBody.appendChild(row);
                        });
                    }
                    orderDetailsModal.show();
                })
                .catch(error => {
                    console.error('Error fetching order details:', error);
                    orderDetailsTableBody.innerHTML = '<tr><td colspan="5" class="text-center text-danger">Failed to load order details.</td></tr>';
                    orderDetailsModal.show();
                });
        });
    });
});
</script>
@endsection
