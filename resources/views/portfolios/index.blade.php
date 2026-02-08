@extends('layouts.app')

@section('title', 'Portfolio')
@section('meta_description', 'Lihat portfolio proyek-proyek yang sudah kami kerjakan')

@section('content')
<!-- Hero Section -->
<section class="relative py-20 bg-black overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0 bg-pattern"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-6">Our Portfolio</h1>
        <p class="text-xl text-gray-400 max-w-2xl mx-auto">Proyek-proyek terbaik yang sudah kami kerjakan</p>
    </div>
</section>

<!-- Portfolio Grid -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($portfolios->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($portfolios as $portfolio)
            <div class="group bg-white rounded-2xl border border-gray-200 overflow-hidden hover:shadow-xl hover:border-gray-300 transition-all duration-300 hover:-translate-y-1">
                <div class="aspect-video bg-gray-100 overflow-hidden relative">
                    @if($portfolio->featured_image)
                    <img src="{{ Storage::url($portfolio->featured_image) }}" alt="{{ $portfolio->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                    <div class="w-full h-full flex items-center justify-center">
                        <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    @endif

                    @if($portfolio->is_featured)
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 bg-black text-white text-xs font-semibold rounded-full">Featured</span>
                    </div>
                    @endif
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-black mb-2 group-hover:text-gray-600 transition-colors">
                        <a href="{{ route('portfolios.show', $portfolio->slug) }}">{{ $portfolio->title }}</a>
                    </h3>
                    <p class="text-gray-600 mb-4 line-clamp-2">{{ $portfolio->description }}</p>

                    @if($portfolio->technologies)
                    <div class="flex flex-wrap gap-2 mb-4">
                        @foreach(array_slice($portfolio->technologies, 0, 4) as $tech)
                        <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs font-medium rounded">{{ $tech }}</span>
                        @endforeach
                        @if(count($portfolio->technologies) > 4)
                        <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs font-medium rounded">+{{ count($portfolio->technologies) - 4 }}</span>
                        @endif
                    </div>
                    @endif

                    <div class="flex items-center justify-between">
                        @if($portfolio->completed_at)
                        <span class="text-sm text-gray-500">{{ $portfolio->completed_at->format('M Y') }}</span>
                        @endif
                        <a href="{{ route('portfolios.show', $portfolio->slug) }}" class="text-black hover:text-gray-600 font-medium text-sm inline-flex items-center">
                            View Details
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-12">
            {{ $portfolios->links() }}
        </div>
        @else
        <div class="text-center py-20">
            <svg class="w-24 h-24 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum ada portfolio</h3>
            <p class="text-gray-500">Portfolio akan segera tersedia.</p>
        </div>
        @endif
    </div>
</section>
@endsection