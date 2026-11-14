# 📚 School Management System (SMS) — Executive Edition v2.0

A modern, full-featured web-based school management platform built with **Laravel 11**, **JavaScript**, **Bootstrap 4 / AdminLTE 3**, **FullCalendar 5**, and multi-database support (**PostgreSQL / Supabase**, **SQLite**, and **MySQL**). Engineered for educational institutions to effortlessly manage academics, admissions, classrooms, exams & marksheets, fee billing & receipts, requisitions, financial ledgers, staff attendance, security audit trails, and interactive school calendars with **100% Khmer & English bilingual localization**.

---

## 🌟 What's New in v2.0

- 🗓️ **Interactive Academic & Event Calendar (`/calendar`)**: Powered by FullCalendar v5 with month, week, day, and agenda views, draggable event tags with AJAX persistence, date click-to-add modals, live rescheduling, and integration with real school exams and Cambodian national holidays.
- 🧙‍♂️ **Web Installation Wizard (`/install`)**: 6-step modern glassmorphic setup assistant featuring real-time server diagnostics (PHP 8.2+, 12 required extensions, directory permissions), live AJAX database connection testing, school profile & branding customizer, and super admin setup.
- 🌐 **100% Bilingual Localization (Khmer & English)**: Complete translation coverage across all views and controllers with over 2,150+ audited translation keys (`lang/km.json`) and instant one-click language switching (`/lang/km` & `/lang/en`).
- 🗄️ **Multi-Database Support (PostgreSQL / Supabase + SQLite + MySQL)**: Driver-aware date mathematics and parameterized SQL queries ensuring seamless operation across PostgreSQL, Supabase, SQLite, and MySQL/MariaDB.
- 🎨 **Modern 3D Glossy Sidebar Icons**: Beautiful 3D icon design system with gradient color-coding, glass borders, and elevated drop-shadows across all 5 role sidebars.
- 💎 **Executive UI Suite Remakes**: Modern card layouts, responsive data tables, status badges, and compact density modes across Departments, Staff, Parents, Teachers, User Management, Fee Receipts, Purchase Requests, Sessions, Admissions, Students Directory, and Examination Marks.

---

## 🎯 Highlights & Core Features

### 👥 1. Role-Based Access Control (RBAC)
Airtight multi-tier authorization matrix enforced via middleware guards and role models:
- **Administrator (Role 0)**: Full master control — user account management, school customization & branding, security audit trail, financial ledger approvals, departments, staff, student admissions, and installation diagnostics.
- **Teacher (Role 1)**: Class and section management, subject curricula, routines/timetables, class learning materials & lecture videos, student grading, and daily roll call attendance.
- **Student (Role 2)**: Class schedule timetables, course learning materials, enrolled subjects, exam schedules & term marksheets, teacher directory, personal profile, and notification inbox.
- **Accountant (Role 3)**: Complete accounting suite — fee receipts & billing, purchase requisition vouchers, profit & loss statement reports, and student fee lookup.
- **Receptionist (Role 4)**: Front-desk admissions & inquiry pipeline, student enrollment, staff attendance roll, fee collection billing, and supply purchase requisitions.

---

### 🗓️ 2. Interactive Academic & Event Calendar (`/calendar`)
- **FullCalendar v5 Engine**: High-performance calendar supporting DayGrid Month, TimeGrid Week, TimeGrid Day, and List Month views.
- **Draggable Event Palette**: Pre-configured and custom draggable badges that can be dropped directly onto any date cell with instant AJAX database persistence.
- **Live Rescheduling & Resizing**: Drag-and-drop events across dates or resize durations directly on the calendar with automatic background synchronization.
- **Smart System Sync**: Automatically pulls official exams from the `exam` table, academic terms from the `section` table, and pre-seeded Cambodian public holidays.
- **Interactive Modals**: Click any date cell to open the "Add Event" modal with category selection and color swatches; click any event to view details, edit, or delete.
- **Bilingual Support**: Native Khmer calendar translations for days, months, and buttons (`/assets/plugins/fullcalendar/locales/km.js`).

---

