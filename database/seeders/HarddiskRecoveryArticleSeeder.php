<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class HarddiskRecoveryArticleSeeder extends Seeder
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

        // Create Harddisk Recovery article
        Article::create([
            'title' => 'Tutorial Komprehensif Penyelamatan Data Harddisk Rusak',
            'slug' => 'tutorial-komprehensif-penyelamatan-data-harddisk-rusak',
            'excerpt' => 'Panduan lengkap penyelamatan data dari harddisk rusak dengan 3 metode: USB SATA External Adapter, Direct SATA Connection, dan Recovery via Ubuntu. Dilengkapi tools recovery lanjutan dan tips troubleshooting.',
            'content' => '
<p>Di era digital, data adalah aset berharga. Kehilangan data akibat harddisk rusak bisa menjadi bencana. Tutorial ini membahas secara komprehensif cara menyelamatkan data dari harddisk yang rusak dengan 3 metode berbeda.</p>

<h2>🔧 Persiapan Awal</h2>

<h3>Peralatan yang Dibutuhkan:</h3>
<ul>
    <li><strong>Kabel USB to SATA adapter</strong> (untuk metode 1)</li>
    <li><strong>Kabel SATA data + power</strong> (untuk metode 2)</li>
    <li><strong>USB Flash Drive</strong> minimal 4GB untuk Ubuntu Live</li>
    <li><strong>Harddisk eksternal</strong> untuk menyimpan data hasil recovery</li>
    <li><strong>Obeng</strong> (jika harddisk masih di dalam casing laptop/PC)</li>
</ul>

<h3>Tanda-tanda Harddisk Rusak:</h3>
<ul>
    <li>Tidak terdeteksi di BIOS</li>
    <li>Bunyi klik-klik atau beep</li>
    <li>Sangat lambat saat diakses</li>
    <li>Blue Screen of Death (BSOD) berulang</li>
    <li>Bad sectors banyak</li>
    <li>File corrupt atau hilang</li>
</ul>

<p><strong>⚠️ PERINGATAN PENTING:</strong></p>
<ol>
    <li><strong>JANGAN format harddisk</strong> jika masih ada data penting</li>
    <li><strong>Matikan komputer dengan benar</strong> sebelum mencabut harddisk</li>
    <li><strong>Hindari guncangan</strong> pada harddisk yang rusak</li>
    <li><strong>Backup segera</strong> jika harddisk masih terbaca</li>
    <li><strong>Jangan install software</strong> ke harddisk yang rusak</li>
</ol>

<h2>📱 Metode 1: USB SATA External Adapter</h2>

<p>Metode ini paling mudah untuk pemula, tidak perlu bongkar PC, dan cocok untuk harddisk laptop (2.5") maupun desktop (3.5").</p>

<h3>Langkah 1: Persiapan Hardware</h3>
<ol>
    <li><strong>Keluarkan harddisk dari laptop/PC:</strong>
        <ul>
            <li>Matikan komputer dan cabut kabel power</li>
            <li>Buka casing dengan obeng</li>
            <li>Lepaskan harddisk dengan hati-hati</li>
            <li>Catat jenis harddisk: 2.5" (laptop) atau 3.5" (desktop)</li>
        </ul>
    </li>
    <li><strong>Hubungkan ke USB SATA Adapter:</strong>
        <ul>
            <li>Pasang harddisk ke adapter SATA</li>
            <li>Untuk harddisk 3.5", pastikan adaptor memiliki power supply eksternal</li>
            <li>Untuk harddisk 2.5", biasanya cukup USB power</li>
        </ul>
    </li>
</ol>

<h3>Langkah 2: Koneksi ke Komputer</h3>
<ol>
    <li>Colokkan USB adapter ke komputer yang sehat</li>
    <li>Tunggu Windows mendeteksi (akan muncul notifikasi)</li>
    <li>Buka <strong>Disk Management</strong>:
        <ul>
            <li>Tekan <code>Win + R</code></li>
            <li>Ketik: <code>diskmgmt.msc</code></li>
            <li>Enter</li>
        </ul>
    </li>
</ol>

<h3>Langkah 3: Cek Status Harddisk</h3>

<p><strong>✅ Jika terdeteksi dan bisa dibaca:</strong></p>
<ol>
    <li>Buka "This PC" atau "My Computer"</li>
    <li>Klik drive harddisk eksternal</li>
    <li>Copy semua data ke lokasi aman</li>
    <li><strong>SELESAI - Data berhasil diselamatkan!</strong></li>
</ol>

<p><strong>ℹ️ Jika terdeteksi tapi tidak ada drive letter:</strong></p>
<ol>
    <li>Di Disk Management, klik kanan partisi</li>
    <li>Pilih "Change Drive Letter and Paths"</li>
    <li>Assign drive letter (misal E:, F:, dsb)</li>
    <li>Coba akses lagi</li>
</ol>

<p><strong>⚠️ Jika muncul "RAW" atau "Unallocated":</strong></p>
<p><strong>JANGAN FORMAT!</strong> Lanjut ke metode recovery (lihat bagian Tools Recovery Lanjutan)</p>

<h3>Langkah 4: Copy Data Manual</h3>
<p>Jika harddisk terbaca normal, gunakan Command Prompt untuk copy yang lebih stabil:</p>

<pre><code># Via Command Prompt (lebih stabil untuk file besar)
# Buka CMD sebagai Administrator

# Copy seluruh folder
xcopy E:\*.* D:\Backup\ /E /H /C /I /Y

# Keterangan:
# E:\ = Drive harddisk rusak
# D:\Backup\ = Lokasi tujuan backup
# /E = Copy semua subfolder termasuk yang kosong
# /H = Copy hidden files
# /C = Continue meski ada error
# /I = Assume destination is folder
# /Y = Overwrite tanpa konfirmasi</code></pre>

<h2>🖥️ Metode 2: Koneksi Langsung via Kabel SATA di PC</h2>

<p>Metode ini lebih stabil daripada USB adapter, kecepatan transfer lebih cepat, dan cocok untuk harddisk dengan banyak error.</p>

<h3>Langkah 1: Persiapan PC</h3>
<ol>
    <li>Matikan PC dan cabut kabel power</li>
    <li>Buka casing PC (biasanya baut di belakang)</li>
    <li>Sentuh bagian metal casing untuk discharge static</li>
</ol>

<h3>Langkah 2: Instalasi Harddisk</h3>
<ol>
    <li><strong>Pasang kabel SATA data:</strong>
        <ul>
            <li>Sambungkan satu ujung ke harddisk</li>
            <li>Ujung lain ke motherboard (cari port SATA kosong)</li>
        </ul>
    </li>
    <li><strong>Pasang kabel SATA power:</strong>
        <ul>
            <li>Dari PSU (Power Supply Unit)</li>
            <li>Ke port power harddisk</li>
        </ul>
    </li>
    <li>Pastikan koneksi kencang dan tidak goyang</li>
</ol>

<h3>Langkah 3: Atur BIOS (jika perlu)</h3>
<ol>
    <li>Nyalakan PC dan tekan <code>Del</code> / <code>F2</code> / <code>F10</code> (tergantung motherboard)</li>
    <li>Masuk ke BIOS Setup</li>
    <li>Cari menu <strong>Storage/SATA Configuration</strong></li>
    <li>Pastikan SATA port yang digunakan dalam status "Enabled"</li>
    <li>Ubah SATA Mode (jika diperlukan): Dari <code>AHCI</code> ke <code>IDE</code> atau sebaliknya, atau coba mode <code>RAID</code></li>
    <li>Save &amp; Exit (biasanya F10)</li>
</ol>

<h3>Langkah 4: Boot ke Windows</h3>
<ol>
    <li>Buka <strong>Disk Management</strong> (<code>Win + R</code> → <code>diskmgmt.msc</code>)</li>
    <li>Lihat status harddisk</li>
    <li>Assign drive letter jika perlu</li>
    <li>Copy data seperti metode 1</li>
</ol>

<p><strong>💡 Tips:</strong> Jika Windows tidak mau boot, boot ke Safe Mode (tekan F8 saat booting), atau lanjut ke Metode 3 (Ubuntu).</p>

<h2>🐧 Metode 3: Recovery via Ubuntu</h2>

<p>Metode ini paling powerful! Cocok jika harddisk tidak terbaca di Windows, filesystem corrupt, atau butuh tools recovery advanced.</p>

<h3>Langkah 1: Persiapan Ubuntu Live USB</h3>

<p><strong>Download Ubuntu:</strong></p>
<ol>
    <li>Download Ubuntu Desktop ISO dari <a href="https://ubuntu.com/download" target="_blank">ubuntu.com/download</a></li>
    <li>Pilih versi LTS terbaru (misal: Ubuntu 24.04 LTS)</li>
</ol>

<p><strong>Buat Bootable USB:</strong></p>
<ol>
    <li>Download <strong>Rufus</strong> (Windows) atau <strong>Balena Etcher</strong> (cross-platform)</li>
    <li>Colokkan USB flash drive minimal 4GB</li>
    <li>Buka Rufus/Etcher</li>
    <li>Pilih ISO Ubuntu</li>
    <li>Pilih USB drive</li>
    <li>Klik "Start" atau "Flash"</li>
    <li>Tunggu selesai</li>
</ol>

<h3>Langkah 2: Boot ke Ubuntu Live</h3>
<ol>
    <li>Masukkan USB ke komputer</li>
    <li>Restart komputer</li>
    <li>Tekan tombol boot menu (biasanya F12, F9, atau Esc)</li>
    <li>Pilih USB Flash Drive dari menu</li>
    <li>Pilih <strong>"Try Ubuntu"</strong> (jangan install)</li>
</ol>

<h3>Langkah 3: Identifikasi Harddisk di Ubuntu</h3>
<p>Buka Terminal dengan menekan <code>Ctrl + Alt + T</code></p>

<pre><code># Lihat semua disk yang terdeteksi
sudo fdisk -l

# Output akan menampilkan semua disk seperti:
# /dev/sda - Disk utama sistem
# /dev/sdb - Harddisk rusak (yang ingin diselamatkan)
# /dev/sdc - Harddisk eksternal (tujuan backup)

# Lihat detail dengan lsblk
lsblk

# Cek status SMART harddisk (untuk deteksi kerusakan)
sudo apt update
sudo apt install smartmontools -y
sudo smartctl -a /dev/sdb

# Cek bad sectors
sudo badblocks -v /dev/sdb > ~/bad-blocks.txt</code></pre>

<h3>Langkah 4: Mount Harddisk Rusak</h3>

<pre><code># Buat folder untuk mount point
sudo mkdir -p /mnt/harddisk-rusak
sudo mkdir -p /mnt/harddisk-backup

# Mount harddisk rusak (ganti sdb1 sesuai partisi Anda)
sudo mount /dev/sdb1 /mnt/harddisk-rusak

# Mount harddisk eksternal untuk backup (ganti sdc1 sesuai partisi Anda)
sudo mount /dev/sdc1 /mnt/harddisk-backup

# Cek apakah berhasil di-mount
df -h | grep mnt

# Jika ada error "unknown filesystem", coba deteksi:
sudo blkid /dev/sdb1

# Mount dengan filesystem spesifik (contoh NTFS):
sudo mount -t ntfs-3g /dev/sdb1 /mnt/harddisk-rusak

# Untuk ext4:
sudo mount -t ext4 /dev/sdb1 /mnt/harddisk-rusak

# Jika read-only atau corrupt, mount dengan opsi recovery:
sudo mount -t ntfs-3g -o ro,recover /dev/sdb1 /mnt/harddisk-rusak</code></pre>

<h3>Langkah 5: Copy Data dengan DDrescue (Metode Terbaik)</h3>

<p>DDrescue adalah tool terbaik untuk harddisk rusak karena bisa skip bad sectors, bisa resume jika terputus, lebih cepat daripada <code>dd</code>, dan memiliki logging lengkap.</p>

<pre><code># Install ddrescue (tool terbaik untuk harddisk rusak)
sudo apt update
sudo apt install gddrescue -y

# PENTING: Sintaks ddrescue berbeda dengan dd!
# Format: ddrescue [input] [output] [logfile]

# Backup SELURUH harddisk ke file image
sudo ddrescue /dev/sdb /mnt/harddisk-backup/disk-image.img /mnt/harddisk-backup/rescue.log

# Backup hanya satu partisi
sudo ddrescue /dev/sdb1 /mnt/harddisk-backup/partition1.img /mnt/harddisk-backup/rescue1.log

# Opsi lengkap untuk kasus berat:
sudo ddrescue -d -r3 /dev/sdb /mnt/harddisk-backup/disk-image.img /mnt/harddisk-backup/rescue.log

# Keterangan opsi:
# -d : Direct disk access (lebih cepat)
# -r3 : Retry 3 kali pada sektor rusak
# -n : No-scrape mode (skip bad sectors di pass pertama)
# -v : Verbose (tampilkan progress detail)</code></pre>

<h3>Langkah 6: Copy Data Manual (Jika Mount Berhasil)</h3>

<pre><code># Navigasi ke folder harddisk rusak
cd /mnt/harddisk-rusak
ls -la

# Copy semua data dengan rsync (lebih aman, bisa resume)
sudo rsync -avh --progress /mnt/harddisk-rusak/ /mnt/harddisk-backup/DataRecovery/

# Keterangan opsi rsync:
# -a : Archive mode (preserve permissions, timestamps, etc)
# -v : Verbose (tampilkan detail)
# -h : Human-readable (ukuran file dalam MB/GB)
# --progress : Tampilkan progress bar

# Jika ada bad sectors, skip file yang error:
sudo rsync -avh --progress --ignore-errors /mnt/harddisk-rusak/ /mnt/harddisk-backup/DataRecovery/

# Copy dengan cp (alternatif):
sudo cp -Rv /mnt/harddisk-rusak/* /mnt/harddisk-backup/DataRecovery/</code></pre>

<h3>Langkah 7: Recovery File yang Terhapus dengan TestDisk &amp; PhotoRec</h3>

<pre><code># Install testdisk dan photorec
sudo apt install testdisk -y

# === TESTDISK (untuk partisi hilang/terhapus) ===
sudo testdisk
# Ikuti wizard:
# 1. Create → pilih disk → Enter
# 2. Pilih partition table type (biasanya Intel untuk PC)
# 3. Analyse → Quick Search
# 4. Jika partisi ditemukan: Write → Yes
# 5. Quit

# === PHOTOREC (untuk file yang terhapus) ===
sudo photorec
# Ikuti wizard:
# 1. Pilih disk (misal /dev/sdb)
# 2. Pilih partition (atau whole disk)
# 3. Pilih filesystem type (ext2/ext3/FAT/NTFS/Other)
# 4. Pilih lokasi output (misal /mnt/harddisk-backup/PhotorecRecovery/)
# 5. Tekan C untuk mulai

# PhotoRec akan recovery:
# - Foto (jpg, png, raw, dll)
# - Video (mp4, avi, mov, dll)
# - Dokumen (doc, pdf, xls, dll)
# - Archive (zip, rar, 7z, dll)
# - Dan ratusan format file lainnya</code></pre>

<h3>Langkah 8: Repair Filesystem (Jika Corrupt)</h3>

<p><strong>⚠️ PENTING:</strong> Hanya lakukan repair filesystem jika data sudah di-backup terlebih dahulu!</p>

<pre><code># === Untuk filesystem ext4 (Linux) ===
# Unmount dulu
sudo umount /mnt/harddisk-rusak

# Check dan repair
sudo e2fsck -f -y -v /dev/sdb1
# Opsi: -f (force), -y (auto yes), -v (verbose), -c (check bad blocks)

# === Untuk filesystem NTFS (Windows) ===
sudo apt install ntfs-3g -y
sudo ntfsfix /dev/sdb1
sudo ntfsfix -b -d /dev/sdb1
# Opsi: -b (clear bad cluster list), -d (clear dirty flag)

# === Untuk filesystem FAT32 ===
sudo fsck.vfat -a /dev/sdb1
# Opsi: -a (automatic repair), -v (verbose), -r (interactive repair)</code></pre>

<h2>🛠️ Tools Recovery Lanjutan</h2>

<h3>1. Foremost - File Carving Tool</h3>
<pre><code># Install
sudo apt install foremost -y

# Recovery berdasarkan file signature
sudo foremost -t all -i /dev/sdb1 -o /mnt/harddisk-backup/ForemostRecovery/

# Recovery file tertentu saja:
sudo foremost -t jpg,png,pdf,doc -i /dev/sdb1 -o /mnt/harddisk-backup/ForemostRecovery/

# Opsi: -t (tipe file), -i (input), -o (output), -v (verbose)</code></pre>

<h3>2. Scalpel - Advanced File Carving</h3>
<pre><code># Install
sudo apt install scalpel -y

# Edit konfigurasi untuk enable file types yang diinginkan
sudo nano /etc/scalpel/scalpel.conf

# Uncomment (hapus #) pada tipe file yang ingin di-recovery
# Jalankan recovery
sudo scalpel /dev/sdb1 -o /mnt/harddisk-backup/ScalpelRecovery/</code></pre>

<h3>3. Extundelete - Untuk ext3/ext4</h3>
<pre><code># Install
sudo apt install extundelete -y

# Unmount dulu
sudo umount /dev/sdb1

# Lihat file yang bisa di-recover
sudo extundelete /dev/sdb1 --ls

# Recovery semua file yang terhapus
sudo extundelete /dev/sdb1 --restore-all

# Recovery file tertentu
sudo extundelete /dev/sdb1 --restore-file /path/to/deleted/file.txt

# Hasil akan ada di folder RECOVERED_FILES/</code></pre>

<h3>4. Clone Disk dengan dd</h3>
<pre><code># HATI-HATI: Pastikan input/output benar!
# Format: dd if=input of=output

# Clone seluruh harddisk
sudo dd if=/dev/sdb of=/mnt/harddisk-backup/disk-clone.img bs=4M status=progress

# Clone dengan ukuran block optimal
sudo dd if=/dev/sdb of=/mnt/harddisk-backup/disk-clone.img bs=64K conv=noerror,sync status=progress

# Opsi:
# bs : Block size (lebih besar = lebih cepat)
# conv=noerror : Lanjut meski ada error
# conv=sync : Sync setiap write
# status=progress : Tampilkan progress</code></pre>

<p><strong>⚠️ PENTING:</strong> <code>dd</code> tidak akan skip bad sectors! Gunakan <code>ddrescue</code> untuk harddisk dengan bad sectors.</p>

<h2>🔍 Tips dan Troubleshooting</h2>

<h3>Masalah Umum dan Solusi</h3>

<h4>1. Harddisk Tidak Terdeteksi</h4>
<pre><code># Cek apakah disk terdeteksi di level hardware
dmesg | grep sd

# Cek USB/SATA connection
lsusb  # untuk USB
lsscsi # untuk SATA

# Reset USB ports
sudo modprobe -r usb_storage && sudo modprobe usb_storage

# Force scan SCSI bus
echo "- - -" | sudo tee /sys/class/scsi_host/host*/scan</code></pre>

<h4>2. Permission Denied</h4>
<pre><code># Jalankan dengan sudo
sudo [command]

# Atau ganti ownership
sudo chown -R $USER:$USER /mnt/harddisk-backup

# Ganti permissions
sudo chmod -R 755 /mnt/harddisk-backup</code></pre>

<h4>3. Input/Output Error</h4>
<pre><code># Disk mungkin dying, segera backup!
# Gunakan ddrescue dengan opsi aggressive:
sudo ddrescue -d -r3 -n /dev/sdb /mnt/harddisk-backup/disk-image.img /mnt/harddisk-backup/rescue.log

# Mount image hasil ddrescue:
sudo mkdir /mnt/image
sudo mount -o loop,ro /mnt/harddisk-backup/disk-image.img /mnt/image</code></pre>

<h4>4. Read-Only Filesystem</h4>
<pre><code># Remount dengan read-write
sudo mount -o remount,rw /mnt/harddisk-rusak

# Jika gagal, coba mount ulang:
sudo umount /mnt/harddisk-rusak
sudo mount -t ntfs-3g -o rw,remove_hiberfile /dev/sdb1 /mnt/harddisk-rusak</code></pre>

<h3>Estimasi Waktu Recovery</h3>

<table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse: collapse; margin-bottom: 20px;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>Kapasitas HDD</th>
            <th>DDRescue (Normal)</th>
            <th>DDRescue (Banyak Error)</th>
            <th>PhotoRec</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>250 GB</td>
            <td>2-4 jam</td>
            <td>8-24 jam</td>
            <td>4-8 jam</td>
        </tr>
        <tr>
            <td>500 GB</td>
            <td>4-8 jam</td>
            <td>16-48 jam</td>
            <td>8-16 jam</td>
        </tr>
        <tr>
            <td>1 TB</td>
            <td>8-16 jam</td>
            <td>24-72 jam</td>
            <td>16-32 jam</td>
        </tr>
        <tr>
            <td>2 TB</td>
            <td>16-32 jam</td>
            <td>48-120 jam</td>
            <td>32-64 jam</td>
        </tr>
    </tbody>
</table>
<p><em>*Waktu tergantung kondisi harddisk dan kecepatan USB/SATA</em></p>

<h3>Syntax Cheat Sheet Ubuntu</h3>
<pre><code># === DISK INFO ===
sudo fdisk -l                    # List semua disk
lsblk                           # Tree view disk & partisi
sudo blkid                      # UUID dan filesystem type
df -h                           # Disk space usage
sudo smartctl -a /dev/sdb       # SMART status

# === MOUNT/UNMOUNT ===
sudo mount /dev/sdb1 /mnt/disk  # Mount disk
sudo umount /mnt/disk           # Unmount disk
sudo umount -l /mnt/disk        # Lazy unmount (force)

# === FILE OPERATIONS ===
cp -Rv source/ dest/            # Copy recursive verbose
rsync -avh --progress src/ dst/ # Sync with progress
find /path -name "*.jpg"        # Find files

# === PERMISSIONS ===
sudo chown user:user file       # Change owner
sudo chmod 755 file             # Change permissions
sudo chmod -R 755 folder/       # Recursive

# === RECOVERY TOOLS ===
sudo ddrescue /dev/sdb img.img rescue.log   # Rescue disk
sudo testdisk                               # Partition recovery
sudo photorec                               # File recovery
sudo e2fsck -f /dev/sdb1                   # Check ext4
sudo ntfsfix /dev/sdb1                     # Fix NTFS</code></pre>

<h2>🎯 Kesimpulan</h2>

<h3>Ringkasan Metode:</h3>
<ol>
    <li><strong>USB SATA Adapter</strong> → Paling mudah, cocok untuk pemula</li>
    <li><strong>Direct SATA Connection</strong> → Lebih stabil, cocok untuk harddisk berat</li>
    <li><strong>Ubuntu Live + DDrescue</strong> → Paling powerful, cocok untuk kasus sulit</li>
</ol>

<h3>Urutan yang Disarankan:</h3>
<ol>
    <li>Coba metode 1 (USB SATA) → jika berhasil, <strong>SELESAI</strong></li>
    <li>↓ (gagal) → Coba metode 2 (Direct SATA) → jika berhasil, <strong>SELESAI</strong></li>
    <li>↓ (gagal) → Gunakan metode 3 (Ubuntu + DDrescue)</li>
    <li>↓ → Jika masih gagal → Gunakan PhotoRec/TestDisk</li>
    <li>↓ → Jika tetap gagal → Pertimbangkan jasa professional data recovery</li>
</ol>

<h3>Kapan Harus ke Professional:</h3>
<ul>
    <li>💰 Harddisk bunyi klik keras berulang (head crash)</li>
    <li>💰 Harddisk tidak berputar sama sekali</li>
    <li>💰 Harddisk jatuh/terendam air</li>
    <li>💰 Data sangat kritis (bisnis, legal, dll)</li>
    <li>💰 Budget ada untuk recovery professional</li>
</ul>

<h3>Software Windows Alternatif:</h3>
<p>Jika tidak bisa menggunakan Ubuntu:</p>
<ul>
    <li><strong>Recuva</strong> (Gratis) - untuk file terhapus</li>
    <li><strong>EaseUS Data Recovery</strong> (Free trial)</li>
    <li><strong>MiniTool Power Data Recovery</strong> (Free trial)</li>
    <li><strong>R-Studio</strong> (Berbayar, sangat powerful)</li>
    <li><strong>GetDataBack</strong> (Berbayar)</li>
</ul>

<p><strong>💡 Pesan Penting:</strong> Jika data sangat kritis, lakukan backup menggunakan <strong>lebih dari satu metode</strong>. Jangan mengandalkan satu backup saja! Good luck dengan recovery data Anda! 🚀</p>
',
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(50, 200),
        ]);

        $this->command->info('Harddisk Recovery Article created successfully!');
    }
}
