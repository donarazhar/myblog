<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class SignageDisplayArticleSeeder extends Seeder
{
    public function run(): void
    {
        // Get admin user
        $admin = User::where('is_admin', true)->first();

        if (!$admin) {
            $this->command->warn('No admin user found. Please run DatabaseSeeder first.');
            return;
        }

        // Get or create category for Aplikasi
        $category = Category::firstOrCreate(
            ['name' => 'Aplikasi'],
            ['description' => 'Artikel tentang aplikasi yang telah dibuat']
        );

        // Create Digital Signage article
        Article::create([
            'title' => 'Digital Signage Masjid - Sistem Informasi Jamaah Modern',
            'slug' => 'digital-signage-masjid-informasi-jamaah',
            'excerpt' => 'Aplikasi Digital Signage untuk menampilkan jadwal shalat, agenda kegiatan, dan informasi masjid secara real-time di layar TV/Monitor.',
            'content' => '
<p><strong>Digital Signage Masjid</strong> adalah aplikasi manajemen informasi masjid modern berbasis web yang dirancang untuk menampilkan informasi jadwal shalat, agenda kegiatan, laporan keuangan, dan konten dakwah secara real-time di layar TV/Monitor masjid.</p>

<p>Sistem ini mendukung <strong>Multi-Masjid</strong> — satu sistem untuk mengelola banyak masjid dengan panel admin yang terpusat dan role management yang aman.</p>

<h2>Fitur Display Mode (Tampilan TV)</h2>

<p>Interface visual yang menawan untuk jamaah:</p>

<h3>🕌 Jadwal Shalat Otomatis</h3>
<ul>
    <li>Terintegrasi dengan API Aladhan</li>
    <li>Akurat sesuai lokasi koordinat masjid</li>
    <li>Smart countdown menuju waktu Adzan dan Iqamah</li>
    <li>Mode Shalat: layar otomatis gelap saat waktu shalat tiba</li>
</ul>

<h3>📺 Konten Visual Menarik</h3>
<ul>
    <li>Carousel gambar dan video untuk pengumuman</li>
    <li>Running text untuk berita singkat (Normal/Urgent/Berita Duka)</li>
    <li>Hadits harian dan kata mutiara bergantian</li>
    <li>Layout adaptif untuk berbagai ukuran layar</li>
</ul>

<h3>📋 Informasi Kegiatan</h3>
<ul>
    <li>Agenda kajian dan acara mendatang</li>
    <li>Informasi keuangan: saldo kas, QRIS, rekening donasi</li>
</ul>

<h2>Fitur Admin Panel</h2>

<p>Pusat kontrol berbasis web untuk pengurus masjid:</p>

<ul>
    <li><strong>Dashboard Statistik</strong> - Ringkasan konten dan status perangkat</li>
    <li><strong>Manajemen Konten</strong> - Upload poster, video, atur durasi tayang</li>
    <li><strong>Pengaturan Shalat</strong> - Koreksi waktu per-menit dan durasi jeda Iqamah</li>
    <li><strong>Agenda & Running Text</strong> - Input kegiatan dan teks berjalan</li>
    <li><strong>Laporan Keuangan</strong> - Update pemasukan/pengeluaran mingguan</li>
    <li><strong>Database Backup</strong> - Backup manual dan download SQL langsung</li>
</ul>

<h2>Super Admin & Multi-Masjid</h2>

<ul>
    <li>Kelola banyak masjid dalam satu instalasi</li>
    <li>Activity log: siapa melakukan apa dan kapan</li>
    <li>User management untuk admin tiap masjid</li>
</ul>

<h2>Teknologi</h2>

<p>Dibangun dengan teknologi modern:</p>

<ul>
    <li><strong>Backend</strong>: Laravel 11 + MySQL + Sanctum</li>
    <li><strong>Frontend</strong>: React 18 + TypeScript + Vite</li>
    <li><strong>Styling</strong>: Tailwind CSS + Framer Motion</li>
    <li><strong>State</strong>: React Query (TanStack Query)</li>
</ul>

<p>Digital Signage Masjid adalah solusi modern untuk menyampaikan informasi kepada jamaah secara profesional dan menarik, membantu pengurus masjid mengelola konten dengan mudah dari satu dashboard.</p>
',
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(50, 200),
        ]);

        $this->command->info('Digital Signage article created successfully!');
    }
}
