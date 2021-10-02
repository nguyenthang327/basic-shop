<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Backend\OrderDetailModel;
use App\Models\Backend\OrderModel;
use App\Models\Backend\ProductsModel;
use App\Models\Frontend\CartModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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

        $moneytotal = 0;
        $product_name_to_send_mail = [];

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

            $product_name_to_send_mail[]=$product->product_name;

            $order->total_product += $quantity;
            $order->total_price += $totalPriceProduct;

            $product->product_quantity = $product->product_quantity - $quantity;
            $product->save();
        }

        $moneytotal = $order->total_price;
        //dd($product_name_to_send_mail);
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

        // send mail
        $to_name = "thanghaui05112001@gmail.com";
        $to_email = "$customer_email";

        $data_email = array("name"=> "VTH_Z shop", "body"=>"Hàng hóa bạn đã order từ shop chúng tôi", "total"=>"$moneytotal","product_names"=>$product_name_to_send_mail);
        Mail::send('site.send_mail.send_mail', $data_email , function($message) use($to_name,$to_email){
            $message->to($to_email)->subject('Thông tin đơn hàng từ VTH_Z');
            $message->from($to_name,$to_email);
        });


        $cart->clearCart();

        return redirect('/aftercheckout')->with('status', 'thêm đơn hàng thành công và được gửi đến mail của bạn');
    }

    public function aftercheckout(){
        $this->shareKey();

        $categories = DB::table("category")->get();

        $data = [];
        $data["categories"] = $categories;

        return view("site.aftercheckout", $data);
    }
}
