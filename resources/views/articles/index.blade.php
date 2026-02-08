@extends('layouts.app')

@section('title', isset($category) ? $category->name : 'Articles')
@section('meta_description', 'Baca artikel-artikel terbaru tentang pembuatan aplikasi')

@section('content')
<!-- Hero Section -->
<section class="relative py-20 bg-black overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0 bg-pattern"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-6">
            @if(isset($category))
            {{ $category->name }}
            @else
            Articles
            @endif
        </h1>
        <p class="text-xl text-gray-400 max-w-2xl mx-auto">Artikel dan tutorial tentang pembuatan aplikasi</p>
    </div>
</section>

<!-- Articles Content -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar -->
            <aside class="lg:col-span-1">
                <div class="bg-white rounded-2xl border border-gray-200 p-6 sticky top-24">
                    <h3 class="text-lg font-bold text-black mb-4">Categories</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('articles.index') }}" class="flex items-center justify-between px-4 py-2 rounded-lg {{ !isset($category) ? 'bg-black text-white' : 'text-gray-600 hover:bg-gray-100' }} transition-colors">
                                <span>All Articles</span>
                                <span class="text-sm">{{ $articles->total() }}</span>
                            </a>
                        </li>
                        @foreach($categories as $cat)
                        <li>
                            <a href="{{ route('articles.category', $cat->slug) }}" class="flex items-center justify-between px-4 py-2 rounded-lg {{ (isset($category) && $category->id == $cat->id) ? 'bg-black text-white' : 'text-gray-600 hover:bg-gray-100' }} transition-colors">
                                <span>{{ $cat->name }}</span>
                                <span class="text-sm">{{ $cat->articles_count }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </aside>

            <!-- Articles Grid -->
            <div class="lg:col-span-3">
                @if($articles->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach($articles as $article)
                    <article class="group bg-white rounded-2xl border border-gray-200 overflow-hidden hover:shadow-xl hover:border-gray-300 transition-all duration-300 hover:-translate-y-1">
                        <div class="aspect-video bg-gray-100 overflow-hidden">
                            @if($article->featured_image)
                            <img src="{{ Storage::url($article->featured_image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                </svg>
                            </div>
                            @endif
                        </div>
                        <div class="p-6">
                            @if($article->category)
                            <a href="{{ route('articles.category', $article->category->slug) }}" class="inline-block px-3 py-1 bg-gray-100 text-gray-700 text-sm font-medium rounded-full mb-3 hover:bg-gray-200 transition-colors">{{ $article->category->name }}</a>
                            @endif
                            <h2 class="text-xl font-bold text-black mb-2 group-hover:text-gray-600 transition-colors line-clamp-2">
                                <a href="{{ route('articles.show', $article->slug) }}">{{ $article->title }}</a>
                            </h2>
                            <p class="text-gray-600 mb-4 line-clamp-2">{{ $article->excerpt ?? Str::limit(strip_tags($article->content), 120) }}</p>
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <span>{{ $article->published_at->format('d M Y') }}</span>
                                <span>{{ $article->views }} views</span>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $articles->links() }}
                </div>
                @else
                <div class="text-center py-20">
                    <svg class="w-24 h-24 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum ada artikel</h3>
                    <p class="text-gray-500">Artikel akan segera tersedia.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection