# 🏫 Laravel Multi-School Management System

A multi-tenant school management platform built with **Laravel 13**, **Inertia.js**, **React 19**, **TypeScript**, and **Tailwind CSS v4**. Each registered user gets their own isolated school (tenant) with full CRUD management for Teachers, Students, Courses, and Enrollments.

---

## ✨ Features

| Module | Capabilities |
|--------|-------------|
| **Auth** | Register, Login, Forgot/Reset Password, 2FA (via Laravel Fortify) |
| **Multi-Tenancy** | Every user is scoped to their own school — data is fully isolated |
| **Dashboard** | Live counts of Students, Courses, Teachers, Subjects, and Enrollments |
| **Teachers** | Add, edit, and delete teachers with subject assignment |
| **Students** | Add, edit, and delete students with grade tracking |
| **Courses** | Add, edit, and delete courses; assign a teacher per course |
| **Enrollments** | Enroll students in courses with an enrollment date |
| **Profile Settings** | Update name, email, and password |

---

## 🛠️ Tech Stack

- **Backend**: PHP 8.3, Laravel 13, Laravel Fortify
- **Frontend**: React 19, TypeScript, Inertia.js v2, Tailwind CSS v4
- **Build**: Vite 7, pnpm
- **Database**: PostgreSQL (local & production)

---

## 🚀 Local Setup

### Prerequisites

- PHP 8.3+
- Composer
- Node 20+ & pnpm (`npm i -g pnpm`)
- PostgreSQL

### Steps

```bash
# 1. Clone the repo
git clone <your-repo-url>
cd Laravel-Multi-School-Management-System

# 2. Install PHP dependencies
composer install

# 3. Copy environment file and generate app key
cp .env.example .env
php artisan key:generate

# 4. Configure your database in .env
#    Set DB_CONNECTION=pgsql, DB_HOST, DB_PORT=5432, DB_DATABASE, DB_USERNAME, DB_PASSWORD

# 5. Run migrations and seed demo data
php artisan migrate --seed

# 6. Install JS dependencies and build assets
pnpm install
pnpm run build

# 7. Start the dev server
composer run dev
```

The app will be available at **http://localhost:8000**.

**Demo login** (after seeding):
- Email: `test@example.com`
- Password: `password`

---

## 🚂 Deploy to Railway

### 1. Add a PostgreSQL Service

In your Railway project, click **+ New** → **Database** → **PostgreSQL**. Railway will automatically provision the database and inject `DATABASE_URL` environment variables.

### 2. Set Environment Variables

In your Railway service's **Variables** tab, add the following:

| Variable | Value |
|----------|-------|
| `APP_NAME` | `Multi School Management System` |
| `APP_ENV` | `production` |
| `APP_KEY` | _(run `php artisan key:generate --show` locally)_ |
| `APP_DEBUG` | `false` |
| `APP_URL` | _(your Railway public URL, e.g. `https://yourapp.up.railway.app`)_ |
| `DB_CONNECTION` | `pgsql` |
| `DB_HOST` | _(from Railway Postgres plugin `PGHOST`)_ |
| `DB_PORT` | `5432` |
| `DB_DATABASE` | _(from Railway Postgres plugin `PGDATABASE`)_ |
| `DB_USERNAME` | _(from Railway Postgres plugin `PGUSER`)_ |
| `DB_PASSWORD` | _(from Railway Postgres plugin `PGPASSWORD`)_ |
| `SESSION_DRIVER` | `database` |
| `QUEUE_CONNECTION` | `database` |
| `CACHE_STORE` | `database` |
| `LOG_CHANNEL` | `stderr` |

> **Tip**: Since the config handles `DATABASE_URL` automatically, you can also let Laravel run directly on Railway's `DATABASE_URL` connection string!

### 3. Deploy

Railway will automatically detect the `nixpacks.toml` file and:

1. Install **PHP 8.3** with all required extensions (including `pdo_pgsql`)
2. Install **Node 20**
3. Run `npm ci` + `composer install`
4. Build Vite assets (`npm run build`)
5. Cache Laravel routes and views (excluding environment variables config caching to prevent dynamic runtime env issues)
6. On startup: run `php artisan migrate --force` then start the server

Simply push to your connected GitHub branch and Railway will deploy automatically.

```bash
git add .
git commit -m "chore: prepare for Railway PostgreSQL deployment"
git push origin main
```

---

## 📁 Project Structure

```
├── app/
│   ├── Actions/Fortify/     # User registration & password reset
│   ├── Concerns/            # Validation rule traits
│   ├── Http/Controllers/    # Dashboard, Teacher, Student, Course, Enrollment
│   ├── Models/              # User, Tenant, Teacher, Student, Course, Enrollment
│   └── Providers/           # AppServiceProvider, FortifyServiceProvider
│   database/
│   ├── migrations/          # All table schemas
│   └── seeders/             # Demo school + test user seed
├── resources/js/
│   ├── pages/               # React page components (Inertia)
│   │   ├── dashboard.tsx
│   │   ├── teacher/index.tsx
│   │   ├── student/index.tsx
│   │   ├── course/index.tsx
│   │   └── enrollment/index.tsx
│   ├── layouts/             # App layout (sidebar, nav)
│   └── components/          # UI components (shadcn/ui based)
├── routes/
│   ├── web.php              # Main authenticated routes
│   └── settings.php         # Profile & security settings routes
├── nixpacks.toml            # Railway build configuration
└── Procfile                 # Railway start command
```

---

## 🔐 Multi-Tenancy Model

- Each **User** belongs to exactly one **Tenant** (school) via `tenant_id`.
- When a user **registers**, a new `Tenant` record is automatically created and linked to that user.
- All queries in every controller filter by `Auth::user()->tenant_id`, ensuring complete data isolation between schools.

---

## 🧪 Running Tests

```bash
php artisan test
```

---

## 📄 License

MIT
