# RezTax (Rezeki & Tax Keeping) 🚀

**RezTax** is a modern, professional bookkeeping and tax-readiness application designed for freelancers and small business owners in Malaysia. It simplifies the process of tracking income, managing expenses, and preparing for LHDN filings.

---

## 🌟 Key Features

### 1. **Financial Dashboard**
- **Monthly Overview**: Real-time snapshot of Total Income, Total Expenses, and Net Balance.
- **Visual Analytics**: Interactive charts showing daily trends and spending breakdowns.
- **Recent Activity**: Quick view of recent transactions with direct edit access.

### 2. **Income Management**
- Dedicated CRUD flow for tracking multiple income sources.
- Support for various payment methods and descriptive notes.
- Quick-add interface for fast data entry.

### 3. **Expense & Tax Tracking**
- **Tax Deductibility**: Flag expenses as tax-deductible for accurate tax planning.
- **Attachment Support**: Upload and store receipts/invoices directly with each record.
- **Categorization**: Specialized expense categories tailored for Malaysian tax reliefs.

### 4. **Tax Summary (YA 2026 Ready)**
- **Chargeable Income Calculation**: Detailed breakdown of statutory income and reliefs.
- **Relief Optimization**: Real-time tracking of individual, lifestyle, and medical relief quotas.
- **Tax Payable Estimation**: Estimates your net tax payable based on current Malaysian tax brackets.

### 5. **Bank Statement Import**
- **Smart Mapping**: Intelligent interface to map CSV columns (Date, Description, Amount) from any bank.
- **Fuzzy Date Parsing**: Robust handling of various Malaysian date formats (e.g., 09 Jan 2026, 09/01/2026).
- **Credit/Debit Support**: Handles separate deposit/withdrawal columns or single-column amount signs.
- **Accounting Format Support**: Correctly interprets negative amounts in parentheses.

---

## 🛠 Technical Architecture

- **Backend**: Laravel (PHP 8.2+)
- **Frontend**: Blade with Tailwind CSS
- **Interactions**: Vanilla JavaScript (Modern, lightweight, no jQuery)
- **Database**: Eloquent ORM with resource-based controllers
- **Icons/Fonts**: Google Material Symbols & Inter Font

---

## 🔄 Recent Reorganization (Jan 2026)

We recently completed a major structural cleanup to improve maintainability:
- **Decoupled Logic**: Migrated from a monolithic `TransactionController` to dedicated `IncomeController` and `ExpenseController`.
- **Resource Routing**: Standardized all financial modules to use Laravel RESTful resources.
- **Dedicated Pages**: Replaced the global transaction modal with high-performance, dedicated Create/Edit pages for better user focus and data validation.
- **Layout Refactoring**: Consolidated dashboard layouts into a unified `layouts.main` system.
- **Premium Theme Alignment**: Harmonized registration and login pages with the dashboard's high-end dark/light design system.
- **Centralized Design System**: Moved Tailwind configurations to a base app layout for project-wide consistency.

---

## 🗺 2026 Roadmap (Next Steps)

- [ ] **[CHIP-asia.com](https://www.chip-in.asia/) Integration**: Implement automated subscription payments for Pro accounts (In Progress).
- [ ] **Savings Tracker**: Implement the projected savings module to help users meet long-term financial goals.
- [ ] **AI Receipt Parsing**: (Experimental) Automated data extraction from uploaded receipt images.
- [ ] **PDF Reporting**: Generate one-click tax reports for easy LHDN e-Filing reference.
- [ ] **Multi-Currency Support**: Support for freelancers working with international clients.

---

## 🚀 Getting Started

1. Clone the repository
2. Install dependencies: `composer install && npm install`
3. Configure `.env` with your database and `APP_NAME=RezTax`
4. Run migrations: `php artisan migrate --seed`
5. Start the server: `php artisan serve`

---

**© 2026 RezTax Malaysia**  
*Secure • Simple • Reliable*
