@extends('layouts.app')

@section('title', 'About Us')
@section('meta_description', 'Learn more about our company and what we do')

@section('content')
<!-- Hero Section -->
<section class="relative py-20 bg-black overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0 bg-pattern"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-6">About Us</h1>
        <p class="text-xl text-gray-400 max-w-2xl mx-auto">Mengenal lebih dekat siapa kami dan apa yang kami lakukan</p>
    </div>
</section>

<!-- About Content -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl font-bold text-black mb-6">Kami Membangun Solusi Digital</h2>
                <p class="text-lg text-gray-600 mb-6">
                    {{ $settings['about_short'] ?? 'Kami adalah tim developer berpengalaman yang fokus pada pembuatan aplikasi web dan mobile yang berkualitas tinggi.' }}
                </p>
                <div class="prose prose-gray max-w-none">
                    {!! nl2br(e($settings['about_full'] ?? 'Dengan pengalaman bertahun-tahun dalam industri teknologi, kami telah membantu berbagai klien mewujudkan ide mereka menjadi aplikasi yang powerful dan user-friendly. Kami menggunakan teknologi terkini dan best practices untuk memastikan setiap proyek yang kami kerjakan memiliki kualitas terbaik.')) !!}
                </div>
            </div>

            <div class="relative">
                <div class="aspect-square bg-black rounded-3xl shadow-2xl flex items-center justify-center">
                    <svg class="w-48 h-48 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                    </svg>
                </div>
                <!-- Decorative elements -->
                <div class="absolute -top-4 -right-4 w-24 h-24 bg-gray-200 rounded-2xl -z-10"></div>
                <div class="absolute -bottom-4 -left-4 w-32 h-32 bg-gray-100 rounded-2xl -z-10"></div>
            </div>
        </div>
    </div>
</section>

<!-- Skills Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-black mb-4">Keahlian Kami</h2>
            <p class="text-gray-600">Teknologi dan tools yang kami kuasai</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
            @php
            $skills = [
            ['name' => 'Laravel', 'abbr' => 'La'],
            ['name' => 'PHP', 'abbr' => 'PH'],
            ['name' => 'JavaScript', 'abbr' => 'JS'],
            ['name' => 'React', 'abbr' => 'Re'],
            ['name' => 'Vue.js', 'abbr' => 'Vu'],
            ['name' => 'MySQL', 'abbr' => 'My'],
            ['name' => 'Tailwind', 'abbr' => 'Tw'],
            ['name' => 'Node.js', 'abbr' => 'No'],
            ['name' => 'Flutter', 'abbr' => 'Fl'],
            ['name' => 'Git', 'abbr' => 'Gi'],
            ['name' => 'Docker', 'abbr' => 'Do'],
            ['name' => 'AWS', 'abbr' => 'AW'],
            ];
            @endphp

            @foreach($skills as $skill)
            <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg hover:border-gray-300 transition-all text-center group">
                <div class="w-12 h-12 mx-auto mb-3 rounded-xl bg-black flex items-center justify-center text-white font-bold group-hover:scale-110 transition-transform">
                    {{ $skill['abbr'] }}
                </div>
                <span class="text-sm font-medium text-gray-700">{{ $skill['name'] }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-20 bg-black">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-4xl md:text-5xl font-bold text-white mb-2">50+</div>
                <div class="text-gray-400">Projects Completed</div>
            </div>
            <div>
                <div class="text-4xl md:text-5xl font-bold text-white mb-2">30+</div>
                <div class="text-gray-400">Happy Clients</div>
            </div>
            <div>
                <div class="text-4xl md:text-5xl font-bold text-white mb-2">5+</div>
                <div class="text-gray-400">Years Experience</div>
            </div>
            <div>
                <div class="text-4xl md:text-5xl font-bold text-white mb-2">100%</div>
                <div class="text-gray-400">Client Satisfaction</div>
            </div>
        </div>
    </div>
</section>
@endsection