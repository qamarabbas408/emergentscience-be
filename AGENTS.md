# Emerging Science Backend — Session Context

## Project Overview
Laravel 12 API + Filament 3.3 admin panel for an open-access academic journal platform (Frontiers-style hierarchy).

## Stack
- Laravel 12, PHP 8.5, Sanctum 4.3, MySQL 9 (socket `/tmp/mysql.sock`), Filament v3.3
- Tests: PHPUnit with SQLite in-memory
- Remote: `https://github.com/qamarabbas408/emergentscience-be.git`

## Key Conventions
- API versioning: URI-prefix (`/api/v1/`), routes in `routes/api/v1.php`
- Standardized response envelope: `{ success, message, data, meta?, facets? }` via `ApiResponse` trait
- Admin login: `admin@example.com` / `admin`
- FE only needs public GET APIs; all writes via Filament admin panel
- Filament `unique()` bug fix: `ignoreRecord: true` required
- User directive: "don't add commits unless i say so"

## Database Hierarchy
Discipline Category → Journal → Topics → Articles

## Completed Features

### Auth & Users
- Register, login, logout, me — Sanctum
- Unified User model with role-based profiles (Author, Reviewer, Editor)

### Journals
- Full CRUD in Filament, public GET API
- Many-to-many with Discipline Categories via `discipline_category_journal`
- Many-to-many with Topics via `journal_topics`
- Paginated with `articles_count`, `topics_count` per journal

### Topics
- Many-to-many with Journals (no direct FK)
- Standalone API: `GET /topics`, `GET /topics/{slug}`, `GET /topics/{slug}/articles`
- Paginated with `submission_deadline` (date), `article_count`, `journals[]` array
- Discipline facets: always returns all categories, zero-count included
- Cross-filter: facets exclude own filter (same semantics as articles API)

### Articles
- Paginated with facets (journals, article_types)
- Multi-select filters: `?journal=a,b`, `?type=x,y`
- Publication date filters: `?published_from=`, `?published_to=`
- Includes journal, article_type, topics[], authors[]

### Article Types
- 8 seeded types with `file_requirements` (JSON editor + Reviewer Materials in Filament)
- ArticleTypeResource with 3-section file requirements UI

### File Upload System
- Submissions table (status: draft/submitted/under_review/revision_required/accepted/rejected)
- `article_files`: `submission_id` FK, `storage_path`, `original_name`, `file_type` (manuscript/cover_letter/data/figure/reviewer_materials)

### Discipline Categories
- 20 seeded categories
- Public API with facets

### Filament Resources
- JournalResource, TopicResource, ArticleResource, ArticleTypeResource, DisciplineCategoryResource
- UserResource with tabs (Core Profile, Author/Reviewer/Editor via relation managers)

## Important Files
- `app/Http/Controllers/Api/V1/ArticleController.php` — refactored with applyFilters/applySort/buildFacets/parseSlugs
- `app/Http/Controllers/Api/V1/TopicController.php` — paginated with discipline facets via LEFT JOIN
- `app/Http/Controllers/Api/V1/JournalController.php` — paginated with articles_count/topics_count
- `app/Http/Controllers/ApiResponse.php` — success() and paginated() accept optional $facets
- `app/Models/User.php` — authorProfile(), reviewerProfile(), editorProfile()
- `app/Http/Resources/V1/TopicResource.php` — includes journals[], submission_deadline, article_count
- `app/Http/Resources/V1/JournalResource.php` — includes articles_count, topics_count
- `public/docs/api-export/export.html` — API export UI

## SQLite Compatibility
- Migrations that modify columns: skip on SQLite (use `isSQLite()` helper)
- Tests use SQLite in-memory; ENUM/MODIFY operations must be guarded

## Agent Instructions
- Run `php artisan test` to verify changes
- Run `php artisan migrate:fresh --seed` to reset database
- Check existing code patterns before adding new features
- Never commit secrets or keys
