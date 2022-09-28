<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    // Direct Category List Page
    public function list() {
        $categories = Category::when(request('searchKey'), function($query) {
            $query->where('name', 'like', '%' . request('searchKey') . '%');
        })
        ->orderBy('created_at', 'desc')
        ->paginate(4);
        $categories->appends(request()->all());

        return view('admin.category.list', compact('categories'));
    }

    // Direct Category Create Page
    public function createPage() {
        return view('admin.category.create');
    }

    // Category Create
    public function create(Request $request) {
        $this->checkCategoryValidation($request);
        Category::create([
            'name' => $request->categoryName
        ]);
        return redirect()->route('category#list');
    }

    // Category Delete
    public function delete($id) {
        Category::find($id)->delete();
        return back()->with(['message' => 'Deleted successfully.']);
    }

    // Direct Category Update Page
    public function updatePage($id) {
        $category = Category::find($id);
        return view('admin.category.update', compact('category'));
    }

    // Category Update
    public function update($id, Request $request) {
        $this->checkCategoryValidation($request);
        Category::find($id)->update([
            'name' => $request->categoryName
        ]);

        return redirect()->route('category#list')->with(['message' => 'Updated successfully.']);
    }

    // Category Validation
    private function checkCategoryValidation($request) {
        Validator::make($request->all(), [
            'categoryName' => 'required|unique:categories,name'
        ])->validate();
    }
}
