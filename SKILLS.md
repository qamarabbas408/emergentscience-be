# SKILLS.md

## Project
Open-access journal platform. Laravel 12 API + Filament admin. React FE (separate repo). MySQL 9.

## Key Commands
```
php artisan serve | route:list | scramble:export | make:filament-resource <Model>
composer test  # phpunit
```

## API
- Routes: `routes/api/v{n}.php`, controllers: `app/Http/Controllers/Api/V{n}/`
- Resources: `app/Http/Resources/V{n}/`. Always use `JsonResource`, never hand-roll arrays.
- Response envelope: `ApiResponse` trait. Success: `{success, message, data, meta?}`. Failure: `{success: false, message, errors}`.
- Status: 200/201/204/401/403/404/422.
- Auth: Sanctum. Rate limit: throttle middleware on routes.
- Docs: Scramble at `/docs/api`. Export at `/docs/api/export`.

## Database
- MySQL 9, utf8mb4_unicode_ci. Migrations = source of truth.
- snake_case columns, explicit FK indices, ON DELETE RESTRICT default.
- Soft deletes on review/decision entities. UUID PKs on journal entities; int PKs on users/roles.
- Hierarchy: Discipline Category → Journal → Topics → Articles.

## Filament
- Panel: `/admin`, provider: `app/Providers/Filament/AdminPanelProvider.php`.
- Resources in `app/Filament/Resources/`. Pages in `app/Filament/Pages/`.

## Conventions
- No Blade UI for features. Backend API only.
- COPE: billing/APC fields hidden from editorial views (`apc_amount`, `apc_currency` not in public API).
- Validate via FormRequest. Controllers thin.

## Troubleshooting
- **Filament `getOriginal() on int`**: `->unique(Model, 'slug', fn($r) => $r?->id)` → use `->unique(Model, 'slug', ignoreRecord: true)`. Callback returning int breaks Filament v3 validation. Check ALL unique rules in all resources.

## Token Rules
- Parallel file reads. Grep before reading. Use offsets. Never re-read seen files. Terse output.
