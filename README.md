# 📚 School Management System

A comprehensive web-based school management system built with **Laravel**, **JavaScript**, and **CSS**. This application provides complete functionality for managing school operations including student information, attendance, grades, schedules, and administrative tasks.

---

## 🎯 Features

### Core Functionality
- **Student Management** - Register, manage, and track student information
- **Staff Management** - Employee records, roles, and permissions
- **Accounting Management** - Receipt, Purchase Request, and Profit&Lost
- **Class Management** - Create and organize classes with grade levels
- **Attendance Tracking** - Mark and monitor student and staff attendance
- **Grade Management** - Record and manage student grades and academic performance
- **Timetable/Schedule** - Create and manage class schedules and timetables
- **User Authentication** - Secure login system with role-based access control
- **Reports** - Generate various reports (attendance, grades, enrollment, etc.)
- **Dashboard** - Customizable admin dashboard with key metrics
- **Notifications** - System notifications for important events

---

## 🛠️ Tech Stack

| Component | Technology | Version |
|-----------|-----------|---------|
| **Backend Framework** | Laravel | 11.9 |
| **PHP Version** | PHP | 8.2+ |
| **Frontend** | JavaScript (Vanilla) | ES6+ |
| **Build Tool** | Vite | 5.4.11 |
| **Database** | SQLite (default) / MySQL | - |
| **Styling** | CSS / SCSS | - |
| **Template Engine** | Blade | - |
| **PDF Generation** | DomPDF | 3.1 |
| **QR Code** | Simple QRCode | 4.2 |
| **Permissions** | Spatie Laravel Permission | 6.10 |

### Language Composition
- **JavaScript**: 77.8%
- **CSS**: 8.4%
- **PHP**: 7.3%
- **Blade**: 5.0%
- **SCSS**: 1.4%
- **HTML**: 0.1%

---

## 📋 Prerequisites

Before you begin, ensure you have the following installed:

- **PHP 8.2 or higher**
- **Composer** (PHP dependency manager)
- **Node.js** and **npm** (for frontend dependencies)
- **Git** (for version control)
- **Database**: MySQL, PostgreSQL, or SQLite

---

## 🚀 Installation

### Step 1: Clone the Repository

```bash
git clone https://github.com/theinvinciblebe/School-Management-System.git
cd School-Management-System
```

### Step 2: Install PHP Dependencies

```bash
composer install
```

### Step 3: Install Node Dependencies

```bash
npm install
```

### Step 4: Environment Setup

Copy the environment example file and configure it:

```bash
cp .env.example .env
```

Edit the `.env` file and set your configuration:

```env
APP_NAME=SchoolManagementSystem
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=school_management
DB_USERNAME=root
DB_PASSWORD=

# Mail Configuration (optional)
MAIL_MAILER=log
MAIL_FROM_ADDRESS=school@example.com
MAIL_FROM_NAME="School Management System"
```

### Step 5: Generate Application Key

```bash
php artisan key:generate
```

### Step 6: Run Database Migrations

```bash
php artisan migrate
```

### Step 7: (Optional) Seed Database with Sample Data

```bash
php artisan db:seed
```

### Step 8: Build Frontend Assets

```bash
npm run build
```

For development with hot reload:

```bash
npm run dev
```

### Step 9: Start the Development Server

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

---

## 📂 Project Structure

