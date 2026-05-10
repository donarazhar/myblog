<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class OsnkProktorArticleSeeder extends Seeder
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

        // Create OSNK Proktor article
        Article::create([
            'title' => 'Panduan Strategis Proktor: Bedah Tuntas Semi Daring vs. Daring Penuh untuk OSNK & ANBK',
            'slug' => 'panduan-strategis-proktor-semi-daring-vs-daring-penuh-osnk-anbk',
            'excerpt' => 'Menjelang pelaksanaan simulasi OSNK SMA, pertanyaan krusial bagi teknisi dan proktor adalah: pilih moda daring atau semi daring? Artikel ini membedah tuntas mekanisme teknis, kelebihan, kekurangan, serta panduan memilih moda yang tepat untuk sekolah Anda.',
            'content' => '
<p>Menjelang pelaksanaan simulasi <strong>OSNK (Olimpiade Sains Nasional Tingkat Kabupaten/Kota) SMA</strong>, pertanyaan krusial yang selalu muncul bagi rekan-rekan teknisi dan proktor adalah: <strong>&ldquo;Pilih moda daring atau semi daring?&rdquo;</strong>. Pilihan ini bukan sekadar preferensi, melainkan penentu kelancaran ujian siswa. Berikut adalah bedah tuntas untuk memastikan sekolah Anda tidak salah langkah.</p>

<h2>1. Moda Daring Penuh (The Cloud Direct Model)</h2>

<p>Sesuai namanya, moda ini mengandalkan koneksi internet secara penuh dan langsung. Perangkat siswa berkomunikasi tanpa perantara langsung ke server pusat di Kemendikbudristek.</p>

<h3>Mekanisme Teknis</h3>

<p>Cukup memastikan aplikasi <em>ExamBrowser Client</em> terpasang di perangkat siswa dan terhubung ke internet yang stabil.</p>

<h3>Kelebihan</h3>

<ul>
    <li>Sangat praktis &mdash; proktor tidak perlu melakukan instalasi <em>VirtualBox</em> atau melakukan proses sinkronisasi VHD yang memakan waktu berjam-jam.</li>
    <li>Persiapan proktor relatif ringan, cukup instal aplikasi klien saja.</li>
</ul>

<h3>Kekurangan</h3>

<ul>
    <li>Sangat bergantung pada <em>bandwidth</em>.</li>
    <li>Beban internet sekolah akan sangat berat jika banyak siswa ujian secara bersamaan.</li>
    <li>Jika internet mati meski hanya sedetik, siswa berisiko terlempar dari sistem (<em>logout</em>).</li>
</ul>

<h2>2. Moda Semi Daring (The Local Cache Model)</h2>

<p>Moda ini adalah pilihan favorit bagi sekolah yang ingin &ldquo;bermain aman&rdquo; terhadap fluktuasi internet. Sekolah menyediakan PC Server yang bertindak sebagai jembatan atau <em>cache</em>.</p>

<h3>Mekanisme Teknis</h3>

<p>Proktor mengunduh soal terlebih dahulu melalui proses sinkronisasi VHD. Saat ujian berlangsung, siswa hanya terhubung ke server lokal melalui jaringan LAN kabel tanpa membutuhkan koneksi internet aktif untuk mengerjakan soal.</p>

<h3>Kelebihan</h3>

<ul>
    <li>Stabilitas tinggi &mdash; jika kabel ISP terputus di tengah ujian, siswa tetap bisa lanjut mengerjakan soal.</li>
    <li>Internet hanya dibutuhkan di awal untuk rilis token dan di akhir untuk unggah hasil ujian.</li>
</ul>

<h3>Kekurangan</h3>

<ul>
    <li>Rumit secara teknis &mdash; proktor harus menguasai pengaturan VHD, <em>VirtualBox</em>, IP Statis, dan topologi jaringan LAN yang benar agar data tidak korup.</li>
</ul>

<h2>Perbandingan Infrastruktur &amp; Kebutuhan</h2>

<table>
    <thead>
        <tr>
            <th>Aspek</th>
            <th>Moda Daring Penuh</th>
            <th>Moda Semi Daring</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>Spesifikasi Server</strong></td>
            <td>Tidak butuh server spek tinggi.</td>
            <td><strong>Wajib</strong> Server (RAM min. 8GB + CPU mumpuni).</td>
        </tr>
        <tr>
            <td><strong>Koneksi Internet</strong></td>
            <td>Wajib stabil sepanjang waktu ujian.</td>
            <td>Hanya butuh saat sinkronisasi &amp; upload data.</td>
        </tr>
        <tr>
            <td><strong>Kebutuhan Bandwidth</strong></td>
            <td>Min. 12 Mbps per 15-20 klien (Dedicated).</td>
            <td>Relatif kecil (Hanya untuk rilis token).</td>
        </tr>
        <tr>
            <td><strong>Keamanan Data</strong></td>
            <td>Langsung terkirim ke server pusat.</td>
            <td>Tersimpan sementara di server lokal.</td>
        </tr>
        <tr>
            <td><strong>Persiapan Proktor</strong></td>
            <td>Ringan (Instal aplikasi klien saja).</td>
            <td>Berat (Sinkronisasi VHD &amp; Manajemen IP).</td>
        </tr>
    </tbody>
</table>

<h2>Panduan Memilih: Mana yang Cocok untuk Sekolah Anda?</h2>

<h3>Pilih Moda DARING jika:</h3>

<ul>
    <li>Sekolah memiliki internet <em>dedicated</em> (seperti Astinet) dengan kecepatan stabil minimal 12 Mbps untuk setiap 15-20 siswa.</li>
    <li>Anda tidak ingin disibukkan dengan urusan perawatan server lokal atau <em>maintenance</em> hardware server yang kompleks.</li>
</ul>

<h3>Pilih Moda SEMI DARING jika:</h3>

<ul>
    <li>Lokasi sekolah berada di area yang jaringan ISP-nya sering &ldquo;naik-turun&rdquo; atau labil.</li>
    <li>Sekolah memiliki tim teknis atau proktor yang sudah fasih melakukan instalasi server dan manajemen jaringan kabel.</li>
</ul>

<h2>Tips Sukses Simulasi OSNK</h2>

<p>Apapun moda yang Anda pilih, <strong>Simulasi adalah kunci</strong>. Pastikan untuk melakukan <em>stress-test</em> pada jaringan dan mengecek kembali seluruh pengkabelan di laboratorium komputer. Jika terjadi kendala pada sinkronisasi VHD atau pengaturan IP pada moda semi daring, segera lakukan koordinasi dengan tim teknis pusat atau diskusikan di forum proktor.</p>

<h2>Video Referensi</h2>

<iframe src="https://www.youtube.com/embed/MSCOTecJZB0" title="BEDANYA TKA SEMI DARING DAN DARING ? PILIH MANA" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>

<p><em>Sumber: Video &ldquo;BEDANYA TKA SEMI DARING DAN DARING ? PILIH MANA&rdquo; dari Channel <strong>Ilmu Komputer dan Pendidikan</strong> di YouTube.</em></p>
',
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(50, 200),
        ]);

        $this->command->info('OSNK Proktor Article created successfully!');
    }
}
