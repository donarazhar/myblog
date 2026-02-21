<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class CanvaTipsArticleSeeder extends Seeder
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

        $content = $this->getArticleContent();

        Article::create([
            'title' => '74 Tips dan Trik Canva untuk Desain yang Lebih Baik',
            'slug' => '74-tips-dan-trik-canva-untuk-desain-yang-lebih-baik',
            'excerpt' => 'Dari pemula yang baru membuka Canva pertama kali hingga desainer berpengalaman yang ingin mempercepat workflow — 74 tips ini mencakup semua yang perlu Anda tahu untuk menghasilkan desain yang lebih profesional, lebih cepat, dan lebih konsisten.',
            'content' => $content,
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(50, 200),
        ]);

        $this->command->info('Canva 74 Tips Article created successfully!');
    }

    private function getArticleContent(): string
    {
        return $this->getPart1() . $this->getPart2() . $this->getPart3() . $this->getPart4() . $this->getPart5() . $this->getPart6() . $this->getPart7() . $this->getPart8() . $this->getClosing();
    }

    private function getPart1(): string
    {
        return '
<h2>🏁 Bagian 1 — Fondasi &amp; Setup (Tips 1–10)</h2>

<p><em>Sebelum mendesain apapun, pastikan Anda membangun pondasi yang kuat. Bagian ini adalah yang paling sering dilewatkan pemula — dan paling disesali kemudian.</em></p>

<h3>Tip 1 — Pilih Ukuran Kanvas yang Tepat Sejak Awal</h3>

<p>Kesalahan paling umum pemula Canva: mulai mendesain dengan ukuran yang salah, lalu mencoba mengubahnya di tengah jalan. Ukuran yang berbeda membutuhkan komposisi yang berbeda — desain Instagram Square (1080×1080px) tidak akan terlihat bagus jika dipaksakan ke Instagram Story (1080×1920px).</p>

<p><strong>Ukuran standar yang wajib dihapal:</strong></p>

<table border="1" cellpadding="8" cellspacing="0" style="width:100%; border-collapse: collapse; margin-bottom: 20px;">
<thead><tr style="background-color: #f2f2f2;"><th>Platform</th><th>Format</th><th>Ukuran (px)</th></tr></thead>
<tbody>
<tr><td>Instagram Post</td><td>Square</td><td>1080 × 1080</td></tr>
<tr><td>Instagram Story / Reels</td><td>Vertikal</td><td>1080 × 1920</td></tr>
<tr><td>Facebook Post</td><td>Landscape</td><td>1200 × 630</td></tr>
<tr><td>YouTube Thumbnail</td><td>Landscape</td><td>1280 × 720</td></tr>
<tr><td>YouTube Banner</td><td>Ultrawide</td><td>2560 × 1440</td></tr>
<tr><td>Presentasi (16:9)</td><td>Landscape</td><td>1920 × 1080</td></tr>
<tr><td>Pinterest Pin</td><td>Vertikal</td><td>1000 × 1500</td></tr>
<tr><td>TikTok / Shorts</td><td>Vertikal</td><td>1080 × 1920</td></tr>
<tr><td>A4 Dokumen</td><td>Portrait</td><td>794 × 1123</td></tr>
</tbody></table>

<p><strong>Cara terbaik:</strong> Buka Canva → klik "Buat desain" → ketik nama platform di kolom pencarian. Canva otomatis menyarankan ukuran yang tepat.</p>

<h3>Tip 2 — Manfaatkan Resize &amp; Magic Resize</h3>

<p>Sudah buat desain keren untuk Instagram Post, tapi perlu versi Story-nya juga? Jangan buat ulang dari nol.</p>

<p><strong>Cara menggunakan Resize (Canva Pro):</strong> Klik menu <strong>File</strong> → <strong>Ubah Ukuran</strong> (Resize) → masukkan dimensi baru atau pilih platform dari daftar → klik <strong>"Salin &amp; Ubah Ukuran"</strong>.</p>

<p>Canva membuat salinan desain dengan ukuran baru, lalu mencoba menyesuaikan elemen secara otomatis. Hasilnya memang tidak selalu sempurna dan perlu sedikit penyesuaian manual — tapi menghemat 70–80% waktu dibanding membuat desain baru.</p>

<h3>Tip 3 — Aktifkan Grid dan Panduan (Guides)</h3>

<p>Desain yang rapi bukan soal bakat — melainkan soal <strong>sistem</strong>. Grid dan panduan adalah sistem itu.</p>

<p><strong>Cara mengaktifkan:</strong></p>
<ul>
<li><strong>Ruler (Penggaris):</strong> Klik <strong>View</strong> → <strong>Tampilkan Penggaris</strong></li>
<li><strong>Grid:</strong> Klik <strong>View</strong> → <strong>Tampilkan Grid</strong></li>
<li><strong>Guides manual:</strong> Klik dan seret dari penggaris ke kanvas untuk membuat garis panduan</li>
</ul>

<h3>Tip 4 — Kuasai Snap to Grid dan Smart Guides</h3>

<p>Saat Anda menggeser elemen di Canva, garis-garis merah/merah muda muncul secara otomatis. Inilah <strong>Smart Guides</strong> — fitur yang menunjukkan kapan elemen sejajar dengan elemen lain atau tepat di tengah kanvas.</p>

<p><strong>Mengaktifkan Snap:</strong> <strong>View</strong> → <strong>Snap ke Panduan</strong> dan <strong>Snap ke Objek</strong></p>

<p><strong>Trik:</strong> Tahan tombol <strong>Alt</strong> saat menggeser elemen untuk menonaktifkan snap sementara — berguna saat Anda memang butuh posisi yang tidak beraturan.</p>

<h3>Tip 5 — Pahami Perbedaan Gratis vs. Pro vs. Teams</h3>

<p><strong>Canva Gratis:</strong> Lebih dari 250.000 template, jutaan elemen gratis, 5GB penyimpanan cloud, ekspor ke PNG/PDF/MP4, kolaborasi dasar.</p>

<p><strong>Canva Pro (berbayar):</strong> Semua di Gratis + Magic Resize, Background Remover, Brand Kit tak terbatas, 1TB penyimpanan, seluruh library premium, Magic Write (AI copywriting), Content Planner.</p>

<p><strong>Canva Teams:</strong> Semua di Pro + fitur kolaborasi enterprise, admin controls, SSO, dan branding terpusat.</p>

<p><strong>Trik hemat:</strong> Mahasiswa dan guru bisa menggunakan <strong>Canva for Education</strong> yang memberikan fitur Pro secara gratis.</p>

<h3>Tip 6 — Gunakan Template sebagai Titik Awal, Bukan Produk Jadi</h3>

<p>Template Canva dirancang oleh desainer profesional — tapi kelemahan terbesarnya adalah <strong>semua orang memakai template yang sama</strong>. Solusinya: gunakan template sebagai kerangka, lalu ubah hingga tidak terkenali lagi.</p>

<p><strong>Checklist modifikasi template minimal:</strong> Ganti semua font ke font brand Anda. Ubah semua warna ke palet brand Anda. Ganti semua foto/gambar dengan aset milik Anda sendiri. Sesuaikan semua teks dengan konten aktual Anda. Tambah atau hapus elemen yang tidak relevan.</p>

<h3>Tip 7 — Buat Folder dan Organisasi Desain dari Hari Pertama</h3>

<p>Jika Anda sudah membuat 5–10 desain di Canva, ini belum terasa perlu. Tapi saat Anda punya 200+ desain, kekacauan tanpa folder akan membuat Anda pusing.</p>

<pre><code>📁 Klien A
   📁 Instagram
   📁 Presentasi
   📁 Materi Cetak
📁 Klien B
📁 Template Pribadi
📁 Aset Brand</code></pre>

<h3>Tip 8 — Manfaatkan Canva di Desktop (Bukan Hanya Browser)</h3>

<p>Canva memiliki aplikasi desktop untuk Windows dan macOS yang menawarkan <strong>performa lebih stabil</strong> dibanding versi browser, terutama untuk proyek besar dengan banyak halaman.</p>

<h3>Tip 9 — Upload Aset Brand Anda Sendiri</h3>

<p>Foto stok Canva memang melimpah, tapi konten yang paling powerful adalah <strong>foto dan aset asli milik Anda</strong>.</p>

<p><strong>Tips penting:</strong> Upload logo Anda dalam format <strong>PNG transparan</strong> (background bening), bukan JPG. Format JPG memiliki background putih yang akan merusak tampilan di atas background berwarna.</p>

<h3>Tip 10 — Pahami Sistem Layer di Canva</h3>

<p>Setiap elemen di Canva berada di "layer" — urutan tumpukan dari depan ke belakang.</p>

<p><strong>Shortcut layer:</strong></p>
<ul>
<li><code>]</code> → maju satu layer</li>
<li><code>[</code> → mundur satu layer</li>
<li><code>Alt + ]</code> → ke paling depan</li>
<li><code>Alt + [</code> → ke paling belakang</li>
</ul>

<p><strong>Panel Layer:</strong> Klik <strong>File</strong> → <strong>Tampilkan Layer</strong> untuk melihat semua elemen dalam urutan layer yang bisa diatur ulang dengan drag &amp; drop.</p>';
    }

    private function getPart2(): string
    {
        return '
<h2>⌨️ Bagian 2 — Shortcut &amp; Produktivitas (Tips 11–20)</h2>

<p><em>Editor yang cepat bukan yang paling berbakat — melainkan yang paling efisien. Shortcut keyboard yang tepat bisa memotong waktu desain hingga 50%.</em></p>

<h3>Tip 11 — 20 Shortcut Keyboard Canva Wajib Hafal</h3>

<table border="1" cellpadding="8" cellspacing="0" style="width:100%; border-collapse: collapse; margin-bottom: 20px;">
<thead><tr style="background-color: #f2f2f2;"><th>Shortcut</th><th>Fungsi</th></tr></thead>
<tbody>
<tr><td><code>Ctrl/Cmd + D</code></td><td>Duplikat elemen</td></tr>
<tr><td><code>Ctrl/Cmd + G</code></td><td>Group elemen terpilih</td></tr>
<tr><td><code>Ctrl/Cmd + Shift + G</code></td><td>Ungroup</td></tr>
<tr><td><code>Ctrl/Cmd + L</code></td><td>Lock/kunci elemen</td></tr>
<tr><td><code>Ctrl/Cmd + Z</code></td><td>Undo</td></tr>
<tr><td><code>Ctrl/Cmd + Shift + Z</code></td><td>Redo</td></tr>
<tr><td><code>T</code></td><td>Tambah text box baru</td></tr>
<tr><td><code>R</code></td><td>Tambah rectangle</td></tr>
<tr><td><code>C</code></td><td>Tambah circle</td></tr>
<tr><td><code>L</code></td><td>Tambah line</td></tr>
</tbody></table>

<h3>Tip 12 — Tahan Shift untuk Proporsi Sempurna</h3>

<p>Saat mengubah ukuran elemen, tahan tombol <strong>Shift</strong> sambil menyeret sudut elemen. Ini mempertahankan rasio aspek secara otomatis — sehingga lingkaran tetap lingkaran, kotak tetap kotak, dan foto tidak terlihat meregang.</p>

<h3>Tip 13 — Gunakan Tombol Panah untuk Presisi Posisi</h3>

<p>Saat elemen terpilih, gunakan <strong>tombol panah keyboard</strong> untuk memindahkan elemen secara presisi:</p>
<ul>
<li>Panah biasa → bergerak 1px</li>
<li><strong>Shift + Panah</strong> → bergerak 10px</li>
</ul>

<h3>Tip 14 — Copy &amp; Paste Style Antar Elemen</h3>

<p>Sudah menghabiskan waktu menyetel warna, font, ukuran, dan efek pada sebuah elemen teks? Jangan ulangi proses yang sama untuk elemen teks lain.</p>

<p>Shortcut: <strong>Ctrl/Cmd + Alt + C</strong> untuk copy style, lalu <strong>Ctrl/Cmd + Alt + V</strong> untuk paste style.</p>

<h3>Tip 15 — Duplikat Halaman untuk Variasi Cepat</h3>

<p>Klik tanda <strong>"..."</strong> di thumbnail halaman → <strong>"Duplikat Halaman"</strong>. Salinan identik terbuat. Ubah satu elemen pada salinan itu untuk membuat variasi tanpa mengerjakan ulang layout dari nol.</p>

<h3>Tip 16 — Manfaatkan Pencarian Elemen yang Spesifik</h3>

<p>Canva memiliki lebih dari 100 juta aset. Pencarian generik akan memberi Anda jutaan hasil yang membingungkan.</p>

<p><strong>Teknik pencarian yang lebih cerdas:</strong> Gunakan kata sifat deskriptif: alih-alih "arrow", cari "minimal thin arrow right". Tambahkan "flat design", "line art", "watercolor", "3D", "retro", "minimalist" untuk menyaring gaya.</p>

<h3>Tip 17 — Gunakan "Find &amp; Replace" untuk Teks</h3>

<p>Punya dokumen 20 halaman dan perlu mengganti nama yang salah di semua halaman? <strong>Edit</strong> → <strong>Find &amp; Replace</strong> → masukkan kata yang ingin dicari dan kata penggantinya → <strong>Replace All</strong>.</p>

<h3>Tip 18 — Multi-Select yang Efisien</h3>

<ul>
<li><strong>Klik + Shift + Klik</strong> → tambahkan elemen ke seleksi satu per satu</li>
<li><strong>Drag selection box</strong> → seret mouse untuk membuat kotak seleksi</li>
<li><strong>Ctrl/Cmd + A</strong> → pilih semua elemen di halaman aktif</li>
</ul>

<h3>Tip 19 — Kunci Elemen yang Tidak Ingin Tergeser</h3>

<p>Klik elemen → klik ikon <strong>kunci 🔒</strong> di toolbar atas. Elemen yang dikunci tidak bisa dipindahkan, diubah ukurannya, atau dihapus secara tidak sengaja.</p>

<p><strong>Workflow terbaik:</strong> Kunci background dan elemen struktural segera setelah memposisikannya. Fokus editing hanya pada elemen konten di atasnya.</p>

<h3>Tip 20 — Gunakan Canva Assistant (Magic Studio)</h3>

<p><strong>Magic Write:</strong> AI copywriting yang bisa menghasilkan caption, tagline, deskripsi produk langsung di dalam desain.</p>

<p><strong>Magic Design:</strong> Upload satu foto atau deskripsi, Canva AI akan menghasilkan beberapa template desain yang disesuaikan secara otomatis.</p>

<p><strong>Magic Edit:</strong> Ganti elemen dalam foto menggunakan AI. Pilih area dengan brush → deskripsikan penggantinya.</p>

<p><strong>Magic Eraser:</strong> Hapus objek tidak diinginkan dari foto secara otomatis.</p>';
    }

    private function getPart3(): string
    {
        return '
<h2>🎨 Bagian 3 — Warna &amp; Tipografi (Tips 21–30)</h2>

<p><em>Warna dan tipografi adalah 80% dari kesan pertama sebuah desain.</em></p>

<h3>Tip 21 — Gunakan Palet Warna, Bukan Warna Acak</h3>

<p><strong>Formula 60-30-10:</strong> 60% desain menggunakan warna dominan (biasanya netral). 30% menggunakan warna sekunder. 10% menggunakan warna aksen untuk elemen yang ingin ditonjolkan.</p>

<p><strong>Tool pencari palet:</strong> Canva memiliki <strong>"Color Palette Generator"</strong> di canva.com/colors/color-palette-generator — upload foto, Canva ekstrak palet warnanya secara otomatis.</p>

<h3>Tip 22 — Ekstrak Warna Langsung dari Gambar</h3>

<p>Klik elemen yang ingin diubah warnanya → klik kotak warna di toolbar → klik ikon <strong>eyedropper</strong> (pipet) → klik bagian manapun dari kanvas untuk mengambil warnanya.</p>

<h3>Tip 23 — Simpan Palet Warna Kustom</h3>

<p>Panel warna → klik <strong>"+"</strong> di sebelah "Warna Kustom" → tambahkan warna satu per satu → beri nama palet. Palet tersimpan tersedia di semua proyek Canva Anda.</p>

<h3>Tip 24 — Pahami Psikologi Warna untuk Konten</h3>

<p><strong>Merah:</strong> Urgensi, energi, gairah. Cocok untuk: sale, promo terbatas.</p>
<p><strong>Biru:</strong> Kepercayaan, profesionalisme, ketenangan. Cocok untuk: corporate, fintech, healthcare.</p>
<p><strong>Hijau:</strong> Alam, kesehatan, pertumbuhan. Cocok untuk: kesehatan, lingkungan, keuangan.</p>
<p><strong>Kuning:</strong> Optimisme, perhatian, keceriaan. Cocok untuk: anak-anak, promosi diskon.</p>
<p><strong>Ungu:</strong> Kemewahan, kreativitas. Cocok untuk: beauty, premium brand, seni.</p>
<p><strong>Hitam:</strong> Elegan, eksklusif, modern. Cocok untuk: luxury, fashion, teknologi premium.</p>

<h3>Tip 25 — Gunakan Opacity untuk Warna yang Lebih Halus</h3>

<p>Klik elemen → di toolbar atas ada angka persentase (biasanya 100) → kurangi untuk membuat elemen lebih transparan.</p>

<p><strong>Penggunaan kreatif:</strong> Overlay gambar dengan kotak berwarna opacity 30-50% untuk menciptakan efek color wash yang tetap memperlihatkan foto di bawahnya.</p>

<h3>Tip 26 — Maksimalkan Kontras untuk Keterbacaan</h3>

<p>Aturan emas tipografi: <strong>teks harus mudah dibaca</strong>. Teks terang di atas background gelap (atau sebaliknya). Jika foto sebagai background, tambahkan overlay gelap semi-transparan di antara foto dan teks.</p>

<h3>Tip 27 — Batasi Jumlah Font dalam Satu Desain</h3>

<p>Desain profesional biasanya menggunakan <strong>maksimal 2-3 font</strong>:</p>

<p><strong>Font 1 (Display/Heading):</strong> Font yang ekspresif, bold, eye-catching.</p>
<p><strong>Font 2 (Body):</strong> Font yang mudah dibaca dalam ukuran kecil.</p>
<p><strong>Font 3 (Aksen, opsional):</strong> Font dekoratif untuk aksen kecil.</p>

<p><strong>Pasangan font yang terbukti:</strong> Playfair Display + Lato, Montserrat + Open Sans, Raleway + Merriweather, Oswald + Source Serif Pro, Bebas Neue + Roboto.</p>

<h3>Tip 28 — Gunakan Hierarki Tipografi yang Jelas</h3>

<p><strong>Level 1 — Headline:</strong> Ukuran terbesar, paling bold. Menjawab "Ini tentang apa?" dalam 3 detik pertama.</p>
<p><strong>Level 2 — Subheadline:</strong> Ukuran sedang, memberi konteks tambahan.</p>
<p><strong>Level 3 — Body/Detail:</strong> Ukuran terkecil, informasi pendukung.</p>

<p><strong>Aturan proporsi:</strong> Jika body text 12pt → subheadline 18-24pt → headline 36-48pt atau lebih besar.</p>

<h3>Tip 29 — Manfaatkan Font Pairing Suggestions Canva</h3>

<p>Saat Anda memilih sebuah font → Canva menampilkan saran <strong>"Font Pairs"</strong> di bawah daftar font. Ini dirancang oleh tim tipografi Canva berdasarkan prinsip desain yang telah teruji.</p>

<h3>Tip 30 — Manfaatkan Fitur "Text Effects"</h3>

<p>Klik teks → klik <strong>"Efek"</strong> di toolbar → panel efek teks akan terbuka:</p>

<p><strong>Shadow:</strong> Tambahkan bayangan untuk kesan dimensi. <strong>Lift:</strong> Bayangan lembut, kesan mengambang. <strong>Hollow:</strong> Teks dengan outline tanpa fill. <strong>Splice:</strong> Bayangan yang terpisah — efek retro. <strong>Echo:</strong> Bayangan berlapis — efek 3D. <strong>Glitch:</strong> Distorsi digital untuk konten gaming/tech. <strong>Neon:</strong> Efek glow seperti lampu neon.</p>';
    }

    private function getPart4(): string
    {
        return '
<h2>🖼️ Bagian 4 — Gambar, Foto &amp; Elemen Visual (Tips 31–40)</h2>

<p><em>Gambar yang tepat bisa membuat desain biasa menjadi luar biasa. Gambar yang salah bisa merusak desain sempurna sekalipun.</em></p>

<h3>Tip 31 — Gunakan Frame untuk Foto yang Rapi</h3>

<p><strong>Frame</strong> di Canva adalah bentuk yang bisa "diisi" dengan foto. Klik <strong>Elemen</strong> → cari <strong>"Frame"</strong> → pilih bentuk → drag foto ke dalam frame → foto otomatis ter-crop mengikuti bentuk.</p>

<p>Double-click pada frame untuk menyesuaikan posisi foto di dalamnya.</p>

<h3>Tip 32 — Hapus Background Foto Seketika</h3>

<p>Upload foto → klik foto → <strong>"Edit Gambar"</strong> → <strong>"Background Remover"</strong> → tunggu beberapa detik. Canva AI mendeteksi subjek utama dan menghapus backgroundnya secara otomatis.</p>

<h3>Tip 33 — Edit Foto Langsung di Canva</h3>

<p>Klik foto → <strong>"Edit Gambar"</strong> → parameter yang bisa disesuaikan: Brightness, Contrast, Saturation, Tint, Warmth, Sharpen, Highlights, Shadows, Fade, Vignette.</p>

<p><strong>Filters bawaan:</strong> Lebih dari 30 filter preset tersedia. Jangan gunakan intensitas 100% — biasanya 40-70% terlihat lebih natural.</p>

<h3>Tip 34 — Teknik "Duotone" untuk Foto yang Konsisten</h3>

<p><strong>Duotone</strong> mengubah foto menjadi dua warna. Klik foto → <strong>"Edit Gambar"</strong> → <strong>"Duotone"</strong> → pilih preset atau buat kustom. Ini cara tercepat membuat semua foto terlihat konsisten dengan brand color Anda.</p>

<h3>Tip 35 — Posisikan Foto dengan Aturan Rule of Thirds</h3>

<p><strong>Rule of Thirds</strong> membagi frame menjadi 9 kotak sama besar (3×3 grid) dan merekomendasikan meletakkan subjek utama di sepanjang garis atau di titik persimpangan grid.</p>

<pre><code>┌─────┬─────┬─────┐
│     │  ✦  │     │
├─────┼─────┼─────┤
│     │     │  ✦  │  ← Titik ideal untuk subjek
├─────┼─────┼─────┤
│     │     │     │
└─────┴─────┴─────┘</code></pre>

<h3>Tip 36 — Gunakan "Photo Filters" Secara Konsisten</h3>

<p>Konsistensi visual adalah kunci feed media sosial yang profesional. Gunakan filter foto yang sama di semua konten. Edit foto → simpan sebagai preset → gunakan di konten berikutnya.</p>

<h3>Tip 37 — Teknik "Text Over Image" yang Profesional</h3>

<p><strong>Metode 1 — Color Overlay:</strong> Tambahkan kotak berwarna gelap, opacity 40-60%, di antara foto dan teks.</p>

<p><strong>Metode 2 — Gradient Overlay:</strong> Gunakan overlay gradien dari gelap ke transparan. Posisikan teks di area gelap.</p>

<p><strong>Metode 3 — Blur Spot:</strong> Blur bagian foto di area teks akan ditempatkan.</p>

<p><strong>Metode 4 — Text Background:</strong> Beri background warna solid hanya pada elemen teks — efek label yang modern.</p>

<h3>Tip 38 — Cari Elemen SVG, Bukan PNG</h3>

<p>Prioritaskan format <strong>SVG</strong> (vector) daripada PNG. Keunggulan: bisa diperbesar tanpa pecah, bisa diubah warnanya langsung di Canva, ukuran file lebih kecil, tepi lebih tajam di semua ukuran.</p>

<h3>Tip 39 — Grouping dan Ungrouping Elemen</h3>

<p><strong>Group:</strong> Pilih semua elemen → <strong>Ctrl/Cmd + G</strong></p>
<p><strong>Ungroup:</strong> Klik grup → <strong>Ctrl/Cmd + Shift + G</strong></p>
<p><strong>Nested Group:</strong> Anda bisa membuat grup dari beberapa grup — sangat berguna untuk desain kompleks.</p>

<h3>Tip 40 — Gunakan Grid Layout untuk Konten Multi-Foto</h3>

<p><strong>Elemen</strong> → <strong>Grid</strong> → pilih konfigurasi (2 kolom, 3 kolom, mosaic) → drag foto ke masing-masing sel. Semua foto otomatis mendapat ukuran dan proporsi identik.</p>';
    }

    private function getPart5(): string
    {
        return '
<h2>✨ Bagian 5 — Efek, Animasi &amp; Presentasi (Tips 41–50)</h2>

<p><em>Desain yang bergerak menarik perhatian 3x lebih lama daripada desain statis.</em></p>

<h3>Tip 41 — Animasi "Page" vs. Animasi "Elemen"</h3>

<p><strong>Page Animation:</strong> Seluruh halaman masuk dengan animasi yang sama. Klik area kosong → <strong>"Animate"</strong> → pilih gaya.</p>
<p><strong>Element Animation:</strong> Setiap elemen memiliki animasi sendiri. Klik elemen → <strong>"Animate"</strong> → atur timing dan gaya.</p>

<h3>Tip 42 — Atur Timing Animasi dengan Cermat</h3>

<p>Animasi masuk: 0.4–0.8 detik. Durasi tampil: cukup lama untuk dibaca. Animasi keluar: 0.3–0.5 detik.</p>

<p><strong>Stagger effect:</strong> Untuk 4 bullet point berurutan, atur delay: elemen 1 di 0s, elemen 2 di 0.3s, elemen 3 di 0.6s, elemen 4 di 0.9s.</p>

<h3>Tip 43 — Buat Presentasi yang Interaktif</h3>

<p><strong>Presenter View:</strong> Saat presentasi, klik <strong>"Present"</strong> → <strong>"Presenter View"</strong>. Anda melihat slide saat ini + slide berikutnya + catatan presenter.</p>

<p><strong>Link Antar Slide:</strong> Klik elemen → <strong>"Link"</strong> → <strong>"Page in this design"</strong> → pilih halaman tujuan. Membuat presentasi non-linear dan interaktif.</p>

<h3>Tip 44 — Export Animasi sebagai GIF atau MP4</h3>

<p><strong>GIF:</strong> Cocok untuk email, website. Klik <strong>Share</strong> → <strong>Download</strong> → pilih <strong>"GIF"</strong>.</p>
<p><strong>MP4:</strong> Kualitas terbaik, untuk media sosial. Klik <strong>Share</strong> → <strong>Download</strong> → pilih <strong>"MP4 Video"</strong>.</p>

<h3>Tip 45 — Tambahkan Musik dan Suara ke Desain Animasi</h3>

<p>Klik ikon <strong>"Audio"</strong> di toolbar → pilih dari library musik Canva atau upload file audio sendiri. Sesuaikan volume, trim, atur fade in/out.</p>

<h3>Tip 46 — Buat Video Singkat dengan Canva Video Editor</h3>

<p>Canva memiliki video editor: import clips, trim, cut, transisi, overlay teks, musik, color filter, ekspor hingga 4K (Pro).</p>

<p>Beranda → <strong>"Buat Desain"</strong> → ketik "Video" → pilih ukuran → editor video terbuka.</p>

<h3>Tip 47 — Gunakan Transition Antar Halaman dengan Bijak</h3>

<p>Gunakan satu jenis transisi konsisten. Durasi 0.3–0.5 detik. Hindari transisi yang terlalu "animated" untuk presentasi formal.</p>

<h3>Tip 48 — Manfaatkan Fitur "Morph" untuk Transisi Halus</h3>

<p><strong>Morph</strong> menganimasi perubahan elemen dari satu halaman ke halaman berikutnya secara halus. Pastikan elemen sama ada di dua halaman → pilih transisi <strong>"Morph"</strong>.</p>

<h3>Tip 49 — Embed Canva ke Website atau Blog</h3>

<p>Klik <strong>"Share"</strong> → <strong>"More"</strong> → <strong>"Embed"</strong> → salin kode HTML → paste ke website. Desain yang diembed tetap interaktif dan otomatis terupdate jika Anda mengubahnya.</p>

<h3>Tip 50 — Gunakan "Smart Mockup" untuk Presentasi Produk</h3>

<p><strong>Elemen</strong> → cari "Mockup" → pilih device/objek → pilih desain yang ingin ditampilkan. Canva menempatkan desain Anda dengan perspektif yang tepat secara otomatis.</p>';
    }

    private function getPart6(): string
    {
        return '
<h2>🗂️ Bagian 6 — Organisasi &amp; Manajemen Desain (Tips 51–58)</h2>

<p><em>Desainer yang tidak terorganisir kehilangan waktu lebih banyak untuk mencari file daripada untuk mendesain.</em></p>

<h3>Tip 51 — Beri Nama Desain yang Deskriptif</h3>

<p><strong>Format penamaan:</strong> <code>[Klien/Proyek] — [Tipe Konten] — [Tanggal/Versi]</code></p>
<p>Contoh: "Toko Baju Online — IG Post Promo — Nov 2025 v2"</p>

<h3>Tip 52 — Gunakan "Copy of Design" untuk Iterasi Aman</h3>

<p>Sebelum perubahan besar, buat salinan dulu. <strong>File</strong> → <strong>Buat Salinan</strong>. Beri nama dengan tambahan "v2" atau "backup".</p>

<h3>Tip 53 — Manfaatkan Version History</h3>

<p><strong>File</strong> → <strong>Riwayat Versi</strong> → klik versi yang ingin dipulihkan → <strong>"Pulihkan versi ini"</strong>. Canva menyimpan versi otomatis setiap beberapa menit.</p>

<h3>Tip 54 — Gunakan "Star" untuk Desain Favorit</h3>

<p>Hover pada desain → klik ikon <strong>bintang ⭐</strong> → desain muncul di filter <strong>"Starred"</strong>. Jauh lebih cepat dari mencari melalui ratusan folder.</p>

<h3>Tip 55 — Kelola Asset dengan "Brand Kit"</h3>

<p><strong>Brand Kit</strong> menyimpan logo, warna brand, font brand di satu tempat. Klik ikon <strong>Brand Kit</strong> → upload logo → tambahkan warna → pilih font. Tersedia di semua desain baru.</p>

<h3>Tip 56 — Buat Template Internal untuk Tim</h3>

<p>Buat desain → <strong>"Share"</strong> → <strong>"Publish as Template"</strong> → pilih "For your team". Template muncul di <strong>"Your Team Templates"</strong> untuk semua anggota tim.</p>

<h3>Tip 57 — Manfaatkan Trash untuk Pemulihan Darurat</h3>

<p>Desain yang dihapus masuk ke <strong>Trash</strong> dan disimpan selama <strong>30 hari</strong>. Beranda → <strong>"Sampah"</strong> → <strong>"Pulihkan"</strong>.</p>

<h3>Tip 58 — Ekspor dalam Format yang Tepat untuk Tiap Tujuan</h3>

<p><strong>PNG:</strong> Logo, ikon, desain butuh transparansi. <strong>JPG:</strong> Foto, desain tanpa transparansi. <strong>PDF Standard:</strong> Dokumen untuk layar. <strong>PDF Print:</strong> Material cetak (resolusi lebih tinggi). <strong>SVG:</strong> Logo untuk berbagai ukuran (Pro). <strong>MP4:</strong> Konten animasi dan video. <strong>GIF:</strong> Animasi untuk email/website.</p>';
    }

    private function getPart7(): string
    {
        return '
<h2>🤝 Bagian 7 — Kolaborasi &amp; Brand Kit (Tips 59–65)</h2>

<p><em>Canva bukan hanya alat personal — ia juga platform kolaborasi yang powerful untuk tim.</em></p>

<h3>Tip 59 — Kolaborasi Real-Time seperti Google Docs</h3>

<p>Klik <strong>"Share"</strong> → masukkan email → atur permission: <strong>"Can Edit"</strong> atau <strong>"Can View"</strong>. Gunakan <strong>Comment</strong> untuk feedback: klik kanan area → <strong>"Add Comment"</strong>.</p>

<h3>Tip 60 — Gunakan "Approval Workflow" untuk Kontrol Kualitas</h3>

<p>Di Canva Teams: Editor mengajukan desain → reviewer menyetujui atau menolak → jika disetujui, desain siap digunakan. Mencegah konten belum disetujui terpublikasikan.</p>

<h3>Tip 61 — Share Desain sebagai Link View-Only</h3>

<p><strong>Share</strong> → <strong>"Anyone with the link"</strong> → permission <strong>"Can View"</strong> → salin link. Penerima bisa melihat tanpa akun Canva.</p>

<h3>Tip 62 — Publish Desain Langsung ke Media Sosial</h3>

<p>Platform yang didukung: Instagram, Facebook, Twitter/X, LinkedIn, Pinterest, Slack.</p>

<p><strong>Share</strong> → <strong>"Jadwalkan atau Publikasikan"</strong> → pilih platform → connect akun → <strong>"Publikasikan Sekarang"</strong> atau <strong>"Jadwalkan"</strong>.</p>

<p><strong>Content Planner:</strong> Kalender semua jadwal posting di semua platform.</p>

<h3>Tip 63 — Gunakan Brand Voice di Magic Write</h3>

<p>Klik area teks → <strong>"Magic Write"</strong> → berikan instruksi gaya: <em>"Tulis dengan nada profesional tapi hangat"</em> atau <em>"Gunakan bahasa yang energetik dan mengundang anak muda"</em>.</p>

<h3>Tip 64 — Buat "Design System" Mini dengan Canva</h3>

<p>Buat satu desain sebagai referensi visual:</p>
<ul>
<li>Halaman 1: Logo dalam semua variasi</li>
<li>Halaman 2: Palet warna lengkap dengan kode hex</li>
<li>Halaman 3: Tipografi — semua font dengan contoh</li>
<li>Halaman 4: Contoh elemen UI</li>
<li>Halaman 5: Contoh desain benar vs. salah</li>
<li>Halaman 6: Template siap pakai</li>
</ul>

<h3>Tip 65 — Manfaatkan Integrasi Canva dengan Tools Lain</h3>

<p><strong>Google Drive &amp; Dropbox:</strong> Import aset langsung dari cloud storage. <strong>HubSpot &amp; Mailchimp:</strong> Ekspor desain email ke platform marketing. <strong>Slack:</strong> Bagikan desain langsung ke channel. <strong>GIPHY &amp; Pexels:</strong> Akses library langsung dari panel elemen Canva.</p>';
    }

    private function getPart8(): string
    {
        return '
<h2>🚀 Bagian 8 — Fitur Lanjutan &amp; Rahasia Pro (Tips 66–74)</h2>

<p><em>Tips-tips ini adalah yang digunakan desainer profesional untuk pekerjaan serius.</em></p>

<h3>Tip 66 — Buat Pola (Pattern) Sendiri dari Elemen Canva</h3>

<p>Pilih satu elemen → atur ukuran kecil → duplikat berkali-kali dan susun dalam grid → group semua → duplikat untuk memenuhi kanvas. Atau cari "seamless pattern" atau "tile" di Canva Elements.</p>

<h3>Tip 67 — Gunakan "Transparent Background" untuk PNG Berkualitas</h3>

<p>Saat ekspor, pilih format <strong>PNG</strong> → centang <strong>"Transparent background"</strong>. Verifikasi dengan melihat pattern checkerboard abu-putih di file hasil.</p>

<h3>Tip 68 — Buat Infografis dari Data dengan Charts</h3>

<p><strong>Elemen</strong> → <strong>Charts</strong> → pilih tipe (bar, line, pie, donut, area, scatter) → masukkan data atau import dari Google Sheets. Semua aspek visual bisa dikustomisasi sesuai brand.</p>

<h3>Tip 69 — Teknik "Bleed" untuk Material Cetak</h3>

<p><strong>File</strong> → <strong>"Show Print Bleed"</strong> → area bleed (3mm di setiap sisi) ditampilkan. Elemen yang menyentuh tepi harus melewati garis bleed. Teks harus di dalam safe area. Saat ekspor: <strong>"PDF Print"</strong> + centang <strong>"Crop marks and bleed"</strong>.</p>

<h3>Tip 70 — Gunakan "Position Panel" untuk Penempatan Presisi</h3>

<p>Klik elemen → tombol <strong>"Position"</strong> → masukkan koordinat X, Y, dan ukuran W, H yang tepat. Gunakan alignment tools: rata kiri, tengah, kanan, atas, tengah vertikal, bawah.</p>

<h3>Tip 71 — Eksplorasi "Canva Docs" untuk Konten Panjang</h3>

<p><strong>Canva Docs</strong> adalah tool pembuatan dokumen — mirip Google Docs tapi dengan visual Canva. Embedding desain Canva ke dalam teks, Magic Write terintegrasi, output bisa langsung dijadikan presentasi.</p>

<h3>Tip 72 — Buat QR Code Langsung di Canva</h3>

<p><strong>Elemen</strong> → cari <strong>"QR Code"</strong> → masukkan URL → QR code otomatis terupdate. Ubah warna foreground dan background sesuai brand (pastikan kontras cukup untuk bisa di-scan).</p>

<h3>Tip 73 — Gunakan "Canva Print" untuk Cetak Langsung</h3>

<p>Selesaikan desain → <strong>"Print this design"</strong> di menu Share → pilih produk (kartu nama, flyer, poster, mug, kaos) → pilih jumlah → checkout → dikirim ke alamat Anda.</p>

<h3>Tip 74 — Jadikan Canva Bagian dari Sistem Konten</h3>

<p>Gunakan Canva bukan hanya saat butuh membuat satu desain, tetapi sebagai <strong>pusat sistem konten</strong>:</p>

<p>Brand Kit menyimpan semua aset → Template yang sudah disetujui memastikan konsistensi → Content Planner mengatur jadwal posting → Kolaborasi tim memungkinkan semua orang berkontribusi → Magic Write mempercepat copywriting → Direct publish ke platform menghemat langkah manual.</p>

<p>Dengan membangun sistem di Canva, Anda tidak hanya mendesain lebih baik — Anda mendesain lebih <strong>cerdas</strong>.</p>';
    }

    private function getClosing(): string
    {
        return '
<h2>Penutup</h2>

<p>Canva terus berkembang — fitur baru ditambahkan setiap bulan, AI semakin terintegrasi, dan library aset terus bertumbuh. Artikel ini adalah fondasi yang solid, tapi <strong>jangan berhenti mengeksplorasi</strong>.</p>

<p>Cara terbaik menguasai Canva adalah dengan <strong>desain aktual</strong> — bukan hanya membaca tips. Ambil satu proyek nyata, terapkan 5-10 tips dari artikel ini, dan lihat hasilnya sendiri.</p>

<p>Desain yang baik bukan soal software mana yang Anda gunakan. Ini soal pemahaman prinsip visual, konsistensi brand, dan keberanian untuk terus mencoba sampai hasilnya benar-benar baik.</p>

<p>Selamat mendesain.</p>

<p><em>Artikel ini ditulis berdasarkan fitur Canva yang tersedia per akhir 2025. Beberapa nama menu dan ketersediaan fitur mungkin berbeda antara akun Gratis, Pro, dan Teams.</em></p>';
    }
}
