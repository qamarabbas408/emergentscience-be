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
- Core domain entities: discipline_categories, journals, topics, special_issues, manuscripts, reviews, decisions, conflicts_of_interest, apc_invoices, appeals, production_assets. Hierarchy: Discipline Category → Journal → Topics → Manuscripts (Frontiers-style, no sections).

## Laravel API Standards

- **API-first**: the `/api` layer is consumed by the React public UI and Filament admin panel; business logic lives in services/repositories, not controllers.
- **Versioning**: URI-prefix versioning via `routes/api/v{n}.php` + `Api\V{n}` controller namespaces — never break an existing versioned contract.
- **Resources, not arrays**: return `JsonResource`/`ResourceCollection` instances (e.g. `V1\UserResource`); never hand-roll response arrays or sprinkle `toArray` over models.
- **Validation via FormRequest**: use dedicated `FormRequest` classes for request validation + authorization; keep controllers thin.
- **Error contracts**: use `ApiResponder` trait + `ApiResponse` class so all errors follow `{"ok": false, "error": "...", "errors": {...}}` with consistent HTTP status mapping.
- **Status codes**: 200 (read/update), 201 (created with `Location` header), 204 (delete), 401 (unauthenticated), 403 (forbidden), 404 (not found), 422 (validation).
- **HTTP semantics**: `GET` is safe & idempotent; `POST` creates; `PUT` full replace; `PATCH` partial. Return `204 No Content` for successful delete.
- **Security**: Sanctum bearer-token auth on protected routes; tokens hashed in DB with hashed random 40-char strings; no tokens in responses/logs; password hashing via `bcrypt`.
- **Rate limiting**: version auth routes (`throttle:5,1` login/`throttle:10,1` register, etc.); extend `throttles` for sensitive writes.
- **Paginated responses**: `ResourceCollection` with `AbstractResource::pagination()`; clients may pass `?page=N` only.

## Database

- **MySQL 9** (utf8mb4, `utf8mb4_unicode_ci`). Migrations are the source of truth — no raw SQL in app code.
- **Eloquent relationships** via `hasManyThrough`/`hasMorphMany`/scoped relations; avoid N+1 (eager-load with `withCount`/constraints or `@covers` queries in tests).
- **Normalization**: keep transactional entities to 3NF; denormalize only behind CQRS for reads. Journals→Sections, Manuscripts→Reviews, Appeals, ProductionAssets, ApcInvoices — use FK constraints (no `SET NULL` unless strictly required; cascade soft-delete via `CascadeSoftDeletes` trait).
- **Soft deletes** (`SoftDeletes` trait) on manuscripts/reviews/decisions/appeals/apc invoices — audit trail over hard deletes.
- **UUID keys**: PKs are `uuid` on all journal entities (manuscripts/reviews/etc.) for safe cross-instance merges; `users`/`roles` stay unsigned-int/Bigint for Laravel/Sanctum simplicity.
- **Conventions**: snake_case columns, explicit FK indices, `ON DELETE RESTRICT` defaults, avoid reserved words (`status`, `order`, `type`) — alias them.

## Reference

- Full product research/requirements: `requirements.md`
- Admin login (local dev): `admin@example.com` / `admin`

## Minimize token usage to preserve context

- Keep responses terse and direct.
- Read files in parallel batches rather than one at a time.
- Read only the specific files/lines needed instead of whole files.
- Prefer targeted `grep`/`rg` for spot-checks over full reads.
- Avoid re-reading files already seen this session.
- When output is long, use offsets to read only the changed regions.

# Learning Goals

- Get productive in Laravel 12 (current version).
- Internalize the API standards.
- Internalize the database conventions.
- Apply them to this codebase without drifting.
