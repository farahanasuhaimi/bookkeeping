# Lemon Squeezy Integration Guide (RezTax)

Since we are avoiding the business registration requirement of local Malaysian gateways (like CHIP), we are using **Lemon Squeezy** as a Merchant of Record.

## 🚀 Status
- [x] Branch `feature/lemon-squeezy` created.
- [x] `Billable` trait added to `User` model.
- [x] Pricing UI updated with checkout links.
- [x] CSRF protection skipped for webhooks.
- [x] Environment variables added to `.env.example`.
- [x] Pro tier logic updated in Controllers and Views.

## 🛠 Next Steps (User Action Required)

### 1. Fix Dependencies
Run the following command in your terminal. Since you are on Windows and the package might request `ext-pcntl` (which is Linux-only), use the `-W` (with-all-dependencies) flag:

```bash
composer update lemonsqueezy/laravel -W
```

*Note: If it still complains about `ext-pcntl`, I have added a "platform" config to your `composer.json` to help, but you can also use:*
```bash
composer update lemonsqueezy/laravel -W --ignore-platform-req=ext-pcntl
```

### 2. Run Migrations
Once dependencies are installed, run:
```bash
php artisan migrate
```
This will create the necessary `subscriptions` and `customers` tables.

### 3. Configure Lemon Squeezy
1. Go to [Lemon Squeezy Dashboard](https://app.lemonsqueezy.com/).
2. Create a **Store**.
3. Create a **Subscription Product** with two variants (Monthly & Yearly).
4. Get your **API Key** and **Store ID**.
5. Set up a **Webhook**:
   - URL: `https://your-domain.com/lemon-squeezy/webhook`
   - Signing Secret: Any random string (must match `.env`).
   - Events: `subscription_created`, `subscription_updated`, `subscription_cancelled`.

### 4. Update Variant IDs
In `resources/views/pricing.blade.php`, replace:
- `PLACEHOLDER_MONTHLY_VARIANT_ID`
- `PLACEHOLDER_YEARLY_VARIANT_ID`
with the actual variant IDs from your Lemon Squeezy dashboard.

### 5. Update Pro Logic (Code)
In `ExpenseController.php` and `IncomeController.php`, update the plan checks:
**From:**
```php
if (auth()->user()->plan == 'pro')
```
**To (more robust):**
```php
if (auth()->user()->subscribed())
```

## 📄 Why Lemon Squeezy?
- **No SSM Required**: You can start as an individual.
- **Tax Handling**: They handle global VAT/SST automatically.
- **Google Pay**: Built into their checkout experience.
- **Laravel First**: The `lemonsqueezy/laravel` package is officially supported.
