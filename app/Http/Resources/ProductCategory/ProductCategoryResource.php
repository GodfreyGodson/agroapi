<?php

namespace App\Http\Resources\ProductCategory;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
        return [
            'id' => $this ->id,
            'name_product' => $this->name_product,
            'image_product'=>$this->image_product,
            'rate_product'=>$this->rate_product
        ];
    }
}
