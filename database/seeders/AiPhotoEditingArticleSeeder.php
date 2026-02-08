<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class AiPhotoEditingArticleSeeder extends Seeder
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

        // Create AI Photo Editing article
        Article::create([
            'title' => 'AI & Etika Digital: Menjadi Kreator Canggih yang Tetap Beradab',
            'slug' => 'ai-etika-digital-kreator-canggih-beradab',
            'excerpt' => 'Pembahasan lengkap tentang evolusi AI photo editing, implikasi etika dan hukum, serta perspektif Islam dalam teknologi generatif AI.',
            'content' => '
<p>Di era <strong>Generative AI</strong>, kemampuan mengedit foto dan membuat konten visual telah berevolusi drastis. Tools seperti ChatGPT, Midjourney, dan Remini membawa kita ke "Era Magic" di mana seolah-olah siapa saja bisa menjadi kreator profesional dalam hitungan detik.</p>

<h2>Era Magic: Dari Manual ke AI</h2>

<p>Perjalanan editing foto telah berubah total:</p>
<ul>
    <li><strong>Dulu</strong>: Membutuhkan skill Photoshop bertahun-tahun</li>
    <li><strong>Sekarang</strong>: Cukup dengan prompt teks, AI menghasilkan gambar berkualitas tinggi</li>
</ul>

<h3>Tools AI Populer</h3>
<ul>
    <li><strong>ChatGPT</strong> - AI conversational dengan kemampuan image generation</li>
    <li><strong>Midjourney</strong> - Text-to-image generator berkualitas tinggi</li>
    <li><strong>Remini</strong> - AI photo enhancement dan restoration</li>
    <li><strong>DALL-E</strong> - Image generation dari OpenAI</li>
</ul>

<h2>Sisi Gelap: Deepfakes & Hoax</h2>

<p>Dengan kekuatan besar datang tanggung jawab besar. AI photo editing membawa risiko:</p>
<ul>
    <li><strong>Deepfakes</strong> - Manipulasi wajah untuk konten menyesatkan</li>
    <li><strong>Standardisasi Kecantikan</strong> - Tekanan sosial akibat filter AI</li>
    <li><strong>Penyebaran Hoax</strong> - Gambar palsu yang tampak nyata</li>
</ul>

<h2>Perspektif Hukum (UU ITE)</h2>

<p>Di Indonesia, manipulasi foto digital yang merugikan orang lain dapat dijerat dengan UU ITE terkait:</p>
<ul>
    <li>Penyebaran informasi yang menyesatkan</li>
    <li>Pencemaran nama baik</li>
    <li>Pelanggaran privasi</li>
</ul>

<h2>Perspektif Islam</h2>

<p>Dari sudut pandang fiqh, penggunaan AI photo editing perlu memperhatikan:</p>

<h3>Konsep Tabarruj</h3>
<p>Memamerkan kecantikan secara berlebihan, termasuk melalui filter AI yang mengubah penampilan drastis.</p>

<h3>Konsep Taghyir</h3>
<p>Mengubah ciptaan Allah secara permanen atau menyesatkan.</p>

<h2>4 Pilar Etika Digital</h2>

<ol>
    <li><strong>Consent (Persetujuan)</strong> - Tidak edit foto orang tanpa izin</li>
    <li><strong>Harm (Kerugian)</strong> - Tidak membuat konten yang merugikan</li>
    <li><strong>Intent (Niat)</strong> - Gunakan AI untuk kebaikan</li>
    <li><strong>Truth (Kebenaran)</strong> - Jangan menyebarkan informasi palsu</li>
</ol>

<h2>Kesimpulan</h2>

<p>AI adalah alat yang netral. Dampaknya tergantung bagaimana kita menggunakannya. Menjadi <strong>kreator canggih yang tetap beradab</strong> adalah pilihan yang harus kita ambil di era digital ini.</p>

<p><em>Presentasi ini ditujukan untuk Smart Generation Series - Digital Native Gen Z.</em></p>
',
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
            'views' => rand(50, 200),
        ]);

        $this->command->info('AI Photo Editing & Digital Ethics article created successfully!');
    }
}
