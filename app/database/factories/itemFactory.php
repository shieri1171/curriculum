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
        $imageDirectory = storage_path('app/public/items');

        $imageFiles = array_diff(scandir($imageDirectory), array('..', '.'));
        $imageFile = $imageFiles[array_rand($imageFiles)];

        return [
            'user_id' => \App\Models\User::inRandomOrder()->first()->id,
            'itemname' => $this->faker->word,
            'image' => 'items/' . $imageFile,
            'price' => $this->faker->numberBetween(300, 99999),
            'presentation' => $this->faker->text,
            'state' => $this->faker->numberBetween(1, 6),
        ];
    }
}
