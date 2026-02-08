<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class FbEngagementArticleSeeder extends Seeder
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

        // Create FB Engagement article
        Article::create([
            'title' => 'FB Engagement Manager - Aplikasi Manajemen Interaksi Facebook',
            'slug' => 'fb-engagement-manager-manajemen-interaksi-facebook',
            'excerpt' => 'Aplikasi untuk mengelola dan mengoptimalkan engagement di Facebook dengan fitur content calendar, template komentar, dan tracking misi harian.',
            'content' => '
<p><strong>FB Engagement Manager</strong> adalah aplikasi berbasis web yang dirancang untuk membantu mengelola dan mengoptimalkan interaksi di platform Facebook. Aplikasi ini menyediakan berbagai fitur untuk meningkatkan engagement secara sistematis dan terukur.</p>

<h2>Fitur Utama</h2>

<h3>📅 Content Calendar</h3>
<ul>
    <li>Perencanaan konten posting harian/mingguan</li>
    <li>Penjadwalan posting otomatis</li>
    <li>Visualisasi kalender yang mudah dipahami</li>
</ul>

<h3>💬 Template Komentar</h3>
<ul>
    <li>Buat dan simpan template komentar</li>
    <li>Kategorisasi template berdasarkan tipe</li>
    <li>Quick-access untuk reply cepat</li>
</ul>

<h3>🎯 Sistem Misi</h3>
<ul>
    <li><strong>Daily Mission</strong> - Target engagement harian</li>
    <li><strong>Outbound Mission</strong> - Misi komentar ke halaman lain</li>
    <li><strong>Inbound Reply</strong> - Tracking balasan masuk</li>
</ul>

<h3>📊 Engagement Log</h3>
<ul>
    <li>Tracking semua aktivitas engagement</li>
    <li>Statistik performa harian/mingguan</li>
    <li>Laporan pencapaian target</li>
</ul>

<h3>🏷️ Manajemen Target</h3>
<ul>
    <li>Daftar halaman/akun target engagement</li>
    <li>Tagging dan kategorisasi target</li>
    <li>Prioritas dan status tracking</li>
</ul>

<h3>📝 My Post</h3>
<ul>
    <li>Kelola semua posting Anda</li>
    <li>Tracking performa setiap post</li>
    <li>Analisis engagement per konten</li>
</ul>

<h2>Teknologi</h2>

<p>Dibangun dengan:</p>
<ul>
    <li><strong>Backend</strong>: Laravel + MySQL</li>
    <li><strong>Frontend</strong>: Blade + Tailwind CSS</li>
    <li><strong>Build Tool</strong>: Vite</li>
</ul>

<p>FB Engagement Manager membantu Anda mengelola aktivitas engagement Facebook secara lebih terstruktur, efisien, dan terukur.</p>
',
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(50, 200),
        ]);

        $this->command->info('FB Engagement article created successfully!');
    }
}
