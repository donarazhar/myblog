<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class BrdPrdErdArticleSeeder extends Seeder
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

        // Create BRD PRD ERD article
        Article::create([
            'title' => 'Membedah Anatomi Aplikasi: Panduan Lengkap BRD, PRD, dan ERD',
            'slug' => 'membedah-anatomi-aplikasi-panduan-lengkap-brd-prd-dan-erd',
            'excerpt' => 'Memahami ketiga elemen kunci BRD, PRD, dan ERD dalam siklus pengembangan perangkat lunak (SDLC). Panduan lengkap definisi, fungsi, perbedaan, dan keterkaitan ketiga dokumen ini.',
            'content' => '
<p>Dalam ekosistem pengembangan perangkat lunak, kegagalan seringkali bukan disebabkan oleh kode yang buruk, melainkan oleh komunikasi yang tidak jelas. Di sinilah peran dokumentasi menjadi vital. Tiga akronim yang sering menjadi tulang punggung keberhasilan sebuah proyek digital adalah <strong>BRD</strong>, <strong>PRD</strong>, dan <strong>ERD</strong>.</p>

<p>Artikel ini akan mengupas tuntas definisi, fungsi, perbedaan, dan keterkaitan ketiga dokumen ini agar Anda dapat merancang aplikasi yang tidak hanya canggih secara teknis, tetapi juga sukses secara bisnis.</p>

<h2>1. BRD (Business Requirements Document)</h2>

<p><strong>Fokus Utama: &ldquo;Mengapa (Why) kita membangun ini?&rdquo;</strong></p>

<p>BRD adalah dokumen pondasi. Sebelum satu baris kode ditulis atau satu desain digambar, BRD harus ada untuk membenarkan keberadaan proyek tersebut dari sudut pandang bisnis. Dokumen ini mendefinisikan masalah bisnis yang ingin dipecahkan dan hasil yang diharapkan.</p>

<h3>Komponen Utama BRD:</h3>

<ul>
    <li><strong>Pernyataan Masalah (<em>Problem Statement</em>):</strong> Kendala apa yang sedang dihadapi organisasi atau pasar saat ini?</li>
    <li><strong>Tujuan Bisnis (<em>Business Objectives</em>):</strong> Apa target konkretnya? (Misalnya: Meningkatkan penjualan sebesar 20% atau efisiensi waktu kerja 30%).</li>
    <li><strong>Ruang Lingkup Proyek (<em>Scope</em>):</strong> Batasan apa yang termasuk dan <em>tidak</em> termasuk dalam proyek ini.</li>
    <li><strong>Analisis Keuangan:</strong> Estimasi anggaran, proyeksi ROI (<em>Return on Investment</em>), dan analisis biaya-manfaat.</li>
    <li><strong>Jadwal Tingkat Tinggi:</strong> <em>Timeline</em> kasar kapan proyek harus selesai.</li>
</ul>

<p><strong>Siapa yang Membuat?</strong><br>Biasanya disusun oleh <em>Business Analyst</em>, <em>Project Manager</em>, atau Konsultan Bisnis.</p>

<p><strong>Siapa yang Membaca?</strong><br>Eksekutif C-Level (CEO, CTO), Investor, dan Klien (Pemilik Proyek).</p>

<h2>2. PRD (Product Requirements Document)</h2>

<p><strong>Fokus Utama: &ldquo;Apa (What) yang akan kita bangun?&rdquo;</strong></p>

<p>Jika BRD adalah &ldquo;keinginan bisnis&rdquo;, maka PRD adalah &ldquo;solusi produk&rdquo;. Dokumen ini menerjemahkan bahasa bisnis yang abstrak menjadi spesifikasi fungsional yang bisa dipahami oleh tim teknis. PRD adalah &ldquo;kitab suci&rdquo; bagi tim produk selama masa pengembangan.</p>

<h3>Komponen Utama PRD:</h3>

<ul>
    <li><strong>Fitur &amp; Fungsionalitas:</strong> Daftar lengkap fitur yang harus ada (misalnya: <em>Login</em> dengan Google, Keranjang Belanja, <em>Dashboard</em> Admin).</li>
    <li><strong>User Stories:</strong> Deskripsi fitur dari sudut pandang pengguna.<br><em>Contoh: &ldquo;Sebagai admin, saya ingin bisa mengunduh laporan bulanan agar bisa menganalisis tren penjualan.&rdquo;</em></li>
    <li><strong>Kriteria Penerimaan (<em>Acceptance Criteria</em>):</strong> Syarat mutlak agar sebuah fitur dianggap &ldquo;selesai&rdquo; dan berfungsi benar.</li>
    <li><strong>User Flow &amp; Wireframes:</strong> Sketsa kasar antarmuka dan alur navigasi pengguna di dalam aplikasi.</li>
    <li><strong>Kebutuhan Non-Fungsional:</strong> Kecepatan <em>loading</em>, keamanan data, dan kapasitas server.</li>
</ul>

<p><strong>Siapa yang Membuat?</strong><br><em>Product Manager</em> atau <em>Product Owner</em>.</p>

<p><strong>Siapa yang Membaca?</strong><br>Tim UI/UX Designer, Tim Pengembang (<em>Developer</em>), dan QA (<em>Quality Assurance</em>).</p>

<h2>3. ERD (Entity Relationship Diagram)</h2>

<p><strong>Fokus Utama: &ldquo;Bagaimana (How) data disimpan dan saling berhubungan?&rdquo;</strong></p>

<p>Berbeda dengan dua dokumen sebelumnya yang berbasis teks naratif, ERD adalah representasi visual (diagram) dari struktur data. ERD adalah cetak biru (<em>blueprint</em>) bagi database aplikasi. Tanpa ERD yang baik, aplikasi akan mengalami masalah performa, redundansi data, dan sulit dikembangkan di masa depan.</p>

<h3>Komponen Utama ERD:</h3>

<ul>
    <li><strong>Entitas (<em>Entity</em>):</strong> Objek yang datanya disimpan (Contoh: Tabel <code>User</code>, Tabel <code>Produk</code>, Tabel <code>Transaksi</code>).</li>
    <li><strong>Atribut (<em>Attribute</em>):</strong> Detail dari entitas tersebut (Contoh: Pada entitas <code>User</code>, atributnya adalah <code>Username</code>, <code>Password</code>, <code>Email</code>).</li>
    <li><strong>Relasi (<em>Relationship</em>):</strong> Hubungan antar entitas.
        <ul>
            <li><em>One-to-One:</em> Satu pengguna punya satu KTP.</li>
            <li><em>One-to-Many:</em> Satu pelanggan bisa membuat banyak pesanan.</li>
            <li><em>Many-to-Many:</em> Satu siswa bisa mengambil banyak kelas, dan satu kelas bisa diambil banyak siswa.</li>
        </ul>
    </li>
    <li><strong>Kardinalitas:</strong> Aturan jumlah minimum dan maksimum dalam hubungan tersebut.</li>
</ul>

<p><strong>Siapa yang Membuat?</strong><br><em>System Analyst</em>, <em>Database Administrator</em>, atau <em>Backend Developer</em>.</p>

<p><strong>Siapa yang Membaca?</strong><br><em>Backend Developer</em> dan <em>Database Architect</em>.</p>

<h2>Tabel Perbandingan Komprehensif</h2>

<table>
    <thead>
        <tr>
            <th>Dimensi</th>
            <th>BRD (Business)</th>
            <th>PRD (Product)</th>
            <th>ERD (Technical)</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>Perspektif</strong></td>
            <td>Strategi &amp; Pasar</td>
            <td>Pengguna &amp; Fungsi</td>
            <td>Struktur &amp; Data</td>
        </tr>
        <tr>
            <td><strong>Pertanyaan Kunci</strong></td>
            <td>Apakah proyek ini menguntungkan?</td>
            <td>Fitur apa yang dibutuhkan user?</td>
            <td>Bagaimana tabel database disusun?</td>
        </tr>
        <tr>
            <td><strong>Bentuk Output</strong></td>
            <td>Dokumen Teks &amp; Angka</td>
            <td>Dokumen Teks, Wireframe, Flowchart</td>
            <td>Diagram Visual</td>
        </tr>
        <tr>
            <td><strong>Fleksibilitas</strong></td>
            <td>Kaku (jarang berubah setelah disetujui)</td>
            <td>Moderat (berubah sesuai iterasi)</td>
            <td>Kaku (sulit diubah jika sudah <em>live</em>)</td>
        </tr>
        <tr>
            <td><strong>Tahapan SDLC</strong></td>
            <td>Inisiasi / Perencanaan Awal</td>
            <td>Perancangan &amp; Desain</td>
            <td>Perancangan Teknis / Arsitektur</td>
        </tr>
    </tbody>
</table>

<h2>Studi Kasus: Aplikasi Perpustakaan Digital</h2>

<p>Untuk memudahkan pemahaman, mari kita lihat bagaimana ketiga dokumen ini bekerja dalam satu proyek pembuatan <strong>Aplikasi Perpustakaan Sekolah</strong>.</p>

<h3>1. Dalam BRD:</h3>

<p>Disebutkan bahwa sekolah ingin mengurangi biaya pembelian buku fisik sebesar 40% dan meningkatkan minat baca siswa. Targetnya adalah sistem yang bisa diakses 1.000 siswa secara bersamaan.</p>

<h3>2. Dalam PRD:</h3>

<p>Dijelaskan fitur spesifik: Siswa harus bisa meminjam <em>e-book</em> maksimal 3 hari. Jika lewat, buku otomatis hilang dari akun siswa (fitur <em>auto-return</em>). Ada fitur pencarian berdasarkan judul, pengarang, dan kategori.</p>

<h3>3. Dalam ERD:</h3>

<p>Digambarkan tabel database:</p>

<ul>
    <li>Tabel <code>Siswa</code> (ID, Nama, Kelas).</li>
    <li>Tabel <code>Buku</code> (Kode Buku, Judul, Pengarang, Stok Digital).</li>
    <li>Tabel <code>Peminjaman</code> yang menghubungkan <code>Siswa</code> dan <code>Buku</code> (ID Peminjaman, Tanggal Pinjam, Tanggal Kembali).</li>
</ul>

<h2>Kesimpulan</h2>

<p>Ketiga dokumen ini tidak berdiri sendiri, melainkan saling bergantung. <strong>BRD</strong> memastikan kita tidak membuang uang untuk proyek yang salah. <strong>PRD</strong> memastikan kita membangun fitur yang benar untuk memecahkan masalah tersebut. Dan <strong>ERD</strong> memastikan sistem yang dibangun kokoh dan mampu menangani data dengan efisien.</p>

<p>Melewatkan salah satu dari tahap ini seringkali menjadi resep bagi <em>scope creep</em> (fitur melebar tak terkendali), pembengkakan biaya, atau aplikasi yang gagal berfungsi saat diluncurkan.</p>
',
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(50, 200),
        ]);

        $this->command->info('BRD PRD ERD Article created successfully!');
    }
}
