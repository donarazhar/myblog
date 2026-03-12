<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class UploadScormMoodleArticleSeeder extends Seeder
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
            ['name' => 'Tutorial'],
            ['description' => 'Tutorial dan panduan pengembangan aplikasi']
        );

        // Create Upload SCORM to Moodle article
        Article::create([
            'title' => 'Panduan Teknis: Mengunggah Modul SCORM ke Moodle LMS',
            'slug' => 'panduan-teknis-mengunggah-modul-scorm-ke-moodle-lms',
            'excerpt' => 'Panduan langkah demi langkah untuk mengunggah modul SCORM ke Moodle LMS, mulai dari persiapan file hingga konfigurasi pengaturan penting agar konten interaktif berkomunikasi dengan database nilai siswa.',
            'content' => '
<p>Proses ini adalah tahap krusial di mana konten interaktif Anda mulai &ldquo;berkomunikasi&rdquo; dengan database nilai siswa.</p>

<h2>Langkah 1: Persiapan File</h2>

<p>Pastikan file yang Anda miliki adalah satu file berformat <strong>.zip</strong>.</p>

<blockquote>
    <p><strong>Penting:</strong> Jangan mengekstrak isi folder tersebut. Moodle membutuhkan paket .zip utuh yang berisi file <code>imsmanifest.xml</code> di dalamnya agar bisa mengenali struktur SCORM tersebut.</p>
</blockquote>

<h2>Langkah 2: Masuk ke Kursus (Course)</h2>

<ol>
    <li>Login ke situs Moodle Anda sebagai <strong>Teacher</strong> atau <strong>Administrator</strong>.</li>
    <li>Pilih kursus tempat Anda ingin meletakkan modul tersebut dari <strong>Dashboard</strong>.</li>
</ol>

<h2>Langkah 3: Aktifkan Mode Ubah (Edit Mode)</h2>

<p>Di pojok kanan atas halaman kursus, geser tombol <strong>&ldquo;Edit mode&rdquo;</strong> ke posisi <strong>ON</strong>. Tanpa mengaktifkan ini, Anda tidak bisa menambah atau mengubah aktivitas apa pun.</p>

<h2>Langkah 4: Tambahkan Aktivitas SCORM</h2>

<ol>
    <li>Cari bagian (Topic/Week) di mana modul akan diletakkan.</li>
    <li>Klik <strong>&ldquo;Add an activity or resource&rdquo;</strong>.</li>
    <li>Pilih ikon <strong>&ldquo;SCORM package&rdquo;</strong> dari daftar aktivitas yang muncul.</li>
</ol>

<h2>Langkah 5: Konfigurasi Identitas dan File</h2>

<ul>
    <li><strong>Name:</strong> Berikan judul modul yang menarik (misal: <em>Modul 1: Literasi Keamanan Digital</em>).</li>
    <li><strong>Description:</strong> Isi dengan instruksi singkat bagi siswa (opsional).</li>
    <li><strong>Package file:</strong> Klik ikon panah biru atau <em>drag-and-drop</em> file .zip SCORM Anda ke kotak yang tersedia. Tunggu hingga proses unggah selesai.</li>
</ul>

<h2>Langkah 6: Pengaturan Penting (Critical Settings)</h2>

<p>Agar modul berjalan sesuai harapan, perhatikan tiga pengaturan utama ini:</p>

<table>
    <thead>
        <tr>
            <th>Kategori</th>
            <th>Pengaturan</th>
            <th>Rekomendasi</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>Appearance</strong></td>
            <td>Display Package</td>
            <td>Pilih &ldquo;New Window&rdquo; agar modul terbuka lebih luas dan tidak terpotong sidebar Moodle.</td>
        </tr>
        <tr>
            <td><strong>Availability</strong></td>
            <td>Choose Date</td>
            <td>Atur kapan modul ini mulai bisa diakses dan kapan akan ditutup.</td>
        </tr>
        <tr>
            <td><strong>Grade</strong></td>
            <td>Grading Method</td>
            <td>Pilih &ldquo;Learning Objects&rdquo; atau &ldquo;Highest Grade&rdquo; tergantung apakah Anda ingin mengambil nilai kuis tertinggi.</td>
        </tr>
        <tr>
            <td><strong>Attempts</strong></td>
            <td>Number of attempts</td>
            <td>Pilih &ldquo;Unlimited&rdquo; jika untuk latihan, atau &ldquo;1&rdquo; jika ini adalah ujian resmi.</td>
        </tr>
    </tbody>
</table>

<h2>Langkah 7: Simpan dan Uji Coba</h2>

<ol>
    <li>Gulir ke bawah dan klik <strong>&ldquo;Save and display&rdquo;</strong>.</li>
    <li>Klik tombol <strong>&ldquo;Enter&rdquo;</strong> untuk mencoba menjalankan modul.</li>
</ol>

<h3>Ceklist Pengujian:</h3>

<ul>
    <li>Apakah suara/audio terdengar?</li>
    <li>Apakah tombol &ldquo;Next&rdquo; berfungsi?</li>
    <li>Apakah kuis mengirimkan nilai ke Gradebook Moodle setelah selesai?</li>
</ul>

<h2>Tips Pro untuk Developer IT</h2>

<p>Jika Anda mengalami kendala di mana modul tidak mau terbuka (muncul pesan <em>error manifest</em>), biasanya masalah ada pada <strong>standard versi SCORM</strong>. Pastikan saat export dari aplikasi authoring, Anda memilih versi yang didukung oleh versi Moodle Anda (biasanya <strong>SCORM 1.2</strong> adalah yang paling stabil dan umum).</p>

<blockquote>
    <p><strong>Catatan:</strong> Jika Anda bekerja di lingkungan dengan koneksi internet yang tidak stabil, pastikan ukuran file .zip tidak terlalu besar (usahakan di bawah 50MB) agar proses loading siswa tidak terhambat.</p>
</blockquote>
',
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(50, 200),
        ]);

        $this->command->info('Upload SCORM to Moodle Article created successfully!');
    }
}
