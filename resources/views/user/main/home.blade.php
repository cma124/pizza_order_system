@extends('user.layouts.master')

@section('title', 'MyPizza | Home')

@section('home-active', 'active')

@section('totalCart', count($carts))
@section('totalOrder', count($orders))

@section('content')
<div class="container-fluid">
    <div class="row px-xl-5">

        <!-- Shop Sidebar Start -->
        <div class="col-lg-3 col-md-4">

            <!-- Category Filter Start -->
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by category</span></h5>
            <div class="bg-light p-4 mb-30">
                <form>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3 ps-0">
                        <a href="{{ route('user#home') }}" class="m-0 text-dark">All Categories</a>
                        <span class="badge-lg px-1 border text-dark">{{ count($totalProducts) }}</span>
                    </div>

                    @foreach($categories as $category)
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3 ps-0">
                            <a href="{{ route('products#filter', $category->id) }}" class="m-0 text-dark">{{ $category->name }}</a>

                            <span class="badge-lg px-1 border text-dark">
                                @foreach ($categoriesCount as $categoryCount)
                                    @if ($categoryCount->category_id == $category->id)
                                        {{ $categoryCount->count }}
                                    @endif
                                @endforeach
                            </span>
                        </div>
                    @endforeach
                </form>
            </div>
            <!-- Category Filter End -->

            <div>
                <a href="{{ route('order#list') }}" class="btn btn btn-warning w-100">Order</a>
            </div>
            <!-- Size End -->
        </div>
        <!-- Shop Sidebar End -->

        <!-- Shop Product Start -->
        <div class="col-lg-9 col-md-8">
            <div class="row">
                <div class="col-12 pb-1">
                    <div class="text-end">
                        <div class="me-4">
                            <div class="btn-group">
                                <select name="sortingType" id="sortingOption" class="form-control">
                                    <option value="">Sorting</option>
                                    <option value="asc">Ascending</option>
                                    <option value="desc">Descending</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                @if (count($products) > 0)
                <div class="row" id="sortedContent">
                    @foreach($products as $product)
                      <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                          <div class="product-item bg-light mb-4">
                              <div class="product-img position-relative overflow-hidden shadow-sm">
                                  <img class="img-fluid w-100" src="{{ asset('storage/products/' . $product->image) }}" style="height: 200px;">
                                  <div class="product-action">
                                      <a class="btn btn-outline-dark btn-square" href="{{ route('products#detail', $product->id) }}"><i class="fa-solid fa-circle-info"></i></a>
                                  </div>
                              </div>
                              <div class="text-center py-3">
                                  <a class="h6 text-decoration-none text-truncate" href="{{ route('products#detail', $product->id) }}">
                                    {{ $product->name }}
                                  </a>

                                  <h5 class="mt-2">{{ $product->price }} MMK</h5>
                              </div>
                          </div>
                      </div>
                    @endforeach
                </div>
                @else
                    <div class="alert alert-secondary text-center fs-4">
                        There is no pizza !
                    </div>
                @endif

            </div>
        </div>
        <!-- Shop Product End -->
    </div>
</div>
@endsection

@section('scriptCode')
<script>
    $(document).ready(function() {
        $('#sortingOption').change(function() {
            sortingOption = $('#sortingOption').val();

            if(sortingOption == 'asc') {
                requestData = {'sorting' : 'asc'};
            } else if(sortingOption == 'desc') {
                requestData = {'sorting' : 'desc'};
            }

            $.ajax({
                type: 'GET',
                url: '/user/products/ajax',
                data: requestData,
                dataType: 'json',
                success: function(responses) {
                    content = '';
                    responses.forEach(response => {
                        content += `
                        <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                            <div class="product-item bg-light mb-4">
                                <div class="product-img position-relative overflow-hidden shadow-sm">
                                <img class="img-fluid w-100" src="{{ asset('storage/products/${response.image}') }}" style="height: 200px;">
                                    <div class="product-action">
                                        <a class="btn btn-outline-dark btn-square"><i class="fa-solid fa-shopping-cart"></i></a>
                                        <a class="btn btn-outline-dark btn-square" href="{{ url('user/products/detail/${response.id}') }}"><i class="fa-solid fa-circle-info"></i></a>
                                    </div>
                                </div>
                                <div class="text-center py-3">
                                    <a class="h6 text-decoration-none text-truncate" href="{{ url('user/products/detail/${response.id}') }}">
                                        ${response.name}
                                    </a>

                                    <h5 class="mt-2">${response.price} MMK</h5>
                                </div>
                            </div>
                        </div>
                        `;
                        $('#sortedContent').html(content);
                    });
                }
            });
        });
    });
</script>
@endsection
