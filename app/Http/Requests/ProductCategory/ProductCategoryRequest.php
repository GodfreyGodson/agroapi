<?php

namespace App\Http\Requests\ProductCategory;

use Illuminate\Foundation\Http\FormRequest;

class ProductCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            //

            'name_product' => [
                'required',
                'string'

            ],

            'image_product' => [
                'nullable'

            ],

            'rate_product' => [
                'nullable',


            ],




        ];
        return  $rules;
    }
}
