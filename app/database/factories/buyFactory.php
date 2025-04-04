<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BuyFactory extends Factory
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
            'item_id' => \App\Models\Item::inRandomOrder()->first()->id,
            'name' => $this->faker->name,
            'tel' => $this->faker->phoneNumber,
            'postcode' => $this->faker->postcode,
            'address' => $this->faker->address,
        ];
    }
}
