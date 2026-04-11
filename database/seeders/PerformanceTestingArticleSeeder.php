<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class PerformanceTestingArticleSeeder extends Seeder
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

        // Create Performance Testing article
        Article::create([
            'title' => 'Menguasai Performance Testing: Panduan Lengkap agar Aplikasi Anda Tidak Hanya Jalan, Tapi Juga Tangguh dan Cepat',
            'slug' => 'menguasai-performance-testing-panduan-lengkap-agar-aplikasi-tangguh-dan-cepat',
            'excerpt' => 'Banyak developer berhenti saat fitur sudah "jalan". Padahal, aplikasi yang fungsional tapi lambat adalah resep jitu untuk ditinggalkan pengguna. Pelajari panduan lengkap performance testing mulai dari dasar, tools, simulasi traffic, deteksi bottleneck, hingga cara memonetisasi keahlian ini.',
            'content' => '
<p>Banyak developer berhenti saat fitur sudah &ldquo;jalan&rdquo;. Padahal, aplikasi yang fungsional tapi lambat adalah resep jitu untuk ditinggalkan pengguna. Menurut <strong>Google</strong>, <em>53% pengguna mobile meninggalkan website yang membutuhkan lebih dari 3 detik untuk dimuat</em>. Di era sekarang, kecepatan bukan lagi sebuah <em>bonus</em>, melainkan <em>kebutuhan</em> yang menentukan keberhasilan atau kegagalan produk digital Anda.</p>

<p>Berikut adalah panduan untuk menguasai <em>performance testing</em> agar aplikasi Anda tidak hanya berfungsi, tapi juga tangguh dan cepat.</p>

<h2>⚡ 1. Dasar-Dasar Performance Testing</h2>

<p>Sebelum memulai, Anda harus tahu apa yang ingin diukur. Jangan sekadar mengetes tanpa metrik yang jelas. <em>Performance testing</em> adalah proses menguji perilaku sistem di bawah berbagai kondisi beban kerja untuk memastikan kestabilan, kecepatan, dan skalabilitasnya.</p>

<p>Ada beberapa jenis pengujian performa yang perlu Anda pahami:</p>

<table>
    <thead>
        <tr>
            <th>Jenis Testing</th>
            <th>Tujuan</th>
            <th>Kapan Digunakan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>Load Testing</strong></td>
            <td>Mengukur performa saat diakses oleh jumlah pengguna yang diperkirakan dalam kondisi normal.</td>
            <td>Sebelum <em>launch</em> produk atau fitur baru.</td>
        </tr>
        <tr>
            <td><strong>Stress Testing</strong></td>
            <td>Mencari titik hancur (<em>breaking point</em>) dengan memberikan beban di luar batas normal.</td>
            <td>Saat ingin mengetahui batas maksimal kapasitas server.</td>
        </tr>
        <tr>
            <td><strong>Endurance Testing</strong> (Soak Testing)</td>
            <td>Mengecek apakah performa menurun setelah aplikasi berjalan dalam waktu lama (mencari kebocoran memori).</td>
            <td>Untuk aplikasi yang berjalan 24/7 seperti SaaS atau e-commerce.</td>
        </tr>
        <tr>
            <td><strong>Spike Testing</strong></td>
            <td>Menguji respons sistem saat terjadi lonjakan pengguna secara tiba-tiba.</td>
            <td>Menjelang event besar seperti flash sale atau peluncuran produk.</td>
        </tr>
        <tr>
            <td><strong>Scalability Testing</strong></td>
            <td>Mengukur kemampuan sistem untuk bertumbuh seiring penambahan sumber daya.</td>
            <td>Saat merencanakan infrastruktur jangka panjang.</td>
        </tr>
    </tbody>
</table>

<h3>Metrik Utama yang Harus Anda Pantau</h3>

<p>Tanpa metrik yang jelas, testing hanyalah buang waktu. Fokus pada metrik-metrik berikut:</p>

<ul>
    <li><strong>Response Time (Latency):</strong> Berapa lama server membalas permintaan. Idealnya di bawah <strong>200ms</strong> untuk API dan di bawah <strong>1 detik</strong> untuk halaman web.</li>
    <li><strong>Throughput:</strong> Berapa banyak <em>request</em> yang bisa diproses per detik (RPS). Semakin tinggi, semakin baik.</li>
    <li><strong>Error Rate:</strong> Persentase permintaan yang gagal. Target idealnya adalah <strong>di bawah 1%</strong>.</li>
    <li><strong>TTFB (Time to First Byte):</strong> Waktu dari saat browser mengirim permintaan hingga menerima byte pertama dari server. Ini indikator awal kesehatan backend Anda.</li>
    <li><strong>Concurrent Users:</strong> Jumlah pengguna yang bisa dilayani secara bersamaan tanpa penurunan performa signifikan.</li>
</ul>

<h2>📊 2. Tools untuk Mengukur Performa</h2>

<p>Setiap aspek aplikasi membutuhkan alat ukur yang berbeda. Berikut pembagiannya berdasarkan layer:</p>

<h3>A. Frontend (Browser Level)</h3>

<ul>
    <li><strong>Lighthouse:</strong> Standar industri dari Google untuk mengecek <em>Core Web Vitals</em> (LCP, FID, CLS). Tersedia langsung di Chrome DevTools, bisa juga dijalankan via CLI atau sebagai modul Node.js untuk integrasi ke CI/CD.</li>
    <li><strong>PageSpeed Insights:</strong> Memberikan laporan komprehensif mengenai pengalaman pengguna di desktop dan mobile, lengkap dengan rekomendasi perbaikan spesifik.</li>
    <li><strong>WebPageTest:</strong> Tool <em>open-source</em> yang memungkinkan Anda menguji dari berbagai lokasi dan koneksi. Sangat berguna untuk melihat <em>waterfall chart</em> loading resource.</li>
</ul>

<h3>B. Backend & API (Load Level)</h3>

<ul>
    <li><strong>k6 (Grafana k6):</strong> Sangat modern, berbasis JavaScript, dan ringan. Cocok untuk tim yang ingin mengintegrasikan tes ke dalam pipeline CI/CD. Contoh script sederhana:
        <br><br>
        <code>import http from &apos;k6/http&apos;;</code><br>
        <code>import { check, sleep } from &apos;k6&apos;;</code><br>
        <code>export const options = { vus: 100, duration: &apos;30s&apos; };</code><br>
        <code>export default function () {</code><br>
        <code>&nbsp;&nbsp;const res = http.get(&apos;https://api.example.com/products&apos;);</code><br>
        <code>&nbsp;&nbsp;check(res, { &apos;status is 200&apos;: (r) =&gt; r.status === 200 });</code><br>
        <code>&nbsp;&nbsp;sleep(1);</code><br>
        <code>}</code>
    </li>
    <li><strong>JMeter:</strong> Tool &ldquo;legendaris&rdquo; dari Apache yang sangat <em>powerful</em> untuk skenario pengujian yang kompleks. Mendukung berbagai protokol (HTTP, JDBC, LDAP, SOAP) dan memiliki GUI untuk membangun test plan.</li>
    <li><strong>Artillery:</strong> Alternatif modern yang mendukung pengujian HTTP, WebSocket, dan Socket.io. YAML-based configuration membuatnya mudah dibaca.</li>
</ul>

<h3>C. Monitoring & Observability</h3>

<ul>
    <li><strong>Sentry:</strong> Untuk error tracking dan performance monitoring secara <em>real-time</em>. Sangat berguna untuk mendeteksi <em>slow transaction</em> di produksi.</li>
    <li><strong>New Relic / Datadog:</strong> Platform observability lengkap untuk melihat apa yang terjadi di sisi server, database, dan infrastruktur. Menyediakan APM (Application Performance Monitoring) yang detail.</li>
    <li><strong>Laravel Telescope:</strong> Khusus untuk developer Laravel, ini adalah alat debug dan monitoring yang sangat kuat untuk melihat query, request, job, dan exception secara detail di environment lokal.</li>
</ul>

<h2>🚀 3. Simulasi Traffic: Menghadirkan Kondisi Real</h2>

<p>Testing di lingkungan lokal (<em>localhost</em>) tidak pernah mencerminkan realitas. Server lokal biasanya memiliki latensi mendekati 0ms, tidak ada <em>network congestion</em>, dan hanya satu pengguna. Berikut cara membuat simulasi yang lebih realistis:</p>

<h3>A. User Journey Simulation</h3>

<p>Jangan hanya menembak satu URL (misalnya <em>homepage</em>). Simulasikan alur pengguna yang sesungguhnya:</p>

<ol>
    <li><strong>E-commerce:</strong> <em>Login &rarr; Cari Barang &rarr; Lihat Detail &rarr; Tambah ke Keranjang &rarr; Checkout &rarr; Pembayaran</em></li>
    <li><strong>SaaS:</strong> <em>Login &rarr; Buka Dashboard &rarr; Filter Data &rarr; Export Laporan</em></li>
    <li><strong>Blog/CMS:</strong> <em>Homepage &rarr; Klik Kategori &rarr; Baca Artikel &rarr; Tulis Komentar</em></li>
</ol>

<p>Setiap langkah dalam journey ini akan memicu query database, render view, dan proses lainnya yang berbeda-beda. Menguji hanya satu endpoint adalah <strong>ilusi keamanan</strong>.</p>

<h3>B. Ramp-up Period</h3>

<p>Jangan langsung mengirim 1.000 user dalam satu detik. Mulailah secara bertahap untuk melihat bagaimana server beradaptasi:</p>

<ol>
    <li><strong>Menit 1-2:</strong> 10 virtual users</li>
    <li><strong>Menit 3-5:</strong> 100 virtual users</li>
    <li><strong>Menit 6-8:</strong> 500 virtual users</li>
    <li><strong>Menit 9-10:</strong> 1.000 virtual users</li>
</ol>

<p>Dengan pendekatan ini, Anda bisa mengidentifikasi di titik mana performa mulai menurun &mdash; apakah di 200 user? 500? Atau baru di 1.000?</p>

<h3>C. Geographical & Network Testing</h3>

<ul>
    <li><strong>Geographical Testing:</strong> Jika target pengguna di Indonesia, pastikan server penguji juga berada di region yang dekat (misalnya <em>ap-southeast-1</em> untuk Singapore atau <em>ap-southeast-3</em> untuk Jakarta). Gunakan layanan seperti <strong>AWS CloudFront</strong> atau <strong>Cloudflare CDN</strong> untuk mendistribusikan konten.</li>
    <li><strong>Network Throttling:</strong> Simulasikan koneksi 3G atau 4G untuk memahami pengalaman pengguna di daerah dengan koneksi internet yang tidak ideal.</li>
</ul>

<h2>🧠 4. Deteksi Masalah Sebelum User Merasakan</h2>

<p>Gunakan pendekatan proaktif dengan mencari <em>bottleneck</em> (leher botol) yang umum terjadi. Berikut adalah area-area kritis yang harus Anda periksa:</p>

<h3>A. Database Query Optimization</h3>

<p>Seringkali, penyebab utama lambatnya aplikasi bukan di kode PHP/Laravel, melainkan di query database yang tidak efisien:</p>

<ul>
    <li><strong>N+1 Problem:</strong> Ini adalah &ldquo;pembunuh diam-diam&rdquo; performa Laravel. Misalnya, menampilkan 100 artikel beserta nama penulisnya bisa menghasilkan 101 query jika tidak menggunakan <code>eager loading</code>. Solusi: gunakan <code>with()</code> di Eloquent.
        <br><br>
        <code>// ❌ Buruk: N+1 Problem (101 queries)</code><br>
        <code>$articles = Article::all();</code><br>
        <code>foreach ($articles as $article) { echo $article-&gt;user-&gt;name; }</code><br>
        <br>
        <code>// ✅ Baik: Eager Loading (2 queries)</code><br>
        <code>$articles = Article::with(&apos;user&apos;)-&gt;get();</code><br>
        <code>foreach ($articles as $article) { echo $article-&gt;user-&gt;name; }</code>
    </li>
    <li><strong>Missing Index:</strong> Pastikan kolom yang sering digunakan di <code>WHERE</code>, <code>JOIN</code>, dan <code>ORDER BY</code> sudah di-<em>index</em>. Gunakan <code>EXPLAIN</code> untuk menganalisis query plan.</li>
    <li><strong>Query Monitoring:</strong> Gunakan <code>DB::enableQueryLog()</code> atau <strong>Laravel Debugbar</strong> untuk melihat semua query yang dijalankan per request.</li>
</ul>

<h3>B. Asset Optimization</h3>

<ul>
    <li><strong>Gambar:</strong> Kompres menggunakan format modern seperti <strong>WebP</strong> atau <strong>AVIF</strong>. Gunakan <em>lazy loading</em> (<code>loading="lazy"</code>) untuk gambar di bawah <em>fold</em>.</li>
    <li><strong>JavaScript/CSS:</strong> Pastikan sudah di-<em>minify</em> dan di-<em>bundle</em>. Gunakan <em>tree shaking</em> untuk menghilangkan kode yang tidak terpakai. Dengan Vite di Laravel, ini sudah otomatis saat <code>npm run build</code>.</li>
    <li><strong>Font:</strong> Gunakan <code>font-display: swap</code> untuk mencegah <em>FOIT</em> (Flash of Invisible Text). Pertimbangkan untuk memuat font secara <em>self-hosted</em> daripada dari Google Fonts CDN.</li>
</ul>

<h3>C. Caching Strategy</h3>

<p>Caching yang tepat bisa meningkatkan performa hingga <strong>10-100x lipat</strong>:</p>

<ul>
    <li><strong>Application Cache (Redis/Memcached):</strong> Simpan data yang jarang berubah (daftar kategori, konfigurasi, artikel populer) agar server tidak perlu query database berulang kali.</li>
    <li><strong>HTTP Cache:</strong> Gunakan header <code>Cache-Control</code>, <code>ETag</code>, dan <code>Last-Modified</code> untuk membiarkan browser menyimpan aset statis.</li>
    <li><strong>Query Cache:</strong> Di Laravel, gunakan package seperti <em>laravel-query-cache</em> atau implementasikan sendiri dengan <code>Cache::remember()</code>.</li>
    <li><strong>Full Page Cache:</strong> Untuk halaman yang jarang berubah (seperti <em>landing page</em>), pertimbangkan menggunakan <strong>Varnish</strong> atau <strong>Nginx FastCGI Cache</strong>.</li>
</ul>

<h3>D. Server & Infrastructure</h3>

<ul>
    <li><strong>PHP-FPM Tuning:</strong> Sesuaikan <code>pm.max_children</code>, <code>pm.start_servers</code>, dan <code>pm.max_requests</code> berdasarkan RAM server Anda.</li>
    <li><strong>OPcache:</strong> Pastikan OPcache diaktifkan di produksi. Ini meng-cache bytecode PHP sehingga tidak perlu di-compile ulang setiap request.</li>
    <li><strong>Queue System:</strong> Pindahkan proses berat (kirim email, generate PDF, resize gambar) ke background job menggunakan Laravel Queue dengan Redis atau database driver.</li>
</ul>

<h2>💼 5. Deliver Hasil Kerja yang Terpercaya</h2>

<p>Jangan memberikan laporan berupa screenshot terminal yang membingungkan. Berikan laporan profesional yang bisa dipahami klien dan stakeholder non-teknis:</p>

<h3>A. Visualisasi Data</h3>

<ul>
    <li>Gunakan grafik perbandingan antara <strong>&ldquo;Sebelum Optimasi&rdquo;</strong> dan <strong>&ldquo;Sesudah Optimasi&rdquo;</strong> untuk menunjukkan dampak pekerjaan Anda secara visual.</li>
    <li>Sertakan <em>percentile chart</em> (P50, P95, P99) bukan hanya rata-rata. Rata-rata bisa menyembunyikan masalah: response time rata-rata 200ms tapi P99 bisa 5 detik &mdash; artinya 1% pengguna Anda menunggu sangat lama.</li>
</ul>

<h3>B. Executive Summary</h3>

<p>Berikan kesimpulan sederhana yang bisa langsung dipahami. Contoh:</p>

<blockquote>
    <p>&ldquo;Setelah optimasi, sistem sekarang mampu menangani <strong>5.000 pengguna bersamaan</strong> dengan response time rata-rata <strong>180ms</strong> (sebelumnya 1.2 detik untuk 500 pengguna). Error rate turun dari <strong>12% menjadi 0.3%</strong>. Biaya server bulanan berkurang <strong>40%</strong> karena penggunaan resource yang lebih efisien.&rdquo;</p>
</blockquote>

<h3>C. Rekomendasi Lanjutan</h3>

<p>Berikan <em>roadmap</em> teknis untuk skala di masa depan:</p>

<ul>
    <li>Penggunaan <strong>Load Balancer</strong> (Nginx, HAProxy, atau managed LB dari cloud provider) untuk distribusi traffic.</li>
    <li>Implementasi <strong>Database Read Replica</strong> untuk memisahkan beban baca dan tulis.</li>
    <li>Migrasi ke arsitektur <strong>microservices</strong> jika monolith sudah terlalu besar.</li>
    <li>Penerapan <strong>CDN</strong> untuk melayani aset statis dari edge server terdekat dengan pengguna.</li>
</ul>

<h2>💰 6. Naikkan Harga Karena Kualitas Terjamin</h2>

<p>Performance testing adalah layanan premium. Anda tidak lagi menjual &ldquo;Web Jadi&rdquo;, tapi menjual <strong>&ldquo;Infrastruktur yang Siap Bisnis&rdquo;</strong>. Inilah yang membedakan developer pemula dari <em>engineer</em> profesional.</p>

<table>
    <thead>
        <tr>
            <th>Aspek</th>
            <th>Developer Biasa</th>
            <th>Performance Engineer</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Deliverable</td>
            <td>Website yang &ldquo;bisa diakses&rdquo;</td>
            <td>Website yang teruji hingga X pengguna bersamaan</td>
        </tr>
        <tr>
            <td>Jaminan</td>
            <td>Tidak ada SLA</td>
            <td>Garansi uptime 99.9% dengan laporan testing</td>
        </tr>
        <tr>
            <td>Tarif</td>
            <td>Rp 5-15 juta/proyek</td>
            <td>Rp 15-50 juta/proyek</td>
        </tr>
        <tr>
            <td>Posisi</td>
            <td>Coder / Freelancer</td>
            <td>Konsultan Performa / Engineer</td>
        </tr>
    </tbody>
</table>

<h3>Cara Memposisikan Diri:</h3>

<ul>
    <li><strong>Guarantee Stability:</strong> Berikan jaminan bahwa web tidak akan <em>down</em> saat ada lonjakan traffic (misalnya saat peluncuran produk atau promosi besar). Sertakan laporan stress test sebagai bukti.</li>
    <li><strong>Efisiensi Biaya:</strong> Tunjukkan bahwa dengan kode yang efisien, biaya server bisa ditekan seminimal mungkin. Misalnya, optimasi query bisa menghemat biaya database hingga 50%.</li>
    <li><strong>Posisi Sebagai Konsultan:</strong> Anda bukan sekadar <em>coder</em>, tapi konsultan performa. Ini memungkinkan Anda untuk menagih tarif <strong>2-3x lipat</strong> lebih tinggi dari pembuatan web standar.</li>
</ul>

<h2>🎯 Kesimpulan</h2>

<p>Performance testing bukan hanya soal menjalankan tools dan melihat angka. Ini adalah <strong>mindset</strong> &mdash; sebuah pemahaman bahwa setiap milidetik yang Anda hemat berdampak langsung pada kepuasan pengguna, konversi bisnis, dan reputasi profesional Anda.</p>

<p>Langkah pertama yang bisa Anda lakukan sekarang:</p>

<ol>
    <li>Install <strong>Lighthouse</strong> dan jalankan audit pada proyek Anda saat ini.</li>
    <li>Pasang <strong>Laravel Debugbar</strong> dan identifikasi query N+1.</li>
    <li>Buat script <strong>k6</strong> sederhana untuk mengetes API endpoint Anda.</li>
    <li>Implementasikan <strong>caching</strong> pada data yang paling sering diakses.</li>
</ol>

<p>Dengan menguasai aspek ini, Anda berpindah dari seorang pelaksana teknis menjadi seorang <em>engineer</em> yang memahami dampak bisnis dari sebuah teknologi. Dan itu, adalah perbedaan antara dibayar untuk &ldquo;membuat website&rdquo; dan dibayar untuk <strong>&ldquo;membangun solusi bisnis&rdquo;</strong>.</p>
',
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(50, 200),
        ]);

        $this->command->info('Performance Testing Article created successfully!');
    }
}
