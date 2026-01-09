# RezTax (Rezeki & Tax Keeping) 🚀

**RezTax** is a modern, professional bookkeeping and tax-readiness application designed for freelancers and small business owners in Malaysia. It simplifies the process of tracking income, managing expenses, and preparing for LHDN filings.

---

## 🌟 Key Features

### 1. **Advanced Analytics Hub**
- **Yearly Trending**: Interactive line charts visualizing Income vs. Expenses over the last 12 months.
- **Category Breakdown**: Beautiful doughnut charts showing precise spending and income distribution by category.
- **Visual Clarity**: Vibrant, distinct color palettes for easy data interpretation.

### 2. **Smart Savings & Goal Tracking**
- **Personal Goals**: Create and track custom savings goals (e.g., "Emergency Fund", "New Laptop") with visual progress bars.
- **Tax Relief Tracking**: Dedicated tracking for tax-deductible savings like EPF, PRS, and SSPN to maximize tax benefits.
- **Real-time Insights**: "At a Glance" stats for Total Savings, YTD EPF, and Zakat contributions.

### 3. **Seamless Transaction Management**
- **Universal Quick-Add**: A global "New Transaction" modal accessible from anywhere.
- **Smart Mobile UX**: Floating Action Button (FAB) for one-tap entry on mobile devices.
- **Dynamic Context**: Intelligent form that adapts categories based on "Income" or "Expense" selection.

### 4. **Mobile-First Experience**
- **Responsive Navigation**: Smooth off-canvas sidebar menu for mobile users.
- **Touch-Optimized**: Large touch targets, simplified layouts, and FAB integration for on-the-go management.
- **Adaptive Charts**: Analytics charts that resize and reformat perfectly for small screens.

### 5. **Comprehensive Settings**
- **Profile Management**: Update personal details and secure password management.
- **Payment Methods**: Custom CRUD management for banks, e-wallets, and cards.
- **Category Customization**: Full control over income and expense categories to match your specific needs.

### 6. **Tax Summary (YA 2026 Ready)**
- **Chargeable Income Calculation**: Detailed breakdown of statutory income and reliefs.
- **Relief Optimization**: Real-time tracking of individual, lifestyle, and medical relief quotas.
- **Tax Payable Estimation**: Estimates your net tax payable based on current Malaysian tax brackets.

### 7. **Bank Statement Import**
- **Smart Mapping**: Intelligent interface to map CSV columns from any bank.
- **Fuzzy Date Parsing**: Robust handling of various Malaysian date formats (e.g., 09 Jan 2026, 09/01/2026).
- **Pro-Level Handling**: Correctly interprets credit/debit columns and negative accounting formats.

---

## 🛠 Technical Architecture

- **Backend**: Laravel 11.x (PHP 8.2+)
- **Frontend**: Blade with Tailwind CSS
- **Charts**: Chart.js for dynamic visualization
- **Interactions**: Vanilla JavaScript (Modern, lightweight)
- **Database**: Eloquent ORM
- **Icons**: Google Material Symbols

---

## 🔄 Recent Updates (Jan 2026)

- **UI/UX Overhaul**: Implemented a globally accessible Transaction Modal and Mobile FAB.
- **Mobile Optimization**: fixed mobile navigation with a responsive hamburger menu and sidebar.
- **Analytics Engine**: Deployed Chart.js powered visual analytics for yearly trends.
- **Savings Module**: Launched the dedicated Savings & Goal Tracking feature.
- **Settings System**: Built a robust settings module for managing dynamic app data.

---

## 🗺 2026 Roadmap (Next Steps)

- [ ] **[CHIP-asia.com](https://www.chip-in.asia/) Integration**: Implement automated subscription payments for Pro accounts (In Progress).
- [x] **Savings Tracker**: Implement the projected savings module to help users meet long-term financial goals.
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
