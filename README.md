<p align="center">
  <img src="public/assets/img/logo_polos.png" alt="Auth Starter Kit Admin Logo" width="200"/>
</p>

<h1 align="center">Auth Starter Kit - Backend API</h1>

<p align="center">
  <strong>Laravel REST API with Sanctum authentication system</strong>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.0-FF2D20?logo=laravel" alt="Laravel Version"/>
  <img src="https://img.shields.io/badge/PHP-8.2-777BB4?logo=php" alt="PHP Version"/>
  <img src="https://img.shields.io/badge/Authentication-Sanctum-4FC08D" alt="Sanctum"/>
  <img src="https://img.shields.io/badge/Database-MySQL-4479A1?logo=mysql" alt="MySQL"/>
  <img src="https://img.shields.io/badge/License-MIT-green" alt="License"/>
</p>

---

## 🚀 Tentang Aplikasi

**Auth Starter Kit Backend** adalah REST API yang dibangun dengan Laravel 12 dan Laravel Sanctum untuk menyediakan sistem autentikasi yang aman dan scalable. API ini dirancang untuk mendukung aplikasi mobile dan web dengan fitur login, register, logout, dan manajemen token.

### ✨ Fitur Utama

- 🔐 **Laravel Sanctum** - Token-based authentication
- 📱 **Device Tracking** - Mencatat setiap device yang login
- 🔒 **Token Management** - Create, revoke, dan manage access tokens
- 👤 **User Management** - Register, login, dan profile management
- 🛡️ **Secure API** - Protected routes dengan middleware auth:sanctum
- 📊 **Database Migration** - Schema management dengan migrations
- 🧪 **Testing Ready** - Pest PHP untuk unit & feature testing
- ⚡ **Fast Development** - Hot reload dengan Vite

---

## 🏗️ Arsitektur

Aplikasi ini menggunakan arsitektur **MVC (Model-View-Controller)** dengan struktur Laravel standar:

```
admin/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── api/
│   │           └── AuthController.php    # Authentication logic
│   └── Models/
│       └── User.php                      # User model
├── database/
│   ├── migrations/                       # Database schema
│   └── seeders/                          # Database seeders
├── routes/
│   ├── api.php                           # API routes
│   └── web.php                           # Web routes
├── config/
│   ├── sanctum.php                       # Sanctum configuration
│   └── cors.php                          # CORS configuration
└── public/
    └── assets/                           # Public assets
```

---

## 📡 API Endpoints

### Authentication Endpoints

| Method | Endpoint        | Auth Required | Description                   |
| ------ | --------------- | ------------- | ----------------------------- |
| POST   | `/api/login`    | ❌ No         | Login dengan email & password |
| POST   | `/api/register` | ❌ No         | Register user baru            |
| POST   | `/api/logout`   | ✅ Yes        | Logout & revoke token         |
| GET    | `/api/me`       | ✅ Yes        | Get authenticated user info   |

### Request & Response Examples

#### 1. Login

**Request:**

```http
POST /api/login
Content-Type: application/json

{
  "email": "user@example.com",
  "password": "password123",
  "device_name": "iPhone 14 Pro",
  "device_os": "iOS 17.0",
  "device_identifier": "unique-device-id"
}
```

**Response (Success):**

```json
{
    "success": true,
    "message": "Login successful",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "user@example.com",
            "created_at": "2026-02-06T08:00:00.000000Z"
        },
        "token": "1|abcdefghijklmnopqrstuvwxyz1234567890"
    }
}
```

**Response (Failed):**

```json
{
    "success": false,
    "message": "Invalid credentials",
    "data": null
}
```

#### 2. Register

**Request:**

```http
POST /api/register
Content-Type: application/json

{
  "name": "John Doe",
  "email": "user@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Response:**

```json
{
    "success": true,
    "message": "User registered successfully",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "user@example.com"
        },
        "token": "1|abcdefghijklmnopqrstuvwxyz1234567890"
    }
}
```

#### 3. Logout

**Request:**

```http
POST /api/logout
Authorization: Bearer {token}
```

**Response:**

```json
{
    "success": true,
    "message": "Logged out successfully",
    "data": null
}
```

#### 4. Get User Info

**Request:**

```http
GET /api/me
Authorization: Bearer {token}
```

**Response:**

```json
{
    "success": true,
    "message": "User retrieved successfully",
    "data": {
        "id": 1,
        "name": "John Doe",
        "email": "user@example.com",
        "email_verified_at": null,
        "created_at": "2026-02-06T08:00:00.000000Z",
        "updated_at": "2026-02-06T08:00:00.000000Z"
    }
}
```

---

## 🚀 Instalasi & Setup

### Prasyarat

Pastikan Anda sudah menginstall:

- PHP >= 8.2
- Composer
- MySQL / PostgreSQL / SQLite
- Node.js & npm (untuk Vite)
- Git

### Langkah Instalasi

1. **Clone repository**

    ```bash
    git clone <repository-url>
    cd auth-starter-kit/admin
    ```

2. **Install PHP dependencies**

    ```bash
    composer install
    ```

3. **Install Node dependencies**

    ```bash
    npm install
    ```

4. **Setup environment**

    ```bash
    # Copy .env.example ke .env
    cp .env.example .env

    # Generate application key
    php artisan key:generate
    ```

5. **Konfigurasi database**

    Edit file `.env`:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=auth_starter_kit
    DB_USERNAME=root
    DB_PASSWORD=
    ```

