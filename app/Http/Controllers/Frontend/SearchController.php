<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backend\ProductsModel;
use App\Models\Frontend\CartModel;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SearchController extends Controller
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
    }

    public function search(Request $request) {

        $this->shareKey();

        $products = [];
        $keyword = $request->get("keyword", "");
        $keyword = strip_tags($keyword);
        if (strlen($keyword) > 0 && strlen($keyword) < 100) {

            //$queryORM = ProductsModel::where('product_name', "LIKE", "%".$keyword."%");
            //$products = $queryORM->paginate(10);     
            $products = ProductsModel::where('product_name', "LIKE BINARY", "%".$keyword."%")->get();

        }  
        
        $data["keyword"] = $keyword;
        $data["products"] = $products;

        $categories = DB::table("category")->get();
        $data["categories"] = $categories;

        return view("site.search", $data);
    }
}
