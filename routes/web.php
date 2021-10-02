<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Frontend\HomepageController;
use App\Models\Backend\CategoryModel;
use App\Models\Frontend\CartModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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



Route::get('/', [App\Http\Controllers\Frontend\HomeController::class, 'index']);

Route::get('/all-products', function(){

    $cart = new CartModel();
    $totalQttCart = $cart->getTotalQuantity();
    $totalPriceCart = $cart->getTotalPrice();

    view()->share('totalQttCart', $totalQttCart);
    view()->share('totalPriceCart', $totalPriceCart);

    $products = DB::table("products")->get();
    $categories = DB::table("category")->get();

    $data = [];
    $data['products'] = $products;
    $data['categories'] = $categories;

    return view("site.allProducts", $data);
});

Route::get('/product/{id}', [App\Http\Controllers\Frontend\ProductController::class, 'index']);
Route::get('/category/{id}', [App\Http\Controllers\Frontend\CategoryController::class, 'index']);
Route::get('/cart', [App\Http\Controllers\Frontend\CartController::class, 'index'])->middleware('auth');
Route::get('/payment', [App\Http\Controllers\Frontend\PaymentController::class, 'index'])->middleware('auth');
Route::post('/cart/add', [App\Http\Controllers\Frontend\CartController::class, 'add'])->middleware('auth');
Route::post('/cart/update', [App\Http\Controllers\Frontend\CartController::class, 'update'])->middleware('auth');
Route::post('/cart/remove', [App\Http\Controllers\Frontend\CartController::class, 'remove'])->middleware('auth');
Route::post('/cart/clear', [App\Http\Controllers\Frontend\CartController::class, 'clear'])->middleware('auth');
Route::post('/payment/checkout', [App\Http\Controllers\Frontend\PaymentController::class, 'checkout'])->middleware('auth');
Route::get('/aftercheckout', [App\Http\Controllers\Frontend\PaymentController::class, 'aftercheckout'])->middleware('auth');

Route::get('/search', [App\Http\Controllers\Frontend\SearchController::class, 'search']);


Auth::routes();

Route::get('/home', [App\Http\Controllers\Frontend\HomepageController::class, 'index'])->name('home');

Route::get('admin/home', [App\Http\Controllers\Backend\DashboardController::class, 'adminHome'])->name('admin.home')->middleware('is_admin');


 Route::get('/register', function(){
    $categories = CategoryModel::all();
    $data =[];
    $data['categories'] = $categories;
     return view('auth.register', $data);
 })->name('register');

 Route::get('/login', function(){
    $categories = CategoryModel::all();
    $data =[];
    $data['categories'] = $categories;
    return view('auth.login', $data);
})->name('login');

//facebook login
Route::get('login/facebook', [App\Http\Controllers\Auth\LoginController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('login/facebook/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleFacebookCallback']);


// backend category
Route::get('backend/category/index' , [App\Http\Controllers\Backend\CategoryController::class, 'index'])->middleware('is_admin');
Route::get('backend/category/create' , [App\Http\Controllers\Backend\CategoryController::class, 'create'])->middleware('is_admin');
Route::get('backend/category/edit/{id}' , [App\Http\Controllers\Backend\CategoryController::class, 'edit'])->middleware('is_admin');
Route::get('backend/category/delete/{id}' , [App\Http\Controllers\Backend\CategoryController::class, 'delete'])->middleware('is_admin');
Route::post('backend/category/store' , [App\Http\Controllers\Backend\CategoryController::class, 'store'])->middleware('is_admin');
Route::post('backend/category/update/{id}' , [App\Http\Controllers\Backend\CategoryController::class, 'update'])->middleware('is_admin');
Route::post('backend/category/destroy/{id}' , [App\Http\Controllers\Backend\CategoryController::class, 'destroy'])->middleware('is_admin');

// backend product
Route::get('backend/product/index' , [App\Http\Controllers\Backend\ProductsController::class, 'index'])->middleware('is_admin');
Route::get('backend/product/create' , [App\Http\Controllers\Backend\ProductsController::class, 'create'])->middleware('is_admin');
Route::get('backend/product/edit/{id}' , [App\Http\Controllers\Backend\ProductsController::class, 'edit'])->middleware('is_admin');
Route::get('backend/product/delete/{id}' , [App\Http\Controllers\Backend\ProductsController::class, 'delete'])->middleware('is_admin');
Route::post('backend/product/store' , [App\Http\Controllers\Backend\ProductsController::class, 'store'])->middleware('is_admin');
Route::post('backend/product/update/{id}' , [App\Http\Controllers\Backend\ProductsController::class, 'update'])->middleware('is_admin');
Route::post('backend/product/destroy/{id}' , [App\Http\Controllers\Backend\ProductsController::class, 'destroy'])->middleware('is_admin');


// quản lý đơn hàng
Route::get('/backend/orders/index', [App\Http\Controllers\Backend\OrderController::class, 'index'])->middleware('is_admin');
Route::get('/backend/orders/create', [App\Http\Controllers\Backend\OrderController::class, 'create'])->middleware('is_admin');
Route::get('/backend/orders/edit/{id}', [App\Http\Controllers\Backend\OrderController::class, 'edit'])->middleware('is_admin');
Route::get('/backend/orders/delete/{id}', [App\Http\Controllers\Backend\OrderController::class, 'delete'])->middleware('is_admin');
Route::post('/backend/orders/store',[App\Http\Controllers\Backend\OrderController::class, 'store'])->middleware('is_admin');
Route::post('/backend/orders/update/{id}', [App\Http\Controllers\Backend\OrderController::class, 'update'])->middleware('is_admin');
Route::post('/backend/orders/destroy/{id}', [App\Http\Controllers\Backend\OrderController::class, 'destroy'])->middleware('is_admin');

// quản lý users
Route::get('/backend/users/index', [App\Http\Controllers\Backend\UsersController::class, 'index'])->middleware('is_admin');
Route::get('/backend/users/delete/{id}', [App\Http\Controllers\Backend\UsersController::class, 'delete'])->middleware('is_admin');
Route::post('/backend/users/destroy/{id}', [App\Http\Controllers\Backend\UsersController::class, 'destroy'])->middleware('is_admin');