### 🧙‍♂️ 3. Modern Installation & Setup Wizard (`/install`)
- **Step 1: Welcome & Overview**: Software version badge, platform capabilities overview, and license agreement acceptance.
- **Step 2: Server & Environment Diagnostics**: Real-time verification of PHP version (>= 8.2), 12 required extensions (`pdo`, `openssl`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `curl`, `fileinfo`, `gd`, `intl`), and directory permissions.
- **Step 3: Database Engine & Credentials**: Select between SQLite, PostgreSQL (Supabase), and MySQL with live AJAX connection testing and automatic schema migration/seeding.
- **Step 4: Institution Profile & Branding**: School name, contact phone, official email, campus address, default currency (`USD $` / `KHR ៛`), and theme accent colors.
- **Step 5: Super Administrator Setup**: Configure the primary administrator account credentials.
- **Step 6: Completion & Launch**: Animated celebration card with checklist summary and direct links to the dashboard or login page.

---

### 💰 4. Accounting & Financial Suite
- **Fee Receipts & Billing (`/fee_receipt`)**:
  - Issue itemized student tuition and fee receipts.
  - Official A4 print layout and PDF voucher download with school logo, contact details, dynamic signatures, and auto-generated filenames (`FeeReceipt_{No}_{Student}.pdf`).
- **Purchase Requests & Procurement (`/purchase_req`)**:
  - Submit purchase requisition vouchers with multi-item expense breakdowns.
  - Approval and rejection workflow for administrators.
  - Printable purchase request vouchers with auto-naming (`PurchaseRequest_{No}_{Dept}.pdf`).
- **Profits & Expenses Statement Report (`/profit`)**:
  - Executive financial statement layout with KPI summary cards (Total Revenue, Total Expense, Net Surplus/Deficit, Margin %).
  - Visual category progress breakdowns and itemized transaction ledgers.
  - Print/PDF export with auto-naming (`FinancialReport_{Year}.pdf`).

---

### 🛡️ 5. Security Audit Trail & Activity Logs (`/activity-logs`)
- **Non-Blocking Architecture**: High-performance middleware with zero external network freezing (local IPs resolve instantly; public IPs use cached lookups).
- **Comprehensive Event Capture**: Tracks user, action, description, HTTP method (`GET`, `POST`, `PUT`, `DELETE`), route URL, client device, IP address, geolocation, HTTP status code, and timestamp.
- **Executive Audit Dashboard**: Real-time KPI counters, advanced multi-criteria filtering (User, Method, Date range presets, Keyword search), streamed CSV export, and safe multi-tier log purging modal.

---

### 🖥️ 6. Academic & Classroom Management
- **Classes & Sections**: Organize academic levels, assign class teachers, and configure multi-section schedules.
- **Curriculum & Subjects**: Manage subject lists, assign courses to classes, and schedule timetables.
- **Class Materials Hub**: Teachers upload lecture documents, notes, video links, and gallery images; students browse and download resources.
- **Examinations & Marksheets**: Create exams, configure grade boundaries, evaluate student marks, and generate class marksheets.
- **Attendance Roll**: Mark daily student attendance with present/absent counters, attendance reports, and edit request workflows.

---

### ⚡ 7. Modern Desktop & UI Experience
- **PC Command Palette (<kbd>Ctrl + K</kbd>)**: Fast Spotlight-style keyboard search to jump between authorized pages instantly.
- **Dark & Light Mode**: Seamless dark mode support synchronized across cookies and client local storage.
- **Quick Test Accounts Showcase**: One-click demo login pills on the login screen with vector role badges.
- **Unified Global Logout**: Reliable one-click logout across the top navbar, user profile menu, sidebar, and command palette.

---

## 🛠️ Tech Stack

| Layer | Technology | Description |
| :--- | :--- | :--- |
| **Backend Framework** | Laravel 11.x | Modern PHP Web Framework |
| **PHP Version** | PHP 8.2+ (PHP 8.3 Recommended) | Modern PHP Runtime Engine |
| **Database** | PostgreSQL / Supabase, SQLite, MySQL | Multi-Database Compatible |
| **Admin Template** | AdminLTE 3 / Bootstrap 4 | Responsive Executive UI Framework |
| **Calendar Engine** | FullCalendar 5.10 | Interactive Drag-and-Drop Calendar |
| **Icons & Fonts** | FontAwesome 5 Free / 3D Icons | Modern Vector Icons & 3D Sidebar System |
| **Charts** | Chart.js | Interactive Dashboard & Ledger Visualizations |
| **PDF Engine** | DomPDF | Server-side PDF Voucher Generation |
| **QR Code Engine** | Simple Software IO QRCode | QR Code Generation |
| **Asset Bundler** | Vite 5.x | Modern Frontend Asset Pipeline |

