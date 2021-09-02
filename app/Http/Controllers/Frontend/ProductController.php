<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Backend\ProductsModel;
use App\Models\Frontend\CartModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    //
    public function shareKey()
    {
        $cart = new CartModel();
        $totalQttCart = $cart->getTotalQuantity();
        $totalPriceCart = $cart->getTotalPrice();
        $totalItem = $cart->getTotalItem();
        view()->share('totalQttCart', $totalQttCart);
        view()->share('totalPriceCart', $totalPriceCart);
        view()->share('totalItem', $totalItem);
        
        $categories = DB::table('category')->get();
        view()->share('categories', $categories);
    }

    public function index($id){
        $this->shareKey();

        $product = ProductsModel::find($id);
        $categories = DB::table('category')->get();

        $data = [
            'product' => $product,
            'categories' => $categories
        ];

        return view('site.product', $data);
    }
}
