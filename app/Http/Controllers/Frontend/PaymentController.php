<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Backend\OrderDetailModel;
use App\Models\Backend\OrderModel;
use App\Models\Backend\ProductsModel;
use App\Models\Frontend\CartModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
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

    public function index(){
        $this->shareKey();

        $categories = DB::table("category")->get();

        $data = [];
        $data["categories"] = $categories;

        $cart = new CartModel();
        $data["cart"] = $cart->getItems();

        $cartIds = [];
        foreach($data["cart"] as $id => $valCart){
            $cartIds[] = $id;
        }

        $products = DB::table("products")->whereIn("id", $cartIds)->get();

        $data["products"] = $products;

        return view("site.payment", $data);
    }

    public function checkout(Request $request){
        $validatedData = $request->validate([
            "customer_name" => 'required',
            "customer_email" => 'required',
            "customer_phone" => 'required',
            "customer_address" => 'required',
            "order_note" => 'required',
        ]);

        $customer_name = $request->get("customer_name", "");
        $customer_email = $request->get("customer_email", "");
        $customer_phone = $request->get("customer_phone", "");
        $customer_address = $request->get("customer_address", "");
        $order_note = $request->get("order_note", "");

        $cart = new CartModel();
        $data["cart"] = $cart->getItems();

        $order = new OrderModel();

        $order->customer_name = $customer_name;
        $order->customer_phone = $customer_phone;
        $order->customer_email = $customer_email;
        $order->customer_address = $customer_address;
        $order->order_note = $order_note;
        $order->order_status = 1;

        foreach($data["cart"] as $id => $valCart){
            $cartIds[] = $id;

            $quantity = $valCart[0]['quantity'];
            $product = ProductsModel::find($id);
            $totalPriceProduct = $quantity* ($product->product_price - $product->product_price * $product->product_sale / 100);

            $order->total_product += $quantity;
            $order->total_price += $totalPriceProduct;

            $product->product_quantity = $product->product_quantity - $quantity;
            $product->save();
        }

        $order->save();

        foreach($data["cart"] as $id => $valCart){
            $quantity = $valCart[0]['quantity'];
            $product = ProductsModel::find($id);

            $orderDetail = new OrderDetailModel();
            $orderDetail->product_id = $id;
            $orderDetail->product_price = $product->product_price - $product->product_price * $product->product_sale / 100;
            $orderDetail->quantity = $quantity;
            $orderDetail->order_id = $order->id;
            $orderDetail->order_status = 1;
            $orderDetail->save();
        }

        $cart->clearCart();

        return redirect('/aftercheckout')->with('status', 'thêm đơn hàng thành công');
    }

    public function aftercheckout(){
        $this->shareKey();

        $categories = DB::table("category")->get();

        $data = [];
        $data["categories"] = $categories;

        return view("site.aftercheckout", $data);
    }
}
