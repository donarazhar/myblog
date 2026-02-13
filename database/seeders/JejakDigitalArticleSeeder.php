<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class JejakDigitalArticleSeeder extends Seeder
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

        // Create Jejak Digital article
        Article::create([
            'title' => 'Jejak Digital Sulit Dihapus: Kenapa Oversharing Bisa Menjadi Mimpi Buruk Seumur Hidup?',
            'slug' => 'jejak-digital-sulit-dihapus-kenapa-oversharing-bisa-menjadi-mimpi-buruk-seumur-hidup',
            'excerpt' => 'Internet tidak memiliki tombol "hapus" yang sesungguhnya. Sekali Anda menekan tombol post, informasi tersebut tersalin ke server, bisa di-screenshot orang lain, dan diarsipkan oleh mesin pencari. Pelajari bahaya oversharing dan cara melindungi jejak digital Anda.',
            'content' => '
<p>Pernahkah Anda mendengar pepatah, &ldquo;Mulutmu, harimau-mu&rdquo;? Di era digital, pepatah itu berubah menjadi <strong>&ldquo;Jari-jarimu, penentu masa depanmu.&rdquo;</strong></p>

<p>Internet tidak memiliki tombol &ldquo;hapus&rdquo; yang sesungguhnya. Sekali Anda menekan tombol <em>post</em>, informasi tersebut tersalin ke server, bisa di-<em>screenshot</em> orang lain, dan diarsipkan oleh mesin pencari. Inilah yang disebut <strong>Jejak Digital</strong>. Sayangnya, banyak dari kita yang terjebak dalam perilaku <em>oversharing</em>&mdash;terlalu banyak membagikan informasi pribadi demi eksistensi, tanpa menyadari bahaya yang mengintai di baliknya.</p>

<h2>⚠️ Awas, Apakah Anda Terjebak dalam Zona <em>Oversharing</em>?</h2>

<p>Seringkali kita tidak sadar bahwa kebiasaan &ldquo;sepele&rdquo; di media sosial sebenarnya adalah celah keamanan yang fatal. Coba cek, apakah Anda pernah melakukan hal-hal berikut?</p>

<ul>
    <li><strong>Posting Saat Emosi Memuncak:</strong> Entah itu marah pada atasan, galau putus cinta, atau menyindir teman. Ingat, emosi Anda mungkin reda dalam 2 jam, tapi postingan itu bisa merusak reputasi Anda selamanya.</li>
    <li><strong>Pamer Dokumen Pribadi:</strong> Memfoto tiket pesawat (yang ada <em>barcode</em>-nya), KTP, SIM, atau sertifikat vaksin demi konten.</li>
    <li><strong>Tag Lokasi <em>Real-Time</em>:</strong> &ldquo;Lagi ngopi sendirian nih di Cafe X!&rdquo; atau &ldquo;Akhirnya sampai rumah!&rdquo;.</li>
    <li><strong>Mengumbar Aib:</strong> Curhat masalah dapur rumah tangga atau keburukan kantor di ruang publik.</li>
</ul>

<p>Jika Anda pernah melakukan salah satunya, berhentilah sekarang. Kenapa? Karena dampaknya tidak main-main.</p>

<h2>🚨 Hati-hati, Ini 5 Bahaya Fatal yang Mengintai Anda!</h2>

<p>Dunia maya bukan tempat yang 100% aman. Informasi yang Anda sebar secara sukarela bisa menjadi senjata bagi orang jahat untuk menyerang Anda.</p>

<h3>1. Pencurian Identitas (<em>Identity Theft</em>) 🎭</h3>

<p>Ini adalah mimpi buruk terbesar. Foto KTP atau data pribadi yang Anda bagikan bisa digunakan pelaku kejahatan untuk mengajukan <strong>Pinjol (Pinjaman Online) Ilegal</strong> atas nama Anda. Tiba-tiba Anda ditagih hutang ratusan juta yang tidak pernah Anda nikmati.</p>

<h3>2. Mengundang Kejahatan Fisik 📍</h3>

<p>Fitur <em>location tag</em> memang seru, tapi berbahaya. Memberitahu lokasi Anda secara <em>real-time</em> sama saja memberikan peta gratis bagi penguntit (<em>stalker</em>). Lebih parah lagi, jika Anda update status &ldquo;Liburan sekeluarga ke Bali seminggu!&rdquo;, itu adalah undangan terbuka bagi perampok bahwa rumah Anda sedang kosong.</p>

<h3>3. Celah Peretasan (<em>Hacking</em>) 🔓</h3>

<p>Pernah ikut tren &ldquo;Spill nama panggilan kecil&rdquo; atau &ldquo;Spill tanggal lahir&rdquo;? Sadarkah Anda bahwa data-data tersebut (Nama Ibu Kandung, Tanggal Lahir, Sekolah Dasar) sering digunakan sebagai <strong>pertanyaan keamanan (<em>security question</em>)</strong> untuk memulihkan password bank atau email? Anda secara tidak sadar sedang menyerahkan kunci akun Anda kepada <em>hacker</em>.</p>

<h3>4. Target <em>Deepfake</em> AI 🤖</h3>

<p>Teknologi AI semakin canggih. Foto <em>selfie</em> resolusi tinggi yang Anda unggah bisa diambil dan dimanipulasi menggunakan teknologi <strong>Deepfake</strong>. Wajah Anda bisa ditempelkan pada video tak senonoh atau digunakan untuk video penipuan seolah-olah Anda sedang meminta uang kepada teman-teman Anda.</p>

<h3>5. Karir Terhambat 💼</h3>

<p>Jejak digital adalah CV kedua Anda. Sebelum merekrut, banyak perusahaan (HRD) yang melakukan <em>background check</em> melalui media sosial. Postingan kasar, rasis, atau penuh keluhan di masa lalu bisa membuat Anda gagal diterima kerja, tidak peduli seberapa pintar Anda.</p>

<h2>📌 Kesimpulan: Saring Sebelum <em>Sharing</em></h2>

<p>Media sosial adalah alat yang hebat jika digunakan dengan bijak. Jangan biarkan keinginan viral sesaat menghancurkan keamanan finansial dan masa depan karir Anda.</p>

<p>Mulai hari ini, jadilah <strong>Netizen Cerdas &amp; Aman</strong>. Pikirkan ulang sebelum memposting: <em>Apakah informasi ini aman? Apakah ini merugikan saya di masa depan?</em> Jika ragu, lebih baik simpan untuk diri sendiri.</p>

<p><strong>Lindungi Privasimu, Amankan Masa Depanmu.</strong></p>
',
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(50, 200),
        ]);

        $this->command->info('Jejak Digital - Oversharing Article created successfully!');
    }
}
