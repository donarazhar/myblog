<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class PostTruthArticleSeeder extends Seeder
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

        // Create Post-Truth article
        Article::create([
            'title' => 'Ketika Fakta Bukan Lagi Raja: Selamat Datang di Era Post-Truth',
            'slug' => 'ketika-fakta-bukan-lagi-raja-selamat-datang-di-era-post-truth',
            'excerpt' => 'Mengapa hoaks lebih cepat viral daripada klarifikasi data yang valid? Selamat datang di era Post-Truth, di mana kebenaran objektif kalah oleh emosi dan keyakinan pribadi. Pelajari cara bertahan dengan berpikir kritis.',
            'content' => '
<p>Pernahkah Anda bertanya-tanya, kenapa berita bohong (<em>hoaks</em>) yang memancing amarah seringkali lebih cepat viral daripada klarifikasi data yang valid? Kenapa perdebatan di kolom komentar seringkali berujung pada caci maki tanpa ada titik temu?</p>

<p>Selamat datang di era <strong>Post-Truth</strong>. Sebuah zaman di mana kebenaran objektif menjadi kurang penting dibandingkan dengan emosi dan keyakinan pribadi. Di era ini, fakta bukan lagi raja; perasaanlah yang memegang mahkota.</p>

<h2>Mengapa Hoaks Lebih Cepat Viral?</h2>

<p>Dalam psikologi era digital, berlaku rumus sederhana namun berbahaya: <strong>Emosi &gt; Fakta.</strong></p>

<p>Manusia secara alami memiliki <em>Confirmation Bias</em> (bias konfirmasi). Kita cenderung mencari, mempercayai, dan menyebarkan informasi yang <strong>mendukung apa yang sudah kita yakini</strong>, bukan apa yang sebenarnya terjadi. Kebenaran menjadi nomor dua, yang terpenting adalah &quot;validasi perasaan&quot;.</p>

<p>Jika sebuah berita bohong berhasil membuat kita merasa &quot;senang&quot;, &quot;dibenarkan&quot;, atau bahkan &quot;marah pada musuh kita&quot;, maka jari kita akan otomatis menekan tombol <em>share</em> tanpa berpikir panjang. Inilah bahan bakar utama mesin hoaks.</p>

<h2>⚠️ Terperangkap dalam Jebakan &quot;Filter Bubble&quot;</h2>

<p>Sadarkah Anda bahwa media sosial tidak dirancang untuk memberikan kebenaran yang utuh? Media sosial didesain untuk membuat Anda betah berlama-lama menatap layar.</p>

<p>Algoritma Facebook, TikTok, Instagram, hingga YouTube bekerja dengan cara mempelajari apa yang Anda sukai. Jika Anda sering menyukai konten politik A, maka algoritma akan terus &quot;menyuapi&quot; Anda dengan konten yang memuji A dan menjelekkan B.</p>

<p>Inilah yang disebut <strong>Filter Bubble</strong> atau gelembung filter.</p>

<ul>
    <li>Kita terkurung dalam &quot;tempurung digital&quot; kita sendiri.</li>
    <li>Kita merasa bahwa &quot;semua orang berpikir seperti kita&quot;.</li>
    <li>Akibatnya, kita menjadi makin fanatik, anti-perbedaan, dan menganggap pandangan yang berbeda sebagai serangan atau kejahatan.</li>
</ul>

<h2>Jangan Mau Dibodohi! Lakukan 3 Langkah Ini</h2>

<p>Kita tidak bisa mematikan algoritma, tapi kita bisa mengendalikan diri kita sendiri. Jangan biarkan diri Anda menjadi boneka yang digerakkan oleh emosi sesaat. Berikut adalah <em>Action Plan</em> untuk bertahan di era Post-Truth:</p>

<h3>1. 🕵️ Verifikasi Dulu, Baru Bicara</h3>
<p>Jangan pernah hanya membaca judul (headline). Judul seringkali dibuat sensasional (clickbait) demi trafik. Cek sumber beritanya: Apakah dari media kredibel atau blog antah-berantah? Apakah ada bukti foto/video yang asli atau editan?</p>

<h3>2. 🧠 Sadari Bias dalam Diri</h3>
<p>Sebelum membagikan sesuatu, berhentilah sejenak dan tanya pada diri sendiri: <em>&quot;Aku share ini karena ini benar-benar fakta, atau karena ini memuaskan egoku untuk menyerang orang lain?&quot;</em> Jika jawabannya yang kedua, tahan jarimu.</p>

<h3>3. 🌐 Pecahkan Gelembung Filter</h3>
<p>Jangan hanya <em>follow</em> akun-akun yang setuju denganmu. Ikuti juga akun berita atau tokoh yang memiliki pandangan berseberangan. Tujuannya bukan untuk menyetujui mereka, tapi untuk meluaskan wawasan agar Anda paham konteks masalah dari berbagai sudut pandang (Cover Both Sides).</p>

<h2>Kesimpulan: Jadilah Netizen Cerdas</h2>

<p>Di tengah banjir informasi yang tak terbendung, kemampuan berpikir kritis adalah pelampung keselamatan kita. Jangan mudah &quot;terbakar&quot; oleh isu yang belum jelas. Mari kita kembalikan akal sehat ke dalam ruang digital kita.</p>

<p>Ingat: <strong>Utamakan Akal Sehat, Bukan Urat Leher.</strong></p>

<p><em>Materi ini merupakan bagian dari IT Literacy Series - YPI Al Azhar.</em></p>
',
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(50, 200),
        ]);

        $this->command->info('Post-Truth Article created successfully!');
    }
}
