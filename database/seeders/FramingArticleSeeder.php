<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class FramingArticleSeeder extends Seeder
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

        // Create Framing article
        Article::create([
            'title' => 'Waspada Jebakan Framing: Fakta Sama, Sudut Pandang Beda',
            'slug' => 'waspada-jebakan-framing',
            'excerpt' => 'Literasi digital tentang bahaya framing yang lebih halus dari hoax. Pelajari cara menjadi netizen cerdas agar tidak terjebak hasutan emosional di media sosial.',
            'content' => '
<p>Di era digital, informasi beredar sangat cepat. Namun, literasi digital bukan hanya tentang membedakan berita asli dan palsu (hoax). Ada bahaya lain yang lebih halus dan sering tidak disadari, yaitu <strong>Framing</strong>.</p>

<h2>Apa Itu Framing?</h2>

<p>Bayangkan dua orang melihat angka <strong>6</strong> dan <strong>9</strong> dari arah berlawanan. Keduanya melihat fakta yang sama (sebuah angka), namun memiliki interpretasi yang berbeda. Itulah analogi sederhana dari framing.</p>

<p><strong>Framing</strong> adalah strategi membingkai sebuah peristiwa atau fakta agar publik memiliki pandangan tertentu sesuai keinginan pembuat berita. Dalam framing:</p>
<ul>
    <li><strong>Fakta Sama</strong>: Kejadiannya benar-benar ada dan nyata.</li>
    <li><strong>Sudut Pandang Beda</strong>: Cara penyampaiannya dimiringkan ke satu sisi.</li>
    <li><strong>Tujuan</strong>: Mengaduk emosi pembaca (Marah, Sedih, Benci).</li>
</ul>

<h2>Bahaya Terbesar: Jebakan "Paling Tahu"</h2>

<p>Bahaya terbesar era digital bukan cuma Hoax, tapi Framing yang membuatmu merasa <strong>"Paling Tahu"</strong>. Saat kita membaca satu judul provokatif, kita langsung merasa tahu segalanya, padahal kita cuma tahu "sepotong" fakta yang sudah dibumbui.</p>

<h2>Hoax vs Framing: Bedanya Apa?</h2>

<table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse: collapse; margin-bottom: 20px;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>HOAX</th>
            <th>FRAMING</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Berita Bohong Total</td>
            <td>Berita Benar Terjadi</td>
        </tr>
        <tr>
            <td>Data Palsu / Dikarang</td>
            <td>Fakta Dipotong Sepihak</td>
        </tr>
        <tr>
            <td>Tidak Pernah Terjadi</td>
            <td>Judul Provokatif</td>
        </tr>
    </tbody>
</table>

<h2>3 Saringan Cek Fakta Sebelum Share</h2>

<h3>1. Fakta atau Opini?</h3>
<p>Cek kalimatnya! Apakah murni kejadian (Fakta) atau sudah ada bumbu pendapat penulisnya yang menuduh (Opini)?</p>
<ul>
    <li><strong>Fakta</strong>: "Terjadi kebakaran di Gedung A jam 10.00 WIB." (Objektif)</li>
    <li><strong>Opini/Framing</strong>: "Gedung A kebakaran akibat kelalaian satpam yang malas." (Subjektif/Menuduh)</li>
</ul>

<h3>2. Status Hukum Jelas?</h3>
<p>Jangan jadi "hakim jalanan". Seringkali framing membuat seseorang terlihat bersalah padahal belum disidang.</p>
<ul>
    <li><strong>Praduga Tak Bersalah</strong>: Seseorang belum tentu bersalah sebelum ada putusan pengadilan.</li>
    <li><strong>Cek Sumber</strong>: Apakah info dari kepolisian/resmi atau baru "katanya"?</li>
    <li><strong>Bahaya</strong>: Menuduh orang yang belum tentu salah sama dengan Fitnah Digital.</li>
</ul>

<h3>3. Konteks Utuh atau Potongan?</h3>
<p>Hati-hati dengan video potongan atau clickbait.</p>
<ul>
    <li><strong>Video Potongan</strong>: Video 1 jam dipotong jadi 15 detik bisa mengubah makna total.</li>
    <li><strong>Clickbait</strong>: Judul heboh, isi berita biasa saja.</li>
    <li><strong>Tips</strong>: Tonton sampai habis, baca sampai tuntas baru komentar.</li>
</ul>

<h2>Kesimpulan: Jadilah Netizen Cerdas</h2>

<p>Mari jaga jari kita dari dosa jariyah akibat framing. Mulai hari ini, praktikkan langkah berikut:</p>
<ol>
    <li><strong>Tahan Jempol</strong>: Jangan buru-buru share saat emosi.</li>
    <li><strong>Baca Utuh</strong>: Jangan cuma baca judul.</li>
    <li><strong>Cek Sumber Lain</strong>: Lakukan <em>cover both sides</em> (cek dari sisi lain).</li>
</ol>

<p><em>Materi ini merupakan bagian dari IT Literacy Series - YPI Al Azhar.</em></p>
',
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(50, 200),
        ]);

        $this->command->info('Framing Article created successfully!');
    }
}
