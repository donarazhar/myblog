<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class CapcutTricksArticleSeeder extends Seeder
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
            'title' => '21 Trik CapCut TERBAIK untuk Membawa Anda dari Pemula Menjadi Profesional!',
            'slug' => '21-trik-capcut-terbaik-pemula-menjadi-profesional',
            'excerpt' => 'Sudah lama edit video tapi hasilnya masih biasa-biasa saja? Artikel ini membeberkan 21 trik CapCut yang dipakai kreator konten jutaan followers — mulai dari teknik dasar yang sering terlewat hingga fitur tersembunyi yang mengubah video biasa menjadi karya sinematik memukau.',
            'content' => '
<h2>✦ TINGKAT PEMULA</h2>

<p><em>Trik 1-5 ini terdengar sederhana — tapi sebagian besar editor pemula melewatinya dan langsung loncat ke fitur yang lebih "keren". Jangan lakukan kesalahan yang sama.</em></p>

<h2>1. Pahami Timeline Sebelum Apapun</h2>

<p>Sebelum bicara efek, transisi, atau filter — editor yang baik harus <strong>menguasai timeline</strong>. Ini fondasi segalanya.</p>

<h3>Kenali Anatomi Timeline CapCut</h3>

<pre><code>┌──────────────────────────────────────────────┐
│  [Klip Video 1]──[Klip Video 2]──[Klip 3]    │ ← Track Utama
│  ════════════════[Musik]═════════════════     │ ← Track Audio
│           [Teks]──[Teks]                      │ ← Track Teks
│      [Stiker]                                 │ ← Track Overlay
└──────────────────────────────────────────────┘
       ↑ Playhead — posisi waktu saat ini</code></pre>

<h3>Trik yang Wajib Dikuasai</h3>

<p><strong>Pinch to Zoom Timeline:</strong> Cubit dua jari untuk memperbesar/memperkecil tampilan timeline. Sangat penting saat edit klip pendek yang butuh presisi milidetik — tanpa ini kamu akan terus salah potong.</p>

<p><strong>Tahan dan Geser Klip:</strong> Tekan agak lama pada klip, lalu seret untuk memindahkan posisinya di timeline. Lepaskan di antara dua klip lain dan CapCut akan otomatis menggeser klip yang lain.</p>

<p><strong>Hapus Gap Otomatis:</strong> Ketika ada ruang kosong (gap) di timeline, ketuk gap tersebut — akan muncul pilihan "Delete". CapCut otomatis menutup celah tanpa menggeser elemen di track lain.</p>

<p><strong>Magnetic Timeline:</strong> Aktifkan snap (biasanya ikon magnet di toolbar) agar klip otomatis "menempel" ke tepi klip tetangganya. Ini mencegah gap tidak sengaja yang sering bikin bingung pemula.</p>

<h3>Kesalahan Paling Umum di Timeline</h3>

<p>Banyak pemula mengedit dalam tampilan timeline yang terlalu kecil sehingga sulit melihat detail klip. Selalu <strong>perbesar timeline ketika melakukan cut presisi</strong> — pastikan kamu bisa melihat bingkai per bingkai.</p>

<h2>2. Magic Cut — Auto Edit yang Sering Diabaikan</h2>

<p>Kebanyakan orang tidak tahu CapCut punya fitur <strong>Magic Cut</strong> yang menganalisis video panjang secara otomatis dan membuang bagian yang membosankan.</p>

<h3>Cara Menggunakan Magic Cut</h3>

<p><strong>Langkah 1:</strong> Import video panjangmu (misalnya rekaman vlog 10 menit) ke CapCut.</p>

<p><strong>Langkah 2:</strong> Pilih klip di timeline, tap <strong>"Edit"</strong>, cari opsi <strong>"Smart"</strong> atau <strong>"Auto Cut"</strong> (tergantung versi CapCut).</p>

<p><strong>Langkah 3:</strong> CapCut menganalisis video dan otomatis menandai bagian yang perlu dipotong — biasanya jeda, keheningan, atau momen yang tidak bergerak.</p>

<p><strong>Langkah 4:</strong> Review hasilnya, setujui atau batalkan pemotongan individual yang tidak sesuai.</p>

<h3>Fitur "Remove Silence" yang Tersembunyi</h3>

<p>Ini trik emas untuk konten podcast atau talking-head:</p>

<p>Tap klip → <strong>"Edit"</strong> → <strong>"Auto Captions"</strong> → setelah caption muncul, ada opsi <strong>"Remove Silence"</strong>. CapCut akan memotong semua jeda diam di videomu secara otomatis. Hemat hingga 30-40% durasi tanpa mengorbankan konten.</p>

<h3>Pro Tip</h3>

<p>Setelah Magic Cut, jangan langsung puas. Cek kembali setiap potongan secara manual — AI tidak selalu paham konteks. Terkadang jeda singkat itu <strong>disengaja</strong> untuk efek dramatis dan tidak seharusnya dihapus.</p>

<h2>3. Keyframe untuk Animasi Manual</h2>

<p><strong>Keyframe</strong> adalah trik yang memisahkan editor amatir dari editor sungguhan. Dengan keyframe, kamu bisa menganimasikan <strong>hampir semua properti</strong> sebuah elemen dari satu nilai ke nilai lain sepanjang waktu.</p>

<h3>Konsep Dasar Keyframe</h3>

<p>Bayangkan kamu ingin teks yang awalnya transparan, lalu perlahan muncul, lalu bergerak ke kanan layar. Tanpa keyframe, kamu tidak bisa melakukan ini. Dengan keyframe:</p>

<pre><code>Keyframe 1 (detik 0):  Opacity = 0%, Posisi X = 0
Keyframe 2 (detik 1):  Opacity = 100%, Posisi X = 0
Keyframe 3 (detik 2):  Opacity = 100%, Posisi X = +200px

CapCut otomatis menginterpolasi (mengisi) nilai di antara keyframe ↑</code></pre>

<h3>Cara Menambahkan Keyframe</h3>

<p><strong>Langkah 1:</strong> Pilih elemen yang ingin dianimasikan (teks, gambar, video klip, stiker).</p>