---

## 👥 Default Demo Test Accounts

The system includes pre-configured test accounts across all 5 authorization roles:

| Role | Email | Password | Primary Scope |
| :--- | :--- | :--- | :--- |
| **Administrator (Role 0)** | `admin@gmail.com` | `123456` | Full master control, settings, diagnostics |
| **Teacher (Role 1)** | `TeacherTest@gmail.com` | `123456` | Classroom, materials, marks & attendance |
| **Student (Role 2)** | `StudentTest@gmail.com` | `123456` | Schedules, materials, grades & notifications |
| **Accountant (Role 3)** | `phy@gmail.com` | `123456` | Accounting, fee receipts & financial ledgers |
| **Receptionist (Role 4)** | `ReceptionistTest@gmail.com` | `123456` | Admissions, front desk & staff attendance |

> [!TIP]
> On the login page (`/login`), you can click any of the role badges under **"Quick Demo Login"** to automatically populate credentials and sign in with one click.

---

## 📋 Prerequisites

Ensure you have the following installed on your machine or server:
- **PHP >= 8.2** (Recommended: PHP 8.3 with `pdo`, `pdo_sqlite`, `pdo_pgsql`, `pdo_mysql`, `mbstring`, `openssl`, `curl`, `fileinfo`, `gd`, `intl`)
- **Composer**
- **Node.js** (v18+ recommended) and **npm**
- **Git**

---

## 🚀 Quick Setup & Installation

### Option A: Interactive Web Installation Wizard (Recommended)
1. Clone the repository and install dependencies:
   ```bash
   git clone https://github.com/theinvinciblebe/School-Management-System.git
   cd School-Management-System
   composer install
   npm install && npm run build
   cp .env.example .env
   php artisan key:generate
   ```
2. Start the local server:
   ```bash
   php artisan serve
   ```
3. Open your browser and navigate to **`http://localhost:8000/install`**. The 6-step wizard will test your environment, configure your database, set your school branding, and create your super admin account automatically.

---

### Option B: Manual CLI Installation

#### Step 1: Clone & Install Dependencies
```bash
git clone https://github.com/theinvinciblebe/School-Management-System.git
cd School-Management-System
composer install
npm install
```

#### Step 2: Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

