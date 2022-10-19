<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = ['product_name', 'image', 'rate', 'category_id'];

 public function categories()
 {

    return $this -> belongsTo(Category::class);
 }

 public function product_categories()
 {
     return $this -> hasMany(ProductCategory::class);
 }

}
