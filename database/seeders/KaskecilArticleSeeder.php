<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class KaskecilArticleSeeder extends Seeder
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

        // Create Kas Kecil article
        Article::create([
            'title' => 'Kas Kecil v4.0 - Aplikasi Pengelolaan Petty Cash dengan Metode Imprest',
            'slug' => 'kas-kecil-aplikasi-petty-cash-imprest',
            'excerpt' => 'Sistem pengelolaan kas kecil (Petty Cash) berbasis metode Imprest (Dana Tetap) dengan dukungan multi-platform (Web & Mobile).',
            'content' => '
<p>Mengelola kas kecil di organisasi besar dengan banyak cabang dan unit bisa menjadi tantangan tersendiri. Untuk menjawab kebutuhan ini, kami mengembangkan <strong>Kas Kecil v4.0</strong> — sebuah sistem pengelolaan petty cash yang modern dan terintegrasi.</p>

<h2>Apa itu Metode Imprest?</h2>
<p>Metode Imprest atau <strong>Dana Tetap</strong> adalah sistem pengelolaan kas kecil dimana jumlah dana kas kecil selalu dijaga pada tingkat yang tetap. Setiap kali terjadi pengeluaran, dana akan diisi kembali (reimbursement) sebesar pengeluaran tersebut agar kembali ke saldo awal.</p>

<h2>Fitur Utama</h2>

<h3>🏢 Manajemen Multi-Level</h3>
<p>Aplikasi ini mendukung struktur organisasi bertingkat:</p>
<ul>
    <li><strong>Instansi</strong> - Organisasi induk</li>
    <li><strong>Cabang</strong> - Kantor regional</li>
    <li><strong>Unit</strong> - Unit kerja seperti Keuangan, SDM, IT</li>
</ul>

<h3>💵 Transaksi Real-time</h3>
<ul>
    <li>Input transaksi pengeluaran dengan upload bukti (hingga 3 lampiran)</li>
    <li>Pengisian kas otomatis sesuai metode Imprest</li>
    <li>Tracking saldo realtime per unit</li>
</ul>

<h3>📊 Sistem Akuntansi</h3>
<ul>
    <li>Akun AAS (Debet/Kredit)</li>
    <li>Mata Anggaran dengan tracking saldo</li>
    <li>Laporan konsolidasi dan rekap</li>
</ul>

<h3>🔐 Role-Based Access Control</h3>
<ul>
    <li><strong>Super Admin</strong> - Akses penuh ke semua data</li>
    <li><strong>Admin Unit</strong> - Input transaksi untuk unit sendiri</li>
</ul>

<h2>Platform</h2>
<p>Kas Kecil tersedia dalam dua platform:</p>
<ul>
    <li><strong>Web App</strong> - Diakses melalui browser untuk pengelolaan di desktop</li>
    <li><strong>Mobile App</strong> - Aplikasi mobile untuk input transaksi di lapangan</li>
</ul>

<h2>Teknologi</h2>
<p>Dibangun dengan teknologi modern:</p>
<ul>
    <li><strong>Frontend</strong>: React + Vite + Tailwind CSS</li>
    <li><strong>Mobile</strong>: React Native (Expo)</li>
    <li><strong>Backend</strong>: Laravel 12 (PHP 8.2+)</li>
    <li><strong>Database</strong>: PostgreSQL</li>
    <li><strong>Monorepo</strong>: Turbo Repo</li>
</ul>

<p>Kas Kecil v4.0 adalah solusi lengkap untuk organisasi yang membutuhkan sistem pengelolaan kas kecil yang terstruktur, transparan, dan mudah diaudit.</p>
',
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(50, 200),
        ]);

        $this->command->info('Kas Kecil article created successfully!');
    }
}