#### Step 3: Configure Database
For **SQLite** (Default, zero configuration):
```env
DB_CONNECTION=sqlite
```
For **PostgreSQL / Supabase**:
```env
DB_CONNECTION=pgsql
DB_HOST=aws-0-ap-northeast-2.pooler.supabase.com
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres.your_project_id
DB_PASSWORD="your_password"
DB_SSLMODE=require
```
For **MySQL**:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=school_management
DB_USERNAME=root
DB_PASSWORD=
```

#### Step 4: Run Migrations & Seed Default Data
**Option A — Via Terminal:**
```bash
php artisan migrate
# Seed demo accounts and initial calendar events
php artisan db:seed
```

**Option B — Via Web Console / Vercel Serverless (No SSH Required):**
When running on Vercel or cloud hosting without SSH terminal access, trigger migrations and seeds directly via browser or cURL:
- ⚡ **Migrate & Seed (Combined)**: `GET` / `POST` [`http://localhost:8000/migrate-seed`](http://localhost:8000/migrate-seed) or `https://your-domain.vercel.app/migrate-seed`
- 🛠️ **Run Migrations Only**: `GET` / `POST` [`http://localhost:8000/migrate`](http://localhost:8000/migrate)
- 🌱 **Run Seeders Only**: `GET` / `POST` [`http://localhost:8000/seed`](http://localhost:8000/seed)
- 📋 **Check Migration Status**: `GET` [`http://localhost:8000/migrate/status`](http://localhost:8000/migrate/status)
- 💻 **Database Operations Console UI**: `GET` [`http://localhost:8000/migrate/console`](http://localhost:8000/migrate/console)

*(Optional: Set `MIGRATE_KEY=your_secret_token` in `.env` to protect routes with `?key=your_secret_token`)*

#### Step 5: Build Assets & Start Server
```bash
npm run build
php artisan serve
```
Visit `http://localhost:8000` in your browser.

---

## 📂 Project Structure

```
School-Management-System/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AccountingController.php   # Fee receipts, purchase requisitions, financial ledger
│   │   │   ├── ActivityLogController.php  # Security audit trail, filtering, export
│   │   │   ├── CalendarController.php     # FullCalendar v5 events feed, drag/drop, CRUD
│   │   │   ├── DashboardController.php    # Role-tailored dashboard & KPI feeds
│   │   │   ├── InstallerController.php    # 6-step modern web installation wizard
│   │   │   ├── LoginController.php        # Authentication & quick role login
│   │   │   └── ...
│   │   └── Middleware/
│   │       ├── LogUserActivity.php        # Non-blocking activity audit logger
│   │       ├── RoleMiddleware.php         # RBAC route authorization guard
│   │       └── SetLocale.php              # Multi-language localization middleware
│   └── Models/
│       ├── CalendarEvent.php              # Calendar event model
│       ├── ActivityLog.php                # Audit log model with device/geo resolution
│       ├── User.php                       # User model with role helpers
│       └── ...
├── database/
│   ├── migrations/                        # Database schema migrations
│   ├── seeders/                           # Database seeders (UserSeeder, StaffSeeder, etc.)
│   └── database.sqlite                    # SQLite database storage
├── lang/
│   ├── en/                                # English translations
│   └── km.json                            # Complete Khmer localization dictionary (2,150+ keys)
├── resources/
│   └── views/
│       ├── accounting/                    # Fee receipts, purchase requisitions, financial ledger
│       ├── activity_logs/                 # Executive audit trail interface
│       ├── calendar.blade.php             # Modern interactive calendar view
│       ├── installer/
│       │   └── index.blade.php            # 6-step glassmorphic web installation wizard
│       ├── components/
│       │   ├── navbar/                    # Top navigation, language switch & user menu
│       │   ├── sidebar/                   # 5 role-tailored sidebars with 3D icons
│       │   └── pc-command-palette.blade.php # Spotlight command palette
│       ├── dashboard/                     # Role-aware dashboards
│       └── layout/                        # Main layout, header, footer, toastr notifications
├── routes/
│   ├── web.php                            # Web routes organized by role authorization
│   └── api.php                            # API endpoints
└── README.md
```

---

## ⌨️ Keyboard Shortcuts (Desktop)

| Shortcut | Action |
| :--- | :--- |
| <kbd>Ctrl</kbd> + <kbd>K</kbd> | Open Spotlight Command Palette |
| <kbd>Alt</kbd> + <kbd>D</kbd> | Jump to Dashboard |
| <kbd>Alt</kbd> + <kbd>S</kbd> | Toggle Sidebar Collapse / Expand |
| <kbd>Alt</kbd> + <kbd>T</kbd> | Toggle Dark / Light Theme Mode |
| <kbd>Alt</kbd> + <kbd>C</kbd> | Toggle Compact Table Density |
| <kbd>Alt</kbd> + <kbd>F</kbd> | Toggle Browser Fullscreen |
| <kbd>Esc</kbd> | Close Modal / Reset Search Filter |

---

## 🛡️ Security Best Practices

- **Strict RBAC Enforcement**: Controller and route-level role authorization preventing privilege escalation.
- **Audit Logging**: Every state mutation (`POST`, `PUT`, `DELETE`) is captured with user details, IP, and timestamp.
- **Cross-Database Compatibility**: Parameterized queries via Eloquent ORM and Query Builder preventing SQL injection.
- **CSRF & XSS Protection**: Token-based CSRF verification on all state-modifying endpoints with Blade automatic HTML escaping.
- **Safe Environment Management**: Automated forward-slash normalization for `.env` paths preventing dotenv parsing exceptions.

---

## 📄 License

This software is released under the [MIT License](LICENSE).
