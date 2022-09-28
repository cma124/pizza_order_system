@extends('admin.layouts.master')

@section('title', 'Product Details')

@section('content')

<div class="main-content">
    <div class="section__content section__content--p30">
      <div class="container-fluid">
          <div class="col-lg-12">
              <div class="card">
                  <div class="card-body">
                        <div class="card-title">
                            <h3 class="text-center title-2">Product Details</h3>
                        </div>

                        <hr>

                        @if(session('updateSuccess'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-circle-check me-2"></i>
                                {{ session('updateSuccess') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-3 offset-1">
                                <img src="{{ asset('storage/products/' . $product->image) }}" class="shadow-sm" />
                            </div>

                            <div class="col-7">
                                <p class="text-dark fs-5 mb-3">
                                    <i class="fa-solid fa-pizza-slice me-1"></i>
                                    {{ $product->name }}
                                </p>

                                <span class="px-2 py-1 bg-dark text-white rounded fs-6 mb-2">
                                    <i class="fa-solid fa-list me-2"></i>
                                    {{ $product->category_name }}
                                </span>

                                <span class="ms-2 px-2 py-1 bg-dark text-white rounded fs-6 mb-2">
                                    <i class="fa-solid fa-money-bill-wave me-2"></i>
                                    {{ $product->price }}
                                    MMK
                                </span>

                                <span class="ms-2 px-2 py-1 bg-dark text-white rounded fs-6">
                                    <i class="fa-solid fa-eye me-2"></i>
                                    {{ $product->view_count }}
                                </span>

                                <br> <br>

                                <span class="px-2 py-1 bg-dark text-white rounded fs-6">
                                    <i class="fa-solid fa-calendar-days me-2"></i>
                                    {{ $product->updated_at->format('d-M-Y') }}
                                </span>

                                <p class="text-dark fs-6 mt-4 mb-2">
                                    <i class="fa-solid fa-file-lines me-2"></i>
                                    Description
                                </p>

                                <p class="text-dark">
                                    {{ $product->description }}
                                </p>
                            </div>
                        </div>

                        <a href="{{ route('product#updatePage', $product->id) }}" class="d-block btn btn-lg btn-dark mx-5 mt-4">
                            <i class="fa-solid fa-pen-to-square me-2"></i>
                            Edit Product
                        </a>
                  </div>
              </div>
          </div> 
      </div>
    </div>
</div>

@endsection