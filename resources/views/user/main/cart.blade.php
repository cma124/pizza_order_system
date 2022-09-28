@extends('user.layouts.master')

@section('title', 'MyPizza | Cart')

@section('cart-active', 'active')

@section('totalCart', count($carts))
@section('totalOrder', count($orders))

@section('content')

<!-- Cart Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-8 table-responsive mb-5">
            @if (count($carts) > 0)
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody id="cart-data" class="align-middle">
                        @foreach ($carts as $cart)
                            <tr>
                                <td>
                                    <input type="hidden" id="cartId" value="{{ $cart->id }}">
                                    <input type="hidden" id="userId" value="{{ $cart->user_id }}">
                                    <input type="hidden" id="productId" value="{{ $cart->product_id }}">
                                    <img src="{{ asset('storage/products/' . $cart->image) }}" class="img-thumbnail" style="width: 80px; aspect-ratio: 5/4;">
                                </td>
                                <td class="align-middle">{{ $cart->name }}</td>
                                <td class="align-middle">
                                    <span id="pizzaPrice">{{ $cart->price }}</span>
                                    MMK
                                </td>
                                <td class="align-middle">
                                    <div class="input-group quantity mx-auto" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-minus" >
                                            <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" id="quantity" class="form-control form-control-sm bg-secondary border-0 text-center" value="{{ $cart->quantity }}">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-plus">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <span class="totalPrice">{{ $cart->price * $cart->quantity }}</span>
                                    MMK
                                </td>
                                <td class="align-middle"><button class="removeBtn btn btn-sm btn-danger"><i class="fa fa-times"></i></button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-secondary text-center fs-4">
                    There is no item in cart !
                </div>
            @endif
        </div>
        <div class="col-lg-4">
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart Summary</span></h5>
            <div class="bg-light p-30 mb-5">
                <div class="border-bottom pb-2">
                    <div class="d-flex justify-content-between mb-3">
                        <h6>Subtotal</h6>
                        <h6>
                            <span id="subtotal">{{ $totalPrice }}</span>
                            MMK
                        </h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6 class="font-weight-medium">Delivery</h6>
                        <h6 class="font-weight-medium">3000 MMK</h6>
                    </div>
                </div>
                <div class="pt-2">
                    <div class="d-flex justify-content-between mt-2">
                        <h5>Total</h5>
                        <h5>
                            <span id="total">{{ $totalPrice + 3000 }}</span>
                            MMK
                        </h5>
                    </div>
                    <button class="btn btn-block btn-primary font-weight-bold my-3 py-3" id="orderBtn">Proceed To Order</button>
                    <button class="btn btn-block btn-danger font-weight-bold my-3 py-3" id="clearBtn">Clear Cart</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cart End -->
@endsection

@section('scriptCode')
<script>
    $(document).ready(function() {
        $('.btn-plus').click(function() {
            parent = $(this).parents('tr');
            price = parent.find('#pizzaPrice').text();
            quantity = parent.find('#quantity').val();

            totalPrice = price * quantity;
            parent.find('.totalPrice').html(totalPrice);

            total = 0;
            $('#cart-data tr').each(function(index, row) {
                total += Number($(row).find('.totalPrice').text());
            });

            $('#subtotal').html(total);
            $('#total').html(total + 3000);
        });

        $('.btn-minus').click(function() {
            parent = $(this).parents('tr');
            price = parent.find('#pizzaPrice').text();
            quantity = parent.find('#quantity').val();

            totalPrice = price * quantity;
            parent.find('.totalPrice').html(totalPrice);

            total = 0;
            $('#cart-data tr').each(function(index, row) {
                total += Number($(row).find('.totalPrice').text());
            });

            $('#subtotal').html(total);
            $('#total').html(total + 3000);
        });

        $('#orderBtn').click(function() {
            orderList = [];
            random = Math.floor(Math.random() * 100000000001);

            $('#cart-data tr').each(function(index, row) {
                orderList.push({
                    'userId': $(row).find('#userId').val(),
                    'productId': $(row).find('#productId').val(),
                    'quantity': $(row).find('#quantity').val(),
                    'total': $(row).find('.totalPrice').text(),
                    'orderCode': 'MP-' + random
                });
            });
            orderList = Object.assign({}, orderList);

            $.ajax({
                type: 'GET',
                url: '/user/order/ajax',
                data: orderList,
                dataType: 'json',
                success: function(response) {
                    if(response.status == 'success') {
                        window.location.href = '/user/products/home';
                    }
                }
            });
        });

        // Clear Single Cart
        $('.removeBtn').click(function() {
            parent = $(this).parents('tr');
            cartId = parent.find('#cartId').val();

            $.ajax({
                type: 'GET',
                url: '/user/cart/clear/item',
                data: { 'cartId': cartId },
                dataType: 'json'
            });

            parent.remove();
            total = 0;
            $('#cart-data tr').each(function(index, row) {
                total += Number($(row).find('.totalPrice').text());
            });

            $('#subtotal').html(total);
            $('#total').html(total + 3000);
        });

        // Clear All Carts
        $('#clearBtn').click(function() {
            $('#cart-data tr').remove();
            $('#subtotal').html(0);
            $('#total').html(3000);

            $.ajax({
                type: 'GET',
                url: '/user/cart/clear',
                dataType: 'json'
            });
        });
    });
</script>
@endsection
