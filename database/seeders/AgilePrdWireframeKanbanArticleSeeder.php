<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class AgilePrdWireframeKanbanArticleSeeder extends Seeder
{
    public function run(): void
    {
        // Get admin user
        $admin = User::where('is_admin', true)->first();

        if (!$admin) {
            $this->command->warn('No admin user found. Please run DatabaseSeeder first.');
            return;
        }

        // Get or create category
        $category = Category::firstOrCreate(
            ['name' => 'Teknologi'],
            ['description' => 'Artikel tentang perkembangan teknologi']
        );

        // Create Agile PRD Wireframe Kanban article
        Article::create([
            'title' => 'Menepis Birokrasi Dokumen: Mengapa Agile Memilih PRD Ringan, Wireframe, dan Kanban Board',
            'slug' => 'menepis-birokrasi-dokumen-mengapa-agile-memilih-prd-ringan-wireframe-dan-kanban-board',
            'excerpt' => 'Dalam metode pengembangan tradisional, tim sering terjebak dalam pembuatan dokumen tebal sebelum satu baris kode ditulis. Agile hadir sebagai antitesis dengan tiga alat komunikasi efisien: PRD Ringan, Wireframe, dan Kanban Board.',
            'content' => '
<p>Dalam metode pengembangan tradisional (seperti <em>Waterfall</em>), tim sering kali terjebak dalam pembuatan dokumen setebal puluhan hingga ratusan halaman sebelum satu baris kode pun ditulis. Masalahnya, di era transformasi digital yang bergerak cepat, kebutuhan pengguna bisa berubah dalam hitungan minggu. Dokumen tebal tersebut sering kali sudah kedaluwarsa saat aplikasi selesai dibuat.</p>

<p>Di sinilah <strong>Agile</strong> hadir sebagai antitesis. Filosofi utama Agile adalah: <em>&ldquo;Working software over comprehensive documentation&rdquo;</em> (Perangkat lunak yang berfungsi lebih diutamakan daripada dokumentasi yang menyeluruh).</p>

<p>Untuk bagian perencanaan dan pengembangan, ini berarti membuang birokrasi yang tidak perlu dan berfokus pada tiga alat komunikasi yang efisien: <strong>PRD Ringan, Wireframe, dan Kanban Board</strong>.</p>

<h2>1. PRD Ringan (Lightweight PRD): Fokus pada Nilai, Bukan Rincian Mati</h2>

<p>Jika PRD tradisional mencoba memprediksi setiap kemungkinan yang akan terjadi di masa depan, <strong>PRD Ringan (Lean PRD)</strong> dalam Agile hanya berfokus pada masalah saat ini dan iterasi terdekat.</p>

<p>PRD ringan tidak memuat spesifikasi teknis yang kaku, melainkan menggunakan format <em>User Story</em> yang sederhana:</p>

<blockquote><em>&ldquo;Sebagai [tipe pengguna], saya ingin [sebuah aksi] sehingga saya mendapatkan [manfaat/nilai].&rdquo;</em></blockquote>

<p><strong>Mengapa ini efektif?</strong></p>

<ul>
    <li><strong>Mencegah Over-Engineering:</strong> Tim hanya membangun apa yang benar-benar dibutuhkan saat ini.</li>
    <li><strong>Meningkatkan Agilitas:</strong> Jika ada perubahan kebijakan atau kebutuhan di tengah jalan, PRD ringan sangat mudah direvisi tanpa merombak seluruh dokumen proyek.</li>
    <li><strong>Justifikasi Terukur:</strong> Setiap fitur yang diajukan memiliki alasan (&ldquo;sehingga saya mendapatkan manfaat&rdquo;) yang jelas. Ini mempermudah validasi apakah suatu inisiatif benar-benar membawa dampak atau sekadar membuang-buang sumber daya.</li>
</ul>

<h2>2. Wireframe: Menggantikan Ribuan Kata dengan Satu Sketsa Kasar</h2>

<p>Manusia memproses informasi visual jauh lebih cepat daripada teks naratif. Daripada mendeskripsikan &ldquo;Tombol login berada di sudut kanan atas dengan warna biru&rdquo;, Agile lebih suka langsung menggambarnya.</p>

<p>Dalam pendekatan Agile, <strong>Wireframe</strong> (sketsa tata letak antarmuka tingkat rendah/kasar) bertindak sebagai penerjemah utama antara tim perencanaan, desainer, dan <em>developer</em>.</p>

<p><strong>Keunggulan Wireframe dalam Agile:</strong></p>

<ul>
    <li><strong>Feedback Instan:</strong> Pemangku kepentingan (<em>stakeholders</em>) bisa langsung melihat bentuk kasar aplikasi dan memberikan masukan sebelum desain final atau kode dibuat.</li>
    <li><strong>Kolaborasi Tanpa Sekat:</strong> Tim teknis dan non-teknis memiliki pemahaman visual yang sama tentang alur pengguna.</li>
    <li><strong>Iterasi Cepat:</strong> Sketsa bisa dicoret, dihapus, dan diubah posisinya dalam hitungan menit pada saat rapat perencanaan berlangsung.</li>
</ul>

<h2>3. Kanban Board: Transparansi Radikal Pengganti Laporan Status</h2>

<p>Ini adalah jantung dari eksekusi Agile. <strong>Kanban Board</strong> adalah papan visual (bisa fisik menggunakan <em>sticky notes</em>, atau digital menggunakan Trello/Jira) yang membagi pekerjaan ke dalam kolom-kolom status, biasanya: <strong>To Do</strong> (Akan Dikerjakan), <strong>In Progress</strong> (Sedang Dikerjakan), dan <strong>Done</strong> (Selesai).</p>

<p><strong>Kekuatan Utama Kanban:</strong></p>

<ul>
    <li><strong>Transparansi Penuh:</strong> Papan Kanban menciptakan lingkungan kerja yang sangat terbuka. Siapa mengerjakan apa, sampai tahap mana, dan apa yang menghambat proses (<em>bottleneck</em>) terlihat jelas oleh semua orang.</li>
    <li><strong>Akuntabilitas:</strong> Karena setiap tiket/tugas memiliki nama penanggung jawab dan status yang terlihat publik, sangat sulit bagi siapa pun untuk menyembunyikan inefisiensi, menunda pekerjaan tanpa alasan, atau memanipulasi alokasi waktu dan sumber daya. Semua terekam secara transparan.</li>
    <li><strong>Fokus pada Penyelesaian:</strong> Kanban membatasi jumlah pekerjaan yang boleh berstatus &ldquo;In Progress&rdquo;. Tim dipaksa untuk menyelesaikan satu tugas terlebih dahulu sebelum menarik tugas baru, mencegah penumpukan pekerjaan setengah jadi.</li>
</ul>

<h2>Sinergi Ketiganya dalam Praktik Nyata</h2>

<p>Bayangkan Anda sedang merancang sebuah sistem informasi pendaftaran atau portal donasi terintegrasi. Pendekatan Agile akan berjalan seperti ini:</p>

<ol>
    <li>Tim merumuskan <strong>PRD Ringan</strong> yang memuat <em>user story</em>: <em>&ldquo;Sebagai calon donatur, saya ingin melihat riwayat donasi saya agar saya tahu kemana dana saya tersalurkan.&rdquo;</em></li>
    <li>Tim desain membuat <strong>Wireframe</strong> sederhana yang menunjukkan halaman <em>dashboard</em> dengan tabel riwayat.</li>
    <li>Tugas &ldquo;Membangun Dashboard Donatur&rdquo; dimasukkan ke kolom <em>To Do</em> di <strong>Kanban Board</strong>. Saat <em>developer</em> mulai mengerjakannya, tiket dipindah ke <em>In Progress</em>. Semua orang di departemen tahu persis bahwa sumber daya saat ini sedang difokuskan ke fitur tersebut.</li>
</ol>

<h2>Kesimpulan</h2>

<p>Beralih ke Agile bukan berarti menghilangkan dokumentasi sepenuhnya, melainkan mengubah dokumentasi menjadi alat komunikasi yang hidup, visual, dan tepat sasaran. Kombinasi PRD yang ringkas, komunikasi visual melalui Wireframe, dan transparansi radikal dari Kanban Board tidak hanya mempercepat waktu peluncuran aplikasi, tetapi juga membangun budaya kerja yang sehat, akuntabel, dan bebas dari silo informasi.</p>

<hr>

<h2>📄 Template Lean PRD: Portal Edukasi &amp; Bank Naskah Terintegrasi</h2>

<p><strong>Informasi Dokumen</strong></p>

<ul>
    <li><strong>Nama Proyek:</strong> Portal Edukasi &amp; Bank Naskah Terintegrasi</li>
    <li><strong>Dokumen Owner:</strong> [Nama Anda / Posisi Anda]</li>
    <li><strong>Target Rilis:</strong> Q3 - 2026</li>
    <li><strong>Status:</strong> Draft / Sedang Direviu / Disetujui</li>
</ul>

<h3>1. Pernyataan Masalah (Problem Statement)</h3>

<p><em>Mengapa kita harus membangun ini? Apa masalah yang sedang dihadapi?</em></p>

<p>Saat ini, materi edukasi terkait literasi digital (seperti bahaya jejak digital dan <em>oversharing</em>) serta naskah-naskah ceramah/dakwah tersebar di berbagai platform yang tidak terpusat (WhatsApp, Google Drive pribadi). Hal ini menyulitkan pengajar untuk berbagi materi standar, dan siswa kesulitan menemukan referensi yang aman dan tervalidasi oleh yayasan.</p>

<h3>2. Tujuan &amp; Metrik Keberhasilan (Goals &amp; Success Metrics)</h3>

<p><em>Apa yang ingin dicapai dan bagaimana kita mengukur kesuksesannya?</em></p>

<ul>
    <li><strong>Tujuan Bisnis/Organisasi:</strong> Menciptakan satu pusat data digital (repositori) yang aman dan terstandardisasi untuk kebutuhan dakwah dan pendidikan internal yayasan.</li>
    <li><strong>Metrik Kesuksesan (KPI):</strong>
        <ul>
            <li>50 naskah ceramah dan 10 modul literasi digital diunggah dalam bulan pertama.</li>
            <li>Tingkat adopsi 70% dari total pengajar aktif dalam 3 bulan pertama setelah rilis.</li>
        </ul>
    </li>
</ul>

<h3>3. Pengguna Sasaran (Target Audience)</h3>

<p><em>Siapa yang akan menggunakan fitur ini?</em></p>

<ol>
    <li><strong>Pengajar/Ustadz:</strong> Membutuhkan akses cepat ke naskah referensi dan materi ajar.</li>
    <li><strong>Siswa/Santri:</strong> Membutuhkan bahan bacaan literasi digital dan referensi tugas.</li>
    <li><strong>Admin IT/Pusat:</strong> Bertugas memverifikasi konten sebelum dipublikasikan.</li>
</ol>

<h3>4. User Stories &amp; Spesifikasi Fitur (Core Features)</h3>

<p><em>Fitur apa saja yang akan dibuat untuk menyelesaikan masalah di atas?</em></p>

<table>
    <thead>
        <tr>
            <th>Prioritas</th>
            <th>User Story</th>
            <th>Kriteria Penerimaan (Acceptance Criteria)</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>P1 (Tinggi)</strong></td>
            <td>Sebagai <strong>Pengajar</strong>, saya ingin <strong>mengunggah dokumen naskah ceramah (PDF/Word)</strong>, agar <strong>bisa diakses oleh pengajar lain.</strong></td>
            <td>- Ada tombol &ldquo;Unggah Materi&rdquo;.<br>- Mendukung format .pdf dan .docx (maks 10MB).<br>- Wajib mengisi kategori (misal: Ramadan, Akhlak, Literasi Digital).</td>
        </tr>
        <tr>
            <td><strong>P1 (Tinggi)</strong></td>
            <td>Sebagai <strong>Admin</strong>, saya ingin <strong>memverifikasi draf materi yang diunggah</strong>, agar <strong>konten sesuai standar yayasan sebelum tayang.</strong></td>
            <td>- Admin memiliki dashboard &ldquo;Menunggu Persetujuan&rdquo;.<br>- Ada tombol &ldquo;Setujui&rdquo; atau &ldquo;Tolak&rdquo; beserta kolom catatan revisi.</td>
        </tr>
        <tr>
            <td><strong>P2 (Sedang)</strong></td>
            <td>Sebagai <strong>Siswa</strong>, saya ingin <strong>membaca modul jejak digital langsung di aplikasi</strong>, agar <strong>tidak perlu mengunduh file ke perangkat.</strong></td>
            <td>- Fitur <em>preview</em> dokumen (PDF Viewer) di dalam web/aplikasi.<br>- Ada tombol penanda &ldquo;Selesai Dibaca&rdquo;.</td>
        </tr>
        <tr>
            <td><strong>P3 (Rendah)</strong></td>
            <td>Sebagai <strong>Pengajar</strong>, saya ingin <strong>melihat metrik berapa kali naskah saya dibaca</strong>, agar <strong>saya tahu topik apa yang paling diminati.</strong></td>
            <td>- Terdapat angka <em>view counter</em> di bawah judul setiap materi.</td>
        </tr>
    </tbody>
</table>

<p><em>(Keterangan: P1 = Harus ada untuk rilis pertama/MVP, P2 = Penting tapi bisa menyusul, P3 = Fitur tambahan/Nice to have).</em></p>

<h3>5. Di Luar Cakupan (Out of Scope)</h3>

<p><em>Apa yang TIDAK akan kita kerjakan pada fase ini agar fokus tidak melebar?</em></p>

<ul>
    <li>Fitur <em>live streaming</em> ceramah tidak termasuk dalam fase ini.</li>
    <li>Pembuatan forum diskusi atau kolom komentar antar pengguna ditiadakan pada rilis pertama untuk menghindari kebutuhan moderasi yang rumit.</li>
</ul>

<h3>6. Kebutuhan Non-Fungsional (Non-Functional Requirements)</h3>

<p><em>Batasan teknis atau aturan operasional.</em></p>

<ul>
    <li><strong>Keamanan:</strong> Sistem harus menggunakan protokol HTTPS dan memastikan akses ke dokumen hanya bisa dilakukan oleh pengguna yang sudah <em>login</em> menggunakan akun institusi.</li>
    <li><strong>Performa:</strong> Dokumen PDF berukuran di bawah 5MB harus bisa dirender (ditampilkan) dalam waktu kurang dari 3 detik.</li>
</ul>

<hr>

<h3>Cara Menggunakan Template Ini:</h3>

<ol>
    <li><strong>Fokus pada iterasi:</strong> Jangan mencoba memasukkan semua ide fitur Anda ke bagian nomor 4. Cukup masukkan fitur-fitur yang paling esensial (P1) untuk rilis tahap pertama (MVP - <em>Minimum Viable Product</em>).</li>
    <li><strong>Kolaborasi:</strong> Bawa dokumen singkat ini saat rapat. Karena bentuknya tidak bertele-tele, tim desain dan <em>developer</em> bisa langsung membacanya dalam 5 menit dan memahami arah proyek.</li>
</ol>
',
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(50, 200),
        ]);

        $this->command->info('Agile PRD Wireframe Kanban Article created successfully!');
    }
}
