<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class KedaulatanDigitalArticleSeeder extends Seeder
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

        // Create Kedaulatan Digital article
        Article::create([
            'title'        => 'Kedaulatan Digital: Membangun Istana di Tanah Sendiri, Bukan Menyewa di Tanah Orang',
            'slug'         => 'kedaulatan-digital-membangun-istana-di-tanah-sendiri',
            'excerpt'      => 'Jika internet cepat adalah napas peradaban digital kita, maka kemandirian teknologi adalah jiwanya. Artikel ini membongkar jebakan ketergantungan pada vendor, menjelaskan mengapa Laboratorium IT internal bukan sekadar ruangan komputer, dan memetakan langkah konkret menuju kedaulatan digital yang sesungguhnya—ditulis khusus agar mudah dipahami oleh pimpinan sekolah, yayasan, dan kantor.',
            'content'      => '
<p>Artikel ini adalah kelanjutan dari manifesto <a href="/artikel/internet-cepat-buat-apa-menjawab-skeptisisme-akselerasi-transformasi-digital"><em>"Internet Cepat Buat Apa?"</em></a>. Jika bagian pertama membahas pembangunan <strong>jalan raya digital</strong> yang lebar dan tanpa hambatan, maka bagian kedua ini menjawab pertanyaan yang lebih mendasar: <em>siapa yang seharusnya memiliki kendaraan dan bangunan di atas jalan tersebut?</em></p>

<blockquote>
    <p><strong>Analogi Sederhana untuk Pimpinan:</strong> Bayangkan Anda baru saja membangun jalan tol mewah di depan kantor Anda. Namun ternyata, mobil yang Anda pakai setiap hari adalah <em>mobil sewaan</em>—kunci cadangan dipegang oleh rental, servis hanya boleh di bengkel mereka, dan jika mereka tutup, Anda tidak bisa kemana-mana. Itulah kondisi sebuah institusi yang bergantung sepenuhnya pada vendor teknologi luar.</p>
</blockquote>

<h2>Apa Itu Kedaulatan Digital dan Mengapa Penting?</h2>

<p>Kedaulatan digital adalah kondisi di mana sebuah organisasi <strong>memiliki kendali penuh</strong> atas teknologi yang digunakannya—mulai dari aplikasi, data, infrastruktur server, hingga kemampuan sumber daya manusianya. Ini bukan soal anti-teknologi atau anti-vendor. Ini soal <strong>siapa yang memegang kendali</strong> ketika terjadi masalah.</p>

<p>Membangun ekosistem digital yang canggih namun bergantung sepenuhnya pada pihak ketiga adalah sebuah ironi strategis: kita sedang membangun <strong>gedung pencakar langit digital yang mewah</strong>, namun sertifikat tanah dan kunci pintunya dipegang oleh orang asing.</p>

<h2>1. Jebakan Vendor: Membeli Solusi, Tanpa Disadari Menyewa Ketergantungan</h2>

<p>Selama bertahun-tahun, pola pikir yang lazim adalah: <em>"Ada kebutuhan aplikasi? Cari vendor."</em> Namun dalam transformasi digital yang fundamental, vendor seharusnya menjadi <strong>akselerator</strong>—pendorong percepatan—bukan <strong>tumpuan hidup</strong> yang kita tidak bisa lepas.</p>

<p>Mari kita bedah tiga jebakan terbesar yang sering tidak disadari oleh pimpinan:</p>

<h3>Jebakan 1: Biaya Tersembunyi yang Tidak Berujung</h3>

<p>Vendor sering menawarkan harga awal yang tampak terjangkau. Namun setelah kontrak ditandatangani, muncul biaya-biaya lain yang tidak pernah dihitung di awal:</p>

<ul>
    <li><strong>Biaya perawatan tahunan (maintenance):</strong> Biasanya 15–20% dari harga awal, setiap tahun.</li>
    <li><strong>Biaya pembaruan (upgrade):</strong> Ketika ada peraturan baru atau kebutuhan baru, fitur tambahan tidak gratis.</li>
    <li><strong>Biaya kustomisasi:</strong> Ingin mengubah tampilan atau menambah kolom data? Ada harga tersendiri.</li>
    <li><strong>Biaya "hostage":</strong> Karena hanya vendor yang tahu cara kerja sistemnya, Anda tidak punya pilihan selain terus membayar.</li>
</ul>

<blockquote>
    <p><strong>Ilustrasi Nyata:</strong> Sebuah yayasan pendidikan membayar Rp 300 juta untuk aplikasi absensi dari vendor. Tahun berikutnya: Rp 60 juta untuk maintenance. Tahun ketiga: vendor menaikkan harga jadi Rp 90 juta karena "server upgrade." Dalam 5 tahun, total pengeluaran mencapai Rp 650 juta—dan yayasan masih tidak memiliki apapun jika kontrak berakhir.</p>
</blockquote>

<h3>Jebakan 2: Risiko "Kotak Hitam" (Black Box)</h3>

<p>Ketika aplikasi dibangun oleh pihak luar tanpa keterlibatan tim internal, kita memiliki <em>datanya</em> tetapi tidak memahami <em>"mesin" di baliknya</em>. Ini seperti memiliki mobil mewah namun tidak tahu di mana letak mesinnya—apalagi cara memperbaikinya jika mogok di tengah jalan.</p>

<p>Risikonya nyata dan serius:</p>

<ul>
    <li>Jika vendor tersebut <strong>tutup atau bangkrut</strong>, sistem Anda berhenti berfungsi dan tidak ada yang bisa memperbaikinya.</li>
    <li>Jika vendor <strong>menaikkan harga sepihak</strong>, Anda tidak punya pilihan selain membayar atau kehilangan akses ke data operasional Anda sendiri.</li>
    <li>Jika terjadi <strong>kebocoran data</strong>, Anda tidak bisa investigasi mandiri karena tidak mengerti cara kerja sistemnya.</li>
</ul>

<h3>Jebakan 3: Keamanan yang Rapuh dan Respons yang Lambat</h3>

<p>Belajar dari berbagai insiden serangan siber yang terjadi di institusi pendidikan Indonesia, ketergantungan pada pihak luar membuat respons kita sangat lambat. Ketika data siswa sedang bocor pukul 2 dini hari, kita tidak bisa menunggu email balasan dari tim support vendor yang baru buka kantor pukul 9 pagi.</p>

<table>
    <thead>
        <tr>
            <th>Situasi Darurat</th>
            <th>Dengan Ketergantungan Vendor</th>
            <th>Dengan Kemandirian Internal</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Server down pukul 02.00</td>
            <td>Kirim email, tunggu respons jam kerja vendor</td>
            <td>Tim internal langsung tangani dalam menit</td>
        </tr>
        <tr>
            <td>Ada celah keamanan ditemukan</td>
            <td>Lapor vendor, tunggu jadwal perbaikan mereka</td>
            <td>Tim langsung tutup celah saat itu juga</td>
        </tr>
        <tr>
            <td>Butuh fitur baru mendesak</td>
            <td>Negosiasi kontrak, antri pengerjaan</td>
            <td>Tim internal kerjakan sesuai prioritas lembaga</td>
        </tr>
        <tr>
            <td>Data perlu diaudit mendadak</td>
            <td>Minta laporan dari vendor, bayar biaya tambahan</td>
            <td>Akses langsung ke database kapan saja</td>
        </tr>
    </tbody>
</table>

<h2>2. Perubahan Cara Pandang yang Harus Terjadi</h2>

<p>Kedaulatan digital dimulai bukan dari anggaran, tapi dari <strong>cara pandang pimpinan</strong>. Berikut pergeseran pola pikir yang perlu terjadi:</p>

<table>
    <thead>
        <tr>
            <th>Cara Pandang Lama</th>
            <th>Cara Pandang Baru</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>"Kita sudah pakai aplikasi vendor internasional, pasti aman."</td>
            <td>"Kita tidak punya akses ke kode sumber—kita bergantung penuh, bukan aman."</td>
        </tr>
        <tr>
            <td>"Tidak ada SDM yang bisa buat aplikasi sendiri."</td>
            <td>"Kita harus investasi membangun SDM itu—itu lebih murah daripada ketergantungan selamanya."</td>
        </tr>
        <tr>
            <td>"Beli aplikasi jadi lebih cepat dan praktis."</td>
            <td>"Bangun kapasitas internal lebih lambat di awal, tapi menghasilkan puluhan aplikasi di kemudian hari."</td>
        </tr>
        <tr>
            <td>"Masalah IT urusan vendor."</td>
            <td>"Masalah IT urusan kita—vendor hanya membantu, bukan bertanggung jawab."</td>
        </tr>
    </tbody>
</table>

<blockquote>
    <p><strong>Pernyataan Kedaulatan:</strong><br>
    <em>Dulu:</em> "Kami sudah menggunakan aplikasi terbaru dari vendor internasional." <em>(Pimpinan merasa tenang, padahal tidak punya kendali apapun).</em><br>
    <em>Sekarang:</em> "Kami memiliki kode sumber aplikasi sendiri—jika ada kendala jam 2 pagi, tim internal langsung perbaiki tanpa menunggu siapapun." <strong>Inilah kedaulatan digital yang sesungguhnya.</strong></p>
</blockquote>

<h2>3. Laboratorium IT: "Pabrik Inovasi" Milik Yayasan</h2>

<p>Kemandirian tidak lahir dari instruksi, melainkan dari ekosistem. Solusi konkretnya adalah mendirikan <strong>Laboratorium Pembelajaran IT</strong> sebagai pusat Riset &amp; Pengembangan (R&amp;D) milik yayasan sendiri.</p>

<p>Penting untuk dipahami: <strong>ini bukan sekadar ruangan berisi komputer.</strong> Ini adalah "dapur" tempat inovasi diracik, tempat tim internal belajar membangun solusi nyata yang 100% sesuai kebutuhan lembaga.</p>

<h3>Apa yang Dihasilkan oleh Lab IT Ini?</h3>

<p>Berikut perbandingan yang perlu dipahami pimpinan dalam bahasa investasi:</p>

<table>
    <thead>
        <tr>
            <th>Skenario</th>
            <th>Anggaran Rp 500 Juta</th>
            <th>Hasil yang Didapat</th>
            <th>Jangka Panjang</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>Beli dari Vendor</strong></td>
            <td>Rp 500 juta</td>
            <td>1 aplikasi pendaftaran siswa</td>
            <td>Bayar maintenance selamanya, tidak punya aset</td>
        </tr>
        <tr>
            <td><strong>Bangun Lab IT Internal</strong></td>
            <td>Rp 500 juta</td>
            <td>Server + pelatihan tim = mampu buat 5–10 aplikasi per tahun</td>
            <td>Aset bertumbuh, tidak ada ketergantungan</td>
        </tr>
    </tbody>
</table>

<h3>Empat Pilar yang Dikuasai Lab IT</h3>

<p>Agar pimpinan mendapat gambaran yang konkret, laboratorium ini berfokus pada penguasaan empat pilar berikut:</p>

<ol>
    <li>
        <strong>Arsitektur Aplikasi Modern (Laravel)</strong><br>
        <em>Bahasa awamnya:</em> Tim kita belajar "bahasa" yang digunakan untuk membangun hampir semua aplikasi web modern. Dengan ini, kita bisa membuat sistem absensi, pendaftaran, keuangan, hingga e-learning sendiri—100% sesuai budaya dan kebutuhan Al Azhar, bukan aplikasi "generik" dari vendor yang dipaksakan masuk.
    </li>
    <li>
        <strong>Manajemen Server dan Cloud (DevOps)</strong><br>
        <em>Bahasa awamnya:</em> Ini seperti belajar cara mengelola "gudang digital" kita sendiri. Data tidak pernah hilang, sistem selalu aktif 24 jam sehari 7 hari seminggu, dan kita tidak perlu membayar biaya "titip server" ke pihak luar.
    </li>
    <li>
        <strong>Keamanan Siber dari Dalam (Proactive Security)</strong><br>
        <em>Bahasa awamnya:</em> Bukan sekadar memasang gembok di pintu (antivirus), tapi membangun tembok yang kuat dari dalam pondasi bangunannya (kode aplikasi). Ancaman siber dicegah sejak awal, bukan ditangani setelah terjadi.
    </li>
    <li>
        <strong>Otomatisasi dan Kecerdasan Buatan (AI &amp; Automation)</strong><br>
        <em>Bahasa awamnya:</em> Mengajarkan tim untuk membuat "robot digital" yang mengerjakan tugas berulang dan membosankan—input data, laporan rutin, notifikasi otomatis—sehingga staf bisa fokus pada pekerjaan yang lebih bernilai dan kreatif.
    </li>
</ol>

<h2>4. Visi Konkret: Satu Wajah untuk Segalanya (Face-as-a-Service SSO)</h2>

<p>Salah satu proyek percontohan paling ambisius yang hanya bisa terwujud jika kita memegang kendali penuh atas sistem adalah <strong>Face-as-a-Service Single Sign-On (FaaS SSO)</strong>.</p>

<p>Bayangkan skenario ini:</p>

<ul>
    <li>Seorang guru tiba di sekolah → wajahnya terdeteksi kamera → absensi tercatat otomatis.</li>
    <li>Siswa masuk perpustakaan → scan wajah → akses pintu terbuka, peminjaman buku tercatat.</li>
    <li>Siswa ke kantin → scan wajah → pembayaran dipotong dari saldo orang tua.</li>
    <li>Semua dari <strong>satu sistem, satu database, satu identitas digital</strong>—berlaku di seluruh cabang Al Azhar di Indonesia.</li>
</ul>

<p>Proyek sebesar ini <strong>mustahil dipercayakan ke vendor luar</strong>. Data biometrik wajah adalah data paling sensitif yang ada. Jika kita tidak memegang kode sumbernya, kita tidak tahu siapa lagi yang bisa mengakses data wajah anak-anak kita.</p>

<blockquote>
    <p><strong>Inilah mengapa Lab IT bukan sekadar "penghematan biaya"—ia adalah benteng perlindungan data dan aset strategis jangka panjang.</strong></p>
</blockquote>

<h2>5. Langkah Konkret yang Bisa Diputuskan Pimpinan Hari Ini</h2>

<p>Transformasi menuju kedaulatan digital tidak harus dilakukan sekaligus. Berikut tiga langkah bertahap yang terukur:</p>

<h3>Langkah 1: Audit Ketergantungan (Bulan 1–2)</h3>
<p>Buat daftar seluruh aplikasi yang saat ini digunakan dan tanyakan untuk setiap aplikasi:</p>
<ul>
    <li>Apakah kita memiliki <em>kode sumber</em> (source code)-nya?</li>
    <li>Berapa total biaya yang sudah dan akan kita bayar ke vendor ini dalam 5 tahun?</li>
    <li>Apa yang terjadi jika vendor ini tiba-tiba berhenti beroperasi?</li>
</ul>
<p>Jawaban dari pertanyaan-pertanyaan ini akan mengungkap seberapa dalam kita sudah "terperangkap."</p>

<h3>Langkah 2: Peresmian Lab R&amp;D dan Proyek Percontohan (Bulan 3–6)</h3>
<p>Tetapkan satu ruangan, rekrut atau tunjuk 2–3 staf IT yang akan dikembangkan, dan mulai dengan satu proyek percontohan yang hasilnya bisa langsung dirasakan oleh pimpinan—misalnya sistem absensi Face-ID yang dibangun sepenuhnya secara internal.</p>

<h3>Langkah 3: Migrasi Bertahap (Bulan 6–24)</h3>
<p>Satu per satu, aplikasi dari vendor yang sudah habis masa kontraknya digantikan dengan versi yang dibangun oleh tim internal. Tidak perlu terburu-buru—yang penting prosesnya konsisten dan terencana.</p>

<h2>Penutup: Membeli Masa Depan, Bukan Sekadar Membeli Alat</h2>

<p>Transformasi digital yang sejati bukan tentang <em>seberapa banyak alat yang kita beli</em>, tapi <em>seberapa banyak kemampuan yang kita miliki di dalam organisasi</em>.</p>

<p>Ada dua jenis institusi di era digital ini:</p>

<ol>
    <li><strong>Institusi yang menjadi konsumen teknologi</strong>—selalu membayar, selalu bergantung, tidak pernah punya kendali.</li>
    <li><strong>Institusi yang menjadi produsen teknologi</strong>—membangun, memiliki, dan mengendalikan ekosistem digitalnya sendiri.</li>
</ol>

<p>YPI Al Azhar, dengan skala dan sumber dayanya, memiliki semua prasyarat untuk menjadi yang kedua. Yang dibutuhkan hanyalah <strong>keputusan strategis dari pimpinan</strong> untuk memulai perjalanan ini.</p>

<blockquote>
    <p>Jika kita terus mengandalkan vendor, kita akan selamanya menjadi <strong>pengikut yang membayar upeti</strong>. Namun, dengan membangun infrastruktur internet yang cepat dan memperkuat kemandirian melalui Laboratorium IT, YPI Al Azhar akan berdiri sebagai <strong>pemilik</strong> peradaban digitalnya sendiri.</p>
    <p>Mari kita berhenti bertanya <em>"aplikasi apa yang bisa kita beli?"</em> dan mulailah bertanya: <strong>"Inovasi apa yang bisa kita ciptakan hari ini?"</strong></p>
</blockquote>

<h2>Ringkasan Eksekutif untuk Pimpinan</h2>

<table>
    <thead>
        <tr>
            <th>Aspek</th>
            <th>Kondisi Saat Ini (Bergantung Vendor)</th>
            <th>Kondisi Ideal (Kedaulatan Digital)</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Kepemilikan aplikasi</td>
            <td>Vendor memiliki kode sumber</td>
            <td>Lembaga memiliki kode sumber sendiri</td>
        </tr>
        <tr>
            <td>Biaya jangka panjang</td>
            <td>Terus membayar, tidak punya aset</td>
            <td>Investasi awal, aset bertumbuh</td>
        </tr>
        <tr>
            <td>Respons insiden</td>
            <td>Tunggu vendor, bisa berhari-hari</td>
            <td>Tim internal, dalam hitungan menit</td>
        </tr>
        <tr>
            <td>Keamanan data</td>
            <td>Bergantung pada kebijakan vendor</td>
            <td>Dikendalikan penuh oleh lembaga</td>
        </tr>
        <tr>
            <td>Inovasi baru</td>
            <td>Minta vendor, negosiasi biaya, antre</td>
            <td>Tim internal kerjakan sesuai visi lembaga</td>
        </tr>
        <tr>
            <td>Kapasitas SDM</td>
            <td>Stagnasi, bergantung pihak luar</td>
            <td>Tumbuh, menjadi aset organisasi</td>
        </tr>
    </tbody>
</table>
',
            'user_id'      => $admin->id,
            'category_id'  => $category->id,
            'status'       => 'published',
            'published_at' => now(),
            'views'        => rand(50, 200),
        ]);

        $this->command->info('Kedaulatan Digital Article created successfully!');
    }
}
