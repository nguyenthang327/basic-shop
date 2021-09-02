<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Backend\ProductsModel;

use App\Models\Frontend\CartModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    //
    public function shareKey(){
        $cart = new CartModel();
        $totalQttCart = $cart->getTotalQuantity();
        $totalPriceCart = $cart->getTotalPrice();
        $totalItem = $cart->getTotalItem();
        view()->share('totalQttCart', $totalQttCart);
        view()->share('totalPriceCart', $totalPriceCart);
        view()->share('totalItem', $totalItem);

    }

    public function index(Request $request,$id){
        $this->shareKey();

        $sort = $request->query('sort');

        $categories = DB::table('category')->get();
        $category = DB::table('category')->where('id',$id)->first();
        $productQttInCategory = DB::table('products')->where('category_id',$id)->count();

        $discountProducts = ProductsModel::where('category_id',$id);

        if($sort == 'price_asc'){
            $discountProducts->orderBy('product_price' , "ASC");
        }

        if($sort == 'price_desc'){
            $discountProducts->orderBy('product_price' , "DESC");
        }

        $discountProducts = $discountProducts->paginate(10);

        $data = [];

        $data['categories'] = $categories;
        $data['category'] = $category;
        $data['productQttInCategory'] = $productQttInCategory;
        $data['discountProducts'] = $discountProducts;
       
        $data['sort'] = $sort;

        return view("site.category", $data);
    }

    
}
