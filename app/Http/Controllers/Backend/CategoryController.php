<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backend\CategoryModel;
use COM;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    //
    public function index(Request $request){
        $sort = $request->query('sort', "");

        $searchKeyword = $request->query('name', "");
        $queryORM = CategoryModel::where('name', "LIKE", "%".$searchKeyword."%");

        if($sort == 'name_asc'){
            $queryORM->orderBy('name', 'asc');
        }

        if($sort == 'name_desc'){
            $queryORM->orderBy('name', 'desc');
        }

        $categories = $queryORM->paginate(10);

        $data = [];
        $data['categories'] = $categories;
        $data['searchKeyword'] = $searchKeyword;
        $data['sort'] = $sort;

        return view('backend.category.index', $data);
    }

    public function create(){
        return view('backend.category.create');
    }

    public function store(Request $request){

        $validatedData = $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'image' => 'required',
            'desc' => 'required',
        ]);

        $name = $request->input('name', '');
        $slug = $request->input('slug', '');
        $desc = $request->input('desc', '');

        $pathCategoryImage = $request->file('image')->store('public/categoryimages');

        $category = new CategoryModel();

        $category->name = $name;
        $category->slug = $slug;
        $category->desc = $desc;
        $category->image = $pathCategoryImage;

        $category->save();

        return redirect('/backend/category/index')->with('status', 'thêm danh mục thành công');
    }

    public function edit($id){
        $category =  CategoryModel::findOrFail($id);

        $data = [];
        $data['category'] = $category;

        return view('backend.category.edit', $data);
    }

    public function update(Request $request, $id){
        
        $validatedData = $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'desc' => 'required',
        ]);

        $name = $request->input('name', '');
        $slug = $request->input('slug', '');
        $desc = $request->input('desc', '');

        $category = CategoryModel::findOrFail($id);

        $category->name = $name;
        $category->slug = $slug;
        $category->desc = $desc;

        if($request->hasFile('image')){
            if($category->image){
                Storage::delete($category->image);
            }

            $pathCategoryImage = $request->file('image')->store('public/categoriesimages');
            $category->image = $pathCategoryImage;
        }

        $category->save();
        return redirect("/backend/category/edit/$id")->with('status', 'update danh muc thanh cong');
    }

    public function delete($id){

        $category = CategoryModel::findOrFail($id);

        $data = [];
        $data['category'] = $category;
        return view('backend.category.delete', $data);
    }

    public function destroy($id){

        $category = CategoryModel::findOrFail($id);
        $category_id = $category->id;

        $countProducts = DB::table('products')->select(DB::raw('count(*) as product_in_category','category_id'))
                        ->where('category_id',$category_id)
                        ->groupBy('category_id')
                        ->get();
        $product_in_category = $countProducts[0]->product_in_category;
        if($product_in_category > 0){
            
            return redirect("/backend/category/index")->with('status', 'vui long xoa het danh muc cua san pham truoc khi xoa danh muc nay');
        }

        $category->delete();

        return redirect("/backend/category/index")->with('status', 'xoa danh muc thanh cong');
    }
}