<p><strong>Langkah 2:</strong> Geser playhead ke posisi waktu di mana animasi dimulai.</p>

<p><strong>Langkah 3:</strong> Tap ikon <strong>berlian (◆)</strong> di toolbar bawah untuk menambahkan keyframe pertama.</p>

<p><strong>Langkah 4:</strong> Geser playhead ke posisi waktu berikutnya.</p>

<p><strong>Langkah 5:</strong> Ubah properti elemen (geser posisi, ubah ukuran, ubah opacity, putar).</p>

<p><strong>Langkah 6:</strong> Keyframe kedua otomatis ditambahkan. CapCut mengisi animasinya sendiri.</p>

<h3>5 Animasi Populer dengan Keyframe</h3>

<p><strong>Zoom Dramatis:</strong> Keyframe 1 = skala 100%, Keyframe 2 (0.5 detik kemudian) = skala 130%. Gunakan untuk momen "reveal" yang dramatis.</p>

<p><strong>Teks Melayang:</strong> Atur posisi Y berbeda di dua keyframe untuk efek teks yang naik atau turun.</p>

<p><strong>Fade Out Manual:</strong> Atur opacity dari 100% di keyframe 1 menjadi 0% di keyframe 2 — lebih presisi dari fade bawaan CapCut.</p>

<p><strong>Parallax Effect:</strong> Gerakkan background lebih lambat dari foreground menggunakan keyframe yang berbeda pada dua layer berbeda.</p>

<p><strong>Ken Burns Effect (Zoom Foto):</strong> Sangat efektif untuk slideshow foto — mulai dari wide shot, akhiri dengan close-up menggunakan keyframe skala dan posisi.</p>

<h2>4. Teknik Split yang Benar</h2>

<p>Split (memotong klip) terdengar sepele. Tapi cara kamu melakukan split <strong>menentukan ritme dan energi seluruh video</strong>.</p>

<h3>Tiga Metode Split</h3>

<p><strong>Metode 1 — Split Manual:</strong> Geser playhead ke titik yang ingin dipotong → tap <strong>"Split"</strong> di toolbar. Klip terbagi dua tepat di posisi playhead.</p>

<p><strong>Metode 2 — Split dengan Presisi:</strong> Perbesar timeline sebesar mungkin (pinch out), lalu gunakan tombol <code>&lt;</code> dan <code>&gt;</code> (frame by frame) untuk memposisikan playhead tepat di bingkai yang kamu inginkan sebelum tap Split.</p>

<p><strong>Metode 3 — Split dan Hapus (Trim):</strong> Untuk membuang bagian tengah klip: split di awal bagian yang mau dihapus → split lagi di akhir bagian tersebut → pilih segmen tengah → delete.</p>

<h3>Aturan Tidak Tertulis dalam Cutting</h3>

<p><strong>Cut on Action:</strong> Potong video di tengah gerakan, bukan sebelum atau sesudahnya. Misalnya, jika seseorang sedang berdiri — potong saat tubuh sudah setengah berdiri, bukan sebelum mulai berdiri. Transisi terasa jauh lebih halus.</p>

<p><strong>J-Cut dan L-Cut:</strong> Ini teknik editing sinema klasik yang bisa dilakukan di CapCut:</p>
<ul>
    <li><strong>J-Cut:</strong> Audio klip berikutnya masuk lebih dulu sebelum videonya muncul — mempersiapkan penonton secara auditory</li>
    <li><strong>L-Cut:</strong> Video klip berikutnya muncul tapi audio klip sebelumnya masih terdengar — menciptakan kontinuitas yang mulus</li>
</ul>

<p>Caranya di CapCut: setelah split, tap klip audio dan geser ujungnya secara independen dari klip video.</p>

<h2>5. Menggunakan Template Bukan Berarti Curang</h2>

<p>Ada stigma di kalangan kreator bahwa menggunakan template itu "curang" atau "tidak kreatif". Ini <strong>salah kaprah total</strong>.</p>

<h3>Cara Profesional Menggunakan Template</h3>

<p>Template adalah <strong>titik awal</strong>, bukan titik akhir. Editor profesional menggunakan template untuk:</p>

<p><strong>Mempercepat workflow:</strong> Animasi teks rumit yang butuh 2 jam untuk dibuat dari nol bisa diaplikasikan dalam 30 detik. Waktu yang tersisa digunakan untuk menyempurnakan konten.</p>

<p><strong>Belajar dari yang lebih baik:</strong> Setelah menggunakan template, <strong>buka dan pelajari</strong> cara animasinya dibuat. CapCut memungkinkan kamu melihat setiap layer dan keyframe dalam template. Ini cara terbaik belajar teknik baru.</p>

<p><strong>Konsistensi brand:</strong> Buat template kustom sendiri — atur font, warna, animasi — lalu simpan untuk digunakan di semua konten. Ini yang dilakukan brand besar untuk menjaga konsistensi visual.</p>

<h3>Memodifikasi Template agar Unik</h3>

<p>Jangan gunakan template 100% apa adanya. Selalu ubah minimal:</p>

<p>Ganti font ke brand font kamu. Ubah palet warna ke warna brand. Sesuaikan timing animasi (kadang template default terlalu cepat atau lambat). Ganti musik dengan musik yang lebih sesuai konten. Hasil akhirnya akan terasa milikmu, bukan template generik.</p>

<h2>✦ TINGKAT MENENGAH</h2>

<p><em>Di sini kita mulai memasuki wilayah yang sebagian besar kreator tidak pernah eksplorasi. Fitur-fitur ini ada di CapCut, gratis, tapi jarang digunakan secara optimal.</em></p>

<h2>6. Transisi yang Tidak Terlihat Seperti Transisi</h2>

<p>Transisi standar CapCut (dissolve, swipe, zoom) itu bagus — tapi kalau dipakai berlebihan, video terlihat amatir. Rahasianya: <strong>transisi terbaik adalah yang tidak kamu sadari</strong>.</p>

<h3>Transisi "Match Cut" — Favorit Sinematrografer</h3>

<p><strong>Match Cut</strong> menghubungkan dua klip yang berbeda tapi memiliki <strong>kesamaan visual</strong> — bentuk, warna, gerakan, atau komposisi serupa.</p>

