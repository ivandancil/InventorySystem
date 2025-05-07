<?php

namespace Database\Factories;

use App\Models\InventoryItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class InventoryItemFactory extends Factory
{
    protected $model = InventoryItem::class;

    public function definition(): array
    {
        $price_php = $this->faker->randomFloat(2, 100, 10000);

        return [
            'name' => $this->faker->word(),
            'quantity' => $this->faker->numberBetween(1, 100),
            'price_php' => $price_php,
            'category' => $this->faker->randomElement(['Electronics', 'Furniture', 'Clothing', 'Toys']),
            'description' => $this->faker->sentence(),
        ];
    }
}
