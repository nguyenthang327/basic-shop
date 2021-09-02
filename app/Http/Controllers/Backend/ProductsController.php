<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\ProductsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class ProductsController extends Controller
{
     //
     public function index(Request $request){
        $sort = $request->query('product_sort', "");

        $searchKeyword = $request->query('product_name', "");
        $productStatus = (int)$request->query('product_status', 0);
        $category_id = (int) $request->query('category_id',0);

        $queryORM = ProductsModel::where('product_name', "LIKE", "%".$searchKeyword."%");

        if($sort == 'price_asc'){
            $queryORM->orderBy('price', 'asc');
        }

        if($sort == 'price_desc'){
            $queryORM->orderBy('price', 'desc');
        }

        if($sort == 'quantity_asc'){
            $queryORM->orderBy('quantity', 'asc');
        }

        if($sort == 'quantity_desc'){
            $queryORM->orderBy('quantity', 'desc');
        }

        $products = $queryORM->paginate(10);

        $data = [];
        $data['products'] = $products;
        $data['searchKeyword'] = $searchKeyword;
        $data['productStatus'] = $productStatus;
        $data['category_id'] = $category_id;
        $data['sort'] = $sort;

        $categories = DB::table('category')->get();
        $data['categories'] = $categories;

        return view('backend.products.index', $data);
    }

    public function create(){

        $data = [];
        $categories = DB::table('category')->get();
        $data['categories'] = $categories;

        return view('backend.products.create', $data);
    }

    public function store(Request $request){

        $validatedData = $request->validate([
            'product_name' => 'required',
            'category_id' => 'required',
            'product_image' => 'required',
            'product_publish' => 'required',
            'product_desc' => 'required',
            'product_quantity' => 'required',
            'product_price' => 'required',
            'product_sale' => 'required'
        ]);

        $product_name = $request->input('product_name', '');
        $category_id = $request->input('category_id', 0);
        $product_status = $request->input('product_status', 1);
        $product_publish = $request->input('product_publish', '');
        $product_desc = $request->input('product_desc', '');
        $product_quantity = $request->input('product_quantity', 0);
        $product_price = $request->input('product_price', 0);
        $product_sale = $request->input('product_sale', 0);
        
        

        $pathProductImage = $request->file('product_image')->store('public/productimages');

        $product = new ProductsModel();

        if(!$product_publish){
            $product_publish = date("Y-m-d H:i:s");
        }

        $product->product_name = $product_name;
        $product->category_id = $category_id;
        $product->product_status = $product_status;
        $product->product_desc = $product_desc;
        $product->product_publish = $product_publish;
        $product->product_quantity = $product_quantity;
        $product->product_price = $product_price;
        $product->product_sale = $product_sale;


        $product->product_image = $pathProductImage;
        

        $product->save();

        return redirect('/backend/product/index')->with('status', 'thêm sản phẩm thành công');
    }

    public function edit($id){
        $product =  ProductsModel::findOrFail($id);

        $data = [];
        $data['product'] = $product;

        $categories = DB::table('category')->get();
        $data["categories"] = $categories;

        return view('backend.products.edit', $data);
    }

    public function update(Request $request, $id){
        
        $validatedData = $request->validate([
            'product_name' => 'required',
            'category_id' => 'required',
            'product_publish' => 'required',
            'product_desc' => 'required',
            'product_quantity' => 'required',
            'product_price' => 'required',
            'product_sale' => 'required'
        ]);

        $product_name = $request->input('product_name', '');
        $category_id = (int) $request->input('category_id', 0);
        $product_status = $request->input('product_status', 1);
        $product_desc = $request->input('product_desc', '');
        $product_publish = $request->input('product_publish', '');
        $product_quantity = $request->input('product_quantity', 0);
        $product_price = $request->input('product_price', 0);
        $product_sale = $request->input('product_sale', 0);


        if (!$product_publish) {
            $product_publish = date("Y-m-d H:i:s");
        }

        $product = ProductsModel::findOrFail($id);

        $product->product_name = $product_name;
        $product->category_id = $category_id;
        $product->product_status = $product_status;
        $product->product_desc = $product_desc;
        $product->product_publish = $product_publish;
        $product->product_quantity = $product_quantity;
        $product->product_price = $product_price;
        $product->product_sale = $product_sale;


        if($request->hasFile('product_image')){
            if($product->product_image){
                Storage::delete($product->product_image);
            }

            $pathProductImage = $request->file('image')->store('public/productimages');
            $product->product_image = $pathProductImage;
        }

        $product->save();
        return redirect("/backend/product/edit/$id")->with('status', 'update san pham thanh cong');
    }

    public function delete($id){

        $product = ProductsModel::findOrFail($id);

        $data = [];
        $data['product'] = $product;
        return view('backend.products.delete', $data);
    }

    public function destroy($id){

        $product = ProductsModel::findOrFail($id);

        $product->delete();

        return redirect("/backen/product/index")->with('status', 'xoa san pham thanh cong');
    }
}
