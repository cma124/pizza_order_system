@extends('user.layouts.master')

@section('title', 'MyPizza | Details')

@section('totalCart', count($carts))
@section('totalOrder', count($orders))

@section('content')
<!-- Shop Detail Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-5 mb-30">
            <div>
                <img src="{{ asset('storage/products/' . $product->image) }}" class="w-100 h-100">
            </div>
        </div>

        <div class="col-lg-7 h-auto mb-30">
            <div class="h-100 bg-light p-30">
                <div class="d-flex align-items-center mb-3">
                    <h3 class="m-0">{{ $product->name }}</h3>
                    <small class="pt-1 ms-2">(<i class="fa-solid fa-eye"></i> {{ $product->view_count }})</small>
                </div>
                <h3 class="font-weight-semi-bold mb-4">{{ $product->price }} MMK</h3>
                <p class="mb-4">{{ $product->description }}</p>
                <div class="d-flex align-items-center mb-4 pt-2">
                    <div class="input-group quantity mr-3" style="width: 130px;">
                        <div class="input-group-btn">
                            <button class="btn btn-primary btn-minus">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <input type="text" class="form-control bg-secondary border-0 text-center" id="productCount" value="1">
                        <div class="input-group-btn">
                            <button class="btn btn-primary btn-plus">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <button id="addCartBtn" class="btn btn-primary px-3"><i class="fa fa-shopping-cart mr-1"></i> Add To
                        Cart</button>
                </div>
                <div class="d-flex pt-2">
                    <strong class="text-dark mr-2">Share on:</strong>
                    <div class="d-inline-flex">
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-pinterest"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Shop Detail End -->

<input type="hidden" id="userId" value="{{ Auth::user()->id }}">
<input type="hidden" id="productId" value="{{ $product->id }}">

<!-- Products Start -->
<div class="container-fluid py-2">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">You May Also Like</span></h2>
    <div class="row px-xl-5">
        <div class="col">
            <div class="owl-carousel related-carousel">
                @foreach ($otherProducts as $otherProduct)
                    <div class="product-item bg-light">
                        <div class="product-img position-relative overflow-hidden">
                            <img src="{{ asset('storage/products/' . $otherProduct->image) }}" class="img-fluid w-100" style="height: 190px;">
                            <div class="product-action">
                                <a href="{{ route('products#detail', $otherProduct->id) }}" class="btn btn-outline-dark btn-square"><i class="fa-solid fa-circle-info"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-1">
                            <a href="{{ route('products#detail', $otherProduct->id) }}" class="h6 text-decoration-none text-truncate">{{ $otherProduct->name }}</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>{{ $otherProduct->price }} MMK</h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- Products End -->
@endsection

@section('scriptCode')
<script>
    $(document).ready(function() {
        // Add View Count
        $.ajax({
            type: 'GET',
            url: '/user/products/view/add',
            data: { 'productId' : $('#productId').val() },
            dataType: 'json',
        });

        // Add to Cart
        $('#addCartBtn').click(function() {
            cartData = {
                'userId' : $('#userId').val(),
                'productId' : $('#productId').val(),
                'productCount' : $('#productCount').val(),
            };

            $.ajax({
                type: 'GET',
                url: '/user/cart/add',
                data: cartData,
                dataType: 'json',
                success: function(response) {
                    if(response.status == 'success') {
                        window.location.href = '/user/products/home';
                    }
                }
            });
        });
    });
</script>
@endsection
