<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Book;
use Illuminate\Database\Seeder;
use Database\Seeders\OrderDocTypeSeeder;
use Database\Seeders\ClientDocTypeSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Book::factory(30)->create();
        $this->call([
            ClientDocTypeSeeder::class,
            OrderDocTypeSeeder::class,
        ]);
    }
}
