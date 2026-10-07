# Changelog

## Security hardening
Active-user check on every request, session invalidation on password change, current-password
required for e-mail/password change, role privilege-escalation guard, private chat/ticket
attachments with upload whitelist, security headers, throttling, stock locking, input validation.

## Features
- **Audit log** (`audit.view`): created/updated/deleted on 14 models, logins, failed logins,
  role changes. Passwords never stored. `php artisan audit:prune` runs daily (default 365 days).
- **Sale cancellation** (`sales.cancel`): restores stock, posts a reversing journal entry, keeps the invoice.
- **Reports** (`reports.view`): 12-month revenue, top products, low stock, CSV export (formula-injection safe).
- **Dashboard KPIs** shown only to users who may see that module.
- Unique payroll per employee/month at DB level, race-free employee numbers.

## After updating
    php artisan migrate
    php artisan db:seed --class=RolePermissionSeeder   # adds audit.view / sales.cancel
    npm run build                                      # new views use new Tailwind classes
