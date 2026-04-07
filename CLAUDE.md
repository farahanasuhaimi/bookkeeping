# CLAUDE.md — RezTax (bookkeeping)

## Project Overview

**RezTax** is a Laravel bookkeeping and tax-readiness web app for Malaysian freelancers and small business owners. It tracks income/expenses, calculates LHDN tax liability (YA 2026), and helps users maximize tax reliefs. Includes a Pro tier with PDF exports and CSV bank import.

**Owner**: Farahana Suhaimi (Nufa)
**Target users**: Malaysian freelancers, self-employed individuals
**Currency**: MYR (RM)

---

## Tech Stack

| Layer | Tech |
|-------|------|
| Backend | Laravel 12, PHP 8.2+ |
| Frontend | Blade, Tailwind CSS v4, Vite 7 |
| Charts | Chart.js |
| PDF | barryvdh/laravel-dompdf ^3.1 |
| Subscriptions | lemonsqueezy/laravel ^1.8 |
| Database | MySQL (Eloquent ORM) |
| Auth | Custom (AuthController — not Laravel Breeze) |

---

## Development Commands

```bash
# First-time setup
composer run-script setup

# Development (starts PHP server + queue + logs + Vite concurrently)
composer run-script dev

# Run tests
composer run-script test

# Single test
php artisan test --filter TestClassName

# Lint (Laravel Pint)
./vendor/bin/pint

# Migrations
php artisan migrate
php artisan migrate --seed
```

---

## Project Structure

```
app/
├── Http/Controllers/
│   ├── AuthController.php          # Login, register, password reset (custom)
│   ├── DashboardController.php     # Main dashboard
│   ├── IncomeController.php        # Income CRUD (resource)
│   ├── ExpenseController.php       # Expense CRUD (resource)
│   ├── TaxSummaryController.php    # Tax calculations + PDF export
│   ├── SavingsController.php       # Savings goals + tracking
│   ├── ImportController.php        # CSV bank statement import
│   ├── SettingsController.php      # Profile, password, payment methods, categories, preferences
│   └── AdminController.php         # Admin: users, plans, categories
├── Models/
│   ├── User.php                    # Auth + plan/tier + tooltip settings + Billable (LemonSqueezy)
│   ├── Income.php                  # user_id, source, amount, date, category_id, pcb_amount, payment_method_id
│   ├── Expense.php                 # user_id, description, amount, date, category_id, is_deductible, payment_method_id
│   ├── Category.php                # Shared categories for income and expense
│   ├── Transaction.php             # Legacy/general transaction model
│   ├── PaymentMethod.php           # User-defined: banks, e-wallets, cards
│   ├── Savings.php                 # Savings entries (EPF, PRS, SSPN, Zakat)
│   └── SavingsGoal.php             # Custom savings goals with target amounts
resources/views/
├── dashboard.blade.php             # Main dashboard with modals + FABs
├── tax_summary.blade.php           # Tax calculation view
├── tax_summary_pdf.blade.php       # PDF export view
├── pricing.blade.php               # Pro plan pricing page
└── [incomes/, expenses/, savings/, settings/, admin/]
database/migrations/                # See schema section below
```

---

## Database Schema

### Key Tables

**users**
- `id`, `name`, `email`, `password`
- `is_admin` (boolean) — admin flag
- `plan` (string) — `'free'` or `'pro'`
- `show_tooltips` (boolean)
- `tooltip_settings` (JSON) — per-page tooltip preferences

**incomes**
- `user_id`, `source`, `amount`, `description`, `date`, `status`
- `category_id` (FK → categories)
- `pcb_amount` — monthly tax deduction amount
- `payment_method_id` (FK → payment_methods)
- `notes`, `attachment_path`

**expenses**
- `user_id`, `description`, `amount`, `category_id`, `date`, `status`
- `is_deductible` (boolean) — tax deductible flag
- `payment_method_id` (FK → payment_methods)
- `notes`, `attachment_path`

**categories** — shared for income and expense, user-customizable

**payment_methods** — user-defined banks, e-wallets, cards

**savings** — EPF, PRS, SSPN, Zakat contributions

**savings_goals** — custom goals (e.g., "Emergency Fund") with target + current amounts

**transactions** — legacy general transactions table (predates split income/expense tables)

---

## Key Features & Modules

### 1. Income & Expense Management
- Full CRUD via resource controllers
- Categories are dynamic (user-customizable + admin-managed defaults)
- Payment methods are user-managed
- `is_deductible` flag on expenses feeds directly into tax relief calculation

### 2. Tax Summary (YA 2026)
**File**: `app/Http/Controllers/TaxSummaryController.php`

Malaysian tax brackets hardcoded in `calculateTax()`:
```
RM 0–5,000        → 0%
RM 5,001–20,000   → 1%
RM 20,001–35,000  → 3%
RM 35,001–50,000  → 8%
RM 50,001–70,000  → 13%
RM 70,001–100,000 → 21%
RM 100,001+       → 24%
```

