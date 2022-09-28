<?php

namespace App\Http\Controllers\Api;

use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiRouteController extends Controller
{
    // Show all products
    public function showProducts() {
        $products = Product::all();
        return response()->json($products, 200);
    }

    // Show all categories
    public function showCategories() {
        $categories = Category::all();
        return response()->json($categories, 200);
    }

    // Show single category
    public function showCategory($id) {
        $category = Category::find($id);
        if(!empty($category)) {
            return response()->json($category, 200);
        }

        return response()->json(['message' => 'No category with this id'], 200);
    }

    // Create category
    public function createCategory(Request $request) {
        $category = Category::create([
            'name' => $request->name
        ]);
        return response()->json($category, 200);
    }

    // Create contact
    public function createContact(Request $request) {
        $contact = Contact::create([
            'user_id' => $request->user_id,
            'subject' => $request->subject,
            'message' => $request->message
        ]);
        return response()->json($contact, 200);
    }

    // Delete category
    public function deleteCategory(Request $request) {
        $category = Category::find($request->id);
        if(!empty($category)) {
            $category = $category->delete();
            return response()->json(['message' => 'Successfully deleted'], 200);
        }

        return response()->json(['message' => 'No category with this id']);
    }

    // Update category
    public function updateCategory(Request $request) {
        $category = Category::find($request->id);
        if(!empty($category)) {
            $category = $category->update([
                'name' => $request->name
            ]);
            $category = Category::find($request->id);
            return response()->json($category, 200);
        }

        return response()->json(['message' => 'No category with this id']);
    }
}
