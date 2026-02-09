@extends('layouts.app')

@section('title', 'Home')

@section('content')
<!-- Hero Section - Full Width Background -->
<section class="relative min-h-[90vh] flex items-center bg-black overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0 bg-pattern"></div>
    </div>

    <div class="relative content-container px-4 sm:px-6 lg:px-8 py-20 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Text Content -->
            <div class="text-center lg:text-left">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight uppercase">
                    Iqra' <span class="text-gray-400">bismi rabbikalladzi</span><br>
                    khalaq
                </h1>
                <p class="text-lg md:text-xl text-gray-400 max-w-2xl mx-auto lg:mx-0 mb-10">
                    Landasi setiap aktivitas literasi, riset, dan teknologi dengan niat karena Allah agar ilmu pengetahuan yang diraih mendatangkan keberkahan sejati bagi umat.
                </p>

            </div>

            <!-- Profile Image - Floating Animation -->
            <div class="flex justify-center lg:justify-end">
                <div class="relative animate-float">
                    <div class="w-[50vh] h-[50vh] md:w-[55vh] md:h-[55vh] lg:w-[60vh] lg:h-[60vh] max-w-80 max-h-80 md:max-w-96 md:max-h-96 lg:max-w-none lg:max-h-none rounded-full overflow-hidden border-4 border-white/20 shadow-2xl">
                        <img src="{{ asset('img/myimage.png') }}" alt="Profile" class="w-full h-full object-cover object-top">
                    </div>
                    <!-- Decorative Ring -->
                    <div class="absolute inset-0 rounded-full border-2 border-white/10 scale-110"></div>
                    <div class="absolute inset-0 rounded-full border border-white/5 scale-125"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <svg class="w-6 h-6 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
        </svg>
    </div>
</section>

<!-- Featured Articles Section - Full Width Background -->
@if($featuredArticles->count() > 0)
<section class="py-20 bg-white">
    <div class="content-container px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-black mb-4">Artikel Terbaru</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Artikel terbaru & aplikasi yang saya kerjakan, semoga bermanfaat.</p>
        </div>

        <div class="space-y-4">
            @foreach($featuredArticles as $article)
            <article class="group bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg hover:border-gray-300 transition-all duration-300">
                <a href="{{ route('articles.show', $article->slug) }}" class="flex items-center p-4 gap-4">
                    <!-- Small Thumbnail -->
                    <div class="w-16 h-16 flex-shrink-0 rounded-lg overflow-hidden bg-gray-100">
                        @if($article->featured_image)
                        <img src="{{ Storage::url($article->featured_image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                        </div>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <h3 class="text-lg font-bold text-black group-hover:text-gray-600 transition-colors truncate">
                                {{ $article->title }}
                            </h3>
                            @if($article->category)
                            <span class="hidden sm:inline-block px-2 py-0.5 bg-gray-100 text-gray-600 text-xs font-medium rounded-full flex-shrink-0">{{ $article->category->name }}</span>
                            @endif
                        </div>
                        <p class="text-gray-600 text-sm line-clamp-1">{{ $article->excerpt ?? Str::limit(strip_tags($article->content), 100) }}</p>
                        <div class="flex items-center text-xs text-gray-500 mt-1">
                            <span>{{ $article->published_at->format('d M Y') }}</span>
                            <span class="mx-2">•</span>
                            <span>{{ $article->views }} views</span>
                        </div>
                    </div>

                    <!-- Arrow -->
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-black transition-colors flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </article>
            @endforeach
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('articles.index') }}" class="group inline-flex items-center gap-2 px-6 py-3 bg-black text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition-all duration-300">
                Lihat Semua Artikel
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
    </div>
</section>
@endif
@endsection