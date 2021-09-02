<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Frontend\CartModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
   
    public function shareKey(){
        $cart = new CartModel();
        $totalQttCart = $cart->getTotalQuantity();
        $totalPriceCart = $cart->getTotalPrice();
        $totalItem = $cart->getTotalItem();
        view()->share('totalQttCart', $totalQttCart);
        view()->share('totalPriceCart', $totalPriceCart);
        view()->share('totalItem', $totalItem);

    }

    public function index()
    {
        $this->shareKey();

        $categories = DB::table('category')->get();

        $products = DB::table('products')->where('product_status',1)->limit(18)->orderBy('id', 'asc')->get();

        $productsSaleUp = DB::table('products')->where('product_sale','>=', 35)->get();

        $data = [];

        $data['categories'] = $categories;
        $data['products'] = $products;
        $data['productsSaleUp'] = $productsSaleUp;


        return view('site.homepage', $data);
    }
    
}
