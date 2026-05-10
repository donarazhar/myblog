<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class AsesmenUjianSiswaArticleSeeder extends Seeder
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

        // Create Asesmen Ujian Siswa article
        Article::create([
            'title' => 'Panduan Lengkap: Mengenal Jenis Asesmen dan Ujian Siswa di Indonesia',
            'slug' => 'panduan-lengkap-mengenal-jenis-asesmen-ujian-siswa-indonesia',
            'excerpt' => 'Dalam sistem pendidikan Indonesia saat ini, istilah "Ujian Nasional" telah bergeser menjadi berbagai bentuk Asesmen dan Penilaian yang lebih spesifik. Berikut adalah panduan lengkap mengenai berbagai jenis ujian dan asesmen yang berlaku di jenjang SD, SMP, dan SMA/SMK.',
            'content' => '
<p>Dalam sistem pendidikan Indonesia saat ini, istilah &ldquo;Ujian Nasional&rdquo; telah bergeser menjadi berbagai bentuk <strong>Asesmen</strong> dan <strong>Penilaian</strong> yang lebih spesifik. Bagi pengelola pendidikan, proktor, maupun orang tua, memahami peta asesmen ini sangat penting untuk mendukung kesuksesan siswa.</p>

<p>Berikut adalah panduan lengkap mengenai berbagai jenis ujian dan asesmen yang berlaku di jenjang SD, SMP, dan SMA/SMK di luar ANBK dan OSNK.</p>

<p>Seiring dengan implementasi <strong>Kurikulum Merdeka</strong>, evaluasi pendidikan kini dibagi menjadi beberapa kategori utama: penilaian internal sekolah, seleksi masuk jenjang lebih tinggi, hingga ajang pengembangan bakat.</p>

<h2>1. Asesmen Internal Satuan Pendidikan (Intra-Kurikuler)</h2>

<p>Ini adalah penilaian yang dikelola langsung oleh sekolah untuk mengukur pencapaian kurikulum pada setiap siswa.</p>

<ul>
    <li><strong>ASASP / PSAJ (Asesmen Sumatif Akhir Satuan Pendidikan):</strong> Dulu dikenal sebagai Ujian Sekolah (US). Ini adalah ujian akhir bagi siswa di tingkat akhir (Kelas 6, 9, dan 12). Hasilnya menjadi salah satu pertimbangan utama kelulusan siswa dari sekolah.</li>
    <li><strong>SAS (Sumatif Akhir Semester):</strong> Menggantikan istilah PAS (Penilaian Akhir Semester). Dilakukan di akhir semester ganjil dan genap untuk mengukur kompetensi selama satu semester.</li>
    <li><strong>STS (Sumatif Tengah Semester):</strong> Dulu disebut PTS atau UTS. Dilakukan di tengah semester untuk memantau kemajuan belajar siswa secara berkala.</li>
    <li><strong>Asesmen Madrasah (AM):</strong> Khusus untuk sekolah di bawah naungan Kementerian Agama (MI, MTs, MA). Fungsinya sama dengan ASASP, yakni sebagai syarat kelulusan dari madrasah.</li>
</ul>

<h2>2. Seleksi Masuk Perguruan Tinggi (Khusus SMA/SMK)</h2>

<p>Bagi siswa kelas 12, fokus utama bergeser ke ujian seleksi nasional untuk memperebutkan kursi di Perguruan Tinggi Negeri (PTN).</p>

<ul>
    <li><strong>SNBT (Seleksi Nasional Berdasarkan Tes):</strong> Ujian masuk PTN yang menggunakan tes <strong>UTBK (Ujian Tulis Berbasis Komputer)</strong>. Fokus tesnya adalah potensi kognitif, penalaran matematika, serta literasi Bahasa Indonesia dan Inggris.</li>
    <li><strong>SNBP (Seleksi Nasional Berdasarkan Prestasi):</strong> Seleksi tanpa tes yang didasarkan pada nilai rapor dan prestasi akademik/non-akademik selama masa sekolah.</li>
    <li><strong>UM (Ujian Mandiri):</strong> Ujian seleksi yang diadakan secara independen oleh masing-masing universitas.</li>
</ul>

<h2>3. Asesmen Regional Khusus (Studi Kasus: ASPD)</h2>

<p>Beberapa daerah memiliki instrumen pemetaan kualitas pendidikan tambahan yang diakui secara lokal.</p>

<ul>
    <li><strong>ASPD (Asesmen Standardisasi Pendidikan Daerah):</strong> Saat ini diterapkan secara intensif di wilayah <strong>D.I. Yogyakarta</strong>. Meski bukan syarat kelulusan nasional, nilai ASPD menjadi instrumen krusial dalam seleksi PPDB (Penerimaan Peserta Didik Baru) untuk masuk ke SMP atau SMA Negeri favorit di wilayah tersebut.</li>
</ul>

<h2>4. Ajang Talenta dan Kompetisi Nasional</h2>

<p>Selain OSNK yang fokus pada sains, pemerintah melalui Balai Pengembangan Talenta Indonesia (BPTI) menyelenggarakan ajang tahunan lainnya:</p>

<ul>
    <li><strong>O2SN (Olimpiade Olahraga Siswa Nasional):</strong> Wadah bagi siswa yang berprestasi di bidang olahraga seperti karate, renang, atletik, dan bulutangkis.</li>
    <li><strong>FLS2N (Festival dan Lomba Seni Siswa Nasional):</strong> Kompetisi bergengsi di bidang seni, mulai dari menyanyi solo, tari kreasi, poster, hingga kriya.</li>
    <li><strong>LKS (Lomba Kompetensi Siswa):</strong> Khusus untuk siswa <strong>SMK</strong>. Ini adalah ajang bergengsi untuk menunjukkan keahlian teknis sesuai kejuruan (misal: IT Network, Graphic Design, atau Welding).</li>
    <li><strong>GSI (Gala Siswa Indonesia):</strong> Kompetisi khusus sepak bola untuk jenjang SMP guna menjaring bakat muda atlet nasional.</li>
</ul>

<h2>Tabel Ringkasan Asesmen &amp; Ujian</h2>

<table>
    <thead>
        <tr>
            <th>Kategori</th>
            <th>Nama Instrumen</th>
            <th>Target Peserta</th>
            <th>Tujuan Utama</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>Kelulusan</strong></td>
            <td>ASASP / PSAJ</td>
            <td>SD, SMP, SMA (Tingkat Akhir)</td>
            <td>Penentu Kelulusan Sekolah</td>
        </tr>
        <tr>
            <td><strong>Harian/Semester</strong></td>
            <td>SAS / STS</td>
            <td>Semua Jenjang</td>
            <td>Evaluasi Belajar Berkala</td>
        </tr>
        <tr>
            <td><strong>Masuk PTN</strong></td>
            <td>UTBK-SNBT</td>
            <td>SMA / SMK Kelas 12</td>
            <td>Seleksi Masuk Universitas</td>
        </tr>
        <tr>
            <td><strong>Keahlian</strong></td>
            <td>LKS</td>
            <td>SMK</td>
            <td>Uji Kompetensi Kejuruan</td>
        </tr>
        <tr>
            <td><strong>Bakat/Minat</strong></td>
            <td>O2SN / FLS2N</td>
            <td>SD, SMP, SMA</td>
            <td>Pengembangan Potensi Non-Akademik</td>
        </tr>
        <tr>
            <td><strong>Religius</strong></td>
            <td>Asesmen Madrasah</td>
            <td>MI, MTs, MA</td>
            <td>Kelulusan Madrasah (Kemenag)</td>
        </tr>
    </tbody>
</table>

<h2>Kesimpulan</h2>

<p>Perubahan istilah dari &ldquo;Ujian&rdquo; menjadi &ldquo;Asesmen&rdquo; mencerminkan semangat pendidikan yang lebih manusiawi, di mana evaluasi tidak hanya dilihat dari satu angka mutlak, melainkan dari berbagai pintu (akademik, karakter, dan bakat).</p>

<p>Bagi Bapak/Ibu yang bertugas sebagai proktor atau pengelola data di yayasan/sekolah, memahami kalender kegiatan ini adalah kunci agar persiapan infrastruktur (server, jaringan, dan perangkat) bisa dilakukan jauh-jauh hari sebelum pelaksanaan.</p>
',
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(50, 200),
        ]);

        $this->command->info('Asesmen Ujian Siswa Article created successfully!');
    }
}
