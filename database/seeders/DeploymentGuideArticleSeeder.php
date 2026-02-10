<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class DeploymentGuideArticleSeeder extends Seeder
{
    public function run(): void
    {
        // Get admin user
        $admin = User::where('is_admin', true)->first();

        if (!$admin) {
            $this->command->warn('No admin user found. Please run DatabaseSeeder first.');
            return;
        }

        // Get or create category for Tutorial
        $category = Category::firstOrCreate(
            ['name' => 'Tutorial'],
            ['description' => 'Tutorial dan panduan pengembangan aplikasi']
        );

        // Create or Update Deployment Guide article
        Article::updateOrCreate(
            ['slug' => 'myblog-deployment-guide'],
            [
                'title' => 'Panduan Lengkap Deploy Laravel ke Ubuntu Server dengan Nginx & Cloudflare Tunnel',
                'excerpt' => 'Tutorial step-by-step cara deploy aplikasi Laravel ke Ubuntu Server menggunakan Nginx sebagai web server, MySQL sebagai database, dan Cloudflare Tunnel untuk mengekspos server lokal ke internet dengan HTTPS otomatis.',
                'content' => '
<p>Deployment adalah salah satu tahap paling krusial dalam siklus pengembangan aplikasi web. Setelah aplikasi selesai dibangun di lingkungan lokal, langkah selanjutnya adalah membuat aplikasi tersebut dapat diakses oleh pengguna melalui internet. Dalam panduan ini, kita akan membahas secara lengkap bagaimana cara men-deploy aplikasi <strong>Laravel</strong> ke <strong>Ubuntu Server</strong> menggunakan <strong>Nginx</strong> sebagai web server, serta mengeksposnya ke internet menggunakan <strong>Cloudflare Tunnel</strong>.</p>

<p>Panduan ini dibagi menjadi <strong>12 langkah</strong> utama yang mencakup seluruh proses dari instalasi dependencies hingga konfigurasi Cloudflare Tunnel agar website Anda dapat diakses dengan domain custom dan HTTPS otomatis.</p>

<h2>Prasyarat</h2>
<ul>
    <li>Server Ubuntu 20.04 atau lebih baru (bisa VPS, dedicated server, atau bahkan komputer lokal)</li>
    <li>Akses root atau sudo ke server</li>
    <li>Repository project Laravel yang sudah siap di GitHub</li>
    <li>Akun Cloudflare dengan domain yang sudah terdaftar (untuk bagian Cloudflare Tunnel)</li>
    <li>Koneksi internet yang stabil pada server</li>
</ul>

<h2>Bagian 1: Setup Server & Deploy Laravel</h2>

<h3>Step 1 — Install Dependencies</h3>
<p>Langkah pertama adalah mempersiapkan server dengan menginstall seluruh software yang dibutuhkan. Laravel memerlukan PHP 8.2 atau lebih baru beserta sejumlah extension PHP, Composer untuk manajemen package PHP, Node.js untuk build frontend assets, Nginx sebagai web server, dan MySQL sebagai database.</p>

<p><strong>Update sistem dan install PHP beserta extension-nya:</strong></p>
<pre><code># Update package list dan upgrade sistem
apt update && apt upgrade -y

# Install PHP 8.2+ dan seluruh extension yang dibutuhkan Laravel
apt install -y php php-cli php-fpm php-mysql php-mbstring php-xml php-curl php-zip php-gd unzip git nginx mysql-server</code></pre>

<p>Extension PHP yang diinstall memiliki fungsi masing-masing: <code>php-mysql</code> untuk koneksi database, <code>php-mbstring</code> untuk manipulasi string multibyte, <code>php-xml</code> untuk parsing XML, <code>php-curl</code> untuk HTTP request, <code>php-zip</code> untuk kompresi file, dan <code>php-gd</code> untuk manipulasi gambar.</p>

<p><strong>Install Composer dan Node.js:</strong></p>
<pre><code># Install Composer (dependency manager untuk PHP)
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

# Install Node.js 20 LTS (dibutuhkan untuk build frontend assets)
curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
apt install -y nodejs</code></pre>

<p>Pastikan semua terinstall dengan benar dengan menjalankan <code>php -v</code>, <code>composer -V</code>, dan <code>node -v</code> untuk mengecek versi masing-masing.</p>

<h3>Step 2 — Clone Repository</h3>
<p>Setelah semua dependencies terinstall, langkah berikutnya adalah mengunduh source code project dari GitHub ke server. Kita akan meletakkan project di direktori <code>/var/www</code> yang merupakan lokasi standar untuk web applications di Linux.</p>

<pre><code># Pindah ke direktori web server
cd /var/www

# Clone repository dari GitHub
git clone https://github.com/donarazhar/myblog.git

# Masuk ke direktori project
cd myblog</code></pre>

<p>Jika repository Anda bersifat private, Anda perlu mengkonfigurasi SSH key atau menggunakan personal access token untuk autentikasi.</p>

<h3>Step 3 — Setup Laravel</h3>
<p>Sekarang kita perlu menginstall semua dependency PHP melalui Composer dan mengkonfigurasi environment variable. Flag <code>--no-dev</code> memastikan hanya package production yang diinstall, dan <code>--optimize-autoloader</code> meningkatkan performa autoloading class.</p>

<pre><code># Install PHP dependencies (production mode)
composer install --no-dev --optimize-autoloader

# Salin file environment template
cp .env.example .env

# Edit file environment sesuai konfigurasi server
nano .env</code></pre>

<p><strong>⚠️ Penting!</strong> Sesuaikan file <code>.env</code> dengan konfigurasi server Anda. Berikut variabel yang harus diubah:</p>

<ul>
    <li><code>APP_ENV=production</code> — Mengatur mode aplikasi ke production</li>
    <li><code>APP_DEBUG=false</code> — Menonaktifkan debug mode agar error detail tidak terekspos</li>
    <li><code>APP_URL=http://IP_SERVER_ANDA</code> — URL dimana aplikasi akan diakses</li>
    <li><code>DB_DATABASE=myblog</code> — Nama database yang akan digunakan</li>
    <li><code>DB_USERNAME=root</code> — Username database MySQL</li>
    <li><code>DB_PASSWORD=password_anda</code> — Password database MySQL</li>
</ul>

<h3>Step 4 — Setup Database</h3>
<p>Laravel menggunakan MySQL sebagai database. Kita perlu membuat database baru, lalu menjalankan migrasi untuk membuat tabel-tabel yang dibutuhkan dan seeder untuk mengisi data awal.</p>

<p><strong>Buat database MySQL:</strong></p>
<pre><code># Masuk ke MySQL console
mysql -u root -p

# Buat database baru
CREATE DATABASE myblog;

# Keluar dari MySQL
exit;</code></pre>

<p><strong>Generate application key dan jalankan migrasi:</strong></p>
<pre><code># Generate encryption key untuk Laravel
php artisan key:generate

# Jalankan migrasi database dan seeder
php artisan migrate --seed

# Buat symbolic link untuk akses file storage dari public
php artisan storage:link</code></pre>

<p>Perintah <code>key:generate</code> akan menghasilkan encryption key unik yang digunakan Laravel untuk mengenkripsi session, cookies, dan data sensitif lainnya. Perintah <code>migrate --seed</code> akan membuat semua tabel database dan mengisi data awal. Perintah <code>storage:link</code> membuat symlink dari <code>public/storage</code> ke <code>storage/app/public</code> agar file yang di-upload dapat diakses via URL.</p>

<h3>Step 5 — Build Frontend</h3>
<p>Laravel modern menggunakan Vite sebagai build tool untuk mengompilasi dan mengoptimasi file CSS dan JavaScript. Proses build akan menghasilkan file-file yang sudah di-minify dan di-cache untuk performa optimal di production.</p>

<pre><code># Install seluruh npm package yang dibutuhkan
npm install

# Build assets untuk production (CSS & JS di-minify dan di-hash)
npm run build</code></pre>

<p>Setelah proses build selesai, file-file hasil kompilasi akan tersimpan di direktori <code>public/build</code>. File-file ini sudah siap untuk digunakan di production dengan filename yang di-hash untuk cache busting.</p>

<h3>Step 6 — Set Permissions</h3>
<p>Pengaturan permission yang benar sangat penting untuk keamanan dan fungsionalitas Laravel. Web server Nginx berjalan sebagai user <code>www-data</code>, sehingga user ini memerlukan akses ke file-file project, terutama direktori <code>storage</code> dan <code>bootstrap/cache</code> yang digunakan Laravel untuk menulis file cache, log, dan session.</p>

<pre><code># Set kepemilikan seluruh project ke user www-data
chown -R www-data:www-data /var/www/myblog

# Set permission untuk direktori storage (read, write, execute)
chmod -R 755 /var/www/myblog/storage

# Set permission untuk direktori bootstrap/cache
chmod -R 755 /var/www/myblog/bootstrap/cache</code></pre>

<p>Tanpa permission yang benar, Laravel tidak akan bisa menulis file log, menyimpan session, atau melakukan cache konfigurasi, yang akan menyebabkan error 500 pada website.</p>

<h3>Step 7 — Konfigurasi Nginx</h3>
<p>Nginx bertindak sebagai web server yang menerima HTTP request dari client dan meneruskannya ke PHP-FPM untuk diproses oleh Laravel. Kita perlu membuat virtual host configuration file yang mendefinisikan bagaimana Nginx harus menangani request untuk website kita.</p>

<p><strong>Buat file konfigurasi:</strong></p>
<pre><code>nano /etc/nginx/sites-available/myblog</code></pre>

<p><strong>Isi dengan konfigurasi berikut:</strong></p>
<pre><code>server {
    listen 80;
    server_name IP_SERVER_ANDA;
    root /var/www/myblog/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}</code></pre>

<p>Konfigurasi di atas mengarahkan semua request ke <code>public/index.php</code> (entry point Laravel), menggunakan PHP-FPM untuk memproses file PHP, dan menambahkan security header untuk perlindungan dasar. Directive <code>location ~ /\.</code> terakhir memblokir akses ke file tersembunyi (seperti <code>.env</code>) untuk keamanan.</p>

<h3>Step 8 — Enable & Restart Nginx</h3>
<p>Setelah konfigurasi dibuat, kita perlu mengaktifkan site dengan membuat symbolic link ke direktori <code>sites-enabled</code>, menghapus konfigurasi default, dan merestart Nginx.</p>

<pre><code># Aktifkan konfigurasi site myblog
ln -s /etc/nginx/sites-available/myblog /etc/nginx/sites-enabled/

# Hapus konfigurasi default Nginx (opsional)
rm /etc/nginx/sites-enabled/default

# Test konfigurasi Nginx untuk memastikan tidak ada error syntax
nginx -t

# Restart Nginx untuk menerapkan perubahan
systemctl restart nginx</code></pre>

<p>✅ <strong>Local Access Ready!</strong> Jika semua langkah berhasil, website Anda sekarang dapat diakses melalui <code>http://IP_SERVER_ANDA</code> dalam jaringan lokal. Buka browser dan akses IP server untuk memastikan Laravel berjalan dengan baik.</p>

<h2>Bagian 2: Cloudflare Tunnel Setup</h2>
<p>Jika Anda ingin mengekspos server lokal ke internet tanpa perlu port forwarding atau IP publik statis, <strong>Cloudflare Tunnel</strong> adalah solusi yang tepat. Tunnel ini membuat koneksi terenkripsi dari server Anda ke jaringan Cloudflare, sehingga website dapat diakses via domain custom dengan HTTPS otomatis — tanpa biaya tambahan.</p>

<h3>Step 9 — Install Cloudflared</h3>
<p>Cloudflared adalah daemon yang menjalankan tunnel antara server Anda dan jaringan Cloudflare. Download dan install dari repository resmi:</p>

<pre><code># Download package cloudflared terbaru
curl -L --output cloudflared.deb https://github.com/cloudflare/cloudflared/releases/latest/download/cloudflared-linux-amd64.deb

# Install package
dpkg -i cloudflared.deb

# Verifikasi instalasi berhasil
cloudflared --version</code></pre>

<h3>Step 10 — Create Tunnel</h3>
<p>Setelah Cloudflared terinstall, login ke akun Cloudflare Anda dan buat tunnel baru. Proses login akan membuka URL di browser untuk autentikasi — jika server tidak memiliki GUI, copy URL yang ditampilkan dan buka di browser komputer lain.</p>

<pre><code># Login ke akun Cloudflare (akan memberikan URL untuk autentikasi)
cloudflared tunnel login

# Buat tunnel baru bernama "myblog"
cloudflared tunnel create myblog</code></pre>

<p>📝 <strong>Catat Tunnel ID!</strong> Setelah tunnel berhasil dibuat, akan muncul Tunnel ID berupa UUID (<code>xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx</code>). Simpan ID ini karena dibutuhkan untuk konfigurasi selanjutnya.</p>

<h3>Step 11 — Configure Tunnel</h3>
<p>Buat file konfigurasi YAML yang mendefinisikan bagaimana tunnel harus merutekan traffic dari domain ke service di server lokal.</p>

<p><strong>Buat file konfigurasi:</strong></p>
<pre><code># Buat direktori konfigurasi (jika belum ada)
mkdir -p ~/.cloudflared

# Edit file konfigurasi
nano ~/.cloudflared/config.yml</code></pre>

<p><strong>Isi file config.yml:</strong></p>
<pre><code>tunnel: &lt;TUNNEL_ID&gt;
credentials-file: /root/.cloudflared/&lt;TUNNEL_ID&gt;.json

ingress:
  - hostname: donarazhar.site
    service: http://localhost:80
  - hostname: www.donarazhar.site
    service: http://localhost:80
  - service: http_status:404</code></pre>

<p>Ganti <code>&lt;TUNNEL_ID&gt;</code> dengan UUID tunnel Anda. Bagian <code>ingress</code> mendefinisikan routing: request ke <code>donarazhar.site</code> dan <code>www.donarazhar.site</code> akan diteruskan ke Nginx di port 80, sedangkan request lainnya akan mendapat response 404.</p>

<p><strong>Route DNS domain ke tunnel:</strong></p>
<pre><code># Arahkan domain utama ke tunnel
cloudflared tunnel route dns myblog donarazhar.site

# Arahkan subdomain www ke tunnel
cloudflared tunnel route dns myblog www.donarazhar.site</code></pre>

<p><strong>Update APP_URL di Laravel:</strong></p>
<pre><code># Edit file .env untuk mengubah APP_URL
nano /var/www/myblog/.env

# Ubah APP_URL menjadi domain Cloudflare:
# APP_URL=https://donarazhar.site

# Clear dan re-cache konfigurasi Laravel
cd /var/www/myblog && php artisan config:cache</code></pre>

<h3>Step 12 — Run as Service</h3>
<p>Agar tunnel berjalan otomatis setiap kali server boot (restart), kita perlu menginstall Cloudflared sebagai system service. Sebelum itu, lakukan test dulu untuk memastikan tunnel berjalan dengan benar.</p>

<pre><code># Test tunnel terlebih dahulu (tekan Ctrl+C untuk stop)
cloudflared tunnel run myblog

# Jika tunnel berhasil berjalan, install sebagai system service
cloudflared service install

# Start service
systemctl start cloudflared

# Enable auto-start saat boot
systemctl enable cloudflared

# Cek status service
systemctl status cloudflared</code></pre>

<p>🎉 <strong>Deployment Complete!</strong> Website Anda sekarang dapat diakses dari mana saja melalui:</p>
<ul>
    <li><code>https://donarazhar.site</code></li>
    <li><code>https://www.donarazhar.site</code></li>
</ul>

<p>Cloudflare secara otomatis menyediakan sertifikat SSL/TLS sehingga website Anda langsung memiliki HTTPS tanpa perlu konfigurasi tambahan.</p>

<h2>Troubleshooting</h2>
<p>Berikut beberapa masalah umum yang mungkin ditemui beserta solusinya:</p>
<ul>
    <li><strong>Error 502 Bad Gateway</strong> — Pastikan PHP-FPM berjalan: <code>systemctl status php8.2-fpm</code></li>
    <li><strong>Error 500 Internal Server Error</strong> — Cek log Laravel di <code>storage/logs/laravel.log</code> dan pastikan permission sudah benar</li>
    <li><strong>Halaman blank putih</strong> — Biasanya terkait permission, jalankan ulang perintah <code>chown</code> dan <code>chmod</code></li>
    <li><strong>Tunnel tidak connect</strong> — Pastikan config.yml sudah benar dan Tunnel ID sesuai</li>
    <li><strong>Assets tidak muncul (CSS/JS)</strong> — Pastikan sudah menjalankan <code>npm run build</code> dan <code>php artisan storage:link</code></li>
</ul>

<h2>Kesimpulan</h2>
<p>Dalam panduan ini, kita telah berhasil men-deploy aplikasi Laravel dari awal hingga akhir, dimulai dari instalasi dependencies di Ubuntu Server, konfigurasi Nginx sebagai web server, setup database MySQL, hingga mengekspos server ke internet menggunakan Cloudflare Tunnel. Dengan setup ini, website Anda memiliki koneksi yang aman melalui HTTPS, dapat diakses dari mana saja, dan tunnel akan berjalan otomatis setiap kali server restart.</p>
',
                'user_id' => $admin->id,
                'category_id' => $category->id,
                'status' => 'published',
                'published_at' => now(),
            ]
        );

        $this->command->info('Deployment Guide article created/updated successfully!');
    }
}
