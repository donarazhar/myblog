<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class UmlApiDocsSowArticleSeeder extends Seeder
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

        // Create UML API Docs SOW article
        Article::create([
            'title' => 'Trisula Anti-Miskomunikasi: Mengapa UML, API Docs, dan SOW Menyelamatkan Proyek Anda',
            'slug' => 'trisula-anti-miskomunikasi-mengapa-uml-api-docs-dan-sow-menyelamatkan-proyek-anda',
            'excerpt' => 'Dalam SDLC, masalah terbesar jarang bersumber dari ketidakmampuan developer menulis kode. Masalah sesungguhnya berakar pada miskomunikasi. UML, API Documentation, dan SOW adalah trisula anti-miskomunikasi yang menyelamatkan proyek Anda.',
            'content' => '
<p>Dalam siklus pengembangan perangkat lunak (SDLC), masalah terbesar jarang bersumber dari ketidakmampuan <em>developer</em> dalam menulis kode. Masalah sesungguhnya berakar pada miskomunikasi: apa yang diminta oleh bisnis, apa yang dirancang oleh arsitek sistem, dan apa yang ditagihkan oleh vendor ternyata adalah tiga hal yang berbeda.</p>

<p>Untuk memastikan semua pihak berada di halaman yang sama, proyek skala menengah hingga besar mutlak membutuhkan <strong>UML, API Documentation,</strong> dan <strong>SOW</strong>.</p>

<h2>1. UML (Unified Modeling Language): Menyamakan Persepsi Visual Arsitektur</h2>

<p>Bahasa pemrograman itu kompleks dan tidak semua orang bisa (atau mau) membacanya. UML hadir sebagai &ldquo;bahasa visual universal&rdquo; yang menjembatani tim non-teknis dan teknis.</p>

<p>Alih-alih menjelaskan alur sistem melalui rapat yang panjang dan membingungkan, UML menggunakan standar diagram untuk memetakan bagaimana sistem akan bekerja sebelum kode ditulis.</p>

<p><strong>Bagaimana UML mencegah miskomunikasi?</strong></p>

<ul>
    <li><strong>Memvalidasi Alur Logika (Sequence &amp; Activity Diagram):</strong> UML memastikan tim perencanaan dan <em>developer</em> sepakat tentang urutan kejadian. Misalnya, &ldquo;Apakah notifikasi email dikirim <em>sebelum</em> atau <em>sesudah</em> pembayaran diverifikasi?&rdquo; Diagram ini menghilangkan asumsi tersebut.</li>
    <li><strong>Memperjelas Interaksi Pengguna (Use Case Diagram):</strong> Menggambarkan dengan jelas siapa saja aktor di dalam sistem (misal: Admin, User, Auditor) dan apa saja batas hak akses mereka, sehingga tidak ada fitur penting yang terlewat atau salah sasaran.</li>
</ul>

<h2>2. API Docs (API Documentation): &ldquo;Kontrak Teknis&rdquo; Antar Mesin dan Tim</h2>

<p>Aplikasi modern jarang berdiri sendiri; mereka saling bertukar data. Misalnya, aplikasi absensi internal harus &ldquo;berbicara&rdquo; dengan sistem penggajian. Komunikasi antar sistem ini dilakukan melalui API (<em>Application Programming Interface</em>).</p>

<p>API Documentation adalah buku manual yang menjelaskan secara presisi bagaimana cara sistem A boleh meminta data dari sistem B.</p>

<p><strong>Bagaimana API Docs mencegah miskomunikasi?</strong></p>

<ul>
    <li><strong>Mencegah Sikap Saling Lempar Kesalahan (<em>Finger-pointing</em>):</strong> Ketika integrasi dua sistem gagal, tim <em>frontend</em> dan <em>backend</em> (atau tim internal dan vendor) sering saling menyalahkan. API Docs yang baik&mdash;biasanya dibuat dengan standar Swagger atau Postman&mdash;menjadi wasit yang objektif. Jika data yang dikirim tidak sesuai dengan yang tertulis di dokumen API, maka jelas siapa yang harus memperbaiki kodenya.</li>
    <li><strong>Mempercepat Onboarding:</strong> <em>Developer</em> baru tidak perlu bertanya-tanya atau menebak format data apa yang harus mereka kirimkan. Semua parameter, status kode <em>error</em> (seperti 404 atau 500), dan batas akses sudah tertulis baku.</li>
</ul>

<h2>3. SOW (Statement of Work): Benteng Transparansi Ekspektasi dan Anggaran</h2>

<p>Jika UML mengatur desain dan API Docs mengatur kode, maka <strong>SOW mengatur manusia, waktu, dan uang</strong>. SOW adalah dokumen kesepakatan formal (seringkali mengikat secara hukum) antara pihak yang memberi pekerjaan (klien/perusahaan) dan pihak yang mengerjakan (vendor/tim pelaksana).</p>

<p>Sebagai tim perencana, menyusun SOW yang kedap air adalah langkah pertahanan pertama yang paling krusial.</p>

<p><strong>Bagaimana SOW mencegah miskomunikasi?</strong></p>

<ul>
    <li><strong>Menangkal <em>Scope Creep</em> (Pembengkakan Lingkup Kerja):</strong> Tanpa SOW, pemangku kepentingan bisa terus-menerus meminta &ldquo;tambahan fitur kecil&rdquo; di tengah jalan yang akhirnya menunda peluncuran proyek berbulan-bulan. SOW mendefinisikan dengan tegas apa yang <em>termasuk</em> (In-Scope) dan apa yang <em>tidak termasuk</em> (Out-of-Scope) dalam pengerjaan saat ini.</li>
    <li><strong>Mengunci Integritas Anggaran:</strong> SOW sangat vital untuk menjaga tata kelola finansial yang sehat. Dokumen ini menetapkan metrik pembayaran berdasarkan penyelesaian tugas nyata (<em>deliverables/milestones</em>). Hal ini menutup rapat celah bagi pihak-pihak yang mungkin mencoba memanipulasi alokasi dana, membebankan biaya siluman, atau menggeser anggaran secara tidak transparan antar unit kerja, karena setiap rupiah yang dikeluarkan harus berdasar pada rincian pekerjaan tertulis yang telah disepakati bersama di awal.</li>
    <li><strong>Menetapkan Kriteria Selesai (Definition of Done):</strong> SOW mencegah perdebatan subjektif tentang apakah sebuah proyek sudah selesai atau belum, karena kriteria pengujian dan serah terimanya sudah dikunci.</li>
</ul>

<h2>Kesimpulan</h2>

<p>Ketiga dokumen ini bertindak sebagai jaring pengaman proyek pada level yang berbeda:</p>

<ol>
    <li><strong>SOW</strong> memastikan ekspektasi bisnis, ruang lingkup, dan anggaran terkunci aman (Level Manajerial).</li>
    <li><strong>UML</strong> memastikan alur kerja dan arsitektur sistem dirancang dengan benar secara logika (Level Desain Sistem).</li>
    <li><strong>API Docs</strong> memastikan komponen teknis dapat berkomunikasi tanpa gangguan (Level Teknis/Kode).</li>
</ol>

<p>Mengabaikan salah satu dari ketiganya mungkin terasa menghemat waktu di awal proyek, namun hampir selalu dibayar mahal dengan kebingungan, perdebatan, dan kerugian finansial di akhir proyek.</p>
',
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(50, 200),
        ]);

        $this->command->info('UML API Docs SOW Article created successfully!');
    }
}
