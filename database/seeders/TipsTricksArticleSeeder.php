<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class TipsTricksArticleSeeder extends Seeder
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

        // Create or Update Tips & Tricks article
        Article::updateOrCreate(
            ['slug' => 'tips-tricks-troubleshooting-developer'],
            [
                'title' => 'Tips & Tricks: Troubleshooting Umum untuk Developer — SSH, Git, Laravel, dan Server',
                'excerpt' => 'Kumpulan solusi praktis untuk masalah yang sering dialami developer, mulai dari gagal SSH ke server, perintah Git sehari-hari, troubleshooting Laravel, hingga manajemen Nginx dan MySQL di Ubuntu Server.',
                'content' => '
<p>Sebagai developer, kita pasti pernah mengalami momen frustrasi ketika sesuatu yang seharusnya sederhana ternyata tidak berjalan semestinya. Koneksi SSH ditolak, git push gagal, Laravel menampilkan error 500, atau Nginx tiba-tiba tidak meresponse. Artikel ini mengumpulkan <strong>tips dan trik</strong> praktis yang sering saya gunakan dalam pekerjaan sehari-hari untuk menyelesaikan masalah-masalah umum tersebut.</p>

<p>Anggap artikel ini sebagai <em>cheat sheet</em> pribadi yang bisa Anda bookmark dan kunjungi kapanpun dibutuhkan.</p>

<h2>🔐 SSH — Troubleshooting Koneksi ke Server</h2>

<p>SSH (Secure Shell) adalah cara utama kita mengakses server secara remote. Namun, koneksi SSH sering bermasalah karena berbagai alasan. Berikut masalah yang paling sering terjadi dan cara mengatasinya:</p>

<h3>Masalah 1: Connection Refused</h3>
<p>Error: <code>ssh: connect to host 192.168.x.x port 22: Connection refused</code></p>
<p>Ini biasanya terjadi karena SSH service belum berjalan di server atau firewall memblokir port 22.</p>

<p><strong>Solusi:</strong></p>
<pre><code># Cek apakah SSH service berjalan (jalankan di server langsung)
systemctl status ssh

# Jika belum berjalan, start dan enable
sudo systemctl start ssh
sudo systemctl enable ssh

# Jika SSH belum terinstall
sudo apt install openssh-server

# Cek apakah port 22 terbuka
sudo ufw status

# Buka port 22 di firewall
sudo ufw allow ssh
sudo ufw allow 22/tcp</code></pre>

<h3>Masalah 2: Connection Timed Out</h3>
<p>Error: <code>ssh: connect to host 192.168.x.x port 22: Connection timed out</code></p>
<p>Ini biasanya karena server tidak bisa dijangkau — IP salah, server mati, atau ada masalah jaringan.</p>

<p><strong>Solusi:</strong></p>
<pre><code># Pastikan server hidup dan terhubung ke jaringan
ping 192.168.x.x

# Cek IP address server yang benar
ip addr show

# Jika menggunakan WiFi, pastikan laptop dan server di jaringan yang sama
# Cek IP laptop:
ipconfig   # Windows
ifconfig   # Linux/Mac</code></pre>

<h3>Masalah 3: Permission Denied (Password Salah)</h3>
<p>Error: <code>Permission denied, please try again.</code></p>

<p><strong>Solusi:</strong></p>
<pre><code># Pastikan username dan password benar
ssh root@192.168.x.x

# Jika lupa password root, reset dari server langsung:
sudo passwd root

# Cek apakah login root via SSH diizinkan
sudo nano /etc/ssh/sshd_config
# Pastikan: PermitRootLogin yes
# Lalu restart SSH:
sudo systemctl restart ssh</code></pre>

<h3>Masalah 4: Host Key Verification Failed</h3>
<p>Error: <code>WARNING: REMOTE HOST IDENTIFICATION HAS CHANGED!</code></p>
<p>Ini terjadi ketika server di-reinstall atau IP-nya berubah, sehingga fingerprint SSH-nya tidak cocok dengan yang tersimpan.</p>

<p><strong>Solusi:</strong></p>
<pre><code># Hapus entry lama dari known_hosts
ssh-keygen -R 192.168.x.x

# Lalu coba SSH lagi, ketik "yes" saat diminta
ssh root@192.168.x.x</code></pre>

<h3>Masalah 5: Koneksi SSH Sering Putus (Timeout)</h3>
<p>Koneksi SSH terputus setelah idle beberapa saat? Tambahkan konfigurasi keep-alive:</p>

<p><strong>Solusi (di sisi client/laptop):</strong></p>
<pre><code># Edit SSH config di laptop (Windows: C:\Users\username\.ssh\config)
Host *
    ServerAliveInterval 60
    ServerAliveCountMax 3</code></pre>

<p><strong>Solusi (di sisi server):</strong></p>
<pre><code># Edit konfigurasi SSH server
sudo nano /etc/ssh/sshd_config

# Tambahkan:
ClientAliveInterval 60
ClientAliveCountMax 3

# Restart SSH
sudo systemctl restart ssh</code></pre>

<h2>🔄 Git & GitHub — Perintah Sehari-hari</h2>

<p>Git adalah version control wajib untuk setiap developer. Berikut perintah-perintah yang paling sering digunakan beserta penjelasannya:</p>

<h3>Workflow Dasar: Push Perubahan ke GitHub</h3>
<pre><code># 1. Cek status file yang berubah
git status

# 2. Tambahkan file yang ingin di-commit
git add .                           # Tambah semua file
git add nama_file.php               # Tambah file tertentu
git add database/seeders/           # Tambah satu folder

# 3. Commit dengan pesan deskriptif
git commit -m "feat: menambahkan fitur login"

# 4. Push ke GitHub
git push origin main</code></pre>

<h3>Workflow: Pull Perubahan dari GitHub (di Server)</h3>
<pre><code># Pindah ke direktori project
cd /var/www/myblog

# Tarik perubahan terbaru
git pull origin main

# Jika ada perubahan di composer.json:
composer install --no-dev --optimize-autoloader

# Jika ada perubahan migrasi:
php artisan migrate

# Jika ada seeder baru:
php artisan db:seed --class=NamaSeederBaru

# Jika ada perubahan frontend:
npm install
npm run build

# Clear cache setelah update
php artisan config:cache
php artisan route:cache
php artisan view:cache</code></pre>

<h3>Konvensi Pesan Commit</h3>
<p>Gunakan format yang konsisten agar history commit mudah dibaca:</p>
<ul>
    <li><code>feat: ...</code> — Fitur baru (contoh: <code>feat: tambah halaman about</code>)</li>
    <li><code>fix: ...</code> — Perbaikan bug (contoh: <code>fix: perbaiki error login</code>)</li>
    <li><code>docs: ...</code> — Perubahan dokumentasi</li>
    <li><code>style: ...</code> — Perubahan tampilan/CSS (bukan logic)</li>
    <li><code>refactor: ...</code> — Refactoring kode tanpa mengubah fungsionalitas</li>
    <li><code>chore: ...</code> — Update dependencies, konfigurasi, dll</li>
</ul>

<h3>Troubleshooting Git</h3>

<p><strong>Masalah: "Your branch is behind" saat push</strong></p>
<pre><code># Pull dulu perubahan dari remote, lalu push
git pull origin main
git push origin main

# Jika ada conflict, selesaikan conflict di file yang ditandai
# kemudian:
git add .
git commit -m "fix: resolve merge conflict"
git push origin main</code></pre>

<p><strong>Masalah: Sudah commit tapi mau ubah pesan commit</strong></p>
<pre><code># Ubah pesan commit terakhir (sebelum push)
git commit --amend -m "pesan baru yang benar"</code></pre>

<p><strong>Masalah: Mau membatalkan perubahan file</strong></p>
<pre><code># Batalkan perubahan di satu file (belum di-add)
git checkout -- nama_file.php

# Batalkan semua perubahan (belum di-add)
git checkout -- .

# Undo git add (sudah di-add tapi belum commit)
git reset HEAD nama_file.php

# Undo commit terakhir tapi simpan perubahannya
git reset --soft HEAD~1</code></pre>

<p><strong>Masalah: Clone repository private</strong></p>
<pre><code># Menggunakan Personal Access Token (PAT)
git clone https://TOKEN@github.com/username/repo.git

# Atau setup SSH key:
ssh-keygen -t ed25519 -C "email@example.com"
cat ~/.ssh/id_ed25519.pub
# Copy output dan tambahkan di GitHub > Settings > SSH Keys</code></pre>

<h2>🛠️ Laravel — Perintah Artisan yang Wajib Diketahui</h2>

<p>Laravel artisan adalah CLI tool yang sangat powerful. Berikut perintah-perintah yang paling sering digunakan:</p>

<h3>Perintah Cache (Wajib Setelah Deploy)</h3>
<pre><code># Clear semua cache sekaligus
php artisan optimize:clear

# Atau clear satu per satu:
php artisan config:clear      # Clear config cache
php artisan route:clear       # Clear route cache
php artisan view:clear        # Clear compiled views
php artisan cache:clear       # Clear application cache

# Build cache untuk production (lebih cepat):
php artisan config:cache      # Cache konfigurasi
php artisan route:cache       # Cache routes
php artisan view:cache        # Pre-compile Blade views</code></pre>

<h3>Database & Migration</h3>
<pre><code># Jalankan migrasi
php artisan migrate

# Rollback migrasi terakhir
php artisan migrate:rollback

# Reset semua migrasi dan jalankan ulang + seed
php artisan migrate:fresh --seed

# Jalankan seeder tertentu
php artisan db:seed --class=NamaSeeder

# Buat migration baru
php artisan make:migration create_nama_tabel_table

# Buat model + migration + seeder + controller sekaligus
php artisan make:model NamaModel -msc</code></pre>

<h3>Debugging Laravel</h3>
<pre><code># Cek log error Laravel
tail -f storage/logs/laravel.log       # Linux
Get-Content storage\logs\laravel.log -Tail 50   # PowerShell

# Cek routes yang terdaftar
php artisan route:list

# Cek versi Laravel
php artisan --version

# Masuk ke Tinker (REPL untuk testing)
php artisan tinker</code></pre>

<h3>Masalah Umum Laravel di Production</h3>

<p><strong>Error 500 tanpa info:</strong></p>
<pre><code># Pastikan APP_DEBUG=false di production, tapi cek log:
tail -50 storage/logs/laravel.log

# Pastikan permission storage benar
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 755 storage bootstrap/cache</code></pre>

<p><strong>Error "Class not found" setelah deploy:</strong></p>
<pre><code># Regenerate autoload
composer dump-autoload

# Atau install ulang
composer install --no-dev --optimize-autoloader</code></pre>

<p><strong>Error "Key not set" atau encryption error:</strong></p>
<pre><code># Generate application key
php artisan key:generate

# Clear config cache setelahnya
php artisan config:cache</code></pre>

<h2>🌐 Nginx — Manajemen Web Server</h2>

<h3>Perintah Dasar</h3>
<pre><code># Cek status Nginx
systemctl status nginx

# Start / Stop / Restart
sudo systemctl start nginx
sudo systemctl stop nginx
sudo systemctl restart nginx

# Reload konfigurasi tanpa downtime
sudo systemctl reload nginx

# Test konfigurasi sebelum restart (SELALU lakukan ini!)
sudo nginx -t</code></pre>

<h3>Cek Log Error</h3>
<pre><code># Log error Nginx
sudo tail -f /var/log/nginx/error.log

# Log akses Nginx
sudo tail -f /var/log/nginx/access.log

# Log error untuk site tertentu (jika dikonfigurasi)
sudo tail -f /var/log/nginx/myblog-error.log</code></pre>

<h3>Masalah Umum Nginx</h3>

<p><strong>Error 502 Bad Gateway:</strong></p>
<pre><code># PHP-FPM tidak berjalan
sudo systemctl status php8.2-fpm
sudo systemctl restart php8.2-fpm

# Cek versi PHP-FPM yang aktif
ls /var/run/php/

# Pastikan socket di Nginx config sesuai dengan versi PHP
# Di /etc/nginx/sites-available/myblog:
# fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;</code></pre>

<p><strong>Error 403 Forbidden:</strong></p>
<pre><code># Masalah permission
sudo chown -R www-data:www-data /var/www/myblog
sudo chmod -R 755 /var/www/myblog

# Pastikan root path benar di Nginx config
# root /var/www/myblog/public;  (BUKAN /var/www/myblog)</code></pre>

<h2>🗄️ MySQL — Database Management</h2>

<h3>Perintah Dasar</h3>
<pre><code># Masuk ke MySQL
mysql -u root -p

# Lihat semua database
SHOW DATABASES;

# Pilih database
USE myblog;

# Lihat semua tabel
SHOW TABLES;

# Lihat isi tabel
SELECT * FROM articles;
SELECT * FROM users;

# Keluar
exit;</code></pre>

<h3>Backup & Restore Database</h3>
<pre><code># Backup database ke file SQL
mysqldump -u root -p myblog > backup_myblog_$(date +%Y%m%d).sql

# Restore database dari file SQL
mysql -u root -p myblog < backup_myblog.sql

# Backup semua database
mysqldump -u root -p --all-databases > backup_all.sql</code></pre>

<h3>Reset Password User Laravel via MySQL</h3>
<pre><code># Masuk MySQL
mysql -u root -p

# Pilih database
USE myblog;

# Lihat user yang ada
SELECT id, name, email FROM users;

# Reset password admin menjadi "password"
# Hash bcrypt untuk "password":
UPDATE users SET password = "$2y$12$LZhBRfaQe5aDMR1qEBmWG.YI6SRMVFBxncOL3Q3pJE0VZzBRzGq7S" WHERE email = "admin@demo.com";

exit;</code></pre>

<h2>☁️ Cloudflare Tunnel — Troubleshooting</h2>

<h3>Cek Status Tunnel</h3>
<pre><code># Cek service cloudflared
sudo systemctl status cloudflared

# Lihat log tunnel
sudo journalctl -u cloudflared -f

# Lihat daftar tunnel
cloudflared tunnel list

# Cek info tunnel tertentu
cloudflared tunnel info myblog</code></pre>

<h3>Masalah: Website Tidak Bisa Diakses via Domain</h3>
<pre><code># 1. Pastikan cloudflared service berjalan
sudo systemctl status cloudflared

# 2. Restart jika perlu
sudo systemctl restart cloudflared

# 3. Cek apakah Nginx berjalan (tunnel mengarah ke localhost:80)
sudo systemctl status nginx

# 4. Test akses dari server sendiri
curl http://localhost

# 5. Cek config tunnel
cat ~/.cloudflared/config.yml

# 6. Jika masih bermasalah, jalankan tunnel manual untuk lihat error:
sudo systemctl stop cloudflared
cloudflared tunnel run myblog</code></pre>

<h2>⚡ Tips Cepat Lainnya</h2>

<h3>Cek Penggunaan Disk</h3>
<pre><code># Lihat penggunaan disk secara keseluruhan
df -h

# Lihat ukuran folder tertentu
du -sh /var/www/myblog

# Cari file besar
find / -size +100M -type f 2>/dev/null</code></pre>

<h3>Cek Penggunaan RAM dan CPU</h3>
<pre><code># Lihat penggunaan memori
free -h

# Lihat proses yang berjalan (sortir berdasarkan CPU usage)
top
htop   # Versi lebih user-friendly (install: apt install htop)</code></pre>

<h3>Restart Service Sekaligus (Setelah Deploy)</h3>
<pre><code># Script restart semua service sekaligus
sudo systemctl restart php8.2-fpm
sudo systemctl restart nginx
sudo systemctl restart cloudflared

# Atau buat alias di ~/.bashrc:
# alias deploy-restart="sudo systemctl restart php8.2-fpm nginx cloudflared"</code></pre>

<h3>Cek Port yang Digunakan</h3>
<pre><code># Lihat port yang sedang listening
sudo ss -tlnp

# Atau menggunakan netstat
sudo netstat -tlnp

# Cek apakah port tertentu digunakan
sudo lsof -i :80
sudo lsof -i :3306</code></pre>

<h2>📝 Cheat Sheet Ringkasan</h2>

<p>Berikut ringkasan perintah yang paling sering digunakan dalam satu tempat:</p>

<pre><code># === SSH ke Server ===
ssh root@192.168.x.x

# === Update Project dari GitHub ===
cd /var/www/myblog
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate
npm run build
php artisan optimize:clear
php artisan config:cache
sudo systemctl restart php8.2-fpm

# === Push Perubahan ke GitHub ===
git add .
git commit -m "feat: deskripsi perubahan"
git push origin main

# === Cek Log Error ===
tail -50 storage/logs/laravel.log    # Laravel
sudo tail -50 /var/log/nginx/error.log  # Nginx

# === Restart Semua Service ===
sudo systemctl restart php8.2-fpm nginx cloudflared</code></pre>

<p>Semoga kumpulan tips dan trik ini bermanfaat dan bisa menghemat waktu Anda dalam menyelesaikan masalah-masalah teknis sehari-hari. Jangan ragu untuk bookmark halaman ini dan kembali kapanpun dibutuhkan! 🚀</p>
',
                'user_id' => $admin->id,
                'category_id' => $category->id,
                'status' => 'published',
                'published_at' => now(),
            ]
        );

        $this->command->info('Tips & Tricks article created/updated successfully!');
    }
}
