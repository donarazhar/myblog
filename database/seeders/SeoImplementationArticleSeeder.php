<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Article;

class SeoImplementationArticleSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('is_admin', true)->first();

        $category = Category::firstOrCreate(
            ['name' => 'Teknologi'],
            ['description' => 'Artikel tentang perkembangan teknologi']
        );

        Article::create([
            'title' => 'SEO Implementation Plan: Strategi Lengkap Agar Website Muncul di Halaman Pertama Google',
            'slug' => 'seo-implementation-plan-strategi-halaman-pertama-google',
            'excerpt' => 'Panduan lengkap implementasi SEO untuk website dan blog. Pelajari strategi teknis dan non-teknis agar website Anda muncul di halaman pertama pencarian Google, mulai dari XML Sitemap, JSON-LD, hingga Google Search Console.',
            'content' => '
<h2>🎯 Mengapa SEO Itu Penting?</h2>

<p>Pernahkah Anda membuat website yang bagus, menulis artikel berkualitas, tapi tidak ada yang mengunjungi? Masalahnya bukan konten Anda yang buruk — melainkan <strong>Google belum tahu website Anda ada</strong>.</p>

<p><strong>Search Engine Optimization (SEO)</strong> adalah serangkaian teknik untuk membuat website Anda mudah ditemukan dan mendapat peringkat tinggi di mesin pencari seperti Google. Tanpa SEO, website Anda ibarat toko di gang sempit tanpa papan nama — produknya bagus, tapi tidak ada yang tahu.</p>

<p>Dalam artikel ini, saya akan membagikan <strong>strategi SEO lengkap</strong> yang saya terapkan pada website <strong>donarazhar.site</strong> — mulai dari audit awal, implementasi teknis, hingga strategi konten. Semua ini bisa Anda terapkan juga untuk website Anda sendiri.</p>

<hr>

<h2>🔍 Langkah 1: Audit SEO — Kenali Kondisi Website Anda</h2>

<p>Sebelum melakukan optimasi, langkah pertama adalah <strong>audit SEO</strong> — mengecek apa yang sudah ada dan apa yang masih kurang. Berikut hasil audit yang saya lakukan:</p>

<h3>✅ Yang Sudah Ada</h3>
<ul>
    <li><strong>Meta Description</strong> — Deskripsi singkat yang muncul di hasil pencarian Google</li>
    <li><strong>Open Graph Tags</strong> — Untuk preview cantik saat link di-share ke Facebook/WhatsApp</li>
    <li><strong>Twitter Cards</strong> — Preview khusus untuk Twitter</li>
    <li><strong>Google Analytics</strong> — Tracking pengunjung dan perilaku user</li>
    <li><strong>robots.txt</strong> — File yang memberi tahu Google bot halaman mana yang boleh di-crawl</li>
</ul>

<h3>❌ Yang Belum Ada (dan Kritis!)</h3>
<ul>
    <li><strong>XML Sitemap</strong> — Peta seluruh halaman website untuk Google</li>
    <li><strong>JSON-LD Structured Data</strong> — Metadata terstruktur untuk rich snippets</li>
    <li><strong>Canonical URL</strong> — Menghindari duplikasi konten</li>
    <li><strong>Google Search Console</strong> — Dashboard untuk memantau performa di Google</li>
</ul>

<hr>

<h2>🗺️ Langkah 2: Implementasi XML Sitemap</h2>

<p><strong>XML Sitemap</strong> adalah file yang berisi daftar semua halaman penting di website Anda. File ini membantu Google untuk:</p>
<ul>
    <li>Menemukan halaman-halaman baru dengan cepat</li>
    <li>Mengetahui kapan halaman terakhir diperbarui</li>
    <li>Memahami struktur website Anda</li>
</ul>

<h3>Cara Implementasi</h3>
<p>Untuk website berbasis <strong>Laravel</strong>, saya membuat controller khusus yang menghasilkan sitemap secara dinamis. Setiap kali ada artikel baru, sitemap otomatis ter-update.</p>

<p>Sitemap yang baik harus mencakup:</p>
<ul>
    <li><strong>Halaman statis</strong>: Home, About, Contact, Articles</li>
    <li><strong>Halaman kategori</strong>: Setiap kategori artikel</li>
    <li><strong>Halaman artikel</strong>: Setiap artikel yang sudah dipublikasi, lengkap dengan tanggal terakhir diperbarui (<code>lastmod</code>)</li>
</ul>

<p>Setelah sitemap dibuat, Anda bisa mengaksesnya di <code>https://domainkamu.com/sitemap.xml</code> dan submit ke Google Search Console.</p>

<blockquote>
    <p>💡 <strong>Tips:</strong> Pastikan sitemap Anda selalu up-to-date. Jangan memasukkan halaman yang di-<code>noindex</code> atau halaman error ke dalam sitemap.</p>
</blockquote>

<hr>

<h2>📊 Langkah 3: Implementasi JSON-LD Structured Data</h2>

<p><strong>JSON-LD (JavaScript Object Notation for Linked Data)</strong> adalah format data terstruktur yang membantu Google memahami konten halaman Anda dengan lebih baik. Hasilnya?</p>

<ul>
    <li>Artikel Anda muncul dengan <strong>rich snippets</strong> di Google (ada gambar, author, tanggal)</li>
    <li><strong>Click-Through Rate (CTR)</strong> meningkat karena hasil pencarian lebih menarik</li>
    <li>Google lebih mudah mengkategorikan konten Anda</li>
</ul>

<h3>Schema yang Perlu Ditambahkan</h3>

<p><strong>1. WebSite Schema</strong> — Ditambahkan di layout utama website:</p>
<ul>
    <li>Nama website</li>
    <li>URL utama</li>
    <li>Deskripsi website</li>
    <li>SearchAction (untuk sitelinks searchbox)</li>
</ul>

<p><strong>2. Article Schema</strong> — Ditambahkan di setiap halaman artikel:</p>
<ul>
    <li>Judul artikel (headline)</li>
    <li>Deskripsi singkat</li>
    <li>Nama author dan publisher</li>
    <li>Tanggal publikasi dan terakhir diperbarui</li>
    <li>Gambar utama artikel</li>
    <li>URL halaman</li>
</ul>

<p><strong>3. BreadcrumbList Schema</strong> — Untuk navigasi breadcrumb di hasil pencarian:</p>
<ul>
    <li>Home → Articles → Nama Kategori → Judul Artikel</li>
</ul>

<blockquote>
    <p>💡 <strong>Validasi:</strong> Setelah implementasi, gunakan <a href="https://search.google.com/test/rich-results" target="_blank" rel="noopener">Google Rich Results Test</a> untuk memastikan structured data Anda terdeteksi dengan benar.</p>
</blockquote>

<hr>

<h2>🔗 Langkah 4: Canonical URL dan Meta Tags</h2>

<p><strong>Canonical URL</strong> memberi tahu Google halaman mana yang merupakan versi "asli" dari konten Anda. Ini penting untuk menghindari masalah <strong>duplicate content</strong>, misalnya ketika URL yang sama bisa diakses dengan dan tanpa trailing slash, atau dengan parameter query string.</p>

<h3>Yang Perlu Ditambahkan</h3>
<ul>
    <li><code>&lt;link rel="canonical" href="URL_HALAMAN"&gt;</code> — Di setiap halaman</li>
    <li><code>&lt;meta name="robots" content="index, follow"&gt;</code> — Memberi tahu Google untuk mengindex halaman</li>
    <li><code>&lt;meta name="author" content="NAMA_ANDA"&gt;</code> — Credit penulis</li>
</ul>

<hr>

<h2>🤖 Langkah 5: Optimasi robots.txt</h2>

<p>File <code>robots.txt</code> terletak di root website dan memberi instruksi kepada bot search engine. Berikut konfigurasi yang ideal:</p>

<ul>
    <li><strong>Allow semua bot</strong> untuk crawl halaman publik</li>
    <li><strong>Block halaman admin</strong> (<code>Disallow: /admin/</code>) agar tidak muncul di Google</li>
    <li><strong>Tambahkan referensi sitemap</strong> (<code>Sitemap: https://domainkamu.com/sitemap.xml</code>) agar Google langsung tahu lokasi sitemap</li>
</ul>

<hr>

<h2>📈 Langkah 6: Google Search Console (WAJIB!)</h2>

<p><strong>Google Search Console</strong> adalah tool GRATIS dari Google yang WAJIB Anda gunakan. Ini adalah dashboard untuk memantau bagaimana Google melihat website Anda.</p>

<h3>Cara Setup</h3>
<ol>
    <li>Buka <a href="https://search.google.com/search-console" target="_blank" rel="noopener">Google Search Console</a></li>
    <li>Tambah property dengan URL website Anda</li>
    <li>Verifikasi kepemilikan (bisa via DNS record, upload file HTML, atau meta tag)</li>
    <li>Submit sitemap: masukkan URL <code>/sitemap.xml</code></li>
</ol>

<h3>Yang Bisa Dipantau</h3>
<ul>
    <li><strong>Performance</strong> — Jumlah klik, impressions, CTR, dan posisi rata-rata di Google</li>
    <li><strong>Coverage/Indexing</strong> — Halaman mana yang sudah ter-index dan mana yang error</li>
    <li><strong>URL Inspection</strong> — Cek status indexing halaman tertentu dan request indexing manual</li>
    <li><strong>Sitemaps</strong> — Status submit sitemap</li>
    <li><strong>Core Web Vitals</strong> — Performa loading halaman</li>
</ul>

<blockquote>
    <p>⚡ <strong>Pro tip:</strong> Setiap kali Anda mempublikasikan artikel baru, gunakan <strong>URL Inspection → Request Indexing</strong> agar Google segera mengcrawl artikel tersebut.</p>
</blockquote>

<hr>

<h2>✍️ Langkah 7: Strategi Konten SEO</h2>

<p>Implementasi teknis saja tidak cukup. <strong>Konten adalah raja</strong> dalam SEO. Berikut strategi konten yang efektif:</p>

<h3>1. Riset Keyword</h3>
<p>Sebelum menulis artikel, riset keyword yang relevan menggunakan:</p>
<ul>
    <li><a href="https://ads.google.com/home/tools/keyword-planner/" target="_blank" rel="noopener">Google Keyword Planner</a> (gratis)</li>
    <li><a href="https://neilpatel.com/ubersuggest/" target="_blank" rel="noopener">Ubersuggest</a> (freemium)</li>
    <li><strong>Google Search autocomplete</strong> — Ketik topik di Google dan lihat saran pencarian</li>
</ul>

<h3>2. Optimasi Judul dan Excerpt</h3>
<ul>
    <li>Masukkan <strong>keyword utama</strong> di judul artikel</li>
    <li>Buat excerpt yang menarik dan mengandung keyword (maks 160 karakter)</li>
    <li>Gunakan judul yang memancing klik, misalnya: "7 Cara...", "Panduan Lengkap...", "Mengapa..."</li>
</ul>

<h3>3. Struktur Konten yang Baik</h3>
<ul>
    <li>Gunakan heading (<code>H2</code>, <code>H3</code>) untuk membagi konten</li>
    <li>Paragraf pendek (2-3 kalimat per paragraf)</li>
    <li>Gunakan <strong>bullet points</strong> dan <strong>numbered lists</strong></li>
    <li>Tambahkan gambar dengan <strong>alt text</strong> yang relevan</li>
</ul>

<h3>4. Internal Linking</h3>
<p>Tambahkan link ke artikel lain di website Anda dalam konten. Ini membantu:</p>
<ul>
    <li>Google memahami hubungan antar konten</li>
    <li>Pengunjung menemukan konten relevan lainnya</li>
    <li>Menurunkan bounce rate</li>
</ul>

<h3>5. Konsistensi Posting</h3>
<p>Google menyukai website yang aktif. Targetkan minimal <strong>1-2 artikel per minggu</strong> dengan kualitas yang konsisten.</p>

<hr>

<h2>🌐 Langkah 8: Off-Page SEO — Backlinks</h2>

<p><strong>Backlinks</strong> (link dari website lain ke website Anda) adalah salah satu faktor ranking terpenting di Google. Berikut cara mendapatkannya:</p>

<h3>Strategi Mendapatkan Backlinks</h3>
<ul>
    <li><strong>Share di media sosial</strong> — WhatsApp, LinkedIn, Facebook, Twitter</li>
    <li><strong>Submit ke forum dan komunitas</strong> — Kaskus, Medium, Dev.to, komunitas IT</li>
    <li><strong>Guest blogging</strong> — Tulis artikel untuk website lain dengan link balik ke website Anda</li>
    <li><strong>Buat konten yang "link-worthy"</strong> — Tutorial, infografis, atau data unik yang orang ingin bagikan</li>
    <li><strong>Daftar di direktori</strong> — Google Business Profile, Bing Places, Yellow Pages</li>
</ul>

<hr>

<h2>⚡ Langkah 9: Technical SEO — Kecepatan & Mobile</h2>

<p>Google juga mempertimbangkan <strong>kecepatan website</strong> dan <strong>mobile-friendliness</strong> dalam ranking:</p>

<h3>Optimasi Kecepatan</h3>
<ul>
    <li><strong>Kompres gambar</strong> — Gunakan format WebP atau tool seperti TinyPNG</li>
    <li><strong>Minify CSS & JavaScript</strong> — Kurangi ukuran file</li>
    <li><strong>Browser caching</strong> — Set header cache yang tepat</li>
    <li><strong>CDN (Content Delivery Network)</strong> — Gunakan Cloudflare untuk distribusi konten global</li>
    <li><strong>Lazy loading images</strong> — Gambar hanya dimuat saat terlihat di layar</li>
</ul>

<h3>Mobile-Friendly</h3>
<ul>
    <li>Pastikan desain <strong>responsive</strong> di semua ukuran layar</li>
    <li>Test di <a href="https://search.google.com/test/mobile-friendly" target="_blank" rel="noopener">Google Mobile-Friendly Test</a></li>
    <li>Perhatikan ukuran font, jarak antar elemen, dan ukuran tap target</li>
</ul>

<h3>HTTPS</h3>
<p>Pastikan website menggunakan <strong>HTTPS</strong> (sertifikat SSL). Google memberikan preferensi ranking untuk website yang aman. Cloudflare menyediakan SSL gratis.</p>

<hr>

<h2>📋 Checklist SEO Lengkap</h2>

<p>Gunakan checklist ini untuk memastikan semua aspek SEO sudah dipenuhi:</p>

<h3>Technical SEO</h3>
<ul>
    <li>☑️ XML Sitemap dibuat dan bisa diakses</li>
    <li>☑️ robots.txt dikonfigurasi dengan benar</li>
    <li>☑️ JSON-LD Structured Data ditambahkan</li>
    <li>☑️ Canonical URL di setiap halaman</li>
    <li>☑️ Meta description unik per halaman</li>
    <li>☑️ Open Graph & Twitter Cards aktif</li>
    <li>☑️ HTTPS aktif</li>
    <li>☑️ Website responsive/mobile-friendly</li>
    <li>☑️ Kecepatan loading optimal</li>
</ul>

<h3>Google Search Console</h3>
<ul>
    <li>☑️ Website terverifikasi</li>
    <li>☑️ Sitemap ter-submit</li>
    <li>☑️ Tidak ada error indexing</li>
    <li>☑️ Request indexing untuk artikel baru</li>
</ul>

<h3>Konten</h3>
<ul>
    <li>☑️ Keyword research dilakukan</li>
    <li>☑️ Judul mengandung keyword utama</li>
    <li>☑️ Excerpt singkat dan menarik</li>
    <li>☑️ Heading terstruktur (H1, H2, H3)</li>
    <li>☑️ Internal linking antar artikel</li>
    <li>☑️ Gambar dengan alt text</li>
    <li>☑️ Konsistensi posting</li>
</ul>

<hr>

<h2>🏁 Kesimpulan</h2>

<p>SEO bukanlah pekerjaan sekali jadi. Ini adalah <strong>proses berkelanjutan</strong> yang membutuhkan konsistensi dan kesabaran. Biasanya dibutuhkan <strong>3-6 bulan</strong> untuk melihat hasil signifikan.</p>

<p>Yang terpenting adalah memulai dari fondasi yang benar:</p>
<ol>
    <li><strong>Technical SEO</strong> — Pastikan Google bisa menemukan dan memahami website Anda</li>
    <li><strong>Konten berkualitas</strong> — Tulis konten yang benar-benar bermanfaat bagi pembaca</li>
    <li><strong>Promosi</strong> — Sebarkan konten Anda agar mendapat backlinks dan traffic</li>
    <li><strong>Monitoring</strong> — Pantau performa di Google Search Console dan optimalkan terus</li>
</ol>

<p>Semoga panduan ini bermanfaat. Jika Anda memiliki pertanyaan tentang SEO, jangan ragu untuk menghubungi saya melalui halaman <a href="/contact">Contact</a>. Mari bersama-sama belajar dan membangun web yang lebih baik! 🚀</p>

<p><em>Wallahu a\'lam bishawab.</em></p>
',
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(50, 200),
        ]);
    }
}
