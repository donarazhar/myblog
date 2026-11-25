<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class ArtikelCyberlabArticleSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('is_admin', true)->first();

        if (!$admin) {
            $this->command->warn('No admin user found. Please run DatabaseSeeder first.');
            return;
        }

        $category = Category::firstOrCreate(
            ['name' => 'Tutorial'],
            ['description' => 'Tutorial dan panduan pengembangan aplikasi']
        );

        $content = <<<'HTML'
<p><strong>Disclaimer Edukasi:</strong> Seluruh simulasi pada artikel ini dilakukan di lingkungan lab lokal terisolasi milik sendiri untuk tujuan pembelajaran, audit keamanan, dan latihan <em>incident response</em>. Jangan pernah menerapkan teknik pengujian pada sistem tanpa izin resmi.</p>

<h2>1. Latar Belakang &amp; Topologi Lab</h2>
<p>Salah satu insiden keamanan yang paling sering menimpa website berbasis WordPress adalah <strong>pengambilalihan akun administrator</strong> yang diikuti oleh <strong>penyisipan artikel SEO spam</strong> (misalnya artikel judi atau pinjaman online ilegal) serta <strong>penanaman akses cadangan (<em>backdoor</em>)</strong> agar penyerang tetap bisa masuk meskipun password utama telah diganti.</p>

<p>Untuk memahami alur serangan sekaligus melatih prosedur pemulihannya secara nyata, dibangun sebuah lingkungan lab lokal dengan topologi berikut:</p>

<table>
    <thead>
        <tr>
            <th>Komponen</th>
            <th>Peran</th>
            <th>Spesifikasi / Alamat</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>Proxmox VE Host</strong></td>
            <td>Hypervisor</td>
            <td>Node <code>alazhar</code> (<code>192.168.13.69:8006</code>)</td>
        </tr>
        <tr>
            <td><strong>Target Server (LXC 108)</strong></td>
            <td>Server WordPress</td>
            <td><code>basiru-server</code> (<code>192.168.13.78</code>), Ubuntu 22.04, Apache <code>2.4.52</code>, MySQL 8.0, WordPress <code>7.1.5</code></td>
        </tr>
        <tr>
            <td><strong>Mesin Penyerang (VM)</strong></td>
            <td>Attacker Lab</td>
            <td>Kali Linux di VirtualBox (Bridged Adapter, IP <code>192.168.206.90</code>)</td>
        </tr>
    </tbody>
</table>

<h2>2. Fase 1 — Reconnaissance &amp; Scanning Vulnerability</h2>
<p>Langkah awal yang dilakukan penyerang sebelum menyerang adalah mengumpulkan informasi (<em>information gathering</em>) mengenai layanan yang terbuka, versi aplikasi, dan celah konfigurasi.</p>

<h3>2.1 Port &amp; Service Scanning dengan Nmap</h3>
<p>Dari terminal Kali Linux, pemindaian port dilakukan pada target <code>192.168.13.78</code>:</p>
<pre><code>nmap -sV -sC -p 22,80,443,3306 192.168.13.78</code></pre>
<p><strong>Hasil temuan:</strong></p>
<ul>
    <li>Port <code>22/tcp</code> (OpenSSH 8.9p1 Ubuntu) terbuka.</li>
    <li>Port <code>80/tcp</code> (Apache httpd 2.4.52) terbuka dan menjalankan <strong>WordPress 7.1.5</strong> dengan judul <em>Wordpress Cyberlab</em>.</li>
    <li>Port <code>443</code> (HTTPS) dan <code>3306</code> (MySQL) tertutup dari luar.</li>
</ul>

<h3>2.2 Vulnerability &amp; User Enumeration dengan WPScan</h3>
<p>Selanjutnya dilakukan pemindaian khusus WordPress untuk mencari username, tema, plugin, serta direktori yang terekspos:</p>
<pre><code>wpscan --url http://192.168.13.78 --enumerate u,p,t --no-banner</code></pre>
<p><strong>Temuan kritis dari hasil WPScan:</strong></p>
<ol>
    <li><strong>Username terekspos:</strong> Akun <code>admin</code> terdeteksi secara pasif melalui RSS Generator (<code>/index.php/feed/</code>).</li>
    <li><strong>XML-RPC aktif:</strong> Endpoint <code>http://192.168.13.78/xmlrpc.php</code> aktif dan berpotensi dimanfaatkan untuk <em>brute force</em> atau <em>pingback abuse</em>.</li>
    <li><strong>Directory listing aktif:</strong> Direktori <code>wp-content/uploads/</code> dan folder tema dapat dilihat daftar isinya oleh publik.</li>
    <li><strong>Info versi terbuka:</strong> File <code>readme.html</code> dan meta tag generator menampilkan versi WordPress secara langsung.</li>
