# 📚 School Management System (SMS)

A modern, comprehensive web-based school management platform built with **Laravel 11**, **JavaScript**, **Bootstrap 4 / AdminLTE 3**, and **SQLite / MySQL**. Designed for educational institutions to seamlessly manage academics, student records, fee billing, requisitions, financial ledger reports, staff attendance, and security audit trails.

---

---

## 🎯 Highlights & Core Features

### 👥 1. Role-Based Access Control (RBAC)
Airtight multi-tier authorization matrix powered by middleware and user models:
- **Administrator (Role 0)**: Full master control — user account management, school customization & branding, security audit trail, financial ledger approvals, departments, staff, and admissions.
- **Teacher (Role 1)**: Class and section management, subject curricula, routines/timetables, class learning materials & lecture videos, student grading, and daily roll call attendance.
- **Student (Role 2)**: Class schedule timetables, course learning materials, enrolled subjects, exam schedules & term marksheets, teacher directory, personal profile, and notification inbox.
- **Accountant (Role 3)**: Complete accounting suite — fee receipts & billing, purchase requisition vouchers, profit & loss statement reports, and student fee lookup.
- **Receptionist (Role 4)**: Front-desk admissions & inquiry pipeline, student enrollment, staff attendance roll, fee collection billing, and supply purchase requisitions.

---

### 💰 2. Accounting & Financial Suite
- **Fee Receipts & Billing**:
  - Issue itemized student tuition and fee receipts.
  - Official A4 print layout and PDF voucher download with school logo, contact details, dynamic signatures, and auto-generated filenames (`FeeReceipt_{No}_{Student}.pdf`).
- **Purchase Requests (Procurement)**:
  - Submit purchase requisition vouchers with multi-item expense breakdowns.
  - Approval and rejection workflow for administrators.
  - Printable purchase request vouchers with auto-naming (`PurchaseRequest_{No}_{Dept}.pdf`).
- **Profits & Expenses Statement Report**:
  - Executive financial statement layout with KPI summary cards (Total Revenue, Total Expense, Net Surplus/Deficit, Margin %).
  - Visual category progress breakdowns and itemized transaction ledgers.
  - Print/PDF export with auto-naming (`FinancialReport_{Year}.pdf`).

---

### 🛡️ 3. Security Audit Trail & Activity Logs
- **Non-Blocking Architecture**: High-performance middleware with zero external network freezing (local IPs resolve instantly; public IPs use cached lookups).
- **Comprehensive Event Capture**: Tracks user, action, description, HTTP method (`GET`, `POST`, `PUT`, `DELETE`), route URL, client device, IP address, geolocation, HTTP status code, and timestamp.
- **Executive SaaS Audit Dashboard**: Real-time KPI counters, advanced multi-criteria filtering (User, Method, Date range presets, Keyword search), streamed CSV export, and safe multi-tier log purging modal.

---

### 🖥️ 4. Academic & Classroom Management
- **Classes & Sections**: Organize academic levels, assign class teachers, and configure multi-section rooms.
- **Curriculum & Subjects**: Manage subject lists, assign courses to classes, and schedule routines.
- **Class Materials Hub**: Teachers upload lecture documents, notes, video links, and gallery images; students browse and download resources.
- **Examinations & Marksheets**: Create exams, configure grade boundaries, evaluate student marks, and generate class marksheets.
- **Attendance Roll**: Mark daily student attendance with present/absent counters, attendance reports, and edit request workflows.

---

### ⚡ 5. Modern Desktop & UI Experience
- **PC Command Palette (<kbd>Ctrl + K</kbd>)**: Fast Spotlight-style keyboard search to jump between authorized pages instantly.
- **Dark & Light Mode**: Seamless dark mode support synchronized across cookies and client local storage.
- **Quick Test Accounts Showcase**: Visual role pill selector on the login screen with vector role icons and active showcase cards.
- **Unified Global Logout**: Reliable one-click logout across the top navbar, user profile menu, sidebar, and command palette.

---

## 🛠️ Tech Stack

