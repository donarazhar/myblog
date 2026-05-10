<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class InstalasiVhdVirtualboxArticleSeeder extends Seeder
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

        // Create Instalasi VHD VirtualBox article
        Article::create([
            'title' => 'Panduan Teknis: Instalasi VHD TKA 2026 & Optimalisasi VirtualBox (SD, SMP, & SMA)',
            'slug' => 'panduan-teknis-instalasi-vhd-tka-2026-optimalisasi-virtualbox-sd-smp-sma',
            'excerpt' => 'Moda Semi Daring tetap menjadi pilihan utama bagi sekolah yang mengutamakan stabilitas pengerjaan siswa. Kunci utama dari moda ini terletak pada VirtualBox. Berikut adalah langkah demi langkah instalasi dan konfigurasi yang benar untuk proktor di semua jenjang.',
            'content' => '
<p>Mengingat Anda sedang mempersiapkan <strong>Simulasi OSNK SMA</strong> dan berbagai kebutuhan teknis di sekolah, pemahaman mengenai konfigurasi VirtualBox untuk VHD adalah keterampilan &ldquo;wajib&rdquo; bagi proktor.</p>

<p>Berikut adalah artikel teknis yang disusun secara sistematis, komprehensif, dan mudah dipahami berdasarkan alur kerja terbaru untuk <strong>Panduan Install VHD TKA 2026</strong>.</p>

<p>Moda <strong>Semi Daring</strong> tetap menjadi pilihan utama bagi sekolah yang mengutamakan stabilitas pengerjaan siswa. Kunci utama dari moda ini terletak pada <strong>VirtualBox</strong>. Jika pengaturan VirtualBox salah, maka server tidak akan bisa sinkron atau komputer klien tidak akan terhubung.</p>

<p>Berikut adalah langkah demi langkah instalasi dan konfigurasi yang benar:</p>

<h2>1. Persiapan File &amp; Lingkungan Kerja</h2>

<p>Sebelum membuka aplikasi, pastikan tiga hal ini sudah siap:</p>

<ul>
    <li><strong>File VHD Fresh:</strong> Pastikan file VHD TKA 2026 sudah diunduh sempurna dan <strong>diekstrak</strong> dari format ZIP/RAR. Jangan menjalankan VHD di dalam folder kompresi.</li>
    <li><strong>Oracle VM VirtualBox:</strong> Gunakan versi yang stabil (disarankan versi 6.1.x atau 7.0.x sesuai instruksi pusat).</li>
    <li><strong>Ruang Penyimpanan:</strong> Pastikan Drive (disarankan SSD) tempat menyimpan VHD memiliki sisa ruang minimal 50GB.</li>
</ul>

<h2>2. Membuat Mesin Virtual (Virtual Machine)</h2>

<ol>
    <li>Buka VirtualBox, klik tombol <strong>&ldquo;New&rdquo;</strong> (Baru).</li>
    <li><strong>Nama:</strong> Isi dengan nama yang jelas (Contoh: <code>TKA_2026_SIMULASI</code>).</li>
    <li><strong>Type &amp; Version:</strong> Pilih <strong>Microsoft Windows</strong> dan versinya adalah <strong>Windows 2012 (64-bit)</strong>. Ini adalah standar sistem operasi di dalam VHD.</li>
    <li><strong>Memory (RAM):</strong> Geser ke angka minimal <strong>8 GB (8192 MB)</strong>. Pastikan indikator tetap di area warna hijau.</li>
    <li><strong>Hard Disk:</strong> Pilih opsi terakhir: <strong>&ldquo;Use an existing virtual hard disk file&rdquo;</strong>. Klik ikon folder, lalu <strong>Add</strong> (Tambah), dan cari file VHD yang sudah Anda ekstrak tadi. Klik <strong>Create</strong>.</li>
</ol>

<h2>3. Pengaturan (Setting) Vital pada VirtualBox</h2>

<p>Setelah mesin dibuat, jangan langsung dijalankan. Anda harus melakukan konfigurasi tambahan:</p>

<h3>A. Sistem (System)</h3>

<ul>
    <li>Pada tab <strong>Processor</strong>, berikan minimal <strong>2 atau 4 Core</strong>.</li>
    <li>Pastikan fitur <strong>Acceleration (VT-x/AMD-V)</strong> sudah aktif (jika tidak aktif, Anda harus mengaktifkannya di BIOS komputer).</li>
</ul>

<h3>B. Jaringan (Network) &mdash; Bagian Paling Krusial</h3>

<p>Dua adapter harus diseting dengan benar agar data bisa mengalir:</p>

<table>
    <thead>
        <tr>
            <th>Adapter</th>
            <th>Attached to</th>
            <th>Name / Fungsi</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>Adapter 1</strong> (Jalur ke Siswa)</td>
            <td><strong>Bridged Adapter</strong></td>
            <td>Pilih kartu jaringan (LAN Card) yang terhubung ke <strong>Hub/Switch lokal</strong> di laboratorium.</td>
        </tr>
        <tr>
            <td><strong>Adapter 2</strong> (Jalur ke Pusat)</td>
            <td><strong>NAT</strong></td>
            <td>Agar VHD bisa mendapatkan akses internet untuk sinkronisasi soal.</td>
        </tr>
    </tbody>
</table>

<h2>4. Konfigurasi IP Address (Sisi Host)</h2>

<p>Agar server lokal bisa berkomunikasi dengan klien, Anda harus mengatur IP pada LAN Card yang terhubung ke siswa (Adapter 1):</p>

<ul>
    <li>Buka <em>Network Connections</em> di Windows.</li>
    <li>Pilih LAN Card lokal, klik <em>Properties</em> &rarr; <em>IPv4</em>.</li>
    <li>Atur IP Statis: <strong>192.168.0.200</strong> (Jangan gunakan .199 karena itu IP default VHD).</li>
    <li>Subnet Mask: <strong>255.255.255.0</strong>.</li>
</ul>

<h2>5. Menjalankan Admin VHD (Exambrowser Admin)</h2>

<ol>
    <li>Buka aplikasi <strong>Exambrowser Admin 2026</strong>.</li>
    <li>Klik <strong>Set Virtual Machine</strong>, pilih nama mesin yang tadi Anda buat (<code>TKA_2026_SIMULASI</code>).</li>
    <li>Klik <strong>Start Virtual Machine</strong>.</li>
    <li>Tunggu hingga layar virtual berwarna biru/hitam menunjukkan proses booting selesai.</li>
    <li>Jika berhasil, status akan berubah menjadi <strong>Standby</strong> dan tombol <strong>&ldquo;Buka CBT Sync&rdquo;</strong> akan muncul.</li>
</ol>

<h2>6. Tips Perawatan &amp; Keamanan</h2>

<ul>
    <li><strong>Jangan Mematikan Paksa:</strong> Selalu matikan VHD melalui tombol &ldquo;Shutdown&rdquo; di dalam CBT Sync atau Exambrowser Admin. Mematikan paksa bisa merusak (<em>corrupt</em>) file VHD.</li>
    <li><strong>Backup berkala:</strong> Setelah sinkronisasi 100%, matikan mesin, lalu <em>copy-paste</em> file VHD tersebut ke hardisk eksternal. Ini adalah tindakan pencegahan terbaik jika server tiba-tiba bermasalah.</li>
    <li><strong>Nonaktifkan Update:</strong> Pastikan Windows Update dan Antivirus pada komputer Host dimatikan sementara agar tidak memakan sumber daya RAM saat ujian.</li>
</ul>

<h2>Kesimpulan</h2>

<p>Proses instalasi VHD memang terlihat teknis, namun dengan mengikuti urutan <strong>Setting Jaringan (Bridged &amp; NAT)</strong> dan <strong>Alokasi RAM</strong> yang tepat, hambatan teknis saat simulasi OSNK atau TKA dapat diminimalisir.</p>

<p>Sebagai proktor, pastikan Anda melakukan <em>trial and error</em> saat masa simulasi agar pada hari pengerjaan sesungguhnya, semua infrastruktur sudah dalam kondisi prima.</p>

<h2>Video Referensi</h2>

<iframe src="https://www.youtube.com/embed/236X3g9ZgBU" title="Panduan Install VHD TKA 2026 & Optimalisasi VirtualBox" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>

<p><em>Sumber: Video tutorial dari YouTube mengenai instalasi VHD TKA 2026 dan optimalisasi VirtualBox untuk semua jenjang.</em></p>
',
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(50, 200),
        ]);

        $this->command->info('Instalasi VHD VirtualBox Article created successfully!');
    }
}
