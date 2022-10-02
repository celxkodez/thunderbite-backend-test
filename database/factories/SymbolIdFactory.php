<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SymbolId>
 */
class SymbolIdFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        //@todo return all entity to a faked data
        return [
            'name' => 'Apple Fruit',
            'image_url' => 'img/symbols-images/apple_fruit_eat.jpg',
            'match_point_3' => 3,
            'match_point_4' => 4,
            'match_point_5' => 5,
        ];
    }
}