<p>Contoh populer:</p>
<ul>
    <li>Klip 1: Close-up mata orang menutup — Klip 2: Close-up matahari terbenam (bentuk bulat serupa)</li>
    <li>Klip 1: Tangan melempar bola ke atas — Klip 2: Bola melambung di lapangan berbeda</li>
    <li>Klip 1: Pintu kamar tertutup — Klip 2: Pintu kantor terbuka</li>
</ul>

<p>Cara melakukannya di CapCut: edit kedua klip sehingga frame terakhir klip 1 dan frame pertama klip 2 memiliki kesamaan visual → pilih titik transisi → pilih transisi <strong>"Cut"</strong> (tidak ada transisi sama sekali). Hasilnya akan terasa seperti magic.</p>

<h3>Transisi dengan Gerakan Kamera</h3>

<p>Ini trik yang digunakan konten travel dan lifestyle. Akhiri klip 1 dengan gerakan kamera ke satu arah (misalnya pan kanan), mulai klip 2 dengan gerakan kamera dari arah yang sama. Pasang di CapCut dengan transisi minimal untuk kesan "mengalir".</p>

<h3>Tips Penggunaan Transisi Bawaan CapCut</h3>

<p>Kurang benar-benar lebih. Batasi diri hanya 1-2 jenis transisi per video. Durasi transisi yang baik adalah 0.3-0.5 detik — lebih panjang dari itu mulai terlihat berlebihan. Simpan transisi "wow" (zoom, spin) hanya untuk momen puncak video, bukan setiap pergantian klip.</p>

<h2>7. Chroma Key — Green Screen Tanpa Green Screen Mahal</h2>

<p><strong>Chroma Key</strong> (atau disebut Green Screen) memungkinkan kamu menghapus warna tertentu dari video dan menggantinya dengan background lain. Yang mengejutkan: kamu <strong>tidak butuh layar hijau mahal</strong> untuk ini.</p>

<h3>Cara Kerja Chroma Key di CapCut</h3>

<p><strong>Langkah 1:</strong> Import video yang ingin digunakan sebagai "talent" (subjek utama). Letakkan sebagai overlay di atas video background.</p>

<p><strong>Langkah 2:</strong> Tap klip overlay → tap <strong>"Chroma Key"</strong> di menu.</p>

<p><strong>Langkah 3:</strong> Gunakan pipet (color picker) untuk mengetuk warna yang ingin dihapus.</p>

<p><strong>Langkah 4:</strong> Sesuaikan <strong>"Intensity"</strong> — semakin tinggi, semakin banyak warna yang dihapus (tapi hati-hati, terlalu tinggi akan menghapus warna dari subjeknya juga).</p>

<p><strong>Langkah 5:</strong> Sesuaikan <strong>"Shadow"</strong> untuk mengurangi sisa warna di tepi subjek.</p>

<h3>Trik: Tanpa Green Screen Fisik</h3>

<p>Kamu bisa merekam di depan <strong>dinding polos berwarna solid</strong> — dinding putih, biru, bahkan merah — asal warna tersebut <strong>tidak ada di pakaian atau kulit</strong> subjek. Pencahayaan yang merata di dinding penting untuk hasil maksimal.</p>

<p><strong>Alternatif gratis:</strong> CapCut memiliki fitur <strong>"Remove BG"</strong> berbasis AI yang menghapus background secara otomatis tanpa perlu warna solid sama sekali. Tap klip → <strong>"Remove BG"</strong> → pilih <strong>"Auto Removal"</strong>. Hasilnya mengejutkan bagus untuk subjek manusia.</p>

<h3>Penggunaan Kreatif Chroma Key</h3>

<p>Tempatkan dirimu di dalam video game. Buat efek portal atau teleportasi. Ganti background dengan footage kota atau alam eksotis untuk konten travel tanpa harus pergi. Buat thumbnail video yang berdampak dengan background kustom.</p>

<h2>8. Masking untuk Efek Sinematik</h2>

<p><strong>Masking</strong> adalah teknik menyembunyikan sebagian area klip sehingga layer di bawahnya terlihat. Ini membuka dunia kemungkinan efek visual yang terlihat sangat profesional.</p>

<h3>Jenis Mask di CapCut</h3>

<p>CapCut menyediakan beberapa bentuk mask dasar: Linear (garis lurus), Mirror, Circle, Rectangle, Heart, Star, dan Custom (buatan sendiri dengan titik-titik yang bisa diatur).</p>

<h3>Efek Split Screen Vertikal</h3>

<p>Ini salah satu trik masking paling populer untuk konten "before/after" atau "duet":</p>

<p><strong>Langkah 1:</strong> Letakkan Video A sebagai track utama, Video B sebagai overlay.</p>

<p><strong>Langkah 2:</strong> Tap Video B (overlay) → <strong>"Mask"</strong> → pilih <strong>Linear</strong>.</p>

<p><strong>Langkah 3:</strong> Posisikan garis mask tepat di tengah layar. Sekarang setengah kiri menampilkan Video A, setengah kanan menampilkan Video B.</p>

<p><strong>Langkah 4:</strong> Tambahkan keyframe pada garis mask untuk membuatnya bergeser dari sisi ke sisi — efek "wipe reveal" yang dramatis.</p>

<h3>Efek "Invisible Transition" dengan Mask</h3>

<p>Ini trik yang membuat penonton bingung bagaimana kamu melakukannya:</p>

<p>Rekam dua klip — satu dengan kamera bergerak melewati objek yang sangat dekat (tiang, pintu, bahu orang). Di titik objek memenuhi frame, potong. Klip kedua dimulai dengan objek yang sama memenuhi frame, lalu kamera menjauh. Hubungkan dengan mask berbentuk sesuai objek tersebut. Hasilnya: transisi yang terlihat seperti kamu "menembus" objek.</p>

<h2>9. Auto Caption yang Layak Pakai</h2>

<p>Caption adalah <strong>faktor nomor satu</strong> yang meningkatkan dwell time (berapa lama orang menonton video). Di Instagram, TikTok, dan YouTube Shorts, 85% video ditonton <strong>tanpa suara</strong>. Tanpa caption, kamu kehilangan 85% penonton potensial.</p>

