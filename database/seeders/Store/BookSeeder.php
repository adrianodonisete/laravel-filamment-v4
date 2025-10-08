<?php

namespace Database\Seeders\Store;

use App\Models\Store\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::factory(50)->create();
    }
}