| Layer | Technology | Description |
| :--- | :--- | :--- |
| **Backend Framework** | Laravel 11.x | PHP Web Framework |
| **PHP Version** | PHP 8.2+ | Modern PHP Engine |
| **Database** | SQLite (Default) / MySQL | Relational Database |
| **Admin Template** | AdminLTE 3 / Bootstrap 4 | Responsive UI Framework |
| **Icons & Fonts** | FontAwesome 5 Free | Vector Icons |
| **Charts** | Chart.js | Interactive Dashboard & Ledger Visualizations |
| **PDF Engine** | DomPDF | Server-side PDF Voucher Generation |
| **QR Code Engine** | Simple Software IO QRCode | QR Code Generation |
| **Asset Bundler** | Vite 5.x | Modern Frontend Asset Pipeline |

---

## 👥 Default Test Accounts

Use these accounts to test the application across different access levels:

| Role | Email | Password | Primary Scope |
| :--- | :--- | :--- | :--- |
| **Administrator** | `admin@gmail.com` | `admin123` | Full master control & settings |
| **Teacher** | `TeacherTest@gmail.com` | `password` | Classroom, marks & attendance |
| **Student** | `StudentTest@gmail.com` | `password` | Schedules, materials & grades |
| **Accountant** | `phy@gmail.com` | `password` | Accounting, fees & financial ledger |
| **Receptionist** | `ReceptionistTest@gmail.com` | `password` | Admissions, staff attendance & fees |

---

## 📋 Prerequisites

Ensure you have the following installed on your machine:
- **PHP >= 8.2** (with `pdo`, `sqlite3` or `pdo_mysql`, `mbstring`, `openssl`, `curl`)
- **Composer**
- **Node.js** (v18+ recommended) and **npm**
- **Git**

---

## 🚀 Quick Setup & Installation

### Step 1: Clone the Repository
```bash
git clone https://github.com/theinvinciblebe/School-Management-System.git
cd School-Management-System
```

### Step 2: Install Dependencies
```bash
composer install
npm install
```

### Step 3: Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### Step 4: Configure Database
The application defaults to SQLite for quick setup:
```env
DB_CONNECTION=sqlite
# database/database.sqlite will be created automatically
```
Or for MySQL:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=school_management
DB_USERNAME=root
DB_PASSWORD=
```

### Step 5: Run Database Migrations & Seeds
```bash
php artisan migrate
# (Optional) Seed demo records
php artisan db:seed
```

### Step 6: Build Assets & Start Server
```bash
# Build frontend assets
npm run build

# Start local web server
php artisan serve
```

Visit `http://localhost:8000` in your browser.

---

## 📂 Project Structure

```
School-Management-System/
├── app/
│   ├── Http/
│   │   ├── Controllers/         # Role-specific & resource controllers
│   │   │   ├── AccountingController.php   # Fee receipts, purchase requisitions, ledger
│   │   │   ├── ActivityLogController.php  # Security audit trail, filtering, export
│   │   │   ├── DashboardController.php    # Role-tailored dashboard & KPI feeds
│   │   │   ├── LoginController.php        # Authentication & session logging
│   │   │   └── ...
│   │   └── Middleware/
│   │       ├── LogUserActivity.php        # Non-blocking intelligent activity logging
│   │       ├── RoleMiddleware.php         # RBAC route guard
│   │       └── SetLocale.php              # Multi-language localization
│   └── Models/
│       ├── ActivityLog.php                # Audit log model with device/geo resolution
│       ├── User.php                       # User model with role helpers (isAdmin, etc.)
│       └── ...
├── database/
│   ├── migrations/              # Database schema migrations
│   └── database.sqlite          # SQLite database storage
├── resources/
│   └── views/
│       ├── accounting/          # Fee receipts, purchase requisitions, financial ledger
│       ├── activity_logs/       # Executive audit trail interface
│       ├── components/
│       │   ├── navbar/          # Top navigation & user profile dropdown
│       │   ├── sidebar/         # 5 role-tailored sidebars (admin, teacher, etc.)
│       │   └── pc-command-palette.blade.php # Spotlight command palette
│       ├── dashboard/           # Role-aware dashboard
│       └── layout/              # Main layout, header, footer, modals
├── routes/
│   ├── web.php                  # Web routes organized by role authorization
│   └── api.php                  # API endpoints
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
- **Audit Logging**: Every mutation (`POST`, `PUT`, `DELETE`) is captured with user details, IP, and timestamp.
- **CSRF & XSS Protection**: Token-based CSRF verification on all state-modifying endpoints with Blade automatic escaping.
- **SQL Injection Prevention**: 100% parameterized queries via Eloquent ORM and Query Builder.

---

## 📄 License

This software is released under the [MIT License](LICENSE).
