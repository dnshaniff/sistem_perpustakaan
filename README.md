## 🚀 Deployment Guide — Sistem Perpustakaan

Aplikasi ini dibangun menggunakan:

* Laravel 13
* MySQL
* AdminLTE (via Composer)

---

## 1. Persyaratan Sistem

Pastikan memiliki:

* PHP >= 8.2
* Composer
* MySQL / MariaDB

Cek versi:

```bash
php -v
composer -V
mysql --version
```

---

## 2. Clone Repository

```bash
git clone https://github.com/dnshaniff/sistem_perpustakaan.git
cd sistem_perpustakaan
```

---

## 3. Install Dependency

```bash
composer install
```

---

## 4. Konfigurasi Environment

Salin file environment:

```bash
cp .env.example .env
```

Edit konfigurasi database:

```env
APP_NAME="Sistem Perpustakaan KAG"
APP_ENV=local
APP_KEY=base64:BLzaMDgYlal3SQkC91/+JW00DGCy9O7qA6inoRSdsho=
APP_DEBUG=true
APP_URL=http://localhost:8000
APP_TIMEZONE="Asia/Jakarta"

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kag_website
DB_USERNAME=root
DB_PASSWORD=
```

---

## 5. Generate Application Key

```bash
php artisan key:generate
```

---

## 6. Migrasi Database

```bash
php artisan migrate --seed
```

---

## 7. Jalankan Aplikasi (Local)

```bash
php artisan serve
```

Akses:

```
http://127.0.0.1:8000
```

---

## 8. Struktur Role

Sistem memiliki role:

* administrator → melihat semua data (users, students, books, loans)
* user / student → melihat data history loans sesuai user_id

---
