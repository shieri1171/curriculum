<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // $this->call(UsersTableSeeder::class);
        $this->call(ItemsTableSeeder::class);
        // $this->call(BuysTableSeeder::class);
        // $this->call(favoritesTableSeeder::class);
        // $this->call(followsTableSeeder::class);
        // $this->call(CommentsTableSeeder::class);
    }
}
