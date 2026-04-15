# 72 Seaside Vinyl

App for 72 Seaside Vinyl in Zierikzee

## Tech Stack

- **[CakePHP 5](https://cakephp.org/)** (5.3.x) — PHP web framework
- **[Tailwind CSS v4](https://tailwindcss.com/)** — Utility-first CSS framework

## Requirements

- PHP 8.2+
- Composer
- Node.js & npm

## Installation

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies and build CSS
npm install
npm run build
```

Create `config/.env` from `config/.env.example` and set the database variables before loading the app:

```bash
copy config\\.env.example config\\.env
```

Required database settings in `config/.env`:

```bash
export DB_HOST="127.0.0.1"
export DB_PORT="3306"
export DB_USERNAME="root"
export DB_PASSWORD=""
export DB_DATABASE="72seasidevinyl"
```

Optional test database settings:

```bash
export DB_TEST_HOST="127.0.0.1"
export DB_TEST_PORT="3306"
export DB_TEST_USERNAME="root"
export DB_TEST_PASSWORD=""
export DB_TEST_DATABASE="72seasidevinyl_test"
```

You can still use `DATABASE_URL` and `DATABASE_TEST_URL` instead of the granular `DB_*` variables if you prefer a DSN-style configuration.

## Development

```bash
# Watch for CSS changes during development
npm run watch
```

## Build

```bash
# Build and minify CSS for production
npm run build:minify
```