<h3>Mengaktifkan Auto Caption</h3>

<p><strong>Langkah 1:</strong> Setelah selesai edit dasar, tap <strong>"Text"</strong> di menu bawah.</p>

<p><strong>Langkah 2:</strong> Pilih <strong>"Auto Captions"</strong>.</p>

<p><strong>Langkah 3:</strong> Pilih bahasa audio videomu (pilih Bahasa Indonesia jika narasi dalam Bahasa Indonesia).</p>

<p><strong>Langkah 4:</strong> Tunggu CapCut memproses — biasanya 1-3 menit untuk video 1 menit.</p>

<p><strong>Langkah 5:</strong> Review dan koreksi kata-kata yang salah dikenali.</p>

<h3>Membuat Caption Terlihat Profesional</h3>

<p>Caption default CapCut sering terlihat generik. Berikut cara meningkatkannya:</p>

<p><strong>Pilih font yang tepat:</strong> Untuk konten energetik (gaming, olahraga), pilih font bold dan tebal. Untuk konten lifestyle, font sans-serif yang bersih lebih cocok. Hindari font yang sulit dibaca di layar kecil.</p>

<p><strong>Gunakan stroke (outline):</strong> Tambahkan outline hitam pada teks putih, atau sebaliknya. Ini memastikan teks terbaca di depan background berwarna apapun.</p>

<p><strong>Highlight kata kunci:</strong> CapCut memungkinkan kata tertentu di-highlight dengan warna berbeda. Gunakan ini untuk menekankan poin penting dalam narasi.</p>

<p><strong>Animasikan kemunculan:</strong> Pilih animasi "Pop" atau "Bounce" untuk caption agar tidak terasa statis. Tapi jaga konsistensi — gunakan animasi yang sama di seluruh video.</p>

<p><strong>Posisi caption:</strong> Jangan tempatkan di bawah layar seperti subtitle film — di platform vertikal (TikTok, Reels), caption di tengah layar mendapat engagement lebih tinggi.</p>

<h2>10. Curve Audio untuk Suara Profesional</h2>

<p>Banyak kreator menghabiskan 90% waktunya di visual dan mengabaikan audio. Padahal <strong>audio yang buruk lebih mengganggu daripada visual yang buruk</strong> — penonton akan memaafkan video buram, tapi tidak akan memaafkan suara yang buruk.</p>

<h3>Masalah Audio yang Paling Umum</h3>

<p>Volume klip yang tidak konsisten (satu klip keras, yang lain pelan). Transisi audio yang tiba-tiba (bukan fade in/out). Musik yang terlalu keras menutupi vokal. Background noise yang mengganggu.</p>

<h3>Curve Audio — Fade yang Presisi</h3>

<p>Alih-alih menggunakan volume flat, gunakan <strong>curve</strong> untuk mendapatkan volume yang berubah secara halus dan alami.</p>

<p><strong>Cara menggunakan Curve Audio:</strong></p>

<p>Tap klip audio di timeline → tap <strong>"Volume"</strong> → aktifkan <strong>"Keyframe Volume"</strong>. Sekarang kamu bisa menambahkan titik-titik di kurva volume dan menyeretnya naik/turun.</p>

<p>Contoh penggunaan:</p>

<pre><code>Musik intro:
Detik 0-2:   Volume naik dari 0% ke 80% (fade in halus)
Detik 2-10:  Volume stabil di 80%
Detik 10-12: Volume turun dari 80% ke 30% (ducking saat vokal masuk)
Detik 12-25: Volume stabil di 30% (di bawah vokal)
Detik 25-27: Volume naik kembali ke 80% (vokal selesai)</code></pre>

<h3>Ducking Otomatis</h3>

<p>CapCut versi terbaru memiliki fitur <strong>"Smart Volume"</strong> atau <strong>"Auto Ducking"</strong> yang otomatis menurunkan volume musik saat ada vokal/narasi. Cari di menu audio track → <strong>"Smart"</strong>. Ini menghemat waktu setup curve manual.</p>

<h2>11. Speed Ramping — Efek Slow-Fast yang Dramatis</h2>

<p><strong>Speed Ramping</strong> adalah teknik mengubah kecepatan video secara bertahap — bukan hanya slow motion statis. Ini yang membuat video aksi, olahraga, dan dance terlihat sangat sinematik.</p>

<h3>Cara Kerja Speed Ramping</h3>

<p>Bayangkan video seseorang melompat:</p>
<ul>
    <li>Berlari menuju titik lompat: kecepatan normal (1x)</li>
    <li>Tepat saat kaki meninggalkan tanah: mulai slow down</li>
    <li>Di puncak lompatan (di udara): sangat lambat (0.2x)</li>
    <li>Mendarat: kembali ke normal atau bahkan dipercepat</li>
</ul>

<h3>Membuat Speed Ramp di CapCut</h3>

<p><strong>Langkah 1:</strong> Pilih klip video yang ingin diramping.</p>

<p><strong>Langkah 2:</strong> Tap <strong>"Speed"</strong> → pilih <strong>"Curve"</strong> (bukan "Normal").</p>

<p><strong>Langkah 3:</strong> Pilih preset yang tersedia (CapCut menyediakan Montage, Hero, Bullet, Jump Cut, Flash In, Flash Out) atau buat sendiri dengan memilih <strong>"Custom"</strong>.</p>

<p><strong>Langkah 4:</strong> Tap titik-titik pada kurva untuk menambah titik baru. Seret ke atas = percepat, seret ke bawah = perlambat.</p>

<p><strong>Langkah 5:</strong> Cocokkan titik perubahan kecepatan dengan beat musik untuk hasil yang maksimal.</p>

<h3>Tips Agar Speed Ramp Terlihat Halus</h3>

<p>Rekam video dengan kecepatan <strong>60fps atau lebih</strong> — ketika diperlambat ke 0.3x, kamu masih mendapat 18fps yang terlihat mulus. Video 30fps diperlambat 0.3x hanya menghasilkan 9fps — terlihat patah-patah.</p>

