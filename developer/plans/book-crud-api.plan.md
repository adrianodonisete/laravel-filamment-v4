<!-- d5e5bbac-ef9d-41de-9f68-2ea2e6b975e2 0b4c0947-0d39-48a6-8b9a-750bef2f8385 -->
# Book CRUD API Implementation Plan

## Overview

Create a complete Book CRUD API with authentication, validation, search, and tests following Laravel 12 best practices.

## 1. Model and Database

### Create Book Model with Migration

- Use `php artisan make:model` to create `app/Models/Store/Book.php` with migration
- Add fields: id, name, author, pages, price, description, status
- Enable soft deletes with `SoftDeletes` trait
- Add `softDeletes()` in migration
- Set timestamps

### Add Casts and Accessors

- Implement `casts()` method for id (integer), pages (integer), price (decimal:10,2)
- Create `name()` and `author()` Attribute accessors using `Str::title()` to capitalize words
- Follow pattern from `app/Models/Product.php` (lines 20-33)

## 2. Enum

### Create BookStatusEnum

- Create `app/Enums/Store/BookStatusEnum.php`
- Define string-backed enum with cases: ACTIVE, OUT_OF_STOCK, INACTIVE
- Follow pattern from `app/Enums/ProductsStatusEnum.php`

## 3. API Resources

### Create BookResource

- Create `app/Http/Resources/Api/Store/BookResource.php`
- Include all fields: id, name, author, pages, price, description, status
- Format status using the enum value

## 4. Form Requests

### Create Validation Requests

- Create `app/Http/Requests/Store/StoreBookRequest.php`:
- name: required, string, max:255
- author: required, string, max:255
- pages: required, integer, min:1
- price: required, decimal:10,2, min:0
- description: required, string
- status: required, enum validation with `Rule::enum(BookStatusEnum::class)`
- Add pt-BR messages following pattern from `app/Http/Requests/Glpi/CreateControleGlpiRequest.php`

- Create `app/Http/Requests/Store/UpdateBookRequest.php`:
- Same validation as StoreBookRequest
- Add pt-BR messages

## 5. Controller

### Create BookController

- Create `app/Http/Controllers/Api/Store/BookController.php`
- Implement REST methods:
- `index()`: List books with search filtering and pagination (15 per page)
  - Filter by name (LIKE query)
  - Filter by pages, price, status (exact match)
  - Return `BookResource::collection()` with pagination meta/links
- `show()`: Return single book (404 if not found)
- `store()`: Create new book (201 status)
- `update()`: Update existing book (200 status)
- `destroy()`: Soft delete book (200 status)
- Return proper HTTP status codes: 200, 201, 404, 422, 400, 500
- Use Form Requests for validation
- Return JSON responses using BookResource

## 6. Routes

### Create API Routes

- Create `routes/api/store/book_routes.php`
- Define resourceful routes for BookController
- Apply `auth:sanctum` middleware to all routes
- Include route file in `routes/api.php` (follow pattern from existing structure)

## 7. Factory and Seeder

### Create BookFactory

- Create `database/factories/Store/BookFactory.php`
- Define faker data:
- name: `$this->faker->sentence(3)`
- author: `$this->faker->name()`
- pages: `$this->faker->numberBetween(200, 1000)`
- price: `$this->faker->randomFloat(2, 10, 100)`
- description: `$this->faker->paragraph()`
- status: `$this->faker->randomElement(BookStatusEnum::cases())`
- Follow pattern from `database/factories/UserFactory.php` using `fake()` helper

### Create BookSeeder

- Create `database/seeders/Store/BookSeeder.php`
- Generate 50 books using BookFactory

## 8. Tests

### Create PHPUnit Feature Tests

- Create `tests/Feature/Store/BookTest.php`
- Use PHPUnit (not Pest) following project convention
- Test all CRUD operations:
- Test index with pagination and search filters
- Test show (success and 404)
- Test store (success and validation errors)
- Test update (success and validation errors)
- Test destroy (soft delete)
- Use `RefreshDatabase` trait
- Create authenticated user with Sanctum token for each test
- Use `$this->actingAs($user, 'sanctum')` or token-based authentication
- Assert proper HTTP status codes and JSON structure
- Run tests after creation to verify functionality

## 9. Final Steps

- Run migration to create books table
- Run seeder to populate test data
- Run Pint to format all new code: `vendor/bin/pint --dirty`
- Run tests to verify everything works: `php artisan test --filter=BookTest`

### To-dos

- [ ] Create Book model with migration including all fields and soft deletes
- [ ] Create BookStatusEnum with ACTIVE, OUT_OF_STOCK, INACTIVE cases
- [ ] Create BookResource for formatting API responses
- [ ] Create StoreBookRequest and UpdateBookRequest with validation and pt-BR messages
- [ ] Create BookController with CRUD methods, search, and pagination
- [ ] Create book_routes.php and register in api.php with Sanctum auth
- [ ] Create BookFactory and BookSeeder with realistic test data
- [ ] Create PHPUnit feature tests for all CRUD operations with authentication
- [ ] Run migration and seeder to populate database
- [ ] Run Pint for code formatting and execute tests

