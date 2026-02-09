<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class IttdLearnhubArticleSeeder extends Seeder
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

        // Create ITTD LearnHub article
        Article::create([
            'title' => 'ITTD LearnHub - Platform Pembelajaran Internal untuk Pegawai IT',
            'slug' => 'ittd-learnhub-platform-pembelajaran-it',
            'excerpt' => 'Learning Management System (LMS) berbasis web untuk meningkatkan kompetensi dan skill pegawai IT dengan fitur video learning, progress tracking, dan forum diskusi.',
            'content' => '
<p>Pengembangan kompetensi sumber daya manusia adalah investasi penting bagi setiap organisasi. Untuk mendukung hal tersebut, kami mengembangkan <strong>ITTD LearnHub</strong> — sebuah platform pembelajaran internal yang dirancang khusus untuk meningkatkan keterampilan teknis pegawai IT.</p>

<h2>Mengapa ITTD LearnHub?</h2>
<p>Pelatihan konvensional memiliki beberapa kendala seperti jadwal yang kaku, biaya trainer eksternal yang tinggi, dan kesulitan dalam tracking progress. ITTD LearnHub hadir sebagai solusi dengan konsep <strong>self-paced learning</strong> — belajar sesuai waktu dan kecepatan masing-masing.</p>

<h2>Fitur Utama</h2>

<h3>📚 Untuk Pegawai (Learner)</h3>
<ul>
    <li><strong>Browse & Enroll Kursus</strong> - Melihat katalog kursus dan mendaftar ke kursus yang diminati</li>
    <li><strong>Video Learning</strong> - Pembelajaran berbasis video dengan fitur resume otomatis dari posisi terakhir</li>
    <li><strong>Personal Notes</strong> - Membuat catatan pribadi di setiap materi pembelajaran</li>
    <li><strong>Progress Tracking</strong> - Monitoring progress pembelajaran secara real-time</li>
    <li><strong>Forum Diskusi</strong> - Berdiskusi dan bertanya tentang materi pembelajaran</li>
    <li><strong>Review & Rating</strong> - Memberikan review dan rating untuk kursus yang telah diselesaikan</li>
</ul>

<h3>✍️ Untuk Kontributor (Content Creator)</h3>
<ul>
    <li><strong>Membuat Kursus</strong> - Membuat dan mengelola kursus pembelajaran sendiri</li>
    <li><strong>Manajemen Modul</strong> - Mengorganisir materi dalam modul-modul terstruktur</li>
    <li><strong>Drag & Drop Reorder</strong> - Mengatur ulang urutan modul dan materi dengan mudah</li>
    <li><strong>Analytics</strong> - Melihat statistik dan performa kursus yang dibuat</li>
</ul>

<h3>👥 Untuk Admin</h3>
<ul>
    <li><strong>User Management</strong> - Mengelola akun pegawai dengan operasi CRUD</li>
    <li><strong>Full Course Management</strong> - Mengelola semua kursus dari semua kontributor</li>
    <li><strong>Advanced Analytics</strong> - Dashboard analytics lengkap dengan metrics seperti popular courses, user activity tracking, completion rate, dan enrollment statistics</li>
</ul>

<h2>Struktur Pembelajaran</h2>
<p>Konten pembelajaran disusun secara hierarkis untuk memudahkan navigasi:</p>
<ul>
    <li><strong>Kursus</strong> - Topik utama pembelajaran (contoh: Laravel Fundamental)</li>
    <li><strong>Modul</strong> - Bab atau sub-topik dalam kursus (contoh: Routing, Controller, Model)</li>
    <li><strong>Materi</strong> - Konten spesifik dalam modul (video, teks, attachment)</li>
</ul>

<h2>Kursus yang Tersedia</h2>
<p>Beberapa kursus yang telah tersedia:</p>
<ul>
    <li><strong>Laravel Fundamental</strong> - Dasar-dasar Laravel framework (8 jam, Beginner)</li>
    <li><strong>Vue.js for Beginners</strong> - Pengembangan frontend modern dengan Vue.js (6 jam, Beginner)</li>
    <li><strong>Advanced PHP Programming</strong> - Design patterns, testing, dan best practices (12 jam, Advanced)</li>
    <li><strong>RESTful API Development</strong> - Membangun RESTful API yang scalable (9 jam, Intermediate)</li>
    <li><strong>Database Design Mastery</strong> - Normalisasi hingga optimasi query (10 jam, Intermediate)</li>
</ul>

<h2>Teknologi</h2>
<p>Platform dibangun dengan teknologi modern:</p>
<ul>
    <li><strong>Backend</strong>: Laravel 12 (PHP 8.2+)</li>
    <li><strong>Database</strong>: MySQL 8.0</li>
    <li><strong>Frontend</strong>: Blade + Tailwind CSS + Alpine.js</li>
    <li><strong>Authentication</strong>: Laravel Breeze (customized)</li>
</ul>

<h2>Alur Pembelajaran</h2>
<p>Flow end-to-end dari enrollment hingga completion:</p>
<ol>
    <li>User browse katalog kursus yang tersedia</li>
    <li>Enroll ke kursus yang diminati</li>
    <li>Akses materi dan tonton video pembelajaran</li>
    <li>Sistem menyimpan posisi terakhir video (auto-resume)</li>
    <li>Tandai materi sebagai selesai</li>
    <li>Progress dihitung otomatis (completed/total * 100%)</li>
    <li>Jika 100%, kursus ditandai complete</li>
    <li>Submit review dan rating</li>
</ol>

<p>ITTD LearnHub adalah bukti komitmen kami dalam menciptakan ekosistem pembelajaran yang terstruktur, terukur, dan berkelanjutan untuk pengembangan SDM di bidang IT.</p>
',
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(80, 250),
        ]);

        $this->command->info('ITTD LearnHub article created successfully!');
    }
}
