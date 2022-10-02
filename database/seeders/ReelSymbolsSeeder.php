<?php

namespace Database\Seeders;

use App\Models\SymbolId;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class ReelSymbolsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $symbolsIDs = [
            [
                'name' => 'Mango',
                'image_url' => 'img/symbols-images/mango_pelican_fruit.jpg',
                'match_point_3' => 3,
                'match_point_4' => 4,
                'match_point_5' => 5,
            ],
            [
                'name' => 'Citrus',
                'image_url' => 'img/symbols-images/mandarin_citrus_fruit_citrus_fruits.jpg',
                'match_point_3' => 3,
                'match_point_4' => 4,
                'match_point_5' => 5,
            ],
            [
                'name' => 'Cherries',
                'image_url' => 'img/symbols-images/cherries_pulp_sliced.jpg',
                'match_point_3' => 3,
                'match_point_4' => 4,
                'match_point_5' => 5,
            ],
            [
                'name' => 'Dogwood Fruits',
                'image_url' => 'img/symbols-images/asian_dogwood_fruits_red.jpg',
                'match_point_3' => 3,
                'match_point_4' => 4,
                'match_point_5' => 5,
            ],
            [
                'name' => 'Guava Fruit',
                'image_url' => 'img/symbols-images/guava_fruit_green_fruit.jpg',
                'match_point_3' => 3,
                'match_point_4' => 4,
                'match_point_5' => 5,
            ],
            [
                'name' => 'Cherries Tree',
                'image_url' => 'img/symbols-images/cherries_tree_red.jpg',
                'match_point_3' => 3,
                'match_point_4' => 4,
                'match_point_5' => 5,
            ],
            [
                'name' => 'Dragon Fruit',
                'image_url' => 'img/symbols-images/dragon_fruit_pitahaya_pitaya.jpg',
                'match_point_3' => 3,
                'match_point_4' => 4,
                'match_point_5' => 5,
            ],
            [
                'name' => 'Apple Fruit',
                'image_url' => 'img/symbols-images/apple_fruit_eat.jpg',
                'match_point_3' => 3,
                'match_point_4' => 4,
                'match_point_5' => 5,
            ],
            [
                'name' => 'Strawberry',
                'image_url' => 'img/symbols-images/strawberry_tasty_frisch.jpg',
                'match_point_3' => 3,
                'match_point_4' => 4,
                'match_point_5' => 5,
            ],
        ];

        SymbolId::factory()
            ->count(count($symbolsIDs))
            ->state(new Sequence(...$symbolsIDs))
            ->create();
    }
}
