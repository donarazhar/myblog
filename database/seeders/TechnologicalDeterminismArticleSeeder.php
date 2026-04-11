<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class TechnologicalDeterminismArticleSeeder extends Seeder
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

        // Create Technological Determinism article
        Article::create([
            'title' => 'Hidup Kita "Diatur" Teknologi? Memahami Technological Determinism dan Peran Manusia di Era Digital',
            'slug' => 'hidup-kita-diatur-teknologi-memahami-technological-determinism-dan-peran-manusia-di-era-digital',
            'excerpt' => 'Pernahkah Anda merasa pagi hari Anda "disetir" oleh notifikasi ponsel? Fenomena ini bukan sekadar perasaan, melainkan realitas sosiologis. Artikel ini mengupas teori Technological Determinism, bagaimana teknologi membentuk perilaku kita, dan cara menjadi pengguna yang berdaya di tengah arus digitalisasi.',
            'content' => '
<p>Pernahkah Anda merasa seolah-olah pagi hari Anda &ldquo;disetir&rdquo; oleh notifikasi ponsel? Atau merasa ada yang kurang jika satu jam saja tidak terhubung dengan internet? Mungkin Anda pernah membatalkan rencana membaca buku karena terlalu asyik menggulir media sosial, atau tanpa sadar menghabiskan dua jam menonton video pendek yang awalnya hanya ingin dilihat &ldquo;sebentar saja&rdquo;.</p>

<p>Fenomena ini bukan sekadar perasaan emosional belaka. Ini adalah sebuah <strong>realitas sosiologis</strong> yang memiliki landasan teori kuat dan telah dipelajari oleh para ilmuwan selama lebih dari setengah abad.</p>

<p>Infografis terbaru dari <strong>Information Technology of Al Azhar</strong> mengangkat sebuah pertanyaan reflektif yang sangat relevan untuk zaman kita: <em>&ldquo;Hidup kita &lsquo;diatur&rsquo; teknologi?&rdquo;</em>. Untuk menjawabnya, kita perlu menyelam lebih dalam ke sebuah konsep yang disebut <strong>Technological Determinism</strong>.</p>

<h2>🔍 Apa Itu Technological Determinism?</h2>

<p>Secara sederhana, <strong>Technological Determinism</strong> adalah sebuah teori yang menyatakan bahwa perkembangan teknologi secara langsung membentuk dan memengaruhi struktur sosial serta budaya masyarakat. Teori ini pertama kali dipopulerkan oleh <strong>Marshall McLuhan</strong>, seorang filsuf komunikasi asal Kanada, pada tahun 1960-an melalui kalimat terkenalnya: <em>&ldquo;The medium is the message&rdquo;</em> &mdash; yang artinya, media (teknologi) itu sendiri lebih berpengaruh daripada konten yang dibawanya.</p>

<p>Bayangkan seperti ini: <strong>penemuan mesin cetak oleh Gutenberg</strong> pada abad ke-15 tidak hanya mengubah cara kita mencetak buku. Ia mengubah <em>segalanya</em> &mdash; munculnya gerakan Reformasi Protestan, menyebarnya ilmu pengetahuan ke masyarakat umum, lahirnya konsep kebebasan pers, hingga tumbuhnya demokrasi modern. Satu penemuan teknologi, dampaknya mengubah peradaban.</p>

<p>Hal yang sama terjadi hari ini. Kehadiran <strong>smartphone</strong> bukan sekadar menggantikan telepon rumah. Ia mengubah cara kita berkencan (swipe kanan-kiri), cara kita belajar (YouTube dan Google menggantikan ensiklopedia), cara kita bekerja (Zoom menggantikan ruang rapat), bahkan cara kita memandang diri sendiri (jumlah &ldquo;like&rdquo; menjadi validasi sosial).</p>

<p>Artinya, bukan hanya kita yang menciptakan teknologi, tetapi teknologi yang kita ciptakan akhirnya berbalik <strong>&ldquo;menciptakan&rdquo;</strong> cara kita hidup.</p>

<h2>⚖️ Dua Kubu: Determinisme Keras vs. Determinisme Lunak</h2>

<p>Dalam memahami teori ini, para pemikir terbagi menjadi dua perspektif yang penting untuk kita pahami:</p>

<table>
    <thead>
        <tr>
            <th>Aspek</th>
            <th>Determinisme Keras (<em>Hard</em>)</th>
            <th>Determinisme Lunak (<em>Soft</em>)</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>Pandangan</strong></td>
            <td>Teknologi adalah kekuatan otonom yang mengubah masyarakat secara tak terelakkan.</td>
            <td>Teknologi memengaruhi masyarakat, tapi manusia tetap punya pilihan dan kendali.</td>
        </tr>
        <tr>
            <td><strong>Contoh</strong></td>
            <td>&ldquo;Media sosial <em>pasti</em> membuat anak muda depresi.&rdquo;</td>
            <td>&ldquo;Media sosial <em>bisa</em> menyebabkan depresi jika digunakan tanpa batas dan tanpa literasi digital.&rdquo;</td>
        </tr>
        <tr>
            <td><strong>Tokoh</strong></td>
            <td>Marshall McLuhan, Jacques Ellul</td>
            <td>Neil Postman, Langdon Winner</td>
        </tr>
        <tr>
            <td><strong>Sikap</strong></td>
            <td>Pesimistis &mdash; manusia adalah &ldquo;korban&rdquo; teknologi.</td>
            <td>Realistis &mdash; manusia bisa berdaya jika memiliki kesadaran.</td>
        </tr>
    </tbody>
</table>

<p>Perspektif yang paling sehat untuk dipegang adalah <strong>determinisme lunak</strong>: mengakui bahwa teknologi memang memiliki kekuatan besar untuk membentuk perilaku kita, tetapi kita <em>masih</em> punya pilihan untuk menentukan bagaimana kita meresponsnya.</p>

<h2>🔄 Evolusi Teknologi: Pergeseran Gaya Hidup Lama ke Baru</h2>

<p>Kita sedang berada dalam fase transisi besar-besaran. Pergeseran ini tidak hanya terjadi pada alat yang kita gunakan, tapi pada <strong>pola perilaku</strong> dan <strong>nilai-nilai</strong> kita sehari-hari:</p>

<h3>1. Komunikasi: Dari Sabar Menunggu ke Instan Menuntut</h3>
<p>Dulu kita harus menunggu berhari-hari, bahkan berminggu-minggu, untuk sebuah balasan melalui <strong>surat fisik</strong>. Kini, <strong>email</strong> dan pesan instan memungkinkan koordinasi terjadi dalam hitungan detik. Namun, ada harga yang kita bayar: budaya &ldquo;harus dibalas sekarang juga&rdquo; yang menciptakan <strong>tekanan sosial yang tidak sehat</strong>. Pesan yang belum dibalas dalam 10 menit saja sudah menimbulkan kecemasan &mdash; fenomena yang oleh psikolog disebut sebagai <em>&ldquo;always-on anxiety&rdquo;</em>.</p>

<h3>2. Konektivitas: Dari Satu Titik ke Tanpa Batas</h3>
<p>Era <strong>telepon rumah</strong> yang membatasi komunikasi pada satu titik lokasi telah berganti menjadi era <strong>smartphone</strong>, di mana kita bisa terhubung kapan saja dan di mana saja. Dampak positifnya luar biasa: seorang petani di pelosok bisa langsung menjual hasil panennya melalui marketplace. Namun, sisi gelapnya adalah hilangnya batas antara &ldquo;waktu kerja&rdquo; dan &ldquo;waktu pribadi&rdquo;. Bos bisa mengirim pesan WhatsApp tengah malam, dan kita merasa <em>wajib</em> membalasnya.</p>

<h3>3. Informasi: Dari Kurasi ke Banjir Informasi</h3>
<p>Konsumsi berita dari <strong>koran atau majalah</strong> cetak yang melalui proses kurasi editorial kini telah bergeser ke <strong>portal berita online</strong> dan media sosial yang menawarkan pembaruan informasi secara <em>real-time</em>. Kecepatan ini datang dengan risiko besar: <strong>misinformasi</strong> dan <strong>hoaks</strong> menyebar lebih cepat daripada fakta. Sebuah studi dari MIT menemukan bahwa berita palsu menyebar <strong>6 kali lebih cepat</strong> dibandingkan berita yang benar di platform media sosial.</p>

<h3>4. Produktivitas: Dari Tenaga Manusia ke Kecerdasan Buatan</h3>
<p>Tugas-tugas yang dulu sepenuhnya mengandalkan <strong>tenaga manusia</strong> kini mulai didukung oleh <strong>AI (Artificial Intelligence) dan otomasi</strong>. ChatGPT bisa menulis esai dalam 30 detik, Midjourney bisa membuat ilustrasi tanpa seorang ilustrator, dan robot di pabrik bisa bekerja 24 jam tanpa istirahat. Ini memunculkan pertanyaan eksistensial: <em>&ldquo;Jika mesin bisa melakukan pekerjaan saya, apa peran saya sebagai manusia?&rdquo;</em></p>

<p>Perubahan ini memang membuat hidup terasa lebih cepat dan efisien, namun seringkali menimbulkan satu pertanyaan besar: <strong><em>Apakah kita masih memegang kendali?</em></strong></p>

<h2>🧠 Bukti Nyata: Bagaimana Teknologi Sudah &ldquo;Mengatur&rdquo; Perilaku Kita</h2>

<p>Jika Anda masih ragu apakah teknologi benar-benar memengaruhi perilaku, perhatikan contoh-contoh berikut yang mungkin Anda alami sendiri setiap hari:</p>

<ul>
    <li><strong>Scrolling Tanpa Tujuan:</strong> Rata-rata orang Indonesia menghabiskan <strong>3 jam 46 menit per hari</strong> di media sosial (Data We Are Social, 2024). Sebagian besar dari waktu itu dihabiskan untuk menggulir konten tanpa tujuan yang jelas. Ini bukan kebetulan &mdash; platform media sosial sengaja didesain menggunakan mekanisme <em>infinite scroll</em> dan <em>variable reward</em> (seperti mesin slot) untuk membuat kita ketagihan.</li>

    <li><strong>Notifikasi yang Mendikte:</strong> Sebuah studi dari Duke University menunjukkan bahwa rata-rata pengguna smartphone menerima <strong>65-80 notifikasi per hari</strong>. Setiap notifikasi memecah konsentrasi kita, dan dibutuhkan rata-rata <strong>23 menit</strong> untuk kembali fokus setelah satu kali gangguan.</li>

    <li><strong>FOMO (Fear of Missing Out):</strong> Melihat teman-teman posting liburan di Instagram secara tidak sadar menciptakan perasaan &ldquo;tertinggal&rdquo;. Ini mendorong perilaku konsumtif dan perbandingan sosial yang merusak kesehatan mental.</li>

    <li><strong>Filter Bubble:</strong> Algoritma media sosial menyajikan konten yang sesuai dengan preferensi kita. Akibatnya, kita terjebak dalam &ldquo;gelembung&rdquo; informasi yang mempersempit wawasan dan memperkuat bias yang sudah ada. Ini yang disebut <em>echo chamber</em>.</li>

    <li><strong>Phantom Vibration:</strong> Pernahkah merasa ponsel Anda bergetar di saku, padahal sebenarnya tidak? Fenomena ini dialami oleh <strong>89% pengguna smartphone</strong> dan menunjukkan betapa dalamnya teknologi sudah tertanam dalam sistem saraf kita.</li>
</ul>

<h2>🛠️ Hakikat Teknologi: Alat untuk Membantu, Bukan Menggantikan</h2>

<p>Di tengah kekhawatiran akan dominasi teknologi atau ancaman AI yang menggantikan pekerjaan, kita perlu kembali pada hakikat dasar teknologi itu sendiri. Infografis dari IT Al Azhar mengingatkan kita pada tiga prinsip penting:</p>

<h3>1. Teknologi sebagai Akselerator Kerja</h3>
<p>Teknologi ada untuk membantu manusia bekerja lebih cepat, tepat, dan efektif. Ia adalah <strong>&ldquo;pengungkit&rdquo; (leverage)</strong> produktivitas kita. Contoh nyata: seorang akuntan yang dulu membutuhkan 3 hari untuk menyusun laporan keuangan, kini bisa menyelesaikannya dalam 3 jam dengan bantuan spreadsheet dan software akuntansi. Pekerjaannya tidak hilang &mdash; tapi <em>diakselerasi</em>.</p>

<h3>2. Teknologi sebagai Pengoptimal Potensi</h3>
<p>Alih-alih membatasi, teknologi seharusnya mengoptimalkan potensi dan kreativitas manusia. AI, misalnya, dapat mengambil alih tugas-tugas rutin dan repetitif (entri data, sortir email, jadwal rapat) sehingga manusia bisa fokus pada apa yang benar-benar membutuhkan sentuhan manusia: <strong>pemikiran strategis, empati, kreativitas, dan pengambilan keputusan etis</strong>. Ini yang disebut sebagai <em>&ldquo;augmented intelligence&rdquo;</em> &mdash; kecerdasan buatan yang <em>menambah</em> kemampuan manusia, bukan menggantikannya.</p>

<h3>3. Teknologi sebagai Wujud Proses Belajar</h3>
<p>Perkembangan teknologi adalah bukti nyata dari <em>progress</em> dan hasil dari proses belajar manusia yang terus berlanjut tanpa henti. Dari roda, mesin uap, listrik, internet, hingga AI &mdash; setiap teknologi baru lahir dari rasa ingin tahu dan semangat pemecahan masalah yang menjadi ciri khas manusia. Kita bukan korban perkembangan &mdash; kita adalah <strong>penciptanya</strong>.</p>

<blockquote>
    <p><strong>Catatan Penting:</strong> Teknologi adalah alat (<em>tool</em>). Sehebat apa pun alatnya, kualitas hasilnya tetap bergantung pada siapa yang mengoperasikannya. Pisau di tangan koki menghasilkan hidangan lezat. Pisau yang sama, di tangan yang salah, bisa menjadi senjata. Demikian pula dengan teknologi.</p>
</blockquote>

<h2>🧭 Panduan Praktis: Menjadi Pengguna yang Berdaya</h2>

<p>Menyadari bahwa teknologi memengaruhi perilaku kita adalah langkah pertama. Langkah selanjutnya adalah mengambil tindakan nyata. Berikut panduan praktis yang bisa Anda terapkan mulai hari ini:</p>

<h3>A. Digital Mindfulness (Kesadaran Digital)</h3>
<ul>
    <li><strong>Audit Waktu Layar:</strong> Cek fitur <em>Screen Time</em> di ponsel Anda. Catat berapa jam yang dihabiskan untuk media sosial vs. aktivitas produktif. Jika lebih dari 2 jam untuk media sosial, saatnya evaluasi.</li>
    <li><strong>Aturan 20-20-20:</strong> Setiap 20 menit menatap layar, lihat sesuatu berjarak 20 kaki (6 meter) selama 20 detik untuk menjaga kesehatan mata dan pikiran.</li>
    <li><strong>Tech-Free Zone:</strong> Tetapkan zona bebas gadget di rumah Anda &mdash; misalnya meja makan dan kamar tidur. Ini membantu memisahkan waktu digital dan waktu personal.</li>
</ul>

<h3>B. Kelola Notifikasi dengan Tegas</h3>
<ul>
    <li><strong>Matikan notifikasi non-esensial.</strong> Hanya aktifkan notifikasi untuk telepon, pesan dari keluarga, dan aplikasi kerja utama. Sisanya? Cek secara manual di waktu yang Anda tentukan sendiri.</li>
    <li><strong>Batch Processing:</strong> Alih-alih merespons setiap notifikasi saat itu juga, kumpulkan dan proses pesan/email dalam blok waktu tertentu (misalnya pukul 09.00, 13.00, dan 17.00).</li>
</ul>

<h3>C. Konsumsi Informasi Secara Sadar</h3>
<ul>
    <li><strong>Pilih sumber informasi.</strong> Berlanggananlah ke 2-3 media kredibel dan batasi konsumsi berita dari timeline media sosial yang tidak terkurasi.</li>
    <li><strong>Terapkan prinsip SIFT:</strong> <strong>S</strong>top (berhenti sebelum membagikan), <strong>I</strong>nvestigate (cek sumbernya), <strong>F</strong>ind better coverage (cari sumber lain), <strong>T</strong>race claims (telusuri klaim aslinya).</li>
    <li><strong>Digital Detox berkala:</strong> Luangkan satu hari dalam seminggu untuk &ldquo;puasa digital&rdquo; &mdash; jauh dari media sosial dan berita online. Gunakan waktu tersebut untuk membaca buku, berolahraga, atau berinteraksi langsung dengan orang di sekitar Anda.</li>
</ul>

<h3>D. Gunakan Teknologi untuk Tujuan yang Jelas</h3>
<ul>
    <li><strong>Sebelum membuka aplikasi, tanyakan:</strong> &ldquo;Apa tujuan saya membuka ini?&rdquo; Jika jawabannya &ldquo;tidak tahu&rdquo; atau &ldquo;cuma iseng&rdquo;, pertimbangkan kembali.</li>
    <li><strong>Manfaatkan teknologi untuk belajar:</strong> Ikuti kursus online, baca e-book, dengarkan podcast edukatif. Jadikan layar Anda sebagai jendela ilmu, bukan lubang waktu.</li>
    <li><strong>Ciptakan, bukan hanya konsumsi:</strong> Daripada hanya menonton dan menggulir, gunakan waktu digital Anda untuk berkreasi &mdash; menulis blog, mendesain, coding, atau membuat konten edukatif.</li>
</ul>

<h2>🌍 Perspektif Islam: Teknologi sebagai Amanah</h2>

<p>Dari sudut pandang Islam, teknologi adalah bagian dari <strong>amanah</strong> yang diberikan Allah kepada manusia sebagai <em>khalifah</em> (pengelola) di muka bumi. Al-Qur&rsquo;an menyebutkan:</p>

<blockquote>
    <p><em>&ldquo;Dan Dia mengajarkan kepada Adam nama-nama (benda-benda) seluruhnya...&rdquo;</em> (QS. Al-Baqarah: 31)</p>
</blockquote>

<p>Ayat ini menunjukkan bahwa kemampuan manusia untuk memahami, menamai, dan mengelola hal-hal di dunia &mdash; termasuk teknologi &mdash; adalah <strong>anugerah ilahi</strong>. Namun, setiap anugerah datang dengan tanggung jawab. Teknologi harus digunakan untuk:</p>

<ul>
    <li><strong>Kebaikan (<em>maslahat</em>):</strong> Menyebarkan ilmu, memudahkan silaturahmi, dan meningkatkan produktivitas ibadah.</li>
    <li><strong>Keadilan:</strong> Mempersempit kesenjangan digital antara kota dan desa, antara yang mampu dan tidak mampu.</li>
    <li><strong>Kebijaksanaan (<em>hikmah</em>):</strong> Menggunakan teknologi dengan penuh pertimbangan, bukan secara impulsif.</li>
</ul>

<p>Prinsipnya, dalam Islam, kita <strong>bukan hamba teknologi, tapi tuan atas teknologi</strong>. Teknologi yang mendekatkan kita pada kebaikan adalah berkah. Teknologi yang menjauhkan kita dari Allah, keluarga, dan diri sendiri adalah ujian yang harus kita kelola.</p>

<h2>🎯 Kesimpulan: Siapa yang Sebenarnya Memegang Remote?</h2>

<p>Jadi, apakah hidup kita diatur oleh teknologi? Jawabannya bergantung pada bagaimana kita memosisikan diri.</p>

<p>Jika kita menggunakan teknologi <strong>tanpa pemahaman, tanpa batas, dan tanpa tujuan</strong>, maka ya &mdash; kita mungkin akan merasa &ldquo;diatur&rdquo;. Kita menjadi penonton pasif yang terhanyut oleh algoritma, terdikte oleh notifikasi, dan terperangkap dalam siklus konsumsi konten tanpa akhir.</p>

<p>Namun, jika kita memahami hakikat teknologi sebagai <strong>alat pendukung</strong> dan menggunakannya dengan <strong>kesadaran penuh</strong>, maka teknologilah yang akan melayani tujuan hidup kita &mdash; bukan sebaliknya.</p>

<p>Ingatlah:</p>

<ul>
    <li><strong>Smartphone</strong> Anda adalah alat yang bisa membuka pintu ilmu seluas samudra, atau lubang kelinci yang membuang waktu berjam-jam &mdash; <em>Anda yang memilih</em>.</li>
    <li><strong>AI</strong> bisa menjadi asisten yang membebaskan Anda dari tugas membosankan, atau menjadi alasan Anda berhenti berpikir kritis &mdash; <em>Anda yang menentukan</em>.</li>
    <li><strong>Media sosial</strong> bisa menjadi jembatan silaturahmi dan dakwah, atau menjadi panggung validasi dan perbandingan sosial &mdash; <em>Anda yang memutuskan</em>.</li>
</ul>

<p>Mari terus belajar, tetap terkoneksi, dan gunakan teknologi untuk kemajuan bersama &mdash; tanpa kehilangan sisi kemanusiaan kita. Karena pada akhirnya, yang membedakan kita dari mesin bukanlah kecepatan atau efisiensi, tapi <strong>hati nurani, empati, dan kemampuan untuk memilih</strong>.</p>

<blockquote>
    <p><em>&ldquo;Teknologi terbaik adalah teknologi yang kita kuasai, bukan teknologi yang menguasai kita.&rdquo;</em></p>
</blockquote>
',
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(50, 200),
        ]);

        $this->command->info('Technological Determinism Article created successfully!');
    }
}
