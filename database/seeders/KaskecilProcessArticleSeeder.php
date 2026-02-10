<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class KaskecilProcessArticleSeeder extends Seeder
{
    public function run(): void
    {
        // Get admin user
        $admin = User::where('is_admin', true)->first();

        if (!$admin) {
            $this->command->warn('No admin user found. Please run DatabaseSeeder first.');
            return;
        }

        // Get or create category for Tutorial
        $category = Category::firstOrCreate(
            ['name' => 'Tutorial'],
            ['description' => 'Tutorial dan panduan pengembangan aplikasi']
        );

        // Create or Update Kaskecil Development Process article
        Article::updateOrCreate(
            ['slug' => 'proses-pembuatan-aplikasi-kaskecil-monorepo'],
            [
                'title' => 'Panduan Lengkap Membangun Aplikasi Kas Kecil: Monorepo, Backend, Frontend, dan Mobile',
                'excerpt' => 'Dokumentasi detail proses pembuatan aplikasi Kas Kecil dari nol — mulai dari arsitektur monorepo, backend Laravel API, frontend React, hingga build APK mobile dengan Expo EAS. Termasuk tips penting seputar node_modules, .easignore, dan workflow GitHub.',
                'content' => '
<p>Membangun aplikasi multi-platform (web dan mobile) dari nol adalah proses yang kompleks. Dalam artikel ini, saya akan membagikan secara detail bagaimana proses pembuatan <strong>Aplikasi Kas Kecil (Petty Cash)</strong> — sebuah sistem pengelolaan keuangan berbasis metode Imprest yang berjalan di web dan mobile. Artikel ini bisa menjadi panduan referensi untuk membangun aplikasi serupa di masa depan.</p>

<h2>📋 Gambaran Proyek</h2>
<p>Kas Kecil adalah aplikasi untuk mengelola dana kas kecil (petty cash) di organisasi multi-level. Fitur utamanya meliputi:</p>
<ul>
    <li>Manajemen organisasi hierarkis: Instansi → Cabang → Unit</li>
    <li>Input transaksi pengeluaran dan pengisian kas (metode Imprest/Dana Tetap)</li>
    <li>Role-based access: Super Admin dan Admin Unit</li>
    <li>Upload bukti transaksi (lampiran)</li>
    <li>Dashboard dan laporan keuangan</li>
    <li>Tersedia di Web (admin panel) dan Mobile (untuk petugas lapangan)</li>
</ul>

<h2>🏗️ Arsitektur Monorepo</h2>

<h3>Apa Itu Monorepo?</h3>
<p><strong>Monorepo</strong> adalah pendekatan di mana semua bagian aplikasi (backend, frontend, mobile) disimpan dalam <strong>satu repository GitHub</strong> yang sama. Ini berbeda dengan pendekatan multi-repo di mana setiap bagian memiliki repository terpisah.</p>

<h3>Mengapa Monorepo?</h3>
<ul>
    <li><strong>Satu tempat</strong> — Semua kode ada di satu repo, mudah di-clone dan di-manage</li>
    <li><strong>Konsistensi</strong> — Perubahan di backend dan frontend bisa di-commit bersamaan</li>
    <li><strong>Shared code</strong> — Bisa berbagi logic, tipe data, dan validasi antara web dan mobile</li>
    <li><strong>Satu history</strong> — Git log menampilkan keseluruhan perjalanan proyek</li>
</ul>

<h3>Struktur Folder Monorepo Kas Kecil</h3>
<pre><code>kaskecil/                    # Root monorepo
├── api/                     # Backend - Laravel 12 (REST API)
│   ├── app/                 # Models, Controllers, Services
│   ├── database/            # Migrations, Seeders
│   ├── routes/              # API routes
│   ├── composer.json        # PHP dependencies
│   └── .env                 # Environment variables
│
├── web/                     # Frontend - React + Vite + Tailwind
│   ├── src/                 # Components, Pages, Hooks
│   ├── package.json         # Node dependencies (KHUSUS web)
│   ├── vite.config.ts       # Vite build configuration
│   └── tailwind.config.js   # Tailwind CSS configuration
│
├── mobile/                  # Mobile - React Native + Expo
│   ├── src/                 # Screens, Components, Navigation
│   ├── app.json             # Expo configuration
│   ├── eas.json             # EAS Build profiles
│   ├── package.json         # Node dependencies (KHUSUS mobile)
│   └── .easignore           # File exclusion untuk EAS Build
│
├── docs/                    # Dokumentasi
├── package.json             # Root package.json (scripts global)
├── .gitignore               # Git ignore rules
└── nginx_kaskecil.conf      # Konfigurasi Nginx untuk deployment</code></pre>

<h3>Root package.json — Script Lintas Proyek</h3>
<p>File <code>package.json</code> di root monorepo berisi script shortcut untuk menjalankan berbagai bagian aplikasi tanpa perlu pindah-pindah folder:</p>
<pre><code>{
  "name": "kas-kecil-monorepo",
  "scripts": {
    "api:dev": "cd api && php artisan serve",
    "web:dev": "cd web && npm run dev",
    "mobile:dev": "cd mobile && npm start",
    "api:migrate": "cd api && php artisan migrate",
    "api:seed": "cd api && php artisan db:seed",
    "install:all": "cd web && npm install && cd ../mobile && npm install"
  }
}</code></pre>
<p>Dengan script ini, Anda cukup menjalankan <code>npm run api:dev</code> dari root folder untuk menjalankan backend, tanpa perlu <code>cd api</code> dulu secara manual.</p>

<h2>⚙️ Backend — Laravel REST API</h2>

<h3>Pemilihan Teknologi</h3>
<ul>
    <li><strong>Laravel 12</strong> — Framework PHP yang mature dan memiliki ekosistem lengkap</li>
    <li><strong>PHP 8.2+</strong> — Versi PHP terbaru dengan fitur modern (typed properties, enums, dll)</li>
    <li><strong>PostgreSQL</strong> — Database relasional yang powerful, lebih cocok untuk data keuangan karena mendukung transaksi ACID dengan lebih baik</li>
    <li><strong>Laravel Sanctum</strong> — Autentikasi token-based yang ringan, cocok untuk SPA dan mobile app</li>
</ul>

<h3>Proses Pembuatan Backend</h3>
<p><strong>1. Inisialisasi Project Laravel:</strong></p>
<pre><code># Buat project Laravel baru di folder api/
composer create-project laravel/laravel api

# Masuk ke folder
cd api

# Install Sanctum untuk autentikasi API
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"</code></pre>

<p><strong>2. Desain Database (Migration):</strong></p>
<p>Sistem Kas Kecil memiliki struktur hierarki organisasi yang kompleks. Migration dibuat berurutan sesuai dependency:</p>
<pre><code># Urutan migration (dependency-based)
php artisan make:migration create_instansi_table      # Level 1: Organisasi induk
php artisan make:migration create_cabang_table        # Level 2: Cabang (FK ke instansi)
php artisan make:migration create_unit_table          # Level 3: Unit kerja (FK ke cabang)
php artisan make:migration create_roles_table         # Roles (Super Admin, Admin Unit)
php artisan make:migration create_users_table         # Users (FK ke role, cabang, unit)
php artisan make:migration create_akun_aas_table      # Akun AAS (FK ke unit)
php artisan make:migration create_akun_ma_table       # Mata Anggaran (FK ke akun AAS)
php artisan make:migration create_transaksi_table     # Transaksi (FK ke unit, user)</code></pre>

<p><strong>3. Model dan Relationship:</strong></p>
<p>Setiap model menggunakan Eloquent relationship untuk menghubungkan data:</p>
<pre><code>// Contoh: Model Unit
class Unit extends Model {
    public function cabang() { return $this->belongsTo(Cabang::class); }
    public function users() { return $this->hasMany(User::class); }
    public function transaksi() { return $this->hasMany(Transaksi::class); }
    public function akunAas() { return $this->hasMany(AkunAas::class); }
}</code></pre>

<p><strong>4. API Routes dan Controller:</strong></p>
<p>Semua endpoint dibuat sebagai REST API (tidak menggunakan Blade view), karena frontend terpisah:</p>
<pre><code>// routes/api.php
Route::middleware(\'auth:sanctum\')->group(function () {
    Route::apiResource(\'instansi\', InstansiController::class);
    Route::apiResource(\'cabang\', CabangController::class);
    Route::apiResource(\'unit\', UnitController::class);
    Route::apiResource(\'transaksi\', TransaksiController::class);
    Route::get(\'/dashboard\', [DashboardController::class, \'index\']);
});</code></pre>

<p><strong>5. Autentikasi dengan Sanctum:</strong></p>
<p>Sanctum menggunakan token-based auth. Setelah login, client menerima token yang harus disertakan di setiap request:</p>
<pre><code>// Login endpoint mengembalikan token
$token = $user->createToken(\'auth-token\')->plainTextToken;

// Client mengirim token di header:
// Authorization: Bearer {token}</code></pre>

<h2>🖥️ Frontend Web — React + Vite</h2>

<h3>Pemilihan Teknologi</h3>
<ul>
    <li><strong>React 18</strong> — Library UI yang paling populer dengan ekosistem besar</li>
    <li><strong>Vite</strong> — Build tool yang sangat cepat dibanding Webpack</li>
    <li><strong>TypeScript</strong> — Type safety untuk mengurangi bug</li>
    <li><strong>Tailwind CSS</strong> — Utility-first CSS framework untuk styling cepat</li>
    <li><strong>Radix UI</strong> — Unstyled, accessible component library</li>
    <li><strong>TanStack React Query</strong> — Data fetching dan caching hook</li>
    <li><strong>Zustand</strong> — State management yang ringan dan simpel</li>
    <li><strong>React Hook Form + Zod</strong> — Form handling dengan validasi schema</li>
</ul>

<h3>Proses Pembuatan Frontend</h3>
<p><strong>1. Inisialisasi Project React:</strong></p>
<pre><code># Buat project Vite + React + TypeScript
npm create vite@latest web -- --template react-ts

# Masuk ke folder web
cd web

# Install dependencies
npm install

# Install Tailwind CSS
npm install -D tailwindcss postcss autoprefixer
npx tailwindcss init -p

# Install UI dan state libraries
npm install @radix-ui/react-select @radix-ui/react-dropdown-menu
npm install @tanstack/react-query axios zustand
npm install react-router-dom react-hook-form @hookform/resolvers zod</code></pre>

<p><strong>2. Struktur Folder Frontend:</strong></p>
<pre><code>web/src/
├── components/          # Reusable UI components (Button, Modal, Table, dll)
│   └── ui/              # Base components (Radix-based)
├── pages/               # Halaman-halaman (Dashboard, Transaksi, Users, dll)
├── hooks/               # Custom hooks (useAuth, useTransaksi, dll)
├── lib/                 # API client, utility functions
├── stores/              # Zustand stores (auth store, UI store)
├── types/               # TypeScript type definitions
├── App.tsx              # Root component + Router
└── main.tsx             # Entry point</code></pre>

<p><strong>3. API Client Pattern:</strong></p>
<p>Semua komunikasi ke backend menggunakan Axios dengan interceptor untuk menyertakan token otomatis:</p>
<pre><code>// lib/api-client.ts
const apiClient = axios.create({
  baseURL: import.meta.env.VITE_API_URL, // dari .env
  headers: { \'Content-Type\': \'application/json\' }
});

// Interceptor: otomatis tambah token di setiap request
apiClient.interceptors.request.use((config) => {
  const token = localStorage.getItem(\'auth_token\');
  if (token) config.headers.Authorization = `Bearer ${token}`;
  return config;
});</code></pre>

<h2>📱 Mobile — React Native + Expo</h2>

<h3>Pemilihan Teknologi</h3>
<ul>
    <li><strong>React Native 0.81</strong> — Framework mobile cross-platform berbasis React</li>
    <li><strong>Expo SDK 54</strong> — Toolchain dan runtime yang mempermudah pengembangan React Native</li>
    <li><strong>NativeWind</strong> — Tailwind CSS untuk React Native (styling konsisten dengan web)</li>
    <li><strong>React Navigation</strong> — Navigasi screen (Stack, Tab, dll)</li>
    <li><strong>Expo Secure Store</strong> — Penyimpanan token yang aman (keychain/keystore)</li>
    <li><strong>EAS Build</strong> — Cloud build service untuk menghasilkan APK/AAB</li>
</ul>

<h3>Proses Pembuatan Mobile</h3>
<p><strong>1. Inisialisasi Project Expo:</strong></p>
<pre><code># Buat project Expo baru di folder mobile/
npx create-expo-app mobile --template blank-typescript

# Masuk ke folder
cd mobile

# Install navigation
npm install @react-navigation/native @react-navigation/native-stack @react-navigation/bottom-tabs
npm install react-native-screens react-native-safe-area-context

# Install NativeWind (Tailwind untuk RN)
npm install nativewind
npm install -D tailwindcss@3.3.2

# Install data fetching dan form
npm install @tanstack/react-query axios react-hook-form zod

# Install secure storage untuk token
npx expo install expo-secure-store</code></pre>

<p><strong>2. Konfigurasi app.json:</strong></p>
<p>File <code>app.json</code> adalah konfigurasi utama Expo yang mendefinisikan nama aplikasi, icon, splash screen, package name, dan plugin:</p>
<pre><code>{
  "expo": {
    "name": "Kas Kecil",
    "slug": "kas-kecil-mobile",
    "version": "1.0.0",
    "android": {
      "adaptiveIcon": { "foregroundImage": "./assets/adaptive-icon.png" },
      "package": "com.donarazhar.kaskecilmobile"
    },
    "plugins": [
      "@react-native-community/datetimepicker",
      "expo-secure-store"
    ],
    "extra": {
      "eas": { "projectId": "your-project-id" }
    }
  }
}</code></pre>

<h3>⚠️ Pelajaran Penting: Install Node di Dalam Folder Aplikasi, Bukan di Parent!</h3>
<p>Ini adalah salah satu pelajaran paling penting yang saya dapatkan. Dalam monorepo, <strong>jangan install node_modules di folder root saja</strong> — install di <strong>masing-masing subfolder</strong> yang membutuhkan.</p>

<p><strong>❌ SALAH — Install di root saja:</strong></p>
<pre><code>kaskecil/              # Install npm di sini
├── node_modules/      # Semua package ada di sini
├── web/               # Tidak punya node_modules sendiri
└── mobile/            # Tidak punya node_modules sendiri ← AKAN BERMASALAH!</code></pre>

<p><strong>✅ BENAR — Install di masing-masing folder:</strong></p>
<pre><code>kaskecil/
├── package.json       # Root scripts (shortcut saja)
├── web/
│   ├── package.json   # Dependencies khusus web
│   └── node_modules/  # Node modules KHUSUS web
└── mobile/
    ├── package.json   # Dependencies khusus mobile
    └── node_modules/  # Node modules KHUSUS mobile</code></pre>

<p><strong>Mengapa ini penting?</strong></p>
<ul>
    <li><strong>EAS Build (Expo)</strong> membutuhkan <code>node_modules</code> di dalam folder mobile saat build APK di cloud. Jika tidak ada, build akan gagal.</li>
    <li><strong>Versi dependency berbeda</strong> — Web mungkin butuh React 18, tapi mobile butuh React 19. Kalau di-share, akan conflict.</li>
    <li><strong>Metro bundler</strong> (React Native) mencari modules dari folder project, bukan dari parent.</li>
    <li><strong>Vite</strong> (Web) juga resolve modules dari folder project-nya sendiri.</li>
</ul>

<p><strong>Cara install yang benar:</strong></p>
<pre><code># Install untuk web
cd web
npm install

# Install untuk mobile (dari folder mobile)
cd ../mobile
npm install

# JANGAN: cd kaskecil/ && npm install (ini hanya untuk root scripts)</code></pre>

<h2>📦 Build Mobile APK dengan EAS Build</h2>
<p>EAS (Expo Application Services) Build adalah layanan cloud dari Expo untuk mengkompilasi React Native menjadi APK (Android) atau IPA (iOS) tanpa perlu Android Studio atau Xcode di komputer lokal.</p>

<h3>Setup EAS Build</h3>
<pre><code># 1. Install EAS CLI secara global
npm install -g eas-cli

# 2. Login ke akun Expo
eas login

# 3. Konfigurasi project (dari dalam folder mobile!)
cd mobile
eas build:configure</code></pre>

<h3>Konfigurasi eas.json</h3>
<p>File <code>eas.json</code> mendefinisikan profil build yang berbeda untuk kebutuhan berbeda:</p>
<pre><code>{
  "build": {
    "development": {
      "developmentClient": true,
      "distribution": "internal"
    },
    "preview": {
      "distribution": "internal",
      "android": {
        "buildType": "apk"        // ← Menghasilkan file .apk yang bisa di-share
      }
    },
    "production": {
      "android": {
        "buildType": "app-bundle"  // ← Menghasilkan .aab untuk Google Play
      }
    }
  }
}</code></pre>

<ul>
    <li><strong>development</strong> — Untuk development dengan dev client (hot reload di device fisik)</li>
    <li><strong>preview</strong> — Menghasilkan APK yang bisa langsung di-share via link download</li>
    <li><strong>production</strong> — Menghasilkan AAB (Android App Bundle) untuk upload ke Google Play Store</li>
</ul>

<h3>Build APK (Preview) yang Bisa Di-share</h3>
<pre><code># PENTING: Jalankan dari dalam folder mobile!
cd mobile

# Build APK untuk preview (bisa langsung di-install)
eas build --platform android --profile preview</code></pre>

<p>Setelah build selesai (biasanya 10-20 menit), EAS akan memberikan <strong>link download APK</strong> yang bisa langsung dibagikan ke siapa saja. Penerima tinggal klik link → download → install APK di Android mereka.</p>

<h3>⚠️ File .easignore — Kunci Sukses Build di Monorepo</h3>
<p>Ini adalah file yang <strong>sangat penting</strong> dalam monorepo. Ketika EAS Build mengupload source code ke cloud, ia akan mengupload <strong>seluruh repository</strong> termasuk folder <code>api/</code> dan <code>web/</code>. Ini menyebabkan masalah karena:</p>
<ul>
    <li>Folder <code>api/</code> Laravel mengandung symlink (<code>storage/app/public</code>) yang tidak didukung di cloud build</li>
    <li>Upload menjadi sangat besar dan lambat</li>
    <li>Build bisa gagal karena konflik dependency</li>
</ul>

<p><strong>Solusi: Buat file <code>.easignore</code> di root DAN di folder mobile:</strong></p>

<p>File <code>.easignore</code> di <strong>root monorepo</strong>:</p>
<pre><code># Exclude backend API folder (contains symlinks)
api
api/**

# Exclude web folder
web
web/**

# Exclude docs
docs

# Exclude unnecessary files
*.tar.gz
*.zip
node_modules
.git
dist.zip</code></pre>

<p>File <code>.easignore</code> di <strong>folder mobile</strong>:</p>
<pre><code># Exclude sibling folders yang menyebabkan masalah
../api
../web
../docs
../.git

# Exclude build artifacts
dist
.expo

# node_modules akan di-install ulang saat build
node_modules

# Exclude unnecessary files
*.tar.gz
*.zip</code></pre>

<p>Dengan <code>.easignore</code>, EAS Build hanya mengupload file yang dibutuhkan untuk build mobile, sehingga proses lebih cepat dan tidak error.</p>

<h2>🔄 Workflow GitHub untuk Monorepo</h2>

<h3>Daily Development Workflow</h3>
<pre><code># 1. Pull perubahan terbaru
git pull origin main

# 2. Jalankan backend (terminal 1)
cd api
php artisan serve

# 3. Jalankan frontend web (terminal 2)
cd web
npm run dev

# 4. Jalankan mobile (terminal 3)
cd mobile
npm start

# 5. Setelah selesai, commit perubahan
git add .
git commit -m "feat: tambah fitur transaksi"
git push origin main</code></pre>

<h3>Tips Commit Message di Monorepo</h3>
<p>Karena satu repository berisi beberapa aplikasi, sertakan scope agar jelas bagian mana yang berubah:</p>
<pre><code># Format: type(scope): description
git commit -m "feat(api): tambah endpoint transaksi"
git commit -m "fix(web): perbaiki bug form login"
git commit -m "feat(mobile): tambah halaman dashboard"
git commit -m "chore(root): update gitignore"</code></pre>

<h3>Deploy ke Server</h3>
<pre><code># Di server (SSH):
cd /var/www/kaskecil

# Pull perubahan
git pull origin main

# Update backend
cd api
composer install --no-dev --optimize-autoloader
php artisan migrate
php artisan config:cache

# Update frontend
cd ../web
npm install
npm run build

# Restart services
sudo systemctl restart php8.2-fpm nginx</code></pre>

<h2>🌐 Konfigurasi Nginx untuk Monorepo</h2>
<p>Karena web dan API berada dalam satu server, Nginx perlu dikonfigurasi untuk merutekan request dengan benar:</p>
<pre><code>server {
    listen 80;
    server_name _;

    # 1. Web Application (React/Vite) — root path
    location / {
        root /var/www/kaskecil/web/dist;
        try_files $uri $uri/ /index.html;    # SPA fallback
    }

    # 2. Backend API (Laravel) — /api path
    location /api {
        alias /var/www/kaskecil/api/public;
        try_files $uri $uri/ @laravel;
    }

    location @laravel {
        root /var/www/kaskecil/api/public;
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME /var/www/kaskecil/api/public/index.php;
        include fastcgi_params;
    }

    # 3. Storage — untuk akses file upload
    location /storage {
        alias /var/www/kaskecil/api/public/storage;
        try_files $uri $uri/ =404;
    }
}</code></pre>
<p>Konfigurasi ini membuat satu domain bisa melayani web app (di <code>/</code>) dan API (di <code>/api</code>) sekaligus.</p>

<h2>💡 Pelajaran Penting (Lessons Learned)</h2>
<p>Berikut rangkuman tips paling penting yang saya pelajari selama membangun proyek ini:</p>

<h3>1. Selalu Install node_modules di Folder Masing-masing</h3>
<p>Jangan pernah hanya install di root monorepo. Setiap subfolder (web, mobile) harus punya <code>node_modules</code> sendiri karena dependency-nya berbeda.</p>

<h3>2. Buat .easignore untuk EAS Build</h3>
<p>Tanpa file ini, EAS Build akan mengupload seluruh monorepo termasuk folder yang tidak relevan, menyebabkan build gagal karena symlink atau dependency conflict.</p>

<h3>3. Environment Variables Terpisah</h3>
<p>Setiap subfolder punya file <code>.env</code> sendiri yang mengarah ke URL yang sesuai:</p>
<ul>
    <li><code>api/.env</code> — Database credentials, app key</li>
    <li><code>web/.env</code> — <code>VITE_API_URL=http://localhost:8000</code> (dev) atau URL production</li>
    <li><code>mobile/.env</code> — <code>API_URL=http://192.168.x.x:8000</code> (IP komputer untuk device fisik)</li>
</ul>

<h3>4. Mobile Harus Menggunakan IP, Bukan localhost</h3>
<p>Saat development mobile di device fisik atau emulator, gunakan IP address komputer (<code>192.168.x.x</code>), bukan <code>localhost</code>. Device fisik tidak mengenal localhost komputer Anda.</p>

<h3>5. Jalankan EAS Build dari Folder Mobile</h3>
<p>Perintah <code>eas build</code> harus dijalankan dari dalam folder <code>mobile/</code>, bukan dari root monorepo. EAS mencari <code>app.json</code> dan <code>package.json</code> di current directory.</p>

<h3>6. Gunakan Sanctum Token, Simpan di Secure Store</h3>
<p>Di mobile, jangan simpan auth token di AsyncStorage biasa. Gunakan <code>expo-secure-store</code> yang mengenkripsi data menggunakan native keychain (iOS) atau keystore (Android).</p>

<h3>7. Test API di Lokal Sebelum Push</h3>
<p>Selalu pastikan API berjalan dan endpoint berfungsi di lokal sebelum push ke server. Gunakan tools seperti Postman, Insomnia, atau cURL untuk testing.</p>

<h3>8. Git Ignore yang Benar</h3>
<p>Pastikan <code>.gitignore</code> mengecualikan semua folder yang tidak perlu di-track:</p>
<pre><code>node_modules/           # Dependencies (install ulang via npm install)
**/node_modules/        # node_modules di semua subfolder
.env                    # Environment variables (rahasia!)
dist/                   # Build output (generate ulang via npm run build)
vendor/                 # PHP dependencies (install ulang via composer install)</code></pre>

<h2>📊 Tech Stack Ringkasan</h2>
<ul>
    <li><strong>Backend</strong>: Laravel 12, PHP 8.2+, PostgreSQL, Sanctum</li>
    <li><strong>Frontend Web</strong>: React 18, Vite, TypeScript, Tailwind CSS, Radix UI, TanStack Query, Zustand</li>
    <li><strong>Mobile</strong>: React Native 0.81, Expo SDK 54, NativeWind, React Navigation, EAS Build</li>
    <li><strong>Validasi</strong>: Zod (bisa di-share antara frontend dan backend)</li>
    <li><strong>Monorepo</strong>: Root package.json dengan scripts lintas-project</li>
    <li><strong>Deployment</strong>: Nginx (web + API), EAS Build (mobile APK/AAB)</li>
</ul>

<p>Dengan mengikuti arsitektur dan workflow yang dijelaskan dalam artikel ini, Anda bisa membangun aplikasi multi-platform yang terstruktur, maintainable, dan scalable. Semoga panduan ini bermanfaat untuk proyek-proyek Anda di masa depan! 🚀</p>
',
                'user_id' => $admin->id,
                'category_id' => $category->id,
                'status' => 'published',
                'published_at' => now(),
            ]
        );

        $this->command->info('Kaskecil Development Process article created/updated successfully!');
    }
}
