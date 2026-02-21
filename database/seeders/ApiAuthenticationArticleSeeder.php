<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class ApiAuthenticationArticleSeeder extends Seeder
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

        // Create API Authentication article
        Article::create([
            'title' => 'Penjelasan Otentikasi API (Akhirnya) — Otentikasi Dasar, Bearer & JWT',
            'slug' => 'penjelasan-otentikasi-api-basic-bearer-jwt',
            'excerpt' => 'Panduan lengkap bagi developer untuk memahami cara kerja otentikasi API dari yang paling sederhana hingga yang paling modern — dengan analogi nyata, contoh kode, dan perbandingan langsung.',
            'content' => '
<h2>1. Apa Itu Otentikasi API?</h2>

<p>Bayangkan kamu memiliki apartemen. Di depan pintu ada satpam. Setiap tamu yang datang harus <strong>membuktikan identitasnya</strong> sebelum diizinkan masuk. Satpam bisa meminta:</p>

<ul>
    <li>Kartu tanda pengenal (username &amp; password)</li>
    <li>Stiker khusus yang diberikan manajemen gedung (token)</li>
    <li>Gelang pintar yang bisa diverifikasi otomatis (JWT)</li>
</ul>

<p><strong>Otentikasi API</strong> bekerja persis seperti itu — ini adalah mekanisme yang memastikan bahwa hanya pihak yang berwenang yang bisa mengakses sumber daya di sebuah API.</p>

<p>Secara teknis, otentikasi API adalah proses di mana <strong>klien</strong> (aplikasi yang memanggil API) <strong>membuktikan identitasnya</strong> kepada <strong>server</strong> (API yang dipanggil) sebelum server memproses permintaan tersebut.</p>

<h3>Otentikasi vs Otorisasi — Jangan Tertukar!</h3>

<p>Dua istilah ini sering membingungkan. Berikut perbedaan sederhananya:</p>

<table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse: collapse; margin-bottom: 20px;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>Konsep</th>
            <th>Pertanyaan yang Dijawab</th>
            <th>Contoh</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>Otentikasi</strong></td>
            <td><em>Siapa kamu?</em></td>
            <td>"Kamu adalah pengguna dengan ID 42"</td>
        </tr>
        <tr>
            <td><strong>Otorisasi</strong></td>
            <td><em>Apa yang boleh kamu lakukan?</em></td>
            <td>"Pengguna 42 boleh membaca data, tapi tidak boleh menghapus"</td>
        </tr>
    </tbody>
</table>

<p>Otentikasi selalu datang <strong>lebih dulu</strong>. Kamu tidak bisa mengotorisasi seseorang yang belum dikenali identitasnya.</p>

<h2>2. Mengapa Otentikasi Itu Penting?</h2>

<p>Tanpa otentikasi, API kamu ibarat toko yang semua pintu dan lacinya terbuka — siapa pun bisa masuk, mengambil data, memodifikasi catatan, atau bahkan menghapus semua data.</p>

<p>Konsekuensi nyata jika API tidak memiliki otentikasi yang baik:</p>

<ul>
    <li><strong>Kebocoran data pengguna</strong> — data pribadi, nomor kartu kredit, alamat email tersebar bebas</li>
    <li><strong>Penyalahgunaan sumber daya</strong> — bot bisa membebani server tanpa batas (DDoS)</li>
    <li><strong>Manipulasi data</strong> — pihak tidak bertanggung jawab bisa mengubah atau menghapus data penting</li>
    <li><strong>Kerugian finansial</strong> — API layanan berbayar bisa disalahgunakan tanpa batas</li>
</ul>

<p>Itulah mengapa memahami dan mengimplementasikan otentikasi yang tepat adalah <strong>fondasi utama</strong> keamanan aplikasi modern.</p>

<h2>3. Basic Authentication (Otentikasi Dasar)</h2>

<h3>Apa Itu?</h3>

<p><strong>Basic Authentication</strong> adalah metode otentikasi paling sederhana dan paling tua di dunia HTTP. Caranya: klien mengirimkan username dan password <strong>setiap kali</strong> membuat permintaan ke API.</p>

<p>Analoginya seperti setiap kali masuk kantor, kamu harus menyebutkan nama lengkap dan nomor KTP kamu kepada satpam — berulang-ulang di setiap kunjungan.</p>

<h3>Cara Kerjanya</h3>

<p>Berikut alur Basic Authentication:</p>

<pre><code>1. Klien ingin mengakses resource API
2. Server merespons dengan 401 Unauthorized
3. Klien mengirim header: Authorization: Basic &lt;kredensial&gt;
4. Server memverifikasi kredensial
5. Jika valid → akses diberikan (200 OK)
   Jika tidak valid → akses ditolak (401 Unauthorized)</code></pre>

<p><strong>Bagaimana kredensial dibentuk?</strong></p>

<p>Username dan password digabung dengan titik dua, lalu di-<em>encode</em> menggunakan <strong>Base64</strong>:</p>

<pre><code>username:password  →  dXNlcm5hbWU6cGFzc3dvcmQ=</code></pre>

<p>Kemudian dikirim dalam HTTP header:</p>

<pre><code>GET /api/data HTTP/1.1
Host: api.contoh.com
Authorization: Basic dXNlcm5hbWU6cGFzc3dvcmQ=</code></pre>

<h3>Contoh Kode</h3>

<p><strong>Menggunakan cURL:</strong></p>
<pre><code>curl -u username:password https://api.contoh.com/data

# Atau secara manual dengan header:
curl -H "Authorization: Basic dXNlcm5hbWU6cGFzc3dvcmQ=" https://api.contoh.com/data</code></pre>

<p><strong>Menggunakan JavaScript (Fetch API):</strong></p>
<pre><code>const username = \'admin\';
const password = \'rahasia123\';
const credentials = btoa(`${username}:${password}`);

const response = await fetch(\'https://api.contoh.com/data\', {
  headers: {
    \'Authorization\': `Basic ${credentials}`
  }
});

const data = await response.json();</code></pre>

<p><strong>Menggunakan Python (requests):</strong></p>
<pre><code>import requests

response = requests.get(
    \'https://api.contoh.com/data\',
    auth=(\'admin\', \'rahasia123\')  # Library otomatis encode ke Base64
)

print(response.json())</code></pre>

<h3>⚠️ Penting: Base64 BUKAN Enkripsi!</h3>

<p>Banyak orang salah paham bahwa Base64 memberikan keamanan. <strong>Tidak!</strong> Base64 hanyalah format <em>encoding</em> — siapa pun bisa mendekode-nya dalam hitungan detik:</p>

<pre><code>dXNlcm5hbWU6cGFzc3dvcmQ=  →  username:password</code></pre>

<p>Ini artinya Basic Auth <strong>HARUS selalu digunakan bersama HTTPS</strong> agar kredensial tidak bisa dicegat di tengah jalan.</p>

<h3>Kelebihan &amp; Kekurangan</h3>

<table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse: collapse; margin-bottom: 20px;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>✅ Kelebihan</th>
            <th>❌ Kekurangan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Sangat sederhana diimplementasikan</td>
            <td>Password dikirim di setiap request</td>
        </tr>
        <tr>
            <td>Didukung hampir semua klien HTTP</td>
            <td>Tidak ada mekanisme "logout" yang nyata</td>
        </tr>
        <tr>
            <td>Cocok untuk testing dan internal tools</td>
            <td>Harus selalu pakai HTTPS (tidak opsional)</td>
        </tr>
        <tr>
            <td>Tidak perlu state di server</td>
            <td>Rentan jika terjadi kebocoran (semua request terekspos)</td>
        </tr>
    </tbody>
</table>

<h2>4. Bearer Token</h2>

<h3>Apa Itu?</h3>

<p><strong>Bearer Token</strong> adalah string unik yang diberikan server kepada klien setelah login berhasil. Setelah mendapat token ini, klien menggunakannya untuk mengakses resource — <strong>tanpa perlu mengirim username/password lagi</strong>.</p>

<p>Analoginya seperti tiket konser. Kamu membeli tiket di loket (login), lalu menunjukkan tiket itu di pintu masuk (setiap request). Siapa pun yang <em>memegang</em> tiket itu bisa masuk — itulah mengapa disebut "<strong>Bearer</strong>" (pemegang).</p>

<h3>Cara Kerjanya</h3>

<pre><code>1. Klien mengirim username &amp; password ke endpoint login
2. Server memverifikasi → menghasilkan token unik → menyimpannya di database
3. Server mengirim token kepada klien
4. Klien menyimpan token (di memori, localStorage, atau cookie)
5. Setiap request berikutnya, klien menyertakan token di header
6. Server mencari token di database → jika ada dan valid → izinkan akses</code></pre>

<p>Token dikirim dalam HTTP header seperti ini:</p>

<pre><code>GET /api/profil HTTP/1.1
Host: api.contoh.com
Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...</code></pre>

<h3>Contoh Kode</h3>

<p><strong>Langkah 1 — Login dan dapatkan token:</strong></p>
<pre><code>// Login untuk mendapatkan token
const loginResponse = await fetch(\'https://api.contoh.com/auth/login\', {
  method: \'POST\',
  headers: { \'Content-Type\': \'application/json\' },
  body: JSON.stringify({
    username: \'admin\',
    password: \'rahasia123\'
  })
});

const { token } = await loginResponse.json();
// token = "abc123xyz789..."</code></pre>

<p><strong>Langkah 2 — Gunakan token untuk request berikutnya:</strong></p>
<pre><code>const response = await fetch(\'https://api.contoh.com/profil\', {
  headers: {
    \'Authorization\': `Bearer ${token}`
  }
});

const profil = await response.json();</code></pre>

<p><strong>Implementasi server sederhana (Node.js/Express):</strong></p>
<pre><code>// Middleware validasi Bearer Token
function autentikasiToken(req, res, next) {
  const authHeader = req.headers[\'authorization\'];
  const token = authHeader &amp;&amp; authHeader.split(\' \')[1];

  if (!token) {
    return res.status(401).json({ error: \'Token tidak ditemukan\' });
  }

  const pengguna = database.cariTokenValid(token);

  if (!pengguna) {
    return res.status(403).json({ error: \'Token tidak valid\' });
  }

  req.pengguna = pengguna;
  next();
}

app.get(\'/api/profil\', autentikasiToken, (req, res) =&gt; {
  res.json({ data: req.pengguna });
});</code></pre>

<h3>Masalah dengan Bearer Token Sederhana</h3>

<p>Token sederhana yang disimpan di database punya satu kelemahan besar: <strong>server harus melakukan query ke database setiap kali ada request</strong>. Bayangkan API dengan jutaan pengguna aktif — ini menjadi bottleneck yang sangat berat.</p>

<p>Di sinilah <strong>JWT hadir</strong> sebagai solusi.</p>

<h3>Kelebihan &amp; Kekurangan</h3>

<table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse: collapse; margin-bottom: 20px;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>✅ Kelebihan</th>
            <th>❌ Kekurangan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Lebih aman dari Basic Auth</td>
            <td>Server harus query DB setiap request (jika stateful)</td>
        </tr>
        <tr>
            <td>Password tidak dikirim berulang kali</td>
            <td>Butuh penyimpanan token yang aman di klien</td>
        </tr>
        <tr>
            <td>Mendukung "logout" dengan menghapus token</td>
            <td>Token bisa dicuri (man-in-the-middle)</td>
        </tr>
        <tr>
            <td>Mudah dibatasi (revoke token kapan saja)</td>
            <td>Perlu manajemen siklus hidup token</td>
        </tr>
    </tbody>
</table>

<h2>5. JWT (JSON Web Token)</h2>

<h3>Apa Itu?</h3>

<p><strong>JWT (JSON Web Token)</strong> adalah standar terbuka (RFC 7519) untuk membuat token yang bisa <strong>membawa informasi sekaligus memverifikasi dirinya sendiri</strong> — tanpa perlu database sama sekali.</p>

<p>Analoginya seperti paspor. Paspor berisi identitasmu, diterbitkan oleh otoritas berwenang (pemerintah), dan bisa diverifikasi kapan saja hanya dengan memeriksa stempel dan tanda tangan di dalamnya — tanpa perlu menelepon kantor imigrasi setiap saat.</p>

<h3>Struktur JWT</h3>

<p>JWT terdiri dari <strong>tiga bagian</strong> yang dipisahkan tanda titik (<code>.</code>):</p>

<pre><code>xxxxx.yyyyy.zzzzz
  │      │      │
Header Payload Signature</code></pre>

<p><strong>Contoh JWT nyata:</strong></p>
<pre><code>eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.
eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.
SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c</code></pre>

<h4>Bagian 1: Header</h4>

<p>Header berisi dua informasi: <strong>jenis token</strong> dan <strong>algoritma enkripsi</strong> yang digunakan.</p>

<pre><code>{
  "alg": "HS256",   // Algoritma: HMAC SHA-256
  "typ": "JWT"      // Tipe token
}</code></pre>

<p>Kemudian di-encode Base64URL:</p>
<pre><code>eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9</code></pre>

<h4>Bagian 2: Payload (Claims)</h4>

<p>Payload berisi <strong>klaim</strong> — informasi tentang pengguna dan metadata token. Ada tiga jenis klaim:</p>

<p><strong>Registered Claims (Standar):</strong></p>
<pre><code>{
  "iss": "https://auth.contoh.com",   // Issuer — siapa yang menerbitkan token
  "sub": "user_42",                   // Subject — siapa pemilik token
  "aud": "https://api.contoh.com",    // Audience — untuk siapa token ini
  "exp": 1700000000,                  // Expiration — kapan token kedaluwarsa
  "iat": 1699996400,                  // Issued At — kapan token dibuat
  "nbf": 1699996400                   // Not Before — token belum valid sebelum waktu ini
}</code></pre>

<p><strong>Custom Claims (Sesuka kita):</strong></p>
<pre><code>{
  "sub": "user_42",
  "exp": 1700000000,
  "nama": "Budi Santoso",
  "role": "admin",
  "email": "budi@contoh.com",
  "izin": ["baca", "tulis", "hapus"]
}</code></pre>

<p>⚠️ <strong>Ingat:</strong> Payload <strong>tidak dienkripsi</strong>, hanya di-encode. Jangan menyimpan informasi sensitif (password, data kartu kredit) di sini!</p>

<h4>Bagian 3: Signature (Tanda Tangan)</h4>

<p>Inilah bagian terpenting JWT. Tanda tangan dibuat dengan cara:</p>

<pre><code>HMACSHA256(
  base64UrlEncode(header) + "." + base64UrlEncode(payload),
  secret_key
)</code></pre>

<p><strong>Contoh dalam pseudocode:</strong></p>
<pre><code>data = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJ1c2VyXzQyIn0"
kunci_rahasia = "kunci-super-rahasia-server-kita"

tanda_tangan = HMAC_SHA256(data, kunci_rahasia)</code></pre>

<p>Tanda tangan ini <strong>membuktikan bahwa token belum dimodifikasi</strong>. Jika seseorang mengubah payload (misalnya mengubah role dari "user" menjadi "admin"), tanda tangan tidak akan cocok lagi, dan server akan menolaknya.</p>

<h3>Cara Kerja JWT End-to-End</h3>

<pre><code>┌─────────┐                               ┌─────────┐
│  Klien  │                               │ Server  │
└────┬────┘                               └────┬────┘
     │                                         │
     │  POST /login {username, password}        │
     │ ────────────────────────────────────────►│
     │                                         │
     │          Verifikasi kredensial           │
     │          Buat JWT dengan payload         │
     │          Tandatangani dengan kunci rahasia│
     │                                         │
     │  200 OK { token: "eyJ..." }             │
     │ ◄────────────────────────────────────────│
     │                                         │
     │  GET /api/data                          │
     │  Authorization: Bearer eyJ...           │
     │ ────────────────────────────────────────►│
     │                                         │
     │          Decode header &amp; payload         │
     │          Hitung ulang signature          │
     │          Cocokkan dengan signature token │
     │          Cek exp, iss, aud               │
     │          Tidak perlu query database! ✓   │
     │                                         │
     │  200 OK { data: ... }                   │
     │ ◄────────────────────────────────────────│</code></pre>

<h3>Contoh Kode Lengkap</h3>

<p><strong>Membuat dan memverifikasi JWT (Node.js dengan jsonwebtoken):</strong></p>

<pre><code>const jwt = require(\'jsonwebtoken\');

const KUNCI_RAHASIA = process.env.JWT_SECRET;

// ===== MEMBUAT TOKEN (saat login) =====
function buatToken(dataPengguna) {
  const payload = {
    sub: dataPengguna.id,
    nama: dataPengguna.nama,
    email: dataPengguna.email,
    role: dataPengguna.role
  };

  const token = jwt.sign(payload, KUNCI_RAHASIA, {
    expiresIn: \'1h\',
    issuer: \'api.contoh.com\',
    audience: \'app.contoh.com\'
  });

  return token;
}

// ===== MEMVERIFIKASI TOKEN (middleware) =====
function verifikasiJWT(req, res, next) {
  const authHeader = req.headers[\'authorization\'];
  const token = authHeader &amp;&amp; authHeader.split(\' \')[1];

  if (!token) {
    return res.status(401).json({ error: \'Token tidak ditemukan\' });
  }

  try {
    const decoded = jwt.verify(token, KUNCI_RAHASIA, {
      issuer: \'api.contoh.com\',
      audience: \'app.contoh.com\'
    });

    req.pengguna = decoded;
    next();
  } catch (error) {
    if (error.name === \'TokenExpiredError\') {
      return res.status(401).json({ error: \'Token kedaluwarsa, silakan login ulang\' });
    }
    return res.status(403).json({ error: \'Token tidak valid\' });
  }
}

// ===== ENDPOINT LOGIN =====
app.post(\'/login\', async (req, res) =&gt; {
  const { username, password } = req.body;

  const pengguna = await db.cariPengguna(username);
  if (!pengguna || !bcrypt.compareSync(password, pengguna.passwordHash)) {
    return res.status(401).json({ error: \'Kredensial salah\' });
  }

  const token = buatToken(pengguna);
  res.json({ token });
});

// ===== ENDPOINT YANG DILINDUNGI =====
app.get(\'/api/profil\', verifikasiJWT, (req, res) =&gt; {
  res.json({ pengguna: req.pengguna });
});</code></pre>

<p><strong>Menggunakan JWT di klien (JavaScript):</strong></p>
<pre><code>// Simpan token dengan aman
localStorage.setItem(\'jwt_token\', token);

// Fungsi helper untuk request berautentikasi
async function apiFetch(url, options = {}) {
  const token = localStorage.getItem(\'jwt_token\');

  return fetch(url, {
    ...options,
    headers: {
      ...options.headers,
      \'Authorization\': `Bearer ${token}`,
      \'Content-Type\': \'application/json\'
    }
  });
}

// Penggunaan
const response = await apiFetch(\'/api/profil\');
const profil = await response.json();</code></pre>

<h3>Konsep Penting: Access Token &amp; Refresh Token</h3>

<p>JWT biasanya memiliki masa kedaluwarsa yang singkat (15 menit – 1 jam) demi keamanan. Tapi tentu tidak nyaman jika pengguna harus login setiap jam. Solusinya adalah pasangan <strong>Access Token</strong> dan <strong>Refresh Token</strong>:</p>

<pre><code>Access Token:
  - Masa berlaku singkat (15–60 menit)
  - Dikirim di setiap request API
  - Jika dicuri, kerugian terbatas (hanya berlaku sebentar)

Refresh Token:
  - Masa berlaku panjang (7–30 hari)
  - Disimpan lebih aman (httpOnly cookie)
  - HANYA digunakan untuk mendapatkan Access Token baru
  - Jika dicuri, bisa direvoke di server</code></pre>

<p><strong>Alur Refresh Token:</strong></p>
<pre><code>1. Access Token kedaluwarsa → API mengembalikan 401
2. Klien mengirim Refresh Token ke /auth/refresh
3. Server memverifikasi Refresh Token
4. Server mengeluarkan Access Token baru
5. Klien melanjutkan request dengan token baru</code></pre>

<h3>Kelebihan &amp; Kekurangan JWT</h3>

<table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse: collapse; margin-bottom: 20px;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>✅ Kelebihan</th>
            <th>❌ Kekurangan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>Stateless</strong> — tidak perlu query database</td>
            <td>Sulit di-revoke sebelum kedaluwarsa</td>
        </tr>
        <tr>
            <td>Skalabel untuk sistem terdistribusi</td>
            <td>Ukuran token lebih besar dari token sederhana</td>
        </tr>
        <tr>
            <td>Membawa data (tidak perlu lookup tambahan)</td>
            <td>Payload bisa didekode (jangan simpan data sensitif)</td>
        </tr>
        <tr>
            <td>Bisa digunakan lintas domain (Cross-Origin)</td>
            <td>Implementasi yang salah bisa berbahaya</td>
        </tr>
        <tr>
            <td>Standar terbuka, banyak library tersedia</td>
            <td>Butuh pemahaman lebih untuk menggunakan dengan benar</td>
        </tr>
    </tbody>
</table>

<h2>6. Perbandingan Ketiga Metode</h2>

<h3>Tabel Perbandingan Lengkap</h3>

<table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse: collapse; margin-bottom: 20px;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>Aspek</th>
            <th>Basic Auth</th>
            <th>Bearer Token</th>
            <th>JWT</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>Cara kirim kredensial</strong></td>
            <td>Setiap request</td>
            <td>Hanya saat login</td>
            <td>Hanya saat login</td>
        </tr>
        <tr>
            <td><strong>Apa yang dikirim per request</strong></td>
            <td>Username:Password (Base64)</td>
            <td>Token opaque (string acak)</td>
            <td>Token berisi data (self-contained)</td>
        </tr>
        <tr>
            <td><strong>Butuh query DB per request?</strong></td>
            <td>Ya (verifikasi password)</td>
            <td>Ya (cari token)</td>
            <td><strong>Tidak</strong></td>
        </tr>
        <tr>
            <td><strong>Bisa di-revoke?</strong></td>
            <td>Ya (ganti password)</td>
            <td><strong>Ya (hapus dari DB)</strong></td>
            <td>Sulit (harus tunggu exp)</td>
        </tr>
        <tr>
            <td><strong>Membawa data pengguna?</strong></td>
            <td>Tidak</td>
            <td>Tidak</td>
            <td><strong>Ya</strong></td>
        </tr>
        <tr>
            <td><strong>Kompleksitas implementasi</strong></td>
            <td>Sangat mudah</td>
            <td>Sedang</td>
            <td>Lebih kompleks</td>
        </tr>
        <tr>
            <td><strong>Cocok untuk microservices?</strong></td>
            <td>Tidak</td>
            <td>Kurang</td>
            <td><strong>Ya</strong></td>
        </tr>
        <tr>
            <td><strong>Keamanan (dengan HTTPS)</strong></td>
            <td>Cukup</td>
            <td>Baik</td>
            <td>Baik</td>
        </tr>
    </tbody>
</table>

<h3>Ilustrasi Visual Alur Masing-masing</h3>

<pre><code>BASIC AUTH — Setiap request membawa password
─────────────────────────────────────────────
Klien ──[username:pass]──► Server ──[cek DB]──► Response
Klien ──[username:pass]──► Server ──[cek DB]──► Response
Klien ──[username:pass]──► Server ──[cek DB]──► Response


BEARER TOKEN — Login sekali, gunakan token
─────────────────────────────────────────────
Klien ──[login]──────────► Server ──[buat token]──► Simpan ke DB
Klien ◄──────────────────── [token: "abc123"]
Klien ──[token: "abc123"]──► Server ──[cek DB]──► Response
Klien ──[token: "abc123"]──► Server ──[cek DB]──► Response


JWT — Login sekali, verifikasi mandiri
─────────────────────────────────────────────
Klien ──[login]──────────► Server ──[buat JWT]──► (tidak disimpan)
Klien ◄──────────────────── [JWT: "eyJ..."]
Klien ──[JWT: "eyJ..."]──► Server ──[verifikasi signature]──► Response
Klien ──[JWT: "eyJ..."]──► Server ──[verifikasi signature]──► Response
                                    (tanpa query DB!)</code></pre>

<h2>7. Kapan Menggunakan Masing-masing?</h2>

<h3>Gunakan Basic Authentication jika:</h3>

<ul>
    <li>Membangun <strong>internal tool</strong> atau <strong>script otomasi</strong> yang tidak berhubungan langsung dengan pengguna akhir</li>
    <li>Proyek sangat kecil atau <strong>prototype</strong> yang akan dibuang nanti</li>
    <li>Membutuhkan implementasi tercepat untuk testing API</li>
    <li><strong>Tidak ada kebutuhan untuk "logout"</strong> atau sesi yang bisa dikelola</li>
</ul>

<p><strong>Contoh nyata:</strong> Mengakses GitHub API dari script CI/CD internal, atau mengakses API sederhana di jaringan lokal yang sudah terlindungi.</p>

<h3>Gunakan Bearer Token (Opaque) jika:</h3>

<ul>
    <li>Kebutuhan untuk <strong>merevoke akses secara instan</strong> sangat penting (misalnya sistem keuangan, layanan sensitif)</li>
    <li>Aplikasi <strong>tidak terdistribusi</strong> — semua layanan mengakses satu database yang sama</li>
    <li>Ingin <strong>mengetahui kapan dan dari mana</strong> setiap token digunakan (audit trail per token)</li>
    <li>Sistem yang <strong>tidak membutuhkan skalabilitas tinggi</strong></li>
</ul>

<p><strong>Contoh nyata:</strong> Aplikasi perbankan mobile yang harus bisa mencabut akses token secara instan jika terdeteksi aktivitas mencurigakan.</p>

<h3>Gunakan JWT jika:</h3>

<ul>
    <li>Membangun <strong>microservices</strong> atau sistem terdistribusi di mana banyak layanan perlu memverifikasi identitas</li>
    <li>Butuh <strong>skalabilitas tinggi</strong> — tidak mau query database untuk setiap request</li>
    <li>Perlu menyematkan <strong>informasi konteks</strong> (role, izin, data profil) langsung di token agar layanan downstream tidak perlu lookup tambahan</li>
    <li>Menggunakan arsitektur <strong>Single Sign-On (SSO)</strong> atau <strong>OAuth 2.0</strong></li>
</ul>

<p><strong>Contoh nyata:</strong> Platform e-commerce dengan layanan terpisah (katalog, keranjang, pembayaran, notifikasi) yang masing-masing perlu tahu siapa pengguna dan apa izinnya.</p>

<h2>8. Praktik Terbaik Keamanan</h2>

<h3>Untuk Semua Metode</h3>

<p><strong>1. Selalu Gunakan HTTPS</strong></p>
<p>Tanpa HTTPS, semua metode otentikasi di atas bisa dicuri dengan mudah melalui <em>man-in-the-middle attack</em>. HTTPS bukan pilihan — ini <strong>wajib</strong>.</p>

<p><strong>2. Hindari Menyimpan Kredensial Sensitif di Log</strong></p>
<pre><code>// ❌ JANGAN lakukan ini
console.log(\'Request headers:\', req.headers); // Akan mencetak token ke log!

// ✅ Lakukan ini
console.log(\'Request dari pengguna:\', req.pengguna.id);</code></pre>

<p><strong>3. Tangani Error dengan Pesan yang Tidak Informatif untuk Penyerang</strong></p>
<pre><code>// ❌ Terlalu informatif untuk penyerang
res.status(401).json({ error: \'Password salah untuk user admin@contoh.com\' });

// ✅ Lebih aman
res.status(401).json({ error: \'Kredensial tidak valid\' });</code></pre>

<h3>Khusus Basic Auth</h3>

<ul>
    <li><strong>Wajib HTTPS</strong> — tidak ada pengecualian</li>
    <li>Gunakan hanya untuk komunikasi server-ke-server yang terkontrol</li>
    <li>Implementasikan <em>rate limiting</em> untuk mencegah brute-force</li>
</ul>

<h3>Khusus Bearer Token</h3>

<ul>
    <li>Simpan token di <strong>httpOnly cookie</strong> (lebih aman dari localStorage yang rentan XSS)</li>
    <li>Implementasikan <strong>token rotation</strong> — perbarui token secara berkala</li>
    <li>Simpan <em>hash</em> token di database, bukan plaintext</li>
    <li>Implementasikan batas waktu sesi yang tidak aktif</li>
</ul>

<h3>Khusus JWT</h3>

<p><strong>Gunakan algoritma yang benar:</strong></p>
<pre><code>// ❌ JANGAN gunakan "none" sebagai algoritma
jwt.sign(payload, \'\', { algorithm: \'none\' }); // Celah keamanan besar!

// ❌ Hindari HS256 untuk sistem besar (kunci simetris)
jwt.sign(payload, secretKey, { algorithm: \'HS256\' });

// ✅ Gunakan RS256 untuk sistem yang butuh kunci publik/privat
jwt.sign(payload, privateKey, { algorithm: \'RS256\' });</code></pre>

<p><strong>Jangan simpan data sensitif di payload:</strong></p>
<pre><code>// ❌ JANGAN
const payload = {
  sub: userId,
  password: userPassword,    // JANGAN!
  kartuKredit: \'4111...\',   // JANGAN!
};

// ✅ Lakukan
const payload = {
  sub: userId,
  email: userEmail,          // OK
  role: \'admin\',             // OK
  exp: Math.floor(Date.now() / 1000) + 3600
};</code></pre>

<p><strong>Validasi semua klaim dengan ketat:</strong></p>
<pre><code>jwt.verify(token, kunci, {
  algorithms: [\'RS256\'],      // Tentukan algoritma secara eksplisit
  issuer: \'auth.contoh.com\', // Verifikasi issuer
  audience: \'api.contoh.com\', // Verifikasi audience
  clockTolerance: 10          // Toleransi 10 detik untuk perbedaan jam server
});</code></pre>

<h2>9. Kesimpulan</h2>

<p>Setelah membaca panduan ini, kamu sudah memahami tiga metode otentikasi API yang paling umum digunakan:</p>

<p><strong>Basic Authentication</strong> adalah yang paling sederhana — cocok untuk penggunaan internal dan testing, tapi kredensial dikirim setiap request sehingga risikonya lebih tinggi.</p>

<p><strong>Bearer Token</strong> menawarkan keamanan yang lebih baik karena password hanya dikirim saat login. Token bisa direvoke kapan saja, namun membutuhkan query database di setiap request.</p>

<p><strong>JWT</strong> adalah solusi paling modern dan skalabel — token "berbicara sendiri" sehingga tidak butuh database per request. Ideal untuk microservices dan sistem besar, namun butuh kehati-hatian dalam implementasi.</p>

<h3>Rekap Singkat</h3>

<pre><code>Butuh yang paling simple?          → Basic Auth (dengan HTTPS!)
Butuh bisa revoke kapan saja?      → Bearer Token
Butuh skalabilitas &amp; microservice? → JWT</code></pre>

<h3>Apa yang Harus Dipelajari Selanjutnya?</h3>

<p>Setelah memahami dasar-dasar ini, topik berikutnya yang relevan untuk dikuasai adalah:</p>

<ul>
    <li><strong>OAuth 2.0</strong> — framework otorisasi standar yang biasanya menggunakan JWT di dalamnya</li>
    <li><strong>OpenID Connect (OIDC)</strong> — lapisan identitas di atas OAuth 2.0</li>
    <li><strong>API Key</strong> — metode sederhana untuk mengidentifikasi aplikasi (bukan pengguna)</li>
    <li><strong>mTLS (Mutual TLS)</strong> — otentikasi dua arah untuk komunikasi service-to-service</li>
    <li><strong>PKCE</strong> — ekstensi OAuth 2.0 untuk aplikasi mobile dan SPA</li>
</ul>

<p><em>Artikel ini ditulis untuk membantu developer memahami konsep otentikasi API dari dasar hingga siap implementasi. Selalu ikuti praktik terbaik keamanan dan sesuaikan metode yang dipilih dengan kebutuhan aplikasimu.</em></p>
',
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(50, 200),
        ]);

        $this->command->info('API Authentication (Basic, Bearer & JWT) Article created successfully!');
    }
}
