<?php

namespace App\Http\Controllers\User;

use Storage;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // ------------------- Products ---------------------
    // Direct Home Page
    public function home() {
        $products = Product::orderBy('created_at', 'desc')->get();

        $categories = Category::orderBy('created_at', 'desc')->get();
        $categoriesCount = Product::select('category_id', DB::raw('COUNT(id) as count'))
            ->groupBy('category_id')
            ->orderBy('created_at', 'desc')
            ->get();
        $totalProducts = Product::all();

        $carts = Cart::where('user_id', Auth::user()->id)->get();
        $orders = Order::where('user_id', Auth::user()->id)->get();

        return view('user.main.home', compact('products', 'categories', 'totalProducts', 'categoriesCount', 'carts', 'orders'));
    }

    // Filter Products by Category
    public function filter($id) {
        $products = Product::where('category_id', $id)->orderBy('created_at', 'desc')->get();

        $categoriesCount = Product::select('category_id', DB::raw('COUNT(id) as count'))
            ->groupBy('category_id')
            ->orderBy('created_at', 'desc')
            ->get();
        $categories = Category::orderBy('created_at', 'desc')->get();
        $totalProducts = Product::all();

        $carts = Cart::where('user_id', Auth::user()->id)->get();
        $orders = Order::where('user_id', Auth::user()->id)->get();

        return view('user.main.home', compact('products', 'categories', 'totalProducts', 'categoriesCount', 'carts', 'orders'));
    }

    // Detail Product
    public function productDetail($id) {
        $product = Product::find($id);
        $otherProducts = Product::whereNot('id', $id)->orderBy('created_at', 'desc')->get();

        $carts = Cart::where('user_id', Auth::user()->id)->get();
        $orders = Order::where('user_id', Auth::user()->id)->get();

        return view('user.main.detail', compact('product', 'otherProducts', 'carts', 'orders'));
    }

    // --------------------- Carts ---------------------
    public function listCart() {
        $carts = Cart::select('carts.*', 'products.name','products.image' , 'products.price')
            ->leftJoin('products', 'products.id', 'carts.product_id')
            ->where('user_id', Auth::user()->id)
            ->orderBy('carts.created_at', 'desc')
            ->get();

        $totalPrice = 0;
        foreach ($carts as $cart) {
            $totalPrice += $cart->price * $cart->quantity;
        }

        $orders = Order::where('user_id', Auth::user()->id)->get();

        return view('user.main.cart', compact('carts', 'totalPrice', 'orders'));
    }

    // ----------------------- Order ---------------------
    public function listOrder() {
        $orders = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(5);
        $carts = Cart::where('user_id', Auth::user()->id)->get();
        return view('user.main.orderList', compact('orders', 'carts'));
    }

    // -------------------- Account & Password -----------------------
    // Direct Detail Page
    public function detail() {
        $carts = Cart::where('user_id', Auth::user()->id)->get();
        $orders = Order::where('user_id', Auth::user()->id)->get();

        return view('user.account.detail', compact('carts', 'orders'));
    }

    // Direct Update Page
    public function updatePage() {
        $carts = Cart::where('user_id', Auth::user()->id)->get();
        $orders = Order::where('user_id', Auth::user()->id)->get();

        return view('user.account.update', compact('carts', 'orders'));
    }

    // Account Update
    public function update(Request $request) {
        $this->checkProfileValidation($request);
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'phone' => $request->phone,
        ];

        if($request->hasFile('image')) {
            $dbImage = User::find(Auth::user()->id)->image;
            if($dbImage != null) {
                Storage::delete('public/profile' . $dbImage);
            }

            $imageName = uniqid() . '-' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/profile', $imageName);

            $data['image'] = $imageName;
        }

        User::find(Auth::user()->id)->update($data);

        return redirect()->route('user#detail')->with(['updateSuccess' => 'Profile updated successfully.']);
    }

    // Direct Password Page
    public function passwordPage() {
        $carts = Cart::where('user_id', Auth::user()->id)->get();
        $orders = Order::where('user_id', Auth::user()->id)->get();

        return view('user.account.password', compact('carts', 'orders'));
    }

    // Password Change
    public function changePassword(Request $request) {
        $this->checkPasswordValidation($request);

        if(Hash::check($request->oldPassword, Auth::user()->password)) {
            $newPassword = Hash::make($request->newPassword);
            User::find(Auth::user()->id)->update([
                'password' => $newPassword
            ]);
            return back()->with(['changeSuccess' => 'Password changed successfully.']);
        }

        return back()->with(['incorrectPassword' => 'The old password is incorrect.']);
    }

    // Check Profile Validation
    public function checkProfileValidation($request) {
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'image' => 'mimes:jpg,png,jpeg,webp'
        ])->validate();
    }

    // Password Validation
    private function checkPasswordValidation($request) {
        Validator::make($request->all(), [
            'oldPassword' => 'required|min:8',
            'newPassword' => 'required|min:8',
            'confirmPassword' => 'required|min:8|same:newPassword',
        ])->validate();
    }
}
