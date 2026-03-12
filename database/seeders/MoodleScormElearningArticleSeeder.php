<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class MoodleScormElearningArticleSeeder extends Seeder
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

        // Create Moodle & SCORM E-Learning article
        Article::create([
            'title' => 'Arsitektur Pembelajaran Digital: Mentransformasi Materi Mentah Menjadi Modul Interaktif Berbasis Moodle & SCORM',
            'slug' => 'arsitektur-pembelajaran-digital-mentransformasi-materi-mentah-menjadi-modul-interaktif-berbasis-moodle-scorm',
            'excerpt' => 'Panduan lengkap tentang bagaimana mengubah materi pembelajaran mentah menjadi modul interaktif menggunakan standar SCORM dan platform LMS Moodle untuk pengalaman belajar yang hidup, terukur, dan menyenangkan.',
            'content' => '
<p>Dalam dunia pendidikan digital modern, sekadar mengunggah file PDF atau PowerPoint ke internet bukanlah e-learning yang sesungguhnya. Itu hanyalah &ldquo;perpustakaan digital statis&rdquo;. Tantangan terbesar bagi institusi pendidikan saat ini adalah bagaimana mengubah tumpukan data menjadi sebuah pengalaman belajar yang hidup, terukur, dan menyenangkan.</p>

<h2>1. Titik Awal: Menghidupkan Materi &ldquo;Mati&rdquo;</h2>

<p>Proyek pengembangan konten pembelajaran digital yang spesifik ini dimulai dengan materi mentah. Klien umumnya memiliki aset berupa dokumen teks (Word/PDF), slide presentasi (PowerPoint), atau rekaman video yang belum terstruktur.</p>

<p>Tugas utama seorang E-Learning Developer adalah memecah kebuntuan materi tersebut melalui:</p>

<ul>
    <li><strong>Instructional Design:</strong> Memecah materi besar menjadi unit-unit kecil (<em>micro-learning</em>) agar lebih mudah diserap.</li>
    <li><strong>Interaktivitas Aktif:</strong> Mengganti metode membaca pasif dengan aksi nyata, seperti fitur <em>drag-and-drop</em>, simulasi skenario, dan kuis interaktif yang memberikan umpan balik instan.</li>
    <li><strong>User Experience (UX):</strong> Memastikan navigasi materi terasa intuitif&mdash;seperti mengoperasikan aplikasi modern, bukan sekadar membalik halaman buku digital.</li>
</ul>

<h2>2. SCORM: Jembatan Teknologi dan Data</h2>

<p>Agar materi interaktif tersebut bisa &ldquo;berkomunikasi&rdquo; dengan sistem, ia harus dikemas dalam format standar bernama <strong>SCORM</strong> (Sharable Content Object Reference Model).</p>

<p>Tanpa SCORM, pengelola kursus tidak akan memiliki data. Dengan SCORM, modul Anda menjadi &ldquo;pintar&rdquo; karena mampu mengirimkan informasi krusial ke sistem, seperti:</p>

<ul>
    <li>Apakah siswa sudah menyelesaikan seluruh slide?</li>
    <li>Berapa nilai kuis yang mereka dapatkan secara otomatis?</li>
    <li>Di titik mana siswa berhenti belajar sehingga mereka bisa melanjutkan kembali nanti (<em>bookmarking</em>).</li>
</ul>

<h2>3. Moodle: &ldquo;Rumah&rdquo; bagi Modul Interaktif</h2>

<p>Jika modul SCORM adalah &ldquo;film&rdquo;-nya, maka Moodle adalah &ldquo;bioskop&rdquo; atau platform pemutarnya. <strong>Moodle</strong> (Modular Object-Oriented Dynamic Learning Environment) adalah platform LMS (Learning Management System) paling populer di dunia karena sifatnya yang <em>open-source</em> dan fleksibel.</p>

<p>Moodle bertindak sebagai pusat kendali di mana:</p>

<ul>
    <li><strong>Manajemen Pengguna:</strong> Pengajar bisa mengelola ribuan siswa, membagi mereka ke dalam kelas, dan memantau progres masing-masing.</li>
    <li><strong>Ekosistem Terintegrasi:</strong> Moodle menyediakan wadah yang stabil untuk menjalankan modul SCORM Anda, memastikan nilai yang didapat siswa langsung masuk ke dalam buku nilai (<em>gradebook</em>) sistem.</li>
    <li><strong>Aksesibilitas:</strong> Melalui Moodle, modul yang Anda buat bisa diakses kapan saja dan di mana saja, baik melalui laptop maupun aplikasi mobile.</li>
</ul>

<h2>4. Sinergi dalam Ekosistem Belajar Digital</h2>

<p>Keberhasilan sebuah proyek e-learning bergantung pada sinergi antara konten yang menarik (Modul SCORM) dan wadah yang tangguh (Moodle). Di tahun 2026, peran ini menjadi semakin krusial karena perhatian manusia menjadi komoditas yang mahal.</p>

<p>Melalui perpaduan desain instruksional yang tepat dan teknologi LMS yang mapan, tingkat pemahaman peserta didik terbukti meningkat hingga 60% dibandingkan metode belajar pasif. Anda bukan sekadar &ldquo;pemindah data&rdquo;, melainkan seorang arsitek pengalaman belajar yang memastikan transformasi digital di bidang pendidikan berjalan dengan efektif.</p>
',
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(50, 200),
        ]);

        $this->command->info('Moodle & SCORM E-Learning Article created successfully!');
    }
}
