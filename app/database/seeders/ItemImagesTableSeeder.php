<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\ItemImage;

class ItemImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = Item::all();

        foreach ($items as $item) {
            $imageCount = rand(1, 5);

            for ($i = 0; $i < $imageCount; $i++) {
                ItemImage::factory()->create([
                    'item_id' => $item->id,
                    'mainflg' => $i === 0,
                ]);
            }
        }
    }
}
