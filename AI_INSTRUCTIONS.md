# AI Instructions for Laravel 12 + Filament v4 Project

## Project Overview

This is a Laravel 12 application with Filament v4 admin panel, using PHP 8.4. The project demonstrates modern Laravel development practices with Filament's new schema-based approach.

## Technology Stack

- **Laravel**: 12.x
- **PHP**: 8.4
- **Filament**: 4.0
- **Database**: SQLite (development)
- **Frontend**: Vite + Livewire

## Project Structure

### Key Directories

```
app/
├── Enums/                    # PHP Enums (e.g., ProductsStatusEnum)
├── Filament/
│   ├── Resources/           # Filament v4 Resources with new schema structure
│   │   └── Products/
│   │       ├── Pages/       # Resource pages (List, Create, Edit)
│   │       ├── Schemas/     # Form schemas (new in v4)
│   │       └── Tables/      # Table configurations
│   └── Tables/             # Global table configurations
├── Models/                  # Eloquent models
└── Providers/              # Service providers
```

### Current Models

- **Product**: Main entity with name, price, description, category_id, status
- **Category**: Simple model with name field
- **User**: Laravel's default user model

### Current Enums

- **ProductsStatusEnum**: IN_STOCK, SOLD_OUT, COMING_SOON, INACTIVE

## Filament v4 Specific Guidelines

### Resource Structure

Filament v4 uses a new schema-based approach:

1. **Resource Class**: Main resource definition
2. **Form Schema**: Separate class for form configuration
3. **Table Configuration**: Separate class for table setup
4. **Pages**: Individual page classes for CRUD operations

### Example Resource Structure

```php
// ProductResource.php
class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    public static function form(Schema $schema): Schema
    {
        return ProductForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductsTable::configure($table);
    }
}
```

### Form Schema Pattern

```php
// ProductForm.php
class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                // Form fields here
            ]);
    }
}
```

### Table Configuration Pattern

```php
// ProductsTable.php
class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // Table columns here
            ])
            ->filters([
                // Filters here
            ]);
    }
}
```

## Development Guidelines

### Code Style

- Follow PSR-12 coding standards
- Use Laravel Pint for code formatting
- Follow Filament v4 conventions and patterns

### Database

- Use migrations for schema changes
- Use seeders for test data
- SQLite for development, configure for production

### Models

- Use Eloquent relationships properly
- Implement proper fillable arrays
- Use attribute casting for data types
- Leverage PHP 8.4 features (enums, attributes)

### Filament Resources

- Separate concerns: Resource, Form Schema, Table, Pages
- Use proper field types and validation
- Implement proper relationships in forms
- Use enums for status fields

## Common Tasks

### Adding a New Resource

1. Create model with migration
2. Create enum if needed for status fields
3. Generate Filament resource: `php artisan make:filament-resource ModelName`
4. Configure form schema in separate class
5. Configure table in separate class
6. Customize pages as needed

### Adding Fields to Existing Resource

1. Update model fillable array
2. Create/update migration
3. Update form schema
4. Update table configuration
5. Run migration

### Working with Enums

```php
// In form schema
Select::make('status')
    ->options(ProductsStatusEnum::class)
    ->required()

// In table
TextColumn::make('status')
    ->badge()
    ->color(fn (ProductsStatusEnum $state): string => match ($state) {
        ProductsStatusEnum::IN_STOCK => 'success',
        ProductsStatusEnum::SOLD_OUT => 'danger',
        ProductsStatusEnum::COMING_SOON => 'warning',
        ProductsStatusEnum::INACTIVE => 'gray',
    })
```

## Commands Reference

### Development

```bash
# Start development server
composer run dev

# Run tests
composer run test

# Code formatting
./vendor/bin/pint

# Clear caches
php artisan optimize:clear
```

### Filament Specific

```bash
# Create resource
php artisan make:filament-resource ModelName

# Create page
php artisan make:filament-page PageName

# Create widget
php artisan make:filament-widget WidgetName

# Upgrade Filament
php artisan filament:upgrade
```

### Database

```bash
# Run migrations
php artisan migrate

# Create migration
php artisan make:migration create_table_name

# Create seeder
php artisan make:seeder SeederName

# Run seeders
php artisan db:seed
```

## Best Practices

### Security

- Always validate user input
- Use proper authorization policies
- Sanitize data before database operations
- Use CSRF protection

### Performance

- Use eager loading for relationships
- Implement proper indexing
- Use database transactions for complex operations
- Cache frequently accessed data

### Code Organization

- Keep resources focused and single-purpose
- Use proper namespacing
- Separate business logic from presentation
- Follow SOLID principles

### Filament Specific

- Use proper field types for better UX
- Implement proper validation rules
- Use actions for complex operations
- Leverage Filament's built-in features

## Environment Setup

### Required Environment Variables

```env
APP_NAME="Filament v4 Course"
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://filament4-course.test

DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

FILAMENT_FILESYSTEM_DISK=public
```

### Admin Access

- URL: `http://filament4-course.test/admin`
- Create admin user: `php artisan make:filament-user`

## Troubleshooting

### Common Issues

1. **Filament not loading**: Check if admin user exists
2. **Database errors**: Ensure SQLite file exists and is writable
3. **Asset compilation**: Run `npm run dev` for frontend assets
4. **Cache issues**: Run `php artisan optimize:clear`

### Debug Tools

- Laravel Debugbar (enabled in development)
- Laravel Pail for log monitoring
- Filament's built-in debugging features

## Resources

- [Laravel 12 Documentation](https://laravel.com/docs/12.x)
- [Filament v4 Documentation](https://filamentphp.com/docs/4.x)
- [PHP 8.4 Features](https://www.php.net/releases/8.4/en.php)
- [Course Video](https://www.youtube.com/watch?v=GXsMX9gI-uI)

## Notes

- This project uses Filament v4's new schema-based approach
- Form and table configurations are separated into dedicated classes
- The project demonstrates modern Laravel and PHP 8.4 features
- SQLite is used for simplicity in development
- All Filament resources follow the new v4 structure and conventions
