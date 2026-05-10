<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class VhdTkaSemiDaringArticleSeeder extends Seeder
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

        // Create VHD TKA Semi Daring article
        Article::create([
            'title' => 'Tutorial Lengkap: Manajemen VHD TKA 2026 Semi Daring (Jenjang SD & SMP Sederajat)',
            'slug' => 'tutorial-lengkap-manajemen-vhd-tka-2026-semi-daring-sd-smp',
            'excerpt' => 'Kesuksesan pelaksanaan TKA Semi Daring sangat bergantung pada ketelitian Proktor dalam melakukan konfigurasi di sisi Server. Artikel ini menyajikan langkah-langkah strategis untuk melakukan setup VHD dari awal hingga siap digunakan untuk simulasi maupun hari pelaksanaan.',
            'content' => '
<p>Berdasarkan alur kerja teknis yang biasanya ada dalam tutorial persiapan <strong>VHD (Virtual Hard Disk)</strong> untuk pelaksanaan Semi Daring tahun 2026, berikut adalah artikel panduan teknis yang lengkap dan komprehensif.</p>

<p>Artikel ini disusun khusus untuk para Proktor dan Teknisi di jenjang SD/SMP yang sedang mempersiapkan simulasi maupun hari pelaksanaan.</p>

<p>Kesuksesan pelaksanaan TKA Semi Daring sangat bergantung pada ketelitian Proktor dalam melakukan konfigurasi di sisi Server. Berbeda dengan moda daring yang praktis, moda semi daring menuntut kesiapan <em>hardware</em> dan ketepatan instalasi <em>Virtual Machine</em>.</p>

<p>Berikut adalah langkah-langkah strategis untuk melakukan setup VHD dari awal hingga siap digunakan.</p>

<h2>1. Persiapan Infrastruktur Utama</h2>

<p>Sebelum menyentuh aplikasi, pastikan spesifikasi minimal terpenuhi agar tidak terjadi <em>lag</em> atau <em>hang</em> saat ujian berlangsung:</p>

<ul>
    <li><strong>Server:</strong> Minimal RAM 16GB (8GB dialokasikan untuk VM), Prosesor dengan minimal 4 Core.</li>
    <li><strong>Sistem Operasi Host:</strong> Windows 10/11 Pro atau Windows Server (64-bit).</li>
    <li><strong>Jaringan:</strong> Wajib menggunakan <strong>Dua LAN Card (NIC)</strong>. Satu untuk akses internet (ke pusat), satu lagi untuk distribusi ke klien (Local).</li>
    <li><strong>Software:</strong> Oracle VM VirtualBox (versi yang direkomendasikan biasanya versi 6.1 atau 7.0 sesuai petunjuk teknis terbaru).</li>
</ul>

<h2>2. Tahap Instalasi Virtual Machine (VM)</h2>

<ol>
    <li><strong>Ekstrak VHD:</strong> Pastikan Anda memiliki salinan VHD murni (Fresh). Simpan di drive yang memiliki ruang kosong besar (disarankan di SSD untuk kecepatan akses).</li>
    <li><strong>Membuat Mesin Baru:</strong> Buka VirtualBox, klik <em>New</em>. Beri nama sesuai jenjang (Contoh: <code>TKA_SD_2026</code>).</li>
    <li><strong>Alokasi RAM:</strong> Berikan minimal <strong>8GB (8192 MB)</strong>. Jangan melebihi garis hijau pada indikator VirtualBox agar sistem Host tidak <em>crash</em>.</li>
    <li><strong>Hard Disk:</strong> Pilih opsi <em>&ldquo;Use an existing virtual hard disk file&rdquo;</em> dan arahkan ke file VHD yang sudah diekstrak tadi.</li>
</ol>

<h2>3. Konfigurasi Jaringan (Crucial Step)</h2>

<p>Kesalahan paling umum terjadi pada tahap ini. Anda harus mengatur dua <em>Adapter</em> jaringan:</p>

<ul>
    <li><strong>Adapter 1:</strong> Atur ke <strong>&ldquo;Bridged Adapter&rdquo;</strong> dan arahkan ke LAN Card yang terhubung ke Hub/Switch siswa (Local). Pastikan kabel ke siswa sudah terpasang.</li>
    <li><strong>Adapter 2:</strong> Atur ke <strong>&ldquo;NAT&rdquo;</strong>. Ini berfungsi sebagai jalur bagi VHD untuk mengambil data (Sinkronisasi) dari server pusat melalui internet.</li>
</ul>

<h2>4. Langkah Menjalankan Admin VHD</h2>

<p>Setelah mesin virtual siap, langkah selanjutnya adalah menjalankan <strong>Exambrowser Admin</strong>:</p>

<ol>
    <li><strong>Set Virtual Machine:</strong> Jalankan aplikasi Exambrowser Admin, arahkan pengaturan mesin ke nama VM yang sudah dibuat di VirtualBox.</li>
    <li><strong>Start Virtual Machine:</strong> Klik tombol &ldquo;Start&rdquo;. Tunggu hingga proses <em>loading</em> sistem operasi di dalam VM selesai dan muncul tombol <strong>&ldquo;Buka CBT Sync&rdquo;</strong>.</li>
    <li><strong>ID Server &amp; Password:</strong> Masukkan ID Server dan Password yang didapatkan dari portal resmi TKA/ANBK. Pastikan status di dashboard menunjukkan <strong>&ldquo;AKTIF&rdquo;</strong>.</li>
</ol>

<h2>5. Proses Sinkronisasi (Data Staging)</h2>

<p>Proses ini dilakukan beberapa hari sebelum simulasi/ujian:</p>

<ul>
    <li>Cek menu <strong>Status Download</strong>.</li>
    <li>Klik tombol <strong>Refresh</strong> dan mulai proses <strong>Download Data</strong>.</li>
    <li><strong>Penting:</strong> Jangan menutup aplikasi atau mematikan internet selama proses sinkronisasi mencapai 100%. Setelah selesai, pastikan semua data telah terunduh dengan lengkap.</li>
</ul>

<h2>6. Checklist Keamanan &amp; Maintenance</h2>

<ul>
    <li><strong>Backup VHD:</strong> Setelah sinkronisasi berhasil 100%, <strong>matikan VM secara normal</strong> dan lakukan salinan (Copy) file VHD tersebut ke media penyimpanan eksternal. Ini adalah &ldquo;nyawa&rdquo; cadangan jika server utama mengalami kendala fisik.</li>
    <li><strong>Deep Freeze/Antivirus:</strong> Disarankan mematikan Antivirus dan fitur Windows Update selama masa ujian agar tidak mengganggu performa server.</li>
    <li><strong>IP Statis:</strong> Pastikan IP pada LAN Card lokal sudah diatur secara statis (biasanya segmen <code>192.168.0.xxx</code>) agar sinkron dengan komputer klien.</li>
</ul>

<h2>Kesimpulan untuk Proktor</h2>

<p>Manajemen VHD Semi Daring memang memerlukan ketelitian ekstra dibandingkan moda daring. Namun, keuntungan utamanya adalah ketenangan saat pengerjaan; Anda tidak perlu khawatir jika internet tiba-tiba mati di tengah ujian. Dengan persiapan VHD yang matang, simulasi TKA SD/SMP 2026 akan berjalan dengan lancar.</p>

<blockquote>
    <p><strong>Tips:</strong> Selalu periksa pengumuman di portal resmi terkait <em>patching</em> atau pembaruan versi VHD terbaru sebelum melakukan sinkronisasi!</p>
</blockquote>

<h2>Video Referensi</h2>

<iframe src="https://www.youtube.com/embed/XVzKC94Z0A0" title="Tutorial Manajemen VHD TKA 2026 Semi Daring" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>

<p><em>Sumber: Video tutorial dari YouTube mengenai persiapan VHD TKA Semi Daring untuk jenjang SD &amp; SMP Sederajat.</em></p>
',
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(50, 200),
        ]);

        $this->command->info('VHD TKA Semi Daring Article created successfully!');
    }
}