```
School-Management-System/
├── app/                          # Application logic
│   ├── Http/
│   │   ├── Controllers/         # Application controllers
│   │   └── Middleware/          # HTTP middleware
│   ├── Models/                  # Eloquent models
│   └── Services/                # Business logic services
├── bootstrap/                   # Application bootstrap
├── config/                      # Configuration files
├── database/
│   ├── migrations/              # Database migrations
│   ├── seeders/                 # Database seeders
│   └── factories/               # Model factories for testing
├── public/                      # Publicly accessible files
│   ├── css/                     # Compiled CSS
│   ├── js/                      # Compiled JavaScript
│   └── images/                  # Image assets
├── resources/
│   ├── views/                   # Blade templates
│   ├── css/                     # Source CSS/SCSS files
│   └── js/                      # Source JavaScript files
├── routes/                      # Application routes
│   ├── web.php                  # Web routes
│   └── api.php                  # API routes
├── storage/                     # Application storage
│   ├── logs/                    # Log files
│   └── app/                     # File storage
├── tests/                       # Test files
├── vendor/                      # Composer dependencies
├── node_modules/                # NPM dependencies
├── composer.json                # PHP dependencies
├── package.json                 # Node dependencies
├── vite.config.js              # Vite configuration
├── phpunit.xml                 # PHPUnit configuration
├── artisan                     # Laravel CLI tool
└── README.md                   # This file
```

---

## 🔐 Database Setup

### Using SQLite (Default - Quick Setup)
The default configuration uses SQLite. Simply run migrations:
```bash
php artisan migrate
```

### Using MySQL
Update `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=school_management
DB_USERNAME=root
DB_PASSWORD=your_password
```

Then run migrations:
```bash
php artisan migrate
```

### Import Existing Database
If you have an existing database file (`mawarid_db.sql`):
```bash
mysql -u root -p school_management < mawarid_db.sql
```

---

## 👥 User Roles & Permissions

The system includes role-based access control with the following roles:

- **Administrator** - Full access to all features
- **Teacher** - Access to class management, attendance, grades
- **Student** - View personal grades, attendance, schedule
- **Parent** - View child's grades, attendance, and progress
- **Office Staff** - Handle administrative and enrollment tasks

---

## 🔑 Key Dependencies

### Backend Dependencies
- **laravel/framework**: Core Laravel framework
- **barryvdh/laravel-dompdf**: PDF generation for reports and certificates
- **simplesoftwareio/simple-qrcode**: QR code generation
- **spatie/laravel-permission**: Role and permission management
- **laravel/tinker**: Interactive shell

### Frontend Dependencies
- **axios**: HTTP client for API requests
- **vite**: Build tool and development server
- **laravel-vite-plugin**: Vite integration with Laravel

### Development Dependencies
- **laravel/sail**: Docker development environment
- **phpunit/phpunit**: PHP testing framework
- **fakerphp/faker**: Fake data generation for testing
- **laravel/pint**: PHP code style fixer

---

## 📖 Usage Guide

### Login
1. Navigate to `http://localhost:8000`
2. Log in with your credentials
3. Default admin credentials are set during installation (check seeders)

### Dashboard
- View system statistics and key metrics
- Quick access to frequently used features
- Recent activities and notifications

### Managing Students
- Go to **Students** section
- Click **Add New Student** to register
- Fill in student information and assign to class
- Manage student status (active, graduated, transferred, etc.)

### Managing Attendance
- Navigate to **Attendance**
- Select class and date
- Mark attendance for each student
- Save and view attendance reports

### Managing Grades
- Go to **Grades** section
- Select subject, class, and assessment period
- Enter grades for each student
- Generate grade reports

### Generating Reports
- Multiple report types available:
<<<<<<< HEAD
    - Attendance reports
    - Grade reports
    - Enrollment statistics
    - Performance analytics
=======
  - Attendance reports
  - Grade reports
  - Enrollment statistics
  - Performance analytics
>>>>>>> d50e472f272e7df09fcd8850cd9616fd6c5fed8b
- Export reports to PDF

---

## 🛡️ Security Features

- **Authentication**: Secure login with password hashing (Bcrypt)
- **Authorization**: Role-based access control (RBAC)
- **CSRF Protection**: Token-based CSRF protection on all forms
- **SQL Injection Prevention**: Parameterized queries via Eloquent ORM
- **XSS Protection**: Blade template auto-escaping
- **Rate Limiting**: API rate limiting to prevent abuse
- **Password Reset**: Secure password reset functionality

---

## 🧪 Testing

Run the test suite:

```bash
php artisan test
```

Run specific test file:

```bash
php artisan test tests/Feature/StudentTest.php
```

