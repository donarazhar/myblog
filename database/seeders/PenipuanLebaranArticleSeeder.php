<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class PenipuanLebaranArticleSeeder extends Seeder
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

        // Create Penipuan Lebaran article
        Article::create([
            'title' => 'Waspada Penipuan Jelang Lebaran: 5 Modus Penipuan Digital Mengincar Gaji & THR',
            'slug' => 'waspada-penipuan-jelang-lebaran-5-modus-penipuan-digital-mengincar-gaji-thr',
            'excerpt' => 'Menjelang Hari Raya Idul Fitri, para penjahat siber memanfaatkan momen ketersediaan dana segar untuk melancarkan berbagai modus penipuan. Kenali 5 modus penipuan digital terkini beserta langkah pencegahannya.',
            'content' => '
<p>Menjelang Hari Raya Idul Fitri, antusiasme masyarakat kian meningkat, terutama dengan turunnya rezeki berupa Gaji dan Tunjangan Hari Raya (THR). Momen ini adalah waktu yang dinanti-nanti untuk memenuhi kebutuhan keluarga sekaligus memperbanyak amal ibadah seperti zakat, infak, dan sedekah.</p>

<p>Namun, di balik euforia tersebut, ada ancaman nyata yang mengintai di ruang digital. Para penjahat siber (<em>cybercriminals</em>) memanfaatkan momen ketersediaan &ldquo;dana segar&rdquo; ini untuk melancarkan berbagai modus penipuan. Jika kita tidak mengedepankan prinsip <em>tabayyun</em> (teliti dan berhati-hati) dalam bertransaksi, niat baik dan hasil jerih payah kita bisa lenyap dalam sekejap.</p>

<p>Sebagai upaya meningkatkan literasi digital dan melindungi umat dari kejahatan siber, berikut adalah 5 modus penipuan terkini yang wajib Anda waspadai beserta langkah pencegahannya:</p>

<h2>1. File APK Jahat (Sniffing): Jebakan di Balik Pesan Singkat</h2>

<p>Modus ini kian marak terjadi melalui aplikasi pesan singkat seperti WhatsApp. Pelaku akan mengirimkan sebuah <em>file</em> berekstensi <strong>.APK</strong> yang diberi nama manipulatif, seperti &ldquo;Info THR&rdquo; atau &ldquo;Resi Paket&rdquo;.</p>

<ul>
    <li><strong>Cara Kerjanya:</strong> Jika Anda mengunduh dan menginstal <em>file</em> tersebut, aplikasi jahat ini akan bersarang di <em>smartphone</em> Anda. Malware ini mampu membaca SMS OTP (One-Time Password) dan menyedot data pribadi, sehingga pelaku bisa menguras seluruh saldo <em>m-banking</em> Anda tanpa Anda sadari.</li>
    <li><strong>Langkah Pencegahan:</strong> Haram hukumnya menginstal aplikasi dari luar sumber resmi (seperti Play Store/App Store). Jika menerima <em>file</em> .APK dari <em>chat</em> mana pun, <strong>STOP! Jangan diklik</strong>. Segera hapus pesan dan blokir nomor tersebut.</li>
</ul>

<h2>2. QRIS Zakat Palsu (Quishing): Membajak Niat Sedekah</h2>

<p>Momen Ramadhan dan Lebaran adalah puncak antusiasme umat untuk beramal. Sayangnya, penipu memanfaatkan kelengahan donatur dengan modus menempelkan stiker QRIS palsu.</p>

<ul>
    <li><strong>Cara Kerjanya:</strong> Pelaku mencetak stiker QRIS milik rekening pribadi mereka, lalu menempelkannya tepat di atas QRIS asli di kotak amal. Saat Anda memindai (<em>scan</em>) QRIS tersebut, uang sedekah Anda justru masuk ke kantong penipu.</li>
    <li><strong>Langkah Pencegahan:</strong> Jadikan verifikasi sebagai kebiasaan wajib. Setelah memindai kode QRIS, <strong>lihat layar HP Anda terlebih dahulu</strong>. Pastikan verifikasi nama lembaga penerima sebelum <em>input</em> PIN. Jika nama yang muncul berbeda atau mencurigakan, segera batalkan transaksi!</li>
</ul>

<h2>3. Investasi Bodong (Scam): Ilusi Untung Instan</h2>

<p>Penipu memanfaatkan keinginan seseorang untuk melipatgandakan uang THR dengan cepat melalui tawaran investasi tak masuk akal.</p>

<ul>
    <li><strong>Cara Kerjanya:</strong> Korban ditawari investasi instan dengan janji &ldquo;Lipat Ganda THR&rdquo;. Setelah memberikan uang muka atau deposit, pelaku akan membawa kabur uang tersebut.</li>
    <li><strong>Langkah Pencegahan:</strong> Abaikan janji manis. Ingatlah prinsip dasar: jika sebuah tawaran terlihat terlalu bagus untuk menjadi kenyataan, maka kemungkinan besar itu adalah penipuan. Jangan pernah tergiur untung instan yang tak logis.</li>
</ul>

<h2>4. Call Center Palsu: Manipulasi Psikologis</h2>

<p>Penjahat siber sangat pandai memainkan psikologis korban dengan menelepon dan mengaku dari pihak institusi resmi.</p>

<ul>
    <li><strong>Cara Kerjanya:</strong> Pelaku menelepon dengan menyamar sebagai petugas Bank atau instansi terkait. Mereka akan mendesak Anda untuk memberikan kode OTP, PIN, atau <em>Password</em> dengan berbagai dalih.</li>
    <li><strong>Langkah Pencegahan:</strong> Tetap tenang. Abaikan dan segera tutup telepon. Ingatlah selalu bahwa <strong>pihak bank resmi tidak pernah meminta kode OTP, PIN, atau Password</strong> milik nasabahnya.</li>
</ul>

<h2>5. Promo Diskon Palsu (Phishing): Jebakan Belanja Lebaran</h2>

<p>Euforia belanja Lebaran sering membuat masyarakat kurang teliti saat berselancar di internet.</p>

<ul>
    <li><strong>Cara Kerjanya:</strong> Pelaku menyebarkan <em>link</em> promo &ldquo;Diskon Spesial Lebaran 90%&rdquo;. Tautan ini mengarah ke situs <em>web</em> palsu yang didesain mirip dengan aslinya untuk mencuri data kartu atau akun Anda.</li>
    <li><strong>Langkah Pencegahan:</strong> Selalu teliti <em>URL link</em> situs <em>web</em> dengan saksama. Cek ejaan alamat situsnya. Untuk keamanan maksimal, lebih aman melakukan transaksi langsung di aplikasi resmi belanja Anda.</li>
</ul>

<h2>Kesimpulan</h2>

<p>Ruang digital memberikan banyak kemudahan, termasuk dalam urusan perbankan dan ibadah maliyah (harta). Namun, kemudahan ini harus dibarengi dengan literasi digital yang mumpuni. Menjaga harta (<em>hifzh al-mal</em>) adalah salah satu tujuan syariat Islam. Oleh karena itu, mari budayakan <em>tabayyun</em>, berhati-hati, dan tidak mudah panik maupun tergiur di ruang digital.</p>

<p>Jaga keamanan Gaji dan THR Anda, pastikan sedekah Anda tepat sasaran. Literasi Digital adalah kunci menjaga amanah harta di era digital.</p>
',
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(50, 200),
        ]);

        $this->command->info('Penipuan Lebaran Article created successfully!');
    }
}
