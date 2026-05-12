# toko-online

Laravel 13 + SQLite + Tailwind CSS v4 + Vite.

## Commands

| Command | What it does |
|---|---|
| `composer setup` | Full project setup (install, .env, key, migrate, npm i, build) |
| `composer dev` | Run all dev services (serve, queue, logs, vite) via concurrently |
| `composer test` | `config:clear` then `artisan test` — use this instead of raw `phpunit` |
| `php artisan migrate` | Run migrations (SQLite at `database/database.sqlite`) |
| `npx pint` | Laravel Pint code style fixer |

## Architecture

- **DB:** SQLite only. Session, cache, and queue all use `database` driver — related migrations exist.
- **Tests:** Use `:memory:` SQLite. No external DB needed.
- **Frontend:** Vite entrypoints `resources/css/app.css` + `resources/js/app.js`. Tailwind v4 via `@tailwindcss/vite` plugin — no `tailwind.config.js`.
- **Font:** Instrument Sans via Bunny CDN, configured in `vite.config.js`.
- **Models:** Modern PHP 8 attributes (`#[Fillable]`, `#[Hidden]`) instead of `$fillable`/`$hidden` properties.
- **.npmrc** has `ignore-scripts=true` — npm lifecycle scripts won't run automatically.

## Structure

- `app/Http/Controllers/` — controllers
- `app/Models/` — Eloquent models
- `app/Providers/` — service providers
- `routes/web.php` + `routes/console.php` — route files
- `resources/views/` — Blade templates
- `tests/Unit/`, `tests/Feature/` — PHPUnit tests
- `database/migrations/`, `database/factories/`, `database/seeders/` — DB layer
