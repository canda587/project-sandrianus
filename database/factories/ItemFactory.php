<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'category_id' => mt_rand(1,3),
            'item_name' => $this->faker->sentence(mt_rand(1,3)),
            'item_description' => $this->faker->sentence(mt_rand(20,35)),
            'item_price' => 100000,
            'item_stock' => 100,
            'item_image' => "assets/images/img_situs/img3.jpg",
            'slug' => $this->faker->slug()
        ];
    }
}
