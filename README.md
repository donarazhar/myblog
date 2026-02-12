<h1 align="center">📝 DnrAzhr Blog</h1>

<p align="center">
  <strong>Personal Blog & Portfolio Website</strong><br>
  Blog pribadi dan portofolio karya Dona R. Azhar — dibuat dengan Laravel 12
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20?logo=laravel&logoColor=white" alt="Laravel 12">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?logo=php&logoColor=white" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/Bootstrap-5.2-7952B3?logo=bootstrap&logoColor=white" alt="Bootstrap 5">
  <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?logo=mysql&logoColor=white" alt="MySQL">
</p>

<p align="center">
  🌐 <a href="https://donarazhar.site">donarazhar.site</a>
</p>

---

## 📖 Tentang

**DnrAzhr Blog** adalah website personal blog dan portofolio yang menampilkan artikel-artikel seputar teknologi, IT, dan tutorial pengembangan web. Dilengkapi admin panel lengkap untuk mengelola seluruh konten, kategori, portofolio, dan pengaturan situs. Terintegrasi dengan Google Analytics untuk tracking pengunjung.

## ✨ Fitur Utama

### 🌐 Website Publik

- **Homepage** — Artikel terbaru, portofolio unggulan, hero section dinamis
- **Blog / Artikel** — Daftar artikel dengan paginasi, filter kategori, dan SEO-friendly slug URL
- **Detail Artikel** — Rich text content, featured image, view counter, artikel terkait
- **Portofolio** — Showcase proyek dengan teknologi, client, dan link project
- **Halaman About** — Profil author dengan informasi dari pengaturan situs
- **Halaman Contact** — Formulir kontak yang tersimpan ke database
- **Google Analytics** — Tracking pengunjung terintegrasi (GA4)
- **Responsive** — Tampilan optimal di semua ukuran layar

### 🔒 Admin Panel

- **Dashboard** — Statistik artikel, kategori, portofolio, dan pesan
- **Manajemen Artikel** — CRUD artikel dengan rich text editor, featured image, status draft/published, penjadwalan publish
- **Manajemen Kategori** — CRUD kategori dengan slug otomatis, relasi ke artikel
- **Manajemen Portofolio** — CRUD proyek portofolio dengan foto, teknologi, client, dan custom ordering
- **Manajemen Pesan** — Baca & kelola pesan dari formulir kontak
- **Pengaturan Situs** — Konfigurasi nama, tagline, deskripsi, sosial media, dan informasi situs
- **Profil Admin** — Ubah nama, email, dan password

## 🛠️ Tech Stack

| Komponen   | Teknologi                      |
| ---------- | ------------------------------ |
| Backend    | Laravel 12 (PHP 8.2+)          |
| Frontend   | Blade Templates, Bootstrap 5.2 |
| Database   | MySQL 8.0                      |
| Editor     | TinyMCE (Rich Text)            |
| Analytics  | Google Analytics 4 (GA4)       |
| Build Tool | Vite                           |
| Caching    | Database Cache (Settings)      |

## 📁 Struktur Proyek

```
myblog/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/                 # Controller admin panel
│   │   │   ├── AuthController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── ArticleController.php
│   │   │   ├── CategoryController.php
│   │   │   ├── PortfolioController.php
│   │   │   ├── ContactController.php
│   │   │   ├── SettingController.php
│   │   │   └── ProfileController.php
│   │   ├── HomeController.php         # Homepage, about, contact
│   │   ├── ArticleController.php      # Artikel publik
│   │   └── PortfolioController.php    # Portofolio publik
│   └── Models/
│       ├── User.php
│       ├── Article.php          # Relasi: user, category
│       ├── Category.php         # Relasi: articles
│       ├── Portfolio.php        # Featured, ordering
│       ├── ContactMessage.php
│       └── Setting.php          # Key-value + cache
├── resources/views/
│   ├── layouts/
│   │   ├── app.blade.php        # Layout publik
│   │   └── admin.blade.php      # Layout admin
│   ├── pages/                   # Home, about, contact
│   ├── articles/                # List & detail artikel
│   ├── portfolios/              # List & detail portofolio
│   └── admin/                   # Semua halaman admin
├── routes/
│   └── web.php                  # Route publik & admin
├── database/
│   ├── migrations/
│   └── seeders/                 # 17 article seeders + DatabaseSeeder
├── config/
│   └── services.php             # Google Analytics config
└── public/
```

## 🚀 Instalasi

