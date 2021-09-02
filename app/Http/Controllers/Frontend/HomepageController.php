<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Frontend\CartModel;
use App\Models\Backend\CategoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomepageController extends Controller
{
    //
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

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

        $products = DB::table('products')->where('product_status',"=", "1" )->limit(18)->orderBy('id', 'asc')->get();

        $productsSaleUp = DB::table('products')->where('product_sale','>=', 35)->get();

        $data = [];

        $data['categories'] = $categories;
        $data['products'] = $products;
        $data['productsSaleUp'] = $productsSaleUp;


        return view('site.homepage', $data);
    }
    
}
