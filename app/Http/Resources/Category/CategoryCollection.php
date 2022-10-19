<?php

namespace App\Http\Resources\Category;
//use App\Models\Category;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [

            'category_name'=>$this->category_name,
            'image'=> $this->image,
            'href'=>[
                'link'=>route('categories.show', $this->id)
            ]

        ];
    }
}
