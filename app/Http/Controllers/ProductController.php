<?php

namespace App\Http\Controllers;

use Storage;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    // Direct Product List Page
    public function list() {
        $products = Product::select('products.*', 'categories.name as category_name')
        ->when(request('searchKey'), function($query) {
            $query->where('products.name', 'like', '%' . request('searchKey') . '%');
        })
        ->leftJoin('categories', 'products.category_id', 'categories.id')
        ->orderBy('products.created_at', 'desc')
        ->paginate(3);
        $products->appends(request()->all());

        return view('admin.product.list', compact('products'));
    }

    // Direct Product Create Page
    public function createPage() {
        $categories = Category::select('id', 'name')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('admin.product.create', compact('categories'));
    }

    // Product Create
    public function create(Request $request) {
        $this->checkProductValidation($request, 'create');
        $data = $this->getArray($request);

        $imageName = uniqid() . '-' . $request->file('productImage')->getClientOriginalName();
        $request->file('productImage')->storeAs('public/products', $imageName);
        $data['image'] = $imageName;

        Product::create($data);

        return redirect()->route('product#list');
    }

    // Product Delete
    public function delete($id) {
        $oldImageName = Product::find($id)->image;
        Storage::delete('public/products/' . $oldImageName);

        Product::find($id)->delete();
        return back()->with(['message' => 'Deleted successfully.']);
    }

    // Direct Product Detail Page
    public function detailPage($id) {
        $product = Product::select('products.*', 'categories.name as category_name')
            ->leftJoin('categories', 'products.category_id', 'categories.id')
            ->find($id);

        return view('admin.product.detail', compact('product'));
    }

    // Direct Product Update Page
    public function updatePage($id) {
        $product = Product::find($id);
        $categories = Category::all();
        return view('admin.product.update', compact('product', 'categories'));
    }

    // Product Update
    public function update(Request $request) {
        $this->checkProductValidation($request, 'update');
        $data = $this->getArray($request);

        if($request->hasFile('productImage')) {
            $oldImageName = Product::find($request->productId)->image;
            Storage::delete('public/products/' . $oldImageName);

            $imageName = uniqid() . '-' .$request->file('productImage')->getClientOriginalName();
            $request->file('productImage')->storeAs('public/products', $imageName);
            $data['image'] = $imageName;
        }

        Product::find($request->productId)->update($data);
        return redirect()->route('product#list')->with(['message' => 'Updated successfully.']);
    }

    // Return Data Array
    private function getArray($request) {
        return [
            'category_id' => $request->productCategory,
            'name' => $request->productName,
            'description' => $request->productDescription,
            'price' => $request->productPrice,
        ];
    }

    // Product Validation
    private function checkProductValidation($request, $type) {
        $validationRules = [
            'productName' => 'required|unique:products,name,' . $request->productId,
            'productCategory' => 'required',
            'productDescription' => 'required',
            'productPrice' => 'required'
        ];

        $type == 'update'
        ? $validationRules['productImage'] = 'mimes:png,jpg,jpeg,webp'
        : $validationRules['productImage'] = 'required|mimes:png,jpg,jpeg,webp';

        Validator::make($request->all(), $validationRules)->validate();
    }
}
