<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class GenerasiIqraArticleSeeder extends Seeder
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

        // Create Generasi Iqra article
        Article::create([
            'title' => 'Dari Generasi Scroll Menuju Generasi Iqra\': Melawan Brain Rot dengan Literasi dan Spiritualitas',
            'slug' => 'dari-generasi-scroll-menuju-generasi-iqra-melawan-brain-rot-dengan-literasi-dan-spiritualitas',
            'excerpt' => 'Refleksi mendalam tentang fenomena Brain Rot di era digital dan bagaimana spirit Iqra\' dari wahyu pertama Al-Qur\'an menjadi solusi untuk melawan kecanduan scrolling. Dilengkapi 5 langkah praktis "Tobat Digital" untuk mengembalikan ketajaman otak dan hati.',
            'content' => '
<p>Pernahkah kita merenung sejenak, mengapa ayat pertama yang Allah turunkan kepada Nabi Muhammad SAW di Gua Hira bukanlah perintah shalat, puasa, atau zakat? Padahal, masyarakat Mekkah saat itu berada dalam kondisi jahiliyah dengan moral yang rusak. Namun, firman pertama yang menembus langit adalah: <strong>&ldquo;Iqra&rsquo;&rdquo;</strong> (Bacalah).</p>

<blockquote>
    <p><em>&ldquo;Iqra&rsquo; bismi rabbikalladzii khalaq.&rdquo;</em> Bacalah dengan (menyebut) nama Tuhanmu yang menciptakan.</p>
</blockquote>

<p>Allah SWT mengetahui bahwa peradaban besar, teknologi canggih, dan inovasi yang mengubah dunia selalu dimulai dari membaca. Tidak ada peradaban yang dibangun di atas budaya &ldquo;malas berpikir&rdquo; atau sekadar mengejar hal viral. Dalam Islam, membaca adalah literasi tingkat tinggi&mdash;bukan hanya mengeja teks, tetapi membaca pola kehidupan, membaca data, membaca alam semesta, hingga membaca diri sendiri (<em>muhasabah</em>).</p>

<p>Ironisnya, hari ini kita rajin membaca status orang lain dan takarir (<em>caption</em>) gosip, namun lupa membaca isi hati sendiri. Jika kita ingin menjadi manusia yang cerdas secara digital dan tidak didikte oleh gawai, kuncinya hanya satu: <strong>Literasi</strong>.</p>

<h2>🧠 Fenomena <em>Brain Rot</em> dan Jebakan <em>Dopamine Loop</em></h2>

<p>Dunia kini terkesima dengan kecerdasan buatan (<em>Artificial Intelligence</em>), cip super cepat, dan valuasi perusahaan raksasa seperti NVIDIA yang menembus triliunan dolar. Apakah tokoh seperti Jensen Huang (CEO NVIDIA) menjadi jenius karena rajin menggulir laman <em>For You Page</em> (FYP)? Tentu tidak.</p>

<p>Mereka melakukan <em>Deep Work</em>. Proses panjang yang dimulai dari membaca riset, membaca kegagalan, dan memprediksi masa depan. Dari sanalah lahir imajinasi, ide, dan solusi. Orang yang malas membaca tidak memiliki &ldquo;basis data&rdquo; di kepalanya, sehingga mustahil memunculkan ide besar. Membaca buku itu meng-<em>install</em> ilmu, sementara <em>scrolling</em> tanpa tujuan sering kali hanya menumpuk &ldquo;sampah <em>cache</em>&rdquo; di memori otak kita.</p>

<p>Di balik kecepatan informasi yang membanjir, ada ancaman serius yang oleh psikologi modern disebut sebagai <strong>Brain Rot</strong> (Kebusukan Otak). Ini bukan sekadar istilah tren, melainkan kondisi nyata ketika otak terus-menerus disuapi konten pendek, cepat, dan dangkal. Dampaknya sangat destruktif:</p>

<ol>
    <li><strong>Hilangnya Fokus:</strong> Kita menjadi gelisah saat harus membaca tulisan panjang atau menyimak materi mendalam.</li>
    <li><strong>Kecemasan Meningkat:</strong> Munculnya <em>Fear of Missing Out</em> (FOMO).</li>
    <li><strong>Tumpulnya Daya Kritis:</strong> Kita menelan informasi mentah-mentah tanpa <em>tabayyun</em>.</li>
    <li><strong>Kesulitan Mengambil Keputusan:</strong> Karena terbiasa disetir algoritma, kemampuan membedakan baik dan buruk bagi diri sendiri menjadi lemah.</li>
</ol>

<p>Kita sibuk membandingkan diri dengan &ldquo;kesempurnaan&rdquo; hidup orang lain di layar, padahal itu hanyalah polesan filter dan penyuntingan. Inilah candu digital yang membuat kita lupa membaca realitas.</p>

<h2>🔄 5 Langkah &ldquo;Tobat Digital&rdquo;</h2>

<p>Bagaimana cara kita mengembalikan ketajaman otak dan hati yang mulai tergerus? Berikut adalah lima langkah praktis untuk melakukan <em>reset</em> sistem mental kita:</p>

<h3>1. Menangkan Jam Pagi (<em>Win The Morning</em>)</h3>

<p>Jangan biarkan algoritma menjajah mata kita saat bangun tidur. Haramkan menyentuh ponsel selama 60 menit pertama setelah bangun. Gunakan waktu emas itu untuk koneksi ke Langit (shalat, doa), bukan koneksi ke internet. Jika kita menang di pagi hari, insya Allah kita akan menang sepanjang hari.</p>

<h3>2. Luruskan Niat (<em>Intentional Usage</em>)</h3>

<p>Terapkan prinsip <em>Innamal A&rsquo;malu Binniyat</em>. Ubah pola pikir: ponsel adalah alat, bukan tuan. Gunakan gawai dengan niat spesifik, misalnya &ldquo;Saya buka HP untuk membaca artikel bermanfaat&rdquo; atau &ldquo;Mendengar kajian&rdquo;. Hindari membuka ponsel hanya untuk &ldquo;lihat-lihat&rdquo;, karena itu adalah pintu masuk jebakan waktu.</p>

<h3>3. Perbaiki Diet Konten (<em>Deep Thinking</em>)</h3>

<p>Lawan <em>Brain Rot</em> dengan melatih otak mengunyah konten &ldquo;keras&rdquo;. Biasakan menyimak <em>podcast</em> atau ceramah berdurasi panjang tanpa di-<em>skip</em> untuk melatih rentang fokus (<em>attention span</em>). Saat menunggu antrean, jangan refleks membuka ponsel. Biarkan otak beristirahat sejenak.</p>

<h3>4. Membaca Buku Fisik untuk <em>Deep Healing</em></h3>

<p>Kembali ke wahyu pertama. Membaca buku fisik melatih imajinasi dan fokus mendalam, berbeda dengan membaca di layar. Ini adalah terapi penyembuhan bagi otak yang terlalu bising.</p>

<h3>5. Meditasi dan Tafakkur</h3>

<p>Luangkan waktu minimal 30 menit sehari untuk duduk tenang, berzikir, dan melakukan apa yang disebut &ldquo;Bengong yang Sadar&rdquo; (<em>Mindfulness</em> atau <em>Tafakkur</em>). Putuskan koneksi dari kebisingan media sosial. Di momen hening inilah kita melakukan <em>scroll</em> ke dalam hati dan pikiran sendiri&mdash;mengingat dosa, mengingat orang tua, dan mengevaluasi hidup. Sering kali, Allah berbicara lewat hati kita yang paling dalam justru di saat hening.</p>

<h2>📖 Menjadi Generasi <em>Iqra&rsquo;</em></h2>

<p>Agar tidak hanyut terbawa arus, kita perlu memegang tiga standar hidup:</p>

<ul>
    <li><strong>Standar Diri (<em>Growth Mindset</em>):</strong> Jangan bandingkan &ldquo;belakang panggung&rdquo; hidupmu dengan &ldquo;panggung utama&rdquo; orang lain di sosmed. Bandingkan dirimu hari ini dengan dirimu yang kemarin.</li>
    <li><strong>Standar Solusi (<em>Value Creation</em>):</strong> Jangan hanya menjadi konsumen, jadilah kreator. Gunakan keahlian kita untuk memberi manfaat dan solusi, bukan sekadar memicu keributan.</li>
    <li><strong>Standar Mimpi (<em>Vision of Akhira</em>):</strong> Sandarkan segala ambisi dan teknologi pada ridha Allah. Mimpi tanpa iman, secanggih apa pun, akan terasa kosong.</li>
</ul>

<p>Hari ini kita dihadapkan pada dua pilihan dalam perang peradaban digital: Menjadi <strong>Generasi Scroll</strong> yang sibuk melihat hidup orang lain hingga lupa hidup sendiri, atau bangkit menjadi <strong>Generasi Iqra&rsquo;</strong> yang sibuk memahami ilmu dan menebar manfaat?</p>

<p>Mari menjadi cerdas digital. Jangan sampai sinyal ponsel kita kuat, namun koneksi kita kepada Allah lemah (<em>Lost Connection</em>). Semoga kita mampu menyelamatkan jari-jari dan pikiran kita dari hal yang sia-sia.</p>

<p><em>Wassalamu&rsquo;alaikum warahmatullahi wabarakatuh.</em></p>
',
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(50, 200),
        ]);

        $this->command->info('Generasi Iqra - Brain Rot Article created successfully!');
    }
}