6. **Jalankan migration**

    ```bash
    php artisan migrate
    ```

7. **Seed database (optional)**

    ```bash
    php artisan db:seed
    ```

8. **Jalankan development server**

    ```bash
    # Opsi 1: Jalankan semua service sekaligus (recommended)
    composer dev

    # Opsi 2: Jalankan manual
    php artisan serve --host=0.0.0.0
    npm run dev
    ```

---

## 🔧 Konfigurasi

### Laravel Sanctum

Konfigurasi Sanctum ada di `config/sanctum.php`:

```php
'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', sprintf(
    '%s%s',
    'localhost,localhost:3000,127.0.0.1,127.0.0.1:8000,::1',
    env('APP_URL') ? ','.parse_url(env('APP_URL'), PHP_URL_HOST) : ''
))),
```

### CORS Configuration

Edit `config/cors.php` untuk mengatur allowed origins:

```php
'paths' => ['api/*', 'sanctum/csrf-cookie'],
'allowed_origins' => ['*'],
'allowed_methods' => ['*'],
'allowed_headers' => ['*'],
```

### Environment Variables

Penting untuk dikonfigurasi di `.env`:

```env
APP_NAME="Auth Starter Kit"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=auth_starter_kit
DB_USERNAME=root
DB_PASSWORD=

# Sanctum
SANCTUM_STATEFUL_DOMAINS=localhost:3000,127.0.0.1:8000
```

---

## 🗄️ Database Schema

### Users Table

| Column            | Type         | Description                  |
| ----------------- | ------------ | ---------------------------- |
| id                | bigint       | Primary key                  |
| name              | varchar(255) | User's full name             |
| email             | varchar(255) | User's email (unique)        |
| email_verified_at | timestamp    | Email verification timestamp |
| password          | varchar(255) | Hashed password              |
| remember_token    | varchar(100) | Remember me token            |
| created_at        | timestamp    | Creation timestamp           |
| updated_at        | timestamp    | Last update timestamp        |

### Personal Access Tokens Table (Sanctum)

| Column         | Type         | Description                 |
| -------------- | ------------ | --------------------------- |
| id             | bigint       | Primary key                 |
| tokenable_type | varchar(255) | Model type (User)           |
| tokenable_id   | bigint       | User ID                     |
| name           | varchar(255) | Token name (device info)    |
| token          | varchar(64)  | Hashed token                |
| abilities      | text         | Token abilities/permissions |
| last_used_at   | timestamp    | Last usage timestamp        |
| expires_at     | timestamp    | Expiration timestamp        |
| created_at     | timestamp    | Creation timestamp          |
| updated_at     | timestamp    | Last update timestamp       |

---

## 🛡️ Keamanan

### Best Practices yang Diterapkan

- ✅ **Password Hashing** - Menggunakan bcrypt untuk hash password
- ✅ **Token Encryption** - Token di-hash sebelum disimpan di database
- ✅ **CSRF Protection** - Built-in CSRF protection untuk web routes
- ✅ **Rate Limiting** - Throttle untuk mencegah brute force
- ✅ **SQL Injection Prevention** - Eloquent ORM dengan prepared statements
- ✅ **XSS Protection** - Auto-escaping di Blade templates
- ✅ **HTTPS Ready** - Siap untuk production dengan HTTPS

### Middleware Protection

Protected routes menggunakan `auth:sanctum` middleware:

```php
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum');

Route::get('/me', [AuthController::class, 'me'])
    ->middleware('auth:sanctum');
```

---

## 🧪 Testing

### Menjalankan Tests

```bash
# Jalankan semua tests
php artisan test

# Atau menggunakan Pest
./vendor/bin/pest

# Dengan coverage
php artisan test --coverage
```

### Membuat Test Baru

```bash
# Feature test
php artisan make:test AuthTest

# Unit test
php artisan make:test UserTest --unit
```

---

## 📦 Dependencies

### PHP Packages

| Package             | Version | Fungsi                   |
| ------------------- | ------- | ------------------------ |
| `laravel/framework` | ^12.0   | Laravel framework core   |
| `laravel/sanctum`   | ^4.3    | API token authentication |
| `laravel/tinker`    | ^2.10   | REPL untuk debugging     |

### Dev Dependencies

| Package        | Version | Fungsi                         |
| -------------- | ------- | ------------------------------ |
| `pestphp/pest` | ^4.3    | Testing framework              |
| `laravel/pint` | ^1.24   | Code style fixer               |
| `laravel/sail` | ^1.41   | Docker development environment |

### Frontend Dependencies

| Package       | Version | Fungsi              |
| ------------- | ------- | ------------------- |
| `vite`        | ^7.0.7  | Frontend build tool |
| `tailwindcss` | ^4.0.0  | CSS framework       |
| `axios`       | ^1.11.0 | HTTP client         |

---