Run with coverage:

```bash
php artisan test --coverage
```

---

## 🐛 Troubleshooting

### Common Issues

#### 1. Composer Install Fails
```bash
composer update
composer dump-autoload
```

#### 2. NPM Build Errors
```bash
rm -rf node_modules package-lock.json
npm install
npm run build
```

#### 3. Database Connection Error
- Verify database credentials in `.env`
- Ensure database server is running
- Create the database: `mysql -u root -p -e "CREATE DATABASE school_management;"`

#### 4. Permission Errors
```bash
chmod -R 775 storage bootstrap/cache
```

#### 5. Key Not Generated
```bash
php artisan key:generate
```

---

## 📝 Environment Variables

Key environment variables in `.env`:

```env
APP_NAME               # Application name
APP_ENV                # Environment (local, production)
APP_DEBUG              # Debug mode (true/false)
APP_URL                # Base URL of application
APP_TIMEZONE           # Application timezone
DB_CONNECTION          # Database type
DB_HOST                # Database host
DB_DATABASE            # Database name
DB_USERNAME            # Database user
DB_PASSWORD            # Database password
MAIL_MAILER            # Mail driver
LOG_LEVEL              # Log level
SESSION_DRIVER         # Session storage
CACHE_STORE            # Cache storage
```

---

## 📚 API Documentation

The system provides RESTful APIs for integration. Common endpoints:

- `GET /api/students` - List all students
- `POST /api/students` - Create new student
- `GET /api/students/{id}` - Get student details
- `PUT /api/students/{id}` - Update student
- `DELETE /api/students/{id}` - Delete student
- `GET /api/classes` - List all classes
- `GET /api/attendance` - Get attendance records
- `GET /api/grades` - Get grade records

See `routes/api.php` for complete API routes.

---

## 🚢 Deployment

### Deploying to Production

1. **Clone Repository**
   ```bash
   git clone https://github.com/theinvinciblebe/School-Management-System.git
   cd School-Management-System
   ```

2. **Install Dependencies**
   ```bash
   composer install --no-dev
   npm ci
   ```

3. **Set Environment**
   ```bash
   cp .env.example .env
   # Edit .env with production settings
   php artisan key:generate
   ```

4. **Build Assets**
   ```bash
   npm run build
   ```

5. **Run Migrations**
   ```bash
   php artisan migrate --force
   ```

6. **Optimize Performance**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

7. **Set Permissions**
   ```bash
   chown -R www-data:www-data /path/to/app
   chmod -R 755 storage bootstrap/cache
   ```

---

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. **Fork** the repository
2. **Create** a feature branch (`git checkout -b feature/amazing-feature`)
3. **Make** your changes
4. **Commit** your changes (`git commit -m 'Add amazing feature'`)
5. **Push** to the branch (`git push origin feature/amazing-feature`)
6. **Open** a Pull Request

### Code Standards
- Follow PSR-12 PHP coding standards
- Use Laravel conventions
- Write tests for new features
- Keep commits atomic and descriptive

---

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.

---

## 👨‍💻 Author

**theinvinciblebe**

GitHub: [@theinvinciblebe](https://github.com/theinvinciblebe)

---

## 🆘 Support

For support, please:

1. Check existing [Issues](https://github.com/theinvinciblebe/School-Management-System/issues)
2. Create a [New Issue](https://github.com/theinvinciblebe/School-Management-System/issues/new) with detailed description
3. Include error messages, steps to reproduce, and environment details

---

## 📞 Contact

For inquiries or questions about the School Management System, please open an issue on GitHub.

---

## 🙏 Acknowledgments

- Laravel community for the excellent framework
- Contributors and supporters
- Educational institutions using this system

---

## 📅 Changelog

See [CHANGELOG.md](CHANGELOG.md) for version history and updates.

---

## ⭐ Show Your Support

If you found this project helpful, please give it a star! It helps others discover the project.

---

**Last Updated**: May 14, 2026

**Version**: 1.0.0
