<?php

namespace Database\Factories\Store;

use App\Enums\Store\BookStatusEnum;
use App\Models\Store\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store\Book>
 */
class BookFactory extends Factory
{
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3),
            'author' => fake()->name(),
            'pages' => fake()->numberBetween(200, 1000),
            'price' => fake()->randomFloat(2, 10, 100),
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(BookStatusEnum::cases())->value,
        ];
    }
}
