<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class JenisApiTulangPunggungArticleSeeder extends Seeder
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

        // Create Jenis API article
        Article::create([
            'title' => 'Mengenal Berbagai Jenis API: Tulang Punggung Aplikasi Modern',
            'slug' => 'mengenal-berbagai-jenis-api-tulang-punggung-aplikasi-modern',
            'excerpt' => 'Panduan definitif untuk memahami enam jenis API utama — REST, SOAP, GraphQL, WebSocket, gRPC, dan Open API — lengkap dengan cara kerja internal, contoh kode, analogi nyata, studi kasus industri, dan panduan memilih API yang tepat untuk setiap kebutuhan.',
            'content' => '
<p>Dalam dunia pengembangan perangkat lunak masa kini, <strong>API (Application Programming Interface)</strong> adalah tulang punggung yang menopang berjalannya aplikasi modern. Tanpa API, berbagai layanan digital yang kita gunakan sehari-hari — dari memesan ojek online, membayar tagihan via mobile banking, hingga menonton film di platform streaming — tidak akan bisa saling berkomunikasi dan beroperasi.</p>

<p>Secara teknis, API adalah <strong>kontrak komunikasi</strong> antara dua perangkat lunak. Ia mendefinisikan bagaimana satu sistem bisa meminta data atau layanan dari sistem lain, apa format permintaannya, dan bagaimana respons yang akan diterima. Bayangkan API sebagai <strong>pelayan restoran</strong>: Anda (klien) memesan makanan melalui pelayan (API), pelayan menyampaikan pesanan ke dapur (server), dan membawakan hasilnya kembali kepada Anda.</p>

<h2>Mengapa API Sangat Penting?</h2>

<p>Kehadiran API memberikan empat manfaat strategis yang menjadi fondasi ekosistem teknologi global:</p>

<table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse: collapse; margin-bottom: 20px;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>Pilar</th>
            <th>Penjelasan</th>
            <th>Contoh Nyata</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>🔗 Connect</strong></td>
            <td>Menghubungkan berbagai sistem heterogen agar dapat berkolaborasi secara mulus</td>
            <td>Aplikasi e-commerce terhubung ke payment gateway, logistik, dan notifikasi SMS — semua melalui API</td>
        </tr>
        <tr>
            <td><strong>⚡ Enable</strong></td>
            <td>Menjadi motor penggerak fitur dan mempercepat proses development</td>
            <td>Startup bisa meluncurkan produk dalam hitungan minggu dengan memanfaatkan API pihak ketiga (Maps, Auth, Payment)</td>
        </tr>
        <tr>
            <td><strong>🔒 Secure</strong></td>
            <td>Memastikan komunikasi data berjalan aman dengan mengikuti standar dan best practice</td>
            <td>API perbankan menerapkan OAuth 2.0, enkripsi TLS, dan rate limiting untuk melindungi data nasabah</td>
        </tr>
        <tr>
            <td><strong>📈 Scale</strong></td>
            <td>Memungkinkan sistem berkembang dari aplikasi sederhana hingga platform berskala global</td>
            <td>Twitter API menangani miliaran request per hari berkat arsitektur API yang scalable</td>
        </tr>
    </tbody>
</table>

<p>Namun, tidak semua API diciptakan sama. Berbagai jenis API dikembangkan untuk menjawab kebutuhan sistem yang berbeda-beda. Memilih jenis API yang salah bisa mengakibatkan <strong>bottleneck performa</strong>, <strong>kompleksitas yang tidak perlu</strong>, atau bahkan <strong>kegagalan arsitektur</strong> di kemudian hari.</p>

<p>Berikut adalah bedah lengkap enam jenis API utama yang wajib dikuasai oleh setiap pengembang dan pegiat teknologi.</p>

<h2>1. REST API — Pilihan Utama yang Ringan dan Populer</h2>

<h3>Apa Itu REST API?</h3>

<p><strong>REST (Representational State Transfer)</strong> adalah gaya arsitektur API yang paling banyak digunakan saat ini. Diciptakan oleh Roy Fielding pada tahun 2000 dalam disertasi doktoralnya, REST dirancang berdasarkan prinsip-prinsip arsitektur web itu sendiri — memanfaatkan protokol HTTP yang sudah ada secara optimal.</p>

<p>REST bukan protokol, melainkan <strong>sekumpulan prinsip desain</strong> (architectural constraints) yang jika diikuti, menghasilkan API yang sederhana, scalable, dan mudah dipahami.</p>

<h3>Prinsip-Prinsip Utama REST</h3>

<p><strong>1. Stateless (Tanpa State)</strong></p>
<p>Setiap request dari klien ke server harus memuat <strong>semua informasi</strong> yang dibutuhkan server untuk memproses permintaan tersebut. Server tidak menyimpan konteks sesi klien di antara request. Ini membuat REST sangat scalable — server bisa melayani jutaan klien tanpa harus mengingat siapa masing-masing.</p>

<p><strong>2. Client-Server Separation</strong></p>
<p>Klien dan server adalah entitas independen. Klien tidak perlu tahu bagaimana server menyimpan data, dan server tidak perlu tahu bagaimana klien menampilkan data. Pemisahan ini memungkinkan keduanya berkembang secara mandiri.</p>

<p><strong>3. Uniform Interface</strong></p>
<p>Semua resource diakses melalui URL yang konsisten dan menggunakan metode HTTP standar.</p>

<p><strong>4. Cacheable</strong></p>
<p>Respons bisa ditandai sebagai <em>cacheable</em> atau <em>non-cacheable</em>, memungkinkan klien atau perantara menyimpan respons untuk meningkatkan performa.</p>

<h3>Metode HTTP dalam REST</h3>

<table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse: collapse; margin-bottom: 20px;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>Metode</th>
            <th>Operasi CRUD</th>
            <th>Contoh Endpoint</th>
            <th>Deskripsi</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><code>GET</code></td>
            <td>Read</td>
            <td><code>GET /api/users</code></td>
            <td>Mengambil daftar semua pengguna</td>
        </tr>
        <tr>
            <td><code>GET</code></td>
            <td>Read</td>
            <td><code>GET /api/users/42</code></td>
            <td>Mengambil data pengguna dengan ID 42</td>
        </tr>
        <tr>
            <td><code>POST</code></td>
            <td>Create</td>
            <td><code>POST /api/users</code></td>
            <td>Membuat pengguna baru</td>
        </tr>
        <tr>
            <td><code>PUT</code></td>
            <td>Update (Full)</td>
            <td><code>PUT /api/users/42</code></td>
            <td>Memperbarui seluruh data pengguna 42</td>
        </tr>
        <tr>
            <td><code>PATCH</code></td>
            <td>Update (Partial)</td>
            <td><code>PATCH /api/users/42</code></td>
            <td>Memperbarui sebagian data pengguna 42</td>
        </tr>
        <tr>
            <td><code>DELETE</code></td>
            <td>Delete</td>
            <td><code>DELETE /api/users/42</code></td>
            <td>Menghapus pengguna 42</td>
        </tr>
    </tbody>
</table>

<h3>Contoh Request dan Response</h3>

<p><strong>Request — Mengambil data pengguna:</strong></p>
<pre><code>GET /api/users/42 HTTP/1.1
Host: api.contoh.com
Accept: application/json
Authorization: Bearer eyJhbGciOiJIUzI1NiJ9...</code></pre>

<p><strong>Response — JSON:</strong></p>
<pre><code>{
  "id": 42,
  "nama": "Budi Santoso",
  "email": "budi@contoh.com",
  "role": "developer",
  "created_at": "2025-01-15T08:30:00Z"
}</code></pre>

<p><strong>Contoh Kode (JavaScript Fetch API):</strong></p>
<pre><code>// GET — Mengambil data
const response = await fetch(\'https://api.contoh.com/users/42\', {
  headers: { \'Authorization\': \'Bearer token_anda\' }
});
const user = await response.json();

// POST — Membuat data baru
const newUser = await fetch(\'https://api.contoh.com/users\', {
  method: \'POST\',
  headers: {
    \'Content-Type\': \'application/json\',
    \'Authorization\': \'Bearer token_anda\'
  },
  body: JSON.stringify({
    nama: \'Siti Rahayu\',
    email: \'siti@contoh.com\',
    role: \'designer\'
  })
});</code></pre>

<h3>HTTP Status Code yang Wajib Dipahami</h3>

<table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse: collapse; margin-bottom: 20px;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>Kode</th>
            <th>Arti</th>
            <th>Kapan Digunakan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><code>200 OK</code></td>
            <td>Berhasil</td>
            <td>GET atau PUT berhasil</td>
        </tr>
        <tr>
            <td><code>201 Created</code></td>
            <td>Resource baru dibuat</td>
            <td>POST berhasil membuat data baru</td>
        </tr>
        <tr>
            <td><code>204 No Content</code></td>
            <td>Berhasil tanpa respons body</td>
            <td>DELETE berhasil</td>
        </tr>
        <tr>
            <td><code>400 Bad Request</code></td>
            <td>Request tidak valid</td>
            <td>Format data salah atau validasi gagal</td>
        </tr>
        <tr>
            <td><code>401 Unauthorized</code></td>
            <td>Belum terautentikasi</td>
            <td>Token tidak ada atau expired</td>
        </tr>
        <tr>
            <td><code>403 Forbidden</code></td>
            <td>Tidak punya izin</td>
            <td>Role tidak sesuai untuk akses resource</td>
        </tr>
        <tr>
            <td><code>404 Not Found</code></td>
            <td>Resource tidak ditemukan</td>
            <td>ID atau endpoint tidak ada</td>
        </tr>
        <tr>
            <td><code>429 Too Many Requests</code></td>
            <td>Rate limit terlampaui</td>
            <td>Terlalu banyak request dalam waktu singkat</td>
        </tr>
        <tr>
            <td><code>500 Internal Server Error</code></td>
            <td>Kesalahan server</td>
            <td>Bug atau crash di sisi server</td>
        </tr>
    </tbody>
</table>

<h3>Kelebihan &amp; Kekurangan REST</h3>

<table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse: collapse; margin-bottom: 20px;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>✅ Kelebihan</th>
            <th>❌ Kekurangan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Sangat sederhana dan mudah dipahami</td>
            <td><em>Over-fetching</em> — sering mengembalikan data lebih dari yang dibutuhkan</td>
        </tr>
        <tr>
            <td>Menggunakan standar HTTP yang sudah universal</td>
            <td><em>Under-fetching</em> — butuh banyak request untuk data yang saling terkait</td>
        </tr>
        <tr>
            <td>Mudah di-cache karena sifat stateless</td>
            <td>Tidak ada standar baku (setiap developer bisa mendesain berbeda)</td>
        </tr>
        <tr>
            <td>Didukung oleh hampir semua bahasa pemrograman</td>
            <td>Kurang efisien untuk relasi data yang kompleks dan bersarang</td>
        </tr>
        <tr>
            <td>Skalabel secara horizontal</td>
            <td>Tidak mendukung komunikasi real-time secara native</td>
        </tr>
    </tbody>
</table>

<h3>Studi Kasus Industri</h3>

<p><strong>Twitter/X API</strong> menggunakan REST sebagai fondasi utamanya. Setiap tweet, user, dan timeline diakses melalui endpoint REST yang terstruktur. Dengan REST, jutaan developer di seluruh dunia bisa membangun aplikasi yang terintegrasi dengan Twitter — dari bot otomatis hingga dashboard analitik.</p>

<h2>2. SOAP API — Standar Keamanan Tinggi untuk Skala Enterprise</h2>

<h3>Apa Itu SOAP API?</h3>

<p><strong>SOAP (Simple Object Access Protocol)</strong> bukanlah sekadar gaya arsitektur seperti REST — ia adalah <strong>protokol komunikasi</strong> yang sangat terstruktur dan formal. SOAP dikembangkan oleh Microsoft pada akhir 1990-an dan telah menjadi standar de facto untuk komunikasi enterprise selama lebih dari dua dekade.</p>

<p>Jika REST adalah percakapan santai lewat pesan singkat, SOAP adalah <strong>surat resmi berstempel dan berlegalisir</strong> — setiap detail diatur, setiap langkah diverifikasi.</p>

<h3>Cara Kerja SOAP</h3>

<p>SOAP menggunakan format XML secara eksklusif untuk semua komunikasi. Setiap pesan SOAP memiliki struktur yang sangat ketat:</p>

<pre><code>&lt;?xml version="1.0" encoding="UTF-8"?&gt;
&lt;soap:Envelope
  xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"
  xmlns:bank="http://bank.contoh.com/transaksi"&gt;

  &lt;soap:Header&gt;
    &lt;bank:Authentication&gt;
      &lt;bank:Token&gt;abc123xyz789&lt;/bank:Token&gt;
      &lt;bank:Timestamp&gt;2025-06-08T10:30:00Z&lt;/bank:Timestamp&gt;
    &lt;/bank:Authentication&gt;
  &lt;/soap:Header&gt;

  &lt;soap:Body&gt;
    &lt;bank:TransferDana&gt;
      &lt;bank:RekeningAsal&gt;1234567890&lt;/bank:RekeningAsal&gt;
      &lt;bank:RekeningTujuan&gt;0987654321&lt;/bank:RekeningTujuan&gt;
      &lt;bank:Jumlah&gt;5000000&lt;/bank:Jumlah&gt;
      &lt;bank:MataUang&gt;IDR&lt;/bank:MataUang&gt;
    &lt;/bank:TransferDana&gt;
  &lt;/soap:Body&gt;

&lt;/soap:Envelope&gt;</code></pre>

<p>Struktur ini terdiri dari tiga bagian utama:</p>
<ul>
    <li><strong>Envelope</strong> — Pembungkus utama yang menandai ini adalah pesan SOAP</li>
    <li><strong>Header</strong> — Metadata seperti autentikasi, routing, dan informasi konteks</li>
    <li><strong>Body</strong> — Isi pesan yang sebenarnya (data yang dikirim/diminta)</li>
</ul>

<h3>WSDL — Kontrak Formal SOAP</h3>

<p>Setiap SOAP API wajib memiliki dokumen <strong>WSDL (Web Services Description Language)</strong> — sebuah file XML yang mendeskripsikan secara lengkap:</p>
<ul>
    <li>Operasi apa saja yang tersedia</li>
    <li>Format input dan output untuk setiap operasi</li>
    <li>Protokol dan alamat endpoint</li>
    <li>Tipe data yang digunakan</li>
</ul>
<p>WSDL adalah "buku petunjuk resmi" yang memungkinkan tool otomatis men-<em>generate</em> kode klien tanpa membaca dokumentasi manual.</p>

<h3>Standar WS-* (Web Services Standards)</h3>

<p>Keunggulan terbesar SOAP terletak pada ekosistem standar <strong>WS-*</strong> yang sangat matang:</p>
<ul>
    <li><strong>WS-Security</strong> — Enkripsi pesan end-to-end, tanda tangan digital, dan token keamanan</li>
    <li><strong>WS-ReliableMessaging</strong> — Menjamin pesan terkirim meskipun jaringan bermasalah</li>
    <li><strong>WS-AtomicTransaction</strong> — Transaksi ACID lintas beberapa service</li>
    <li><strong>WS-Addressing</strong> — Routing pesan yang independen dari transport layer</li>
</ul>

<h3>Kelebihan &amp; Kekurangan SOAP</h3>

<table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse: collapse; margin-bottom: 20px;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>✅ Kelebihan</th>
            <th>❌ Kekurangan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Keamanan tingkat militer (WS-Security)</td>
            <td>Sangat verbose — XML jauh lebih besar dari JSON</td>
        </tr>
        <tr>
            <td>Transaksi ACID lintas service</td>
            <td>Kurva belajar yang curam</td>
        </tr>
        <tr>
            <td>Kontrak formal via WSDL (auto-generate client)</td>
            <td>Overhead parsing XML yang berat</td>
        </tr>
        <tr>
            <td>Tidak terikat pada HTTP saja (bisa SMTP, TCP, JMS)</td>
            <td>Tidak cocok untuk aplikasi mobile (bandwidth mahal)</td>
        </tr>
        <tr>
            <td>Reliable messaging untuk pesan kritis</td>
            <td>Tooling dan debugging yang lebih kompleks</td>
        </tr>
    </tbody>
</table>

<h3>Studi Kasus Industri</h3>

<p><strong>Sistem BI-FAST Bank Indonesia</strong> dan hampir semua <em>core banking system</em> menggunakan SOAP API karena kebutuhan transaksi keuangan yang menuntut keamanan tingkat tinggi, pengiriman pesan yang dijamin, dan kemampuan transaksi ACID. Satu kegagalan transfer dana bisa berakibat fatal — inilah domain di mana SOAP tidak tergantikan.</p>

<h2>3. GraphQL API — Efisien, Fleksibel, dan Tanpa <em>Over-fetching</em></h2>

<h3>Apa Itu GraphQL?</h3>

<p><strong>GraphQL</strong> adalah bahasa query untuk API yang dikembangkan oleh <strong>Facebook (Meta)</strong> pada tahun 2012 dan dirilis sebagai open-source pada 2015. GraphQL lahir dari frustrasi engineer Facebook terhadap keterbatasan REST saat membangun aplikasi mobile News Feed yang sangat kompleks.</p>

<p>Masalah utama REST yang disorot: untuk menampilkan satu halaman profil pengguna di aplikasi mobile, diperlukan <strong>3-5 request terpisah</strong> (data user, daftar post, daftar friends, dll.), dan setiap request mengembalikan data yang <strong>lebih banyak</strong> dari yang dibutuhkan.</p>

<h3>Cara Kerja GraphQL</h3>

<p>Berbeda dengan REST yang memiliki banyak endpoint, GraphQL menggunakan <strong>satu endpoint tunggal</strong> di mana klien mengirimkan "query" yang mendeskripsikan secara tepat data apa yang diinginkan.</p>

<p><strong>Contoh Query — Ambil data user beserta post-nya:</strong></p>
<pre><code># Request: POST /graphql
query {
  user(id: 42) {
    nama
    email
    posts(limit: 5) {
      judul
      tanggal
      komentar {
        isi
        penulis {
          nama
        }
      }
    }
  }
}</code></pre>

<p><strong>Response — Hanya data yang diminta:</strong></p>
<pre><code>{
  "data": {
    "user": {
      "nama": "Budi Santoso",
      "email": "budi@contoh.com",
      "posts": [
        {
          "judul": "Belajar GraphQL",
          "tanggal": "2025-06-01",
          "komentar": [
            {
              "isi": "Artikel bagus!",
              "penulis": { "nama": "Siti" }
            }
          ]
        }
      ]
    }
  }
}</code></pre>

<p>Dengan REST, query di atas membutuhkan <strong>minimal 3 request terpisah</strong>:</p>
<pre><code>GET /api/users/42           → Data user
GET /api/users/42/posts     → Daftar post (semua field, bukan hanya judul &amp; tanggal)
GET /api/posts/1/comments   → Komentar (perlu diulang untuk setiap post)</code></pre>

<h3>Tiga Operasi Utama GraphQL</h3>

<table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse: collapse; margin-bottom: 20px;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>Operasi</th>
            <th>Fungsi</th>
            <th>Setara REST</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>Query</strong></td>
            <td>Membaca data</td>
            <td>GET</td>
        </tr>
        <tr>
            <td><strong>Mutation</strong></td>
            <td>Mengubah data (create/update/delete)</td>
            <td>POST, PUT, DELETE</td>
        </tr>
        <tr>
            <td><strong>Subscription</strong></td>
            <td>Menerima update real-time via WebSocket</td>
            <td>Tidak ada padanan langsung</td>
        </tr>
    </tbody>
</table>

<p><strong>Contoh Mutation:</strong></p>
<pre><code>mutation {
  createUser(input: {
    nama: "Dewi Lestari"
    email: "dewi@contoh.com"
    role: DESIGNER
  }) {
    id
    nama
    created_at
  }
}</code></pre>

<h3>Kelebihan &amp; Kekurangan GraphQL</h3>

<table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse: collapse; margin-bottom: 20px;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>✅ Kelebihan</th>
            <th>❌ Kekurangan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Tidak ada over-fetching maupun under-fetching</td>
            <td>Caching lebih kompleks (tidak bisa cache per URL)</td>
        </tr>
        <tr>
            <td>Satu endpoint untuk semua kebutuhan data</td>
            <td>Query yang sangat kompleks bisa membebani server</td>
        </tr>
        <tr>
            <td>Self-documenting melalui introspection</td>
            <td>Kurva belajar lebih tinggi dari REST</td>
        </tr>
        <tr>
            <td>Strongly typed schema</td>
            <td>Butuh query complexity analysis untuk keamanan</td>
        </tr>
        <tr>
            <td>Developer experience yang sangat baik (GraphiQL, Playground)</td>
            <td>Upload file tidak se-straightforward REST</td>
        </tr>
    </tbody>
</table>

<h3>Studi Kasus Industri</h3>

<p><strong>GitHub API v4</strong> sepenuhnya dibangun dengan GraphQL. Alasannya: developer yang menggunakan GitHub API membutuhkan data yang sangat bervariasi — ada yang hanya perlu nama repo, ada yang butuh seluruh history commit beserta contributor-nya. Dengan GraphQL, setiap developer bisa meminta persis data yang mereka butuhkan, menghemat bandwidth hingga <strong>10x lipat</strong> dibanding API v3 (REST) mereka.</p>

<h2>4. WebSocket API — Komunikasi <em>Real-Time</em> Dua Arah</h2>

<h3>Apa Itu WebSocket?</h3>

<p>Jika REST dan GraphQL bekerja dengan model <strong>request-response</strong> (klien bertanya, server menjawab), <strong>WebSocket</strong> memungkinkan komunikasi <strong>dua arah (full-duplex)</strong> yang berjalan terus-menerus melalui satu koneksi yang tetap terbuka.</p>

<p>Analoginya: REST seperti <strong>berkirim surat</strong> — setiap kali ingin informasi baru, Anda harus menulis dan mengirim surat baru. WebSocket seperti <strong>telepon</strong> — begitu tersambung, kedua pihak bisa berbicara kapan saja tanpa harus menelepon ulang.</p>

<h3>Cara Kerja WebSocket</h3>

<p>WebSocket dimulai sebagai koneksi HTTP biasa, lalu di-<em>upgrade</em> menjadi koneksi WebSocket melalui proses yang disebut <strong>WebSocket Handshake</strong>:</p>

<pre><code>┌─────────┐                               ┌─────────┐
│  Klien  │                               │ Server  │
└────┬────┘                               └────┬────┘
     │                                         │
     │  GET /chat HTTP/1.1                     │
     │  Upgrade: websocket                     │
     │  Connection: Upgrade                    │
     │ ────────────────────────────────────────►│
     │                                         │
     │  HTTP/1.1 101 Switching Protocols       │
     │  Upgrade: websocket                     │
     │ ◄────────────────────────────────────────│
     │                                         │
     │  ═══ Koneksi WebSocket Terbuka ═══      │
     │                                         │
     │  Pesan dari klien ──────────────────────►│
     │ ◄────────────────────── Pesan dari server│
     │  Pesan dari klien ──────────────────────►│
     │ ◄────────────────────── Pesan dari server│
     │                                         │
     │  (Koneksi terus terbuka sampai          │
     │   salah satu pihak menutupnya)          │</code></pre>

<h3>Contoh Kode WebSocket</h3>

<p><strong>Klien (JavaScript di Browser):</strong></p>
<pre><code>// Membuka koneksi WebSocket
const socket = new WebSocket(\'wss://api.contoh.com/chat\');

// Event: Koneksi terbuka
socket.addEventListener(\'open\', () =&gt; {
  console.log(\'Terhubung ke server!\');
  socket.send(JSON.stringify({
    tipe: \'chat\',
    pesan: \'Halo semua!\'
  }));
});

// Event: Menerima pesan dari server
socket.addEventListener(\'message\', (event) =&gt; {
  const data = JSON.parse(event.data);
  console.log(\'Pesan masuk:\', data.pesan);
});

// Event: Koneksi terputus
socket.addEventListener(\'close\', (event) =&gt; {
  console.log(\'Koneksi ditutup, kode:\', event.code);
});</code></pre>

<p><strong>Server (Node.js dengan library ws):</strong></p>
<pre><code>const WebSocket = require(\'ws\');
const server = new WebSocket.Server({ port: 8080 });

// Simpan semua klien yang terhubung
const clients = new Set();

server.on(\'connection\', (socket) =&gt; {
  clients.add(socket);
  console.log(\'Klien baru terhubung. Total:\', clients.size);

  // Terima pesan dari klien
  socket.on(\'message\', (data) =&gt; {
    const pesan = JSON.parse(data);

    // Broadcast ke semua klien lain (chat room)
    clients.forEach((client) =&gt; {
      if (client !== socket &amp;&amp; client.readyState === WebSocket.OPEN) {
        client.send(JSON.stringify(pesan));
      }
    });
  });

  socket.on(\'close\', () =&gt; {
    clients.delete(socket);
  });
});</code></pre>

<h3>Perbandingan: REST Polling vs WebSocket</h3>

<table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse: collapse; margin-bottom: 20px;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>Aspek</th>
            <th>REST Polling</th>
            <th>WebSocket</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>Cara mendapatkan data baru</strong></td>
            <td>Klien bertanya berulang setiap X detik</td>
            <td>Server langsung kirim saat ada data baru</td>
        </tr>
        <tr>
            <td><strong>Latensi</strong></td>
            <td>Tergantung interval polling (detik)</td>
            <td>Milidetik</td>
        </tr>
        <tr>
            <td><strong>Beban jaringan</strong></td>
            <td>Tinggi — banyak request sia-sia (tidak ada data baru)</td>
            <td>Rendah — data hanya dikirim saat ada perubahan</td>
        </tr>
        <tr>
            <td><strong>Koneksi</strong></td>
            <td>Buka → tutup setiap request</td>
            <td>Sekali buka, terus terhubung</td>
        </tr>
        <tr>
            <td><strong>Kompleksitas server</strong></td>
            <td>Sederhana (stateless)</td>
            <td>Lebih kompleks (harus kelola koneksi aktif)</td>
        </tr>
    </tbody>
</table>

<h3>Kelebihan &amp; Kekurangan WebSocket</h3>

<table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse: collapse; margin-bottom: 20px;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>✅ Kelebihan</th>
            <th>❌ Kekurangan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Latensi sangat rendah (milidetik)</td>
            <td>Lebih sulit di-scale (koneksi persisten)</td>
        </tr>
        <tr>
            <td>Efisien — tidak ada overhead HTTP berulang</td>
            <td>Tidak bisa di-cache seperti REST</td>
        </tr>
        <tr>
            <td>Komunikasi bidirectional</td>
            <td>Load balancing lebih kompleks (sticky sessions)</td>
        </tr>
        <tr>
            <td>Native di semua browser modern</td>
            <td>Firewall dan proxy bisa memblokir koneksi WebSocket</td>
        </tr>
    </tbody>
</table>

<h3>Studi Kasus Industri</h3>

<p><strong>Slack</strong> menggunakan WebSocket secara masif untuk fitur messaging real-time-nya. Setiap kali anggota tim mengetik pesan, indikator "sedang mengetik..." langsung muncul di layar anggota lain — tanpa delay, tanpa polling. Slack mengelola <strong>jutaan koneksi WebSocket simultan</strong> di infrastruktur mereka.</p>

<h2>5. gRPC API — Si Cepat Andalan Arsitektur <em>Microservices</em></h2>

<h3>Apa Itu gRPC?</h3>

<p><strong>gRPC (gRPC Remote Procedure Call)</strong> adalah framework RPC open-source berkinerja tinggi yang dikembangkan oleh <strong>Google</strong> dan dirilis pada tahun 2015. gRPC dirancang untuk komunikasi antar-service yang sangat cepat dan efisien — domain di mana REST mulai terasa berat.</p>

<p>Jika REST adalah <strong>mengirim surat pos</strong> (teks yang mudah dibaca manusia, tapi besar), maka gRPC adalah <strong>mengirim kode morse</strong> (tidak mudah dibaca manusia, tapi jauh lebih ringkas dan cepat).</p>

<h3>Mengapa gRPC Lebih Cepat dari REST?</h3>

<p>Tiga faktor utama yang membuat gRPC sangat cepat:</p>

<p><strong>1. Protocol Buffers (Protobuf) vs JSON</strong></p>
<p>REST menggunakan JSON (teks) untuk pertukaran data. gRPC menggunakan <strong>Protocol Buffers</strong> — format serialisasi biner yang jauh lebih kecil dan cepat diproses.</p>

<pre><code>// Perbandingan ukuran data yang sama:

// JSON (REST) — 95 bytes, teks yang mudah dibaca
{
  "id": 42,
  "nama": "Budi Santoso",
  "email": "budi@contoh.com",
  "role": "developer"
}

// Protobuf (gRPC) — ~35 bytes, format biner
// Tidak bisa dibaca langsung, tapi 2-3x lebih kecil</code></pre>

<p><strong>2. HTTP/2 vs HTTP/1.1</strong></p>
<p>REST umumnya berjalan di atas HTTP/1.1, yang mengirim request secara berurutan. gRPC berjalan di atas <strong>HTTP/2</strong> yang mendukung:</p>
<ul>
    <li><strong>Multiplexing</strong> — banyak request/response berjalan bersamaan dalam satu koneksi TCP</li>
    <li><strong>Header compression</strong> — mengurangi overhead metadata</li>
    <li><strong>Server push</strong> — server bisa mengirim data tanpa diminta klien</li>
</ul>

<p><strong>3. Streaming</strong></p>
<p>gRPC mendukung empat pola komunikasi:</p>
<ul>
    <li><strong>Unary</strong> — Request tunggal, response tunggal (mirip REST)</li>
    <li><strong>Server Streaming</strong> — Satu request, server mengirim banyak response bertahap</li>
    <li><strong>Client Streaming</strong> — Klien mengirim banyak pesan, server merespons sekali</li>
    <li><strong>Bidirectional Streaming</strong> — Kedua pihak mengirim stream data secara bersamaan</li>
</ul>

<h3>Contoh: Mendefinisikan Service dengan Protobuf</h3>

<pre><code>// File: user_service.proto

syntax = "proto3";

package user;

// Definisi service
service UserService {
  // Unary — Ambil satu user
  rpc GetUser (GetUserRequest) returns (UserResponse);

  // Server streaming — Ambil banyak user secara bertahap
  rpc ListUsers (ListUsersRequest) returns (stream UserResponse);

  // Bidirectional streaming — Chat real-time
  rpc Chat (stream ChatMessage) returns (stream ChatMessage);
}

// Definisi pesan
message GetUserRequest {
  int32 id = 1;
}

message ListUsersRequest {
  int32 page = 1;
  int32 limit = 2;
}

message UserResponse {
  int32 id = 1;
  string nama = 2;
  string email = 3;
  string role = 4;
}

message ChatMessage {
  string pengirim = 1;
  string isi = 2;
  int64 timestamp = 3;
}</code></pre>

<h3>Kelebihan &amp; Kekurangan gRPC</h3>

<table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse: collapse; margin-bottom: 20px;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>✅ Kelebihan</th>
            <th>❌ Kekurangan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Sangat cepat (2-10x lebih cepat dari REST)</td>
            <td>Tidak bisa langsung diakses dari browser (butuh proxy)</td>
        </tr>
        <tr>
            <td>Strongly typed dengan Protobuf (kontrak ketat)</td>
            <td>Data biner — tidak human-readable (sulit di-debug manual)</td>
        </tr>
        <tr>
            <td>Code generation otomatis untuk 11+ bahasa</td>
            <td>Ekosistem tooling lebih kecil dari REST</td>
        </tr>
        <tr>
            <td>Mendukung streaming bidirectional</td>
            <td>Tidak cocok untuk API publik (developer experience buruk)</td>
        </tr>
        <tr>
            <td>Efisien secara bandwidth</td>
            <td>Butuh tooling khusus untuk testing (bukan cURL biasa)</td>
        </tr>
    </tbody>
</table>

<h3>Studi Kasus Industri</h3>

<p><strong>Netflix</strong> menggunakan gRPC secara ekstensif untuk komunikasi antar-microservice di backend mereka. Dengan ratusan microservice yang saling berkomunikasi jutaan kali per detik, penghematan bandwidth dan latensi dari gRPC dibanding REST menjadi <strong>signifikan secara finansial</strong> — menghemat jutaan dolar biaya cloud per tahun.</p>

<h2>6. Open API — Kunci Inovasi Terbuka</h2>

<h3>Apa Itu Open API?</h3>

<p><strong>Open API</strong> merujuk pada dua konsep yang saling terkait namun berbeda:</p>

<p><strong>1. Open API sebagai Aksesibilitas</strong></p>
<p>API yang <strong>sengaja dibuka untuk publik</strong>, memungkinkan developer dari luar perusahaan untuk membangun aplikasi yang terintegrasi. Ini adalah model bisnis yang mendorong ekosistem dan inovasi.</p>

<p><strong>2. OpenAPI Specification (OAS)</strong></p>
<p>Standar industri (sebelumnya dikenal sebagai Swagger) untuk <strong>mendeskripsikan REST API secara formal</strong>. File OpenAPI Specification ditulis dalam YAML atau JSON dan mendeskripsikan setiap endpoint, parameter, tipe data, dan respons API.</p>

<h3>Contoh OpenAPI Specification</h3>

<pre><code># File: openapi.yaml
openapi: 3.0.0
info:
  title: User Management API
  version: 1.0.0
  description: API untuk mengelola data pengguna

paths:
  /users:
    get:
      summary: Ambil daftar semua pengguna
      parameters:
        - name: page
          in: query
          schema:
            type: integer
            default: 1
      responses:
        \'200\':
          description: Daftar pengguna berhasil diambil
          content:
            application/json:
              schema:
                type: array
                items:
                  $ref: \'#/components/schemas/User\'

    post:
      summary: Buat pengguna baru
      requestBody:
        required: true
        content:
          application/json:
            schema:
              $ref: \'#/components/schemas/CreateUserInput\'
      responses:
        \'201\':
          description: Pengguna berhasil dibuat

components:
  schemas:
    User:
      type: object
      properties:
        id:
          type: integer
        nama:
          type: string
        email:
          type: string
          format: email</code></pre>

<h3>Mengapa Open API Mendorong Inovasi?</h3>

<p>Open API menciptakan efek jaringan (<em>network effect</em>) yang luar biasa:</p>

<pre><code>Perusahaan membuka API
        │
        ▼
Developer eksternal membangun aplikasi di atasnya
        │
        ▼
Pengguna baru tertarik karena ekosistem aplikasi yang kaya
        │
        ▼
Platform semakin bernilai
        │
        ▼
Lebih banyak developer tertarik → siklus berulang</code></pre>

<h3>Contoh Open API yang Mengubah Dunia</h3>

<table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse: collapse; margin-bottom: 20px;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>Open API</th>
            <th>Kegunaan</th>
            <th>Dampak</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>Google Maps API</strong></td>
            <td>Memasukkan peta interaktif ke aplikasi</td>
            <td>Digunakan oleh jutaan aplikasi (Gojek, Grab, Airbnb, dll.)</td>
        </tr>
        <tr>
            <td><strong>Stripe API</strong></td>
            <td>Integrasi pembayaran online</td>
            <td>Memungkinkan startup meluncurkan fitur pembayaran dalam hitungan jam</td>
        </tr>
        <tr>
            <td><strong>OpenWeather API</strong></td>
            <td>Data cuaca global real-time</td>
            <td>Digunakan oleh aplikasi cuaca, pertanian, dan logistik</td>
        </tr>
        <tr>
            <td><strong>GitHub API</strong></td>
            <td>Mengakses repositori, issues, dan CI/CD</td>
            <td>Fondasi ekosistem developer tools modern</td>
        </tr>
        <tr>
            <td><strong>Twilio API</strong></td>
            <td>Kirim SMS, telepon, dan WhatsApp via kode</td>
            <td>Merevolusi komunikasi bisnis global</td>
        </tr>
    </tbody>
</table>

<h3>Kelebihan &amp; Kekurangan Open API</h3>

<table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse: collapse; margin-bottom: 20px;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>✅ Kelebihan</th>
            <th>❌ Kekurangan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Mendorong inovasi lintas platform</td>
            <td>Butuh investasi besar dalam dokumentasi dan developer experience</td>
        </tr>
        <tr>
            <td>Mempercepat time-to-market drastis</td>
            <td>Risiko keamanan lebih tinggi (eksposur ke publik)</td>
        </tr>
        <tr>
            <td>Menciptakan ekosistem dan revenue stream baru</td>
            <td>Butuh versioning dan backward compatibility yang ketat</td>
        </tr>
        <tr>
            <td>Standarisasi via OpenAPI Specification</td>
            <td>Biaya infrastruktur untuk melayani developer eksternal</td>
        </tr>
    </tbody>
</table>

<h2>Matriks Perbandingan Komprehensif</h2>

<p>Untuk memudahkan pengambilan keputusan, berikut adalah matriks perbandingan lengkap dari keenam jenis API:</p>

<table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse: collapse; margin-bottom: 20px;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>Aspek</th>
            <th>REST</th>
            <th>SOAP</th>
            <th>GraphQL</th>
            <th>WebSocket</th>
            <th>gRPC</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>Format Data</strong></td>
            <td>JSON (utama), XML</td>
            <td>XML saja</td>
            <td>JSON</td>
            <td>Bebas (JSON, biner)</td>
            <td>Protobuf (biner)</td>
        </tr>
        <tr>
            <td><strong>Protokol</strong></td>
            <td>HTTP/1.1</td>
            <td>HTTP, SMTP, TCP</td>
            <td>HTTP</td>
            <td>WS/WSS</td>
            <td>HTTP/2</td>
        </tr>
        <tr>
            <td><strong>Performa</strong></td>
            <td>Baik</td>
            <td>Lambat (XML parsing)</td>
            <td>Baik — Sangat Baik</td>
            <td>Sangat Cepat</td>
            <td>Tercepat</td>
        </tr>
        <tr>
            <td><strong>Kasus Penggunaan Utama</strong></td>
            <td>Web app, mobile, API publik</td>
            <td>Enterprise, banking, government</td>
            <td>App modern dengan data kompleks</td>
            <td>Chat, gaming, live dashboard</td>
            <td>Microservices, cloud, internal</td>
        </tr>
        <tr>
            <td><strong>Kurva Belajar</strong></td>
            <td>Rendah</td>
            <td>Tinggi</td>
            <td>Sedang</td>
            <td>Sedang</td>
            <td>Tinggi</td>
        </tr>
        <tr>
            <td><strong>Caching</strong></td>
            <td>Mudah (HTTP cache)</td>
            <td>Sulit</td>
            <td>Kompleks</td>
            <td>Tidak bisa</td>
            <td>Terbatas</td>
        </tr>
        <tr>
            <td><strong>Browser Support</strong></td>
            <td>✅ Penuh</td>
            <td>⚠️ Terbatas</td>
            <td>✅ Penuh</td>
            <td>✅ Penuh</td>
            <td>❌ Perlu proxy</td>
        </tr>
        <tr>
            <td><strong>Real-time</strong></td>
            <td>❌ (perlu polling)</td>
            <td>❌</td>
            <td>✅ (Subscriptions)</td>
            <td>✅ Native</td>
            <td>✅ (Streaming)</td>
        </tr>
        <tr>
            <td><strong>Cocok untuk API Publik?</strong></td>
            <td>✅ Sangat cocok</td>
            <td>⚠️ Terbatas</td>
            <td>✅ Cocok</td>
            <td>⚠️ Spesifik</td>
            <td>❌ Kurang cocok</td>
        </tr>
    </tbody>
</table>

<h2>Panduan Memilih API yang Tepat (Decision Framework)</h2>

<p>Gunakan kerangka keputusan berikut untuk memilih jenis API yang paling sesuai dengan kebutuhan proyek Anda:</p>

<pre><code>Mulai
  │
  ├── Apakah butuh komunikasi real-time (chat, game, live data)?
  │     ├── Ya → WebSocket
  │     └── Tidak ↓
  │
  ├── Apakah ini komunikasi antar-microservice di backend?
  │     ├── Ya → Apakah performa adalah prioritas tertinggi?
  │     │          ├── Ya → gRPC
  │     │          └── Tidak → REST (internal)
  │     └── Tidak ↓
  │
  ├── Apakah ini untuk sistem enterprise (banking, government)?
  │     ├── Ya → Apakah butuh transaksi ACID lintas service?
  │     │          ├── Ya → SOAP
  │     │          └── Tidak → REST + OAuth 2.0
  │     └── Tidak ↓
  │
  ├── Apakah klien membutuhkan data dari banyak sumber dalam satu request?
  │     ├── Ya → GraphQL
  │     └── Tidak ↓
  │
  └── Default → REST API
        (Paling universal, paling mudah, paling banyak didukung)</code></pre>

<h3>Rekomendasi Berdasarkan Skenario</h3>

<table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse: collapse; margin-bottom: 20px;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>Skenario</th>
            <th>Rekomendasi</th>
            <th>Alasan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Startup baru, MVP cepat</td>
            <td><strong>REST</strong></td>
            <td>Cepat dibangun, mudah dipahami tim kecil</td>
        </tr>
        <tr>
            <td>Aplikasi mobile dengan UI kompleks</td>
            <td><strong>GraphQL</strong></td>
            <td>Hemat bandwidth, ambil data sesuai kebutuhan layar</td>
        </tr>
        <tr>
            <td>Sistem perbankan atau asuransi</td>
            <td><strong>SOAP</strong></td>
            <td>Keamanan tertinggi, reliable messaging, ACID</td>
        </tr>
        <tr>
            <td>Aplikasi chatting atau collaborative editing</td>
            <td><strong>WebSocket</strong></td>
            <td>Latensi milidetik, komunikasi bidirectional</td>
        </tr>
        <tr>
            <td>Backend microservices (komunikasi internal)</td>
            <td><strong>gRPC</strong></td>
            <td>Performa terbaik, hemat resource cloud</td>
        </tr>
        <tr>
            <td>Platform developer atau data publik</td>
            <td><strong>Open API (REST)</strong></td>
            <td>Aksesibel, terdokumentasi, mendorong adopsi</td>
        </tr>
        <tr>
            <td>E-commerce berskala besar</td>
            <td><strong>REST + GraphQL + gRPC</strong></td>
            <td>REST untuk publik, GraphQL untuk frontend, gRPC untuk backend</td>
        </tr>
    </tbody>
</table>

<h2>Catatan Penting: Kombinasi API dalam Arsitektur Modern</h2>

<p>Dalam praktik nyata, sistem yang matang <strong>jarang menggunakan hanya satu jenis API</strong>. Arsitektur modern sering menggabungkan beberapa jenis API dalam satu ekosistem:</p>

<pre><code>┌─────────────────────────────────────────────────────┐
│                    ARSITEKTUR MODERN                 │
├─────────────────────────────────────────────────────┤
│                                                     │
│  [Mobile App] ──── GraphQL ────┐                    │
│                                │                    │
│  [Web App] ──── REST API ──────┤                    │
│                                ├──► [API Gateway]   │
│  [Partner] ──── Open API ──────┤         │          │
│                                │         ▼          │
│  [IoT Device] ── gRPC ────────┘   [Microservices]   │
│                                    ┌────┼────┐      │
│                                    │    │    │      │
│                                    ▼    ▼    ▼      │
│                                  [gRPC antar-service]│
│                                         │           │
│  [Dashboard Live] ◄── WebSocket ────────┘           │
│                                                     │
└─────────────────────────────────────────────────────┘</code></pre>

<p>Contoh dunia nyata: <strong>Uber</strong> menggunakan REST untuk API publik developer, gRPC untuk komunikasi antar-microservice di backend, WebSocket untuk tracking lokasi driver real-time di aplikasi penumpang, dan GraphQL untuk beberapa fitur frontend yang membutuhkan data dari banyak sumber sekaligus.</p>

<h2>Kesimpulan</h2>

<p>Dunia API sangatlah luas dan terus berkembang. Tidak ada satu jenis API yang "terbaik untuk semua kasus" — yang ada adalah <strong>API yang paling tepat untuk konteks tertentu</strong>. Berikut ringkasan terakhir:</p>

<ul>
    <li><strong>REST API</strong> — Pilihan default. Sederhana, universal, dan battle-tested. Mulailah dari sini jika tidak ada alasan kuat untuk memilih yang lain.</li>
    <li><strong>SOAP API</strong> — Untuk domain yang tidak mentoleransi kegagalan: perbankan, asuransi, pemerintah. Berat, tapi tidak tergantikan untuk kasus spesifik.</li>
    <li><strong>GraphQL</strong> — Untuk frontend modern yang membutuhkan fleksibilitas tinggi dalam pengambilan data. Investasi awal lebih besar, tapi terbayar dalam jangka panjang.</li>
    <li><strong>WebSocket</strong> — Untuk fitur yang membutuhkan kecepatan real-time. Chat, game, dan kolaborasi langsung adalah domainnya.</li>
    <li><strong>gRPC</strong> — Untuk komunikasi antar-service di backend. Performa terbaik di kelasnya, tapi tidak cocok untuk API publik.</li>
    <li><strong>Open API</strong> — Bukan jenis teknis API, melainkan filosofi membuka akses dan mendorong inovasi. Gunakan OpenAPI Specification untuk mendokumentasikan API Anda secara profesional.</li>
</ul>

<p>Dengan memahami anatomi, kekuatan, kelemahan, dan konteks penggunaan masing-masing jenis API, Anda selangkah lebih maju dalam merancang dan membangun sistem perangkat lunak yang <strong>tangguh, efisien, dan siap menghadapi tantangan masa depan</strong>. 🚀</p>
',
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(50, 200),
        ]);

        $this->command->info('Jenis API — Tulang Punggung Aplikasi Modern Article created successfully!');
    }
}
