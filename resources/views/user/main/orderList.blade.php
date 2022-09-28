@extends('user.layouts.master')

@section('title', 'MyPizza | Order List')

@section('totalCart', count($carts))
@section('totalOrder', count($orders))

@section('content')

<!-- Order Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-8 offset-2 table-responsive mb-5">
            @if (count($orders) > 0)
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Date</th>
                            <th>Order Code</th>
                            <th>Total Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="cart-data" class="align-middle">
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->created_at->format('d-M-Y') }}</td>
                                <td>{{ $order->order_code }}</td>
                                <td>{{ $order->total_price }} MMK</td>
                                <td>
                                    @if($order->status == 0)
                                        <span class="text-warning">
                                            <i class="fa-solid fa-clock me-1"></i>
                                            Pending
                                        </span>
                                    @elseif ($order->status == 1)
                                        <span class="text-success">
                                            <i class="fa-solid fa-circle-check me-1"></i>
                                            Success
                                        </span>
                                    @elseif ($order->status == 2)
                                        <span class="text-danger">
                                            <i class="fa-solid fa-circle-xmark"></i>
                                            Reject
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-3">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="alert alert-secondary text-center fs-4">
                    There is no order !
                </div>
            @endif
        </div>
    </div>
</div>
<!-- Order End -->
@endsection

@section('scriptCode')
<script>

</script>
@endsection
