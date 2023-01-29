<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use  App\Models\Category;
use  App\Models\Store;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
       $name = $this->faker->word(2,true);
        return [
            'name'=> $name ,
            'slug'=>Str::slug($name),
            'description'=>$this->faker->sentence(15),
            'image'=>$this->faker->imageUrl(300,300),
            'price'=>$this->faker->randomFloat(1,500,999),
            'category_id'=>Category::inRandomOrder()->first()->id,
            'fetured' =>rand(0,1),
             'store_id'=>Store::inRandomOrder()->first()->id,
        ];
    }
}