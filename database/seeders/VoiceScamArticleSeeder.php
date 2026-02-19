<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Article;

class VoiceScamArticleSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('is_admin', true)->first();

        $category = Category::firstOrCreate(
            ['name' => 'Teknologi'],
            ['description' => 'Artikel tentang perkembangan teknologi']
        );

        Article::create([
            'title' => 'Suaramu Bisa Dicuri: Panduan Lengkap Menghadapi Ancaman Voice Scam & AI Voice Cloning',
            'slug' => 'suaramu-bisa-dicuri-panduan-voice-scam-ai-voice-cloning',
            'excerpt' => 'Di era digital, suara Anda kini menjadi target pencurian. Pelajari cara kerja jebakan "Say Yes", ancaman AI Voice Cloning yang bisa meniru suara dengan kemiripan 99%, serta strategi pertahanan diri untuk melindungi Anda dan keluarga.',
            'content' => '
<p>Di era digital ini, kita sudah terbiasa menjaga kerahasiaan <em>password</em>, PIN ATM, dan kode OTP. Namun, pernahkah terlintas di benak Anda bahwa <strong>suara Anda</strong> sendiri kini menjadi target pencurian?</p>

<p>Selamat datang di era kejahatan biometrik. Para penipu tidak lagi hanya mengincar data teks, tetapi mereka mengincar identitas biologis Anda. Artikel ini akan mengupas tuntas evolusi penipuan berbasis suara, mulai dari jebakan "Say Yes" hingga ancaman terbaru yang mengerikan: <em>AI Voice Cloning</em>.</p>

<hr>

<h2>📡 Bagian 1: Evolusi Penipuan Suara</h2>

<p>Dahulu, penipuan telepon (<em>vishing</em> atau <em>voice phishing</em>) sangat mudah dikenali. Penipu biasanya mengaku sebagai petugas bank dengan logat yang dibuat-buat atau sinyal yang sengaja dibuat putus-putus. Namun, teknologi telah mengubah peta permainan ini menjadi jauh lebih canggih dan berbahaya.</p>

<p>Saat ini, ada dua modus utama yang wajib Anda waspadai:</p>

<h3>1. Jebakan "Say Yes" (Modus Klasik)</h3>

<p>Ini adalah teknik manipulasi psikologis sederhana namun efektif.</p>

<ul>
    <li><strong>Cara Kerja:</strong> Penipu menelepon Anda (seringkali dari nomor tak dikenal atau nomor lokal yang terlihat normal). Saat Anda mengangkat, mereka akan bertanya dengan suara yang jelas atau justru agak samar: <em>"Halo, apakah suara saya terdengar jelas?"</em> atau <em>"Apa benar ini dengan Bapak/Ibu [Nama Anda]?"</em></li>
    <li><strong>Tujuan:</strong> Mereka memancing Anda untuk menjawab satu kata: <strong>"IYA"</strong> atau <strong>"BENAR"</strong>.</li>
    <li><strong>Bahayanya:</strong> Penipu merekam kata "Iya" tersebut. Rekaman suara Anda kemudian disunting (edit) seolah-olah Anda memberikan persetujuan lisan untuk:
        <ul>
            <li>Berlangganan layanan premium yang menguras pulsa.</li>
            <li>Menyetujui tagihan kartu kredit yang tidak Anda lakukan.</li>
            <li>Konfirmasi perubahan data perbankan (pada layanan yang masih menggunakan verifikasi suara standar).</li>
        </ul>
    </li>
</ul>

<h3>2. AI Voice Cloning (Ancaman Modern)</h3>

<p>Ini adalah level kejahatan yang jauh lebih tinggi. Penipu menggunakan <em>Generative AI</em> (Kecerdasan Buatan) untuk meniru suara target.</p>

<ul>
    <li><strong>Cara Kerja:</strong> Penipu hanya membutuhkan sampel suara Anda yang sangat pendek (sekitar <strong>3-10 detik</strong>). Sampel ini bisa didapat dari:
        <ul>
            <li>Konten media sosial (Instagram Story, TikTok, YouTube).</li>
            <li>Panggilan telepon spam di mana Anda sempat berbicara sedikit.</li>
        </ul>
    </li>
    <li><strong>Proses:</strong> Sampel suara dimasukkan ke dalam <em>software</em> AI. Software tersebut mempelajari intonasi, logat, jeda napas, dan timbre suara Anda. Dalam hitungan menit, penipu bisa mengetik kalimat apa saja, dan AI akan membacakannya <strong>menggunakan suara Anda</strong> dengan kemiripan hingga <strong>99%</strong>.</li>
</ul>

<hr>

<h2>🎯 Bagian 2: Skenario Serangan yang Sering Terjadi</h2>

<p>Memahami skenario serangan adalah kunci pertahanan terbaik. Berikut adalah modus operandi yang paling sering menggunakan teknologi <em>Voice Scam</em>:</p>

<h3>A. The Emergency Scam (Modus Kecelakaan/Keluarga)</h3>

<p>Penipu menelepon orang tua atau kakek-nenek Anda menggunakan suara "Anda" (hasil kloning AI).</p>

<ul>
    <li><strong>Skenario:</strong> Suara Anda terdengar panik, menangis, atau ketakutan. <em>"Mah, aku nabrak orang, sekarang di kantor polisi. Butuh uang damai 50 juta sekarang juga atau aku dipenjara."</em></li>
    <li><strong>Psikologi:</strong> Karena suaranya sangat mirip, korban langsung panik dan kehilangan nalar kritis. Transfer uang pun dilakukan.</li>
</ul>

<h3>B. The Fake Boss (CEO Fraud)</h3>

<p>Menargetkan karyawan perusahaan. Penipu menelpon karyawan bagian keuangan menggunakan suara atasan atau CEO.</p>

<ul>
    <li><strong>Skenario:</strong> <em>"Halo Budi, saya sedang meeting dengan klien penting. Tolong segera transfer pembayaran ke vendor X, nanti saya tanda tangan berkasnya setelah kembali ke kantor."</em></li>
    <li><strong>Psikologi:</strong> Memanfaatkan rasa takut dan kepatuhan karyawan terhadap atasan.</li>
</ul>

<h3>C. Bypass Keamanan Bank (Voice ID)</h3>

<p>Beberapa bank di luar negeri (dan mulai diadopsi di Indonesia) menggunakan <em>Voice Biometrics</em> sebagai pengganti password untuk layanan <em>phone banking</em>.</p>

<ul>
    <li><strong>Skenario:</strong> Penipu menggunakan suara AI Anda untuk menipu sistem keamanan bank agar memberikan akses ke rekening.</li>
</ul>

<hr>

<h2>🛡️ Bagian 3: Strategi Pertahanan Diri</h2>

<p>Kita tidak bisa menghentikan kemajuan teknologi, tetapi kita bisa memperkuat pertahanan diri. Berikut adalah langkah-langkah konkret untuk melindungi diri dan keluarga:</p>

<h3>1. Terapkan "Zero Trust" pada Panggilan Asing</h3>

<p>Jangan pernah percaya pada <em>Caller ID</em> (identitas penelpon yang muncul di layar), karena nomor telepon bisa dipalsukan (<em>spoofing</em>).</p>

<ul>
    <li><strong>Teknik "Mute":</strong> Saat mengangkat telepon dari nomor tak dikenal, jangan langsung bersuara. Tekan tombol <em>mute</em> atau diam saja. Biarkan penelpon bicara duluan. Bot atau mesin otomatis seringkali akan memutus panggilan jika tidak mendeteksi suara dalam 5 detik pertama.</li>
    <li><strong>Hindari Kata "Iya":</strong> Latih diri Anda untuk menjawab telepon dengan kalimat tanya. Ganti <em>"Halo, iya benar"</em> dengan <em>"Mohon maaf, dengan siapa saya bicara?"</em> atau <em>"Ada keperluan apa?"</em>.</li>
</ul>

<h3>2. Buat "Kode Rahasia Keluarga" (Safe Word)</h3>

<p>Ini adalah pertahanan paling ampuh melawan AI Voice Cloning.</p>

<ul>
    <li>Diskusikan dengan keluarga inti (Orang tua, Pasangan, Anak).</li>
    <li>Tentukan satu kata atau frasa unik yang tidak umum, misalnya: <strong>"Gado-gado Pedas"</strong> atau <strong>"Pintu Biru"</strong>.</li>
    <li><strong>Aturan Main:</strong> Jika ada anggota keluarga yang menelepon dalam keadaan darurat (kecelakaan, ditangkap polisi, butuh uang), <strong>WAJIB</strong> menanyakan kode tersebut.</li>
    <li>Jika penelepon tidak bisa menjawab atau beralasan <em>"Aduh lupa, ini lagi panik!"</em>, langsung matikan. Itu pasti penipuan.</li>
</ul>

<h3>3. Verifikasi Dua Arah (Call Back)</h3>

<p>Jika Anda menerima telepon darurat dari "teman" atau "keluarga" yang meminta uang:</p>

<ul>
    <li>Matikan telepon tersebut (jangan takut dianggap tidak sopan).</li>
    <li>Hubungi kembali nomor asli orang tersebut yang Anda simpan di kontak.</li>
    <li>Jika nomor aslinya tidak aktif, hubungi kerabat lain yang mungkin sedang bersama dia.</li>
</ul>

<h3>4. Jaga Jejak Suara di Media Sosial</h3>

<p>Sadari bahwa setiap kali Anda berbicara di <em>Instagram Story</em> atau <em>TikTok</em> yang bersifat publik, Anda sedang memberikan sampel biometrik gratis kepada dunia.</p>

<ul>
    <li>Pertimbangkan untuk mengunci akun (private) jika tidak berkepentingan untuk <em>personal branding</em>.</li>
    <li>Hati-hati saat mengangkat telepon <em>spam</em>, karena suara Anda bisa direkam untuk dijadikan sampel AI.</li>
</ul>

<hr>

<h2>🚨 Bagian 4: Apa yang Harus Dilakukan Jika Sudah Menjadi Korban?</h2>

<p>Jika Anda merasa sudah terlanjur menjawab "Iya" pada telepon mencurigakan atau keluarga Anda tertipu transfer uang:</p>

<ol>
    <li><strong>Hubungi Bank Segera:</strong> Minta pemblokiran rekening atau kartu kredit jika ada transaksi mencurigakan.</li>
    <li><strong>Lapor ke Operator Seluler:</strong> Laporkan nomor penipu agar ditandai sebagai <em>fraud</em>.</li>
    <li><strong>Ganti Password & PIN:</strong> Terutama jika penipu berhasil mendapatkan akses ke akun digital Anda.</li>
    <li><strong>Edukasi Lingkungan:</strong> Ceritakan kejadian ini kepada keluarga dan teman. Rasa malu seringkali membuat korban diam, padahal berbagi cerita bisa menyelamatkan orang lain.</li>
</ol>

<hr>

<h2>🏁 Kesimpulan</h2>

<p>Di era <em>Post-Truth</em> dan kecerdasan buatan ini, telinga kita tidak lagi bisa menjadi tolak ukur kebenaran. Suara yang terdengar akrab di telinga belum tentu berasal dari orang yang kita cintai.</p>

<p>Kewaspadaan, logika yang tenang, dan kesepakatan keamanan keluarga (seperti <em>Safe Word</em>) adalah benteng terakhir kita. Ingat, dalam menghadapi kejahatan siber, <strong>skeptis adalah bentuk pertahanan terbaik.</strong></p>

<p><strong>Share artikel ini kepada orang tua dan keluarga Anda. Satu informasi kecil bisa menyelamatkan tabungan seumur hidup mereka.</strong></p>

<p><em>Wallahu a\'lam bishawab.</em></p>
',
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(50, 200),
        ]);
    }
}
