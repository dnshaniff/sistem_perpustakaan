<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\BookStock;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
        ]);

        Book::factory(20)->has(BookStock::factory(), 'stock')->create();
    }
}
