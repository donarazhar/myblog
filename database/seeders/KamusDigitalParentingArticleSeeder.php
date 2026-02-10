<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class KamusDigitalParentingArticleSeeder extends Seeder
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

        // Create Kamus Digital Parenting article
        Article::create([
            'title' => 'Kamus Digital Parenting: Istilah Wajib Tahu Demi Keamanan Siber Anak',
            'slug' => 'kamus-digital-parenting',
            'excerpt' => 'Panduan lengkap istilah-istilah digital yang wajib dipahami orang tua. Mulai dari FYP, FOMO, Doomscrolling, hingga Grooming dan Phishing — kenali bahasa dunia maya agar anak tetap aman.',
            'content' => '
<p>Anak-anak hidup di dunia digital yang memiliki <strong>bahasanya sendiri</strong>. Sebagai orang tua, memahami istilah-istilah ini adalah langkah awal untuk melindungi anak dari bahaya siber. Artikel ini merangkum istilah-istilah penting yang wajib diketahui, dikelompokkan dalam 4 pilar utama.</p>

<h2>1. Mekanisme Media Sosial (Apa yang Anak Lihat)</h2>

<h3>FYP (For You Page) / Algoritma</h3>
<p>FYP adalah halaman rekomendasi di platform seperti TikTok dan Instagram yang secara otomatis menyesuaikan konten berdasarkan minat pengguna. Algoritma ini mempelajari apa yang ditonton, di-like, dan dibagikan anak.</p>
<p><strong>💡 Tips:</strong> Cek FYP anak sesekali. Jika banyak konten negatif, berarti itu yang sering mereka lihat dan konsumsi sehari-hari.</p>

<h3>Viral / Trending</h3>
<p>Konten yang menyebar sangat cepat dalam waktu singkat. Konten viral bisa berupa hal positif maupun negatif.</p>
<p><strong>⚠️ Waspada:</strong> Hati-hati terhadap <em>"Challenge"</em> berbahaya yang mungkin ingin ditiru anak demi ikut-ikutan tren.</p>

<h3>Hashtag (#)</h3>
<p>Label kata kunci yang digunakan untuk mengelompokkan konten agar mudah dicari dan ditemukan pengguna lain.</p>
<p><strong>💡 Tips:</strong> Ajarkan anak untuk tidak menggunakan hashtag yang mengandung informasi pribadi (seperti #SekolahDiRumah dengan lokasi jelas) demi menjaga privasi.</p>

<h2>2. Kesehatan Mental & Perilaku (Apa yang Anak Rasakan)</h2>

<h3>FOMO (Fear of Missing Out)</h3>
<p>Rasa cemas dan gelisah karena merasa "ketinggalan zaman" jika tidak online atau tidak mengikuti tren terbaru.</p>
<p><strong>❤️ Dampak:</strong> Anak menjadi gelisah, cemas berlebihan, dan merasa tidak percaya diri jika tidak terus-menerus terhubung.</p>

<h3>Doomscrolling</h3>
<p>Kebiasaan terus menerus menggulir layar tanpa henti untuk membaca berita buruk atau konten negatif, meskipun membuat perasaan semakin buruk.</p>
<p><strong>❤️ Dampak:</strong> Meningkatkan tingkat stres dan kecemasan secara signifikan pada anak.</p>

<h3>Screen Time</h3>
<p>Total durasi waktu yang dihabiskan anak untuk menatap layar gawai setiap harinya, termasuk HP, tablet, dan laptop.</p>
<p><strong>✅ Solusi:</strong> Gunakan fitur <strong>Parental Control</strong> untuk membatasi durasi penggunaan gawai agar kehidupan anak tetap seimbang antara dunia nyata dan digital.</p>

<h2>3. Komunikasi & Privasi (Cara Anak Berinteraksi)</h2>

<h3>DM (Direct Message)</h3>
<p>Pesan jalur pribadi yang dikirim langsung antar pengguna tanpa bisa dilihat oleh publik.</p>
<p><strong>🚨 Bahaya:</strong> Predator online sering menggunakan DM untuk mendekati anak secara diam-diam. Ingatkan anak untuk <strong>tidak pernah membalas pesan dari orang asing</strong>.</p>

<h3>Second Account (Akun Kedua)</h3>
<p>Akun alternatif yang dibuat anak untuk berekspresi lebih bebas tanpa pengawasan orang tua atau teman.</p>
<p><strong>🔍 Pahami:</strong> Apa yang ditampilkan di akun utama mungkin hanya pencitraan. <strong>Jati diri asli</strong> anak mungkin tersembunyi di akun keduanya.</p>

<h3>Tag & Share Location</h3>
<p>Fitur untuk menandai orang lain dalam postingan atau membagikan lokasi terkini secara <em>real-time</em>.</p>
<p><strong>🚫 Aturan Tegas:</strong> Larang anak melakukan tag lokasi <strong>rumah atau sekolah</strong> secara <em>real-time</em>. Ini bisa dimanfaatkan oleh orang yang berniat jahat.</p>

<h2>4. Bahaya Digital (Apa yang Harus Dihindari)</h2>

<h3>⚠️ Grooming (Pencabulan Terencana)</h3>
<p>Upaya orang dewasa membangun kepercayaan dengan anak secara bertahap untuk tujuan manipulasi atau pelecehan seksual. Proses ini bisa berlangsung berminggu-minggu hingga berbulan-bulan.</p>
<p><strong>🔍 Tanda-Tanda:</strong> Anak menerima <strong>hadiah dari orang asing</strong> secara online, diminta mengirimkan foto pribadi, atau memiliki "teman online" yang sangat dekat namun dirahasiakan.</p>

<h3>⚠️ Cyberbullying (Perundungan Siber)</h3>
<p>Perundungan lewat media digital dalam berbagai bentuk: komentar jahat, penyebaran aib, ancaman, pengucilan online, atau pembuatan akun palsu.</p>
<p><strong>🔍 Tanda-Tanda:</strong> Anak tiba-tiba <strong>murung, takut membuka HP</strong>, menarik diri dari pergaulan, prestasi menurun drastis, atau menghindari aktivitas online yang biasanya disukai.</p>

<h3>⚠️ Phishing / Scam (Penipuan Online)</h3>
<p>Penipuan online melalui <strong>link palsu</strong> yang bertujuan mencuri data pribadi seperti password, data kartu, dan informasi sensitif lainnya.</p>
<p><strong>Modus yang sering digunakan:</strong></p>
<ul>
    <li>Mengirimkan link hadiah atau voucher game gratis</li>
    <li>Peringatan keamanan palsu dari "platform resmi"</li>
    <li>Pesan menang undian atau giveaway palsu</li>
    <li>Link login palsu yang menyerupai situs asli</li>
</ul>
<p><strong>📚 Edukasi ke Anak:</strong> Jangan pernah klik link aneh yang menjanjikan hadiah instan. Selalu verifikasi sumber link sebelum membukanya, dan biasakan bertanya ke orang tua terlebih dahulu.</p>

<h2>Kesimpulan: Jadilah Orang Tua yang "Connected"</h2>

<p>Keamanan siber anak dimulai dari <strong>pemahaman orang tua</strong> terhadap istilah dan mekanisme dunia digital. Dua langkah sederhana yang bisa dimulai hari ini:</p>
<ol>
    <li><strong>Cek gadget anak secara berkala</strong> — lihat aplikasi yang digunakan dan pantau aktivitas online mereka.</li>
    <li><strong>Bangun komunikasi terbuka</strong> — agar anak berani melapor jika terjadi sesuatu yang tidak nyaman di dunia digital.</li>
</ol>

<p>Untuk informasi lebih lanjut, kunjungi <strong>tunasdigital.id/orang-tua</strong>.</p>

<p><em>Materi ini disarikan dari program We Are Connected — Information Technology YPI Al Azhar.</em></p>
',
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(50, 200),
        ]);

        $this->command->info('Kamus Digital Parenting Article created successfully!');
    }
}
