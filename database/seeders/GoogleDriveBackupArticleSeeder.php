<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Article;

class GoogleDriveBackupArticleSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('is_admin', true)->first();

        $category = Category::firstOrCreate(
            ['name' => 'Tutorial'],
            ['description' => 'Tutorial dan panduan pengembangan aplikasi']
        );

        Article::create([
            'title' => 'Laravel Backup ke Google Drive: Panduan Lengkap Implementasi dan Konfigurasi',
            'slug' => 'laravel-backup-google-drive-panduan-lengkap',
            'excerpt' => 'Panduan lengkap cara mengimplementasikan sistem backup database Laravel yang otomatis tersimpan di Google Drive. Mulai dari konfigurasi Google Cloud Console, OAuth2, hingga membuat admin panel untuk mengelola backup.',
            'content' => '
<h2>🔐 Mengapa Backup Itu Penting?</h2>

<p>Bayangkan skenario ini: website Anda sudah berjalan berbulan-bulan, ratusan artikel sudah dipublikasi, data pengguna sudah terkumpul, lalu suatu hari... <strong>server crash</strong>. Database corrupt. Semua data hilang dalam sekejap.</p>

<p>Tanpa backup, Anda hanya bisa pasrah. Dengan backup yang teratur, Anda bisa <strong>memulihkan semuanya dalam hitungan menit</strong>.</p>

<p>Dalam artikel ini, saya akan membagikan cara mengimplementasikan <strong>sistem backup otomatis</strong> di Laravel yang langsung tersimpan di <strong>Google Drive</strong> — gratis, aman, dan bisa diakses dari mana saja.</p>

<hr>

<h2>📋 Arsitektur Sistem</h2>

<p>Sistem backup yang kita bangun memiliki arsitektur sebagai berikut:</p>

<ul>
    <li><strong>BackupController</strong> — Menangani logika create, list, download, dan delete backup</li>
    <li><strong>GoogleDriveServiceProvider</strong> — Menghubungkan Laravel Filesystem dengan Google Drive API</li>
    <li><strong>Flysystem Adapter</strong> — Library yang menjembatani Laravel Storage dengan Google Drive</li>
    <li><strong>Admin UI</strong> — Halaman admin untuk mengelola backup secara visual</li>
</ul>

<p>Alur kerjanya sederhana:</p>
<ol>
    <li>Admin klik "Buat Backup" di panel admin</li>
    <li>Sistem melakukan database dump (SQL)</li>
    <li>File SQL diupload ke Google Drive</li>
    <li>File temporary lokal dihapus</li>
    <li>Admin bisa download atau hapus backup kapan saja</li>
</ol>

<hr>

<h2>🛠️ Langkah 1: Instalasi Package</h2>

<p>Kita menggunakan package <code>masbug/flysystem-google-drive-ext</code> sebagai adapter Flysystem untuk Google Drive. Install via Composer:</p>

<pre><code>composer require masbug/flysystem-google-drive-ext</code></pre>

<p>Package ini akan otomatis menginstall dependensi yang diperlukan:</p>
<ul>
    <li><code>google/apiclient</code> — Google API Client Library</li>
    <li><code>google/apiclient-services</code> — Google Drive Service</li>
    <li><code>firebase/php-jwt</code> — JWT token handling</li>
    <li><code>phpseclib/phpseclib</code> — PHP Secure Communications Library</li>
</ul>

<hr>

<h2>🔑 Langkah 2: Konfigurasi Google Cloud Console</h2>

<p>Ini bagian yang paling krusial. Anda perlu membuat OAuth2 credentials di Google Cloud Console.</p>

<h3>2.1 Buat Project</h3>
<ol>
    <li>Buka <a href="https://console.cloud.google.com/" target="_blank" rel="noopener">Google Cloud Console</a></li>
    <li>Klik <strong>"New Project"</strong></li>
    <li>Beri nama, misalnya: <strong>"MyBlog Backup"</strong></li>
    <li>Klik <strong>"Create"</strong></li>
</ol>

<h3>2.2 Aktifkan Google Drive API</h3>
<ol>
    <li>Navigasi ke <strong>APIs & Services → Library</strong></li>
    <li>Cari <strong>"Google Drive API"</strong></li>
    <li>Klik <strong>"Enable"</strong></li>
</ol>

<h3>2.3 Konfigurasi OAuth Consent Screen</h3>
<ol>
    <li>Buka <strong>APIs & Services → OAuth consent screen</strong></li>
    <li>Pilih <strong>"External"</strong></li>
    <li>Isi nama aplikasi dan email</li>
    <li>Di bagian <strong>"Test users"</strong>, tambahkan email Google Anda</li>
    <li>Klik <strong>"Save"</strong></li>
</ol>

<blockquote>
    <p>💡 <strong>Tips:</strong> Untuk penggunaan pribadi, Anda <strong>tidak perlu</strong> memverifikasi app ke Google. Mode "Testing" sudah cukup — cukup pastikan email Anda terdaftar sebagai test user.</p>
</blockquote>

<h3>2.4 Buat OAuth2 Credentials</h3>
<ol>
    <li>Buka <strong>APIs & Services → Credentials</strong></li>
    <li>Klik <strong>"+ CREATE CREDENTIALS" → "OAuth client ID"</strong></li>
    <li>Pilih tipe: <strong>Web Application</strong></li>
    <li>Tambahkan Authorized Redirect URI: <code>https://developers.google.com/oauthplayground</code></li>
    <li>Klik <strong>"Create"</strong></li>
    <li>Catat <strong>Client ID</strong> dan <strong>Client Secret</strong></li>
</ol>

<h3>2.5 Dapatkan Refresh Token</h3>
<ol>
    <li>Buka <a href="https://developers.google.com/oauthplayground" target="_blank" rel="noopener">OAuth Playground</a></li>
    <li>Klik ⚙️ <strong>Settings</strong> → centang <strong>"Use your own OAuth credentials"</strong></li>
    <li>Masukkan Client ID dan Client Secret dari langkah sebelumnya</li>
    <li>Di panel kiri, pilih: <strong>Google Drive API v3 → https://www.googleapis.com/auth/drive</strong></li>
    <li>Klik <strong>"Authorize APIs"</strong> → Login dan klik <strong>"Allow"</strong></li>
    <li>Klik <strong>"Exchange authorization code for tokens"</strong></li>
    <li>Salin <strong>Refresh Token</strong> (dimulai dengan <code>1//...</code>)</li>
</ol>

<h3>2.6 Siapkan Folder Google Drive</h3>
<ol>
    <li>Buka <a href="https://drive.google.com/" target="_blank" rel="noopener">Google Drive</a></li>
    <li>Buat folder baru, misalnya: <strong>"MyBlog Backups"</strong></li>
    <li>Buka folder tersebut</li>
    <li>Lihat URL di browser: <code>https://drive.google.com/drive/folders/<strong>FOLDER_ID_NYA</strong></code></li>
    <li>Salin bagian setelah <code>/folders/</code> — itu adalah <strong>Folder ID</strong></li>
</ol>

<hr>

<h2>⚙️ Langkah 3: Konfigurasi Laravel</h2>

<h3>3.1 Environment Variables</h3>
<p>Tambahkan ke file <code>.env</code>:</p>

<pre><code>GOOGLE_DRIVE_CLIENT_ID=your-client-id
GOOGLE_DRIVE_CLIENT_SECRET=your-client-secret
GOOGLE_DRIVE_REFRESH_TOKEN=your-refresh-token
GOOGLE_DRIVE_FOLDER_ID=your-folder-id</code></pre>

<h3>3.2 Filesystem Disk</h3>
<p>Tambahkan disk <code>google</code> di <code>config/filesystems.php</code>:</p>

<pre><code>\'google\' => [
    \'driver\' => \'google\',
    \'clientId\' => env(\'GOOGLE_DRIVE_CLIENT_ID\'),
    \'clientSecret\' => env(\'GOOGLE_DRIVE_CLIENT_SECRET\'),
    \'refreshToken\' => env(\'GOOGLE_DRIVE_REFRESH_TOKEN\'),
    \'folder\' => env(\'GOOGLE_DRIVE_FOLDER_ID\'),
],</code></pre>

<h3>3.3 Service Provider</h3>
<p>Buat <code>GoogleDriveServiceProvider</code> yang mendaftarkan driver <code>google</code> ke Laravel Filesystem. Provider ini menggunakan Google API Client untuk autentikasi OAuth2 dan membuat Flysystem adapter.</p>

<p>Poin penting dalam implementasi:</p>
<ul>
    <li>Gunakan <code>fetchAccessTokenWithRefreshToken()</code> untuk mendapatkan access token dari refresh token</li>
    <li>Tambahkan error handling untuk mendeteksi token yang invalid atau expired</li>
    <li>Daftarkan provider di <code>bootstrap/providers.php</code></li>
</ul>

<hr>

<h2>🎮 Langkah 4: BackupController</h2>

<p>Controller ini menangani semua operasi backup:</p>

<h3>Fitur-fitur:</h3>

<p><strong>1. List Backups</strong> — Mengambil daftar file backup dari Google Drive, menampilkan nama file, ukuran, dan tanggal. Diurutkan dari yang terbaru.</p>

<p><strong>2. Create Backup</strong> — Proses pembuatan backup:</p>
<ul>
    <li>Dump database menggunakan <code>mysqldump</code> (jika tersedia)</li>
    <li>Jika <code>mysqldump</code> tidak ditemukan, gunakan <strong>PHP-based dump</strong> sebagai fallback</li>
    <li>Simpan file SQL sementara di local storage</li>
    <li>Upload ke Google Drive menggunakan <code>Storage::disk(\'google\')</code></li>
    <li>Hapus file temporary</li>
</ul>

<p><strong>3. Download Backup</strong> — Mengambil file dari Google Drive dan mengirimkannya sebagai response download.</p>

<p><strong>4. Delete Backup</strong> — Menghapus file backup dari Google Drive.</p>

<h3>PHP-Based Database Dump</h3>
<p>Tidak semua server memiliki akses ke binary <code>mysqldump</code>. Oleh karena itu, kami implementasikan <strong>fallback berbasis PHP</strong> yang:</p>
<ul>
    <li>Mengambil daftar semua tabel menggunakan <code>SHOW TABLES</code></li>
    <li>Untuk setiap tabel, mengambil <code>CREATE TABLE</code> statement</li>
    <li>Mengekspor semua data baris per baris dengan <code>INSERT INTO</code> statement</li>
    <li>Menangani foreign key constraints dengan <code>SET FOREIGN_KEY_CHECKS=0</code></li>
</ul>

<hr>

<h2>🎨 Langkah 5: Admin Panel UI</h2>

<p>Halaman backup di admin panel menampilkan:</p>

<ul>
    <li><strong>Status koneksi</strong> — Hijau jika terhubung, merah jika ada error</li>
    <li><strong>Tombol "Buat Backup Baru"</strong> — Satu klik untuk membuat dan upload backup</li>
    <li><strong>Tabel daftar backup</strong> — Menampilkan nama file, ukuran, tanggal, dan aksi (download/hapus)</li>
    <li><strong>Panduan setup</strong> — Otomatis muncul jika Google Drive belum dikonfigurasi</li>
</ul>

<h3>Fitur UX yang Penting</h3>
<ul>
    <li>Tombol "Buat Backup" otomatis disabled saat diklik (mencegah double-click)</li>
    <li>Konfirmasi sebelum menghapus backup</li>
    <li>Empty state yang informatif ketika belum ada backup</li>
    <li>Panduan setup lengkap langsung di halaman (tanpa perlu buka dokumentasi terpisah)</li>
</ul>

<hr>

<h2>🔒 Keamanan</h2>

<p>Beberapa hal penting terkait keamanan:</p>

<ul>
    <li><strong>Credentials di .env</strong> — Client ID, Secret, dan Refresh Token disimpan di file <code>.env</code> yang tidak ter-commit ke Git</li>
    <li><strong>Auth middleware</strong> — Semua route backup dilindungi middleware <code>auth</code>, hanya admin yang bisa mengakses</li>
    <li><strong>Scope minimal</strong> — Gunakan scope <code>drive.file</code> agar app hanya bisa mengakses file yang dibuatnya sendiri (bukan seluruh Google Drive Anda)</li>
    <li><strong>Testing mode</strong> — App tidak perlu diverifikasi Google karena hanya digunakan secara pribadi</li>
</ul>

<hr>

<h2>🚀 Deploy ke Server</h2>

<p>Untuk deploy ke server production:</p>

<ol>
    <li><strong>Pull kode terbaru</strong> dari repository</li>
    <li>Jalankan <code>composer install</code> untuk menginstall package baru</li>
    <li>Tambahkan 4 variabel Google Drive ke file <code>.env</code> di server</li>
    <li>Clear config cache: <code>php artisan config:clear</code></li>
    <li>Buka halaman backup di admin panel untuk verifikasi</li>
</ol>

<blockquote>
    <p>💡 <strong>Tips:</strong> Gunakan <strong>Refresh Token yang sama</strong> untuk lokal dan server. Tidak perlu membuat credentials terpisah — satu set credentials bisa digunakan di banyak server.</p>
</blockquote>

<hr>

<h2>📝 Best Practices</h2>

<h3>1. Backup Secara Rutin</h3>
<p>Idealnya, buat backup minimal <strong>1x sehari</strong>. Untuk traffic tinggi, buat backup setiap beberapa jam. Anda bisa mengotomasi ini dengan Laravel Scheduler:</p>

<pre><code>// app/Console/Kernel.php
$schedule->call(function () {
    app(BackupController::class)->create();
})->daily();</code></pre>

<h3>2. Retention Policy</h3>
<p>Jangan biarkan backup menumpuk tanpa batas. Terapkan retention policy — misalnya, hanya simpan backup <strong>30 hari terakhir</strong>, hapus yang lebih lama secara otomatis.</p>

<h3>3. Test Restore</h3>
<p>Backup yang tidak pernah di-test restore-nya sama saja dengan tidak punya backup. Secara berkala, download backup dan coba restore ke database test untuk memastikan file backup valid.</p>

<h3>4. Monitor Google Drive Storage</h3>
<p>Google Drive menyediakan <strong>15 GB gratis</strong>. File backup SQL biasanya berukuran kecil (beberapa MB), tapi pastikan storage tidak penuh.</p>

<hr>

<h2>🏁 Kesimpulan</h2>

<p>Dengan sistem backup ke Google Drive ini, data website Anda terlindungi dari:</p>
<ul>
    <li>✅ Server crash atau hardware failure</li>
    <li>✅ Kesalahan manusia (accidental delete)</li>
    <li>✅ Serangan hacker atau ransomware</li>
    <li>✅ Masalah hosting provider</li>
</ul>

<p>Implementasinya cukup straightforward — install satu package, buat beberapa file, konfigurasi OAuth2, dan sistem backup Anda siap. Investasi waktu <strong>1-2 jam</strong> untuk ketenangan pikiran selamanya.</p>

<p>Semoga panduan ini bermanfaat! Jangan lupa untuk segera membuat backup pertama Anda setelah implementasi. 🚀</p>

<p><em>Wallahu a\'lam bishawab.</em></p>
',
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(50, 200),
        ]);
    }
}
