@extends('admin.layouts.master')

@section('title', 'Order List')

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
                                Order List
                                (
                                <i class="fa-solid fa-list-check"></i>
                                <span class="fw-bold ms-1">
                                    {{ count($orders) }}
                                </span>
                                )
                            </h2>
                        </div>
                    </div>

                    <div class="table-data__tool-right">
                        <form action="{{ route('adminOrder#list') }}" method="GET" class="d-flex justify-content-end">
                            @csrf
                            <input type="search" name="searchKey" class="form-control py-2 w-75" value="{{ request('searchKey') }}" placeholder="Search ...">
                            <button type="submit" class="btn btn-secondary">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="w-25 d-flex align-items-center">
                    <select id="filterOption" class="form-control w-50">
                        <option value="">All</option>
                        <option value="0">Pending</option>
                        <option value="1">Accept</option>
                        <option value="2">Reject</option>
                    </select>
                </div>

                @if(count($orders) != 0)
                    <div class="table-responsive table-responsive-data2 mt-2">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>User Name</th>
                                    <th>Order Code</th>
                                    <th>Date</th>
                                    <th>Total Price (MMK)</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody id="data-table">
                                @foreach($orders as $order)
                                    <tr class="tr-shadow">
                                        <input type="hidden" class="orderId" value="{{ $order->id }}">
                                        <td class="col-1">{{ $order->user_id }}</td>
                                        <td class="col-2">{{ $order->user_name }}</td>
                                        <td class="col-3">
                                            <a href="{{ route('adminOrder#detail', $order->order_code) }}" class="text-decoration-underline orderCode">
                                                {{ $order->order_code }}
                                            </a>
                                        </td>
                                        <td class="col-2">{{ $order->created_at->format('d/M/Y') }}</td>
                                        <td class="col-2">{{ $order->total_price }}</td>
                                        <td class="col-2">
                                            <div class="table-data-feature">
                                                <select class="statusOption me-2">
                                                    <option value="0" @if($order->status == 0) selected @endif>Pending</option>
                                                    <option value="1" @if($order->status == 1) selected @endif>Accept</option>
                                                    <option value="2" @if($order->status == 2) selected @endif>Reject</option>
                                                </select>

                                                <button class="item deleteBtn" data-toggle="tooltip" data-placement="top" title="Delete">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="spacer"></tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- END DATA TABLE -->
                @else
                    <h3 class="text-secondary text-center mt-5">There is no order !</h3>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scriptCode')
<script>
    $(document).ready(function() {
        $('#filterOption').change(function() {
            filterOption = $('#filterOption').val();

            $.ajax({
                type: 'GET',
                url: '/order/list/filter',
                data: { 'filterOption': filterOption },
                dataType: 'json',
                success: function(responses) {
                    months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                    filterData = '';

                    responses.forEach(response => {
                        // JavaScript Date
                        responseDate = new Date(response.created_at);
                        formatDate = `${responseDate.getDate()}/${months[responseDate.getMonth()]}/${responseDate.getFullYear()}`;

                        // Pending/Accept/Reject
                        pended = '';
                        accepted = '';
                        rejected = '';
                        if(response.status == 0) {
                            pended = 'selected';
                        } else if(response.status == 1) {
                            accepted = 'selected';
                        } else if(response.status == 2) {
                            rejected = 'selected';
                        }

                        filterData += `
                            <tr class="tr-shadow">
                                <input type="hidden" class="orderId" value="${response.id}">
                                <td class="col-1"> ${response.user_id} </td>
                                <td class="col-2"> ${response.user_name} </td>
                                <td class="col-3">
                                    <a href="{{url('order/detail/${response.order_code}')}}" class="text-decoration-underline orderCode">
                                        ${response.order_code}
                                    </a>
                                </td>
                                <td class="col-2"> ${formatDate} </td>
                                <td class="col-2"> ${response.total_price} </td>
                                <td class="col-2">
                                    <div class="table-data-feature">
                                        <select class="statusOption me-2">
                                            <option value="0" ${pended}>Pending</option>
                                            <option value="1" ${accepted}>Accept</option>
                                            <option value="2" ${rejected}>Reject</option>
                                        </select>

                                        <button class="item deleteBtn" data-toggle="tooltip" data-placement="top" title="Delete">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr class="spacer"></tr>
                        `;
                    });
                    $('#data-table').html(filterData);

                    $('.statusOption').change(function() {
                        parent = $(this).parents('tr');
                        orderId = parent.find('.orderId').val();
                        orderStatus = $(this).val();

                        $.ajax({
                            type: 'GET',
                            url: '/order/update',
                            data: {
                                'orderId': orderId,
                                'orderStatus': orderStatus
                            },
                            dataType: 'json'
                        });
                    });

                    $('.deleteBtn').click(function() {
                        parent = $(this).parents('tr');
                        orderId = parent.find('.orderId').val();
                        orderCode = parent.find('.orderCode').text();

                        $.ajax({
                            type: 'GET',
                            url: '/order/delete',
                            data: {
                                'orderId' : orderId,
                                'orderCode' : orderCode
                            },
                            dataType: 'json',
                            success: function(response) {
                                location.reload();
                            }
                        });
                    });
                }
            });
        });

        $('.statusOption').change(function() {
            parent = $(this).parents('tr');
            orderId = parent.find('.orderId').val();
            orderStatus = $(this).val();

            $.ajax({
                type: 'GET',
                url: '/order/update',
                data: {
                    'orderId': orderId,
                    'orderStatus': orderStatus
                },
                dataType: 'json'
            });
        });

        $('.deleteBtn').click(function() {
            parent = $(this).parents('tr');
            orderId = parent.find('.orderId').val();
            orderCode = parent.find('.orderCode').text();

            $.ajax({
                type: 'GET',
                url: '/order/delete',
                data: {
                    'orderId' : orderId,
                    'orderCode' : orderCode
                },
                dataType: 'json',
                success: function(response) {
                    location.reload();
                }
            });
        });
    });
</script>
@endsection