<p>Tambahkan sedikit <strong>motion blur</strong> pada CapCut saat bagian slow motion untuk kesan sinematik tambahan.</p>

<h2>12. Color Grading Manual dengan HSL</h2>

<p>Filter otomatis CapCut memang nyaman, tapi untuk mendapat <strong>look yang benar-benar unik dan konsisten</strong>, kamu perlu menguasai color grading manual.</p>

<h3>Memahami HSL</h3>

<p><strong>HSL</strong> adalah tiga parameter yang mengontrol warna:</p>

<p><strong>H (Hue):</strong> Menggeser warna ke warna lain dalam spektrum. Misalnya, menggeser Hue hijau ke kanan akan membuat hijau terlihat lebih kekuningan.</p>

<p><strong>S (Saturation):</strong> Intensitas atau kepekatan warna. 0% = hitam putih, 100% = warna maksimal, terlalu tinggi = terlihat plastik.</p>

<p><strong>L (Luminance/Lightness):</strong> Kecerahan warna tertentu. Naikkan Luminance biru untuk langit yang lebih cerah tanpa mempengaruhi warna lainnya.</p>

<h3>Teknik Color Grading Populer</h3>

<p><strong>Look Cinematic (Teal &amp; Orange):</strong> Ini look paling populer di film Hollywood. Caranya: di HSL, naikkan saturation Orange (kulit manusia) dan Teal (bayangan dingin). Di Curves, tarik shadow ke arah biru/teal dan highlight ke arah oranye hangat.</p>

<p><strong>Look Vintage:</strong> Turunkan saturation secara keseluruhan. Naikkan shadow (buat shadow tidak terlalu gelap — kesan "lifted blacks"). Tambahkan sedikit grain di filter.</p>

<p><strong>Look Bright &amp; Airy (Populer untuk Lifestyle/Food):</strong> Naikkan exposure secara keseluruhan. Turunkan sedikit saturation, tapi naikkan luminance semua warna. Buat highlight sangat terang, bayangan terang.</p>

<p><strong>Look Dark &amp; Moody:</strong> Turunkan exposure. Kurangi contrast. Naikkan saturation biru dan teal di area shadow. Buat highlight tidak terlalu terang.</p>

<h3>Menyimpan Preset Kustom</h3>

<p>Setelah menemukan look yang bagus, tap ikon simpan/export di menu adjustment. Preset ini bisa diaplikasikan ke semua video berikutnya — menjaga konsistensi visual di seluruh feed.</p>

<h2>13. Picture-in-Picture yang Rapi</h2>

<p><strong>Picture-in-Picture (PiP)</strong> bukan hanya "taruh video kecil di sudut layar". Digunakan dengan benar, PiP bisa membuat konten reaction, tutorial, dan commentary jauh lebih menarik.</p>

<h3>Setup PiP Profesional</h3>

<p><strong>Langkah 1:</strong> Letakkan video utama di track utama (main track).</p>

<p><strong>Langkah 2:</strong> Tap <strong>"Overlay"</strong> → <strong>"Add Overlay"</strong> → import video sekunder (dirimu berbicara, reaction, dll).</p>

<p><strong>Langkah 3:</strong> Di layar preview, atur ukuran dan posisi video overlay dengan pinch dan drag.</p>

<p><strong>Langkah 4:</strong> Tambahkan efek <strong>"Stroke"</strong> (border) pada overlay untuk membedakannya secara visual dari background.</p>

<p><strong>Langkah 5:</strong> Pertimbangkan menambahkan <strong>shadow</strong> (bayangan) pada overlay agar terlihat mengapung di atas video utama.</p>

<h3>Trik PiP yang Jarang Diketahui</h3>

<p><strong>Shape Mask pada PiP:</strong> Alih-alih kotak biasa, gunakan mask lingkaran atau bentuk lain pada video overlay. Wajah dalam lingkaran terlihat jauh lebih profesional dari kotak biasa.</p>

<p><strong>Animasi PiP Masuk:</strong> Jangan biarkan PiP langsung muncul begitu saja. Gunakan keyframe untuk animasikan masuknya dari luar frame — slide dari kanan, atau scale dari kecil ke besar.</p>

<p><strong>Sync dengan Konten Utama:</strong> PiP terbaik muncul dan menghilang bersamaan dengan momen yang relevan di video utama, bukan terus ada sepanjang waktu.</p>

<h2>✦ TINGKAT LANJUT</h2>

<p><em>Fitur-fitur ini adalah yang memisahkan konten biasa dari konten yang ditonton jutaan orang. Butuh latihan, tapi hasilnya sepadan.</em></p>

<h2>14. Freeze Frame untuk Efek Dramatis</h2>

<p><strong>Freeze Frame</strong> adalah teknik membekukan satu bingkai video menjadi gambar diam, biasanya digunakan untuk momen dramatis, perkenalan karakter, atau efek komik.</p>

<h3>Membuat Freeze Frame di CapCut</h3>

<p><strong>Langkah 1:</strong> Temukan frame yang ingin dibekukan. Gunakan navigasi frame-by-frame (tombol <code>&lt;</code> <code>&gt;</code>) untuk presisi.</p>

<p><strong>Langkah 2:</strong> Tap klip → <strong>"Edit"</strong> → <strong>"Freeze"</strong>. CapCut otomatis menyisipkan klip "foto" dari frame tersebut selama 3 detik (bisa diubah durasinya).</p>

<p><strong>Langkah 3:</strong> Sekarang tambahkan elemen di atas freeze frame — teks nama karakter, panah, lingkaran sorot, atau efek visual apapun.</p>

<h3>Variasi Efek Freeze Frame</h3>

<p><strong>Freeze + Zoom:</strong> Setelah freeze, tambahkan keyframe zoom in yang lambat pada frame yang dibekukan — efek dramatis yang digunakan banyak film aksi.</p>

<p><strong>Freeze + Black &amp; White:</strong> Ubah warna frame yang dibekukan menjadi hitam putih sementara klip sebelum/sesudahnya tetap berwarna — efek "memory" atau "flashback".</p>

<p><strong>Freeze + Glitch:</strong> Tambahkan efek glitch singkat tepat sebelum freeze untuk transisi yang dramatis.</p>

