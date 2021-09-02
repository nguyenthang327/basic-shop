<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\OrderModel;
use App\Models\Backend\OrderDetailModel;
use App\Models\Backend\ProductsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\VarDumper\Cloner\Data;

class OrderController extends Controller
{
    //
    public function index(Request $request){
        $sort = $request->query('sort',"");
        $searchKeyword = $request->query('name', "");

        $queryORM = OrderModel::where('customer_name',"LIKE","%".$searchKeyword."%");

        if($sort == "name_asc"){
            $queryORM->orderBy('customer_name', "asc");
        }

        if($sort == "name_desc"){
            $queryORM->orderBy('customer_name', "desc");
        }

        $orders = $queryORM->paginate(10);

        $data = [];
        $data['sort'] = $sort;
        $data['orders'] = $orders;
        $data['searchKeyword'] = $searchKeyword;

        
        $order_status_defined = [];
        $order_status_defined[1] = "Đang chờ xác nhận";
        $order_status_defined[2] = "Đã xác nhận";
        $order_status_defined[3] = "Đang vận chuyển";
        $order_status_defined[4] = "Hoàn tất";
        $order_status_defined[5] = "Đơn hủy";
        $order_status_defined[6] = "Đã hoàn tiền ( hủy đơn )";

        $data["order_status_defined"] = $order_status_defined;

        return view("backend.orders.index", $data);
    }

    public function create(){
        return view('backend.orders.create');
    }

    public function edit($id){
        
        $order = OrderModel::findOrFail($id);

        $productInOrders = DB::table('products')
            ->join('orderdetail' , 'orderdetail.product_id', '=', 'products.id')
            ->select('products.id' , 'products.product_name', 'products.product_image', 'orderdetail.order_id', 'orderdetail.quantity', 'orderdetail.product_price')
            ->where('orderdetail.order_id','=',$id)
            ->get();

        $data = [];
        $data['order'] =$order;
        $data['productInOrders'] = $productInOrders;

        return view('backend.orders.edit', $data);
    }

    public function delete($id){
        $order = OrderModel::findOrFail($id);

        $data = [];
        $data['order'] =$order;
        return view('backend.orders.delete', $data);
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'customer_name' => 'required',
            'customer_email' => 'required',
            'customer_address' => 'required',
            'customer_phone' =>'required',
            'order_status' => 'required',
            'order_note' => 'required',
        ]);

        if(empty($product_ids) || empty($product_quantities)){
            return redirect("/backend/orders/create")->withInput()->withErrors(["product_ids"=>" bạn chưa chọn sản phẩm nào cho đơn hàng"]);
        }

        $customer_name = $request->input('customer_name','');
        $customer_address = $request->input('customer_address','');
        $customer_phone = $request->input('customer_phone','');
        $customer_email = $request->input('customer_email','');
        $order_status = $request->input('order_status','');
        $order_note = $request->input('order_note','');
        $product_ids = $request->input('product_ids');
        $product_quantities = $request->input('product_quantity');

        $order = new OrderModel();

        $order->customer_name = $customer_name;
        $order->customer_email = $customer_email;
        $order->customer_address = $customer_address;
        $order->customer_phone = $customer_phone;
        $order->order_status = $order_status;
        $order->order_note = $order_note;

        foreach($product_ids as $product_ids_key => $productId){

            $quantity = $product_quantities[$product_ids_key];
            $product = ProductsModel::find($productId);

            $productPriceSale = $product->product_price - $product->product_price *$product->product_sale /100;
            $totalPriceProduct = $quantity * $productPriceSale;

            $order->total_product += $quantity;
            $order->total_price += $totalPriceProduct;

            // update sl san pham trong gio hang
            $product->product_quantity = $product->product_quantity - $quantity;
            $product->save();
        }

        $order->save();

        foreach($product_ids as $product_ids_key => $productId){
            $quantity = $product_quantities[$product_ids_key];
            $product = ProductsModel::find($productId);
            
            $productPriceSale = $product->product_price *$product->product_sale /100;
            $totalPriceProduct = $quantity * $productPriceSale;

            $orderDetail = new OrderDetailModel();

            $orderDetail->product_id = $productId;
            $orderDetail->product_price = $product->product_price;
            $orderDetail->quantity = $quantity;
            $orderDetail->order_id = $order->id;
            $orderDetail->order_status = $order_status;
            $orderDetail->save();
        }


        return redirect('/backend/orders/index')->with('status', 'thêm đơn hàng thành công');

    }

    public function update(Request $request, $id){
        $validatedData = $request->validate([
            'customer_name' => 'required',
            'customer_address' => 'required',
            'customer_phone' => 'required',
            'customer_email' => 'required',
            'order_status' => 'required',
            'order_note' => 'required',

        ]);

        $customer_name = $request->input('customer_name','');
        $customer_address = $request->input('customer_address','');
        $customer_phone = $request->input('customer_phone','');
        $customer_email = $request->input('customer_email','');
        $order_status = $request->input('order_status','');
        $order_note = $request->input('order_note','');


        $order = OrderModel::findOrFail($id);

        $order->customer_name = $customer_name;
        $order->customer_address = $customer_address;
        $order->customer_phone = $customer_phone;
        $order->customer_email = $customer_email;
        $order->order_status = $order_status;
        $order->order_note = $order_note;

        $order->save();

        $orderDetails = DB::table('orderdetail')->where('order_id', $order->id)->get();

        
        foreach($orderDetails as $orderDetail){
            $orderDetail = OrderDetailModel::findOrFail($orderDetail->id);
            $orderDetail->order_status = $order_status;
            $orderDetail->save();
        }

        return redirect("/backend/orders/edit/$id")->with('status', 'cập nhật đơn hàng thành công !');
    }

    public function destroy($id){
        $order = OrderModel::findOrFail($id);

        $orderDetails  = DB::table('orderdetail')->where('order_id',$order->id)->get();

        foreach($orderDetails as $orderDetail){
            $orderDetail = OrderDetailModel::findOrFail($orderDetail->id);
            $product_idInOrderDetail = $orderDetail->product_id;
            $product_quantityInOrderDetail = $orderDetail->product_quantity;

            $product = ProductsModel::find($product_idInOrderDetail);
            $product->product_quantity += $product_quantityInOrderDetail;

            $product->save();
        }

        $order->delete();
        $orderDetail->delete();

        return redirect('/backend/orders/index')->with('status', 'xoá đơn hàng thành công');
    }
}
