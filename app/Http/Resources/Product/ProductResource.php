<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this ->id,
            'product_name' => $this->product_name,
            'image'=>$this->image,
            'rate'=>$this->rate,


          //  'href' => [
           //   'product_categories'=>route('product-categories.index', $this->id)
         //  ]

        ];



    }
}