<p><strong>Fake Slow Motion dengan Freeze:</strong> Untuk video yang direkam 30fps tapi butuh slow motion lebih ekstrem — kombinasikan speed ramp 0.3x dengan beberapa freeze frame di momen puncak untuk efek "time stop".</p>

<h2>15. Beat Sync Otomatis dan Manual</h2>

<p>Video yang <strong>tersinkronisasi dengan beat musik</strong> mendapat engagement yang jauh lebih tinggi. Ada sesuatu secara neurologi yang membuat otak manusia merespons positif ketika visual dan audio bergerak bersama.</p>

<h3>Auto Beat Sync di CapCut</h3>

<p><strong>Langkah 1:</strong> Masukkan musik ke timeline.</p>

<p><strong>Langkah 2:</strong> Tap track musik → cari opsi <strong>"Beat"</strong> atau <strong>"Auto Beat Sync"</strong>.</p>

<p><strong>Langkah 3:</strong> CapCut menganalisis musik dan menandai beat dengan titik-titik kuning di timeline.</p>

<p><strong>Langkah 4:</strong> Aktifkan <strong>"Auto Sync"</strong> — CapCut akan mencoba menyesuaikan potongan video dengan beat.</p>

<h3>Beat Sync Manual (Hasilnya Lebih Baik)</h3>

<p>Auto Sync kadang tidak akurat karena AI tidak mengerti <em>cerita</em> videomu. Cara manual:</p>

<p><strong>Langkah 1:</strong> Dengarkan musik, rasakan beat-nya. Tandai beat penting (biasanya setiap 4 bar, atau di drop).</p>

<p><strong>Langkah 2:</strong> Di timeline, tandai posisi beat yang ingin menjadi titik pergantian klip.</p>

<p><strong>Langkah 3:</strong> Sesuaikan in/out point setiap klip sehingga pergantian jatuh tepat di beat.</p>

<p><strong>Langkah 4:</strong> Gunakan teknik <strong>"Cut on the Beat"</strong> — potong video tepat di beat, bukan setelah atau sebelumnya.</p>

<h3>Tips Beat Sync untuk Genre Berbeda</h3>

<p><strong>Untuk musik EDM/Drop:</strong> Simpan klip paling impactful (close-up wajah, momen terbaik) untuk tepat di titik drop. Klip sebelum drop bisa dieksekusi lebih lambat dan panjang untuk membangun antisipasi.</p>

<p><strong>Untuk musik slow/ballad:</strong> Jangan potong setiap beat — terlalu cepat. Potong setiap 2-4 bar untuk ritme yang lebih tenang dan emosional.</p>

<p><strong>Untuk musik hip-hop:</strong> Sync bukan hanya di beat, tapi juga di snare dan hi-hat. Ini membuat editing terasa lebih "groovy".</p>

<h2>16. Text Animation Kustom</h2>

<p>Teks bukan hanya informasi — teks adalah <strong>elemen visual</strong> yang seharusnya berkontribusi pada mood dan energi video.</p>

<h3>Membangun Text Animation Berlapis</h3>

<p>CapCut memungkinkan setiap teks memiliki tiga animasi: <strong>In Animation</strong> (cara masuk), <strong>Loop Animation</strong> (gerakan selama teks diam), dan <strong>Out Animation</strong> (cara keluar).</p>

<p>Strategi profesional: pilih In dan Out yang berlawanan tapi senada. Misalnya In "Slide dari kiri", Out "Slide ke kanan" — terasa seperti teks "melewati" layar. Atau In "Scale up", Out "Scale up" — terasa seperti "memantul".</p>

<h3>Trik Teks Berlayer</h3>

<p>Buat efek teks yang eye-catching dengan menggunakan <strong>dua atau tiga layer teks yang sama</strong> dengan styling berbeda:</p>

<p><strong>Layer 1:</strong> Teks utama, warna putih, ukuran besar.</p>
<p><strong>Layer 2:</strong> Teks yang sama, warna brand kamu (misal merah), sedikit digeser ke kanan dan bawah, opacity 60% — efek "shadow berwarna".</p>
<p><strong>Layer 3:</strong> Teks yang sama, stroke tebal, opacity 20% — efek glow atau depth.</p>

<p>Kombinasi ketiga layer ini menghasilkan teks yang terlihat jauh lebih dimensi dari teks flat biasa.</p>

<h3>Teks Kinetic (Bergerak dengan Suara)</h3>

<p>Teks kinetic adalah teks yang bergerak mengikuti ritme narasi — setiap kata atau frasa muncul tepat saat diucapkan. Ini teknik yang banyak digunakan konten motivasi dan quote.</p>

<p>Caranya: gunakan Auto Caption → edit setiap caption menjadi satu kata atau satu frasa pendek → atur timing setiap teks sangat ketat (0.3-0.5 detik per kata) → pilih animasi pop yang cepat.</p>

<h2>17. Efek Glitch yang Terkontrol</h2>

<p><strong>Efek glitch</strong> adalah simulasi gangguan sinyal digital — pixelasi, pergeseran warna, distorsi. Digunakan dengan bijak, ini memberikan kesan edgy dan modern. Digunakan berlebihan, hasilnya mengganggu.</p>

<h3>Tiga Jenis Glitch di CapCut</h3>

<p><strong>Glitch dari Effects:</strong> Tap <strong>"Effects"</strong> → <strong>"Video Effects"</strong> → cari kategori "Glitch" atau "Distortion". Ada banyak preset — pilih yang sesuai kebutuhan.</p>

<p><strong>Glitch dari Transitions:</strong> Beberapa transisi di CapCut memiliki karakter glitch — chromatic aberration (pergeseran warna merah/biru), interference lines, digital noise.</p>

<p><strong>Glitch Manual (Paling Terkontrol):</strong></p>

<p>Ini cara paling fleksibel. Duplikasi klip video dua kali → letakkan sebagai dua layer overlay di atas original → pada layer pertama, geser sedikit ke kanan dan ubah blend mode ke "Lighten" dengan warna tinted merah → pada layer kedua, geser sedikit ke kiri dengan warna tinted biru. Tambahkan keyframe untuk membuat pergeseran bergerak secara acak selama 0.2-0.3 detik. Ini mereplikasi efek <strong>chromatic aberration</strong> — glitch paling sinematik.</p>

