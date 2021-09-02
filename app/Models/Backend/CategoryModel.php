<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Backend\ProductsModel;

class CategoryModel extends Model
{
    use HasFactory;

    protected $table = 'category';

    protected $primaryKey = 'id';

    public function products(){
        return $this->hasMany('App\Models\Backend\ProductsModel', 'category_id');
    }
}
