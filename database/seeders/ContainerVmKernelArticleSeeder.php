<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class ContainerVmKernelArticleSeeder extends Seeder
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

        // Create Container vs VM article
        Article::create([
            'title' => 'Kontainer Tidak Ada — Kernel Anda Berbohong kepada Anda',
            'slug' => 'kontainer-tidak-ada-kernel-anda-berbohong-kepada-anda',
            'excerpt' => 'Selama bertahun-tahun kita menjalankan "kontainer" — tapi tahukah kamu bahwa sistem operasi tidak mengenal benda bernama kontainer? Yang ada hanyalah sekelompok fitur kernel Linux yang bekerja bersama untuk menciptakan ilusi isolasi.',
            'content' => '
<h2>1. Kebohongan yang Nyaman</h2>

<p>Jalankan perintah ini di terminal Linux kamu:</p>

<pre><code>docker run -it ubuntu bash</code></pre>

<p>Dalam hitungan detik, kamu berada di dalam sebuah "Ubuntu". Kamu bisa menjalankan <code>ls</code>, <code>ps</code>, bahkan menginstal paket. Semuanya terasa terisolasi. Terasa terpisah. Terasa seperti komputer lain.</p>

<p><strong>Tapi coba pikirkan ini:</strong></p>

<pre><code># Di dalam "kontainer Ubuntu"
cat /proc/version
# Linux version 5.15.0-91-generic (Ubuntu 22.04)

# Di host, di terminal lain
cat /proc/version
# Linux version 5.15.0-91-generic (Ubuntu 22.04)</code></pre>

<p>Versi kernel <strong>identik</strong>. Bukan kebetulan. Mereka memang kernel yang <strong>sama persis</strong>.</p>

<p>Sekarang coba ini:</p>

<pre><code># Di dalam kontainer
ls -la /proc/1/
# Kamu melihat proses PID 1 milik kontainer

# Di host
ls -la /proc/1/
# Kamu melihat init/systemd — proses pertama sistem</code></pre>

<p>Kedua <code>/proc</code> itu berbeda. Tapi filesystem <code>/proc</code> itu bukan dua benda terpisah. Kernel hanya <strong>menunjukkan tampilan yang berbeda</strong> kepada siapa yang bertanya.</p>

<p>Inilah inti dari seluruh artikel ini:</p>

<blockquote><p><strong>Kontainer bukan teknologi. Kontainer adalah narasi. Yang nyata adalah fitur-fitur kernel Linux yang sudah ada bertahun-tahun sebelum Docker lahir.</strong></p></blockquote>

<h2>2. Virtual Machine — Komputer di Dalam Komputer</h2>

<p>Sebelum membongkar kontainer, kita perlu memahami VM — karena kontainer sering dibandingkan dengannya, dan keduanya bekerja dengan cara yang <strong>fundamental berbeda</strong>.</p>

<h3>Apa Itu Virtual Machine?</h3>

<p>Virtual Machine (VM) adalah emulasi <strong>perangkat keras lengkap</strong> yang dijalankan di atas sistem operasi nyata. Di dalamnya berjalan sistem operasi yang sesungguhnya — dengan kernel sendiri, driver sendiri, dan manajemen memori sendiri.</p>

<pre><code>┌─────────────────────────────────────────┐
│           MESIN FISIK (HOST)            │
│                                         │
│  ┌──────────────────────────────────┐   │
│  │      HYPERVISOR (VMware/KVM)     │   │
│  └──────────────────────────────────┘   │
│         │              │                │
│  ┌──────┴──┐    ┌──────┴──┐            │
│  │  VM #1  │    │  VM #2  │            │
│  │         │    │         │            │
│  │ Kernel  │    │ Kernel  │            │
│  │  Linux  │    │ Windows │            │
│  │         │    │         │            │
│  │  App A  │    │  App B  │            │
│  └─────────┘    └─────────┘            │
└─────────────────────────────────────────┘</code></pre>

<h3>Dua Tipe Hypervisor</h3>

<p><strong>Type 1 — Bare Metal Hypervisor:</strong></p>
<p>Berjalan langsung di atas perangkat keras, tanpa OS host. Ini yang digunakan di data center serius.</p>

<pre><code>Hardware
   └── Hypervisor (VMware ESXi, Microsoft Hyper-V, Xen)
          ├── VM 1 (OS + App)
          ├── VM 2 (OS + App)
          └── VM 3 (OS + App)</code></pre>

<p><strong>Type 2 — Hosted Hypervisor:</strong></p>
<p>Berjalan di atas OS host seperti aplikasi biasa. Lebih mudah digunakan untuk keperluan developer.</p>

<pre><code>Hardware
   └── OS Host (Windows/macOS/Linux)
          └── Hypervisor (VirtualBox, VMware Workstation, QEMU)
                 ├── VM 1 (OS + App)
                 └── VM 2 (OS + App)</code></pre>

<h3>Apa yang Dilakukan Hypervisor?</h3>

<p>Hypervisor mengintersep <strong>setiap instruksi privileged</strong> yang dikeluarkan VM. Ketika kernel VM mencoba mengakses perangkat keras, hypervisor menangkap permintaan itu dan menerjemahkannya ke perangkat keras nyata.</p>

<p>Prosesor modern (Intel VT-x, AMD-V) memiliki dukungan hardware untuk ini, sehingga VM bisa berjalan hampir secepat native untuk sebagian besar operasi.</p>

<pre><code>Kernel VM: "Aku ingin tulis ke disk sektor 0x1A2B3C"
     ↓
Hypervisor: "Tidak langsung. Aku terjemahkan permintaan ini ke
             file virtual disk di disk fisik host."
     ↓
Disk Fisik: Data tersimpan di /var/lib/libvirt/images/vm1.qcow2</code></pre>

<h3>Karakteristik VM</h3>

<ul>
    <li><strong>Isolasi penuh</strong> — kernel terpisah, memori terpisah, perangkat keras virtual terpisah</li>
    <li><strong>Overhead signifikan</strong> — booting butuh detik hingga menit, memori overhead ratusan MB hingga beberapa GB</li>
    <li><strong>Keamanan sangat kuat</strong> — exploit dari dalam VM sangat sulit menembus hypervisor</li>
    <li><strong>Bisa menjalankan OS berbeda</strong> — Linux VM di atas Windows host, atau sebaliknya</li>
</ul>

<h2>3. Mengapa Kontainer Tidak Ada</h2>

<p>Buka source code kernel Linux. Cari file bernama <code>container.c</code>. Cari struct bernama <code>container_t</code>. Cari syscall bernama <code>create_container()</code>.</p>

<p><strong>Kamu tidak akan menemukannya.</strong></p>

<p>Yang akan kamu temukan adalah:</p>

<pre><code>kernel/nsproxy.c        — Namespace management
kernel/cgroup.c         — Control Groups
fs/overlayfs/           — OverlayFS
security/apparmor/      — AppArmor
security/seccomp.c      — Secure Computing Mode</code></pre>

<p>Inilah bahan-bahan sesungguhnya dari "kontainer". Docker, Podman, containerd, LXC — semua dari mereka hanyalah <strong>antarmuka yang nyaman</strong> di atas kombinasi fitur-fitur kernel ini.</p>

<p>Ketika kamu menjalankan <code>docker run ubuntu</code>, yang sesungguhnya terjadi adalah:</p>

<pre><code># Yang Docker lakukan di balik layar (sangat disederhanakan):

# 1. Buat namespace baru
unshare --pid --net --mount --uts --ipc

# 2. Setup cgroup untuk batasan resource
echo "104857600" &gt; /sys/fs/cgroup/memory/myapp/memory.limit_in_bytes

# 3. Setup filesystem dengan OverlayFS
mount -t overlay overlay \
  -o lowerdir=/var/lib/docker/overlay2/abc123/diff,\
     upperdir=/var/lib/docker/overlay2/abc123/work,\
     workdir=/var/lib/docker/overlay2/abc123/merged \
  /var/lib/docker/overlay2/abc123/merged

# 4. chroot ke root filesystem baru
chroot /var/lib/docker/overlay2/abc123/merged /bin/bash

# 5. Eksekusi proses
exec nginx</code></pre>

<h2>4. Namespaces — Seni Berbohong kepada Proses</h2>

<h3>Konsep Dasar</h3>

<p><strong>Namespace</strong> adalah fitur kernel Linux yang membungkus sumber daya sistem tertentu sehingga proses-proses di dalam namespace itu hanya melihat <strong>versi terisolasi</strong> dari sumber daya tersebut.</p>

<p>Analoginya adalah <strong>kacamata augmented reality</strong>. Kamu berada di ruangan yang sama dengan semua orang, tapi kacamatamu menampilkan versi dunia yang berbeda. Kamu pikir kamu sendirian — padahal kamu hanya melihat sebagian.</p>

<p>Linux memiliki <strong>7 jenis namespace</strong> (per kernel 5.x):</p>

<table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse: collapse; margin-bottom: 20px;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>Namespace</th>
            <th>Flag</th>
            <th>Yang Diisolasi</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>PID</td>
            <td><code>CLONE_NEWPID</code></td>
            <td>Nomor proses (PID)</td>
        </tr>
        <tr>
            <td>Network</td>
            <td><code>CLONE_NEWNET</code></td>
            <td>Interface jaringan, routing table, port</td>
        </tr>
        <tr>
            <td>Mount</td>
            <td><code>CLONE_NEWNS</code></td>
            <td>Filesystem mount points</td>
        </tr>
        <tr>
            <td>UTS</td>
            <td><code>CLONE_NEWUTS</code></td>
            <td>Hostname dan domain name</td>
        </tr>
        <tr>
            <td>IPC</td>
            <td><code>CLONE_NEWIPC</code></td>
            <td>Message queue, semaphore, shared memory</td>
        </tr>
        <tr>
            <td>User</td>
            <td><code>CLONE_NEWUSER</code></td>
            <td>User ID dan Group ID</td>
        </tr>
        <tr>
            <td>Cgroup</td>
            <td><code>CLONE_NEWCGROUP</code></td>
            <td>Tampilan cgroup root</td>
        </tr>
    </tbody>
</table>

<h3>PID Namespace — Sistem Penomoran Proses Paralel</h3>

<p>Ini yang paling mengejutkan. Di dalam kontainer, proses pertama selalu memiliki PID 1 — sama seperti init/systemd di host. Padahal di luar kontainer, proses tersebut bisa memiliki PID 7823.</p>

<pre><code>HOST:                          KONTAINER:

PID 1: systemd                 PID 1: nginx (= PID 7823 di host)
PID 2: kthreadd               PID 2: nginx worker (= PID 7824 di host)
...                            PID 3: bash (= PID 7830 di host)
PID 7823: nginx ← ─ ─ ─ ─ ─ ─ ─ ─ ─ ┘
PID 7824: nginx worker
...
PID 7830: bash</code></pre>

<p>Kernel menjaga dua tabel PID secara bersamaan. Proses nginx terdaftar di tabel global host dengan PID 7823, <strong>dan</strong> di tabel namespace kontainer dengan PID 1.</p>

<p>Kita bisa membuktikan ini:</p>

<pre><code># Di dalam kontainer
$ ps aux
USER       PID %CPU %MEM   COMMAND
root         1  0.0  0.1   nginx
nobody       2  0.0  0.1   nginx: worker
root         3  0.0  0.0   bash
root        10  0.0  0.0   ps

# Di host, di terminal berbeda
$ ps aux | grep nginx
root      7823  0.0  0.1   nginx
nobody    7824  0.0  0.1   nginx: worker

# Di host, kita bisa "melihat" proses kontainer dan mengirim sinyal
$ kill -9 7823   # Ini akan mematikan nginx di dalam kontainer!</code></pre>

<p>Kernel yang "jujur" ini berbahaya sekaligus powerful — seorang admin di host <strong>selalu bisa melihat dan mengontrol</strong> semua proses, termasuk yang ada di dalam kontainer.</p>

<h3>Network Namespace — Internet Palsu</h3>

<p>Setiap kontainer bisa memiliki <strong>network stack sendiri</strong>: interface sendiri, IP sendiri, routing table sendiri, bahkan tabel firewall (iptables) sendiri.</p>

<pre><code># Lihat network namespace yang ada
$ ip netns list
container_abc123
container_def456

# Masuk ke namespace network kontainer
$ nsenter --net=/var/run/docker/netns/abc123 ip addr
1: lo: &lt;LOOPBACK,UP,LOWER_UP&gt;
    inet 127.0.0.1/8
2: eth0@if15: &lt;BROADCAST,MULTICAST,UP,LOWER_UP&gt;
    inet 172.17.0.3/16

# Di host
$ ip addr
1: lo: &lt;LOOPBACK,UP,LOWER_UP&gt;
2: eth0: &lt;BROADCAST,MULTICAST,UP,LOWER_UP&gt;
    inet 192.168.1.100/24
3: docker0: &lt;BROADCAST,MULTICAST,UP,LOWER_UP&gt;
    inet 172.17.0.1/16        ← Bridge virtual untuk kontainer
15: veth3a2b1c@if2:           ← Ujung lain dari eth0 kontainer</code></pre>

<p>Docker membuat <strong>virtual ethernet pair</strong> (veth) — seperti kabel jaringan virtual. Satu ujung di dalam namespace kontainer (tampak sebagai <code>eth0</code>), satu ujung lagi di host. Semua traffic keluar masuk kontainer melewati kabel virtual ini, lalu di-NAT oleh iptables sebelum keluar ke jaringan nyata.</p>

<h3>Mount Namespace — Peta Filesystem yang Berbeda</h3>

<p>Mount namespace membuat setiap kontainer bisa memiliki <strong>tampilan filesystem yang berbeda</strong>. Kontainer bisa me-mount direktori berbeda, menyembunyikan direktori host, atau bahkan memiliki root filesystem yang sama sekali berbeda.</p>

<pre><code># Di host
$ ls /
bin boot dev etc home lib media mnt opt proc root run srv sys tmp usr var

# Di dalam kontainer ubuntu
$ ls /
bin dev etc home lib lib32 lib64 libx32 media mnt opt proc root run sbin srv sys tmp usr var

# Direktori /home di kontainer kosong — tidak ada file host
$ ls /home
(kosong)

# Padahal di host ada banyak user
$ ls /home
alice  bob  charlie  dave</code></pre>

<p>Kontainer melihat sistem file yang <strong>sama sekali berbeda</strong> — tapi kernel tetap satu. Trickery mount namespace membuat kernel menjaga dua pohon mount yang berbeda dan menunjukkan pohon yang tepat kepada proses yang tepat.</p>

<h3>UTS Namespace — Hostname Palsu</h3>

<p>UTS (Unix Timesharing System) namespace memungkinkan setiap kontainer memiliki <strong>hostname sendiri</strong>:</p>

<pre><code># Di host
$ hostname
prodserver-01.datacenter.com

# Di dalam kontainer
$ hostname
a3f2c1b9d8e7   ← Container ID sebagai hostname</code></pre>

<p>Secara teknis, ada dua "nama komputer" di mesin yang sama. Kernel hanya menunjukkan nama yang berbeda berdasarkan namespace mana yang bertanya.</p>

<h3>User Namespace — Identitas Ganda</h3>

<p>Ini yang paling powerful sekaligus kontroversial. User namespace memungkinkan proses di dalam kontainer <strong>berjalan sebagai root (UID 0) di dalam namespace</strong> — tapi dari perspektif host, proses itu sebenarnya berjalan sebagai pengguna biasa (misalnya UID 1000).</p>

<pre><code># Di dalam kontainer — terlihat sebagai root
$ id
uid=0(root) gid=0(root) groups=0(root)

$ whoami
root

# Di host, proses kontainer sebenarnya adalah user biasa
$ ps aux | grep nginx
alice    7823  0.0  0.1   nginx   ← UID alice, bukan root!</code></pre>

<p>Ini penting untuk keamanan: jika proses "root" di kontainer berhasil escape dari namespace, dia tidak otomatis jadi root di host.</p>

<h2>5. cgroups — Penjaga Sumber Daya</h2>

<p>Namespace menyelesaikan masalah <strong>visibilitas</strong> — apa yang bisa dilihat proses. Tapi ada masalah lain: <strong>konsumsi sumber daya</strong>.</p>

<p>Tanpa batasan, sebuah proses bisa mengkonsumsi seluruh CPU, RAM, disk I/O, dan bandwidth jaringan mesin. Inilah tugas <strong>Control Groups (cgroups)</strong>.</p>

<h3>Apa Itu cgroups?</h3>

<p>cgroups adalah mekanisme kernel untuk <strong>mengelompokkan proses</strong> dan <strong>membatasi serta memonitor</strong> penggunaan sumber daya mereka.</p>

<pre><code># Struktur cgroup di filesystem
$ ls /sys/fs/cgroup/
blkio  cpu  cpuacct  cpuset  devices  freezer
hugetlb  memory  net_cls  net_prio  perf_event  pids

# Lihat cgroup milik Docker
$ ls /sys/fs/cgroup/memory/docker/
a3f2c1b9d8e7f6...  ← Container ID
b1e9d4c2a8f3b5...</code></pre>

<h3>Membatasi Memori</h3>

<pre><code># Buat cgroup baru
$ mkdir /sys/fs/cgroup/memory/myapp

# Batasi memori maksimum 256MB
$ echo "268435456" &gt; /sys/fs/cgroup/memory/myapp/memory.limit_in_bytes

# Batasi swap
$ echo "0" &gt; /sys/fs/cgroup/memory/myapp/memory.swappiness

# Daftarkan proses ke cgroup ini
$ echo $$ &gt; /sys/fs/cgroup/memory/myapp/cgroup.procs

# Sekarang proses ini dan semua child-nya dibatasi 256MB</code></pre>

<p>Ketika proses mencoba mengalokasikan memori melebihi batas, kernel bisa memilih untuk:</p>
<ul>
    <li>Menjalankan OOM Killer (Out of Memory Killer) — membunuh proses yang paling boros</li>
    <li>Mengembalikan error <code>ENOMEM</code> kepada proses</li>
</ul>

<pre><code># Docker melakukan ini saat kamu gunakan --memory flag
$ docker run --memory=256m nginx

# Ekuivalen dengan membuat cgroup dan set limit
$ cat /sys/fs/cgroup/memory/docker/$(docker inspect --format \'{{.Id}}\' nginx)/memory.limit_in_bytes
268435456</code></pre>

<h3>Membatasi CPU</h3>

<pre><code># Batasi kontainer hanya bisa pakai 50% dari satu CPU core
$ echo "50000" &gt; /sys/fs/cgroup/cpu/myapp/cpu.cfs_quota_us
$ echo "100000" &gt; /sys/fs/cgroup/cpu/myapp/cpu.cfs_period_us

# Atau dengan Docker:
$ docker run --cpus=0.5 nginx</code></pre>

<p>Kernel menggunakan <strong>Completely Fair Scheduler (CFS)</strong> — setiap 100ms (period), proses hanya boleh berjalan maksimal 50ms (quota). Sisanya, proses dibekukan sementara.</p>

<h3>Membatasi I/O Disk</h3>

<pre><code># Batasi read/write ke 10MB/s untuk device /dev/sda (major:minor = 8:0)
$ echo "8:0 10485760" &gt; /sys/fs/cgroup/blkio/myapp/blkio.throttle.read_bps_device
$ echo "8:0 10485760" &gt; /sys/fs/cgroup/blkio/myapp/blkio.throttle.write_bps_device

# Docker:
$ docker run --device-read-bps /dev/sda:10mb nginx</code></pre>

<h3>cgroups v2 — Hierarki Terpadu</h3>

<p>cgroups versi 1 memiliki kekurangan — setiap sumber daya (CPU, memori, dll) memiliki hierarki sendiri yang terpisah. <strong>cgroups v2</strong> (diperkenalkan di kernel 4.5, default di kernel 5.x) menyatukan semua dalam satu hierarki:</p>

<pre><code># cgroups v1 (lama)
/sys/fs/cgroup/
├── cpu/
│   ├── docker/
│   │   └── abc123/
├── memory/
│   ├── docker/
│   │   └── abc123/    ← Terpisah, sulit disinkronisasi
└── blkio/
    ├── docker/
        └── abc123/

# cgroups v2 (baru)
/sys/fs/cgroup/
└── docker/
    └── abc123/         ← Semua resource dalam satu direktori
        ├── memory.max
        ├── cpu.max
        └── io.max      ← Jauh lebih bersih</code></pre>

<h2>6. Union Filesystem — Lapisan Demi Lapisan</h2>

<p>Sekarang kita tahu bagaimana isolasi proses dan resource bekerja. Tapi bagaimana dengan <strong>filesystem</strong>? Mengapa image Docker yang sama bisa digunakan oleh 100 kontainer secara bersamaan tanpa menduplikasi data?</p>

<p>Jawabannya adalah <strong>Union Filesystem</strong> — khususnya <strong>OverlayFS</strong> yang kini menjadi default Docker.</p>

<h3>Konsep Dasar: Copy-on-Write</h3>

<p>Bayangkan sebuah buku resep. Alih-alih memberikan fotokopi 100 halaman kepada 100 orang, kamu memberikan satu buku asli, lalu setiap orang mendapat <strong>selembar kertas transparan</strong> untuk menulis perubahan mereka. Ketika membaca, mereka melihat buku asli + catatan mereka. Buku aslinya tidak pernah berubah.</p>

<p>Inilah <strong>Copy-on-Write (CoW)</strong>:</p>
<ul>
    <li>Data asli (image) hanya ada <strong>satu salinan</strong> di disk</li>
    <li>Setiap kontainer mendapat <strong>layer tipis</strong> untuk menyimpan perubahan</li>
    <li>Membaca = baca dari layer atas, jika tidak ada → baca dari layer bawah</li>
    <li>Menulis = salin blok yang dimodifikasi ke layer atas, lalu ubah</li>
</ul>

<h3>Cara Kerja OverlayFS</h3>

<p>OverlayFS menggabungkan dua direktori: <code>lowerdir</code> (read-only, image) dan <code>upperdir</code> (read-write, data kontainer), lalu menyajikannya sebagai satu filesystem melalui <code>merged</code>.</p>

<pre><code>┌─────────────────────────────────────────┐
│          MERGED (yang dilihat kontainer) │
│  /etc/nginx.conf (dari upper — diubah)  │
│  /usr/bin/nginx  (dari lower — asli)    │
│  /var/log/nginx/ (dari upper — baru)    │
└─────────────────────────────────────────┘
              ↑ overlay
┌──────────────────┐  ┌─────────────────────┐
│   UPPER (rw)     │  │    LOWER (ro)        │
│                  │  │                      │
│ /etc/nginx.conf  │  │  /etc/nginx.conf     │
│ (hasil modifikasi│  │  (asli dari image)   │
│ /var/log/nginx/  │  │  /usr/bin/nginx      │
│ access.log       │  │  /usr/lib/...        │
│ error.log        │  │  (semua file image)  │
└──────────────────┘  └─────────────────────┘</code></pre>

<h3>Struktur Layer Docker</h3>

<p>Docker image terdiri dari <strong>layer-layer</strong> yang ditumpuk:</p>

<pre><code># Dockerfile sederhana:
FROM ubuntu:22.04          # Layer 1: Ubuntu base
RUN apt-get update         # Layer 2: Package list
RUN apt-get install nginx  # Layer 3: Nginx files
COPY app.conf /etc/nginx/  # Layer 4: Konfigurasi kita
CMD ["nginx", "-g", "daemon off;"]

# Melihat layers sebuah image
$ docker history nginx:latest
IMAGE          CREATED      CREATED BY                SIZE
a3f2c1b9d8e7   2 weeks ago  CMD ["nginx" "-g" "da…]  0B
&lt;missing&gt;      2 weeks ago  COPY app.conf /etc/ni…]  1.2kB
&lt;missing&gt;      2 weeks ago  RUN apt-get install n…]  56.2MB
&lt;missing&gt;      2 weeks ago  RUN apt-get update         28.1MB
&lt;missing&gt;      2 weeks ago  Ubuntu 22.04 base          77.8MB</code></pre>

<p><strong>Satu layer bisa dibagi oleh banyak image dan banyak kontainer:</strong></p>

<pre><code>ubuntu:22.04 layer (77.8MB) ← dipakai oleh:
├── nginx image
├── apache image
├── nodejs image
└── python image
... semua berbagi SATU salinan di disk!

Tanpa sharing:
4 image × 77.8MB = 311.2MB
Dengan sharing:
1 × 77.8MB + delta masing-masing = jauh lebih kecil</code></pre>

<h3>Melihat OverlayFS Secara Langsung</h3>

<pre><code># Lihat mount point kontainer yang sedang berjalan
$ docker inspect $(docker ps -q) | grep MergedDir
"MergedDir": "/var/lib/docker/overlay2/abc123/merged"

# Lihat detailnya
$ mount | grep overlay
overlay on /var/lib/docker/overlay2/abc123/merged type overlay
  (rw,
   lowerdir=/var/lib/docker/overlay2/layer4/diff:
           /var/lib/docker/overlay2/layer3/diff:
           /var/lib/docker/overlay2/layer2/diff:
           /var/lib/docker/overlay2/layer1/diff,
   upperdir=/var/lib/docker/overlay2/abc123/diff,
   workdir=/var/lib/docker/overlay2/abc123/work)</code></pre>

<p>Layer 1-4 adalah image — read-only, dibagi bersama. <code>abc123/diff</code> adalah layer writable milik kontainer ini saja. Ketika kontainer dihapus, hanya layer ini yang hilang.</p>

<h2>7. Bagaimana Docker Menyatukan Semuanya</h2>

<p>Sekarang kita bisa melihat gambaran lengkapnya. Ketika kamu menjalankan <code>docker run -p 8080:80 nginx</code>, inilah yang benar-benar terjadi:</p>

<h3>Alur Lengkap docker run</h3>

<pre><code>1. Docker CLI
   └── Kirim request ke Docker daemon via Unix socket
       /var/run/docker.sock

2. Docker Daemon (dockerd)
   └── Delegasikan ke containerd

3. containerd
   └── Instruksikan runc untuk membuat kontainer

4. runc (OCI runtime)
   └── Panggil kernel syscalls:

   a. FILESYSTEM (OverlayFS)
      ├── Mount lowerdir = image layers
      ├── Mount upperdir = container layer (kosong)
      └── Mount merged = tampilan akhir kontainer

   b. ISOLASI (Namespaces)
      ├── clone(CLONE_NEWPID)   → PID namespace baru
      ├── clone(CLONE_NEWNET)   → Network namespace baru
      ├── clone(CLONE_NEWNS)    → Mount namespace baru
      ├── clone(CLONE_NEWUTS)   → UTS namespace baru
      ├── clone(CLONE_NEWIPC)   → IPC namespace baru
      └── clone(CLONE_NEWUSER)  → User namespace baru (opsional)

   c. RESOURCE CONTROL (cgroups)
      ├── Buat direktori di /sys/fs/cgroup/
      ├── Set memory.limit_in_bytes
      ├── Set cpu.cfs_quota_us
      └── Daftarkan PID proses ke cgroup

   d. KEAMANAN TAMBAHAN
      ├── Terapkan seccomp profile (batasi syscalls)
      ├── Terapkan AppArmor/SELinux policy
      └── Drop capabilities (hapus hak kernel berbahaya)

   e. JARINGAN
      ├── Buat veth pair (virtual ethernet cable)
      ├── Satu ujung masuk ke network namespace kontainer
      ├── Ujung lain di-attach ke docker0 bridge
      └── Setup NAT via iptables untuk akses luar

   f. EKSEKUSI
      └── chroot ke merged filesystem
          └── exec nginx</code></pre>

<h3>Arsitektur Komponen Docker</h3>

<pre><code>┌──────────────────────────────────────────────────────┐
│                    docker CLI                        │
└────────────────────────┬─────────────────────────────┘
                         │ REST API via Unix socket
┌────────────────────────▼─────────────────────────────┐
│                   dockerd (Docker Daemon)             │
│           Image management, networking, volumes       │
└────────────────────────┬─────────────────────────────┘
                         │ gRPC
┌────────────────────────▼─────────────────────────────┐
│                    containerd                         │
│         Container lifecycle management               │
│         Image pulling, snapshot management           │
└────────────────────────┬─────────────────────────────┘
                         │ OCI Runtime Spec
┌────────────────────────▼─────────────────────────────┐
│                       runc                           │
│         Low-level container runtime                  │
│         Wraps Linux kernel primitives                │
└────────────────────────┬─────────────────────────────┘
                         │ syscalls
┌────────────────────────▼─────────────────────────────┐
│                  Linux Kernel                        │
│   Namespaces │ cgroups │ OverlayFS │ seccomp │ ...   │
└──────────────────────────────────────────────────────┘</code></pre>

<p>Docker adalah orkestrator yang mengkoordinasikan semua primitif kernel ini menjadi pengalaman yang kita kenal sebagai "kontainer".</p>

<h2>8. Perbedaan Fundamental: VM vs Kontainer</h2>

<p>Sekarang kita bisa melihat dengan jelas mengapa keduanya berbeda secara mendasar — bukan hanya soal kecepatan atau ukuran.</p>

<h3>Perbedaan Inti</h3>

<pre><code>VIRTUAL MACHINE:

Mesin Fisik
└── Hypervisor
    ├── VM 1
    │   ├── Kernel Linux (versi 5.15) — KERNEL TERPISAH
    │   ├── Proses systemd
    │   └── Aplikasi A
    └── VM 2
        ├── Kernel Windows NT — KERNEL BERBEDA
        ├── Proses services.exe
        └── Aplikasi B


KONTAINER:

Mesin Fisik
└── Kernel Linux (versi 5.15) — SATU KERNEL
    ├── Namespace Group A (terlihat sebagai "Kontainer 1")
    │   ├── Proses nginx (PID 1 di namespace, PID 7823 di host)
    │   └── Proses worker
    └── Namespace Group B (terlihat sebagai "Kontainer 2")
        ├── Proses node (PID 1 di namespace, PID 8102 di host)
        └── Proses worker</code></pre>

<h3>Tabel Perbandingan Mendalam</h3>

<table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse: collapse; margin-bottom: 20px;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>Aspek</th>
            <th>Virtual Machine</th>
            <th>Kontainer</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>Kernel</strong></td>
            <td>Masing-masing punya kernel sendiri</td>
            <td>Berbagi kernel host</td>
        </tr>
        <tr>
            <td><strong>Waktu start</strong></td>
            <td>30 detik – beberapa menit</td>
            <td>Milidetik – beberapa detik</td>
        </tr>
        <tr>
            <td><strong>Ukuran image</strong></td>
            <td>GB (OS lengkap)</td>
            <td>MB (hanya aplikasi + library)</td>
        </tr>
        <tr>
            <td><strong>Overhead RAM</strong></td>
            <td>Ratusan MB per VM (OS overhead)</td>
            <td>Sangat minimal</td>
        </tr>
        <tr>
            <td><strong>Isolasi</strong></td>
            <td>Penuh — beda kernel, beda hardware virtual</td>
            <td>Parsial — kernel sama, namespace berbeda</td>
        </tr>
        <tr>
            <td><strong>Keamanan</strong></td>
            <td>Sangat kuat (hypervisor barrier)</td>
            <td>Lebih lemah (berbagi kernel)</td>
        </tr>
        <tr>
            <td><strong>OS yang didukung</strong></td>
            <td>Bisa beda OS (Windows VM di Linux host)</td>
            <td><strong>Harus kernel yang sama</strong></td>
        </tr>
        <tr>
            <td><strong>Portabilitas</strong></td>
            <td>OVA/VMDK, lebih berat</td>
            <td>Docker image, sangat mudah dibawa</td>
        </tr>
        <tr>
            <td><strong>Cocok untuk</strong></td>
            <td>Isolasi kuat, multi-OS, legacy apps</td>
            <td>Microservices, CI/CD, scale cepat</td>
        </tr>
    </tbody>
</table>

<h3>Mengapa Kontainer Lebih Cepat?</h3>

<pre><code>Saat VM boot:
1. BIOS/UEFI virtual (ratusan ms)
2. Boot loader virtual
3. Kernel decompress &amp; init (beberapa detik)
4. systemd mulai semua services (beberapa detik)
5. Aplikasi akhirnya bisa jalan ✓

Saat kontainer "boot":
1. Kernel sudah berjalan (0ms tambahan)
2. Buat namespaces (&lt; 1ms)
3. Setup cgroups (&lt; 1ms)
4. Mount OverlayFS (beberapa ms)
5. exec() proses aplikasi ✓

Total: kontainer bisa jalan dalam 50-200ms</code></pre>

<h2>9. Implikasi Keamanan — Ketika Ilusi Retak</h2>

<p>Inilah bagian yang paling kritis dan sering dilewatkan.</p>

<h3>Ancaman #1: Container Escape</h3>

<p>Karena kontainer berbagi kernel dengan host, celah keamanan di kernel Linux <strong>bisa dieksploitasi dari dalam kontainer</strong> untuk melarikan diri ke host.</p>

<p><strong>Contoh nyata — Exploit CVE-2019-5736 (runc vulnerability):</strong></p>

<pre><code>Penyerang menjalankan proses di dalam kontainer
     ↓
Mengeksploitasi cara runc membaca /proc/self/exe
     ↓
Menimpa binary runc di host
     ↓
Kali berikutnya runc dieksekusi di host = kode penyerang berjalan
     ↓
Penyerang punya akses root di HOST</code></pre>

<p>Ini tidak mungkin terjadi di VM — kernel terpisah berarti exploit dari dalam VM tidak bisa langsung menyentuh host.</p>

<h3>Ancaman #2: Privileged Container</h3>

<pre><code># JANGAN PERNAH lakukan ini di produksi:
$ docker run --privileged ubuntu bash

# Kontainer "privileged" mendapat semua capabilities kernel
# Ekuivalen dengan tidak ada isolasi sama sekali!

# Di dalam privileged container, penyerang bisa:
$ mount /dev/sda1 /mnt  # Mount disk host!
$ nsenter --target 1 --mount --uts --ipc --net --pid  # Masuk ke namespace host!</code></pre>

<h3>Ancaman #3: Syscall Attack Surface</h3>

<p>Karena kernel bersama, semua syscall Linux tersedia dari dalam kontainer. Jika ada bug di penanganan syscall tertentu oleh kernel, proses di dalam kontainer bisa mengeksploitasinya.</p>

<p><strong>Solusi: seccomp profiles</strong></p>

<pre><code>// /etc/docker/seccomp-default.json (versi singkat)
{
  "defaultAction": "SCMP_ACT_ERRNO",
  "syscalls": [
    {
      "names": ["read", "write", "open", "close", "stat",
                "fstat", "lstat", "poll", "lseek", "mmap"],
      "action": "SCMP_ACT_ALLOW"
    }
    // Syscall berbahaya seperti kexec_load, reboot,
    // create_module — tidak ada di whitelist = diblokir
  ]
}</code></pre>

<h3>Ancaman #4: Serangan Lewat /proc dan /sys</h3>

<pre><code># Beberapa path berbahaya yang harus di-mount read-only atau di-mask:

/proc/sys/kernel/core_pattern  # Bisa digunakan untuk privilege escalation
/proc/sys/kernel/dmesg_restrict
/proc/sysrq-trigger            # Bisa crash kernel host!
/sys/firmware/                 # Akses firmware hardware
/sys/kernel/debug/</code></pre>

<p>Docker secara default sudah me-mask beberapa path ini, tapi konfigurasi yang salah bisa membukanya.</p>

<h3>Perbandingan Model Keamanan</h3>

<pre><code>VM Security Model:
Penyerang → exploit app → dapat root container → ??? → hypervisor barrier → BERHENTI
                                                         (sangat sulit ditembus)

Container Security Model:
Penyerang → exploit app → dapat root container → exploit kernel bug → dapat root HOST
                                                  (satu kernel = satu titik kegagalan)

Defense in Depth untuk Kontainer:
1. Jalankan sebagai non-root (USER directive di Dockerfile)
2. Read-only root filesystem (--read-only)
3. Drop all capabilities, tambahkan hanya yang perlu
4. Gunakan seccomp profile
5. Gunakan AppArmor/SELinux
6. Jangan gunakan --privileged
7. Scan image untuk vulnerability
8. Pertimbangkan gVisor atau Kata Containers untuk isolasi lebih kuat</code></pre>

<h3>Solusi: Sandbox yang Lebih Kuat</h3>

<p>Untuk workload yang butuh isolasi lebih kuat tapi tetap ingin kecepatan kontainer, ada solusi tengah:</p>

<p><strong>gVisor (Google):</strong> Mengimplementasikan kernel Linux dalam userspace — kontainer memanggil syscall ke "kernel palsu" ini, bukan langsung ke kernel host. Mengurangi attack surface secara dramatis.</p>

<p><strong>Kata Containers:</strong> Menjalankan kontainer di dalam VM yang sangat ringan (~1 detik boot). Dapat isolasi VM dengan overhead mendekati kontainer.</p>

<pre><code>gVisor Architecture:
App → syscall → Sentry (kernel di userspace) → host syscall minimal
                (attack surface dari 300+ syscall menjadi ~20)

Kata Containers Architecture:
App → syscall → Lightweight VM Kernel → KVM hypervisor → host
                (isolasi penuh, tapi start time ~1 detik)</code></pre>

<h2>10. Kapan Pakai VM, Kapan Pakai Kontainer?</h2>

<h3>Gunakan Virtual Machine jika:</h3>

<p><strong>Kebutuhan isolasi keras (regulated industries):</strong></p>
<ul>
    <li>Sistem keuangan dan perbankan yang memproses data kartu kredit</li>
    <li>Healthcare dengan data pasien (HIPAA compliance)</li>
    <li>Workload yang menjalankan kode pengguna yang tidak dipercaya</li>
</ul>

<p><strong>Kebutuhan multi-OS:</strong></p>
<ul>
    <li>Menjalankan Windows server di samping Linux server di infrastruktur yang sama</li>
    <li>Testing aplikasi di berbagai OS</li>
</ul>

<p><strong>Aplikasi legacy:</strong></p>
<ul>
    <li>Sistem lama yang membutuhkan konfigurasi OS spesifik</li>
    <li>Aplikasi yang harus mengontrol kernel parameters secara mendalam</li>
</ul>

<p><strong>Contoh arsitektur yang tepat:</strong></p>
<pre><code>Data Center
└── Bare Metal Server
    └── KVM Hypervisor
        ├── VM: Payment Processing (PCI-DSS isolated)
        ├── VM: Database Server (dedicated resources)
        └── VM: Windows License Server</code></pre>

<h3>Gunakan Kontainer jika:</h3>

<p><strong>Microservices dan cloud-native:</strong></p>
<ul>
    <li>Banyak service kecil yang perlu deploy dan scale independen</li>
    <li>CI/CD pipeline yang butuh environment konsisten</li>
    <li>Service mesh (Kubernetes, Istio)</li>
</ul>

<p><strong>Development dan testing:</strong></p>
<ul>
    <li>"Works on my machine" problem solved — semua developer pakai image yang sama</li>
    <li>Testing di berbagai versi library tanpa konflik</li>
</ul>

<p><strong>Efisiensi sumber daya:</strong></p>
<ul>
    <li>Menjalankan ratusan instance dengan overhead minimal</li>
    <li>Skalabilitas cepat (autoscaling dari 1 ke 100 instance dalam detik)</li>
</ul>

<p><strong>Contoh arsitektur yang tepat:</strong></p>
<pre><code>Kubernetes Cluster
├── Node 1
│   ├── Pod: api-service (2 containers)
│   ├── Pod: auth-service (1 container)
│   └── Pod: cache (1 container)
├── Node 2
│   ├── Pod: api-service (2 containers)  ← auto-scaled
│   └── Pod: worker (3 containers)
└── Node 3
    └── ...</code></pre>

<h3>Sering Digunakan Bersamaan</h3>

<p>Di dunia nyata, keduanya sering dipakai bersama:</p>

<pre><code>Cloud Provider (AWS/GCP/Azure)
└── Virtual Machine (EC2/GCE/Azure VM)
    └── Kubernetes di dalam VM
        └── Kontainer di dalam Kubernetes

Mengapa? VM memberikan isolasi antar tenant (pelanggan cloud berbeda),
sementara kontainer memberikan efisiensi dan kecepatan deploy.</code></pre>

<h2>11. Kesimpulan</h2>

<p>Mari tarik benang merah dari semua yang telah kita pelajari.</p>

<h3>Apa yang Benar-benar Terjadi</h3>

<p>Ketika kamu menjalankan kontainer, kamu <strong>tidak</strong> menjalankan sebuah "container" dalam pengertian teknis. Yang kamu lakukan adalah:</p>

<ol>
    <li>Meminta kernel Linux membuat <strong>namespace baru</strong> — sehingga proses melihat "dunia" yang terbatas</li>
    <li>Mendaftarkan proses ke <strong>cgroup</strong> — sehingga kernel membatasi sumber daya yang bisa dikonsumsi</li>
    <li>Menyajikan <strong>OverlayFS</strong> sebagai root filesystem — sehingga setiap "kontainer" punya filesystem sendiri tanpa duplikasi</li>
    <li>Menerapkan <strong>seccomp dan capabilities</strong> — untuk membatasi syscall yang bisa dipanggil</li>
</ol>

<p>"Kontainer" adalah abstraksi tingkat tinggi yang dibuat oleh Docker (dan runtime lainnya) di atas kombinasi fitur kernel ini.</p>

<h3>VM vs Kontainer — Bukan Kompetisi, Tapi Pilihan</h3>

<p>Keduanya menjawab masalah yang berbeda:</p>

<ul>
    <li><strong>VM</strong> memisahkan workload di level <strong>kernel dan hardware</strong> — isolasi terkuat</li>
    <li><strong>Kontainer</strong> memisahkan workload di level <strong>proses dan filesystem</strong> — efisiensi tertinggi</li>
</ul>

<p>Jangan memilih salah satu karena tren atau popularitas. Pilih berdasarkan kebutuhan:</p>

<pre><code>Butuh isolasi terkuat?                  → VM
Butuh deploy cepat &amp; skala dinamis?     → Kontainer
Butuh keduanya?                         → Kontainer di dalam VM
Butuh keamanan kontainer setara VM?     → gVisor / Kata Containers</code></pre>

<h3>Mengapa Memahami Ini Penting</h3>

<p>Sebagai developer atau sysadmin, memahami apa yang sesungguhnya terjadi di balik <code>docker run</code> membuatmu:</p>

<ul>
    <li><strong>Lebih aman</strong> — kamu tahu batasan isolasi kontainer dan bagaimana mengatasinya</li>
    <li><strong>Lebih efisien</strong> — kamu bisa optimasi resource berdasarkan pemahaman cgroups</li>
    <li><strong>Lebih mahir debugging</strong> — ketika sesuatu tidak berjalan, kamu tahu harus cari di mana</li>
    <li><strong>Lebih bijak dalam arsitektur</strong> — kamu bisa membuat keputusan desain yang tepat</li>
</ul>

<p>Kernel tidak benar-benar berbohong. Ia hanya <strong>menyajikan cerita yang berbeda kepada pendengar yang berbeda</strong>. Dan sekarang kamu tahu bagaimana cerita itu dibuat.</p>

<blockquote><p><em>"Any sufficiently advanced abstraction is indistinguishable from magic — until you look at the source code."</em></p>
<p>— Parafrase dari Arthur C. Clarke, untuk dunia infrastruktur modern</p></blockquote>

<h3>Referensi &amp; Topik Lanjutan</h3>

<p>Untuk mendalami lebih jauh, eksplorasi topik-topik ini:</p>

<ul>
    <li><strong>Linux Kernel Source</strong>: <code>kernel/nsproxy.c</code>, <code>kernel/cgroup.c</code>, <code>fs/overlayfs/</code></li>
    <li><strong>OCI (Open Container Initiative)</strong>: Spesifikasi standar untuk container runtime dan image</li>
    <li><strong>runc source code</strong>: Implementasi referensi OCI runtime yang benar-benar memanggil syscalls</li>
    <li><strong>Kubernetes internals</strong>: Bagaimana Pod menggunakan semua primitif ini dalam skala besar</li>
    <li><strong>eBPF</strong>: Teknologi baru untuk observability dan security di level kernel tanpa modifikasi kernel</li>
    <li><strong>Linux Capabilities</strong>: Daftar lengkap capability yang bisa diberikan/dicabut dari kontainer</li>
</ul>

<p><em>Artikel ini ditulis untuk developer, sysadmin, dan siapa pun yang ingin memahami apa yang sebenarnya terjadi di balik kata "kontainer".</em></p>
',
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(50, 200),
        ]);

        $this->command->info('Container vs VM Kernel Article created successfully!');
    }
}
