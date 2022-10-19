<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
             'category_id'=>function(){

                return Category::all()->random();

             },
            'product_name' => $this ->faker->word,
            'image'=>$this->faker->word,
            'rate'=>$this->faker->numberBetween(0,5)
        ];
    }
}
