<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class TaarufArticleSeeder extends Seeder
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

        // Create Taaruf article
        Article::create([
            'title' => 'Taaruf Online - Aplikasi Perkenalan Islami untuk Mencari Jodoh',
            'slug' => 'taaruf-online-aplikasi-perkenalan-islami',
            'excerpt' => 'Aplikasi taaruf online untuk membantu proses perkenalan Islami menuju pernikahan yang sesuai syariat.',
            'content' => '
<p><strong>Taaruf Online</strong> adalah aplikasi yang bertujuan untuk menghubungkan orang-orang yang berstatus sendiri untuk saling mengenal atau perkenalan. Dalam konteks mencari jodoh, aplikasi taaruf ini murni proses Islami untuk mengenal calon pasangan hidup dengan cara yang sesuai syariat, dengan tujuan tunggal menuju pernikahan.</p>

<h2>Apa itu Taaruf?</h2>
<p>Taaruf dalam Islam adalah proses perkenalan antara laki-laki dan perempuan dengan tujuan menikah. Berbeda dengan pacaran, taaruf dilakukan dengan cara yang dibenarkan syariat Islam, yaitu dengan melibatkan keluarga atau pihak ketiga sebagai perantara.</p>

<h2>Fitur Utama</h2>

<h3>👤 Profil Lengkap</h3>
<ul>
    <li>Registrasi dengan verifikasi data</li>
    <li>Biodata lengkap sesuai kebutuhan taaruf</li>
    <li>Kriteria pasangan yang diinginkan</li>
    <li>Foto profil dengan validasi admin</li>
</ul>

<h3>💑 Proses Taaruf</h3>
<ul>
    <li>Mencari kandidat berdasarkan kriteria</li>
    <li>Like/Dislike sistem untuk menunjukkan ketertarikan</li>
    <li>Chat dengan kandidat yang mutual</li>
    <li>Progress tracking proses taaruf</li>
</ul>

<h3>📋 Admin Panel</h3>
<ul>
    <li>Approve data karyawan yang mendaftar</li>
    <li>Kelola artikel dan konten edukasi</li>
    <li>Monitoring proses taaruf</li>
    <li>Cetak surat undangan konsultasi</li>
</ul>

<h3>📰 Konten Edukasi</h3>
<ul>
    <li>Artikel tentang taaruf dan pernikahan Islami</li>
    <li>Video edukasi dari YouTube</li>
    <li>QnA seputar taaruf</li>
</ul>

<h2>Platform</h2>
<p>Taaruf Online tersedia dalam dua platform:</p>
<ul>
    <li><strong>Web App</strong> - Diakses melalui browser dengan React + Vite</li>
    <li><strong>Mobile App</strong> - Aplikasi mobile dengan React Native (Expo)</li>
</ul>

<h2>Teknologi</h2>
<p>Dibangun dengan arsitektur monorepo modern:</p>
<ul>
    <li><strong>API Backend</strong>: Laravel 12 + PostgreSQL + Sanctum</li>
    <li><strong>Web Frontend</strong>: React 19 + Vite 6</li>
    <li><strong>Mobile App</strong>: React Native + Expo</li>
    <li><strong>Database</strong>: PostgreSQL 15+</li>
</ul>

<h2>Keamanan & Privasi</h2>
<p>Aplikasi ini menjaga keamanan dan privasi pengguna dengan:</p>
<ul>
    <li>Autentikasi berbasis token (Laravel Sanctum)</li>
    <li>Verifikasi admin untuk setiap pendaftaran</li>
    <li>Data hanya bisa dilihat oleh pengguna yang terverifikasi</li>
    <li>Chat yang aman dan terlindungi</li>
</ul>

<p>Taaruf Online adalah solusi modern untuk proses taaruf yang sesuai syariat Islam, membantu mempermudah pencarian jodoh dengan cara yang halal dan bermartabat.</p>
',
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(50, 200),
        ]);

        $this->command->info('Taaruf article created successfully!');
    }
}
