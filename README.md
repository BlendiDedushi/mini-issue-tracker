# Mini Issue Tracker

A Laravel issue-tracking application for managing projects, issues, tags, and comments. Built for the PRITECH technical assignment.

## Requirements

- PHP 8.3+
- Composer
- MySQL
- Node.js 18+ and npm

## Setup

1. Clone the repository and install dependencies:

```bash
composer install
cp .env.example .env
php artisan key:generate
```

2. Configure your database in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mini_issue_tracker
DB_USERNAME=root
DB_PASSWORD=
```

3. Run migrations and seed demo data:

```bash
php artisan migrate --seed
```

4. Build frontend assets (required — compiled assets are not committed):

```bash
npm install
npm run build
```

5. Start the application:

```bash
php artisan serve
```

Visit [http://localhost:8000](http://localhost:8000).

### Quick setup script

Alternatively, run the Composer setup script (migrations only — seed separately):

```bash
composer run setup
php artisan db:seed
```

For local development with Vite hot reload:

```bash
composer run dev
```

## Demo accounts

All seeded users use the password `password`.

| Role | Email | Notes |
|------|-------|-------|
| Admin | `admin@test.com` | User management only |
| Project owner | `owner@test.com` | Full project/issue management |
| Project owner | `jane@test.com` | Additional owner with seeded projects |
| Project owner | `mark@test.com` | Additional owner with seeded projects |
| Member | `member@test.com` | View issues, comment, see assignments |
| Member | `alex@test.com` | Additional member |
| Member | `sam@test.com` | Additional member |

New registrations are assigned the **member** role by default.

## Roles

- **Admin** — manages user roles via the Users page. Cannot access projects, issues, or tags.
- **Project owner** — creates and manages their own projects and issues. Can assign members to issues, manage tags on issues, and delete issues they own.
- **Member** — browses projects and issues, adds comments, and views **My Assignments** for issues they are assigned to. Cannot assign or remove issue members.

## Features

- **Projects** — CRUD with owner, start date, and deadline
- **Issues** — CRUD with status, priority, due date, and filters (status, priority, tag)
- **Tags** — create tags and attach/detach them on issue detail (AJAX)
- **Comments** — paginated load and add on issue detail (AJAX)
- **Issue members** — assign team members to issues (AJAX, project owner only)
- **Search** — debounced AJAX search on issue title and description
- **Admin panel** — list users and update roles (paginated)

## Tests

```bash
php artisan test
```
