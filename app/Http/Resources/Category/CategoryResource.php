<?php

namespace App\Http\Resources\Category;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'category_name'=>$this->category_name,
            'image'=>$this->image,
            //'price'=>$this->price,
           /// 'discount'=>$this->discount,
           // 'totalpric'=> round((1-($this->discount/100))* $this->price, 2) ,
            //'stock'=>$this->stock == 0 ? 'out of stock' : $this->stock,
            //'rate'=> $this->products->count() > 0 ?round($this->products->sum('rate')/$this->products->count(), 2) : 'no rating yet',
            'href' => [
                 'products'=>route('products.index', $this->id)
            ]

        ];
    }
}
