<?php

namespace Tests\Feature\Store;

use App\Enums\Store\BookStatusEnum;
use App\Models\Store\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create and authenticate a user for each test
        $user = User::factory()->create();
        Sanctum::actingAs($user);
    }

    public function test_can_list_books(): void
    {
        Book::factory(5)->create();

        $response = $this->getJson('/api/books');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'author',
                        'pages',
                        'price',
                        'description',
                        'status',
                        'created_at',
                        'updated_at',
                    ],
                ],
                'meta' => [
                    'current_page',
                    'last_page',
                    'per_page',
                    'total',
                ],
                'links' => [
                    'first',
                    'last',
                    'prev',
                    'next',
                ],
            ]);
    }

    public function test_can_search_books_by_name(): void
    {
        Book::factory()->create(['name' => 'The Great Gatsby']);
        Book::factory()->create(['name' => 'To Kill a Mockingbird']);

        $response = $this->getJson('/api/books?name=Gatsby');

        $response->assertStatus(200);
        $this->assertCount(1, $response->json('data'));
        $this->assertEquals('The Great Gatsby', $response->json('data.0.name'));
    }

    public function test_can_search_books_by_author(): void
    {
        Book::factory()->create(['author' => 'F. Scott Fitzgerald']);
        Book::factory()->create(['author' => 'Harper Lee']);

        $response = $this->getJson('/api/books?author=Fitzgerald');

        $response->assertStatus(200);
        $this->assertCount(1, $response->json('data'));
        $this->assertEquals('F. Scott Fitzgerald', $response->json('data.0.author'));
    }

    public function test_can_search_books_by_pages(): void
    {
        Book::factory()->create(['pages' => 300]);
        Book::factory()->create(['pages' => 500]);

        $response = $this->getJson('/api/books?pages=300');

        $response->assertStatus(200);
        $this->assertCount(1, $response->json('data'));
        $this->assertEquals(300, $response->json('data.0.pages'));
    }

    public function test_can_search_books_by_status(): void
    {
        Book::factory()->create(['status' => BookStatusEnum::ACTIVE->value]);
        Book::factory()->create(['status' => BookStatusEnum::OUT_OF_STOCK->value]);

        $response = $this->getJson('/api/books?status=' . BookStatusEnum::ACTIVE->value);

        $response->assertStatus(200);
        $this->assertCount(1, $response->json('data'));
        $this->assertEquals(BookStatusEnum::ACTIVE->value, $response->json('data.0.status'));
    }

    public function test_can_show_single_book(): void
    {
        $book = Book::factory()->create();

        $response = $this->getJson("/api/books/{$book->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'author',
                    'pages',
                    'price',
                    'description',
                    'status',
                    'created_at',
                    'updated_at',
                ],
            ])
            ->assertJson([
                'data' => [
                    'id' => $book->id,
                    'name' => $book->name,
                    'author' => $book->author,
                    'pages' => $book->pages,
                    'price' => $book->price,
                    'description' => $book->description,
                    'status' => $book->status,
                ],
            ]);
    }

    public function test_can_create_book(): void
    {
        $bookData = [
            'name' => 'Test Book',
            'author' => 'Test Author',
            'pages' => 300,
            'price' => 29.99,
            'description' => 'A test book description',
            'status' => BookStatusEnum::ACTIVE->value,
        ];

        $response = $this->postJson('/api/books', $bookData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'name',
                    'author',
                    'pages',
                    'price',
                    'description',
                    'status',
                    'created_at',
                    'updated_at',
                ],
            ]);

        $this->assertDatabaseHas('books', [
            'name' => 'Test Book',
            'author' => 'Test Author',
            'pages' => 300,
            'price' => 29.99,
            'description' => 'A test book description',
            'status' => BookStatusEnum::ACTIVE->value,
        ]);
    }

    public function test_can_update_book(): void
    {
        $book = Book::factory()->create();

        $updateData = [
            'name' => 'Updated Book Name',
            'author' => 'Updated Author',
            'pages' => 400,
            'price' => 39.99,
            'description' => 'Updated description',
            'status' => BookStatusEnum::OUT_OF_STOCK->value,
        ];

        $response = $this->putJson("/api/books/{$book->id}", $updateData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'name',
                    'author',
                    'pages',
                    'price',
                    'description',
                    'status',
                    'created_at',
                    'updated_at',
                ],
            ]);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'name' => 'Updated Book Name',
            'author' => 'Updated Author',
            'pages' => 400,
            'price' => 39.99,
            'description' => 'Updated description',
            'status' => BookStatusEnum::OUT_OF_STOCK->value,
        ]);
    }

    public function test_can_delete_book(): void
    {
        $book = Book::factory()->create();

        $response = $this->deleteJson("/api/books/{$book->id}");

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Book deleted successfully',
            ]);

        $this->assertSoftDeleted('books', [
            'id' => $book->id,
        ]);
    }

    public function test_validation_errors_on_create(): void
    {
        $response = $this->postJson('/api/books', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'name',
                'author',
                'pages',
                'price',
                'description',
                'status',
            ]);
    }

    public function test_validation_errors_on_update(): void
    {
        $book = Book::factory()->create();

        $response = $this->putJson("/api/books/{$book->id}", []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'name',
                'author',
                'pages',
                'price',
                'description',
                'status',
            ]);
    }

    public function test_returns_404_for_nonexistent_book(): void
    {
        $response = $this->getJson('/api/books/999');

        $response->assertStatus(404);
    }
}