<h3>Kapan Menggunakan Glitch</h3>

<p>Tepat di momen transisi besar (dari bagian satu ke bagian dua video). Untuk menekankan momen shocking atau mengejutkan. Sebagai intro/opening yang energetik. Di titik drop musik untuk transisi yang dramatis.</p>

<p><strong>Jangan</strong> gunakan glitch sebagai filler atau di setiap transisi — efeknya akan kehilangan dampaknya.</p>

<h2>18. Body Effect dan AI Tools</h2>

<p>CapCut berinvestasi besar dalam <strong>AI tools</strong> — dan ini adalah nilai lebih yang membedakannya dari editor lain.</p>

<h3>AI Tools yang Layak Digunakan</h3>

<p><strong>Smart Scene Cut:</strong> Untuk video panjang dengan banyak adegan berbeda. AI mengidentifikasi perubahan scene secara otomatis dan menyarankan titik potong. Hemat waktu luar biasa untuk konten vlog.</p>

<p><strong>AI Portrait:</strong> Membuat background blur (efek bokeh) secara otomatis pada video wajah — meniru efek kamera DSLR. Bagus untuk interview atau talking-head yang direkam dengan smartphone.</p>

<p><strong>Video Enhance:</strong> Tap <strong>"Retouch"</strong> → <strong>"Enhance"</strong> untuk meningkatkan kualitas video secara otomatis — noise reduction, sharpening, color boost. Berguna untuk footage lama atau yang direkam dalam kondisi buruk.</p>

<p><strong>AI Sky Replacement:</strong> Di menu <strong>"Effect"</strong> atau <strong>"Smart"</strong>, beberapa versi CapCut memiliki kemampuan mengganti langit secara otomatis — dari mendung ke cerah, dari siang ke senja. Sangat berguna untuk konten outdoor.</p>

<p><strong>Body Retouch:</strong> Tap <strong>"Retouch"</strong> untuk akses ke fitur body retouch — tapi gunakan dengan bijak dan etis. Over-retouch menciptakan standar kecantikan yang tidak realistis.</p>

<h3>Catatan Penting tentang AI Tools</h3>

<p>AI tools terus berkembang di setiap update CapCut. Selalu eksplorasi menu <strong>"Smart"</strong> dan <strong>"AI"</strong> di versi terbaru karena fitur baru sering ditambahkan tanpa announcement besar.</p>

<h2>19. Multi-Layer Audio Mixing</h2>

<p>Video profesional biasanya memiliki <strong>empat hingga tujuh layer audio</strong> yang bekerja bersama untuk menciptakan pengalaman suara yang kaya.</p>

<h3>Arsitektur Audio Profesional</h3>

<pre><code>Layer 1 — Vokal/Narasi:    Volume 100% (elemen utama)
Layer 2 — Musik background: Volume 20-30% (jangan sampai kalahkan vokal)
Layer 3 — Sound Effect:     Volume 60-80% (muncul di momen spesifik)
Layer 4 — Ambient Sound:    Volume 10-15% (menciptakan "udara" di video)
Layer 5 — Musical Sting:    Volume 40-60% (untuk momen dramatis/transisi)</code></pre>

<h3>Cara Menambahkan Multiple Audio Tracks</h3>

<p>CapCut mendukung multiple audio tracks. Tap area kosong di bawah timeline → <strong>"Add Sound"</strong> untuk menambahkan track audio tambahan. Setiap track bisa diatur volumenya secara independen.</p>

<h3>Teknik "Room Tone"</h3>

<p>Salah satu trik audio yang jarang diketahui: rekam <strong>5-10 detik suara ruangan</strong> tanpa ada yang berbicara di lokasi yang sama dengan main footage. Gunakan rekaman ini sebagai ambient layer tipis di bawah seluruh video. Ini menciptakan konsistensi akustik yang membuat semua potongan terasa menyatu — tidak ada "dead silence" yang mengganggu antar cut.</p>

<h3>EQ dan Noise Reduction</h3>

<p>Di CapCut, tap klip audio → <strong>"Edit Sound"</strong> atau <strong>"Adjust"</strong>. Beberapa tools yang tersedia:</p>

<p><strong>Noise Reduction:</strong> Mengurangi background noise (kipas angin, AC, lalu lintas). Aktifkan dan sesuaikan level — jangan terlalu tinggi karena bisa membuat suara terdengar "robotic".</p>

<p><strong>Voice Enhance:</strong> Meningkatkan kejernihan suara vokal secara otomatis. Berguna untuk rekaman yang dilakukan di ruangan dengan akustik buruk.</p>

<h2>20. Export Cerdas untuk Setiap Platform</h2>

<p>Edit yang sempurna bisa dirusak oleh <strong>setting export yang salah</strong>. Setiap platform memiliki spesifikasi yang berbeda.</p>

<h3>Panduan Resolusi dan Format per Platform</h3>

<table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse: collapse; margin-bottom: 20px;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>Platform</th>
            <th>Rasio</th>
            <th>Resolusi</th>
            <th>FPS</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>TikTok</td>
            <td>9:16</td>
            <td>1080x1920</td>
            <td>30fps</td>
            <td>Vertical, max 10 menit</td>
        </tr>
        <tr>
            <td>Instagram Reels</td>
            <td>9:16</td>
            <td>1080x1920</td>
            <td>30fps</td>
            <td>Max 60 menit</td>
        </tr>
        <tr>
            <td>Instagram Feed</td>
            <td>1:1</td>
            <td>1080x1080</td>
            <td>30fps</td>
            <td>Square untuk feed</td>
        </tr>
        <tr>
            <td>YouTube Shorts</td>
            <td>9:16</td>
            <td>1080x1920</td>
            <td>60fps</td>
            <td>Vertical, max 60 detik</td>
        </tr>
        <tr>
            <td>YouTube Landscape</td>
            <td>16:9</td>
            <td>1920x1080</td>
            <td>60fps</td>
            <td>Gunakan 60fps untuk konten aksi</td>
        </tr>
        <tr>
            <td>Facebook Video</td>
            <td>4:5</td>
            <td>1080x1350</td>
            <td>30fps</td>
            <td>Portrait untuk mobile feed</td>
        </tr>
    </tbody>