</ol>

<h2>3. Fase 2 — Simulasi Brute Force &amp; Pengambilalihan Akses</h2>
<p>Setelah username <code>admin</code> diketahui dari tahap enumerasi, penyerang mencoba menebak password halaman login (<code>wp-login.php</code>).</p>

<h3>3.1 Pengujian Password dengan WPScan</h3>
<p>Pada tahap lab ini, proteksi <em>rate-limiting</em> (seperti Fail2Ban) dimatikan sementara untuk melihat bagaimana serangan bekerja pada server tanpa proteksi:</p>
<pre><code>wpscan --url http://192.168.13.78 \
  --usernames admin \
  --passwords /tmp/passwords.txt \
  --no-banner</code></pre>
<p>Jika akun admin menggunakan password lemah atau umum (misalnya <code>admin123</code>), kombinasi valid akan ditemukan dan penyerang memperoleh akses penuh ke dashboard <code>http://192.168.13.78/wp-admin</code>.</p>

<h3>3.2 Mengunci Pemilik Website (Owner Terkunci)</h3>
<p>Begitu masuk ke <code>wp-admin</code>, langkah pertama yang dilakukan dalam skenario ini adalah mengubah password akun <code>admin</code> melalui menu <strong>Users &rarr; Profile &rarr; Set New Password</strong>, sehingga pemilik asli tidak lagi dapat login.</p>

<h2>4. Fase 3 — Penyisipan Konten Spam (SEO Spam) &amp; Backdoor</h2>

<h3>4.1 Bulk Insert Artikel Spam</h3>
<p>Di dunia nyata, penyerang mengotomatiskan pembuatan puluhan hingga ribuan artikel berisi tautan ke situs ilegal agar terindeks oleh mesin pencari (<em>Blackhat SEO</em>). Dalam simulasi lab, penyisipan artikel dilakukan secara terprogram melalui <strong>WordPress REST API</strong> menggunakan <em>Application Password</em> pada endpoint <code>?rest_route=/wp/v2/posts</code>:</p>
<pre><code>USER="admin"
APP_PASS="fInmwv7ieaqjGHI3kzM0FtN4"

for i in 1 2 3 4 5; do
  CODE=$(curl -s -o /dev/null -w "%{http_code}" -X POST "http://192.168.13.78/?rest_route=/wp/v2/posts" \
    -u "$USER:$APP_PASS" \
    -H "Content-Type: application/json" \
    -d "{
      \"title\": \"[LAB SIMULASI] Panduan Cara Membatalkan Pinjaman #$i\",
      \"content\": \"&lt;p&gt;Ini adalah konten simulasi SEO spam ke-$i. Link redirect simulasi: &lt;a href='http://example.com'&gt;Klik disini&lt;/a&gt;&lt;/p&gt;\",
      \"status\": \"publish\"
    }")
  echo "Artikel #$i -&gt; HTTP $CODE"
done</code></pre>
<p>Semua request mengembalikan status <code>HTTP/1.1 201 Created</code>, dan artikel simulasi langsung tampil di halaman depan website.</p>

<h3>4.2 Penanaman Akses Cadangan (Persistence / Backdoor)</h3>
<p>Agar tetap memiliki akses walaupun pemilik website mereset password <code>admin</code>, penyerang menanam dua bentuk <em>persistence</em>:</p>
<ol>
    <li><strong>Akun Administrator Tambahan:</strong> Membuat user baru bernama <code>admin_sys</code> melalui <strong>Users &rarr; Add New</strong> dengan role <strong>Administrator</strong>.</li>
    <li><strong>File PHP di Direktori <code>uploads</code>:</strong> Dalam kasus nyata, penyerang menaruh skrip PHP tersembunyi di <code>wp-content/uploads/</code> atau menyisipkan kode pada <code>functions.php</code> tema aktif. Untuk simulasi lab yang aman, ditempatkan file penanda (<em>marker</em>) non-destruktif:
        <pre><code>echo '&lt;?php echo "LAB_BACKDOOR_MARKER"; ?&gt;' &gt; /var/www/html/wp-content/uploads/cache-helper.php</code></pre>
        Karena Apache secara default mengeksekusi file <code>.php</code> di dalam folder <code>uploads</code>, file ini langsung merespons dengan status <code>200 OK</code> saat diakses dari luar.
    </li>
