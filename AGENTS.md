# AGENTS.md

## High-Level Purpose

A Laravel 12 + Filament v4 course application showing schema-based Filament Forms/Tables, Inertia+React SPA frontend, and AI integrations (Ollama, OpenAI, Bedrock). Primary dev language is English; some Portuguese appears in domain code/comments.

## Key Technology Versions

- PHP 8.4.x (runs on 8.2+)
- Laravel 12.x
- Filament 4.0 (schema-based Forms & Tables)
- Inertia v2 + React 19 + Tailwind CSS 4
- SQLite by default (configurable for other DBs)

## Developer Commands

```bash
# Start dev server, queue listener, and Vite concurrently
composer run dev

# Build frontend
npm run build

# Run all tests
php artisan test --compact

# Run a single test file
php artisan test --compact tests/Feature/Store/BookTest.php

# Run a specific test
php artisan test --compact --filter=testName

# Code formatting
./vendor/bin/pint --dirty --format agent

# Clear caches
php artisan optimize:clear
```

## Architecture & Entrypoints

### Filament v4 Admin Panel
- URL: `/admin`
- Panel provider: `app/Providers/Filament/AdminPanelProvider.php`
- Resources live under `app/Filament/Resources/`
- **v4 Schema Pattern**: Each resource delegates to a dedicated class:
  - **Form**: `App\Filament\Resources\{Resource}\Schemas\{Resource}Form::configure(Schema)`
  - **Table**: `App\Filament\Resources\{Resource}\Tables\{Resource}Table::configure(Table)`
  - **Pages**: `App\Filament\Resources\{Resource}\Pages\*`
- Current example: `ProductResource` → `ProductForm`, `ProductsTable`
- Generating resources: `php artisan make:filament-resource {ModelName}`
- Upgrade hook: `post-autoload-dump` includes `filament:upgrade`

### Inertia + React SPA
- Entry: `resources/js/app.jsx` (resolves `resources/js/Pages/**/*.jsx`)
- Vite config: `vite.config.js` (React + Tailwind v4 plugins)
- Layout: `resources/views/app.blade.php`
- Pages: `resources/js/Pages/` (e.g., `Welcome.jsx`, `Books/Index.jsx`)
- Navigation: use `router.visit()` or `<Link>` from `@inertiajs/react`

### Routes & Areas
- `routes/web.php`: Main web routes (Inertia SPA pages, book resource, public routes)
- `routes/api.php`: API routes
- Sub-route files (loaded via `require` in `web.php`):
  - `routes/admin/admin_routes.php`
  - `routes/glpi/glpi_routes.php`
  - `routes/sqlserver/sqlserver_routes.php`
  - `routes/api/ai/{ollama,openai,bedrock}_routes.php`
  - `routes/api/store/book_routes.php`

### Models
- `Product`, `Category` (Filament-managed)
- `Book` (Store SPA)
- `User` (default Laravel + Filament auth)
- `Glpi/ControleGlpi`, `SqlServer/SqlServerModel`, `SugestaoVinculacao/SugestVincCacheCall`

### AI Integrations
- **Ollama**: `cloudstudio/ollama-laravel`
- **OpenAI**: `openai-php/laravel`
- **Bedrock**: `prism-php/bedrock`

## Laravel 12 Structure Notes

- Middleware registered in `bootstrap/app.php` (`withMiddleware()`), not `app/Http/Kernel.php`
- `app/Console/Kernel.php` does not exist; use `bootstrap/app.php` or `routes/console.php`
- Service providers auto-discovered; `bootstrap/providers.php` holds app-specific ones
- Casts should live in a `casts()` method on models

## Testing

- Framework: PHPUnit 11 (not Pest)
- Create tests with: `php artisan make:test --phpunit {name}` (or `--unit` for unit tests)
- Uses `phpunit.xml` with SQLite `:memory:` for tests

## Code Style

- Run `vendor/bin/pint --dirty --format agent` before finalizing changes
- PHP 8 constructor property promotion, explicit return types, `declare(strict_types=1)`
- Follow existing sibling files for conventions

## Environment & Secrets

- Default DB: SQLite (`DB_CONNECTION=sqlite`)
- AI keys/config loaded via `.env`:
  - `OLLAMA_MODEL`, `OLLAMA_URL`
  - `OPENAI_API_KEY`
  - `AWS_ACCESS_KEY_ID`, `AWS_SECRET_ACCESS_KEY`, `AWS_BEDROCK_MODEL`
- Never commit `.env` or real credentials

## Existing Instruction Sources

- `CLAUDE.md`: Laravel Boost / ecosystem rules, package versions, search-docs guidance
- `.github/copilot-instructions.md`: Same as `CLAUDE.md`
- `.ai/skills/php-best-practices/AGENTS.md`: General PHP best practices (PSR, strict types, etc.)
