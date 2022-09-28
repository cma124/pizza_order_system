@extends('admin.layouts.master')

@section('title', 'Order Detail')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="row col-7">
                    <div class="card pt-1 mt-2">
                        <div class="card-header bg-white">
                            <h3>
                                <i class="fa-solid fa-clipboard me-2"></i>
                                Order Info
                            </h3>
                        </div>

                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col"><i class="fa-solid fa-user me-1"></i> Customer Name</div>
                                <div class="col">{{$orderLists[0]->user_name}}</div>
                            </div>

                            <div class="row mb-2">
                                <div class="col"><i class="fa-solid fa-barcode me-1"></i> Order Code</div>
                                <div class="col">{{$orderLists[0]->order_code}}</div>
                            </div>

                            <div class="row mb-2">
                                <div class="col"><i class="fa-solid fa-calendar me-1"></i> Order Date</div>
                                <div class="col">{{$orderLists[0]->created_at->format('d/M/Y')}}</div>
                            </div>

                            <div class="row">
                                <div class="col"><i class="fa-solid fa-money-bill-wave me-1"></i>Total Price</div>
                                <div class="col">{{$order->total_price}} MMK</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive table-responsive-data2">
                    <table class="table table-data2 text-center">
                        <thead>
                            <tr>
                                <th></th>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Total Price (MMK)</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($orderLists as $orderList)
                                <tr class="tr-shadow">
                                    <td></td>
                                    <td>{{$orderList->id}}</td>
                                    <td class="col-2">
                                        <img src="{{asset('storage/products/' . $orderList->product_image)}}" class="img-thumbnail">
                                    </td>
                                    <td>{{$orderList->product_name}}</td>
                                    <td>{{$orderList->quantity}}</td>
                                    <td>{{$orderList->total}}</td>
                                </tr>

                                <tr class="spacer"></tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- END DATA TABLE -->
            </div>
        </div>
    </div>
</div>
@endsection
