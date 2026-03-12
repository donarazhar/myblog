<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Setting;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@demo.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        // Create categories
        $categories = [
            ['name' => 'Aplikasi', 'description' => 'Artikel tentang aplikasi yang telah dibuat'],
            ['name' => 'Teknologi', 'description' => 'Artikel tentang perkembangan teknologi'],
            ['name' => 'Tutorial', 'description' => 'Tutorial dan panduan pengembangan aplikasi'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create default settings
        $settings = [
            'site_name' => 'MyBlog',
            'site_tagline' => 'Developer & Tech Enthusiast',
            'site_description' => 'Blog pribadi tentang pengembangan aplikasi web dan mobile',
            'contact_email' => 'contact@myblog.com',
            'contact_phone' => '+62 812 3456 7890',
            'contact_address' => 'Jakarta, Indonesia',
            'social_github' => 'https://github.com/donarazhar',
            'social_linkedin' => 'https://linkedin.com/in/donarazhar',
            'social_twitter' => 'https://twitter.com/donarazhar',
            'social_instagram' => 'https://instagram.com/donsiyos',
            'about_short' => 'Seorang developer yang passionate dalam membangun aplikasi berkualitas.',
            'about_full' => 'Dengan pengalaman lebih dari 5 tahun di bidang pengembangan aplikasi, saya telah bekerja dengan berbagai teknologi mulai dari web development dengan Laravel dan React, hingga mobile development dengan React Native. Saya percaya bahwa teknologi dapat membuat hidup lebih mudah dan efisien.',
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }

        // Run article seeders
        $this->call([
            KaskecilArticleSeeder::class,
            TaarufArticleSeeder::class,
            SignageDisplayArticleSeeder::class,
            FbEngagementArticleSeeder::class,
            AiPhotoEditingArticleSeeder::class,
            IttdLearnhubArticleSeeder::class,
            MyblogArticleSeeder::class,
            DeploymentGuideArticleSeeder::class,
            TipsTricksArticleSeeder::class,
            KaskecilProcessArticleSeeder::class,
            ServerSecurityBackupArticleSeeder::class,
            FramingArticleSeeder::class,
            DataPribadiArticleSeeder::class,
            BuletinLiterasiDigitalArticleSeeder::class,
            KamusDigitalParentingArticleSeeder::class,
            HarddiskRecoveryArticleSeeder::class,
            ItqanManajemenMutuArticleSeeder::class,
            GenerasiIqraArticleSeeder::class,
            JejakDigitalArticleSeeder::class,
            PostTruthArticleSeeder::class,
            SeoImplementationArticleSeeder::class,
            GoogleDriveBackupArticleSeeder::class,
            VoiceScamArticleSeeder::class,
            ApiGatewayLbReverseProxyArticleSeeder::class,
            ApiAuthenticationArticleSeeder::class,
            ContainerVmKernelArticleSeeder::class,
            CapcutTricksArticleSeeder::class,
            CanvaTipsArticleSeeder::class,
            JejakDigitalLpdpArticleSeeder::class,
            BrdPrdErdArticleSeeder::class,
            UmlApiDocsSowArticleSeeder::class,
            AgilePrdWireframeKanbanArticleSeeder::class,
            PenipuanLebaranArticleSeeder::class,
            StudiKasusMyblogBrdPrdErdArticleSeeder::class,
            DdosStressTestMitigasiArticleSeeder::class,
        ]);
    }
}