</table>

<h3>Setting Export Optimal di CapCut</h3>

<p>Tap ikon <strong>export</strong> (↑) di pojok kanan atas → pilih <strong>"Settings"</strong> atau ikon gear:</p>

<p><strong>Resolusi:</strong> Pilih <strong>1080p</strong> sebagai minimum. Pilih <strong>4K</strong> hanya jika footage aslimu 4K dan platform mendukungnya (YouTube).</p>

<p><strong>Frame Rate:</strong> Sesuaikan dengan FPS asli rekamanmu. Jika rekamanmu 30fps, export 30fps. Jika 60fps (untuk slow motion), export 60fps.</p>

<p><strong>Bit Rate:</strong> Pilih <strong>"High"</strong> atau "Recommended" — jangan "Low" karena akan terlihat buram setelah dikompres platform.</p>

<h3>Trik Menghindari Degradasi Kualitas</h3>

<p>Platform seperti TikTok dan Instagram <strong>mengkompres video saat upload</strong>. Untuk meminimalkan kehilangan kualitas, export dengan resolusi sedikit lebih tinggi dari yang dibutuhkan dan biarkan platform mengkompresnya. Hindari upload ulang video yang sudah pernah didownload dari platform (sudah dikompres sekali) — selalu upload dari file original.</p>

<h2>21. Workflow Profesional — Cara Berpikir Editor Sungguhan</h2>

<p>Menguasai semua trik teknis di atas tidak ada artinya tanpa <strong>workflow yang terstruktur</strong>. Inilah perbedaan terakhir — dan terpenting — antara pemula dan profesional.</p>

<h3>Fase 1: Perencanaan (Sebelum Merekam)</h3>

<p>Editor profesional <strong>berpikir tentang editing sebelum mengangkat kamera</strong>. Mereka merencanakan:</p>

<p>Berapa klip yang dibutuhkan dan dari sudut mana. Musik atau audio apa yang akan digunakan — ini menentukan energi dan tempo cutting. Format akhir (landscape, portrait, square) — ini mempengaruhi komposisi rekaman. Apakah butuh footage B-roll untuk menutup bagian yang kurang menarik di footage utama.</p>

<h3>Fase 2: Rough Cut</h3>

<p>Import semua footage. Susun secara kasar di timeline sesuai urutan cerita. <strong>Jangan</strong> mulai edit detail dulu — selesaikan kerangka cerita dahulu. Hapus bagian yang jelas-jelas tidak berguna. Di akhir fase ini, kamu harus punya video dengan struktur yang benar, walau masih kasar.</p>

<h3>Fase 3: Fine Cut</h3>

<p>Sekarang sempurnakan setiap cut. Potong dengan presisi frame-by-frame. Tambahkan transisi. Sesuaikan timing setiap klip. Sinkronisasi dengan musik.</p>

<h3>Fase 4: Sound Design</h3>

<p>Tambahkan dan mix semua layer audio. Vokal, musik, sound effects, ambient. Pastikan volume konsisten di seluruh video. Tambahkan fade in/out di setiap transisi audio.</p>

<h3>Fase 5: Color &amp; Visual Polish</h3>

<p>Lakukan color grading. Tambahkan teks dan caption. Tambahkan efek dan animasi yang diperlukan. Terapkan filter atau look yang konsisten.</p>

<h3>Fase 6: Review dan Export</h3>

<p>Tonton video dari awal hingga akhir <strong>tanpa mengedit apapun</strong>. Tonton seperti penonton — catat momen yang terasa lambat, membingungkan, atau tidak tepat. Lakukan revisi final. Export dengan setting yang tepat untuk platform target.</p>

<h3>Prinsip Terpenting</h3>

<blockquote><p><strong>Editing yang baik adalah editing yang tidak terlihat.</strong> Penonton yang bagus seharusnya tenggelam dalam konten — bukan terpesona oleh teknik editingnya. Teknik adalah alat untuk menyampaikan cerita, bukan tujuan akhir.</p></blockquote>

<p>Kreator konten terbaik tidak berkata "lihat efek glitch-ku yang keren" — mereka membuat penonton berkata "videonya keren banget" tanpa tahu alasannya.</p>

<h2>Penutup: Dari Trik ke Kebiasaan</h2>

<p>Membaca 21 trik ini adalah langkah pertama. Tapi <strong>penguasaan datang dari pengulangan</strong>. Rekomendasinya sederhana:</p>

<p>Jangan coba semua trik sekaligus. Pilih <strong>3 trik</strong> yang paling relevan dengan konten yang kamu buat sekarang. Terapkan di video berikutmu. Setelah nyaman dan terasa alami, tambahkan 3 trik berikutnya.</p>

<p>Dalam 6 bulan dengan pendekatan ini, semua 21 trik di atas akan terasa seperti naluri — bukan lagi sesuatu yang harus kamu pikirkan, tapi bagian alami dari cara kamu bercerita melalui video.</p>

<pre><code>JALUR BELAJAR YANG DISARANKAN:
─────────────────────────────────────────────────
Minggu 1-2:  Kuasai Timeline + Split + Keyframe
Minggu 3-4:  Beat Sync + Speed Ramp + Transisi
Bulan 2:     Color Grading + Audio Mixing
Bulan 3:     Masking + Chroma Key + Text Animation
Bulan 4+:    Workflow Profesional + semua dikombinasikan
─────────────────────────────────────────────────</code></pre>

<p>Selamat membuat konten. Dan ingat — aplikasinya gratis, batasnya hanya imajinasimu.</p>

<p><em>Artikel ini ditulis berdasarkan fitur-fitur CapCut yang tersedia di versi mobile dan desktop. Beberapa nama menu mungkin sedikit berbeda antar versi, tapi konsep dan tekniknya berlaku universal.</em></p>
',
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(50, 200),
        ]);

        $this->command->info('CapCut 21 Tricks Article created successfully!');
    }
}
