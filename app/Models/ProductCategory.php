<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;
    protected $table = 'product_categories';
    protected $fillable = ['name_product', 'image_product', 'rate_product', 'product_id'];

 public function products()
 {

    return $this -> belongsTo(Product::class);
 }
}
