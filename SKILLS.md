# SKILLS.md

Project knowledge and conventions for working in this repository.

## Project

Emerging Science — an open-access journal submission, peer-review, and production platform. Backend is Laravel (APIs only); the public UI is a separate React app maintained by the FE developer; the internal admin panel is Filament.

## Architecture

- **Laravel 12** serves as a pure API backend (`/api`).
- **API versioning**: URI-prefix versioning. Route groups live in `routes/api/v{n}.php`, included from `routes/api.php`. Controllers live in `app/Http/Controllers/Api/V{n}/`.
- **API docs**: Scramble auto-generates OpenAPI docs from code, served at `/docs/api`. Regenerate export with `php artisan scramble:export`.
- **Admin panel**: Filament PHP at `/admin`, panel provider at `app/Providers/Filament/AdminPanelProvider.php`.
- **Static landing page**: `/` renders `resources/views/landing.blade.php` (placeholder until the React app takes over).
- **Health check**: Laravel's built-in `/up` + `api/v1/health`.

## Commands

```bash
php artisan serve
php artisan route:list
php artisan scramble:export
php artisan make:filament-resource <Model>
composer test        # runs phpunit
```

## Conventions

- Backend only; no Blade UI for features — the React app is the public UI.
- Add new API endpoints under the appropriate `routes/api/v{n}.php` + `Api\V{n}` controller namespace.
- Keep billing/APC data permissioned away from editorial-decision views (COPE requirement — see `requirements.md`).
- Core domain entities (from `requirements.md` §7): journals, sections, special_issues, topics, manuscripts, reviews, decisions, conflicts_of_interest, apc_invoices, appeals, production_assets.

## Reference

- Full product research/requirements: `requirements.md`
- Admin login (local dev): `admin@emergingscience.dev` / `password`
