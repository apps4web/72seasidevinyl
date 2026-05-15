# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Commands

```bash
# Setup
composer install
npm install && npm run build
cp config/.env.example config/.env   # Set DB_* and SECURITY_SALT variables
bin/cake migrate run
bin/cake seed run                     # Seeds genres (idempotent)

# Development
npm run watch                         # Watch Tailwind CSS (app.css only)
bin/cake server                       # Dev server at 127.0.0.1:8765

# Testing & Analysis
composer check                        # Tests + coding standard (run before committing)
composer test                         # PHPUnit only
phpstan analyse                       # Level 8 type checking
vendor/bin/psalm                      # Level 2 type checking
composer cs-fix                       # Auto-fix coding standard violations

# Database
bin/cake migrations status
bin/cake migrate run
bin/cake seed run

# CSS build
npm run build                         # Tailwind app.css + copy FontAwesome + Tom Select assets
npm run build:css                     # Admin CSS only (admin.css)
npm run build:minify                  # Minified production build
```

To run a single test file: `vendor/bin/phpunit tests/TestCase/Controller/Admin/ReleasesControllerTest.php`

## Architecture

**Purpose**: E-commerce catalog + admin CMS for a Dutch vinyl record shop (72 Seaside Vinyl, Zierikzee).

**Stack**: CakePHP 5.3, PHP 8.2+, MySQL, Tailwind v4, FontAwesome Pro, Tom Select.

### Records vs. Releases — same table, two models

`RecordsTable` and `ReleasesTable` both map to the `records` database table (`$this->setTable('records')`). `ReleasesTable` is a lighter alias used in the admin CRUD — it has fewer associations and simpler validation. `RecordsTable` is the full model used in the public shop with all associations (Tracks, RecordImages, RecordSupplierImages, RecordVideos, RecordsArtists, Suppliers, Genres).

### Public shop flow

- `/platen` → `ShopController::index` — paginated catalog with search (`q`), artist, and genre filters
- `/platen/{id}` → `ShopController::record` — detail page with Tracks, RecordImages, RecordsArtists + Companies
- `/winkelwagen` → `BasketController` — session-based basket (no DB until checkout)
- `/reserveren` → `BasketController::checkout` — saves `Reservation` + `ReservationItems`, sends two emails via `ReservationMailer` (client confirmation + admin alert), then clears the basket

### Admin

All admin controllers live in `src/Controller/Admin/` and extend `Admin\AppController`, which loads `Authentication` and `Authorization` components and calls `$this->Authorization->authorize($this->request, 'access')` in `beforeFilter`.

`RequestPolicy::canAccess` gates the admin prefix: the route prefix is `Admin` (capital A) — only the login action is public. All other `/admin/*` routes require an authenticated user.

Admin routes use explicit named routes (`admin:releases:index`, `admin:releases:edit`, etc.) rather than convention fallbacks.

### Authorization pattern

Policy classes in `src/Policy/` define entity-level rules (`canView`, `canAdd`, `canEdit`, `canDelete`). Check user role via `$user->getOriginalData()->get('role')`. Role values: `'admin'` | `'customer'`.

### CMS models

`Pages` → `Sections` → `ContentBlocks` forms the CMS hierarchy for static content pages.

### Discogs integration

`calliostro/php-discogs-api` is used for fetching supplier/release data from Discogs. Related tables: `Suppliers`, `RecordsSuppliers` (join), `RecordSupplierImages`, and `RecordVideos`.

### Email

`ReservationMailer` sends HTML+text emails. Templates live in `templates/email/html/`. Logo is attached as inline CID (`seaside-logo`). Email failure does not block reservation saving — both `send()` calls are wrapped in try/catch.

Email config keys: `Contact.ownerEmail`, `Contact.fromEmail`, `Contact.fromName` (set via `.env`).

## Conventions

### Migrations

Use `autoId = false` with an explicit primary key declaration. Timestamp behavior is on by default. Reference `config/Migrations/20260328000000_InitialSchema.php` for the established pattern.

### Routing

- Public routes use Dutch URL slugs (`/platen`, `/winkelwagen`, `/reserveren`)
- Route class is `DashedRoute` (URL-to-controller inflection: `my-resource` → `MyResource`)
- Admin routes declare GET form routes before POST destructors

### Code style

- `declare(strict_types=1);` at the top of all PHP files
- Type hints required on all functions and class properties
- Controller return type is `void` (CakePHP convention; exception to PHPStan level 8)
- PHPStan level 8 + Psalm level 2 + CakePHP coding standard enforced via `composer check`

### Environment

Required `.env` keys: `SECURITY_SALT`, `DB_*` (or `DATABASE_URL`), `APP_NAME`, `DEBUG`.
Production only: `APP_FULL_BASE_URL` (prevents Host Header Injection — throws exception when unset in production mode).
Locale: `nl_NL`, Timezone: `Europe/Amsterdam`.

### Windows PowerShell

`Set-Content` creates UTF-16 LE BOM by default — PHP files starting with `declare(strict_types=1);` will fail to parse. Use the `Write` tool or `-Encoding ASCII` / `-Encoding utf8` when writing PHP files from PowerShell.
