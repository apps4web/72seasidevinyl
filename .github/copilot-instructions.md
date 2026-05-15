# 72 Seaside Vinyl — Project Guidelines

## Code Style

- **PHP**: PHPStan level 8 + Psalm level 2 + CakePHP coding standard. Run `composer check` before committing.
- **CSS/JS**: Tailwind v4 (utility-first); FontAwesome Pro icons; Tom Select for dropdowns. Build CSS via `npm run build`, watch via `npm run watch`.
- **Type hints**: Required on all functions and class properties. Use strict types with `declare(strict_types=1);` at the top of classes.
- **Controllers**: Return type `void` (CakePHP convention; exception to PHPStan level 8 rule).

**Check configuration files for specifics:**
- [phpstan.neon](phpstan.neon) (level 8)
- [psalm.xml](psalm.xml) (level 2)
- [phpcs.xml](phpcs.xml) (CakePHP standard)

## Architecture

**Purpose**: E-commerce catalog + admin CMS for vinyl record shop.

**Core models**:
- `Records` (and `Releases` alias) — vinyl inventory with BelongsToMany: Genres, HasMany: RecordImages
- `Artists` — performers with HasMany: Records
- `Genres` — music taxonomy with BelongsToMany: Records
- `Users` — admin accounts with `role` column (enum-like: 'admin' | 'customer')
- `Pages`, `Sections`, `ContentBlocks` — CMS structure

**Public routes** ([src/Controller/](src/Controller/)) — no auth required.  
**Admin routes** ([src/Controller/Admin/](src/Controller/Admin/)) — authentication + authorization via [src/Policy/](src/Policy/) classes (policy-per-entity pattern).

**See [README.md](README.md) for tech stack details.**

## Build and Test

```bash
# Full setup
composer install
npm install && npm run build
cp config\.env.example config\.env  # Set DB_* variables
bin/cake migrate run
bin/cake seed run                    # Optional: seed genres

# Development
npm run watch                        # CSS watch (background)
bin/cake server                      # Dev server at 127.0.0.1:8765

# Testing & Analysis
composer check                       # Tests + linting (recommended)
composer test                        # phpunit only
phpstan analyse                      # Level 8 type checking
vendor/bin/psalm                     # Level 2 type checking
phpcs --colors -p                    # Coding standard
```

## Conventions

**Migrations & Schema**:
- Use `autoId = false` with explicit primary key declaration (see [config/Migrations/20260328000000_InitialSchema.php](config/Migrations/20260328000000_InitialSchema.php))
- Timestamp behavior on tables by default; check existing migrations for pattern
- Run via `bin/cake migrate run`; status via `bin/cake migrations status`

**Seeds**:
- [GenresSeed.php](config/Seeds/GenresSeed.php) — 30+ vinyl genres with slugs
- Idempotent by design; safe to run repeatedly
- Run via `bin/cake seed run`

**Routing** ([config/routes.php](config/routes.php)):
- Public routes use `DashedRoute` class (URL case inflection: `my-resource` → `MyResource`)
- Admin routes use explicit named routes (`admin:releases:index`) instead of convention fallbacks
- GET forms declared before POST destructors

**Authorization**:
- Policy classes define entity-level rules: `canView()`, `canAdd()`, `canEdit()`, `canDelete()`
- Check user role via `$user->getOriginalData()->get('role')`
- All admin controllers load auth/authz in `beforeFilter` (see [src/Controller/Admin/AppController.php](src/Controller/Admin/AppController.php))

**Naming Conventions**:
- Controllers: `PluralController` (e.g., `RecordsController`)
- Tables: `PluralTable` (e.g., `RecordsTable`)
- Entities: `Singular` (e.g., `Record`)
- Views: `action.php` inside `templates/Controller/` folder
- Admin controllers: Under `src/Controller/Admin/` (scope via `/admin/` route prefix)

**Environment Setup**:
- .env file loaded in [config/bootstrap.php](config/bootstrap.php) via `josegonzalez/php-dotenv`
- Required: `SECURITY_SALT`, `DB_*` or `DATABASE_URL`, `APP_NAME`, `DEBUG`
- **Production only**: Set `APP_FULL_BASE_URL` (prevents Host Header Injection attacks)
- Locale: Dutch (`nl_NL`), Timezone: `Europe/Amsterdam`

**Windows PowerShell Gotcha**:
- `Set-Content` creates UTF-8 BOM by default; PHP scripts with `declare(strict_types=1);` may fail parsing
- Use `create_file` tool or `-Encoding ASCII` flag instead

## Quick Reference

| Task | Command |
|------|---------|
| Run all tests + lint | `composer check` |
| Run tests only | `composer test` |
| Fix code style | `composer cs-fix` |
| Watch CSS | `npm run watch` |
| Check migrations | `bin/cake migrations status` |
| Run migrations | `bin/cake migrate run` |
| Seed database | `bin/cake seed run` |
| Dev server | `bin/cake server` |
