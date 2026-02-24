<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class JejakDigitalLpdpArticleSeeder extends Seeder
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

        // Create Jejak Digital LPDP article
        Article::create([
            'title' => 'Jejak Digital Tak Bisa Dihapus: Pelajaran Berharga dari Kasus Viral LPDP',
            'slug' => 'jejak-digital-tak-bisa-dihapus-pelajaran-berharga-dari-kasus-viral-lpdp',
            'excerpt' => 'Kasus viral awardee LPDP menjadi pelajaran berharga tentang bahaya multitafsir di media sosial, kekuatan persepsi publik, dan pentingnya menjaga jejak digital sebagai "tato virtual" yang tidak bisa dihapus.',
            'content' => '
<h2>Pelajaran Mahal dari Kasus Viral LPDP: Ketika Jempol Lebih Cepat dari Nalar</h2>

<p>Jagat maya belakangan ini diramaikan oleh kasus viral seorang <em>awardee</em> (penerima beasiswa) LPDP yang membagikan status mengenai anak-anaknya yang mendapatkan kewarganegaraan asing (Inggris), disertai pernyataan yang dianggap merendahkan status Warga Negara Indonesia (WNI).</p>

<p>Kasus ini memicu gelombang reaksi keras dari publik. Bukan sekadar masalah pilihan pribadi mengenai kewarganegaraan anak, melainkan adanya benturan etika yang kuat mengingat yang bersangkutan menempuh pendidikan tinggi dengan biaya dari uang pajak rakyat Indonesia.</p>

<p>Namun, di luar drama dan keriuhan komentar netizen, peristiwa ini adalah <strong>momentum emas untuk belajar</strong>. Kasus ini adalah studi kasus nyata yang sempurna tentang bagaimana kita seharusnya berinteraksi di era digital.</p>

<p>Berikut adalah ulasan komprehensif mengenai pelajaran penting yang bisa kita ambil dari infografis dan kasus tersebut:</p>

<h3>1. Satu Pernyataan, Seribu Penilaian (Bahaya Multitafsir)</h3>

<p>Di dunia nyata, saat kita berbicara, lawan bicara kita bisa melihat ekspresi wajah, mendengar nada suara, dan memahami konteks situasi. Di media sosial, semua itu hilang. Yang tersisa hanyalah teks atau video pendek yang dingin.</p>

<p>Seperti yang digambarkan dalam infografis, <strong>&ldquo;1 Pernyataan bisa dimaknai berbeda.&rdquo;</strong></p>

<ul>
    <li><strong>Niat Pengunggah:</strong> Mungkin si pengunggah awalnya hanya berniat mengekspresikan &ldquo;kebanggaan pribadi&rdquo; atas pencapaian keluarganya mendapatkan status legal di negara maju. Bagi dia, itu adalah bentuk kesuksesan.</li>
    <li><strong>Penerimaan Publik:</strong> Namun, publik menangkap pesan yang sama sekali berbeda. Bagi masyarakat luas&mdash;terutama pembayar pajak yang mendanai beasiswanya&mdash;pernyataan tersebut terdengar arogan, tidak bersyukur, dan memicu pertanyaan serius mengenai identitas serta nasionalismenya sebagai anak bangsa yang telah dibiayai negara.</li>
</ul>

<p><strong>Pelajaran:</strong> Di internet, apa yang Anda maksudkan belum tentu sama dengan apa yang ditangkap oleh audiens. Pahami siapa audiens Anda dan bagaimana posisi sosial Anda sebelum mengunggah sesuatu yang sensitif.</p>

<h3>2. Realitas Internet: Persepsi Berlari Lebih Cepat dari Klarifikasi</h3>

<p>Salah satu hukum tak tertulis di internet adalah: <strong>Berita buruk dan kontroversi menyebar secepat kilat.</strong></p>

<p>Saat sebuah unggahan menjadi viral karena alasan negatif, bola salju opini publik bergulir tak terkendali. Ribuan komentar, penghakiman, dan asumsi bermunculan dalam hitungan menit. Dalam situasi seperti ini, <strong>klarifikasi sering kali tidak berguna.</strong></p>

<p>Mengapa? Karena persepsi publik sudah terbentuk lebih dulu. Klarifikasi yang datang belakangan sering kali dianggap sebagai pembelaan diri semata atau bahkan tidak dibaca sama sekali oleh mereka yang sudah terlanjur marah.</p>

<p><strong>Pelajaran:</strong> Mencegah jauh lebih baik daripada mengklarifikasi. Pikirkan potensi ledakan sebelum menekan tombol &ldquo;kirim&rdquo;.</p>

<h3>3. Jejak Digital Adalah &ldquo;Tato Virtual&rdquo;</h3>

<p>Poin paling krusial dari infografis ini adalah: <strong>&ldquo;Jangan berulah, jejak digitalmu akan nggak bisa diubah.&rdquo;</strong></p>

<p>Banyak orang lupa bahwa internet adalah arsip raksasa yang permanen. Anda mungkin bisa menghapus unggahan asli di akun Anda, tetapi Anda tidak bisa menghapus tangkapan layar (<em>screenshot</em>) yang sudah disimpan oleh ribuan orang lain.</p>

<p>Setiap unggahan, komentar, foto, dan video yang Anda bagikan adalah jejak digital. Kumpulan jejak ini membentuk <strong>reputasi online</strong> Anda. Reputasi ini kini menjadi aset yang sangat berharga. Institusi pemberi beasiswa, calon perusahaan tempat Anda melamar kerja, hingga calon mitra bisnis, semuanya kini melakukan pengecekan jejak digital.</p>

<p>Dalam kasus viral ini, jejak digital tersebut tidak hanya merusak reputasi pribadi, tetapi juga memicu investigasi institusi (LPDP dan Kemenkeu) yang berpotensi berujung pada sanksi berat.</p>

<p><strong>Pelajaran:</strong> Perlakukan setiap unggahan di media sosial sebagai pernyataan resmi yang akan melekat pada nama baik Anda selamanya.</p>

<h2>Kesimpulan: Saring Sebelum <em>Sharing</em></h2>

<p>Kasus viral penerima beasiswa LPDP ini seharusnya menjadi alarm bagi kita semua. Kecerdasan akademik tidak serta merta menjamin kecerdasan bermedia sosial (literasi digital).</p>

<p>Mari jadikan ini pelajaran bersama. Sebelum membagikan konten apa pun di ruang publik maya, aktifkan &ldquo;filter mental&rdquo; di kepala kita. Ajukan pertanyaan sederhana ini pada diri sendiri:</p>

<ol>
    <li>Apakah konten ini pantas diketahui publik luas?</li>
    <li>Apakah konten ini berpotensi menyinggung pihak lain atau mencederai institusi yang menaungi saya?</li>
    <li>Apakah ini cerminan diri yang baik yang ingin saya tunjukkan pada dunia di masa depan?</li>
</ol>

<p>Jika jawabannya meragukan, lebih baik simpan untuk diri sendiri. Ingat pesan terakhir di infografis: <strong>Bijak berinternet hari ini, menyelamatkan reputasimu esok hari.</strong></p>
',
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(50, 200),
        ]);

        $this->command->info('Jejak Digital LPDP Article created successfully!');
    }
}
