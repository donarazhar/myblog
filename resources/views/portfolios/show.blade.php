@extends('layouts.app')

@section('title', $portfolio->title)
@section('meta_description', $portfolio->description)

@section('content')
<!-- Portfolio Header -->
<section class="relative pt-24 pb-12 bg-black overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0 bg-pattern"></div>
    </div>

    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm text-gray-400">
                <li><a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a></li>
                <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg></li>
                <li><a href="{{ route('portfolios.index') }}" class="hover:text-white transition-colors">Portfolio</a></li>
            </ol>
        </nav>

        @if($portfolio->is_featured)
        <span class="inline-block px-4 py-1 bg-white/10 text-gray-300 text-sm font-medium rounded-full mb-4">Featured Project</span>
        @endif

        <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-6 leading-tight">{{ $portfolio->title }}</h1>

        <p class="text-xl text-gray-400 mb-6">{{ $portfolio->description }}</p>

        <div class="flex flex-wrap items-center gap-6 text-gray-400">
            @if($portfolio->client_name)
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <span>{{ $portfolio->client_name }}</span>
            </div>
            @endif

            @if($portfolio->completed_at)
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span>{{ $portfolio->completed_at->format('F Y') }}</span>
            </div>
            @endif

            @if($portfolio->project_url)
            <a href="{{ $portfolio->project_url }}" target="_blank" class="flex items-center space-x-2 text-white hover:text-gray-300 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
                <span>Visit Website</span>
            </a>
            @endif
        </div>
    </div>
</section>

<!-- Featured Image -->
@if($portfolio->featured_image)
<section class="relative -mt-12 z-10">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="aspect-video rounded-2xl overflow-hidden shadow-2xl">
            <img src="{{ Storage::url($portfolio->featured_image) }}" alt="{{ $portfolio->title }}" class="w-full h-full object-cover">
        </div>
    </div>
</section>
@endif

<!-- Portfolio Content -->
<section class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Technologies -->
        @if($portfolio->technologies)
        <div class="mb-12">
            <h3 class="text-lg font-semibold text-black mb-4">Technologies Used</h3>
            <div class="flex flex-wrap gap-3">
                @foreach($portfolio->technologies as $tech)
                <span class="px-4 py-2 bg-gray-100 text-gray-700 font-medium rounded-xl border border-gray-200">{{ $tech }}</span>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Content -->
        @if($portfolio->content)
        <article class="prose prose-lg prose-gray max-w-none prose-headings:font-bold prose-a:text-black prose-img:rounded-xl">
            {!! $portfolio->content !!}
        </article>
        @endif

        <!-- Back Button -->
        <div class="mt-12 pt-8 border-t border-gray-200">
            <a href="{{ route('portfolios.index') }}" class="inline-flex items-center text-gray-600 hover:text-black transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Portfolio
            </a>
        </div>
    </div>
</section>

<!-- Related Portfolio -->
@if($relatedPortfolios->count() > 0)
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-black mb-8">Other Projects</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($relatedPortfolios as $related)
            <div class="group bg-white rounded-2xl border border-gray-200 overflow-hidden hover:shadow-xl hover:border-gray-300 transition-all duration-300 hover:-translate-y-1">
                <div class="aspect-video bg-gray-100 overflow-hidden">
                    @if($related->featured_image)
                    <img src="{{ Storage::url($related->featured_image) }}" alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                    <div class="w-full h-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    @endif
                </div>
                <div class="p-6">
                    <h3 class="text-lg font-bold text-black mb-2 group-hover:text-gray-600 transition-colors line-clamp-2">
                        <a href="{{ route('portfolios.show', $related->slug) }}">{{ $related->title }}</a>
                    </h3>
                    <p class="text-gray-600 text-sm line-clamp-2">{{ $related->description }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection