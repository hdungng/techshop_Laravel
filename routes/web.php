<?php

use App\Http\Controllers\AdminImageProductController;
use App\Http\Controllers\AdminProductBrandController;
use App\Http\Controllers\AdminProductCatController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MainPageController;
use App\Http\Controllers\ProductCatController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('admin', [HomeController::class, 'index']);


Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'login')->name('login');
    Route::get('logout', 'logout')->name('logout');
    Route::get('register', 'register')->name('register');


    Route::post('loginUser', 'loginUser')->name('loginUser');
    Route::post('registerUser', 'registerUser')->name('registerUser');
});



Route::middleware('check.auth', 'admin.auth')->group(function () {

    Route::controller(DashboardController::class)->group(function () {
        Route::get('dashboard', 'show')->name('dashboard');

        Route::get('admin', 'show');
    });

    Route::controller(AdminUserController::class)->group(function () {
        Route::get('admin/user/list', 'list')->name('list_user');
        Route::get('admin/user/add', 'add')->name('add_user_show');
        Route::get('admin/user/delete/{id}', 'delete')->name('delete_user');
        Route::get('admin/user/edit/{id}', 'edit')->name('edit_user');


        Route::post('admin/user/update/{id}', 'update')->name('update_user');
        Route::post('admin/user/action', 'action')->name('action_user');
        Route::post('admin/user/store', 'store')->name('add_user');
    });

    Route::controller(AdminProductController::class)->group(function () {
        Route::get('admin/product/list', 'list')->name('list_product');
        Route::get('admin/product/add', 'add')->name('add_product');
        Route::get('admin/product/update/{id}', 'update')->name('update_product');
        Route::get('admin/product/delete/{id}', 'delete')->name('delete_product');


        Route::post('admin/product/create', 'create')->name('create_product');
        Route::post('admin/product/edit/{id}', 'edit')->name('edit_product');
    });


    Route::controller(AdminProductCatController::class)->group(function () {
        Route::get('admin/product_cat/list', 'list')->name('list_product_cat');
        Route::get('admin/product_cat/update/{id}', 'update')->name('update_product_cat');
        Route::get('admin/product_cat/delete/{id}', 'delete')->name('delete_product_cat');


        Route::post('admin/product_cat/create', 'create')->name('create_product_cat');
        Route::post('admin/product_cat/store/{id}', 'store')->name('store_product_cat');
    });

    Route::controller(AdminImageProductController::class)->group(function () {
        Route::get('admin/image_product/add/{id}', 'add')->name('add_image_product');
        Route::get('admin/image_product/update/{id}', 'update')->name('update_image_product');

        Route::post('admin/image_product/create', 'create')->name('create_image_product');
        Route::post('admin/image_product/store/{id}', 'store')->name('store_image_product');
    });

    Route::controller(AdminProductBrandController::class)->group(function () {
        Route::get('admin/product_brand/list', 'list')->name('list_product_brand');
        Route::get('admin/product_brand/delete/{id}', 'delete')->name('delete_product_brand');
        Route::get('admin/product_brand/update/{id}', 'update')->name('update_product_brand');

        Route::post('admin/product_brand/store/{id}', 'store')->name('store_product_brand');
        Route::post('admin/product_brand/create', 'create')->name('create_product_brand');
    });
});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::get('/', [MainPageController::class, 'index'])->name('home_page');
Route::get('/category/{name}', [ProductCatController::class, 'index'])->name('category');
Route::get('/detail/{id}', [ProductController::class, 'index'])->name('detail');
Route::get('/profile/{id}', [UserController::class, 'profile'])->name('profile');