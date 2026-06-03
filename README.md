# SPK VIKOR BANSOS

Sistem Pendukung Keputusan (SPK) untuk penentuan penerima bantuan sosial (BANSOS) menggunakan metode **VIKOR**. Dibangun dengan PHP Native dan Bootstrap 5 untuk tampilan yang profesional dan responsif.

## 🚀 Fitur Utama
- **Autentikasi Pengguna**: Login, Registrasi, dan Logout dengan keamanan password hashing.
- **Manajemen User**: Pengelolaan data admin dan pengguna (CRUD).
- **UI Modern**: Interface bersih dan profesional menggunakan Bootstrap 5 dan Google Fonts (Inter).
- **Arsitektur Rapi**: Pemisahan antara logika (Actions), tampilan (Pages), dan komponen (Templates).

## 🛠️ Teknologi yang Digunakan
- **Bahasa Pemrograman**: PHP 8.x (Native)
- **Database**: MySQL (MariaDB)
- **Frontend Framework**: Bootstrap 5.3
- **Icon & Font**: Bootstrap Icons & Google Fonts (Inter)
- **Database Driver**: PDO (PHP Data Objects)

## 📁 Struktur Proyek
```text
project-root/
├── actions/              # Logika proses (Login, CRUD logic, dll)
├── includes/             # Core system (Database, Helpers, Functions)
├── pages/                # Tampilan Halaman Utama (UI)
│   ├── auth/             # Login & Register
│   └── users/            # Fitur Manajemen User
├── public/               # Assets (CSS, JS, Gambar)
├── templates/            # Komponen reusable (Header, Footer, Navbar)
├── database.sql          # Schema Database
├── index.php             # Entry Point
└── README.md
```

## ⚙️ Instalasi & Persiapan

### 1. Prasyarat
Pastikan Anda sudah menginstal:
- Web Server (XAMPP / Laragon / Apache)
- PHP >= 7.4
- MySQL Database

### 2. Kloning Proyek
Letakkan folder proyek di direktori web server Anda (`htdocs` atau `www`).
```bash
git clone https://github.com/username/spk-vikor-bansos.git
```

### 3. Konfigurasi Database
1. Buat database baru di phpMyAdmin dengan nama `spk_vikor_bansos`.
2. Impor file `database.sql` ke database tersebut.
3. Sesuaikan konfigurasi database di file `includes/db.php`:
```php
$host = 'localhost';
$db   = 'spk_vikor_bansos';
$user = 'root';
$pass = '';
```

### 4. Jalankan Proyek
Buka browser dan akses:
`http://localhost/spk-vikor-bansos/`

## 🔐 Akun Default
Setelah registrasi, user akan masuk ke database. Anda dapat menggunakan fitur **Register** di halaman login untuk membuat akun pertama.

---
Dikembangkan dengan ❤️ untuk kemudahan pengelolaan bantuan sosial.