**Relief categories (by category_id — hardcoded):**
- `5` → Lifestyle relief (cap: RM 2,500)
- `12` → EPF (cap: RM 4,000)
- `13` → Zakat (used as rebate against tax payable)
- `14` → Insurance (cap: RM 3,000)
- `15` → Medical (cap: RM 4,000)
- Standard personal relief: RM 9,000 (hardcoded)

**Income categories (hardcoded IDs):**
- `1` → Employment income
- `18` → Rental income
- `2`, `19` → Other income

⚠️ **Important**: Category IDs for tax calculations are hardcoded. If categories are recreated/seeded differently, tax calculations break. This is a known architectural debt.

**Income projection**: For current year, projects annual income based on months with recorded income.

### 3. Savings & Goals
- Tracks EPF, PRS, SSPN contributions (tax-deductible savings)
- Custom savings goals with visual progress bars
- "At a Glance" stats for YTD EPF and Zakat

### 4. Bank Statement CSV Import
**File**: `app/Http/Controllers/ImportController.php`
- User maps CSV columns to system fields
- Fuzzy date parsing handles Malaysian formats (DD/MM/YYYY, DD Mon YYYY, etc.)
- Handles credit/debit columns and negative accounting formats
- Pro feature

### 5. Plan/Tier System
- `User::$plan` field: `'free'` or `'pro'`
- Pro features: PDF export, Excel export, CSV import
- LemonSqueezy integration (`lemonsqueezy/laravel`) for subscription billing
- Admin can manually upgrade users via `AdminController::updatePlan()`

### 6. Admin Panel
Route prefix: `/admin` — protected by `admin` middleware
- User management + plan upgrades
- Category management (system-wide defaults)

### 7. Tooltip System
- `show_tooltips` boolean + `tooltip_settings` JSON per user
- `User::shouldShowTooltip($page)` helper method
- Explains Malaysian tax terms inline (PCB, Chargeable Income, etc.)

---

## Routes Summary

```
GET  /                          → redirect to login
GET|POST /login                 → AuthController
GET|POST /register              → AuthController
GET  /dashboard                 → DashboardController@index
GET  /pricing                   → pricing view
GET  /tax-summary               → TaxSummaryController@index
GET  /tax-summary/export        → TaxSummaryController@exportPDF (Pro)
resource /incomes               → IncomeController
resource /expenses              → ExpenseController
GET  /saving-tracking           → SavingsController@index
resource /savings-goals         → SavingsController (store/update/destroy only)
GET|POST /import                → ImportController
prefix /settings                → SettingsController (profile, password, payment-methods, categories, preferences)
prefix /admin (admin middleware) → AdminController
```

---

## Malaysian Domain Context

- **PCB** (Potongan Cukai Bulanan) — monthly tax deduction from salary, tracked per income entry
- **LHDN** — Malaysian tax authority (like HMRC/IRS)
- **YA** — Year of Assessment (e.g., YA 2026)
- **EPF** (KWSP) — mandatory pension fund, contributions are tax-deductible up to RM 4,000
- **PRS** — Private Retirement Scheme, voluntary pension
- **SSPN** — Education savings scheme for children
- **Zakat** — Islamic religious tax; acts as a direct rebate against tax payable (not just a relief)
- **Takaful** — Islamic insurance (relevant for insurance relief)
- All monetary values in **MYR (RM)**

---

## Known Issues / Architectural Notes

1. ~~**Hardcoded category IDs**~~ — **Fixed (April 2026)**. Categories now have a `slug` column. `TaxSummaryController::resolveCategoryIds()` looks up IDs by slug at runtime. Tax-relevant slugs: `employment-income`, `part-time-business`, `rental-income`, `dividends-interest`, `lifestyle`, `epf-contribution`, `zakat`, `life-insurance`, `medical-insurance`.
2. **Dual transaction models** — both `Transaction` (legacy) and `Income`/`Expense` (current) exist. The resource routes use `Income`/`Expense`. `Transaction` may be partially unused.
3. **No API routes** — entirely server-side rendered Blade. The dashboard uses JavaScript modals posting to standard form endpoints.
4. **LemonSqueezy not fully wired** — subscription billing integration exists (`Billable` trait on User) but CHIP-asia.com integration is in roadmap.

---

## 2026 Roadmap

- [ ] CHIP-asia.com payment integration (replacing/supplementing LemonSqueezy)
- [ ] AI receipt parsing (experimental)
- [ ] Multi-currency support
- [x] PDF tax reports
- [x] Savings tracker

---

## Environment Setup

```bash
cp .env.example .env
# Set: DB_DATABASE, DB_USERNAME, DB_PASSWORD
# Set: APP_NAME=RezTax
# Set: LEMONSQUEEZY_* keys if using Pro billing
php artisan key:generate
php artisan migrate --seed
```
