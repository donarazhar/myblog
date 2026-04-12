<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class PhishingArticleSeeder extends Seeder
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

        // Create Phishing article
        Article::create([
            'title' => 'Waspada Umpan Digital: Mengupas Tuntas Bahaya Phishing dan Cara Melawannya',
            'slug' => 'waspada-umpan-digital-mengupas-tuntas-bahaya-phishing-dan-cara-melawannya',
            'excerpt' => 'Phishing adalah ancaman siber paling dominan yang menargetkan kelalaian manusia. Pelajari anatomi serangan, berbagai jenisnya mulai dari spear phishing hingga quishing, dampak fatal yang ditimbulkan, serta strategi pertahanan berlapis untuk melindungi identitas digital Anda.',
            'content' => '
<p>Di dunia nyata, memancing membutuhkan umpan untuk mendapatkan ikan. Di dunia digital, para pelaku kejahatan siber menggunakan logika yang persis sama. Mereka menyebarkan &ldquo;umpan&rdquo; berupa informasi palsu&mdash;mulai dari email, pesan singkat, hingga situs web tiruan&mdash;untuk menjerat pengguna internet yang kurang waspada. Fenomena inilah yang kita kenal sebagai <strong>Phishing</strong>, dan ironisnya, ini adalah vektor serangan siber nomor satu di dunia saat ini.</p>

<h2>Apa Itu Phishing?</h2>

<p>Istilah <em>Phishing</em> berasal dari kata <em>fishing</em> (memancing) dengan penggantian huruf &ldquo;f&rdquo; menjadi &ldquo;ph&rdquo;&mdash;sebuah konvensi ejaan yang populer di kalangan <em>hacker</em> awal (dikenal sebagai <em>phreaking</em>). Secara teknis, <strong>phishing adalah upaya rekayasa sosial (<em>social engineering</em>) untuk mendapatkan informasi sensitif</strong>, seperti kata sandi, detail kartu kredit, kode OTP, atau data pribadi lainnya, dengan cara menyamar sebagai entitas tepercaya dalam komunikasi elektronik.</p>

<p>Yang membuat phishing begitu berbahaya adalah karena ia tidak menyerang sistem komputer secara langsung&mdash;<strong>ia menyerang manusia</strong>. Tidak peduli secanggih apa pun <em>firewall</em> atau antivirus yang terpasang, satu klik ceroboh dari pengguna bisa meruntuhkan seluruh pertahanan keamanan.</p>

<h2>Anatomi Serangan Phishing: Bagaimana Cara Kerjanya?</h2>

<p>Untuk memahami cara melawan phishing, kita perlu terlebih dahulu memahami bagaimana serangan ini dirancang secara sistematis. Berikut adalah tahapan umum sebuah operasi phishing:</p>

<ol>
    <li><strong>Fase Persiapan (<em>Setup</em>):</strong> Pelaku menyiapkan infrastruktur serangan. Ini bisa berupa mendaftarkan domain palsu yang mirip dengan situs asli (misalnya <code>www.bca-secure.com</code> alih-alih <code>www.bca.co.id</code>), membuat halaman login tiruan, atau menyusun template email yang meyakinkan.</li>
    <li><strong>Fase Distribusi (<em>Delivery</em>):</strong> Umpan disebarkan secara massal melalui berbagai kanal: email, SMS, pesan WhatsApp, DM media sosial, bahkan iklan berbayar di mesin pencari. Pesan ini biasanya mengandung elemen <strong>urgensi</strong> (&ldquo;Akun Anda akan diblokir dalam 24 jam!&rdquo;) atau <strong>iming-iming</strong> (&ldquo;Selamat! Anda memenangkan hadiah Rp 10 juta&rdquo;).</li>
    <li><strong>Fase Eksploitasi (<em>Exploitation</em>):</strong> Korban yang terpancing mengeklik tautan dan diarahkan ke situs palsu. Di sana, mereka diminta memasukkan kredensial (username, password, PIN, OTP). Data ini langsung dikirim ke server pelaku secara <em>real-time</em>.</li>
    <li><strong>Fase Monetisasi (<em>Cash-Out</em>):</strong> Pelaku menggunakan data curian untuk masuk ke akun asli korban, melakukan transfer dana, mengambil alih akun media sosial, atau menjual data tersebut di <em>dark web</em>.</li>
</ol>

<h2>Jenis-Jenis Phishing yang Wajib Anda Kenali</h2>

<p>Phishing bukan hanya soal email spam. Seiring perkembangan teknologi, metode phishing pun berevolusi menjadi semakin canggih dan terspesialisasi:</p>

<h3>1. Email Phishing (Phishing Massal)</h3>
<p>Ini adalah bentuk paling klasik dan paling umum. Pelaku mengirim ribuan hingga jutaan email yang terlihat berasal dari institusi resmi seperti bank, layanan e-commerce, atau penyedia email. Email ini biasanya berisi tautan ke situs palsu atau lampiran berisi <em>malware</em>.</p>

<h3>2. Spear Phishing (Phishing Bertarget)</h3>
<p>Berbeda dengan phishing massal, <em>spear phishing</em> menargetkan individu atau organisasi tertentu. Pelaku melakukan riset mendalam tentang korban&mdash;mengumpulkan informasi dari LinkedIn, media sosial, atau situs perusahaan&mdash;untuk membuat pesan yang sangat personal dan meyakinkan. Misalnya, email yang seolah-olah datang dari atasan langsung korban yang meminta transfer dana mendesak.</p>

<h3>3. Whaling (Phishing terhadap Eksekutif)</h3>
<p><em>Whaling</em> adalah spear phishing yang secara khusus menargetkan eksekutif tingkat tinggi (CEO, CFO, direktur). Serangan ini jauh lebih canggih karena <em>reward</em>-nya sangat besar&mdash;akses ke data korporat sensitif atau otorisasi transfer jutaan dolar.</p>

<h3>4. Smishing (SMS Phishing)</h3>
<p>Phishing melalui pesan SMS atau aplikasi pesan singkat seperti WhatsApp. Contoh klasiknya adalah pesan berupa &ldquo;Paket Anda tertahan di bea cukai, klik di sini untuk melacak&rdquo; atau &ldquo;Transaksi Rp 5.000.000 berhasil. Jika bukan Anda, hubungi link berikut.&rdquo;</p>

<h3>5. Vishing (Voice Phishing)</h3>
<p>Phishing melalui panggilan telepon. Pelaku menyamar sebagai petugas bank, polisi, atau petugas pajak, lalu menggunakan teknik manipulasi psikologis untuk mendesak korban memberikan data sensitif.</p>

<h3>6. Quishing (QR Code Phishing)</h3>
<p>Teknik terbaru yang memanfaatkan kode QR. Pelaku membuat kode QR palsu yang mengarah ke situs phishing, lalu menempelkannya di tempat umum&mdash;termasuk di kotak amal, poster promosi, atau menggantikan QR Code pembayaran di merchant.</p>

<h3>7. Clone Phishing</h3>
<p>Pelaku menduplikasi email sah yang pernah diterima korban sebelumnya, namun mengganti tautan atau lampiran asli dengan versi berbahaya. Karena email sebelumnya sudah pernah diterima dan dipercaya, korban cenderung lengah.</p>

<h2>Dampak Fatal: Mengapa Phishing Sangat Berbahaya?</h2>

<p>Jangan pernah menganggap remeh satu klik pada tautan yang salah. Berikut adalah dampak destruktif yang dapat menghancurkan kehidupan digital maupun nyata seseorang:</p>

<h3>1. Pengambilalihan Akun (<em>Account Takeover</em>)</h3>
<p>Begitu pelaku mendapatkan <em>username</em> dan <em>password</em> Anda&mdash;baik itu media sosial, email, atau akun kerja&mdash;mereka bisa mengunci Anda keluar dari akun sendiri, mengubah data, menyebarkan hoaks atas nama Anda, bahkan melakukan penipuan berantai kepada kontak-kontak Anda. Bayangkan akun WhatsApp Anda diretas lalu digunakan untuk meminjam uang ke seluruh kontak Anda.</p>

<h3>2. Saldo Rekening Dikuras</h3>
<p>Ini target utama sebagian besar pelaku phishing. Dengan mendapatkan data perbankan (<em>internet banking credentials</em>, nomor kartu kredit, CVV) atau akses ke aplikasi dompet digital (GoPay, OVO, DANA), saldo yang Anda kumpulkan dengan susah payah bisa lenyap dalam hitungan menit. Data dari <strong>BSSN (Badan Siber dan Sandi Negara)</strong> menunjukkan kerugian akibat kejahatan siber di Indonesia mencapai triliunan rupiah setiap tahunnya.</p>

<h3>3. Pencurian Identitas (<em>Identity Theft</em>)</h3>
<p>Data pribadi seperti NIK, foto KTP, nomor NPWP, atau <em>selfie</em> dengan KTP yang Anda kirimkan ke situs palsu bisa dijual di <em>dark web</em> atau digunakan langsung untuk: membuka rekening bank palsu, mengajukan pinjaman <em>online</em> (pinjol) atas nama Anda, mendaftarkan SIM card ilegal, hingga melakukan tindak kriminal menggunakan identitas Anda. Dampak hukum dan finansialnya bisa berlarut-larut selama bertahun-tahun.</p>

<h3>4. Kerugian Reputasi dan Psikologis</h3>
<p>Bagi individu, menjadi korban phishing bisa menimbulkan rasa malu, stres, dan trauma. Bagi perusahaan atau organisasi, satu karyawan yang terkena phishing bisa membocorkan data jutaan pelanggan, merusak kepercayaan publik, dan mengakibatkan tuntutan hukum serta denda regulasi yang besar.</p>

<h2>Perisai Digital: Strategi Pertahanan Berlapis Melawan Phishing</h2>

<p>Kabar baiknya, phishing adalah jenis serangan yang sangat bergantung pada kelalaian manusia. Artinya, dengan literasi digital yang baik dan kebiasaan keamanan siber yang tepat, kita bisa mencegahnya secara efektif. Berikut adalah strategi pertahanan berlapis yang wajib diterapkan:</p>

<h3>Lapisan 1: Verifikasi Sebelum Bertindak</h3>
<ul>
    <li><strong>Cek Link Sebelum Klik:</strong> Selalu arahkan kursor ke tautan (<em>hover</em>) untuk melihat URL sebenarnya sebelum mengeklik. Pelaku sering menggunakan alamat yang mirip tapi berbeda, misalnya <code>www.bannk-resmi.com</code> alih-alih <code>www.bankresmi.com</code>, atau <code>www.tokopedla.com</code> alih-alih <code>www.tokopedia.com</code>. Perhatikan juga penggunaan HTTPS&mdash;meskipun situs palsu pun bisa menggunakan HTTPS, ketiadaan HTTPS adalah <em>red flag</em> besar.</li>
    <li><strong>Waspadai Urgensi Palsu:</strong> Pesan yang meminta Anda &ldquo;bertindak segera&rdquo; atau &ldquo;akun akan diblokir dalam 1 jam&rdquo; hampir selalu merupakan taktik manipulasi. Institusi resmi tidak pernah mendesak lewat pesan instan.</li>
    <li><strong>Verifikasi Melalui Saluran Resmi:</strong> Jika menerima pesan mencurigakan yang mengatasnamakan bank atau instansi, jangan balas atau klik tautan di dalamnya. Hubungi langsung <em>call center</em> resmi atau buka aplikasi/situs resmi secara manual untuk memverifikasi.</li>
</ul>

<h3>Lapisan 2: Perkuat Keamanan Akun</h3>
<ul>
    <li><strong>Aktifkan 2FA (<em>Two-Factor Authentication</em>):</strong> Ini adalah lapisan keamanan ganda yang <em>wajib</em> diaktifkan di setiap akun penting. Bahkan jika pelaku berhasil mencuri kata sandi Anda, mereka tetap tidak bisa masuk tanpa kode verifikasi dari perangkat fisik Anda. Gunakan aplikasi autentikator (Google Authenticator, Authy) yang lebih aman daripada OTP via SMS.</li>
    <li><strong>Jaga Kode OTP Seperti Nyawa:</strong> OTP (<em>One-Time Password</em>) adalah kunci terakhir pertahanan. <strong>Pihak bank, e-commerce, atau layanan apa pun TIDAK AKAN PERNAH meminta kode OTP melalui telepon, chat, atau email.</strong> Jika ada yang memintanya, itu 100% penipuan.</li>
    <li><strong>Gunakan Password Manager:</strong> Hindari menggunakan password yang sama di banyak akun. Gunakan <em>password manager</em> seperti Bitwarden, 1Password, atau KeePass untuk membuat dan menyimpan password unik dan kuat untuk setiap akun.</li>
</ul>

<h3>Lapisan 3: Tingkatkan Pertahanan Teknis</h3>
<ul>
    <li><strong>Perbarui Perangkat Lunak Secara Rutin:</strong> Selalu <em>update</em> sistem operasi, browser, dan aplikasi ke versi terbaru. Pembaruan ini sering kali menambal celah keamanan yang bisa dieksploitasi oleh <em>malware</em> dari tautan phishing.</li>
    <li><strong>Pasang Antivirus dan Anti-Phishing:</strong> Gunakan perangkat lunak keamanan yang memiliki fitur deteksi phishing dan <em>safe browsing</em>. Browser modern seperti Chrome dan Firefox juga sudah memiliki fitur bawaan untuk memblokir situs phishing yang terdeteksi.</li>
    <li><strong>Jangan Unduh Lampiran Sembarangan:</strong> File berekstensi <code>.apk</code>, <code>.exe</code>, atau bahkan <code>.pdf</code> dan <code>.docx</code> dari sumber tidak dikenal bisa mengandung <em>malware</em>. Selalu verifikasi pengirim sebelum membuka lampiran.</li>
</ul>

<h3>Lapisan 4: Edukasi dan Kewaspadaan Berkelanjutan</h3>
<ul>
    <li><strong>Abaikan Kontak Mencurigakan:</strong> Jika Anda menerima pesan mendesak yang mengancam akun akan diblokir atau menawarkan hadiah yang terlalu muluk, abaikan. Gunakan fitur <em>block</em> dan <em>report</em> pada aplikasi pesan Anda.</li>
    <li><strong>Ikuti Perkembangan Modus Terbaru:</strong> Pelaku terus berinovasi. Follow akun-akun resmi seperti <strong>@kemaborasdigi</strong> (Kementerian Komunikasi dan Digital), <strong>BSSN</strong>, dan media literasi digital lainnya untuk tetap <em>update</em> dengan modus phishing terbaru.</li>
    <li><strong>Latih Diri dan Keluarga:</strong> Edukasi orang-orang terdekat Anda, terutama orang tua dan anak-anak yang mungkin kurang familier dengan ancaman digital. Simulasi phishing sederhana bisa menjadi cara efektif untuk meningkatkan kewaspadaan.</li>
</ul>

<h2>Langkah Responsif: Apa yang Harus Dilakukan Jika Menjadi Korban?</h2>

<p>Jika Anda menyadari telah menjadi korban phishing, <strong>jangan panik</strong>, tapi bertindaklah cepat:</p>

<ol>
    <li><strong>Segera Ubah Password:</strong> Ganti password akun yang terdampak dan semua akun lain yang menggunakan password serupa.</li>
    <li><strong>Hubungi Bank/Layanan Terkait:</strong> Jika data perbankan terkompromikan, segera hubungi <em>call center</em> bank untuk memblokir kartu atau rekening.</li>
    <li><strong>Aktifkan/Reset 2FA:</strong> Pastikan autentikasi dua faktor aktif dan reset jika perlu.</li>
    <li><strong>Scan Perangkat:</strong> Jalankan pemindaian antivirus menyeluruh untuk mendeteksi dan menghapus <em>malware</em> yang mungkin terinstal.</li>
    <li><strong>Laporkan:</strong> Laporkan insiden ke portal resmi <strong>aduankonten.id</strong> dan ke pihak kepolisian melalui kanal pelaporan kejahatan siber. Dengan melaporkan, Anda ikut membantu memutus rantai penipuan dan melindungi pengguna lain.</li>
</ol>

<h2>Kesimpulan</h2>

<p>Phishing bukanlah ancaman yang akan hilang&mdash;justru ia terus berevolusi seiring kemajuan teknologi. Namun, karena serangan ini pada dasarnya menargetkan <strong>manusia, bukan mesin</strong>, maka pertahanan terbaik juga terletak pada manusianya. Kewaspadaan adalah mata uang utama di era digital. Ingatlah bahwa <strong>keamanan siber dimulai dari jari Anda sendiri</strong>. Setiap tautan yang Anda klik, setiap data yang Anda masukkan, dan setiap lampiran yang Anda buka adalah keputusan keamanan.</p>

<p>Jangan biarkan diri Anda menjadi &ldquo;ikan&rdquo; berikutnya yang terjebak umpan phishing. Jadilah pengguna digital yang cerdas, kritis, dan tangguh.</p>

<p><strong>Sumber:</strong> <em>Instagram Ditjenwasdigi, IT Al Azhar, BSSN, OWASP Foundation.</em></p>
',
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(50, 200),
        ]);

        $this->command->info('Phishing Article created successfully!');
    }
}
