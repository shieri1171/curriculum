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
        return [
            'username' => $this->faker->userName,
            'email' => $this->faker->email,
            'password' => $this->faker->password,
            'image' => $this->faker->boolean(70)
                ? $this->faker->image('storage/app/public/icons', 1080, 1080, 'icon', false)
                : 'no_image.jpg',
            'profile' => $this->faker->paragraph,
            'name' => $this->faker->name,
            'tel' => $this->faker->phoneNumber,
            'postcode' => $this->faker->postcode,
            'address' => $this->faker->address,
        ];
    }
}
