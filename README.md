<div align="center">

#  Enterprise ERP System

**A modular, permission-driven ERP built with Laravel — HR & Payroll, Inventory, Sales, Purchasing, Accounting, Support Tickets and Internal Chat in one place.**

![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?logo=php&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind-3-06B6D4?logo=tailwindcss&logoColor=white)
![Alpine.js](https://img.shields.io/badge/Alpine.js-3-8BC0D0?logo=alpinedotjs&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-6-646CFF?logo=vite&logoColor=white)
![Tests](https://img.shields.io/badge/tests-PHPUnit-3E8E41)

</div>

---

##  Overview

This project is a full-featured ERP that covers the daily operations of a small-to-mid-sized company. Every screen and action is protected by a fine-grained **role & permission system**, every important change is written to an **audit log**, and every sale or payroll run is reflected in a **double-entry accounting ledger**.

The interface is **Arabic (RTL)** out of the box.

##  Modules

| Module | What it does |
|---|---|
|  **Users & Roles** | User management, role builder, per-action permissions (`view / create / edit / delete`), active/inactive accounts |
|**Human Resources** | Departments, employees, daily attendance sheet, overtime, bonuses, salary advances, loans |
| **Leaves** | Leave types, leave balances, employee self-service requests, approve / reject workflow |
|  **Payroll** | Monthly payroll generation, printable pay slips, verification, one payroll per employee per month (enforced in the DB) |
|  **Inventory** | Products, categories, warehouses, stock in / out, stock movement history, low-stock alerts |
|  **Purchasing** | Suppliers and purchase orders |
|  **Sales** | Customers, invoices, PDF invoice export, **sale cancellation** (restores stock + posts a reversing journal entry) |
|  **Accounting** | Chart of accounts, balanced journal entries, accounting overview, auto-posted entries from sales & payroll |
|  **Reports** | 12-month revenue, top products, low stock, CSV export (formula-injection safe) |
|  **Audit Log** | Tracks create / update / delete on 14 models, logins, failed logins and role changes — passwords are never stored |
|  **IT Tickets** | Employees raise tickets, support staff manage and update status, private attachments |
|  **Internal Chat** | One-to-one conversations between users with private file attachments |
|  **Dashboard** | KPIs shown only for the modules the current user is allowed to see |

##  Security

Security was treated as a first-class feature:

- **Active-user check** on every request — deactivated users are kicked out immediately
- **Session invalidation** after a password change
- **Current password required** to change e-mail or password
- **Privilege-escalation guard** on role assignment
- **Private attachments** for chat & tickets, served through authorized controllers with an upload whitelist
- **Security headers** (`X-Frame-Options`, `X-Content-Type-Options`, `Referrer-Policy`, `Permissions-Policy`, HSTS on HTTPS)
- **Rate limiting** on sensitive endpoints, **row locking** on stock updates, strict input validation
- **Public registration removed** — accounts are created by administrators only
- Dangerous cascade deletes restricted at the database level

##  Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 11, PHP 8.2+ |
| Auth & Permissions | Laravel Breeze, [spatie/laravel-permission](https://github.com/spatie/laravel-permission) |
| PDF | [barryvdh/laravel-dompdf](https://github.com/barryvdh/laravel-dompdf) |
| Frontend | Blade, Tailwind CSS 3, Alpine.js 3, Vite 6 |
| Database | SQLite by default (MySQL / PostgreSQL supported through `.env`) |
| Queue / Cache / Session | Database drivers |
| Testing | PHPUnit 11 |

##  Getting Started

### Requirements

- PHP **8.2+** with the usual Laravel extensions (`mbstring`, `openssl`, `pdo`, `fileinfo`, `gd`)
- Composer
- Node.js 18+ and npm

### Installation

```bash
# 1. Clone the repository
git clone https://github.com/engahmadateah/engahmadateah-enterprise-erp-system.git
cd engahmadateah-enterprise-erp-system

# 2. Install dependencies
composer install
npm install

# 3. Environment
cp .env.example .env
php artisan key:generate

# 4. Database (SQLite by default)
touch database/database.sqlite        # Windows PowerShell: New-Item database/database.sqlite
php artisan migrate --seed

# 5. Storage link (for uploaded files) and frontend assets
php artisan storage:link
npm run build

# 6. Run
php artisan serve
```

Then open **http://127.0.0.1:8000**.

### First login

The seeder creates a Super Admin account:

| Field | Value |
|---|---|
| Email | `admin@erp.com` |
| Password | the value of `SUPERADMIN_PASSWORD` in your `.env`, or a **random password printed once** in the terminal during seeding |

>  Set `SUPERADMIN_PASSWORD` **before** running `php artisan db:seed`, and change it after the first login.

### Using MySQL instead of SQLite

Edit these lines in `.env`, then run `php artisan migrate --seed`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=erp
DB_USERNAME=root
DB_PASSWORD=
```

### Development mode

Runs the server, queue worker, log viewer and Vite together:

```bash
composer run dev
```

## 👤 Default Roles

Seeded by `RolePermissionSeeder` — all of them can be edited later from the **Roles** screen.

| Role | Access |
|---|---|
| **Super Admin** | Everything |
| **Admin** | Everything |
| **HR** | Employees, attendance, leaves, leave balances, payroll, overtime, bonuses, advances, loans |
| **Accountant** | Payroll view, accounting, accounts, journal, sales & purchases view, reports |
| **Manager** | Employees & attendance view, leave approvals |
| **Employee** | Own leaves, tickets, chat, dashboard |

##  Project Structure

```
app/
├── Console/Commands/      # audit:prune
├── Http/
│   ├── Controllers/       # one controller per module
│   ├── Middleware/        # EnsureUserIsActive, SecurityHeaders
│   └── Requests/          # form request validation
├── Models/                # Eloquent models (+ Concerns/ for the audit trait)
└── Services/
    └── AccountingService  # balanced double-entry journal posting
database/
├── migrations/
└── seeders/               # roles, permissions, super admin, chart of accounts, leave types
resources/views/           # Blade views, one folder per module
routes/                    # web.php, auth.php, console.php
tests/
├── Feature/               # access control, features, security hardening, profile, auth
└── Unit/                  # AccountingService
```

##  Testing

```bash
php artisan test
```

The suite covers access control per role, feature behaviour (sale cancellation, reports, audit log), security hardening and the accounting service.

##  Scheduled Tasks

The audit log is pruned automatically (365 days by default):

```bash
php artisan audit:prune
```

It is registered in `routes/console.php` to run daily at **03:00**. In production, add the Laravel scheduler to cron:

```cron
* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```

##  Production Checklist

- [ ] `APP_ENV=production` and `APP_DEBUG=false` (debug pages leak secrets)
- [ ] `SESSION_SECURE_COOKIE=true` when serving over HTTPS
- [ ] Strong `SUPERADMIN_PASSWORD` set before seeding, then changed after first login
- [ ] `php artisan config:cache route:cache view:cache`
- [ ] `npm run build`
- [ ] Cron entry for the scheduler
- [ ] Never commit `.env` or the SQLite database file

##  Updating an Existing Installation

```bash
php artisan migrate
php artisan db:seed --class=RolePermissionSeeder   # adds new permissions
npm run build                                      # new views use new Tailwind classes
```

See [CHANGELOG.md](CHANGELOG.md) for what changed.

##  Author

**Ahmad Ateah** — [@engahmadateah](https://github.com/engahmadateah)

---

<div align="center">

Built with ❤️ using Laravel

</div>