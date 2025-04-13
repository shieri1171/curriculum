<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Item;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ItemImage>
 */
class ItemImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $item = Item::inRandomOrder()->first();

        $imageDirectory = storage_path('app/public/items');
        $imageFiles = array_diff(scandir($imageDirectory), array('..', '.'));
        $imageFile = $imageFiles[array_rand($imageFiles)];

        return [
            'item_id' => $item->id ?? 1, // fallback
            'image_path' => 'items/' . $imageFile,
            'mainflg' => 0,
        ];
    }
}
