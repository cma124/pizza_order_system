<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderList;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Direct Order List Page
    public function list() {
        $orders = Order::when(request('searchKey'), function($query) {
            $query->where('order_code', request('searchKey'));
        })
        ->select('orders.*', 'users.name as user_name')
        ->leftJoin('users', 'orders.user_id', 'users.id')
        ->get();

        return view('admin.order.list', compact('orders'));
    }

    // Filter
    public function filter(Request $request) {
        $orders = Order::select('orders.*', 'users.name as user_name')
            ->leftJoin('users', 'orders.user_id', 'users.id');

        if($request->filterOption == '') {
            $orders = $orders->get();
        } else {
            $orders = $orders->where('orders.status', $request->filterOption)->get();
        }

        return response()->json($orders, 200);
    }

    // Update
    public function update(Request $request) {
        $orders = Order::find($request->orderId)->update([
            'status' => $request->orderStatus
        ]);

        return response()->json(['status' => 'OK'], 200);
    }

    // Detail Order
    public function detail($code) {
        $order = Order::where('order_code', $code)->first();
        $orderLists = OrderList::select('order_lists.*', 'users.name as user_name', 'products.image as product_image', 'products.name as product_name')
            ->leftJoin('users', 'users.id', 'order_lists.user_id')
            ->leftJoin('products', 'products.id', 'order_lists.product_id')
            ->where('order_code', $code)
            ->get();
        return view('admin.order.detail', compact('orderLists', 'order'));
    }

    // Delete Order
    public function delete(Request $request) {
        Order::find($request->orderId)->delete();
        OrderList::where('order_code', $request->orderCode)->delete();
        return response()->json(200);
    }
}