### Prasyarat

- PHP 8.2+
- Composer
- MySQL 8.0+
- Node.js 18+ & npm

### Langkah Instalasi

```bash
# 1. Clone repository
git clone https://github.com/donarazhar/myblog.git
cd myblog

# 2. Install dependencies
composer install
npm install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Konfigurasi database di .env
# DB_DATABASE=myblog
# DB_USERNAME=root
# DB_PASSWORD=your_password

# 5. (Opsional) Konfigurasi Google Analytics
# GOOGLE_ANALYTICS_ID=G-XXXXXXXXXX

# 6. Jalankan migration & seeder
php artisan migrate --seed

# 7. Buat storage link
php artisan storage:link

# 8. Build asset
npm run build

# 9. Jalankan server
php artisan serve
```

Atau gunakan shortcut:

```bash
composer setup          # Install + migrate + build
composer dev            # Jalankan server + queue + logs + vite bersamaan
```

### Akses

- **Website**: http://localhost:8000
- **Admin Panel**: http://localhost:8000/admin
- **Login**: http://localhost:8000/admin/login

## 📦 Database Seeders

Jalankan `php artisan db:seed` untuk mengisi konten awal. Tersedia **17 article seeder** yang berisi tutorial dan dokumentasi lengkap:

| Seeder                                | Topik                               |
| ------------------------------------- | ----------------------------------- |
| `DeploymentGuideArticleSeeder`        | Panduan deployment ke server        |
| `HarddiskRecoveryArticleSeeder`       | Recovery data dari harddisk rusak   |
| `ServerSecurityBackupArticleSeeder`   | Keamanan server & backup            |
| `KaskecilProcessArticleSeeder`        | Proses pembuatan aplikasi Kas Kecil |
| `TipsTricksArticleSeeder`             | Tips & tricks IT                    |
| `KamusDigitalParentingArticleSeeder`  | Kamus digital parenting             |
| `BuletinLiterasiDigitalArticleSeeder` | Buletin literasi digital            |
| `DataPribadiArticleSeeder`            | Keamanan data pribadi               |
| `IttdLearnhubArticleSeeder`           | Platform ITTD LearnHub              |
| `FramingArticleSeeder`                | Teknik framing informasi            |
| `MyblogArticleSeeder`                 | Dokumentasi pembuatan MyBlog        |
| `KaskecilArticleSeeder`               | Aplikasi Kas Kecil                  |
| `AiPhotoEditingArticleSeeder`         | Editing foto dengan AI              |
| `FbEngagementArticleSeeder`           | Engagement Facebook                 |
| `SignageDisplayArticleSeeder`         | Signage display digital             |
| `TaarufArticleSeeder`                 | Aplikasi Taaruf                     |

## 🌍 Deployment

### Server Requirements

- PHP 8.2+ (ekstensi: `mbstring`, `openssl`, `pdo_mysql`, `tokenizer`, `xml`, `ctype`, `json`)
- MySQL 8.0+
- Nginx / Apache
- Composer

### Deployment Steps

```bash
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
npm run build
```

> 📖 Panduan deployment lengkap tersedia di file `deployment-guide.html`

## 🔗 URL Routing

| Method | URL                   | Deskripsi            |
| ------ | --------------------- | -------------------- |
| `GET`  | `/`                   | Homepage             |
| `GET`  | `/about`              | Halaman about        |
| `GET`  | `/contact`            | Halaman kontak       |
| `POST` | `/contact`            | Submit pesan kontak  |
| `GET`  | `/articles`           | Daftar artikel       |
| `GET`  | `/articles/{slug}`    | Detail artikel       |
| `GET`  | `/category/{slug}`    | Artikel per kategori |
| `GET`  | `/portfolio`          | Daftar portofolio    |
| `GET`  | `/portfolio/{slug}`   | Detail portofolio    |
| `GET`  | `/admin/dashboard`    | Dashboard admin      |
| `*`    | `/admin/articles/*`   | CRUD artikel         |
| `*`    | `/admin/categories/*` | CRUD kategori        |
| `*`    | `/admin/portfolios/*` | CRUD portofolio      |
| `GET`  | `/admin/contacts`     | Manajemen pesan      |
| `GET`  | `/admin/settings`     | Pengaturan situs     |
| `GET`  | `/admin/profile`      | Profil admin         |

## 📝 Lisensi

Project ini dibuat oleh **Dona R. Azhar** — [donarazhar.site](https://donarazhar.site)
