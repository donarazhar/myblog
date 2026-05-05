<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class NocJaringanOperasionalArticleSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('is_admin', true)->first();

        if (!$admin) {
            $this->command->warn('No admin user found. Please run DatabaseSeeder first.');
            return;
        }

        $category = Category::firstOrCreate(
            ['name' => 'Teknologi'],
            ['description' => 'Artikel tentang perkembangan teknologi']
        );

        Article::create([
            'title' => 'Anatomi Jaringan NOC: Membedah Alur Data dari Inbound ISP hingga End-User',
            'slug' => 'anatomi-jaringan-noc-alur-data-inbound-isp-hingga-end-user',
            'excerpt' => 'Seberapa dalam Anda memahami jaringan yang Anda kelola setiap hari? Artikel ini membedah secara teknis alur perjalanan data dari koneksi Fiber Optic ISP hingga ke tangan pengguna akhir, lengkap dengan analisis perangkat, standar industri, dan strategi implementasi NOC profesional berbasis diagram topologi nyata.',
            'content' => '
<p>Bagi sebagian besar pengguna, internet hanyalah soal "sinyal kuat atau lemah." Namun di balik layar, terdapat sebuah ekosistem teknis yang terstruktur dengan presisi tinggi — sebuah <strong>Network Operations Center (NOC)</strong> yang menjadi tulang punggung seluruh aktivitas digital sebuah organisasi.</p>

<p>Artikel ini tidak membahas teori abstrak. Kita akan membedah langsung <strong>diagram topologi jaringan NOC</strong> yang nyata, mengurai setiap komponen, memahami mengapa ia ada di sana, dan apa yang terjadi jika salah satunya gagal.</p>

<h2>Memahami Peta Besar: Tiga Zona Jaringan</h2>

<p>Sebelum masuk ke detail teknis, penting untuk memahami bahwa seluruh arsitektur jaringan ini terbagi menjadi <strong>tiga zona fungsional</strong> yang bekerja secara berurutan:</p>

<ol>
    <li><strong>Zona Inbound</strong> &mdash; Tempat sinyal dari dunia luar masuk dan dikonversi.</li>
    <li><strong>Zona Core</strong> &mdash; Otak jaringan yang mengatur semua kebijakan lalu lintas data.</li>
    <li><strong>Zona Distribusi &amp; Akses</strong> &mdash; Jalur terakhir menuju pengguna dan perangkat akhir.</li>
</ol>

<p>Ketiga zona ini saling bergantung. Kegagalan di satu zona akan berdampak langsung ke zona berikutnya. Memahami batas-batas ini adalah fondasi dari setiap operasional NOC yang efektif.</p>

<h2>Zona 1: Inbound — Sinyal dari Luar Masuk ke Dalam</h2>

<h3>ISP: Remala Abadi, TBK</h3>

<p>Perjalanan data dimulai dari <strong>ISP Remala Abadi, TBK</strong> — penyedia layanan internet yang mengantarkan koneksi menggunakan media transmisi <strong>Fiber Optic (FO)</strong>. Pilihan FO bukan sekadar soal kecepatan; ini adalah keputusan arsitektural yang membawa konsekuensi teknis:</p>

<ul>
    <li><strong>Bandwidth tinggi</strong> dengan kapasitas yang dapat mencapai puluhan Gbps.</li>
    <li><strong>Latensi sangat rendah</strong> karena sinyal berjalan dengan kecepatan cahaya.</li>
    <li><strong>Imun terhadap interferensi elektromagnetik (EMI)</strong> — tidak terganggu oleh perangkat elektronik di sekitarnya.</li>
    <li><strong>Jangkauan jauh</strong> tanpa degradasi sinyal yang berarti.</li>
</ul>

<p>Serat optik membawa sinyal cahaya — bukan sinyal listrik. Inilah yang membuat konversi di tahap berikutnya menjadi wajib.</p>

<h3>Fiber Patch Panel: Titik Terminasi yang Sering Diabaikan</h3>

<p><strong>Fiber Patch Panel</strong> adalah komponen pertama yang menerima kabel FO dari ISP. Perannya sering diremehkan, padahal ini adalah garis pertahanan pertama infrastruktur Anda:</p>

<ul>
    <li><strong>Terminasi fisik</strong>: Melindungi ujung kabel FO yang sangat rentan dari tekukan, tarikan, dan kerusakan mekanis.</li>
    <li><strong>Titik manajemen</strong>: Memudahkan penggantian jalur (patching) tanpa harus menyentuh kabel utama yang tertanam.</li>
    <li><strong>Organisasi kabel</strong>: Memberikan struktur yang jelas pada instalasi multi-jalur FO.</li>
</ul>

<blockquote>
    <p><strong>Catatan Operasional:</strong> Kerusakan pada konektor FO di Patch Panel adalah salah satu penyebab paling umum degradasi performa yang sulit didiagnosis. Debu dan kotoran pada ferrule konektor dapat menyebabkan loss sinyal yang signifikan. Bersihkan secara berkala menggunakan fiber optic cleaning kit.</p>
</blockquote>

<h3>Media Converter (TP-Link): Jembatan Dua Dunia</h3>

<p><strong>Media Converter TP-Link</strong> menjalankan satu fungsi kritis: mengonversi sinyal <em>optik</em> dari Fiber Optic menjadi sinyal <em>elektrik</em> yang dapat diproses melalui kabel LAN RJ45 standar.</p>

<p>Tanpa perangkat ini, router dan switch konvensional tidak dapat "membaca" sinyal dari ISP berbasis FO. Media Converter berfungsi sebagai penerjemah antara dua dunia fisik yang berbeda.</p>

<table>
    <thead>
        <tr>
            <th>Aspek</th>
            <th>Sisi Fiber (Input)</th>
            <th>Sisi LAN (Output)</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>Media</strong></td>
            <td>Kabel Serat Optik</td>
            <td>Kabel UTP/STP RJ45</td>
        </tr>
        <tr>
            <td><strong>Sinyal</strong></td>
            <td>Pulsa Cahaya</td>
            <td>Sinyal Elektrik</td>
        </tr>
        <tr>
            <td><strong>Konektor</strong></td>
            <td>SC / LC / ST</td>
            <td>RJ45 (8P8C)</td>
        </tr>
        <tr>
            <td><strong>Standar</strong></td>
            <td>IEEE 802.3z / 802.3ae</td>
            <td>IEEE 802.3u / 802.3ab</td>
        </tr>
    </tbody>
</table>

<p><strong>Kerentanan Kritis:</strong> TP-Link Media Converter adalah perangkat <em>plug-and-play</em> tanpa antarmuka manajemen digital. Ini berarti status operasionalnya hanya dapat dipantau secara visual melalui lampu indikator LED — tidak ada SNMP, tidak ada remote monitoring. Jika perangkat ini gagal di luar jam kerja, tim NOC tidak akan mendapat notifikasi otomatis.</p>

<h2>Zona 2: Core — Otak yang Mengatur Segalanya</h2>

<h3>Core Router &amp; Gateway: MikroTik CCR/CRS</h3>

<p>Inilah perangkat terpenting dalam seluruh ekosistem. <strong>MikroTik CCR (Cloud Core Router) atau CRS (Cloud Router Switch)</strong> bertindak sebagai <strong>pusat kendali kebijakan jaringan</strong>, menjalankan empat fungsi simultan:</p>

<ul>
    <li><strong>Routing</strong>: Menentukan jalur terbaik untuk setiap paket data yang melewatinya, berdasarkan tabel routing yang dikonfigurasi.</li>
    <li><strong>NAT (Network Address Translation)</strong>: Menerjemahkan alamat IP privat internal (seperti <code>172.32.x.x</code>) menjadi IP publik untuk berkomunikasi dengan internet, dan sebaliknya.</li>
    <li><strong>DHCP Server</strong>: Mendistribusikan alamat IP secara otomatis kepada seluruh perangkat yang terhubung ke jaringan.</li>
    <li><strong>Firewall</strong>: Menyaring lalu lintas data berdasarkan aturan keamanan yang ditetapkan — memblokir akses tidak sah dan melindungi jaringan internal dari ancaman eksternal.</li>
</ul>

<h3>Segmen IP Management: 192.168.3.0/24</h3>

<p>Detail yang sangat penting dari diagram topologi ini adalah penggunaan jaringan <strong>192.168.3.0/24</strong> sebagai <strong>segmen IP khusus untuk manajemen</strong>. Ini bukan kebetulan — ini adalah praktik keamanan terbaik:</p>

<ul>
    <li><strong>Isolasi administratif</strong>: Akses ke antarmuka konfigurasi router dan switch hanya tersedia dari jaringan ini, bukan dari jaringan pengguna umum.</li>
    <li><strong>Minimasi attack surface</strong>: Penyerang yang berhasil menembus jaringan pengguna tidak serta-merta mendapat akses ke panel kontrol perangkat jaringan.</li>
    <li><strong>Audit yang lebih bersih</strong>: Semua aktivitas manajemen terlacak di segmen yang terisolasi, memudahkan forensik jika terjadi insiden.</li>
</ul>

<blockquote>
    <p><strong>Prinsip Zero Trust:</strong> Perlakukan jaringan manajemen Anda seperti brankas — hanya personel berwenang dengan kredensial valid yang boleh mengaksesnya, bahkan jika mereka sudah berada di dalam jaringan internal.</p>
</blockquote>

<h2>Zona 3: Distribusi &amp; Akses — Data Sampai ke Tangan Pengguna</h2>

<h3>Switch Distribusi HP: Persimpangan Lalu Lintas</h3>

<p><strong>Switch HP Series</strong> (dengan IP manajemen <code>172.32.252.253</code>) berfungsi sebagai titik distribusi utama yang membagi lalu lintas ke berbagai segmen pengguna. Berbeda dengan router yang beroperasi di Layer 3, switch distribusi bekerja terutama di <strong>Layer 2 (Data Link)</strong> dengan kemampuan Layer 3 terbatas.</p>

<p>Perannya dalam diagram ini adalah menjadi "persimpangan jalan" — menerima koneksi dari Core Router dan mendistribusikannya ke dua jalur utama:</p>

<ol>
    <li><strong>Jalur ke HP Server</strong> (IP: <code>172.32.252.248</code>)</li>
    <li><strong>Jalur ke Area Distribusi Pengguna</strong> (semua perangkat end-user)</li>
</ol>

<h3>HP Server: Aplikasi Internal di IP 172.32.252.248</h3>

<p>Server ini menjalankan layanan aplikasi internal organisasi — bisa berupa sistem informasi, file server, database server, atau kombinasi keduanya. Lokasinya yang berada <em>di dalam</em> jaringan lokal (bukan di cloud) memberikan beberapa implikasi operasional:</p>

<ul>
    <li><strong>Latensi akses sangat rendah</strong> untuk pengguna internal.</li>
    <li><strong>Data tidak keluar dari jaringan</strong> organisasi — relevan untuk kepatuhan privasi data.</li>
    <li><strong>Ketergantungan pada infrastruktur lokal</strong> — jika jaringan internal down, server tidak dapat diakses meskipun internet masih aktif.</li>
</ul>

<h3>Area Atribusi Akses Pengguna (Area Tumpukan Kabel)</h3>

<p>Diagram topologi secara eksplisit menandai area ini sebagai <em>"Area Tumpukan Kabel, Perlu Perapian"</em> — sebuah catatan jujur yang menjadi agenda kerja nyata. Area ini menghubungkan infrastruktur ke lima kategori aset:</p>

<table>
    <thead>
        <tr>
            <th>Aset</th>
            <th>Fungsi</th>
            <th>Risiko Utama</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>Server Aplikasi Internal</strong></td>
            <td>Hosting layanan dan data lokal</td>
            <td>Single point of failure tanpa redundansi</td>
        </tr>
        <tr>
            <td><strong>Komputer Kantor &amp; Staf</strong></td>
            <td>Workstation operasional harian</td>
            <td>Endpoint security yang sering terabaikan</td>
        </tr>
        <tr>
            <td><strong>Jaringan WiFi (Access Point)</strong></td>
            <td>Koneksi nirkabel untuk pengguna mobile</td>
            <td>Keamanan WPA2/3, rogue AP</td>
        </tr>
        <tr>
            <td><strong>Sistem CCTV</strong></td>
            <td>Pengawasan keamanan fisik</td>
            <td>Konsumsi bandwidth besar, segmentasi VLAN diperlukan</td>
        </tr>
        <tr>
            <td><strong>Printer Jaringan</strong></td>
            <td>Cetak dokumen berbagi</td>
            <td>Perangkat IoT dengan keamanan firmware lemah</td>
        </tr>
    </tbody>
</table>

<h2>Analisis Mendalam: Kekuatan dan Celah Setiap Perangkat</h2>

<table>
    <thead>
        <tr>
            <th>Perangkat</th>
            <th>Peran Teknis</th>
            <th>Keunggulan Utama</th>
            <th>Celah yang Perlu Diatasi</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>MikroTik CCR/CRS</strong></td>
            <td>Core Router, Gateway, Firewall</td>
            <td>Fitur <em>enterprise</em> lengkap (BGP, OSPF, MPLS) dengan harga kompetitif; RouterOS sangat fleksibel</td>
            <td>Kurva belajar tinggi; kesalahan konfigurasi berdampak luas; wajib update firmware rutin</td>
        </tr>
        <tr>
            <td><strong>HP Switch Series</strong></td>
            <td>Switch Distribusi LAN</td>
            <td>Stabilitas performa tinggi; garansi jangka panjang; dukungan VLAN dan QoS</td>
            <td>Antarmuka manajemen lebih mendasar dibanding kelas <em>high-end</em>; perlu konfigurasi manual VLAN</td>
        </tr>
        <tr>
            <td><strong>TP-Link Media Converter</strong></td>
            <td>Konverter Sinyal Fiber ke LAN</td>
            <td>Plug-and-play; biaya rendah; tidak memerlukan konfigurasi</td>
            <td>Zero visibility — tidak ada SNMP, tidak ada alert otomatis saat gagal; tidak ada redundansi bawaan</td>
        </tr>
        <tr>
            <td><strong>UniFi Access Point</strong></td>
            <td>Infrastruktur WiFi</td>
            <td>Manajemen terpusat via controller; roaming mulus antar AP; dashboard analitik WiFi</td>
            <td>Memerlukan UniFi Controller (hardware atau cloud) untuk fitur penuh; lisensi cloud berbayar</td>
        </tr>
    </tbody>
</table>

<h2>Tiga Prioritas Strategis Menuju NOC Profesional</h2>

<h3>1. Implementasi Sistem Labeling (TIA/EIA-606)</h3>

<p>Standar <strong>TIA/EIA-606</strong> bukan sekadar formalitas — ini adalah perbedaan antara insiden yang diselesaikan dalam 10 menit versus 2 jam. Setiap kabel, port, dan perangkat dalam jaringan harus memiliki identitas yang terdokumentasi dalam sistem <em>cable management</em>.</p>

<p>Format label yang direkomendasikan untuk port Switch HP:</p>

<table>
    <thead>
        <tr>
            <th>Port</th>
            <th>ID Perangkat Tujuan</th>
            <th>IP Address</th>
            <th>Lokasi Fisik</th>
            <th>Tipe Kabel</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Gi0/1</td>
            <td>SRV-APP-01</td>
            <td>172.32.252.248</td>
            <td>Rack A, Unit 3</td>
            <td>UTP Cat6</td>
        </tr>
        <tr>
            <td>Gi0/2</td>
            <td>AP-LOBBY-01</td>
            <td>172.32.252.10</td>
            <td>Lobby Lt. 1</td>
            <td>UTP Cat6</td>
        </tr>
        <tr>
            <td>Gi0/3</td>
            <td>CCTV-NVR-01</td>
            <td>172.32.252.50</td>
            <td>Ruang Server</td>
            <td>UTP Cat6</td>
        </tr>
    </tbody>
</table>

<h3>2. Cable Management: Dari "Tumpukan" Menjadi Terstruktur</h3>

<p>Diagram topologi secara tegas menyebut kondisi area distribusi saat ini sebagai <em>"Area Tumpukan Kabel."</em> Ini bukan masalah estetika — ini adalah risiko operasional nyata:</p>

<ul>
    <li><strong>Tumpukan kabel = diagnosis gangguan yang lambat.</strong> Saat terjadi putus koneksi, teknisi harus menelusuri kabel secara manual di antara tumpukan — membuang waktu berharga.</li>
    <li><strong>Tekanan berlebih pada kabel</strong> dari <em>cable tie</em> plastik dapat merusak inti tembaga dan meningkatkan resistansi sinyal secara bertahap.</li>
</ul>

<p>Solusi standar yang harus diimplementasikan:</p>

<ul>
    <li><strong>Ganti cable ties dengan Velcro</strong>: Velcro dapat dibuka-pasang tanpa alat dan tidak memberikan tekanan berlebih pada kabel.</li>
    <li><strong>Pasang Horizontal Cable Organizer</strong> pada setiap U di rack server untuk memastikan sisa panjang kabel tersimpan rapi di belakang panel, bukan menggantung di depan.</li>
    <li><strong>Ikuti standar warna kabel</strong>: Gunakan warna berbeda untuk kategori koneksi yang berbeda (misalnya: merah untuk server, biru untuk workstation, kuning untuk uplink).</li>
</ul>

<h3>3. Security Hardening: Tiga Lapisan Pertahanan</h3>

<p>Keamanan jaringan NOC harus diperlakukan sebagai proses berkelanjutan, bukan konfigurasi satu kali. Tiga lapisan pertahanan yang wajib diimplementasikan:</p>

<p><strong>Lapisan 1 — Pembaruan Firmware:</strong> Jadwalkan pembaruan firmware MikroTik dan HP Switch secara rutin minimal setiap kuartal. Setiap kerentanan (<em>CVE</em>) yang ditemukan pada firmware lama adalah pintu terbuka bagi penyerang.</p>

<p><strong>Lapisan 2 — Penggantian Kredensial Default:</strong> Seluruh perangkat aktif &mdash; router, switch, access point, CCTV NVR, printer jaringan &mdash; wajib mengganti password pabrik. Credential default adalah target pertama dalam serangan <em>brute-force</em> otomatis.</p>

<p><strong>Lapisan 3 — Segmentasi VLAN:</strong> Pisahkan trafik berdasarkan kategori perangkat menggunakan VLAN untuk membatasi dampak jika satu segmen berhasil disusupi:</p>

<table>
    <thead>
        <tr>
            <th>VLAN ID</th>
            <th>Segmen</th>
            <th>Perangkat</th>
            <th>Akses Internet</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>VLAN 10</td>
            <td>Management</td>
            <td>Router, Switch (192.168.3.0/24)</td>
            <td>Tidak</td>
        </tr>
        <tr>
            <td>VLAN 20</td>
            <td>Server</td>
            <td>HP Server (172.32.252.248)</td>
            <td>Terbatas</td>
        </tr>
        <tr>
            <td>VLAN 30</td>
            <td>Workstation</td>
            <td>Komputer Kantor &amp; Staf</td>
            <td>Ya</td>
        </tr>
        <tr>
            <td>VLAN 40</td>
            <td>WiFi Guest</td>
            <td>Access Point (tamu)</td>
            <td>Ya (dibatasi)</td>
        </tr>
        <tr>
            <td>VLAN 50</td>
            <td>CCTV</td>
            <td>Kamera &amp; NVR</td>
            <td>Tidak</td>
        </tr>
    </tbody>
</table>

<h2>Mengukur Keberhasilan: MTTR sebagai Metrik Utama NOC</h2>

<p>Standar kualitas NOC profesional tidak diukur dari seberapa jarang gangguan terjadi — melainkan dari seberapa cepat gangguan dapat dipulihkan. Metrik ini disebut <strong>Mean Time To Repair (MTTR)</strong>.</p>

<p>Dengan implementasi tiga prioritas strategis di atas, target MTTR yang realistis adalah:</p>

<table>
    <thead>
        <tr>
            <th>Kondisi</th>
            <th>MTTR Tipikal</th>
            <th>Faktor Penentu</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>Tanpa dokumentasi &amp; labeling</strong></td>
            <td>2 &ndash; 4 jam</td>
            <td>Mencari kabel, menebak konfigurasi</td>
        </tr>
        <tr>
            <td><strong>Dengan labeling &amp; diagram</strong></td>
            <td>30 &ndash; 60 menit</td>
            <td>Identifikasi cepat, eskalasi terstruktur</td>
        </tr>
        <tr>
            <td><strong>Dengan monitoring &amp; alerting</strong></td>
            <td>5 &ndash; 15 menit</td>
            <td>Deteksi proaktif sebelum laporan pengguna</td>
        </tr>
    </tbody>
</table>

<p>Perbedaan antara MTTR 4 jam dan 15 menit bukan sekadar angka teknis — dalam konteks operasional nyata, ini adalah perbedaan antara satu sesi belajar-mengajar yang terganggu versus keseluruhan hari kerja yang lumpuh.</p>

<h2>Kesimpulan: Infrastruktur sebagai Fondasi Operasional</h2>

<p>Diagram topologi NOC yang kita bedah bersama ini mencerminkan sebuah kebenaran fundamental: <strong>kualitas layanan digital sebuah organisasi ditentukan oleh kualitas infrastruktur yang menopangnya.</strong></p>

<p>Alur dari ISP Remala Abadi &rarr; Fiber Patch Panel &rarr; Media Converter &rarr; MikroTik CCR &rarr; HP Switch &rarr; End-user bukan sekadar rantai perangkat keras. Ini adalah <em>pipeline kepercayaan</em> — setiap mata rantai harus andal, terdokumentasi, dan aman agar keseluruhan sistem dapat bekerja optimal.</p>

<p>Investasi pada tiga hal — <strong>labeling yang rapi, cable management yang terstruktur, dan security hardening yang konsisten</strong> — adalah investasi pada sesuatu yang tidak tampak secara kasat mata tetapi terasa langsung oleh setiap pengguna: <em>koneksi yang stabil, masalah yang cepat terselesaikan, dan kepercayaan penuh pada infrastruktur digital organisasi.</em></p>

<blockquote>
    <p><em>"Jaringan yang baik bukan yang tidak pernah bermasalah — melainkan yang ketika bermasalah, dapat dipulihkan sebelum pengguna sempat menyadarinya."</em></p>
</blockquote>
',
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(80, 350),
        ]);

        $this->command->info('NOC Jaringan Operasional Article created successfully!');
    }
}