</ol>

<h2>5. Fase 4 — Forensik, Pemulihan (Recovery), dan Hardening</h2>
<p>Setelah seluruh skenario serangan terbentuk, langkah penanganan dilakukan langsung dari sisi server (LXC 108).</p>

<h3>5.1 Forensik &amp; Audit Kerusakan</h3>
<p>Sebelum menghapus apa pun, administrator harus memetakan seluruh jejak perubahan:</p>
<pre><code># 1. Audit seluruh akun administrator di database
mysql -u wpuser -pwppassword123 wordpress -e "
SELECT u.ID, u.user_login, u.user_email, u.user_registered, m.meta_value AS role
FROM wp_users u
JOIN wp_usermeta m ON u.ID = m.user_id
WHERE m.meta_key = 'wp_capabilities';"

# 2. Audit artikel terbaru di tabel wp_posts
mysql -u wpuser -pwppassword123 wordpress -e "
SELECT ID, post_date, post_status, post_title
FROM wp_posts
WHERE post_type = 'post'
ORDER BY post_date DESC LIMIT 15;"

# 3. Scan file PHP di direktori uploads (seharusnya tidak ada file PHP)
find /var/www/html/wp-content/uploads -type f -name "*.php"

# 4. Analisa log Apache untuk melihat IP penyerang &amp; endpoint yang diakses
grep -E "wp-login\.php|wp/v2/posts|uploads/.*\.php" /var/log/apache2/access.log | tail -20</code></pre>

