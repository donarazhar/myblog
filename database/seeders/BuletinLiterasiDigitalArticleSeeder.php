<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class BuletinLiterasiDigitalArticleSeeder extends Seeder
{
    public function run(): void
    {
        // Get admin user
        $admin = User::where('is_admin', true)->first();

        if (!$admin) {
            $this->command->warn('No admin user found. Please run DatabaseSeeder first.');
            return;
        }

        // Get or create category for Teknologi
        $category = Category::firstOrCreate(
            ['name' => 'Teknologi'],
            ['description' => 'Artikel tentang perkembangan teknologi']
        );

        // Create Buletin Literasi Digital article
        Article::create([
            'title' => 'Buletin Literasi Digital: Menjadi Cerdas, Aman, dan Terlindungi di Dunia Maya',
            'slug' => 'buletin-literasi-digital-cerdas-aman-terlindungi',
            'excerpt' => 'Panduan lengkap literasi digital dari Tim IT YPI Al Azhar berdasarkan tiga pilar utama: Literasi Informasi (Framing), Perlindungan Hukum (Data Pribadi), dan Solusi Teknis (Keamanan Google).',
            'content' => '
<p>Di era digital yang serba cepat ini, ancaman tidak hanya datang dari virus komputer, tetapi juga dari cara kita mengonsumsi informasi dan menjaga privasi. Tim IT YPI Al Azhar (<em>We Are Connected</em>) mempersembahkan panduan lengkap berdasarkan tiga pilar utama: <strong>Literasi Informasi</strong> (<em>Framing</em>), <strong>Perlindungan Hukum</strong> (<em>Data Pribadi</em>), dan <strong>Solusi Teknis</strong> (<em>Keamanan Google</em>).</p>

<h2>BAGIAN 1: LITERASI INFORMASI</h2>

<h3>Mengungkap Jebakan "Framing": Saat Fakta yang Sama Memiliki Wajah Berbeda</h3>

<p>Selama ini kita sering diajarkan untuk waspada terhadap <em>Hoax</em> (berita bohong). Namun, ada bahaya yang lebih halus dan sering tidak disadari, yaitu <strong>Framing</strong>.</p>

<p><strong>Apa itu Framing?</strong></p>

<p><em>Framing</em> adalah kondisi di mana <strong>faktanya sama</strong>, namun disajikan dengan <strong>sudut pandang berbeda</strong>, dengan tujuan <strong>mengaduk emosi</strong> pembaca.</p>

<p>Ibarat melihat angka "6" dari bawah dan angka "9" dari atas. Bendanya sama, faktanya ada, tetapi persepsi yang timbul bisa bertolak belakang. Bahaya terbesar di era digital saat ini bukan hanya <em>Hoax</em> yang jelas-jelas palsu, melainkan <em>Framing</em> yang membuat kita merasa <strong>"Paling Tahu"</strong> padahal hanya melihat sebagian kecil dari realitas.</p>

<p><strong>Rumus "Cek Sebelum Share"</strong></p>

<p>Agar tidak terjebak menjadi penyebar kebencian, lakukan 3 langkah ini sebelum membagikan informasi:</p>

<ol>
    <li><strong>Fakta atau Opini?</strong> Bedakan mana kejadian nyata (objektif) dan mana tafsiran penulis (subjektif).</li>
    <li><strong>Status Hukum Jelas?</strong> Jangan menghakimi seseorang di media sosial sebelum ada putusan hukum atau rilis resmi.</li>
    <li><strong>Konteks Utuh atau Potongan?</strong> Waspadai video potongan atau <em>screenshot</em> chat yang tidak lengkap. Konteks yang hilang bisa mengubah makna 180 derajat.</li>
</ol>

<h2>BAGIAN 2: HUKUM & PRIVASI</h2>

<h3>Mengenal "Harta Karun" Digital Kita: Klasifikasi Data Pribadi menurut UU PDP</h3>

<p>Sejak disahkannya <strong>UU No. 27 Tahun 2022 tentang Perlindungan Data Pribadi</strong>, data diri kita bukan lagi sekadar tulisan di atas kertas, melainkan aset yang dilindungi negara.</p>

<p>Namun, apakah semua data itu sama? Ternyata tidak. Undang-undang membagi data pribadi menjadi dua kategori penting yang wajib kita pahami:</p>

<h3>1. Data Pribadi Umum</h3>

<p>Ini adalah data dasar yang biasanya digunakan untuk mengenali identitas seseorang secara administratif. Data ini mencakup:</p>

<ul>
    <li>Nama Lengkap.</li>
    <li>Jenis Kelamin & Agama.</li>
    <li>Kewarganegaraan & Status Perkawinan.</li>
    <li>Data kombinasi (seperti No. Telepon atau Alamat IP) yang bisa mengidentifikasi seseorang.</li>
</ul>

<h3>2. Data Pribadi Spesifik (SENSITIF)</h3>

<p>Kategori ini jauh lebih berbahaya jika bocor karena berpotensi menimbulkan kerugian besar, diskriminasi, hingga kejahatan serius. Yang termasuk di dalamnya adalah:</p>

<ul>
    <li><strong>Data Kesehatan:</strong> Riwayat penyakit, rekam medis.</li>
    <li><strong>Data Biometrik & Genetika:</strong> Sidik jari, pemindaian wajah (<em>Face ID</em>).</li>
    <li><strong>Catatan Kejahatan.</strong></li>
    <li><strong>Data Anak:</strong> Sangat rentan dieksploitasi.</li>
    <li><strong>Data Keuangan Pribadi:</strong> Gaji, nomor rekening, limit kartu kredit.</li>
</ul>

<p><strong>Penting:</strong> Jaga data spesifik Anda sekuat tenaga. Jangan sembarangan memberikan akses foto wajah (biometrik) atau data keuangan ke aplikasi yang tidak terpercaya.</p>

<h2>BAGIAN 3: SOLUSI TEKNIS</h2>

<h3>Benteng Digital: 3 Fitur Keamanan Google yang Wajib Anda Aktifkan</h3>

<p>Setelah memahami bahaya informasi dan pentingnya privasi, bagaimana cara melindungi perangkat kita sehari-hari? Google menyediakan 3 alat keamanan gratis yang sering kita abaikan, padahal fungsinya sangat vital.</p>

<h3>1. Lindungi Ponsel: Google Play Protect</h3>

<p>Fitur ini bekerja otomatis memindai <em>malware</em> (virus) pada aplikasi, baik yang Anda unduh dari Play Store maupun sumber luar (APK). Jika ada aplikasi berbahaya, Play Protect akan memperingatkan atau memblokir instalasinya.</p>

<h3>2. Lindungi Browser: Google Safe Browsing</h3>

<p>Saat Anda berselancar di internet, fitur ini memberikan peringatan <em>real-time</em> jika Anda tidak sengaja mengakses situs <em>phishing</em> (penipuan) atau mengunduh file berbahaya. Ini menjamin navigasi web yang aman bagi miliaran perangkat setiap hari.</p>

<h3>3. Lindungi Akun: Google Account Security</h3>

<p>Lakukan "Audit Keamanan" melalui fitur ini untuk memantau perangkat mana saja yang sedang <em>login</em> ke akun Anda dan aplikasi pihak ketiga apa yang memiliki akses. Fitur ini juga memberikan saran keamanan yang dipersonalisasi.</p>

<h3>Tips Pro: Maksimalkan Keamanan</h3>

<p>Untuk perlindungan lapis baja, jangan lupa aktifkan:</p>

<ul>
    <li><strong>Verifikasi 2 Langkah (2FA):</strong> Kunci ganda untuk akun Anda.</li>
    <li><strong>Passkeys:</strong> Login aman tanpa kata sandi yang rumit.</li>
</ul>

<h2>Penutup</h2>

<p>Teknologi adalah alat yang memudahkan (<em>Taisir</em>), namun keamanan dan adab tetap menjadi tanggung jawab penggunanya. Mari menjadi keluarga besar Al Azhar yang cerdas memilah informasi dan bijak menjaga privasi.</p>

<p><em>We Are Connected - Tim IT YPI Al Azhar</em></p>
',
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(50, 200),
        ]);

        $this->command->info('Buletin Literasi Digital Article created successfully!');
    }
}
