<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class ItqanManajemenMutuArticleSeeder extends Seeder
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

        // Create Itqan Manajemen Mutu article
        Article::create([
            'title' => 'Mengimplementasikan Nilai Itqan: Fondasi Manajemen Mutu dan Transformasi Keamanan Data',
            'slug' => 'mengimplementasikan-nilai-itqan-fondasi-manajemen-mutu-dan-transformasi-keamanan-data',
            'excerpt' => 'Eksplorasi konsep Itqan (kesempurnaan) dalam Islam sebagai fondasi manajemen mutu dan transformasi keamanan data digital. Membahas empat tahapan Security Maturity Level dari Security Dependent hingga Security Freedom.',
            'content' => '
<blockquote>
    <p><em>&ldquo;Dan engkau akan melihat gunung-gunung, yang engkau kira tetap di tempatnya, padahal ia berjalan seperti jalannya awan. (Demikianlah) perbuatan Allah yang membuat dengan kokoh (sempurna) tiap-tiap sesuatu; sesungguhnya Allah Maha Mengetahui apa yang kamu kerjakan.&rdquo;</em> (Q.S. An-Naml [27]: 88)</p>
</blockquote>

<p>Ayat di atas mengandung kata kunci <strong>&ldquo;Atqana&rdquo;</strong> yang berarti sempurna atau kokoh. Allah SWT bekerja dengan kesempurnaan mutlak, dengan <em>&ldquo;Manajemen Mutu Illahiah&rdquo;</em>. Sebagai hamba-Nya, manusia dituntut untuk meneladani sifat tersebut dalam batas kemampuannya. Dalam perspektif Islam, konsep <strong>Itqan</strong> (mutu) didefinisikan sebagai aktivitas yang diselesaikan secara tertib, disiplin, akurat, dan bijaksana.</p>

<h2>🌟 Spirit Itqan dalam Manajemen Mutu</h2>

<p>Bagi lingkungan YPI Al Azhar, konsep Itqan sangat relevan dengan prinsip manajemen mutu modern yang menekankan tiga pilar utama:</p>

<ol>
    <li><strong>Pelayanan Prima:</strong> Memberikan layanan terbaik melebihi ekspektasi.</li>
    <li><strong>Etos Kerja Tinggi:</strong> Bekerja dengan semangat dan dedikasi.</li>
    <li><strong>Hasil Berkualitas:</strong> Output pekerjaan yang akurat dan bermanfaat.</li>
</ol>

<p>Namun, Itqan melampaui sekadar pencapaian target duniawi. Ia adalah bentuk <strong>tanggung jawab moral dan spiritual</strong>. Bekerja dengan mutu yang tinggi adalah wujud ibadah dan amal saleh.</p>

<p>Karena kesempurnaan manusia bersifat relatif&mdash;apa yang dianggap sempurna oleh satu orang belum tentu sama bagi orang lain&mdash;maka diperlukan sebuah <strong>Standar</strong>. Sebagaimana hidup seorang Muslim yang dipandu oleh Al-Qur&rsquo;an dan As-Sunnah agar tidak tersesat, sebuah organisasi memerlukan panduan dan standar operasional (SOP) agar arah perjalanan tetap terarah, berkelanjutan, dan penuh keberkahan.</p>

<p>Unit IT dan Transformasi Digital (ITTD) berkomitmen menjadikan dokumentasi panduan dan rencana strategis sebagai bukti nyata implementasi semangat Itqan. Setiap inovasi dan pekerjaan diniatkan sebagai ibadah yang bernilai jariyah.</p>

<h2>🔐 Transformasi Keamanan Data: Menuju Security Freedom</h2>

<p>Salah satu wujud nyata dari Itqan di era digital adalah bagaimana kita menjaga amanah berupa data. Berdasarkan diskusi mengenai panduan keamanan, kita dapat memetakan tingkat kematangan keamanan (<em>Security Maturity Level</em>) organisasi menjadi empat tahapan:</p>

<h3>1. Security Dependent (Reaktif)</h3>

<p>Pada tahap ini, keamanan bergantung pada reaksi setelah ancaman terjadi. Organisasi baru bertindak memperkuat sistem setelah serangan masuk.</p>

<ul>
    <li><strong>Ciri:</strong> Tidak ada standar keamanan yang jelas.</li>
    <li><strong>Analogi:</strong> Seperti penangkal petir konvensional yang baru bekerja ketika petir menyambar batangnya. Ini berbeda dengan sistem elektrostatis modern yang mampu memproteksi area radius luas sebelum sambaran terjadi.</li>
</ul>

<h3>2. Security Solvency (Proaktif)</h3>

<p>Organisasi mulai bergerak proaktif dan memiliki kontrol keamanan dasar yang solid.</p>

<ul>
    <li><strong>Ciri:</strong> Sudah memiliki kebijakan, backup, firewall, enkripsi, serta audit rutin.</li>
    <li><strong>Kondisi:</strong> Keamanan sudah mampu mengatasi sebagian besar ancaman umum karena adanya SOP yang dijalankan.</li>
</ul>

<h3>3. Security Stability (Adaptif)</h3>

<p>Keamanan dan ancaman berada dalam titik keseimbangan dinamis. Sistem tidak hanya bertahan, tetapi mampu beradaptasi terhadap perubahan pola serangan.</p>

<ul>
    <li><strong>Ciri:</strong> Memiliki sistem monitoring dan respon insiden otomatis. Terbentuknya budaya keamanan (<em>security culture</em>) di seluruh level organisasi.</li>
    <li><strong>Analogi:</strong> Sebuah kapal yang kokoh di lautan. Ia mampu menghadapi ombak besar tanpa harus menunggu badai reda karena struktur dan awaknya sudah siap menghadapi segala kondisi.</li>
</ul>

<h3>4. Security Freedom (Terintegrasi)</h3>

<p>Ini adalah level tertinggi di mana keamanan menjadi bagian alami dari sistem (<em>Security by Design</em>). Keamanan tidak lagi menjadi kekhawatiran utama yang menghambat gerak, melainkan pendorong kemajuan.</p>

<ul>
    <li><strong>Ciri:</strong> Keamanan berjalan otomatis, adaptif, dan berbasis AI. Fokus organisasi beralih dari &ldquo;mencegah serangan&rdquo; menjadi &ldquo;memperluas inovasi&rdquo;. Model ini diterapkan oleh perusahaan teknologi besar (Big Tech) di mana pengguna merasa aman bertransaksi.</li>
    <li><strong>Analogi:</strong> <em>&ldquo;Anda tidak lagi takut hujan karena sudah memiliki rumah dengan pondasi kokoh dan atap yang kuat.&rdquo;</em></li>
</ul>

<h2>📌 Penutup</h2>

<p>Perjalanan menuju <strong>Security Freedom</strong> dan manajemen mutu yang sempurna adalah proses berkelanjutan. Dengan memegang teguh nilai Itqan, kita berharap setiap langkah transformasi digital yang dilakukan tidak hanya membawa kemajuan organisasi, tetapi juga dicatat sebagai amal kebaikan di sisi Allah SWT.</p>
',
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(50, 200),
        ]);

        $this->command->info('Itqan Manajemen Mutu & Transformasi Keamanan Data Article created successfully!');
    }
}
