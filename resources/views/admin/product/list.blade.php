@extends('admin.layouts.master')

@section('title', 'Product List')

@section('content')

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-12">
                <!-- DATA TABLE -->
                <div class="table-data__tool">
                    <div class="table-data__tool-left">
                        <div class="overview-wrap">
                            <h2 class="title-1">
                                Product List
                                (
                                <i class="fa-solid fa-pizza-slice"></i>
                                <span class="fw-bold ms-1">
                                    {{ $products->total() }}
                                </span>
                                )
                            </h2>

                        </div>
                    </div>

                    <div class="table-data__tool-right">
                        <a href="{{ route('product#createPage') }}">
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                <i class="fa-solid fa-plus"></i>add product
                            </button>
                        </a>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-start">
                    <!-- Update/Delete Successful Message -->
                    <div>
                        @if(session('message'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-circle-check me-1"></i>
                                {{ session('message') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                    </div>

                    <form action="{{ route('product#list') }}" method="GET" class="d-flex justify-content-end">
                        @csrf
                        <input type="search" name="searchKey" class="form-control py-2 w-75" value="{{ request('searchKey') }}" placeholder="Search Product ...">
                        <button type="submit" class="btn btn-secondary">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>
                </div>

                @if(count($products) != 0)
                    <div class="table-responsive table-responsive-data2 mt-3">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th>image</th>
                                    <th>name</th>
                                    <th>category</th>
                                    <th>price</th>
                                    <th>views</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($products as $product)
                                    <tr class="tr-shadow">
                                        <td class="col-3">
                                            <img src="{{ asset('storage/products/' . $product->image) }}" class="img-thumbnail shadow-sm">
                                        </td>

                                        <td class="col-3">{{ $product->name }}</td>
                                        <td class="col-2">{{ $product->category_name }}</td>
                                        <td class="col-2">{{ $product->price }}</td>
                                        <td class="col-2">
                                            <i class="fa-solid fa-eye me-1"></i>
                                            {{ $product->view_count }}
                                        </td>

                                        <td class="col-2">
                                            <div class="table-data-feature">
                                                <a href="{{ route('product#detailPage', $product->id) }}" class="item" data-toggle="tooltip" data-placement="top" title="View">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>

                                                <a href="{{ route('product#updatePage', $product->id) }}" class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                    <i class="fa-solid fa-pen"></i>
                                                </a>

                                                <a href="{{ route('product#delete', $product->id) }}" class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="spacer"></tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $products->links() }}
                    </div>
                    <!-- END DATA TABLE -->
                @else
                    <h3 class="text-secondary text-center mt-5">There is no product !</h3>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