<p>Dari hasil audit lab, ditemukan bukti lengkap:</p>
<ul>
    <li>Dua akun administrator: <code>admin</code> (<code>ID=1</code>) dan akun asing <code>admin_sys</code> (<code>ID=2</code>).</li>
    <li>Enam artikel tidak sah di <code>wp_posts</code> (<code>Test Post</code> serta 5 artikel <code>[LAB SIMULASI] Panduan Cara Membatalkan Pinjaman #1..#5</code>).</li>
    <li>Satu file PHP mencurigakan: <code>/var/www/html/wp-content/uploads/cache-helper.php</code>.</li>
    <li>Log Apache mencatat IP <code>192.168.206.90</code> melakukan request <code>POST /?rest_route=/wp/v2/posts</code> (<code>201</code>), pemindaian <code>WPScan v4.1.0</code>, dan akses ke <code>cache-helper.php</code> (<code>200</code>).</li>
</ul>

<h3>5.2 Pembersihan Total (Containment &amp; Eradication)</h3>
<ol>
    <li><strong>Reset password admin dan cabut semua sesi/token aktif:</strong> Menghapus <code>session_tokens</code> dan <code>_application_passwords</code> sangat penting agar token REST API atau sesi lama penyerang langsung tidak berlaku.
        <pre><code>mysql -u wpuser -pwppassword123 wordpress -e "
UPDATE wp_users SET user_pass = MD5('AdminKantorBaru#2026') WHERE user_login = 'admin';
DELETE FROM wp_usermeta WHERE meta_key IN ('session_tokens', '_application_passwords');
"</code></pre>
    </li>
    <li><strong>Hapus akun backdoor (<code>admin_sys</code>):</strong>
        <pre><code>mysql -u wpuser -pwppassword123 wordpress -e "
DELETE FROM wp_usermeta WHERE user_id IN (SELECT ID FROM wp_users WHERE user_login != 'admin');
DELETE FROM wp_users WHERE user_login != 'admin';
"</code></pre>
    </li>
    <li><strong>Hapus artikel spam di database:</strong>
        <pre><code>mysql -u wpuser -pwppassword123 wordpress -e "
DELETE FROM wp_posts
WHERE post_title LIKE '%Pinjaman%'
   OR post_title LIKE '%Test Post%';
SELECT ROW_COUNT() AS jumlah_artikel_dihapus;
"</code></pre>
    </li>
    <li><strong>Hapus file PHP asing di <code>uploads</code>:</strong>
        <pre><code>find /var/www/html/wp-content/uploads -type f -name "*.php" -delete</code></pre>
    </li>
</ol>

<h3>5.3 Hardening Server &amp; WordPress</h3>
<p>Setelah website bersih, celah yang dieksploitasi sebelumnya ditutup secara permanen:</p>
<ol>
    <li><strong>Blokir eksekusi PHP di folder <code>wp-content/uploads/</code>:</strong>
        <pre><code>cat &gt; /var/www/html/wp-content/uploads/.htaccess &lt;&lt; 'EOF'
&lt;FilesMatch "\.php$"&gt;
    Require all denied
&lt;/FilesMatch&gt;
EOF</code></pre>
    </li>
    <li><strong>Matikan Theme/Plugin File Editor dari Dashboard:</strong> Menambahkan <code>define( 'DISALLOW_FILE_EDIT', true );</code> pada <code>/var/www/html/wp-config.php</code> agar kode tema atau plugin tidak bisa diedit langsung dari <code>wp-admin</code>.</li>
    <li><strong>Sembunyikan informasi versi &amp; blokir <code>xmlrpc.php</code>:</strong> Menghapus <code>readme.html</code> dan <code>license.txt</code>, serta menambahkan aturan penolakan akses pada <code>.htaccess</code>:
        <pre><code>&lt;Files xmlrpc.php&gt;
    Require all denied
&lt;/Files&gt;</code></pre>
    </li>
    <li><strong>Aktifkan Fail2Ban untuk auto-block Brute Force:</strong> Mengonfigurasi jail <code>wordpress</code> pada <code>/etc/fail2ban/jail.d/wordpress.conf</code> yang memantau <code>/var/log/apache2/access.log</code> (<code>maxretry = 5</code>, <code>findtime = 60</code>, <code>bantime = 3600</code>), lalu menjalankan layanan:
        <pre><code>systemctl start fail2ban &amp;&amp; systemctl enable fail2ban</code></pre>
    </li>
</ol>

<h3>5.4 Verifikasi Akhir</h3>
<p>Pengujian ulang dari mesin Kali Linux (<code>curl http://192.168.13.78/wp-content/uploads/cache-helper.php</code>) mengembalikan status <code>404 Not Found</code>, halaman depan website kembali bersih dari artikel spam, dan akses login kembali berada di bawah kendali administrator yang sah.</p>

<h2>6. Rekomendasi Tambahan untuk Lingkungan Produksi</h2>
<p>Jika menerapkan proses pemulihan ini pada server kantor yang berjalan di internet publik, tambahkan langkah berikut:</p>
<ul>
    <li><strong>Selalu lakukan backup penuh</strong> (database &amp; file webroot) sebelum proses pembersihan.</li>
    <li><strong>Verifikasi integritas file inti WordPress</strong> menggunakan <code>wp core verify-checksums</code> dan periksa file yang baru diubah di <code>wp-content/themes/</code> maupun <code>wp-content/plugins/</code>.</li>
    <li><strong>Rotasi <em>Security Keys and Salts</em></strong> di <code>wp-config.php</code> serta periksa kemungkinan kebocoran kredensial database.</li>
    <li><strong>Aktifkan HTTPS, Two-Factor Authentication (2FA)</strong> untuk seluruh akun administrator, dan gunakan plugin keamanan / WAF seperti Wordfence serta pembaruan rutin WordPress, tema, dan plugin.</li>
</ul>
HTML;

        Article::updateOrCreate(
            ['slug' => 'artikel-cyberlab'],
            [
                'title' => 'Artikel Cyberlab',
                'excerpt' => 'Studi kasus lengkap simulasi serangan WordPress (scanning Nmap & WPScan, brute force, bulk insert SEO spam via REST API, dan backdoor) beserta proses forensik, pemulihan database, dan hardening server.',
                'content' => $content,
                'user_id' => $admin->id,
                'category_id' => $category->id,
                'status' => 'published',
                'published_at' => now(),
            ]
        );

        $this->command->info('Artikel Cyberlab created/updated successfully!');
    }
}
