<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    // Get Products
    public function getProducts(Request $request) {
        $products = Product::orderBy('created_at', $request->sorting)->get();
        return response()->json($products, 200);
    }

    // Add to Cart
    public function addCart(Request $request) {
        Cart::create([
            'user_id' => $request->userId,
            'product_id' => $request->productId,
            'quantity' => $request->productCount,
        ]);

        $data = [
            'status' => 'success',
            'message' => 'Add to cart successfully.'
        ];
        return response()->json($data, 200);
    }

    // Add to OrderList
    public function addOrderList(Request $request) {
        $totalPrice = 0;
        foreach ($request->all() as $item) {
            $orderList = OrderList::create([
                'user_id' => $item['userId'],
                'product_id' => $item['productId'],
                'quantity' => $item['quantity'],
                'total' => $item['total'],
                'order_code' => $item['orderCode']
            ]);

            $totalPrice += $orderList->total;
        }

        Cart::where('user_id', Auth::user()->id)->delete();
        Order::create([
            'user_id' => $orderList->user_id,
            'order_code' => $orderList->order_code,
            'total_price' => $totalPrice
        ]);

        return response()->json(['status' => 'success'], 200);
    }

    // Clear All Cart
    public function clearCart() {
        Cart::where('user_id', Auth::user()->id)->delete();
    }

    // Clear Cart Item
    public function clearItem(Request $request) {
        Cart::find($request->cartId)->delete();
    }

    // Add View Count
    public function addViewCount(Request $request) {
        $product = Product::find($request->productId);
        $product->update([
            'view_count' => $product->view_count + 1
        ]);
    }
}
