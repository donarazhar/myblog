<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class ApiGatewayLbReverseProxyArticleSeeder extends Seeder
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

        // Create API Gateway vs Load Balancer vs Reverse Proxy article
        Article::create([
            'title' => 'Jangan Lagi Mencampuradukkan API Gateway, Load Balancer, dan Reverse Proxy',
            'slug' => 'jangan-lagi-mencampuradukkan-api-gateway-load-balancer-dan-reverse-proxy',
            'excerpt' => 'Panduan lengkap untuk memahami tiga komponen arsitektur jaringan yang sering disalahpahami — beserta kapan, mengapa, dan bagaimana menggunakannya.',
            'content' => '
<p>Jika kamu pernah membaca dokumentasi teknis, berbicara dengan tim DevOps, atau mendesain arsitektur sistem, kamu pasti pernah mendengar tiga istilah ini: <strong>API Gateway</strong>, <strong>Load Balancer</strong>, dan <strong>Reverse Proxy</strong>. Banyak orang — bahkan engineer berpengalaman — sering mencampuradukkan ketiganya, atau lebih parahnya, menganggap mereka adalah hal yang sama.</p>

<p>Faktanya, ketiganya <strong>berbeda secara fundamental</strong> dalam tujuan, cara kerja, dan konteks penggunaannya. Namun di sisi lain, ketiganya juga memiliki <strong>zona abu-abu</strong> yang membuat batas di antara mereka terasa kabur — terutama karena beberapa produk modern mengimplementasikan lebih dari satu peran sekaligus.</p>

<p>Artikel ini akan membantu kamu memahami masing-masing dengan jelas: dari konsep dasar, cara kerja internal, perbedaan kunci, hingga kapan harus menggunakan yang mana.</p>

<h2>Bagian 1: Reverse Proxy — Fondasi dari Segalanya</h2>

<h3>Apa Itu Reverse Proxy?</h3>

<p>Sebelum memahami <em>reverse proxy</em>, kita perlu memahami <em>proxy</em> biasa (forward proxy) terlebih dahulu.</p>

<p><strong>Forward Proxy</strong> adalah perantara antara <strong>klien dan internet</strong>. Klien mengirim request ke proxy, dan proxy meneruskannya ke server tujuan. Ini umum digunakan di perusahaan untuk memfilter akses internet karyawan, atau oleh pengguna untuk menyembunyikan identitas mereka (seperti VPN).</p>

<p><strong>Reverse Proxy</strong> adalah kebalikannya — ia adalah perantara antara <strong>internet dan server</strong>. Klien tidak tahu server mana yang sebenarnya mereka ajak bicara. Semua traffic masuk diterima oleh reverse proxy, lalu diteruskan ke server backend yang sesuai.</p>

<pre><code>Tanpa Reverse Proxy:
[Klien] ──────────────────────► [Server Backend]

Dengan Reverse Proxy:
[Klien] ──► [Reverse Proxy] ──► [Server Backend]</code></pre>

<h3>Apa yang Dilakukan Reverse Proxy?</h3>

<p>Secara fundamental, reverse proxy melakukan hal-hal berikut:</p>

<p><strong>1. Terminasi SSL/TLS</strong></p>
<p>Daripada setiap server backend harus mengelola sertifikat SSL sendiri, reverse proxy "mengakhiri" koneksi HTTPS dari klien dan meneruskan traffic sebagai HTTP biasa ke backend. Ini menyederhanakan manajemen sertifikat secara drastis.</p>

<p><strong>2. Caching</strong></p>
<p>Reverse proxy dapat menyimpan respons dari backend dan mengembalikannya langsung ke klien tanpa membebani server. Nginx, misalnya, sangat terkenal untuk kemampuan caching statis ini.</p>

<p><strong>3. Kompresi</strong></p>
<p>Response dapat dikompres (gzip/brotli) di level proxy sebelum dikirim ke klien, menghemat bandwidth dan mempercepat loading.</p>

<p><strong>4. Menyembunyikan Infrastruktur Internal</strong></p>
<p>Klien hanya melihat IP/domain dari reverse proxy. Topologi, IP, dan jumlah server backend tersembunyi sepenuhnya. Ini adalah lapisan keamanan penting.</p>

<p><strong>5. Routing Berbasis Path atau Domain</strong></p>
<p>Reverse proxy dapat mengarahkan traffic berdasarkan URL path atau hostname. Misalnya:</p>
<ul>
    <li><code>example.com/api</code> → diteruskan ke server API</li>
    <li><code>example.com/static</code> → diteruskan ke server aset statis</li>
</ul>

<h3>Contoh Nyata</h3>

<p>Nginx adalah contoh reverse proxy paling populer. Konfigurasi dasar Nginx sebagai reverse proxy terlihat seperti ini:</p>

<pre><code>server {
    listen 80;
    server_name example.com;

    location /api {
        proxy_pass http://backend-api:3000;
    }

    location /static {
        proxy_pass http://static-server:8080;
    }
}</code></pre>

<p>Dengan konfigurasi ini, semua request ke <code>example.com/api</code> diteruskan ke server API di port 3000, sementara <code>/static</code> diteruskan ke server lain.</p>

<h3>Analogi Sederhana</h3>

<p>Bayangkan sebuah <strong>gedung perkantoran besar</strong> dengan satu pintu masuk utama dan seorang <strong>resepsionis</strong>. Semua tamu (klien) harus melewati resepsionis. Resepsionis tidak tahu nama semua orang di dalam gedung, tapi ia tahu harus mengarahkan tamu ke lantai dan ruangan yang tepat. Tamu tidak tahu struktur internal gedung — mereka hanya berinteraksi dengan resepsionis.</p>

<p>Itulah reverse proxy.</p>

<h2>Bagian 2: Load Balancer — Membagi Beban Secara Adil</h2>

<h3>Apa Itu Load Balancer?</h3>

<p>Load balancer adalah komponen yang <strong>mendistribusikan traffic masuk ke beberapa server backend</strong> secara merata atau berdasarkan aturan tertentu. Tujuan utamanya adalah memastikan tidak ada satu server pun yang kewalahan sementara server lain menganggur.</p>

<pre><code>                          ┌──► [Server A]
[Klien] ──► [Load Balancer] ──► [Server B]
                          └──► [Server C]</code></pre>

<p>Load balancer adalah jawaban atas pertanyaan: <strong>"Bagaimana cara menangani jutaan request per detik jika satu server tidak cukup?"</strong></p>

<h3>Cara Kerja Load Balancer</h3>

<p>Load balancer menggunakan berbagai <strong>algoritma distribusi</strong> untuk memutuskan server mana yang akan menerima request berikutnya:</p>

<p><strong>Round Robin</strong></p>
<p>Request didistribusikan secara bergiliran ke setiap server. Request pertama ke Server A, kedua ke Server B, ketiga ke Server C, keempat kembali ke Server A, dan seterusnya. Algoritma paling sederhana dan cocok ketika semua server memiliki kapasitas yang sama.</p>

<p><strong>Weighted Round Robin</strong></p>
<p>Mirip dengan Round Robin, tapi setiap server diberi <em>bobot</em>. Server dengan bobot lebih tinggi menerima lebih banyak request. Berguna ketika server memiliki spesifikasi hardware yang berbeda.</p>

<p><strong>Least Connections</strong></p>
<p>Request dikirim ke server yang saat ini memiliki jumlah koneksi aktif paling sedikit. Lebih cerdas dari Round Robin karena mempertimbangkan beban aktual server.</p>

<p><strong>IP Hash</strong></p>
<p>IP address klien di-<em>hash</em> untuk menentukan server tujuan. Ini memastikan klien yang sama selalu diarahkan ke server yang sama — berguna untuk menjaga <em>session consistency</em>.</p>

<p><strong>Least Response Time</strong></p>
<p>Request dikirim ke server dengan waktu respons terpendek. Paling adaptif, tapi memerlukan monitoring yang lebih kompleks.</p>

<h3>Health Check — Fitur Kritis Load Balancer</h3>

<p>Salah satu fungsi paling penting dari load balancer adalah <strong>health check</strong>: secara berkala memeriksa apakah setiap server backend masih hidup dan berfungsi. Jika sebuah server gagal merespons health check, load balancer secara otomatis mengeluarkan server tersebut dari rotasi dan tidak mengirim traffic ke sana, hingga server kembali sehat.</p>

<p>Inilah yang membuat load balancer menjadi fondasi dari sistem <strong>high availability (HA)</strong>.</p>

<h3>Layer 4 vs Layer 7 Load Balancer</h3>

<p>Load balancer beroperasi di dua level berbeda dari model OSI:</p>

<p><strong>Layer 4 (Transport Layer)</strong></p>
<p>Bekerja berdasarkan informasi TCP/UDP — IP address dan port. Tidak bisa membaca konten HTTP. Sangat cepat karena tidak perlu memeriksa payload. Cocok untuk aplikasi yang membutuhkan latensi ultra-rendah.</p>

<p><strong>Layer 7 (Application Layer)</strong></p>
<p>Bekerja berdasarkan konten HTTP — headers, URL, cookies, body. Bisa membuat keputusan routing yang lebih cerdas. Misalnya, mengirim semua request dengan header <code>Content-Type: image</code> ke server khusus gambar. Lebih lambat dari L4, tapi jauh lebih fleksibel.</p>

<h3>Analogi Sederhana</h3>

<p>Bayangkan sebuah <strong>supermarket besar</strong> dengan banyak kasir. Ada seorang <strong>koordinator kasir</strong> di pintu masuk yang mengarahkan setiap pelanggan (request) ke kasir (server) yang antreannya paling pendek atau sesuai giliran. Ketika seorang kasir sakit dan tidak bisa bekerja, koordinator berhenti mengirim pelanggan ke kasir tersebut.</p>

<p>Itulah load balancer.</p>

<h2>Bagian 3: API Gateway — Penjaga Gerbang yang Cerdas</h2>

<h3>Apa Itu API Gateway?</h3>

<p>API Gateway adalah komponen yang <strong>secara khusus dirancang untuk mengelola, mengontrol, dan mengamankan akses ke API</strong>. Ini bukan sekadar proxy atau distributor traffic — ini adalah lapisan <em>business logic</em> yang kaya fitur.</p>

<p>Jika reverse proxy adalah resepsionis gedung dan load balancer adalah koordinator kasir, maka API Gateway adalah <strong>kepala keamanan + manajer operasional</strong> yang duduk di gerbang utama — memastikan setiap orang yang masuk memiliki izin, mencatat siapa yang masuk dan kapan, membatasi berapa banyak yang bisa masuk dalam satu waktu, dan mengubah format permintaan jika perlu.</p>

<pre><code>            ┌── [Autentikasi]
            ├── [Rate Limiting]
[Klien] ──► [API Gateway] ─── [Routing] ──► [Microservices]
            ├── [Logging]
            └── [Transformasi Request]</code></pre>

<h3>Fitur-Fitur Utama API Gateway</h3>

<p><strong>1. Autentikasi dan Otorisasi</strong></p>
<p>API Gateway memverifikasi identitas setiap request. Apakah klien memiliki API key yang valid? Apakah token JWT mereka masih berlaku? Apakah mereka memiliki izin untuk mengakses endpoint ini? Semua pemeriksaan ini dilakukan di gateway sebelum request sampai ke backend.</p>

<p><strong>2. Rate Limiting dan Throttling</strong></p>
<p>Membatasi jumlah request yang bisa dilakukan oleh klien dalam periode waktu tertentu. Misalnya, "pengguna tier gratis hanya bisa melakukan 100 request per jam". Ini melindungi backend dari penyalahgunaan dan memastikan layanan tetap tersedia untuk semua pengguna.</p>

<p><strong>3. Request dan Response Transformation</strong></p>
<p>API Gateway bisa memodifikasi request sebelum dikirim ke backend, dan memodifikasi response sebelum dikirim ke klien. Misalnya, mengubah format JSON menjadi XML, menambahkan header tertentu, atau menyembunyikan field sensitif dari response.</p>

<p><strong>4. Routing ke Microservices</strong></p>
<p>Dalam arsitektur microservices, satu klien mungkin perlu berkomunikasi dengan belasan service berbeda. API Gateway menyederhanakan ini: klien hanya perlu tahu satu endpoint (gateway), dan gateway yang mengurus routing ke service yang tepat.</p>

<p><strong>5. Caching</strong></p>
<p>Menyimpan respons API sehingga request berikutnya untuk data yang sama tidak perlu sampai ke backend.</p>

<p><strong>6. Logging dan Monitoring</strong></p>
<p>Setiap request tercatat — siapa yang meminta apa, kapan, dan berapa lama prosesnya. Ini sangat berharga untuk debugging, audit, dan analitik.</p>

<p><strong>7. Circuit Breaker</strong></p>
<p>Jika sebuah backend service mengalami gangguan, API Gateway bisa "memutus sirkuit" dan langsung mengembalikan error atau fallback response tanpa membanjiri service yang sedang sakit dengan request.</p>

<p><strong>8. API Versioning</strong></p>
<p>Memungkinkan pengelolaan beberapa versi API secara bersamaan. Request ke <code>/v1/users</code> diarahkan ke service versi lama, sementara <code>/v2/users</code> diarahkan ke service versi baru.</p>

<h3>Contoh Produk API Gateway</h3>

<ul>
    <li><strong>AWS API Gateway</strong> — solusi managed dari Amazon, terintegrasi erat dengan Lambda dan ekosistem AWS</li>
    <li><strong>Kong</strong> — open source, sangat extensible dengan sistem plugin</li>
    <li><strong>Apigee</strong> — enterprise-grade dari Google, fokus pada manajemen API lifecycle</li>
    <li><strong>Traefik</strong> — modern, cloud-native, populer di lingkungan Kubernetes</li>
    <li><strong>Azure API Management</strong> — solusi Microsoft untuk Azure ecosystem</li>
</ul>

<h3>Analogi Sederhana</h3>

<p>Bayangkan sebuah <strong>gedung korporat</strong> dengan sistem keamanan berlapis. Di pintu masuk ada <strong>petugas keamanan yang sangat terlatih</strong>: ia memeriksa ID setiap orang, memastikan mereka hanya boleh masuk ke lantai yang sesuai dengan jabatan mereka, mencatat waktu masuk dan keluar, membatasi berapa kali seseorang boleh bolak-balik dalam satu hari, dan mengubah pesan titipan ke dalam format yang bisa dipahami oleh orang di dalam.</p>

<p>Itulah API Gateway.</p>

<h2>Bagian 4: Perbandingan Langsung — Perbedaan yang Harus Kamu Pahami</h2>

<h3>Tabel Perbandingan</h3>

<table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse: collapse; margin-bottom: 20px;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>Aspek</th>
            <th>Reverse Proxy</th>
            <th>Load Balancer</th>
            <th>API Gateway</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>Fungsi Utama</strong></td>
            <td>Meneruskan &amp; menyembunyikan backend</td>
            <td>Mendistribusikan traffic</td>
            <td>Mengelola &amp; mengamankan API</td>
        </tr>
        <tr>
            <td><strong>Level OSI</strong></td>
            <td>Layer 7</td>
            <td>Layer 4 atau 7</td>
            <td>Layer 7</td>
        </tr>
        <tr>
            <td><strong>Autentikasi</strong></td>
            <td>❌ Tidak</td>
            <td>❌ Tidak</td>
            <td>✅ Ya</td>
        </tr>
        <tr>
            <td><strong>Rate Limiting</strong></td>
            <td>❌ Tidak</td>
            <td>❌ Tidak</td>
            <td>✅ Ya</td>
        </tr>
        <tr>
            <td><strong>Distribusi Traffic</strong></td>
            <td>❌ Terbatas</td>
            <td>✅ Inti fungsinya</td>
            <td>✅ Bisa</td>
        </tr>
        <tr>
            <td><strong>Health Check</strong></td>
            <td>❌ Terbatas</td>
            <td>✅ Ya</td>
            <td>✅ Ya</td>
        </tr>
        <tr>
            <td><strong>Request Transform</strong></td>
            <td>❌ Minimal</td>
            <td>❌ Tidak</td>
            <td>✅ Ya</td>
        </tr>
        <tr>
            <td><strong>Caching</strong></td>
            <td>✅ Ya</td>
            <td>❌ Tidak</td>
            <td>✅ Ya</td>
        </tr>
        <tr>
            <td><strong>SSL Termination</strong></td>
            <td>✅ Ya</td>
            <td>✅ Bisa</td>
            <td>✅ Ya</td>
        </tr>
        <tr>
            <td><strong>Kompleksitas</strong></td>
            <td>Rendah</td>
            <td>Sedang</td>
            <td>Tinggi</td>
        </tr>
        <tr>
            <td><strong>Use Case Utama</strong></td>
            <td>Web server, aset statis</td>
            <td>Skalabilitas horizontal</td>
            <td>Arsitektur API &amp; microservices</td>
        </tr>
    </tbody>
</table>

<h3>Perbedaan Kunci dalam Satu Kalimat</h3>

<ul>
    <li><strong>Reverse Proxy</strong>: "Saya meneruskan request kamu ke server yang tepat dan menyembunyikan siapa server itu."</li>
    <li><strong>Load Balancer</strong>: "Saya mendistribusikan request kamu ke beberapa server agar tidak ada yang kewalahan."</li>
    <li><strong>API Gateway</strong>: "Saya memeriksa apakah kamu berhak membuat request ini, membatasinya jika perlu, mencatatnya, lalu meneruskannya ke service yang tepat."</li>
</ul>

<h2>Bagian 5: Zona Abu-Abu — Mengapa Orang Sering Bingung</h2>

<p>Kebingungan yang terjadi bukan tanpa alasan. Ada beberapa faktor yang membuat batas antara ketiganya terasa kabur:</p>

<h3>1. Produk Modern Menggabungkan Beberapa Peran</h3>

<p><strong>Nginx</strong>, yang secara klasik adalah reverse proxy, kini bisa dikonfigurasi sebagai load balancer dengan upstream module-nya. Bahkan ada Nginx Plus yang menambahkan fitur-fitur seperti health check aktif dan API management dasar.</p>

<p><strong>HAProxy</strong>, yang secara fundamental adalah load balancer, juga berfungsi sebagai reverse proxy dan mendukung terminasi SSL.</p>

<p><strong>Traefik</strong>, yang awalnya dirancang sebagai reverse proxy untuk lingkungan container, kini memiliki fitur load balancing, middleware untuk autentikasi, rate limiting, dan bisa berfungsi sebagai API gateway.</p>

<p><strong>AWS Application Load Balancer (ALB)</strong> adalah load balancer Layer 7 yang juga bisa melakukan routing berbasis path dan header — mirip fungsi dasar API gateway.</p>

<h3>2. Terminologi yang Digunakan Secara Longgar</h3>

<p>Dalam percakapan sehari-hari, seseorang mungkin berkata "kita butuh reverse proxy di depan service kita" padahal yang mereka maksud adalah load balancer. Atau mereka menyebut "API gateway" padahal yang mereka butuhkan hanya reverse proxy sederhana.</p>

<h3>3. Beberapa Fitur Tumpang Tindih</h3>

<p>SSL termination, caching, dan routing berbasis path adalah fitur yang bisa ditemukan di ketiganya. Ini mempersulit identifikasi.</p>

<h3>Cara Membedakannya Secara Konseptual</h3>

<p>Pertanyaan terbaik untuk membedakan ketiganya bukan "apa fiturnya?" tapi <strong>"apa masalah utama yang ia selesaikan?"</strong></p>

<ul>
    <li>Jika masalahnya adalah <strong>menyembunyikan dan melindungi backend dari eksposur langsung</strong> → Reverse Proxy</li>
    <li>Jika masalahnya adalah <strong>mendistribusikan beban di antara beberapa server identik</strong> → Load Balancer</li>
    <li>Jika masalahnya adalah <strong>mengontrol, mengamankan, dan mengelola akses ke API</strong> → API Gateway</li>
</ul>

<h2>Bagian 6: Kapan Menggunakan yang Mana?</h2>

<h3>Gunakan Reverse Proxy Ketika:</h3>

<ul>
    <li>Kamu memiliki beberapa aplikasi web yang berjalan di server yang sama (port berbeda) dan ingin menyatukannya di bawah satu domain</li>
    <li>Kamu ingin mengelola SSL/TLS di satu tempat untuk semua service</li>
    <li>Kamu ingin menyajikan konten statis dengan cepat tanpa membebani server aplikasi</li>
    <li>Kamu ingin menyembunyikan detail infrastruktur internal dari publik</li>
    <li>Tim kecil, aplikasi sederhana, belum butuh distribusi traffic ke banyak server</li>
</ul>

<p><strong>Contoh stack</strong>: Nginx sebagai reverse proxy di depan satu aplikasi Node.js atau Python Flask.</p>

<h3>Gunakan Load Balancer Ketika:</h3>

<ul>
    <li>Traffic kamu sudah terlalu besar untuk ditangani satu server</li>
    <li>Kamu menjalankan beberapa instance server yang identik dan perlu mendistribusikan traffic ke semuanya</li>
    <li>Kamu membutuhkan <em>zero-downtime deployment</em> (dengan mengeluarkan server satu per satu dari rotasi saat update)</li>
    <li>Kamu membutuhkan <em>high availability</em> — jika satu server mati, traffic otomatis dialihkan ke yang lain</li>
    <li>Kamu menjalankan aplikasi stateless di lingkungan cloud</li>
</ul>

<p><strong>Contoh stack</strong>: AWS ALB atau HAProxy di depan cluster dari 5 instance EC2 yang menjalankan aplikasi yang sama.</p>

<h3>Gunakan API Gateway Ketika:</h3>

<ul>
    <li>Kamu membangun atau mengelola <strong>API publik</strong> yang akan diakses oleh developer atau klien eksternal</li>
    <li>Kamu menggunakan <strong>arsitektur microservices</strong> dan butuh satu titik masuk yang menyederhanakan akses ke puluhan service</li>
    <li>Kamu butuh <strong>autentikasi terpusat</strong> — setiap request harus diverifikasi</li>
    <li>Kamu butuh <strong>rate limiting</strong> untuk mencegah penyalahgunaan</li>
    <li>Kamu perlu <strong>monitoring dan analitik</strong> detail tentang penggunaan API</li>
    <li>Kamu mengelola <strong>beberapa versi API</strong> secara bersamaan</li>
</ul>

<p><strong>Contoh stack</strong>: Kong atau AWS API Gateway di depan cluster microservices di Kubernetes.</p>

<h2>Bagian 7: Bagaimana Ketiganya Bekerja Bersama</h2>

<p>Dalam sistem produksi yang kompleks, kamu sangat mungkin menggunakan <strong>ketiga komponen ini secara bersamaan</strong>, masing-masing memainkan perannya yang unik:</p>

<pre><code>[Internet]
    │
    ▼
[API Gateway]          ← Autentikasi, rate limiting, routing berbasis API
    │
    ▼
[Load Balancer]        ← Distribusi traffic ke beberapa instance gateway/service
    │
    ├── [Microservice A]
    │       └── [Reverse Proxy Nginx]   ← SSL termination, caching statis
    │
    ├── [Microservice B]
    │       └── [Reverse Proxy Nginx]
    │
    └── [Microservice C]
            └── [Reverse Proxy Nginx]</code></pre>

<p>Atau dalam versi yang lebih umum di startup dan perusahaan menengah:</p>

<pre><code>[Internet]
    │
    ▼
[API Gateway / Traefik]   ← Menggabungkan peran gateway + reverse proxy + basic LB
    │
    ├── [Service Pengguna]
    ├── [Service Produk]
    ├── [Service Pembayaran]
    └── [Service Notifikasi]</code></pre>

<h2>Bagian 8: Kesalahan Umum yang Harus Dihindari</h2>

<h3>Kesalahan 1: Menggunakan API Gateway untuk Traffic Internal</h3>

<p>API Gateway dirancang untuk mengontrol akses <strong>dari luar ke dalam</strong>. Menggunakannya untuk komunikasi antar-service di dalam jaringan internal adalah overkill — tambahkan latensi yang tidak perlu dan kompleksitas yang tidak diperlukan. Untuk komunikasi internal, gunakan service mesh (seperti Istio) atau panggil service langsung.</p>

<h3>Kesalahan 2: Menggunakan Load Balancer Tanpa Health Check</h3>

<p>Load balancer tanpa health check adalah setengah solusi. Jika sebuah server mati dan load balancer tidak tahu, ia akan terus mengirim traffic ke server yang sudah tidak berfungsi. Selalu aktifkan dan konfigurasikan health check.</p>

<h3>Kesalahan 3: Lupa SSL Termination di Reverse Proxy</h3>

<p>Banyak tim mengelola sertifikat SSL secara terpisah di setiap server backend. Ini menyulitkan pembaruan sertifikat dan meningkatkan risiko human error. Centralkan SSL termination di reverse proxy atau API Gateway.</p>

<h3>Kesalahan 4: Menaruh Business Logic di API Gateway</h3>

<p>API Gateway yang baik menangani <em>cross-cutting concerns</em> (autentikasi, logging, rate limiting) — bukan logika bisnis aplikasi. Jika kamu menaruh logika seperti "jika pengguna adalah premium maka tampilkan X" di gateway, kamu sedang membuat masalah maintainability di masa depan.</p>

<h3>Kesalahan 5: Mengabaikan Single Point of Failure</h3>

<p>Baik reverse proxy, load balancer, maupun API Gateway — jika hanya ada satu instance dan ia mati, seluruh sistem mati. Selalu pertimbangkan untuk menjalankan beberapa instance dari komponen-komponen ini juga, dengan load balancer di depannya (ya, load balancer juga bisa di-load-balance!).</p>

<h2>Kesimpulan</h2>

<p>Mari kita rangkum perbedaan mendasar antara ketiga komponen ini:</p>

<p><strong>Reverse Proxy</strong> adalah tentang <strong>transparansi dan perlindungan infrastruktur</strong>. Ia berdiri di antara klien dan backend, menyembunyikan kompleksitas internal dan menangani hal-hal seperti SSL, caching, dan routing dasar. Nginx adalah contoh paling ikonik.</p>

<p><strong>Load Balancer</strong> adalah tentang <strong>skalabilitas dan ketersediaan</strong>. Ia mendistribusikan traffic ke beberapa server, memastikan tidak ada yang kelebihan beban, dan secara otomatis mengeksklusi server yang tidak sehat. HAProxy dan AWS ALB adalah contoh yang populer.</p>

<p><strong>API Gateway</strong> adalah tentang <strong>kontrol dan manajemen akses</strong>. Ia mengelola siapa yang boleh mengakses API, berapa sering, dengan format apa, dan mencatat semua yang terjadi. Kong, Apigee, dan AWS API Gateway adalah pilihan populer di industri.</p>

<p>Ketiganya tidak saling eksklusif — dalam sistem yang matang, kamu kemungkinan besar akan menggunakan ketiganya. Yang penting adalah memahami peran unik masing-masing sehingga kamu bisa membuat keputusan arsitektur yang tepat, bukan sekadar memilih berdasarkan nama yang paling familiar.</p>

<p>Dengan pemahaman yang benar, kamu tidak hanya akan bisa mendiskusikan arsitektur sistem dengan lebih percaya diri, tapi juga akan mendesain sistem yang lebih efisien, aman, dan mudah di-maintain.</p>
',
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(50, 200),
        ]);

        $this->command->info('API Gateway vs Load Balancer vs Reverse Proxy Article created successfully!');
    }
}
