<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Backend\CategoryModel;

class ProductsModel extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'id';

    public function category(){
        return $this->belongsTo('App\Models\Backend\CategoryModel', 'category_id');
    }
}
