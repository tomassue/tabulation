# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Purpose

Competition tabulation system supporting multiple event types: Quiz Bee, Oral Presentation, Poster, and Higalaay (dance). It handles judge management, participant scoring with deductions, rankings, PDF reports, LED wall display, and a Sanctum-based API for mobile sync.

## Commands

```bash
# Start development (serves + queue + logs + vite)
composer run dev

# Run tests
composer test
# Or directly:
php artisan test
php artisan test --filter=ExampleTest

# Build frontend assets
npm run build
npm run dev

# Database
php artisan migrate
php artisan db:seed
php artisan migrate:fresh --seed
```

## Architecture

### Stack
- **Laravel 12** with **Livewire 3** for reactive UI (primary UI framework)
- **Blade templates** with Bootstrap 5 + jQuery 3.7
- **Vite** with Tailwind CSS 4 and Sass (Tailwind configured but not actively used in views)
- **DomPDF** for PDF report generation
- **Maatwebsite/Excel** for Higalaay data import/export
- **Laravel Sanctum** for API auth (mobile app integration)
- SQLite for development; queue/cache/session driver: database

### Event Types and Their Models
Each competition event has its own model and Livewire component:
- **Quiz Bee**: `QuizBee` model (participant, round, question_number, score)
- **Oral**: `Oral` model (participant, judge, score) + `OralDeduction`
- **Poster**: `Poster` model (participant, judge, score) + `PosterOutput`
- **Higalaay**: `Higalaay` model (participant, criteria, judge, score) + `HigalaayDeduction` — the most complex event with criteria-based multi-judge scoring

### Scoring Architecture
`RefParticipant` is the central model, carrying scoring logic:
- `sumRound1-4()`, `sumAll()` — Quiz aggregation
- `getScore()`, `getPercent()`, `judgeTotalScore()` — Oral scoring
- `getPosterScore()`, `judgePosterTotalScore()`, `posterOutput()` — Poster scoring
- `averageHigalaay()`, `getHigalaayScoreByJudge()`, `getRankingsByJudge()`, `higalaayDeduction()` — Higalaay scoring
- Ranking calculations use `DENSE_RANK` SQL window functions via `ReportService`

### Livewire Components (app/Livewire/)
Components are organized by event and concern:
- **Event components**: `Higalaay.php`, `Quiz.php`, `Oral.php`, `Poster.php` — main scoring interfaces
- **Reference**: `Reference/Criteria.php`, `Reference/Judges.php`, `Reference/Participants.php`, `Reference/QuizRound.php`, `Reference/Deductions.php`
- **Reports**: `Reports/ReportGenerator.php`, `Reports/EventAverageReport.php`, `Reports/EventRankingByJudge.php`, etc.
- **Settings**: `Settings/DBImportExport.php`, `Settings/Modules.php`, `Settings/UserManagement.php`
- **Display**: `DisplayManagement.php`, `DynamicLed.php`

### Multi-Category System
`Category` model controls which event modules are active (`is_active`), how many winners to display, and completion percentage. `RefParticipant`, `RefJudge`, and `RefCriteria` all store category as a JSON field and have a `Category($category)` scope for filtering.

### Report Generation
`ReportService::generateTopParticipants()` builds ranked results filtered by category/criteria/judge with deductions applied. PDF views live in `resources/views/generated_pdf/` and are rendered via DomPDF. Helper functions in `app/Helpers/helpers.php` support reports:
- `bong_ordinal_new()` — formats rank as GRAND CHAMPION / 1ST RUNNER UP / etc.
- `bong_rank_arranger()` — sorts and handles tied ranks
- `convert_image()` — base64-encodes images for inline PDF embedding

### API (routes/api.php)
Sanctum-protected endpoints for mobile sync:
- `POST /api/login` — returns token
- `GET /api/get-reference` — participants, judges, criteria
- `POST /api/upload-database` — mobile pushes scores
- `GET /api/download-database` — mobile pulls current data

### LED Display
`/display_led` and `/display_street` routes serve full-screen display views. `LedManagement` model and `DisplayManagement` Livewire component control what is shown on the LED wall in real time.

### User Roles
`User.role` is an enum: `admin` or `user`. Judges have a linked `RefJudge` record via `hasOne`. Role gates control access to settings and user management.

### Route Typo
`POST /regerence/save-judges` has a typo (`regerence` instead of `reference`) — match this exactly when referencing or modifying that route.
