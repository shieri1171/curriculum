<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::inRandomOrder()->first()->id,
            'itemname' => $this->faker->word,
            'image' => $this->faker->image('storage/app/public/items', 1080, 1080, 'item', false),
            'price' => $this->faker->numberBetween(300, 99999),
            'presentation' => $this->faker->text,
            'state' => $this->faker->numberBetween(1, 6),
        ];
    }
}
