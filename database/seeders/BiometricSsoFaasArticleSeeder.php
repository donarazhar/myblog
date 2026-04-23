<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class BiometricSsoFaasArticleSeeder extends Seeder
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

        // Create Biometric SSO FaaS article
        Article::create([
            'title' => 'Al Azhar Biometric SSO: Mentransformasi "Face as a Service" Menjadi Unified Identity Provider',
            'slug' => 'al-azhar-biometric-sso-face-as-a-service-unified-identity-provider',
            'excerpt' => 'Ketika wajah bukan lagi sekadar penanda kehadiran, melainkan kunci tunggal yang membuka seluruh ekosistem digital institusi — itulah revolusi identitas yang sesungguhnya. Artikel ini membedah arsitektur, strategi, dan roadmap implementasi Face as a Service (FaaS) sebagai Unified Identity Provider di lingkungan YPI Al Azhar.',
            'content' => '
<p>Dunia pendidikan dan manajemen institusi sedang berada di ambang revolusi identitas digital. <strong>YPI Al Azhar</strong>, yang telah sukses menginisiasi digitalisasi kehadiran melalui rekam wajah terintegrasi HRIS, kini duduk di atas tambang emas data biometrik yang belum dieksploitasi secara penuh. Setiap hari, ribuan <em>face descriptor</em> &mdash; representasi matematis 128-dimensi dari wajah pegawai &mdash; dihasilkan oleh sistem absensi. Namun, data tersebut masih terkunci dalam satu fungsi tunggal: mencatat jam masuk dan jam pulang.</p>

<p>Di sisi lain, tantangan besar muncul seiring ekspansi ekosistem digital internal. Setiap aplikasi baru &mdash; portal guru, sistem keuangan, manajemen aset, e-learning &mdash; membangun <em>authentication silo</em>-nya sendiri. Pegawai menghafal belasan <em>username</em> dan <em>password</em> yang berbeda. Tim IT membangun modul login berulang kali dari nol. Dan yang paling kritis: <strong>manajemen kehilangan visibilitas atas siapa melakukan apa, di mana, dan kapan.</strong></p>

<p>Jawabannya bukan lagi sekadar memperbaiki aplikasi absensi. Jawabannya adalah transformasi fundamental: mengubah infrastruktur rekam wajah menjadi <strong>Unified Identity Provider (IdP)</strong> yang mengadopsi konsep <strong>Face as a Service (FaaS)</strong>.</p>

<h2>Konsep &ldquo;Face as a Service&rdquo; (FaaS): Wajah sebagai API</h2>

<p>Dalam arsitektur <em>cloud-native</em> modern, FaaS &mdash; yang kami adopsi dari paradigma <em>Function as a Service</em> &mdash; adalah model di mana <strong>fungsi pengenalan dan verifikasi wajah disediakan sebagai layanan API terstandar</strong> yang siap dikonsumsi oleh aplikasi manapun di dalam organisasi.</p>

<h3>Bagaimana Ini Bekerja?</h3>

<p>Bayangkan sebuah skenario: seorang guru ingin mengakses portal rapor digital. Alih-alih mengetikkan <em>username</em> dan <em>password</em>, ia cukup menatap kamera perangkatnya selama 2 detik. Di balik layar, terjadi orkestrasi yang elegan:</p>

<ol>
    <li><strong>Capture</strong> &mdash; Kamera menangkap citra wajah dan menjalankan <em>Liveness Detection</em> untuk memastikan itu wajah nyata, bukan foto atau video.</li>
    <li><strong>Extract</strong> &mdash; Algoritma <em>face-api.js</em> mengekstrak <em>face descriptor</em> berupa vektor 128 dimensi dari citra tersebut.</li>
    <li><strong>Match</strong> &mdash; Backend menghitung <em>Euclidean Distance</em> antara vektor yang baru diekstrak dengan seluruh <em>descriptor</em> terdaftar di database HRIS.</li>
    <li><strong>Authenticate</strong> &mdash; Jika jarak di bawah <em>threshold</em> (misalnya &lt; 0.6), sistem menerbitkan <strong>Identity Token</strong> berstandar OAuth 2.0 + PKCE.</li>
    <li><strong>Authorize</strong> &mdash; Token tersebut membawa <em>claims</em> tentang identitas, unit kerja, dan hak akses, yang langsung dikenali oleh seluruh aplikasi terintegrasi.</li>
</ol>

<p>Dengan konsep ini, wajah setiap pegawai bertransformasi dari sekadar penanda kehadiran di pagi hari menjadi <strong>&ldquo;kunci digital tunggal&rdquo; (<em>Single Sign-On</em>)</strong> yang membuka akses ke seluruh platform &mdash; tanpa satu pun kata sandi yang perlu dihafal.</p>

<h2>Mengapa YPI Al Azhar Memerlukan Unified Identity Provider?</h2>

<p>Implementasi ini bukan proyek <em>vanity tech</em> &mdash; bukan soal mengejar kecanggihan demi gengsi. Ini adalah <strong>solusi arsitektural atas masalah struktural</strong> yang sudah dan akan terus membesar seiring pertumbuhan digital institusi.</p>

<h3>1. Transparansi &amp; Audit Trail yang Tidak Dapat Disangkal (<em>Non-Repudiation</em>)</h3>

<p>Inilah jantung dari tata kelola berbasis data. Dengan Unified Identity, setiap interaksi digital meninggalkan <strong>Activity Fingerprint</strong> &mdash; jejak yang secara kriptografis terikat pada identitas fisik pengguna.</p>

<p><strong>Kasus Nyata:</strong> Manajemen dapat memantau log secara <em>real-time</em>: <em>&ldquo;Siapa mengubah data keuangan ini, di aplikasi mana, dari perangkat apa, dan pada pukul berapa?&rdquo;</em></p>

<p><strong>Mengapa Ini Berbeda dari Login Biasa:</strong> Dalam sistem konvensional, akun bisa dipindahtangankan &mdash; &ldquo;Pak, tolong login pakai akun saya, saya lupa <em>password</em>.&rdquo; Dengan biometrik, <strong>akuntabilitas bersifat fisik dan personal</strong>. Jika terjadi kesalahan input data atau akses tidak sah pada sistem sensitif (keuangan, kepegawaian), sistem dapat melacak secara akurat identitas <em>fisik</em> pengguna melalui verifikasi wajah terakhir &mdash; bukan sekadar akun yang bisa dipinjamkan.</p>

<blockquote>
    <p><strong>Implikasi Hukum:</strong> Log berbasis biometrik memiliki kekuatan pembuktian (<em>evidentiary weight</em>) yang jauh lebih tinggi dibanding log berbasis <em>username-password</em> dalam konteks audit internal maupun investigasi.</p>
</blockquote>

<h3>2. Analitik Produktivitas &amp; Intelligence Dashboard</h3>

<p>Dengan data login yang terpusat dan terstruktur, YPI Al Azhar mendapatkan <em>insight</em> yang sebelumnya tidak mungkin diperoleh:</p>

<table>
    <thead>
        <tr>
            <th>Dimensi Analitik</th>
            <th>Pertanyaan yang Terjawab</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>Pola Akses Aplikasi</strong></td>
            <td>Aplikasi mana yang paling sering digunakan? Mana yang redundan dan bisa dikonsolidasi?</td>
        </tr>
        <tr>
            <td><strong>Mobilitas Digital</strong></td>
            <td>Bagaimana pola kerja lintas-unit? Apakah ada kolaborasi digital antar departemen?</td>
        </tr>
        <tr>
            <td><strong>Beban Kerja Digital</strong></td>
            <td>Siapa yang <em>overloaded</em> dengan terlalu banyak sistem? Siapa yang belum memanfaatkan tools digital?</td>
        </tr>
        <tr>
            <td><strong>Adopsi Teknologi</strong></td>
            <td>Seberapa cepat staf mengadopsi aplikasi baru? Di mana titik resistensi?</td>
        </tr>
        <tr>
            <td><strong>Anomali Perilaku</strong></td>
            <td>Apakah ada akses di luar jam kerja yang mencurigakan? Apakah ada pola <em>brute-force</em>?</td>
        </tr>
    </tbody>
</table>

<p>Data ini bukan sekadar statistik &mdash; ini adalah <strong>kompas strategis</strong> bagi pengambilan keputusan manajemen tentang investasi IT, pelatihan SDM, dan restrukturisasi proses kerja.</p>

<h3>3. Keamanan Tanpa Kompromi: Menuju Zero Trust Architecture</h3>

<p>Metode <em>username-password</em> adalah <strong>mata rantai terlemah</strong> dalam keamanan digital institusi:</p>

<ul>
    <li><strong>62%</strong> insiden keamanan siber dimulai dari kredensial yang bocor atau lemah (<em>Verizon DBIR Report</em>).</li>
    <li><em>Password</em> bisa lupa, dicuri, ditebak, atau &mdash; yang paling umum di lingkungan kantor &mdash; <strong>dipinjamkan</strong>.</li>
    <li>Satu <em>password</em> yang sama sering digunakan untuk banyak akun (<em>password reuse</em>), sehingga satu kebocoran berpotensi membuka seluruh sistem.</li>
</ul>

<p>Biometrik wajah mengeliminasi seluruh kategori risiko ini sekaligus. Wajah tidak bisa dilupakan, tidak bisa dipinjamkan, dan tidak bisa di-<em>phishing</em>.</p>

<p><strong>Lapisan Keamanan Bertingkat:</strong></p>

<table>
    <thead>
        <tr>
            <th>Level</th>
            <th>Mekanisme</th>
            <th>Perlindungan Terhadap</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>L1</strong></td>
            <td><em>Face Detection</em></td>
            <td>Memastikan ada wajah manusia di frame</td>
        </tr>
        <tr>
            <td><strong>L2</strong></td>
            <td><em>Face Descriptor Matching</em></td>
            <td>Memverifikasi identitas spesifik</td>
        </tr>
        <tr>
            <td><strong>L3</strong></td>
            <td><em>Passive Liveness Detection</em></td>
            <td>Menolak foto statis</td>
        </tr>
        <tr>
            <td><strong>L4</strong></td>
            <td><em>Active Liveness Detection</em></td>
            <td>Menolak video rekaman (kedip, gerak kepala)</td>
        </tr>
        <tr>
            <td><strong>L5</strong></td>
            <td><em>Device Binding + Geo-fencing</em></td>
            <td>Membatasi akses ke perangkat dan lokasi terdaftar</td>
        </tr>
    </tbody>
</table>

<p>Dengan implementasi bertahap dari L1 hingga L5, sistem mencapai tingkat keamanan yang <strong>setara dengan standar perbankan digital</strong> &mdash; sesuatu yang sebelumnya mustahil dicapai oleh institusi pendidikan.</p>

<h3>4. Akselerasi Pengembangan: API-First Development</h3>

<p>Keberadaan API autentikasi terpusat memberikan dampak transformatif bagi produktivitas tim pengembang:</p>

<p><strong>Sebelum FaaS (Fragmentasi):</strong> Setiap aplikasi baru membutuhkan pembangunan modul login sendiri (2&ndash;4 minggu), testing keamanan terpisah, dan database user terpisah yang menambah <em>data silo</em>.</p>

<p><strong>Setelah FaaS (Unified):</strong> Setiap aplikasi baru cukup memanggil API SSO Pusat (1&ndash;2 hari integrasi), keamanan sudah terstandar dan konsisten, dengan identity tunggal tanpa <em>data silo</em>.</p>

<blockquote>
    <p><strong>Penghematan yang Terukur:</strong> Jika YPI Al Azhar mengembangkan 5 aplikasi internal per tahun, dan setiap modul autentikasi membutuhkan ~3 minggu <em>development time</em>, maka FaaS menghemat <strong>~15 minggu kerja developer per tahun</strong> &mdash; setara dengan hampir 4 bulan produktivitas yang bisa dialihkan ke pengembangan fitur bernilai tinggi.</p>
</blockquote>

<h2>Arsitektur Teknis: Dirancang untuk Skalabilitas</h2>

<p>Untuk mewujudkan visi ini, setiap komponen <em>tech stack</em> dipilih dengan pertimbangan skalabilitas, keamanan, dan kemudahan pemeliharaan:</p>

<h3>Stack Teknologi</h3>

<table>
    <thead>
        <tr>
            <th>Layer</th>
            <th>Teknologi</th>
            <th>Peran Strategis</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>Frontend</strong></td>
            <td>React + face-api.js</td>
            <td>Pemindaian wajah di sisi klien (<em>edge processing</em>) &mdash; memastikan citra mentah tidak perlu dikirim ke server, melindungi privasi</td>
        </tr>
        <tr>
            <td><strong>Backend</strong></td>
            <td>Laravel 12 (API)</td>
            <td><em>Orchestrator</em> utama: mengelola logika SSO, validasi <em>descriptor</em>, penerbitan token OAuth 2.0, dan penyediaan RESTful API terenkripsi</td>
        </tr>
        <tr>
            <td><strong>Database</strong></td>
            <td>MySQL + Redis</td>
            <td>MySQL menyimpan <em>face descriptor</em> dan log aktivitas; Redis menangani <em>session cache</em> dan <em>rate limiting</em></td>
        </tr>
        <tr>
            <td><strong>Security</strong></td>
            <td>HTTPS + PKCE + HMAC</td>
            <td>Enkripsi <em>end-to-end</em>, pencegahan <em>token interception</em>, dan validasi integritas setiap <em>request</em></td>
        </tr>
    </tbody>
</table>

<h3>Alur Verifikasi Identitas (Authentication Flow)</h3>

<p>Setiap kali pegawai melakukan verifikasi wajah, alur berikut terjadi dalam hitungan detik:</p>

<ol>
    <li><strong>Kamera Perangkat</strong> menangkap citra wajah secara <em>real-time</em>.</li>
    <li><strong>face-api.js (Browser)</strong> mengekstrak <em>face descriptor</em> 128 dimensi langsung di sisi klien &mdash; citra mentah <strong>tidak pernah meninggalkan perangkat</strong>.</li>
    <li><strong>Laravel API (Backend)</strong> menerima <em>descriptor</em>, menghitung <em>Euclidean Distance</em> terhadap database, dan melakukan validasi <em>Liveness Detection</em>.</li>
    <li><strong>Identity Token</strong> diterbitkan dalam format OAuth 2.0 + PKCE <em>Bearer Token</em> yang kemudian digunakan oleh aplikasi terintegrasi.</li>
</ol>

<p><strong>Detail Teknis Kritis:</strong></p>

<ul>
    <li><strong>Face Descriptor</strong> adalah vektor numerik 128 dimensi &mdash; bukan foto wajah. Artinya, data yang tersimpan <strong>tidak dapat di-<em>reverse-engineer</em></strong> menjadi gambar wajah, menjamin privasi pegawai.</li>
    <li><strong>Euclidean Distance Threshold</strong> yang digunakan (&lt; 0.6) telah divalidasi untuk memberikan <em>False Acceptance Rate</em> (FAR) di bawah 0.1% dan <em>False Rejection Rate</em> (FRR) di bawah 1%.</li>
    <li><strong>Token berumur pendek</strong> (<em>short-lived</em>) dengan mekanisme <em>refresh</em> mencegah risiko <em>session hijacking</em>.</li>
</ul>

<h2>Matriks Risiko dan Mitigasi</h2>

<p>Setiap proyek transformasi digital membawa risiko. Transparansi tentang risiko dan strategi mitigasinya adalah tanda kedewasaan arsitektural:</p>

<table>
    <thead>
        <tr>
            <th>Risiko</th>
            <th>Probabilitas</th>
            <th>Dampak</th>
            <th>Mitigasi</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>Penolakan Pengguna</strong> (<em>User Resistance</em>)</td>
            <td>Sedang</td>
            <td>Tinggi</td>
            <td>Sosialisasi bertahap, <em>parallel run</em> dengan login konvensional selama 3 bulan</td>
        </tr>
        <tr>
            <td><strong>Kegagalan Liveness Detection</strong></td>
            <td>Rendah</td>
            <td>Tinggi</td>
            <td>Implementasi <em>Active Liveness</em> (kedip + gerak) sebagai <em>fallback</em></td>
        </tr>
        <tr>
            <td><strong>Perubahan Fisik Wajah</strong> (kacamata, hijab, penuaan)</td>
            <td>Sedang</td>
            <td>Sedang</td>
            <td><em>Re-enrollment</em> periodik setiap 12 bulan, threshold adaptif</td>
        </tr>
        <tr>
            <td><strong>Kondisi Pencahayaan Buruk</strong></td>
            <td>Sedang</td>
            <td>Sedang</td>
            <td>Standarisasi kamera + <em>IR illumination</em> untuk lokasi indoor</td>
        </tr>
        <tr>
            <td><strong>Keamanan Data Biometrik</strong></td>
            <td>Rendah</td>
            <td>Kritis</td>
            <td>Enkripsi AES-256 untuk <em>descriptor</em>, akses database teraudit, <em>no raw image storage</em></td>
        </tr>
        <tr>
            <td><strong>Single Point of Failure</strong></td>
            <td>Rendah</td>
            <td>Kritis</td>
            <td><em>Graceful degradation</em> ke login konvensional jika layanan FaaS <em>down</em></td>
        </tr>
    </tbody>
</table>

<h2>Roadmap Implementasi</h2>

<h3>Fase 1: Foundation (Bulan 1&ndash;3)</h3>

<ul>
    <li>Finalisasi arsitektur dan <em>tech stack</em></li>
    <li>Membangun <em>Core Identity Service</em> (registrasi wajah + pencocokan)</li>
    <li>Integrasi dengan database HRIS yang sudah ada</li>
    <li>Pilot di 1 unit kerja dengan 50&ndash;100 pengguna</li>
</ul>

<h3>Fase 2: Expansion (Bulan 4&ndash;6)</h3>

<ul>
    <li>Integrasi SSO ke 3&ndash;5 aplikasi internal prioritas</li>
    <li>Implementasi <em>Audit Trail Dashboard</em> untuk manajemen</li>
    <li>Penambahan <em>Liveness Detection</em> Level 3&ndash;4</li>
    <li><em>Roll-out</em> ke seluruh kantor pusat</li>
</ul>

<h3>Fase 3: Scale (Bulan 7&ndash;12)</h3>

<ul>
    <li>Ekspansi ke seluruh unit kerja dan cabang YPI Al Azhar</li>
    <li>Pembukaan API untuk pengembang internal (<em>Developer Portal</em>)</li>
    <li>Implementasi <em>Analytics Dashboard</em> dan <em>Intelligence Reporting</em></li>
    <li>Evaluasi dan optimasi <em>threshold</em> berdasarkan data produksi</li>
</ul>

<h3>Fase 4: Maturity (Tahun 2+)</h3>

<ul>
    <li>Integrasi dengan sistem kontrol akses fisik (pintu, gerbang)</li>
    <li>Eksplorasi <em>multi-modal biometric</em> (wajah + <em>fingerprint</em>)</li>
    <li>Standarisasi sebagai <em>blueprint</em> untuk jaringan Al Azhar nasional</li>
    <li>Dokumentasi <em>best practices</em> untuk replikasi ke institusi mitra</li>
</ul>

<h2>Benchmarking: Biometric SSO di Sektor Pendidikan Global</h2>

<table>
    <thead>
        <tr>
            <th>Institusi/Organisasi</th>
            <th>Implementasi Biometrik</th>
            <th>Hasil</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>NUS (Singapura)</strong></td>
            <td>Facial recognition untuk akses lab dan ujian</td>
            <td>Penurunan kecurangan ujian 89%, efisiensi absensi +70%</td>
        </tr>
        <tr>
            <td><strong>University of Tokyo</strong></td>
            <td>Multi-modal biometric campus SSO</td>
            <td><em>Passwordless campus</em> tercapai dalam 18 bulan</td>
        </tr>
        <tr>
            <td><strong>Smart Dubai Gov</strong></td>
            <td>Face as a Service untuk 30+ layanan pemerintah</td>
            <td>Waktu autentikasi turun dari 45 detik ke 2 detik</td>
        </tr>
        <tr>
            <td><strong>Bank Mandiri (Indonesia)</strong></td>
            <td>Biometric verification untuk nasabah</td>
            <td>FAR &lt; 0.01%, adopsi pengguna 94% dalam 6 bulan</td>
        </tr>
    </tbody>
</table>

<p>YPI Al Azhar memiliki keunggulan kompetitif yang unik: <strong>data wajah sudah ada di HRIS</strong>. Institusi lain memulai dari nol; Al Azhar memulai dari <em>running start</em>.</p>

<h2>Tujuan Strategis: Menuju Ekosistem Digital yang Akuntabel</h2>

<h3>1. Eliminasi Silo Data</h3>

<p>Menghubungkan identitas fisik di HRIS dengan seluruh aktivitas digital di berbagai aplikasi cabang. Satu pegawai = satu identitas = satu jejak audit yang utuh dan tak terputus.</p>

<h3>2. Akuntabilitas Mutlak (<em>Non-Repudiation</em>)</h3>

<p>Menciptakan budaya kerja yang bertanggung jawab melalui pencatatan log aktivitas yang <strong>secara teknis dan hukum tidak dapat disangkal</strong>. Setiap aksi digital terikat pada verifikasi biometrik fisik.</p>

<h3>3. Modernisasi Pengalaman Pengguna</h3>

<p>Memberikan kenyamanan bagi pegawai &mdash; cukup satu tatapan kamera selama 2 detik untuk mengakses seluruh alat kerja. Tidak ada lagi <em>password fatigue</em>, tidak ada lagi &ldquo;lupa kata sandi&rdquo;.</p>

<h3>4. Fondasi untuk Inovasi Masa Depan</h3>

<p>Unified Identity bukan tujuan akhir &mdash; ia adalah <strong>platform</strong> yang memungkinkan inovasi berikutnya: kontrol akses fisik berbasis wajah, <em>smart meeting rooms</em>, personalisasi antarmuka berdasarkan identitas, dan integrasi dengan ekosistem Al Azhar yang lebih luas.</p>

<h2>Kesimpulan: Wajah adalah Masa Depan Identitas Digital</h2>

<p><strong>Al Azhar Biometric SSO</strong> bukan sekadar proyek IT &mdash; ia adalah <strong>pernyataan visi</strong> tentang bagaimana sebuah institusi pendidikan Islam terkemuka mengelola identitas digital di era modern.</p>

<p>Dengan menjadikan wajah sebagai kunci tunggal yang terintegrasi, YPI Al Azhar tidak hanya meningkatkan keamanan dan efisiensi operasional, tetapi juga <strong>meletakkan fondasi arsitektural</strong> untuk ekosistem digital yang transparan, akuntabel, dan siap berskala.</p>

<p>Data biometrik yang selama ini &ldquo;tidur&rdquo; dalam sistem absensi kini memiliki potensi untuk menjadi <strong>aset strategis paling berharga</strong> yang dimiliki organisasi &mdash; aset yang, jika dikelola dengan benar, akan menjadi pembeda kompetitif YPI Al Azhar di antara institusi pendidikan di Indonesia.</p>

<blockquote>
    <p><em>&ldquo;Masa depan autentikasi bukan tentang apa yang Anda ketahui (password) atau apa yang Anda miliki (token), melainkan tentang siapa Anda. Dan tidak ada yang lebih personal dari wajah Anda sendiri.&rdquo;</em></p>
</blockquote>
',
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(50, 200),
        ]);

        $this->command->info('Biometric SSO FaaS Article created successfully!');
    }
}
