<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Frontend\CartModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
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

    public function index() {

        $this->shareKey();
        $data = [];

        $categories = DB::table("category")->get();

        $data["categories"] = $categories;
        $cart = new CartModel();
        $data["cart"] =  $cart->getItems();

        $cartIds = [];

        foreach($data["cart"] as $id => $valCart) {
            $cartIds[] = $id;
        }
        $products = DB::table("products")->whereIn("id", $cartIds)->get();

        $data["products"] = $products;

        return view("site.cart", $data);
    }

    public function getTotalQuantity(){
        $this->shareKey();

        $cart = new CartModel();

        $quantity = $cart->getTotalQuantity();

        $msg = ["quantity" => $quantity];

        return response()->json($msg,200);
    }

    public function add(Request $request) {

        $this->shareKey();

        $cart = new CartModel();

        $id = $request->get("id", 0);
        $quantity = $request->get("quantity", 1);
        $attributes = $request->get("attributes", []);

        $cart->addCart($id, $quantity, $attributes);

        // response json
        $msg = ["text" => "thêm sản phẩm thành công"];
        return response()->json($msg, 200);
    }

    public function update(Request $request){
        $this->shareKey();

        $cart = new CartModel();

        $id = $request->get("id", 0);
        $quantity =$request->get("quantity",1);
        $attributes = $request->get("attributes", []);

        $cart->updateCart($id, $quantity, $attributes);

        $msg = ['text', "cập nhật sản phẩm thành công"];

        return response()->json($msg,200);
    }

    public function remove(Request $request){
        $this->shareKey();

        $cart = new CartModel();

        $id = $request->get("id", 0);
        $attributes = $request->get("attributes", []);

        $cart->removeCart($id, $attributes);

        $msg = ['text', "xoá sản phẩm thành công"];

        return response()->json($msg,200);
    }

    public function clear() {

        $this->shareKey();

        $cart = new CartModel();

        $cart->clearCart();

        // response json
        $msg = ["text" => "xóa giỏ hàng thành công"];
        return response()->json($msg, 200);
    }

} 






