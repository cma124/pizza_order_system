<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\User\AjaxController;
use App\Http\Controllers\User\UserController;

// Login / Register
Route::middleware('admin_auth')->group(function() {
    Route::redirect('/', 'loginPage');
    Route::get('loginPage', [AuthController::class, 'loginPage'])->name('auth#loginPage');

    Route::get('registerPage', [AuthController::class, 'registerPage'])->name('auth#registerPage');
});

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    Route::middleware('admin_auth')->group(function() {
        // Category
        Route::prefix('category')->group(function() {
            Route::get('list', [CategoryController::class, 'list'])->name('category#list');

            Route::get('createPage', [CategoryController::class, 'createPage'])->name('category#createPage');
            Route::post('create', [CategoryController::class, 'create'])->name('category#create');

            Route::get('delete/{id}', [CategoryController::class, 'delete'])->name('category#delete');

            Route::get('updatePage/{id}', [CategoryController::class, 'updatePage'])->name('category#updatePage');
            Route::post('update/{id}', [CategoryController::class, 'update'])->name('category#update');
        });

        // Admin Account
        Route::prefix('admin')->group(function() {
            // Password Change
            Route::get('changePasswordPage', [AdminController::class, 'changePasswordPage'])->name('admin#changePasswordPage');
            Route::post('changePassword', [AdminController::class, 'changePassword'])->name('admin#changePassword');

            // Profile Detail
            Route::get('detailPage', [AdminController::class, 'detailPage'])->name('admin#detailPage');

            // Profile Update
            Route::get('updatePage', [AdminController::class, 'updatePage'])->name('admin#updatePage');
            Route::post('update', [AdminController::class, 'update'])->name('admin#update');

            // Admin
            Route::get('list', [AdminController::class, 'list'])->name('admin#list');

            Route::get('delete/{id}', [AdminController::class, 'delete'])->name('admin#delete');

            // Admin Role Change
            Route::get('changeRole', [AdminController::class, 'changeRole'])->name('admin#changeRole');
        });

        // Product
        Route::prefix('product')->group(function() {
            Route::get('list', [ProductController::class, 'list'])->name('product#list');

            Route::get('createPage', [ProductController::class, 'createPage'])->name('product#createPage');
            Route::post('create', [ProductController::class, 'create'])->name('product#create');

            Route::get('delete/{id}', [ProductController::class, 'delete'])->name('product#delete');

            Route::get('detailPage/{id}', [ProductController::class, 'detailPage'])->name('product#detailPage');

            Route::get('updatePage/{id}', [ProductController::class, 'updatePage'])->name('product#updatePage');
            Route::post('update', [ProductController::class, 'update'])->name('product#update');
        });

        // Order
        Route::prefix('order')->group(function() {
            Route::get('list', [OrderController::class, 'list'])->name('adminOrder#list');
            Route::get('list/filter', [OrderController::class, 'filter'])->name('adminOrder#filter');
            Route::get('update', [OrderController::class, 'update'])->name('adminOrder#update');
            Route::get('detail/{code}', [OrderController::class, 'detail'])->name('adminOrder#detail');
            Route::get('delete', [OrderController::class, 'delete']);
        });

        // User List
        Route::prefix('user')->group(function() {
            Route::get('list', [AdminController::class, 'userList'])->name('admin#userList');
            Route::get('changeRole', [AdminController::class, 'changeUserRole'])->name('admin#changeUserRole');
            Route::get('delete', [AdminController::class, 'deleteUser'])->name('admin#deleteUser');
        });

        // Contact List
        Route::prefix('contact')->group(function() {
            Route::get('list', [ContactController::class, 'list'])->name('admin#contactList');
            Route::get('detail/{id}', [ContactController::class, 'detail'])->name('admin#contactDetail');
            Route::get('delete/{id}', [ContactController::class, 'delete'])->name('admin#contactDelete');
        });
    });

    //User
    //Home
    Route::group(['prefix' => 'user', 'middleware' => 'user_auth'], function() {
        Route::prefix('account')->group(function() {
            Route::get('password', [UserController::class, 'passwordPage'])->name('user#passwordPage');
            Route::post('password', [UserController::class, 'changePassword'])->name('user#changePassword');

            Route::get('detail', [UserController::class, 'detail'])->name('user#detail');

            Route::get('update', [UserController::class, 'updatePage'])->name('user#updatePage');
            Route::post('update', [UserController::class, 'update'])->name('user#update');
        });

        Route::prefix('products')->group(function() {
            Route::get('ajax', [AjaxController::class, 'getProducts'])->name('ajax#get');

            Route::get('home', [UserController::class, 'home'])->name('user#home');
            Route::get('filter/{id}', [UserController::class, 'filter'])->name('products#filter');
            Route::get('detail/{id}', [UserController::class, 'productDetail'])->name('products#detail');
            Route::get('view/add', [AjaxController::class, 'addViewCount'])->name('product#addViewCount');
        });

        Route::prefix('cart')->group(function() {
            Route::get('add', [AjaxController::class, 'addCart'])->name('cart#add');
            Route::get('list', [UserController::class, 'listCart'])->name('cart#list');
            Route::get('clear', [AjaxController::class, 'clearCart'])->name('cart#clear');
            Route::get('clear/item', [AjaxController::class, 'clearItem'])->name('cart#clearCartItem');
        });

        Route::prefix('order')->group(function() {
            Route::get('ajax', [AjaxController::class, 'addOrderList'])->name('ajax#orderList');
            Route::get('list', [UserController::class, 'listOrder'])->name('order#list');
        });

        Route::prefix('contact')->group(function() {
            Route::get('show', [ContactController::class, 'show'])->name('contact#show');
            Route::post('store', [ContactController::class, 'store'])->name('contact#store');
        });
    });
});
