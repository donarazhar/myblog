<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class DataPribadiArticleSeeder extends Seeder
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

        // Create Data Pribadi article
        Article::create([
            'title' => 'Data Pribadimu, Harta Karunmu: Memahami Jenis Data & Perlindungannya di Era UU PDP',
            'slug' => 'data-pribadimu-harta-karunmu',
            'excerpt' => 'Memahami jenis data pribadi dan perlindungannya berdasarkan UU No. 27 Tahun 2022 tentang Perlindungan Data Pribadi (UU PDP). Pelajari perbedaan data umum dan spesifik, serta cara menjaga keamanan data digitalmu.',
            'content' => '
<p>Melanjutkan seri literasi digital kita, kali ini kita akan membedah "harta karun" kita. Banyak yang bilang <strong>"Data adalah minyak baru"</strong>, tapi kita sering tidak sadar mana data yang biasa saja, dan mana yang berbahaya kalau bocor. Mari kita pelajari bersama.</p>

<h2>Negara Hadir Melindungi Kita</h2>

<p>Indonesia kini memiliki payung hukum yang kuat untuk melindungi data pribadi warganya, yaitu <strong>UU No. 27 Tahun 2022 tentang Perlindungan Data Pribadi (UU PDP)</strong>.</p>

<p>Sekarang, menyebarkan data orang lain sembarangan bukan cuma masalah tidak sopan, tapi <strong>bisa kena pidana</strong>. Data Pribadi bukan lagi hal sepele, tapi dilindungi hukum negara.</p>

<h2>Apa Itu Data Pribadi?</h2>

<p>Data pribadi itu bukan sekadar nama. Menurut UU PDP, data pribadi adalah:</p>

<blockquote>
<p>Data tentang orang perseorangan yang teridentifikasi atau dapat diidentifikasi secara tersendiri atau dikombinasi dengan informasi lainnya, baik secara langsung maupun tidak langsung.</p>
</blockquote>

<p>Artinya, alamat IP laptop, riwayat lokasi, bahkan <em>cookies</em> browser pun termasuk data pribadi jika bisa dipakai untuk melacak identitas seseorang.</p>

<h2>Kategori 1: Data Pribadi Umum (General)</h2>

<p>Data Pribadi Umum adalah data yang bisa digunakan untuk mengenali kamu. Contohnya:</p>

<ul>
    <li><strong>Nama Lengkap</strong></li>
    <li><strong>Jenis Kelamin</strong></li>
    <li><strong>Kewarganegaraan & Agama</strong></li>
    <li><strong>Status Perkawinan</strong></li>
    <li><strong>Data Kombinasi</strong> (Nomor Telepon / Alamat IP)</li>
</ul>

<p>Meskipun disebut "Umum", data ini tetap harus dijaga. Jangan sembarangan posting foto KTP atau Kartu Pelajar di story Instagram!</p>

<h2>Kategori 2: Data Pribadi Spesifik (Sensitive)</h2>

<p>Data Pribadi Spesifik adalah data sensitif yang bila tersebar bisa menimbulkan <strong>kerugian besar</strong>. Ini adalah zona merah! Contohnya:</p>

<ul>
    <li><strong>Data Kesehatan & Biometrik</strong> (Sidik Jari / Pemindai Wajah)</li>
    <li><strong>Data Genetika & Catatan Kejahatan</strong></li>
    <li><strong>Data Anak</strong></li>
    <li><strong>Data Keuangan Pribadi</strong></li>
</ul>

<p>Kalau data ini bocor, risikonya fatal. Rekening bisa dibobol, atau identitas bisa dipalsukan. Hati-hati dengan aplikasi yang meminta akses data ini tanpa alasan jelas.</p>

<h2>Kenapa Dibedakan? Perbedaan Risiko</h2>

<p>UU PDP membedakan kedua jenis data ini karena dampak kebocorannya sangat berbeda:</p>

<table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse: collapse; margin-bottom: 20px;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>Bocor Data Umum</th>
            <th>Bocor Data Spesifik</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Potensi <em>Spam</em> Iklan</td>
            <td>Potensi <em>Identity Theft</em> (Pencurian Identitas)</td>
        </tr>
        <tr>
            <td>Penipuan Ringan</td>
            <td>Pembobolan Rekening Bank</td>
        </tr>
        <tr>
            <td>Telepon/SMS tidak dikenal</td>
            <td>Diskriminasi & Perundungan (<em>Bullying</em>)</td>
        </tr>
    </tbody>
</table>

<p>Kalau nama bocor, mungkin kita ditelepon penipu. Tapi kalau data biometrik atau kesehatan bocor? Kita bisa diperas atau didiskriminasi.</p>

<h2>Sudut Pandang Islam: Menjaga Amanah & Aib</h2>

<p>Sebagai umat Islam, kita melihat data bukan hanya sebagai file komputer, tapi sebagai <strong>Amanah</strong>. Beberapa prinsip penting:</p>

<ul>
    <li><strong>Menjaga data orang lain = Menjaga Amanah.</strong> Rasulullah SAW bersabda bahwa orang yang dipercaya memegang amanah harus menjaganya dengan baik.</li>
    <li><strong>Menyebar data spesifik (misal: penyakit/aib) = Ghibah/Membuka Aib.</strong> Membocorkan data gaji teman atau riwayat penyakit guru adalah perbuatan dosa karena membuka aib seseorang.</li>
</ul>

<p>Islam mengajarkan kita untuk menjaga privasi dan kehormatan sesama, dan di era digital ini, menjaga data pribadi adalah bagian dari akhlak mulia tersebut.</p>

<h2>Kesimpulan: Jaga Kunci Digitalmu</h2>

<p>Yuk, mulai sekarang lebih bijak soal data. Berikut langkah-langkah yang bisa kamu praktikkan:</p>

<ol>
    <li><strong>Batasi Share Data di Medsos</strong> — Jangan mudah membagikan informasi pribadi di media sosial.</li>
    <li><strong>Baca Privacy Policy Sebelum Klik "Agree"</strong> — Pahami apa saja data yang diminta oleh aplikasi sebelum menyetujuinya.</li>
    <li><strong>Hargai Privasi Teman</strong> — Jangan melakukan <em>doxing</em> (menyebar data pribadi orang lain tanpa izin).</li>
</ol>

<p>Jadilah <strong>Smart & Secure User</strong>. Jangan mudah memberikan data spesifik ke orang asing atau aplikasi yang tidak jelas.</p>

<p><em>Materi ini merupakan bagian dari IT Literacy Series - YPI Al Azhar, berdasarkan UU No. 27 Tahun 2022 tentang Perlindungan Data Pribadi.</em></p>
',
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(50, 200),
        ]);

        $this->command->info('Data Pribadi Article created successfully!');
    }
}
