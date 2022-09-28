<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiRouteController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// GET ALL
Route::get('/products', [ApiRouteController::class, 'showProducts']);
Route::get('/categories', [ApiRouteController::class, 'showCategories']);

// GET SINGLE ITEM
Route::get('/categories/{id}', [ApiRouteController::class, 'showCategory']);

// POST
Route::post('/categories/create', [ApiRouteController::class, 'createCategory']);
Route::post('/contacts/create', [ApiRouteController::class, 'createContact']);

// DELETE
Route::post('/categories/delete', [ApiRouteController::class, 'deleteCategory']);

// UPDATE
Route::post('/categories/update', [ApiRouteController::class, 'updateCategory']);


// All Products
// localhost:8000/api/products (GET)

// All Categories
// localhost:8000/api/categories (GET)

// Single Category
// localhost:8000/api/categories/{id} (GET)

// Create Category
// localhost:8000/api/categories/create (POST)
// key => name

// Create Contact
// localhost:8000/api/contacts/create (POST)
// key => user_id, subject, message

// Delete Category
// localhost:8000/api/categories/delete (POST)
// key => id

// Update Category
// localhost:8000/api/categories/update (POST)
// key => id, name
