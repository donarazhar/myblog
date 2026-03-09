<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class StudiKasusMyblogBrdPrdErdArticleSeeder extends Seeder
{
    public function run(): void
    {
        // Get admin user
        $admin = User::where('is_admin', true)->first();

        if (!$admin) {
            $this->command->warn('No admin user found. Please run DatabaseSeeder first.');
            return;
        }

        // Get or create category
        $category = Category::firstOrCreate(
            ['name' => 'Teknologi'],
            ['description' => 'Artikel tentang perkembangan teknologi']
        );

        // Create Study Case Article
        Article::create([
            'title' => 'Study Kasus : Bedah Anatomi Aplikasi Web MyBlog terkait BRD, PRD dan ERD',
            'slug' => 'study-kasus-bedah-anatomi-aplikasi-web-myblog-terkait-brd-prd-dan-erd',
            'excerpt' => 'Studi kasus nyata membedah anatomi aplikasi web MyBlog yang dibangun dengan Laravel 12. Analisis komprehensif mencakup Business Requirements Document (BRD), Product Requirements Document (PRD), dan Entity Relationship Diagram (ERD) langsung dari source code.',
            'content' => '
<p>Dalam dunia pengembangan perangkat lunak, teori tanpa praktik ibarat peta tanpa kompas. Artikel sebelumnya telah membahas konsep <strong>BRD</strong>, <strong>PRD</strong>, dan <strong>ERD</strong> secara umum. Kali ini, kita akan membedah sebuah <em>aplikasi nyata</em> — <strong>MyBlog</strong> — sebuah CMS (Content Management System) yang dibangun dengan <strong>Laravel 12</strong>, untuk melihat bagaimana ketiga dokumen tersebut terwujud dalam kode yang sesungguhnya.</p>

<h2>Sekilas Tentang MyBlog</h2>

<p>MyBlog adalah platform <em>all-in-one</em> untuk blogging, portfolio, dan company profile. Aplikasi ini dibangun menggunakan arsitektur <strong>MVC (Model-View-Controller)</strong> dengan spesifikasi sebagai berikut:</p>

<table>
    <thead>
        <tr>
            <th>Aspek</th>
            <th>Detail</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>Framework</strong></td>
            <td>Laravel 12</td>
        </tr>
        <tr>
            <td><strong>PHP Version</strong></td>
            <td>≥ 8.2</td>
        </tr>
        <tr>
            <td><strong>Frontend Build</strong></td>
            <td>Vite + Blade Templates</td>
        </tr>
        <tr>
            <td><strong>Database</strong></td>
            <td>MySQL (dengan fallback SQLite)</td>
        </tr>
        <tr>
            <td><strong>Storage Eksternal</strong></td>
            <td>Google Drive</td>
        </tr>
        <tr>
            <td><strong>Total Models</strong></td>
            <td>6 model</td>
        </tr>
        <tr>
            <td><strong>Total Controllers</strong></td>
            <td>14 controller</td>
        </tr>
        <tr>
            <td><strong>Total Routes</strong></td>
            <td>30+ endpoint</td>
        </tr>
    </tbody>
</table>

<p>Aplikasi ini memiliki dua sisi utama: <strong>sisi publik</strong> (untuk pengunjung/pembaca) dan <strong>sisi admin</strong> (untuk pengelola konten), dilengkapi dengan dashboard analytics, backup database ke Google Drive, dan SEO bawaan.</p>

<h2>Anatomi Struktur Aplikasi</h2>

<p>Sebelum masuk ke analisis BRD, PRD, dan ERD, mari kita pahami dulu anatomi tubuh aplikasi ini:</p>

<h3>6 Model (Organ Utama)</h3>

<ul>
    <li><strong>User</strong> — Pengguna/admin yang mengelola konten</li>
    <li><strong>Article</strong> — Artikel/tulisan blog dengan status draft/published</li>
    <li><strong>Category</strong> — Kategori pengelompokan artikel</li>
    <li><strong>Portfolio</strong> — Proyek/karya yang ditampilkan</li>
    <li><strong>Setting</strong> — Konfigurasi dinamis situs (key-value store dengan caching)</li>
    <li><strong>ContactMessage</strong> — Pesan dari pengunjung melalui form kontak</li>
</ul>

<h3>14 Controller (Sistem Saraf)</h3>

<p>Controller dibagi menjadi dua kelompok:</p>

<ul>
    <li><strong>Public (5 controller):</strong> HomeController, ArticleController, PortfolioController, SitemapController, dan base Controller</li>
    <li><strong>Admin (9 controller):</strong> DashboardController, ArticleController, CategoryController, PortfolioController, SettingController, ContactController, AuthController, ProfileController, dan BackupController</li>
</ul>

<h3>Arsitektur Route (Peredaran Darah)</h3>

<p>Route dibagi menjadi 3 grup besar:</p>

<ol>
    <li><strong>Public Routes</strong> — Tanpa autentikasi (homepage, about, contact, articles, portfolio, sitemap)</li>
    <li><strong>Admin Auth Routes</strong> — Login dan logout</li>
    <li><strong>Admin Protected Routes</strong> — Dilindungi middleware <code>auth</code> (dashboard, CRUD konten, settings, backup)</li>
</ol>

<hr>

<h2>BAGIAN 1: BRD — Business Requirements Document</h2>

<p><strong>Fokus: "Mengapa MyBlog dibangun?"</strong></p>

<h3>1.1 Latar Belakang</h3>

<p>MyBlog dikembangkan sebagai platform CMS pribadi yang menggabungkan fungsi <strong>blog</strong>, <strong>company profile</strong>, dan <strong>portfolio</strong>. Aplikasi ini menjawab kebutuhan individu atau organisasi kecil yang ingin memiliki kehadiran digital profesional tanpa overhead CMS besar seperti WordPress.</p>

<h3>1.2 Tujuan Bisnis</h3>

<table>
    <thead>
        <tr>
            <th>Kode</th>
            <th>Tujuan</th>
            <th>Deskripsi</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>B1</strong></td>
            <td>Kehadiran Digital</td>
            <td>Menyediakan website profesional untuk branding personal/organisasi</td>
        </tr>
        <tr>
            <td><strong>B2</strong></td>
            <td>Knowledge Sharing</td>
            <td>Mempublikasikan artikel untuk berbagi pengetahuan</td>
        </tr>
        <tr>
            <td><strong>B3</strong></td>
            <td>Portfolio Showcase</td>
            <td>Menampilkan proyek dan karya yang telah diselesaikan</td>
        </tr>
        <tr>
            <td><strong>B4</strong></td>
            <td>Lead Generation</td>
            <td>Menerima pesan dari calon klien melalui contact form</td>
        </tr>
        <tr>
            <td><strong>B5</strong></td>
            <td>Content Control</td>
            <td>Memberikan kontrol penuh atas konten yang dipublikasikan</td>
        </tr>
        <tr>
            <td><strong>B6</strong></td>
            <td>Data Safety</td>
            <td>Menjamin keamanan data melalui backup ke Google Drive</td>
        </tr>
    </tbody>
</table>

<h3>1.3 Stakeholder</h3>

<table>
    <thead>
        <tr>
            <th>Stakeholder</th>
            <th>Peran</th>
            <th>Kepentingan Utama</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>Admin/Pemilik</strong></td>
            <td>Mengelola seluruh konten dan pengaturan</td>
            <td>Kemudahan pengelolaan, analytics performa</td>
        </tr>
        <tr>
            <td><strong>Pengunjung/Pembaca</strong></td>
            <td>Membaca artikel, melihat portfolio</td>
            <td>Pengalaman membaca yang baik, navigasi mudah</td>
        </tr>
        <tr>
            <td><strong>Calon Klien</strong></td>
            <td>Melihat portfolio, mengirim pesan</td>
            <td>Informasi proyek lengkap, kontak mudah</td>
        </tr>
    </tbody>
</table>

<h3>1.4 Ruang Lingkup (Scope)</h3>

<h4>Yang Termasuk (In-Scope):</h4>
<ul>
    <li>Manajemen artikel (CRUD) dengan kategori dan status publish/draft</li>
    <li>Manajemen portfolio dengan detail proyek lengkap</li>
    <li>Pengaturan situs dinamis (nama, tagline, sosial media, kontak)</li>
    <li>Contact form dengan manajemen pesan masuk</li>
    <li>Dashboard admin dengan analytics dan chart</li>
    <li>Autentikasi admin (login/logout) dan profil</li>
    <li>Backup database ke Google Drive</li>
    <li>SEO (XML Sitemap, slug URL)</li>
</ul>

<h4>Yang Tidak Termasuk (Out-of-Scope):</h4>
<ul>
    <li>Multi-user role management (hanya 1 level admin)</li>
    <li>Komentar pada artikel</li>
    <li>Registrasi pengguna publik</li>
    <li>E-commerce / pembayaran</li>
    <li>Newsletter / email marketing</li>
    <li>Multi-bahasa (i18n)</li>
    <li>API REST/GraphQL untuk integrasi eksternal</li>
</ul>

<h3>1.5 Business Rules</h3>

<table>
    <thead>
        <tr>
            <th>Kode</th>
            <th>Aturan Bisnis</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>BR-01</strong></td>
            <td>Artikel hanya tampil di publik jika berstatus <code>published</code> dan <code>published_at</code> ≤ waktu sekarang</td>
        </tr>
        <tr>
            <td><strong>BR-02</strong></td>
            <td>Slug artikel, kategori, dan portfolio harus unik (digunakan sebagai URL identifier)</td>
        </tr>
        <tr>
            <td><strong>BR-03</strong></td>
            <td>Setiap artikel dimiliki oleh satu user dan dapat memiliki satu kategori</td>
        </tr>
        <tr>
            <td><strong>BR-04</strong></td>
            <td>Portfolio dapat ditandai sebagai <em>featured</em> dan memiliki urutan custom</td>
        </tr>
        <tr>
            <td><strong>BR-05</strong></td>
            <td>Pesan kontak memiliki status <code>is_read</code> untuk tracking</td>
        </tr>
        <tr>
            <td><strong>BR-06</strong></td>
            <td>Settings menggunakan caching 1 jam untuk performa optimal</td>
        </tr>
        <tr>
            <td><strong>BR-07</strong></td>
            <td>Upload gambar dibatasi: jpeg, png, jpg, gif, webp, maksimal 2MB</td>
        </tr>
        <tr>
            <td><strong>BR-08</strong></td>
            <td>Password admin minimal 8 karakter</td>
        </tr>
        <tr>
            <td><strong>BR-09</strong></td>
            <td>Backup database disimpan di Google Drive dengan format <code>backup_YYYY-MM-DD_HH-mm-ss.sql</code></td>
        </tr>
        <tr>
            <td><strong>BR-10</strong></td>
            <td>URL yang tidak dikenali akan di-redirect ke homepage (fallback route)</td>
        </tr>
    </tbody>
</table>

<h3>1.6 KPI (Key Performance Indicators)</h3>

<p>Dashboard admin MyBlog menyediakan beberapa metrik KPI yang langsung terukur:</p>

<ul>
    <li><strong>Jumlah Artikel Terpublikasi</strong> — Mengukur produktivitas konten</li>
    <li><strong>Total Views</strong> — Mengukur jangkauan pembaca</li>
    <li><strong>Pesan Masuk (Unread)</strong> — Mengukur engagement pengunjung</li>
    <li><strong>Top 5 Artikel</strong> — Mengidentifikasi konten paling populer</li>
    <li><strong>Tren Publikasi Bulanan</strong> — Memantau konsistensi penerbitan</li>
</ul>

<hr>

<h2>BAGIAN 2: PRD — Product Requirements Document</h2>

<p><strong>Fokus: "Apa yang dibangun di MyBlog?"</strong></p>

<h3>2.1 User Personas</h3>

<h4>Persona 1: Admin (Penulis/Pemilik)</h4>
<ul>
    <li><strong>Deskripsi:</strong> Individu yang mengelola website pribadinya</li>
    <li><strong>Goals:</strong> Menulis artikel, menampilkan portfolio, memantau performa konten</li>
    <li><strong>Pain Points:</strong> Butuh CMS simpel tanpa overhead WordPress</li>
</ul>

<h4>Persona 2: Pengunjung (Pembaca)</h4>
<ul>
    <li><strong>Deskripsi:</strong> Pembaca yang mengakses website untuk membaca artikel</li>
    <li><strong>Goals:</strong> Membaca konten informatif, menemukan artikel berdasarkan kategori</li>
    <li><strong>Pain Points:</strong> Loading lambat, navigasi rumit</li>
</ul>

<h4>Persona 3: Calon Klien</h4>
<ul>
    <li><strong>Deskripsi:</strong> Orang yang tertarik dengan jasa/keahlian pemilik</li>
    <li><strong>Goals:</strong> Melihat portfolio proyek, menghubungi pemilik</li>
    <li><strong>Pain Points:</strong> Informasi portfolio sulit ditemukan</li>
</ul>

<h3>2.2 Daftar Fitur Lengkap</h3>

<h4>F-01: Halaman Publik</h4>
<table>
    <thead>
        <tr>
            <th>Sub-Fitur</th>
            <th>Deskripsi</th>
            <th>Prioritas</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Homepage</td>
            <td>Menampilkan 5 artikel terbaru yang sudah dipublikasi</td>
            <td>P0</td>
        </tr>
        <tr>
            <td>About Page</td>
            <td>Halaman tentang pemilik (konten dari settings)</td>
            <td>P0</td>
        </tr>
        <tr>
            <td>Contact Page</td>
            <td>Form kontak dengan validasi (nama, email, subjek, pesan)</td>
            <td>P0</td>
        </tr>
    </tbody>
</table>

<h4>F-02: Manajemen Artikel</h4>
<table>
    <thead>
        <tr>
            <th>Sub-Fitur</th>
            <th>Deskripsi</th>
            <th>Prioritas</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Create Artikel</td>
            <td>Form: judul, kategori, excerpt, konten, featured image, status</td>
            <td>P0</td>
        </tr>
        <tr>
            <td>Edit Artikel</td>
            <td>Edit semua field, replace featured image otomatis</td>
            <td>P0</td>
        </tr>
        <tr>
            <td>Delete Artikel</td>
            <td>Hapus artikel beserta featured image dari storage</td>
            <td>P0</td>
        </tr>
        <tr>
            <td>List Artikel</td>
            <td>Tabel dengan pagination (10/halaman)</td>
            <td>P0</td>
        </tr>
        <tr>
            <td>Status Draft/Published</td>
            <td>Auto-set <code>published_at</code> saat pertama kali dipublish</td>
            <td>P0</td>
        </tr>
        <tr>
            <td>View Counter</td>
            <td>Increment otomatis setiap artikel dibuka</td>
            <td>P1</td>
        </tr>
        <tr>
            <td>Related Articles</td>
            <td>Tampilkan 3 artikel terkait berdasarkan kategori</td>
            <td>P1</td>
        </tr>
        <tr>
            <td>Filter by Category</td>
            <td>Filter artikel berdasarkan kategori</td>
            <td>P1</td>
        </tr>
    </tbody>
</table>

<h4>F-03: Manajemen Kategori</h4>
<table>
    <thead>
        <tr>
            <th>Sub-Fitur</th>
            <th>Deskripsi</th>
            <th>Prioritas</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>CRUD Kategori</td>
            <td>Create, Read, Update, Delete kategori</td>
            <td>P0</td>
        </tr>
        <tr>
            <td>Auto Slug</td>
            <td>Slug otomatis dari nama kategori</td>
            <td>P0</td>
        </tr>
        <tr>
            <td>Article Count</td>
            <td>Jumlah artikel per kategori pada halaman publik</td>
            <td>P1</td>
        </tr>
    </tbody>
</table>

<h4>F-04: Manajemen Portfolio</h4>
<table>
    <thead>
        <tr>
            <th>Sub-Fitur</th>
            <th>Deskripsi</th>
            <th>Prioritas</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>CRUD Portfolio</td>
            <td>Create, Read, Update, Delete portfolio</td>
            <td>P0</td>
        </tr>
        <tr>
            <td>Detail Proyek</td>
            <td>Judul, deskripsi, konten, klien, URL, teknologi, tanggal selesai</td>
            <td>P0</td>
        </tr>
        <tr>
            <td>Featured Flag</td>
            <td>Tandai portfolio sebagai unggulan</td>
            <td>P1</td>
        </tr>
        <tr>
            <td>Custom Order</td>
            <td>Urutan tampilan portfolio bisa diatur manual</td>
            <td>P1</td>
        </tr>
        <tr>
            <td>Technologies (JSON)</td>
            <td>Array JSON untuk daftar teknologi yang digunakan</td>
            <td>P1</td>
        </tr>
    </tbody>
</table>

<h4>F-05: Contact Message Management</h4>
<table>
    <thead>
        <tr>
            <th>Sub-Fitur</th>
            <th>Deskripsi</th>
            <th>Prioritas</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Terima Pesan</td>
            <td>Simpan pesan dari form kontak publik</td>
            <td>P0</td>
        </tr>
        <tr>
            <td>List Pesan</td>
            <td>Daftar pesan dengan pagination + jumlah unread</td>
            <td>P0</td>
        </tr>
        <tr>
            <td>Baca Pesan</td>
            <td>Detail pesan, auto-mark as read saat dibuka</td>
            <td>P0</td>
        </tr>
        <tr>
            <td>Hapus Pesan</td>
            <td>Hapus pesan kontak</td>
            <td>P1</td>
        </tr>
    </tbody>
</table>

<h4>F-06: Admin Dashboard & Analytics</h4>
<table>
    <thead>
        <tr>
            <th>Sub-Fitur</th>
            <th>Deskripsi</th>
            <th>Prioritas</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Statistics Cards</td>
            <td>Total artikel, published, draft, views, kategori, portfolio, users, unread messages</td>
            <td>P0</td>
        </tr>
        <tr>
            <td>Chart: Artikel/Bulan</td>
            <td>Bar chart produksi artikel 12 bulan terakhir</td>
            <td>P1</td>
        </tr>
        <tr>
            <td>Chart: Artikel/Kategori</td>
            <td>Distribusi artikel per kategori</td>
            <td>P1</td>
        </tr>
        <tr>
            <td>Chart: Top 5 Artikel</td>
            <td>5 artikel dengan views terbanyak</td>
            <td>P1</td>
        </tr>
        <tr>
            <td>Publication Calendar</td>
            <td>Kalender visualisasi tanggal publikasi</td>
            <td>P2</td>
        </tr>
    </tbody>
</table>

<h4>F-07: Autentikasi & Profil Admin</h4>
<table>
    <thead>
        <tr>
            <th>Sub-Fitur</th>
            <th>Deskripsi</th>
            <th>Prioritas</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Login</td>
            <td>Autentikasi email & password dengan remember me</td>
            <td>P0</td>
        </tr>
        <tr>
            <td>Logout</td>
            <td>Session invalidation & token regeneration</td>
            <td>P0</td>
        </tr>
        <tr>
            <td>Edit Profil</td>
            <td>Update nama dan email admin</td>
            <td>P1</td>
        </tr>
        <tr>
            <td>Ganti Password</td>
            <td>Verifikasi password lama, konfirmasi password baru</td>
            <td>P1</td>
        </tr>
    </tbody>
</table>

<h4>F-08: Pengaturan Situs</h4>
<table>
    <thead>
        <tr>
            <th>Sub-Fitur</th>
            <th>Deskripsi</th>
            <th>Prioritas</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Identitas Situs</td>
            <td>Nama situs, tagline, deskripsi</td>
            <td>P0</td>
        </tr>
        <tr>
            <td>Info Kontak</td>
            <td>Email, telepon, alamat</td>
            <td>P1</td>
        </tr>
        <tr>
            <td>Media Sosial</td>
            <td>Facebook, Twitter, Instagram, TikTok, GitHub</td>
            <td>P1</td>
        </tr>
        <tr>
            <td>About Content</td>
            <td>Profil singkat dan profil lengkap (digunakan di halaman About)</td>
            <td>P1</td>
        </tr>
    </tbody>
</table>

<h4>F-09: Backup Database</h4>
<table>
    <thead>
        <tr>
            <th>Sub-Fitur</th>
            <th>Deskripsi</th>
            <th>Prioritas</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Create Backup</td>
            <td>Dump database MySQL lalu upload ke Google Drive</td>
            <td>P1</td>
        </tr>
        <tr>
            <td>List Backup</td>
            <td>Daftar file backup (nama, ukuran, tanggal)</td>
            <td>P1</td>
        </tr>
        <tr>
            <td>Download Backup</td>
            <td>Download file backup dari Google Drive</td>
            <td>P1</td>
        </tr>
        <tr>
            <td>PHP Fallback</td>
            <td>Dump via PHP jika <code>mysqldump</code> binary tidak tersedia</td>
            <td>P1</td>
        </tr>
    </tbody>
</table>

<h4>F-10: SEO</h4>
<table>
    <thead>
        <tr>
            <th>Sub-Fitur</th>
            <th>Deskripsi</th>
            <th>Prioritas</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>XML Sitemap</td>
            <td>Auto-generate dari artikel dan kategori</td>
            <td>P1</td>
        </tr>
        <tr>
            <td>SEO Friendly URLs</td>
            <td>Slug-based URL untuk semua konten</td>
            <td>P0</td>
        </tr>
        <tr>
            <td>Fallback Route</td>
            <td>Redirect URL tidak dikenali ke homepage</td>
            <td>P2</td>
        </tr>
    </tbody>
</table>

<h3>2.3 Non-Functional Requirements</h3>

<table>
    <thead>
        <tr>
            <th>Aspek</th>
            <th>Implementasi di MyBlog</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>Performance</strong></td>
            <td>Settings di-cache 1 jam; Eager loading relasi (<code>with()</code>) mencegah N+1 query problem</td>
        </tr>
        <tr>
            <td><strong>Security</strong></td>
            <td>Password hashing otomatis; Session regeneration saat login/logout; CSRF protection bawaan Laravel; Validasi input semua form</td>
        </tr>
        <tr>
            <td><strong>Scalability</strong></td>
            <td>Arsitektur MVC standar; Key-value settings memungkinkan penambahan konfigurasi tanpa migrasi database</td>
        </tr>
        <tr>
            <td><strong>File Storage</strong></td>
            <td>Featured images di <code>storage/app/public/articles</code>; Max upload 2MB; Format: jpeg, png, jpg, gif, webp</td>
        </tr>
    </tbody>
</table>

<hr>

<h2>BAGIAN 3: ERD — Entity Relationship Diagram</h2>

<p><strong>Fokus: "Bagaimana data MyBlog disimpan dan saling berhubungan?"</strong></p>

<p>Berikut adalah analisis ERD yang langsung diekstrak dari migration files di source code MyBlog. Total ada <strong>6 tabel custom</strong> + 6 tabel sistem Laravel.</p>

<h3>3.1 Entitas dan Atribut</h3>

<h4>Tabel <code>users</code></h4>
<table>
    <thead>
        <tr>
            <th>Kolom</th>
            <th>Tipe</th>
            <th>Constraint</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><code>id</code></td>
            <td>BIGINT</td>
            <td>PK, Auto Increment</td>
            <td>Primary Key</td>
        </tr>
        <tr>
            <td><code>name</code></td>
            <td>VARCHAR(255)</td>
            <td>NOT NULL</td>
            <td>Nama pengguna</td>
        </tr>
        <tr>
            <td><code>email</code></td>
            <td>VARCHAR(255)</td>
            <td>NOT NULL, UNIQUE</td>
            <td>Email unik</td>
        </tr>
        <tr>
            <td><code>email_verified_at</code></td>
            <td>TIMESTAMP</td>
            <td>NULL</td>
            <td>Verifikasi email</td>
        </tr>
        <tr>
            <td><code>password</code></td>
            <td>VARCHAR(255)</td>
            <td>NOT NULL</td>
            <td>Hashed otomatis</td>
        </tr>
        <tr>
            <td><code>is_admin</code></td>
            <td>BOOLEAN</td>
            <td>DEFAULT false</td>
            <td>Penanda admin</td>
        </tr>
        <tr>
            <td><code>remember_token</code></td>
            <td>VARCHAR(100)</td>
            <td>NULL</td>
            <td>Remember me token</td>
        </tr>
    </tbody>
</table>

<h4>Tabel <code>categories</code></h4>
<table>
    <thead>
        <tr>
            <th>Kolom</th>
            <th>Tipe</th>
            <th>Constraint</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><code>id</code></td>
            <td>BIGINT</td>
            <td>PK, Auto Increment</td>
            <td>Primary Key</td>
        </tr>
        <tr>
            <td><code>name</code></td>
            <td>VARCHAR(255)</td>
            <td>NOT NULL</td>
            <td>Nama kategori</td>
        </tr>
        <tr>
            <td><code>slug</code></td>
            <td>VARCHAR(255)</td>
            <td>UNIQUE</td>
            <td>URL-friendly identifier</td>
        </tr>
        <tr>
            <td><code>description</code></td>
            <td>TEXT</td>
            <td>NULL</td>
            <td>Deskripsi kategori</td>
        </tr>
    </tbody>
</table>

<h4>Tabel <code>articles</code></h4>
<table>
    <thead>
        <tr>
            <th>Kolom</th>
            <th>Tipe</th>
            <th>Constraint</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><code>id</code></td>
            <td>BIGINT</td>
            <td>PK, Auto Increment</td>
            <td>Primary Key</td>
        </tr>
        <tr>
            <td><code>user_id</code></td>
            <td>BIGINT</td>
            <td>FK → users.id, CASCADE</td>
            <td>Penulis artikel</td>
        </tr>
        <tr>
            <td><code>category_id</code></td>
            <td>BIGINT</td>
            <td>FK → categories.id, SET NULL, NULL</td>
            <td>Kategori artikel</td>
        </tr>
        <tr>
            <td><code>title</code></td>
            <td>VARCHAR(255)</td>
            <td>NOT NULL</td>
            <td>Judul artikel</td>
        </tr>
        <tr>
            <td><code>slug</code></td>
            <td>VARCHAR(255)</td>
            <td>UNIQUE</td>
            <td>URL slug</td>
        </tr>
        <tr>
            <td><code>excerpt</code></td>
            <td>TEXT</td>
            <td>NULL</td>
            <td>Ringkasan singkat</td>
        </tr>
        <tr>
            <td><code>content</code></td>
            <td>LONGTEXT</td>
            <td>NOT NULL</td>
            <td>Konten HTML</td>
        </tr>
        <tr>
            <td><code>featured_image</code></td>
            <td>VARCHAR(255)</td>
            <td>NULL</td>
            <td>Path gambar</td>
        </tr>
        <tr>
            <td><code>status</code></td>
            <td>ENUM</td>
            <td>draft/published, DEFAULT draft</td>
            <td>Status publikasi</td>
        </tr>
        <tr>
            <td><code>published_at</code></td>
            <td>TIMESTAMP</td>
            <td>NULL</td>
            <td>Tanggal publikasi</td>
        </tr>
        <tr>
            <td><code>views</code></td>
            <td>INTEGER</td>
            <td>DEFAULT 0</td>
            <td>Jumlah views</td>
        </tr>
    </tbody>
</table>

<h4>Tabel <code>portfolios</code></h4>
<table>
    <thead>
        <tr>
            <th>Kolom</th>
            <th>Tipe</th>
            <th>Constraint</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><code>id</code></td>
            <td>BIGINT</td>
            <td>PK, Auto Increment</td>
            <td>Primary Key</td>
        </tr>
        <tr>
            <td><code>title</code></td>
            <td>VARCHAR(255)</td>
            <td>NOT NULL</td>
            <td>Judul proyek</td>
        </tr>
        <tr>
            <td><code>slug</code></td>
            <td>VARCHAR(255)</td>
            <td>UNIQUE</td>
            <td>URL slug</td>
        </tr>
        <tr>
            <td><code>description</code></td>
            <td>TEXT</td>
            <td>NOT NULL</td>
            <td>Deskripsi singkat</td>
        </tr>
        <tr>
            <td><code>content</code></td>
            <td>LONGTEXT</td>
            <td>NULL</td>
            <td>Detail proyek</td>
        </tr>
        <tr>
            <td><code>featured_image</code></td>
            <td>VARCHAR(255)</td>
            <td>NULL</td>
            <td>Gambar utama</td>
        </tr>
        <tr>
            <td><code>client_name</code></td>
            <td>VARCHAR(255)</td>
            <td>NULL</td>
            <td>Nama klien</td>
        </tr>
        <tr>
            <td><code>project_url</code></td>
            <td>VARCHAR(255)</td>
            <td>NULL</td>
            <td>Link proyek</td>
        </tr>
        <tr>
            <td><code>technologies</code></td>
            <td>JSON</td>
            <td>NULL</td>
            <td>Array teknologi</td>
        </tr>
        <tr>
            <td><code>completed_at</code></td>
            <td>DATE</td>
            <td>NULL</td>
            <td>Tanggal selesai</td>
        </tr>
        <tr>
            <td><code>is_featured</code></td>
            <td>BOOLEAN</td>
            <td>DEFAULT false</td>
            <td>Proyek unggulan</td>
        </tr>
        <tr>
            <td><code>order</code></td>
            <td>INTEGER</td>
            <td>DEFAULT 0</td>
            <td>Urutan tampilan</td>
        </tr>
    </tbody>
</table>

<h4>Tabel <code>settings</code></h4>
<table>
    <thead>
        <tr>
            <th>Kolom</th>
            <th>Tipe</th>
            <th>Constraint</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><code>id</code></td>
            <td>BIGINT</td>
            <td>PK, Auto Increment</td>
            <td>Primary Key</td>
        </tr>
        <tr>
            <td><code>key</code></td>
            <td>VARCHAR(255)</td>
            <td>UNIQUE</td>
            <td>Identifier setting</td>
        </tr>
        <tr>
            <td><code>value</code></td>
            <td>TEXT</td>
            <td>NULL</td>
            <td>Nilai setting</td>
        </tr>
    </tbody>
</table>

<h4>Tabel <code>contact_messages</code></h4>
<table>
    <thead>
        <tr>
            <th>Kolom</th>
            <th>Tipe</th>
            <th>Constraint</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><code>id</code></td>
            <td>BIGINT</td>
            <td>PK, Auto Increment</td>
            <td>Primary Key</td>
        </tr>
        <tr>
            <td><code>name</code></td>
            <td>VARCHAR(255)</td>
            <td>NOT NULL</td>
            <td>Nama pengirim</td>
        </tr>
        <tr>
            <td><code>email</code></td>
            <td>VARCHAR(255)</td>
            <td>NOT NULL</td>
            <td>Email pengirim</td>
        </tr>
        <tr>
            <td><code>subject</code></td>
            <td>VARCHAR(255)</td>
            <td>NOT NULL</td>
            <td>Subjek pesan</td>
        </tr>
        <tr>
            <td><code>message</code></td>
            <td>TEXT</td>
            <td>NOT NULL</td>
            <td>Isi pesan</td>
        </tr>
        <tr>
            <td><code>is_read</code></td>
            <td>BOOLEAN</td>
            <td>DEFAULT false</td>
            <td>Status sudah dibaca</td>
        </tr>
    </tbody>
</table>

<h3>3.2 Relasi Antar Entitas</h3>

<table>
    <thead>
        <tr>
            <th>Relasi</th>
            <th>Tipe</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>Users → Articles</strong></td>
            <td>One-to-Many (1:N)</td>
            <td>Satu user menulis banyak artikel. <code>ON DELETE CASCADE</code> — hapus user = hapus semua artikelnya</td>
        </tr>
        <tr>
            <td><strong>Categories → Articles</strong></td>
            <td>One-to-Many (1:N)</td>
            <td>Satu kategori memiliki banyak artikel. <code>ON DELETE SET NULL</code> — hapus kategori = artikel tetap ada, <code>category_id</code> jadi NULL</td>
        </tr>
        <tr>
            <td><strong>Portfolios</strong></td>
            <td>Standalone</td>
            <td>Tidak memiliki relasi FK ke tabel lain</td>
        </tr>
        <tr>
            <td><strong>Settings</strong></td>
            <td>Standalone</td>
            <td>Key-value store independen</td>
        </tr>
        <tr>
            <td><strong>Contact Messages</strong></td>
            <td>Standalone</td>
            <td>Tabel independen untuk pesan pengunjung</td>
        </tr>
    </tbody>
</table>

<h3>3.3 Desain Khusus yang Menarik</h3>

<ul>
    <li><strong>Cascade vs Set Null:</strong> Perhatikan perbedaan strategi <em>ON DELETE</em> — artikel dihapus saat user dihapus (<em>cascade</em>), tapi artikel dipertahankan saat kategori dihapus (<em>set null</em>). Ini menunjukkan bahwa konten artikel lebih berharga daripada pengelompokan kategorinya.</li>
    <li><strong>JSON Column:</strong> Kolom <code>technologies</code> pada tabel <code>portfolios</code> menggunakan tipe JSON, memungkinkan penyimpanan array fleksibel tanpa tabel relasi terpisah.</li>
    <li><strong>Key-Value Pattern:</strong> Tabel <code>settings</code> menggunakan pola <em>key-value store</em> dengan caching, sehingga penambahan konfigurasi baru tidak memerlukan migrasi database.</li>
    <li><strong>Soft Status:</strong> Artikel menggunakan ENUM <code>draft/published</code> dikombinasikan dengan <code>published_at</code> timestamp, memberikan kontrol publikasi yang presisi — bahkan bisa dijadwalkan untuk publish di masa depan.</li>
</ul>

<hr>

<h2>Kesimpulan</h2>

<p>Melalui studi kasus MyBlog, kita bisa melihat bagaimana <strong>BRD</strong>, <strong>PRD</strong>, dan <strong>ERD</strong> bukan hanya dokumen teoritis, melainkan benar-benar tercermin dalam setiap baris kode aplikasi:</p>

<ul>
    <li><strong>BRD</strong> menjawab <em>"mengapa"</em> — kebutuhan branding digital, knowledge sharing, dan lead generation terwujud dalam fitur homepage, blog, portfolio, dan contact form.</li>
    <li><strong>PRD</strong> menjawab <em>"apa"</em> — 10 fitur utama dengan 40+ sub-fitur terperinci, mulai dari CRUD konten hingga backup database, semuanya terimplementasi dalam 14 controller.</li>
    <li><strong>ERD</strong> menjawab <em>"bagaimana"</em> — 6 tabel database dengan relasi yang terencana, constraint yang tepat, dan desain yang mempertimbangkan integritas data jangka panjang.</li>
</ul>

<p>Dengan memahami ketiga lapisan ini secara bersamaan, kita tidak hanya belajar <em>membuat</em> aplikasi, tetapi juga belajar <em>merancang</em> aplikasi yang benar — dari visi bisnis hingga struktur data yang kokoh.</p>
',
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(50, 200),
        ]);

        $this->command->info('Study Kasus MyBlog BRD PRD ERD Article created successfully!');
    }
}
