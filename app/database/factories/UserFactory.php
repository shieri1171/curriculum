<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $imageDirectory = storage_path('app/public/icons');

        $imageFiles = array_diff(scandir($imageDirectory), array('..', '.'));

        return [
            'username' => $this->faker->userName,
            'email' => $this->faker->email,
            'password' => $this->faker->password,
            'image' => $this->faker->boolean(70)
                ? 'items/' . $imageFiles[array_rand($imageFiles)]
                : null,
            'profile' => $this->faker->paragraph,
            'name' => $this->faker->name,
            'tel' => $this->faker->phoneNumber,
            'postcode' => $this->faker->postcode,
            'address' => $this->faker->address,
        ];
    }
}