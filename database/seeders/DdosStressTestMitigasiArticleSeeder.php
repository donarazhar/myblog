<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class DdosStressTestMitigasiArticleSeeder extends Seeder
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

        // Create DDoS Stress Test & Mitigasi article
        Article::create([
            'title' => 'Panduan Komprehensif Arsitektur Keamanan: Simulasi Stress Test dan Strategi Mitigasi DDoS',
            'slug' => 'panduan-komprehensif-arsitektur-keamanan-simulasi-stress-test-dan-strategi-mitigasi-ddos',
            'excerpt' => 'Panduan lengkap membangun arsitektur keamanan siber dengan tiga pilar utama: Offensive (Pengujian), Defensive (Perlindungan), dan Implementasi Teknis untuk simulasi stress test dan mitigasi serangan DDoS.',
            'content' => '
<p>Keamanan siber bukan tentang membangun tembok yang tidak bisa ditembus, melainkan membangun sistem yang mampu bertahan, mendeteksi, dan pulih dengan cepat saat diserang. Proyek yang Anda temukan di <em>projects.co.id</em> adalah studi kasus nyata tentang keseimbangan ini.</p>

<p>Kita akan membaginya menjadi tiga pilar utama: <strong>Offensive (Pengujian)</strong>, <strong>Defensive (Perlindungan)</strong>, dan <strong>Implementasi Teknis</strong>.</p>

<h2>1. Memahami Spektrum Serangan (OSI Model Perspective)</h2>

<p>Sebelum membuat <em>tool</em>, Anda harus tahu di lapisan mana Anda &ldquo;bermain&rdquo;. Serangan DDoS biasanya terjadi pada dua lapisan utama:</p>

<table>
    <thead>
        <tr>
            <th>Lapisan OSI</th>
            <th>Nama</th>
            <th>Jenis Serangan Umum</th>
            <th>Fokus Pengujian</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>Layer 4</strong></td>
            <td>Transport</td>
            <td>SYN Flood, UDP Flood</td>
            <td>Menguji ketahanan <em>bandwidth</em> dan kapasitas <em>socket</em> server.</td>
        </tr>
        <tr>
            <td><strong>Layer 7</strong></td>
            <td>Application</td>
            <td>HTTP/S Flood, Slowloris</td>
            <td>Menguji efisiensi kode aplikasi, database, dan pemrosesan web server.</td>
        </tr>
    </tbody>
</table>

<h2>2. Modul Offensive: Membangun Stress Tester Terarah</h2>

<p>Klien meminta fitur khusus: <strong>IP tidak random global, tapi sesuai negara target.</strong> Ini adalah teknik tingkat lanjut untuk melewati sistem keamanan yang menggunakan <em>Geo-Blocking</em>.</p>

<h3>A. Mekanisme Geo-Location Filtering</h3>

<p>Untuk mencapai ini, <em>script</em> Anda memerlukan integrasi dengan database atau API pihak ketiga:</p>

<ol>
    <li><strong>Proxy/VPN Pool:</strong> Anda membutuhkan daftar IP (Proxy) yang dikategorikan berdasarkan negara.</li>
    <li><strong>Logic Filter:</strong> Script akan memuat daftar IP tersebut, lalu memfilter hanya IP dengan kode negara tertentu (misal: ID untuk Indonesia).</li>
    <li><strong>Rotation Logic:</strong> Gunakan algoritma <em>Round Robin</em> agar setiap permintaan menggunakan IP yang berbeda dari <em>pool</em> negara yang sama untuk menghindari deteksi cepat oleh <em>Rate Limiter</em>.</li>
</ol>

<h3>B. Payload Strategy (Efektivitas vs Volume)</h3>

<p>Jangan hanya mengirim trafik sampah. <em>Stress test</em> yang baik mensimulasikan perilaku manusia:</p>

<ul>
    <li><strong>Random User-Agent:</strong> Berganti-ganti antara Chrome, Safari, dan Firefox.</li>
    <li><strong>Referrer Spoofing:</strong> Membuat trafik seolah-olah datang dari Google atau Media Sosial.</li>
    <li><strong>Post/Get Dynamics:</strong> Melakukan simulasi pencarian atau pengisian formulir yang memicu query database berat.</li>
</ul>

<h2>3. Modul Defensive: Membangun Sistem &ldquo;Tahan Banting&rdquo;</h2>

<p>Istilah &ldquo;Tahan Banting&rdquo; dalam dunia IT berarti <strong>Resilience</strong>. Berikut adalah lapisan proteksi yang harus Anda jelaskan dalam tutorial:</p>

<h3>A. Mitigasi di Sisi Infrastruktur</h3>

<ul>
    <li><strong>Anycast Network:</strong> Teknik routing yang menyebarkan trafik ke banyak server secara global. Jika satu server di Jakarta diserang, trafik bisa dialihkan ke server di Singapura tanpa mematikan layanan.</li>
    <li><strong>Auto-Scaling:</strong> Menggunakan Cloud (AWS/GCP/Azure) yang secara otomatis menambah jumlah server (instance) saat penggunaan CPU mencapai titik tertentu.</li>
</ul>

<h3>B. Mitigasi di Sisi Aplikasi (Software-Based)</h3>

<ul>
    <li><strong>Web Application Firewall (WAF):</strong> Bertindak sebagai filter antara internet dan web server. WAF dapat mendeteksi pola serangan Layer 7 dan memblokirnya secara instan.</li>
    <li><strong>Advanced Rate Limiting:</strong> Bukan hanya membatasi IP, tapi membatasi berdasarkan <em>session</em> atau <em>behavior</em>. Jika satu IP melakukan 100 klik dalam 1 detik, sistem otomatis memblokirnya.</li>
    <li><strong>Unreachable Origin:</strong> Menyembunyikan IP asli server di balik layanan seperti Cloudflare, sehingga penyerang hanya bisa menyerang &ldquo;pagar depan&rdquo;, bukan server intinya.</li>
</ul>

<h2>4. Implementasi Teknis: Workflow &amp; Fitur</h2>

<p>Untuk membuat <em>tools</em> ini berfungsi dengan baik, berikut adalah arsitektur yang disarankan:</p>

<h3>Fitur Utama Script</h3>

<ol>
    <li><strong>Modular Engine:</strong> Pisahkan antara kode pengirim trafik (Attack Module) dan kode analisis respons (Analysis Module).</li>
    <li><strong>Real-time Dashboard:</strong> Gunakan library seperti <code>Rich</code> (Python) atau <code>Terminal-Dashboard</code> untuk melihat kecepatan trafik dan status respons server (200 OK vs 503 Service Unavailable).</li>
    <li><strong>Geo-IP Database:</strong> Integrasikan database lokal seperti <code>GeoLite2</code> agar filter negara tidak bergantung pada API eksternal yang lambat.</li>
</ol>

<h3>Workflow Tutorial untuk Klien</h3>

<ol>
    <li><strong>Preparation:</strong> Cara instalasi dependensi (misal: <code>pip install -r requirements.txt</code>).</li>
    <li><strong>Configuration:</strong> Cara memasukkan API Key Proxy dan memilih target negara.</li>
    <li><strong>Execution:</strong> Menjalankan tes dengan parameter durasi dan jumlah <em>thread</em>.</li>
    <li><strong>Fixing:</strong> Panduan memasang konfigurasi Nginx &ldquo;Tahan Banting&rdquo; (seperti pengaturan <code>limit_req_zone</code>).</li>
</ol>

<h2>5. Sudut Pandang Legal &amp; Etika (Penting!)</h2>

<p>Sebagai seorang profesional IT, Anda harus menyertakan <em>Disclaimer</em> hukum dalam setiap <em>tool</em> keamanan:</p>

<ul>
    <li><strong>Izin Tertulis:</strong> Jangan pernah menjalankan <em>stress test</em> pada sistem yang bukan milik Anda atau tanpa izin tertulis.</li>
    <li><strong>Tujuan Edukasi:</strong> Pastikan <em>tool</em> ini ditujukan untuk memperkuat pertahanan, bukan untuk mengganggu layanan publik.</li>
</ul>

<blockquote>
    <p><strong>Tips Belajar:</strong> Cobalah membuat skrip Python sederhana menggunakan library <code>requests</code> dan <code>threading</code> untuk melakukan 10 permintaan per detik ke server lokal Anda (localhost). Lihat bagaimana log server (Apache/Nginx) mencatat aktivitas tersebut.</p>
</blockquote>
',
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(50, 200),
        ]);

        $this->command->info('DDoS Stress Test & Mitigasi Article created successfully!');
    }
}
