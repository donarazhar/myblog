<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class SabarEraModernArticleSeeder extends Seeder
{
    public function run(): void
    {
        // Get admin user
        $admin = User::where('is_admin', true)->first();

        if (!$admin) {
            $this->command->warn('No admin user found. Please run DatabaseSeeder first.');
            return;
        }

        // Get or create category for Tausiyah
        $category = Category::firstOrCreate(
            ['name' => 'Tausiyah'],
            ['description' => 'Artikel tausiyah, nasihat keagamaan dan motivasi Islami']
        );

        // Create article
        Article::create([
            'title' => 'Mendefinisikan Ulang Sabar di Era Modern',
            'slug' => 'mendefinisikan-ulang-sabar-di-era-modern',
            'excerpt' => 'Sabar bukan berarti diam dan pasif. Di era modern ini, sabar harus berdaya — tetap tenang di bawah tekanan namun terus bekerja keras meningkatkan kualitas diri. Mari kita telaah makna sabar yang sesungguhnya melalui QS. Al-Baqarah ayat 153 dan pelajaran dari dunia nyata.',
            'content' => '
<p>Belakangan ini kita dibawa ke arah dunia yang bergerak dengan sangat cepat, penuh dengan hiruk pikuk dan penuh tekanan. Ketika kita membuka jendela informasi, kita disuguhi pemandangan yang membuat hati kita miris — di mana selalu ada benturan kepentingan, peperangan, dan berita ketidakadilan yang begitu tampak nyata di depan mata kita.</p>

<p>Saya mengutip dan terinspirasi kalimat dari Pak Damar yang sangat bagus, di mana saat ini kita melihat begitu gamblang era di mana <em>"Perang antara kebenaran melawan kezaliman"</em>. Mungkin Bapak Ibu tahu yang saya maksud, yaitu perang antara Iran vs Amerika/Israel.</p>

<p>Namun di sini saya mencoba mengaitkan dan memperluas bahasan agar bisa menguraikan judul dari artikel ini mengenai <strong>"Mendefinisikan Ulang Sabar di Era Modern"</strong>. Agar bisa menjadi lebih berkah sebagai sebuah tausiyah, marilah kita bersandar pada satu ayat yang sangat populer namun memiliki makna strategis yang mendalam, yaitu <strong>QS. Al-Baqarah ayat 153</strong>:</p>

<blockquote style="font-size: 1.3em; text-align: center; direction: rtl; font-family: \'Traditional Arabic\', \'Amiri\', serif; line-height: 2; padding: 20px; background: linear-gradient(135deg, #f0f9ff, #e8f5e9); border-radius: 12px; border-left: 4px solid #2e7d32;">
يَٰٓأَيُّهَا ٱلَّذِينَ ءَامَنُوا۟ ٱسْتَعِينُوا۟ بِٱلصَّبْرِ وَٱلصَّلَوٰةِ ۚ إِنَّ ٱللَّهَ مَعَ ٱلصَّٰبِرِينَ
</blockquote>

<p><strong>Artinya:</strong> <em>"Hai orang-orang yang beriman, jadikanlah sabar dan shalat sebagai penolongmu, sesungguhnya Allah beserta orang-orang yang sabar."</em></p>

<h2>🔥 Sabar Berdaya vs. Sabar Pasif</h2>

<p>Dulu kita sering mendengar kalimat <em>"Sabar aja, emang sudah nasib."</em> Jadi seolah-olah sabar itu identik dengan diam, pasif, dan hanya menunggu keajaiban turun dari langit — Allah kasih keajaiban ke kita gitu. Padahal jika kita telaah lebih dalam dan melihat apa yang terjadi belakangan ini, terutama jika kita mengaca pada negara Iran, <strong>sabar itu haruslah sabar yang berdaya, jangan sabar yang lemah</strong>.</p>

<p>Mari kita memetik pelajaran dari negara Iran di mana mereka mengimplementasikan bentuk sabar ini dengan cara yang berdaya. Mereka sabar menghadapi embargo yang dilakukan oleh Amerika sejak 1979.</p>

<p><strong>Bagaimana mereka bersabar?</strong><br>Mereka tidak hanya berdiam diri saja. Sabar mereka diwujudkan dalam bentuk:</p>

<div style="background: linear-gradient(135deg, #1a237e, #283593); color: #fff; padding: 25px; border-radius: 12px; margin: 20px 0;">
<h3 style="color: #90caf9;">1. 📚 Sabar dalam Literasi</h3>
<p>Negara Iran terus memperdalam ilmu pengetahuan meski akses mereka dibatasi. Para pemimpin mereka memiliki kualifikasi yang tinggi (minimal S2) — mungkin perbandingannya berbeda dengan di negara "Konoha" yang kita pahami sendirilah.</p>
</div>

<div style="background: linear-gradient(135deg, #b71c1c, #c62828); color: #fff; padding: 25px; border-radius: 12px; margin: 20px 0;">
<h3 style="color: #ef9a9a;">2. 🚀 Sabar dalam Inovasi</h3>
<p>Negara Iran membangun kemandirian teknologi dan militer secara mandiri hingga membuat dunia tercengang. Bagaimana kewalahannya Amerika dan Israel pada perang ini.</p>
</div>

<div style="background: linear-gradient(135deg, #1b5e20, #2e7d32); color: #fff; padding: 25px; border-radius: 12px; margin: 20px 0;">
<h3 style="color: #a5d6a7;">3. 🔄 Sabar dalam Transformasi</h3>
<p>Mereka mengubah tekanan menjadi energi untuk memperbaiki diri. Rakyat dan pemerintahnya bersatu bahu-membahu, tidak ada pengkhianatan di antara mereka, dan mereka satu suara bahwa Amerika dan Israel adalah iblis yang harus diperangi.</p>
</div>

<p>Inilah yang saya sebut sebagai <strong>Sabar Berdaya</strong> — yang saya definisikan sebagai <em>kemampuan untuk tetap tenang di bawah tekanan, namun tetap "bekerja keras dalam diam" hingga hasil yang bicara</em>. <strong>Sabar tanpa peningkatan kualitas diri bukanlah sabar, melainkan kepasrahan yang keliru.</strong></p>

<div style="background: linear-gradient(135deg, #fff3e0, #ffe0b2); padding: 20px; border-radius: 12px; border-left: 5px solid #e65100; margin: 20px 0;">
<p style="font-size: 1.1em; font-style: italic; color: #e65100; margin: 0;"><strong>💡 Jadi saya coba memotivasi diri saya dan mungkin juga ke teman-teman — jika saat ini kita sedang menghadapi kesulitan hidup, pekerjaan, atau kuliah, tanyakan pada diri sendiri: <br>"Sudahkah saya bersabar?"</strong></p>
</div>

<h2>🤲 Mengetuk Pintu Langit dengan Adab Terbaik</h2>

<p>Setelah ikhtiar fisik melalui sabar yang berdaya, maka penguatnya adalah <strong>Shalat</strong>, karena sesuai dengan ayat di atas bahwa <em>"jadikan sabar dan shalat sebagai penolongmu"</em>. Kita pasti semua sudah paham bahwa shalat adalah tiang agama, namun di dalam shalat itu sesungguhnya berisi lantunan doa-doa. Di sini saya akan mencoba sedikit menelisik sisi lain dari shalat ini, yaitu <strong>doa</strong>.</p>

<p>Karena kita pasti sering mengalami kegagapan dalam berdoa — mengutip kalimat Pak Damar ketika menyampaikan mengenai doa, di mana kita sebagai manusia sering kehabisan kata-kata dalam berdoa. Sehingga jalan terbaik menurut Pak Damar yaitu: <strong>gunakan Asmaul Husna</strong>, menyebut Allah dengan nama-nama indah &amp; terbaik-Nya. Dengan menyebut nama-nama indah dan terbaik Allah adalah bentuk komunikasi yang paling elegan dan penuh adab.</p>

<p><strong>Itulah cara kita "mengetuk pintu langit" dengan cara yang paling terhormat.</strong></p>

<p>Maka dari itu, di sini saya mencoba — layaknya seorang komposer dalam menciptakan bait-bait lagu — membuat bait-bait doa yang mungkin bisa digunakan agar kalimat-kalimat doa itu lebih indah:</p>

<div style="background: linear-gradient(135deg, #e8f5e9, #c8e6c9); padding: 25px; border-radius: 16px; margin: 25px 0; border: 1px solid #a5d6a7;">
<h3 style="color: #1b5e20;">1. 🕊️ Kelompok Doa Rahmat &amp; Keselamatan</h3>
<blockquote style="font-style: italic; font-size: 1.05em; color: #2e7d32; border-left: 4px solid #2e7d32; padding-left: 15px;">
"Ya Allah, Ya Salam, Ya Rahman, Ya Rahim — Jadikanlah aku dan keluargaku termasuk hamba-Mu yang selalu menerima rahmat dan kasih sayang-Mu, taufik dan hidayah-Mu."
</blockquote>
<ul>
    <li><strong>Ya Salam</strong>: Yang Maha Memberi Kesejahteraan dan Kedamaian.</li>
    <li><strong>Ya Rahman</strong>: Yang Maha Pengasih. Kasih sayang Allah yang bersifat umum untuk seluruh makhluk di dunia.</li>
    <li><strong>Ya Rahim</strong>: Yang Maha Penyayang. Kasih sayang Allah yang bersifat khusus dan kekal bagi hamba-hamba-Nya yang beriman.</li>
</ul>
</div>

<div style="background: linear-gradient(135deg, #fff8e1, #ffecb3); padding: 25px; border-radius: 16px; margin: 25px 0; border: 1px solid #ffd54f;">
<h3 style="color: #e65100;">2. 💰 Kelompok Doa Kelimpahan Rezeki</h3>
<blockquote style="font-style: italic; font-size: 1.05em; color: #bf360c; border-left: 4px solid #e65100; padding-left: 15px;">
"Ya Allah, Ya Razzaq, Ya Baasith, Ya Ghaniy — Limpahkanlah rezeki yang barokah, yang halal, yang thayyib, yang berlimpah kepada keluargaku dan semua keturunanku."
</blockquote>
<ul>
    <li><strong>Ya Razzaq</strong>: Yang Maha Pemberi Rezeki. Dialah yang menciptakan rezeki dan yang menyampaikannya kepada hamba-Nya.</li>
    <li><strong>Ya Baasith</strong>: Yang Maha Melapangkan. Digunakan untuk memohon agar rezeki yang sempit dilapangkan dan urusan yang sulit dipermudah.</li>
    <li><strong>Ya Ghaniy</strong>: Yang Maha Kaya / Maha Mandiri. Allah tidak membutuhkan apa pun, namun segala sesuatu membutuhkan-Nya.</li>
</ul>
</div>

<div style="background: linear-gradient(135deg, #e3f2fd, #bbdefb); padding: 25px; border-radius: 16px; margin: 25px 0; border: 1px solid #64b5f6;">
<h3 style="color: #0d47a1;">3. 💪 Kelompok Doa Kesehatan</h3>
<blockquote style="font-style: italic; font-size: 1.05em; color: #1565c0; border-left: 4px solid #0d47a1; padding-left: 15px;">
"Ya Allah, Ya Baari — Berikanlah kesehatan yang sempurna kepadaku, anak-anakku, istriku, orang tuaku dan saudara-saudaraku."
</blockquote>
<ul>
    <li><strong>Ya Baari</strong>: Yang Maha Memulihkan. Allah-lah yang mengatur setiap sel dalam tubuh agar berfungsi dengan sempurna dan serasi.</li>
</ul>
</div>

<div style="background: linear-gradient(135deg, #fce4ec, #f8bbd0); padding: 25px; border-radius: 16px; margin: 25px 0; border: 1px solid #f06292;">
<h3 style="color: #880e4f;">4. ✨ Kelompok Doa Kesucian &amp; Penjagaan Hati</h3>
<blockquote style="font-style: italic; font-size: 1.05em; color: #ad1457; border-left: 4px solid #880e4f; padding-left: 15px;">
"Ya Allah, Ya Quddus — Jauhkanlah aku dari penyakit hati, jauhkanlah aku dari sifat iri, dengki, fitnah, hasut dan dendam."
</blockquote>
<ul>
    <li><strong>Ya Quddus</strong>: Yang Maha Suci. Allah suci dari segala kekurangan dan cela. Memanggil nama ini sangat tepat untuk memohon agar hati kita dibersihkan (disucikan) dari penyakit hati.</li>
</ul>
</div>

<div style="background: linear-gradient(135deg, #ede7f6, #d1c4e9); padding: 25px; border-radius: 16px; margin: 25px 0; border: 1px solid #9575cd;">
<h3 style="color: #4a148c;">5. 📖 Kelompok Doa Kemuliaan &amp; Ilmu</h3>
<blockquote style="font-style: italic; font-size: 1.05em; color: #6a1b9a; border-left: 4px solid #4a148c; padding-left: 15px;">
"Ya Allah, Ya Rafi — Angkatlah derajatku, tambahilah ilmuku dan pertinggikan kecerdasanku."
</blockquote>
<ul>
    <li><strong>Ya Rafi</strong>: Yang Maha Meninggikan. Allah meninggikan derajat hamba-hamba-Nya baik di dunia (dengan ilmu dan kedudukan) maupun di akhirat.</li>
</ul>
</div>

<div style="background: linear-gradient(135deg, #e0f2f1, #b2dfdb); padding: 25px; border-radius: 16px; margin: 25px 0; border: 1px solid #4db6ac;">
<h3 style="color: #004d40;">6. 🙏 Kelompok Doa Syukur</h3>
<blockquote style="font-style: italic; font-size: 1.05em; color: #00695c; border-left: 4px solid #004d40; padding-left: 15px;">
"Ya Allah, Ya Syakur — Jadikanlah aku dan keluargaku termasuk hamba-Mu yang ahli bersyukur."
</blockquote>
<ul>
    <li><strong>Ya Syakur</strong>: Yang Maha Bersyukur / Memberi Balasan. Allah menghargai atau akan membalas setiap ketaatan sekecil apa pun dan memberikan balasan (pahala) yang berlipat ganda melebihi amal yang dilakukan.</li>
</ul>
</div>

<div style="background: linear-gradient(135deg, #263238, #37474f); color: #fff; padding: 25px; border-radius: 16px; margin: 25px 0; border: 1px solid #546e7a;">
<h3 style="color: #80cbc4;">7. 🛡️ Kelompok Doa Kekuasaan &amp; Perlindungan</h3>
<blockquote style="font-style: italic; font-size: 1.05em; color: #b2dfdb; border-left: 4px solid #80cbc4; padding-left: 15px;">
"Ya Allah, Ya Malikul Mulk, Ya Dzul Dzalali wal Ikram — Jauhkanlah aku dan keluargaku dari marabahaya, dari orang-orang jahat, dari godaan syetan yang terkutuk dan dari kesialan dunia dan akhirat."
</blockquote>
<ul>
    <li><strong>Ya Malikul Mulk</strong>: Pemilik Kerajaan Semesta. Dialah penguasa mutlak atas segala sesuatu, sehingga tidak ada kekuatan yang bisa mencelakai kita tanpa izin-Nya.</li>
    <li><strong>Ya Dzul Dzalali wal Ikram</strong>: Pemilik Kebesaran dan Kemuliaan. Nama yang sangat agung untuk menunjukkan bahwa Allah adalah sumber segala kehormatan.</li>
</ul>
</div>

<div style="background: linear-gradient(135deg, #efebe9, #d7ccc8); padding: 25px; border-radius: 16px; margin: 25px 0; border: 1px solid #a1887f;">
<h3 style="color: #3e2723;">8. 🤲 Kelompok Doa Pengampunan Mutlak</h3>
<blockquote style="font-style: italic; font-size: 1.05em; color: #4e342e; border-left: 4px solid #3e2723; padding-left: 15px;">
"Ya Allah, Ya Ghafar, Ya Ghafur, Ya Affuw — Ampunilah dosaku, dosa ayah ibuku, dosa anak-anak istriku, dan dosa semua keturunanku sepanjang hidup dunia dan akhirat."
</blockquote>
<ul>
    <li><strong>Ya Ghafar</strong>: Yang Maha Pengampun (secara berulang). Allah menutupi dosa hamba-Nya berkali-kali.</li>
    <li><strong>Ya Ghafur</strong>: Yang Maha Pengampun (secara mendalam). Allah mengampuni dosa besar dengan ampunan yang luas.</li>
    <li><strong>Ya Affuw</strong>: Yang Maha Pemaaf. Berbeda dengan Ghafur, Affuw bermakna menghapus dosa hingga bekas-bekasnya hilang sama sekali — seolah dosa itu tidak pernah ada. Saat menyebut Ya Affuw, bayangkan Anda sedang meminta agar catatan kesalahan tersebut dihapus total dari "log/riwayat" malaikat, sementara Ya Ghafar adalah memohon agar Allah menutupi aib kita dari pandangan manusia lain.</li>
</ul>
</div>

<hr>

<div style="background: linear-gradient(135deg, #1b5e20, #2e7d32); color: #fff; padding: 30px; border-radius: 16px; margin: 25px 0; text-align: center;">
<h2 style="color: #a5d6a7; margin-top: 0;">🌟 Penutup</h2>
<p style="font-size: 1.1em; line-height: 1.8;">Marilah kita terus bergerak. <strong>Jadilah pribadi yang sabar namun berdaya</strong>, yang shalatnya menguatkan, dan yang doanya mengetuk langit dengan adab yang paling mulia.</p>
<p style="font-size: 1.05em; line-height: 1.8;">Semoga Allah SWT senantiasa membimbing setiap langkah kita, menguatkan hati kita, dan menjadikan kita bagian dari barisan orang-orang yang menang di dunia maupun di akhirat.</p>
<p style="font-size: 1.1em; font-weight: bold; margin-bottom: 0; color: #c8e6c9;">Billahi taufiq wal hidayah,<br>Wassalamu\'alaikum Warahmatullahi Wabarakatuh.</p>
</div>
',
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(100, 500),
        ]);

        $this->command->info('Article "Mendefinisikan Ulang Sabar di Era Modern" created successfully!');
    }
}
