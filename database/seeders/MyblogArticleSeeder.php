<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class MyblogArticleSeeder extends Seeder
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

        // Create MyBlog article
        Article::create([
            'title' => 'MyBlog - Personal Blog & Portfolio Website dengan Laravel',
            'slug' => 'myblog-personal-blog-portfolio-laravel',
            'excerpt' => 'Website blog dan portfolio pribadi yang modern, responsif, dan dilengkapi dengan admin panel untuk mengelola artikel, portfolio, dan pengaturan website.',
            'content' => '
<p>Di era digital saat ini, memiliki personal brand melalui website pribadi adalah hal yang sangat penting. <strong>MyBlog</strong> adalah solusi lengkap untuk membangun personal blog dan portfolio website yang profesional dan modern.</p>

<h2>Tentang MyBlog</h2>
<p>MyBlog adalah aplikasi web berbasis Laravel yang dirancang untuk menampilkan karya, artikel, dan portfolio secara elegan. Website ini memiliki tampilan modern dengan animasi smooth dan responsif di berbagai perangkat.</p>

<h2>Fitur Publik</h2>

<h3>🏠 Homepage</h3>
<ul>
    <li>Hero section dengan informasi profil</li>
    <li>Daftar artikel terbaru</li>
    <li>Showcase portfolio terpilih</li>
    <li>Link ke social media</li>
</ul>

<h3>📝 Blog/Articles</h3>
<ul>
    <li>Daftar artikel dengan pagination</li>
    <li>Kategori untuk mengorganisir artikel</li>
    <li>Search dan filter berdasarkan kategori</li>
    <li>Rich text content dengan formatting lengkap</li>
    <li>View counter untuk tracking popularitas</li>
</ul>

<h3>💼 Portfolio</h3>
<ul>
    <li>Galeri portfolio dengan thumbnail</li>
    <li>Detail project dengan deskripsi lengkap</li>
    <li>Link ke demo dan source code</li>
    <li>Teknologi yang digunakan dalam project</li>
</ul>

<h3>📞 Contact</h3>
<ul>
    <li>Form kontak untuk pengunjung</li>
    <li>Informasi email, telepon, dan alamat</li>
    <li>Link ke akun social media</li>
</ul>

<h3>👤 About</h3>
<ul>
    <li>Halaman about untuk menampilkan profil lengkap</li>
    <li>Deskripsi skill dan pengalaman</li>
</ul>

<h2>Admin Panel</h2>
<p>MyBlog dilengkapi dengan admin panel yang powerful untuk mengelola semua konten:</p>

<h3>📊 Dashboard</h3>
<ul>
    <li>Overview statistik artikel dan portfolio</li>
    <li>Quick access ke semua fitur admin</li>
</ul>

<h3>✍️ Manajemen Artikel</h3>
<ul>
    <li>CRUD artikel dengan TinyMCE rich text editor</li>
    <li>Upload featured image</li>
    <li>Draft dan publish status</li>
    <li>SEO-friendly dengan custom slug</li>
</ul>

<h3>📁 Manajemen Kategori</h3>
<ul>
    <li>CRUD kategori artikel</li>
    <li>Auto-generate slug dari nama kategori</li>
</ul>

<h3>💼 Manajemen Portfolio</h3>
<ul>
    <li>CRUD portfolio project</li>
    <li>Upload gambar project</li>
    <li>Link demo dan repository</li>
</ul>

<h3>📨 Messages</h3>
<ul>
    <li>Melihat pesan dari form kontak</li>
    <li>Manajemen inbox messages</li>
</ul>

<h3>⚙️ Settings</h3>
<ul>
    <li>Pengaturan nama dan deskripsi website</li>
    <li>Informasi kontak</li>
    <li>Link social media</li>
    <li>About content</li>
</ul>

<h3>👤 Profile</h3>
<ul>
    <li>Update nama dan email</li>
    <li>Ganti password</li>
</ul>

<h2>Teknologi</h2>
<p>MyBlog dibangun dengan stack modern:</p>
<ul>
    <li><strong>Backend</strong>: Laravel 12 (PHP 8.2+)</li>
    <li><strong>Database</strong>: MySQL</li>
    <li><strong>Frontend</strong>: Blade + Tailwind CSS</li>
    <li><strong>Rich Text Editor</strong>: TinyMCE</li>
    <li><strong>Build Tool</strong>: Vite</li>
    <li><strong>Font</strong>: Google Fonts (Inter)</li>
</ul>

<h2>Deployment</h2>
<p>Website dapat di-deploy dengan mudah ke berbagai platform:</p>
<ul>
    <li>VPS dengan Nginx/Apache</li>
    <li>Shared Hosting dengan PHP support</li>
    <li>Cloud Platform seperti DigitalOcean, AWS, dll</li>
    <li>Cloudflare Tunnel untuk subdomain custom</li>
</ul>

<p>MyBlog adalah bukti bahwa membangun personal brand secara online tidak harus sulit. Dengan teknologi modern dan fitur yang lengkap, Anda dapat fokus pada konten sementara platform mengurus sisanya.</p>
',
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(100, 300),
        ]);

        $this->command->info('MyBlog article created successfully!');
    }
}
