@extends('layouts.app')

@section('content')
<main class="pt-90">
  <div class="mb-4 pb-4"></div>
  <section class="shop-checkout container">
    <h2 class="page-title">Cart</h2>
    <div class="checkout-steps">
    <a href="{{route('shop.cart')}}" class="checkout-steps__item active">
      <span class="checkout-steps__item-number">01</span>
      <span class="checkout-steps__item-title">
      <span>Shopping Bag</span>
      <em>Manage Your Items List</em>
      </span>
    </a>
    </div>
    <div class="shopping-cart">
    @if($cartitems->count()>0) 
    <div class="cart-table__wrapper">
      <table class="cart-table">
      <thead>
        <tr>
        <th>Product</th>
        <th></th>
        <th></th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Subtotal</th>
        <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($cartitems as $item)
        <tr>
        <td>
          <input type="checkbox" name="selected_products[]" value="{{ $item->id }}" class="select-product">
        </td>
        <td>
          <div class="shopping-cart__product-item">
          <img loading="lazy" src="{{asset('uploads/produk')}}/{{$item->foto}}" width="120" height="120" alt="" />
          </div>
        </td>
        <td>
          <div class="shopping-cart__product-item__detail">
          <h4>{{$item->nama}}</h4>
          <ul class="shopping-cart__product-item__options">
            <li>Size: L</li>
          </ul>
          </div>
        </td>
        <td>
          <span class="shopping-cart__product-price">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
        </td>
        <td>
          <div class="qty-control position-relative">
          <form method="POST" action="{{ route('cart.decrease', $item->id) }}">
            @csrf
            @method('PUT')
            <div class="qty-control__reduce">−</div>
          </form>
        
          <input type="number" class="qty-control__number text-center" value="{{ $item->quantity }}" disabled style="width: 60px;">
        
          <form method="POST" action="{{ route('cart.increase', $item->id) }}">
            @csrf
            @method('PUT')
            <div class="qty-control__increase">+</div>
          </form>
          </div>
        </td>
        <td>
          <span class="shopping-cart__subtotal">{{$item->quantity * $item->harga}}</span>
        </td>
        </tr>
        @endforeach
      </tbody>
      </table> 
    </div>

    <div class="shopping-cart__totals-wrapper">
      <div class="sticky-content">
      <div class="shopping-cart__totals">
        <h3>Cart Totals</h3>
        <table class="cart-totals">
        <tbody>
          <tr>
          <td>
            Total Produk
          </td>
          <td>
            <span id="selected-quantity">0</span>
          </td>
          </tr>
          <tr>
          <th>Subtotal</th>
          <td>Rp <span id="selected-total">0</span></td>
          </tr>
          <tr>
          <th>Delivery Fee</th>
          <td>-</td>
          </tr>
          <tr>
          <th>Total</th>
          <td></td>
          </tr>
        </tbody>
        </table>
      </div>
      <form id="checkout-form"  action="{{ route('checkout.prepare') }}" method="POST">
        @csrf
        <input type="hidden" name="selected_products" id="selected-products">
        <div class="mobile_fixed-btn_wrapper">
          <div class="button-wrapper container">
        <button type="button" class="btn btn-primary" id="proceed-checkout">
          PROCEED TO CHECKOUT
        </button>
          </div>
        </div>
      </form>
    </div>
    @else
    <div class="row">
      <div class="col-md-12 text-center pt bp-5">
      <p>No Item Found</p>
      <a href="{{route('shop.index')}}" class="btn btn-primary">Continue Shopping</a>
      </div>
    </div>
    @endif
    </div>
  </section>
  </main>

  <!-- Modal -->
  <div class="modal fade" id="noProductModal" tabindex="-1" aria-labelledby="noProductModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="noProductModalLabel">No Products Selected</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
      Please select at least one product before proceeding to checkout.
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    </div>
    </div>
  </div>
  </div>
@endsection

@push('scripts')
<script>
  $(function () {
    $(".qty-control__reduce").on("click", function () {
      $(this).closest('form').submit();
    });

    $(".qty-control__increase").on("click", function () {
      $(this).closest('form').submit();
    });

    function updateCartSummary() {
      let total = 0;
      let quantity = 0;
      $(".select-product:checked").each(function () {
        const row = $(this).closest("tr");
        const subtotal = parseFloat(row.find(".shopping-cart__subtotal").text());
        const qtyInput = row.find(".qty-control__number");
        const qty = parseInt(qtyInput.val());
        total += subtotal;
        quantity += qty;
      });
      $("#selected-total").text(total.toFixed(2));
      $("#selected-quantity").text(quantity);
    }

    $(".select-product").on("change", updateCartSummary);

    $("#proceed-checkout").on("click", function () {
      let selected = [];
      $(".select-product:checked").each(function () {
        selected.push($(this).val());
      });

      if (selected.length === 0) {
        $("#noProductModal").modal('show');
      } else {
        // Masukkan produk terpilih ke hidden input
        $("#selected-products").val(JSON.stringify(selected));
        // Submit form
        $("#checkout-form").submit();
      }
    });
  });
</script>
@endpush
