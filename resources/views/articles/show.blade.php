@extends('layouts.app')

@section('title', $article->title)
@section('meta_description', $article->excerpt ?? Str::limit(strip_tags($article->content), 160))
@if($article->featured_image)
@section('meta_image', url(Storage::url($article->featured_image)))
@endif
@section('og_type', 'article')

@push('structured_data')
{{-- Article Schema --}}
<script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "Article",
        "headline": "{{ $article->title }}",
        "description": "{{ $article->excerpt ?? Str::limit(strip_tags($article->content), 160) }}",
        "author": {
            "@@type": "Person",
            "name": "{{ $article->user->name ?? 'Admin' }}"
        },
        "publisher": {
            "@@type": "Organization",
            "name": "DnrAzhr Blog",
            "logo": {
                "@@type": "ImageObject",
                "url": "{{ asset('img/favicon.png') }}"
            }
        },
        "datePublished": "{{ $article->published_at->toIso8601String() }}",
        "dateModified": "{{ $article->updated_at->toIso8601String() }}",
        @if($article -> featured_image)
        "image": "{{ url(Storage::url($article->featured_image)) }}",
        @endif "mainEntityOfPage": {
            "@@type": "WebPage",
            "@@id": "{{ route('articles.show', $article->slug) }}"
        },
        "url": "{{ route('articles.show', $article->slug) }}"
    }
</script>
{{-- Breadcrumb Schema --}}
<script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "BreadcrumbList",
        "itemListElement": [{
                "@@type": "ListItem",
                "position": 1,
                "name": "Home",
                "item": "{{ url('/') }}"
            },
            {
                "@@type": "ListItem",
                "position": 2,
                "name": "Articles",
                "item": "{{ route('articles.index') }}"
            }
            @if($article -> category), {
                "@@type": "ListItem",
                "position": 3,
                "name": "{{ $article->category->name }}",
                "item": "{{ route('articles.category', $article->category->slug) }}"
            },
            {
                "@@type": "ListItem",
                "position": 4,
                "name": "{{ $article->title }}"
            }
            @else, {
                "@@type": "ListItem",
                "position": 3,
                "name": "{{ $article->title }}"
            }
            @endif
        ]
    }
</script>
@endpush

@section('content')
<!-- Article Header -->
<section class="relative pt-24 pb-12 bg-black overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0 bg-pattern"></div>
    </div>

    <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm text-gray-400">
                <li><a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a></li>
                <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg></li>
                <li><a href="{{ route('articles.index') }}" class="hover:text-white transition-colors">Articles</a></li>
                @if($article->category)
                <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg></li>
                <li><a href="{{ route('articles.category', $article->category->slug) }}" class="hover:text-white transition-colors">{{ $article->category->name }}</a></li>
                @endif
            </ol>
        </nav>

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">
            <!-- Title & Meta -->
            <div class="flex-1">
                @if($article->category)
                <span class="inline-block px-4 py-1 bg-white/10 text-gray-300 text-sm font-medium rounded-full mb-4">{{ $article->category->name }}</span>
                @endif

                <h1 class="text-3xl md:text-4xl font-bold text-white mb-6 leading-tight">{{ $article->title }}</h1>

                <div class="flex items-center space-x-6 text-gray-400">
                    <div class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-black font-semibold">
                            {{ substr($article->user->name ?? 'A', 0, 1) }}
                        </div>
                        <span>{{ $article->user->name ?? 'Admin' }}</span>
                    </div>
                    <span>{{ $article->published_at->format('d M Y') }}</span>
                    <span>{{ $article->views }} views</span>
                </div>
            </div>

            <!-- Thumbnail -->
            @if($article->featured_image)
            <div class="flex-shrink-0">
                <div class="w-40 h-40 lg:w-48 lg:h-48 rounded-2xl overflow-hidden shadow-xl border-2 border-white/20">
                    <img src="{{ Storage::url($article->featured_image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                </div>
            </div>
            @endif
        </div>
    </div>
</section>


<!-- Article Content -->
<style>
    /* ========================================
       TINYMCE COMPLETE STYLING
       ======================================== */

    /* Base Typography */
    .article-content {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        font-size: 1.125rem;
        line-height: 1.6;
        color: #1e293b;
    }

    /* Headings */
    .article-content h1 {
        font-size: 2.5rem;
        font-weight: 800;
        color: #0f172a;
        margin-top: 2rem;
        margin-bottom: 1rem;
        line-height: 1.2;
        letter-spacing: -0.02em;
    }

    .article-content h2 {
        font-size: 2rem;
        font-weight: 700;
        color: #0f172a;
        margin-top: 1.75rem;
        margin-bottom: 0.875rem;
        line-height: 1.3;
        letter-spacing: -0.01em;
        padding-bottom: 0.5rem;
        border-bottom: 3px solid #e2e8f0;
    }

    .article-content h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e293b;
        margin-top: 1.5rem;
        margin-bottom: 0.75rem;
        line-height: 1.4;
    }

    .article-content h4 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #334155;
        margin-top: 1.25rem;
        margin-bottom: 0.625rem;
        line-height: 1.5;
    }

    .article-content h5 {
        font-size: 1.125rem;
        font-weight: 600;
        color: #475569;
        margin-top: 1rem;
        margin-bottom: 0.5rem;
        line-height: 1.5;
    }

    .article-content h6 {
        font-size: 1rem;
        font-weight: 600;
        color: #64748b;
        margin-top: 1rem;
        margin-bottom: 0.5rem;
        line-height: 1.5;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* Paragraphs */
    .article-content p {
        margin-bottom: 1rem;
        line-height: 1.6;
    }

    .article-content p:last-child {
        margin-bottom: 0;
    }

    .article-content p:empty {
        min-height: 1.5em;
    }

    /* Text Formatting */
    .article-content strong,
    .article-content b {
        font-weight: 700;
        color: #0f172a;
    }

    .article-content em,
    .article-content i {
        font-style: italic;
    }

    .article-content u {
        text-decoration: underline;
        text-decoration-color: #6366f1;
        text-decoration-thickness: 2px;
        text-underline-offset: 2px;
    }

    .article-content s,
    .article-content strike {
        text-decoration: line-through;
        opacity: 0.7;
    }

    .article-content mark {
        background-color: #fef3c7;
        padding: 0.125rem 0.25rem;
        border-radius: 0.25rem;
        color: #92400e;
    }

    .article-content small {
        font-size: 0.875rem;
        color: #64748b;
    }

    .article-content sub {
        font-size: 0.75rem;
        vertical-align: sub;
    }

    .article-content sup {
        font-size: 0.75rem;
        vertical-align: super;
    }

    /* Links */
    .article-content a {
        color: #6366f1;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s;
        border-bottom: 2px solid transparent;
    }

    .article-content a:hover {
        color: #4f46e5;
        border-bottom-color: #4f46e5;
    }

    /* Lists */
    .article-content ul {
        list-style-type: none;
        margin: 1rem 0;
        padding-left: 0;
    }

    .article-content ul li {
        position: relative;
        padding-left: 2rem;
        margin-bottom: 0.5rem;
        line-height: 1.6;
    }

    .article-content ul li:before {
        content: "";
        position: absolute;
        left: 0.5rem;
        top: 0.7rem;
        width: 0.5rem;
        height: 0.5rem;
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        border-radius: 50%;
    }

    .article-content ol {
        list-style: none;
        counter-reset: item;
        margin: 1rem 0;
        padding-left: 0;
    }

    .article-content ol li {
        position: relative;
        padding-left: 2.5rem;
        margin-bottom: 0.5rem;
        counter-increment: item;
        line-height: 1.6;
    }

    .article-content ol li:before {
        content: counter(item);
        position: absolute;
        left: 0;
        top: 0;
        width: 1.75rem;
        height: 1.75rem;
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
        font-weight: 600;
    }

    /* Nested Lists */
    .article-content ul ul,
    .article-content ol ul,
    .article-content ul ol,
    .article-content ol ol {
        margin-top: 0.5rem;
        margin-bottom: 0.5rem;
    }

    /* Blockquotes */
    .article-content blockquote {
        position: relative;
        margin: 1.25rem 0;
        padding: 1.25rem 1.5rem 1.25rem 3.5rem;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-left: 5px solid #6366f1;
        border-radius: 0.75rem;
        font-style: italic;
        color: #475569;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .article-content blockquote:before {
        content: '"';
        position: absolute;
        left: 1rem;
        top: 1rem;
        font-size: 3rem;
        color: #6366f1;
        opacity: 0.3;
        font-family: Georgia, serif;
        line-height: 1;
    }

    .article-content blockquote p {
        margin-bottom: 0.5rem;
    }

    .article-content blockquote p:last-child {
        margin-bottom: 0;
    }

    /* Code */
    .article-content code {
        background-color: #f1f5f9;
        padding: 0.25rem 0.5rem;
        border-radius: 0.375rem;
        font-family: 'Monaco', 'Courier New', monospace;
        font-size: 0.875em;
        color: #be185d;
        border: 1px solid #e2e8f0;
    }

    .article-content pre {
        background-color: #1e293b;
        color: #e2e8f0;
        padding: 1.25rem;
        border-radius: 0.75rem;
        overflow-x: auto;
        margin: 1.25rem 0;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        border: 1px solid #334155;
    }

    .article-content pre code {
        background-color: transparent;
        padding: 0;
        border-radius: 0;
        color: inherit;
        border: none;
        font-size: 0.875rem;
        line-height: 1.7;
    }

    /* Tables */
    .article-content table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin: 1.25rem 0;
        border-radius: 0.75rem;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .article-content thead {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    }

    .article-content th {
        padding: 0.75rem 1rem;
        text-align: left;
        font-weight: 600;
        color: white;
        text-transform: uppercase;
        font-size: 0.875rem;
        letter-spacing: 0.05em;
    }

    .article-content tbody tr {
        background-color: white;
        transition: background-color 0.2s;
    }

    .article-content tbody tr:nth-child(even) {
        background-color: #f8fafc;
    }

    .article-content tbody tr:hover {
        background-color: #f1f5f9;
    }

    .article-content td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #e2e8f0;
        color: #334155;
    }

    .article-content tbody tr:last-child td {
        border-bottom: none;
    }

    /* Images */
    .article-content img {
        max-width: 100%;
        height: auto;
        border-radius: 0.75rem;
        margin: 1.25rem 0;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s;
    }

    .article-content img:hover {
        transform: scale(1.02);
    }

    /* Image Alignments */
    .article-content .alignleft {
        float: left;
        margin-right: 1.5rem;
        margin-bottom: 1rem;
        max-width: 50%;
    }

    .article-content .alignright {
        float: right;
        margin-left: 1.5rem;
        margin-bottom: 1rem;
        max-width: 50%;
    }

    .article-content .aligncenter {
        display: block;
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 1.25rem;
    }

    /* Figure & Figcaption */
    .article-content figure {
        margin: 1.25rem 0;
    }

    .article-content figcaption {
        text-align: center;
        font-size: 0.875rem;
        color: #64748b;
        margin-top: 0.5rem;
        font-style: italic;
    }

    /* Horizontal Rule */
    .article-content hr {
        border: none;
        height: 2px;
        background: linear-gradient(to right, transparent, #e2e8f0, transparent);
        margin: 2rem 0;
    }

    /* Iframe & Video */
    .article-content iframe {
        width: 100%;
        aspect-ratio: 16/9;
        border-radius: 0.75rem;
        margin: 1.25rem 0;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        border: none;
    }

    /* Text Alignment */
    .article-content .text-left {
        text-align: left;
    }

    .article-content .text-center {
        text-align: center;
    }

    .article-content .text-right {
        text-align: right;
    }

    .article-content .text-justify {
        text-align: justify;
    }

    /* Colors */
    .article-content .text-muted {
        color: #64748b;
    }

    /* Keyboard */
    .article-content kbd {
        background-color: #1e293b;
        color: #e2e8f0;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-family: 'Monaco', 'Courier New', monospace;
        font-size: 0.875em;
        border: 1px solid #334155;
        box-shadow: 0 2px 0 #334155;
    }

    /* Abbreviation */
    .article-content abbr[title] {
        text-decoration: underline dotted;
        cursor: help;
        border-bottom: 1px dotted #6366f1;
    }

    /* Definition List */
    .article-content dl {
        margin: 1rem 0;
    }

    .article-content dt {
        font-weight: 700;
        color: #0f172a;
        margin-top: 0.75rem;
    }

    .article-content dd {
        margin-left: 2rem;
        margin-top: 0.25rem;
        color: #475569;
    }

    /* Address */
    .article-content address {
        font-style: normal;
        line-height: 1.6;
        color: #475569;
        background-color: #f8fafc;
        padding: 0.875rem;
        border-left: 3px solid #6366f1;
        border-radius: 0.5rem;
        margin: 1rem 0;
    }

    /* First Letter Drop Cap */
    .article-content>p:first-of-type::first-letter {
        font-size: 3.5rem;
        font-weight: 700;
        line-height: 1;
        float: left;
        margin-right: 0.5rem;
        color: #6366f1;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .article-content {
            font-size: 1rem;
        }

        .article-content h1 {
            font-size: 2rem;
        }

        .article-content h2 {
            font-size: 1.5rem;
        }

        .article-content h3 {
            font-size: 1.25rem;
        }

        .article-content .alignleft,
        .article-content .alignright {
            float: none;
            margin: 1rem 0;
            max-width: 100%;
        }

        .article-content blockquote {
            padding: 1rem 1.5rem 1rem 3rem;
        }

        .article-content table {
            font-size: 0.875rem;
        }

        .article-content th,
        .article-content td {
            padding: 0.75rem;
        }
    }
</style>

<section class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Article Content with Enhanced Styling -->
        <article class="article-content">
            {!! $article->content !!}
        </article>

        <!-- Tags (if applicable) -->
        @if(isset($article->tags) && $article->tags)
        <div class="mt-12 pt-8 border-t border-gray-200">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Tags</h3>
            <div class="flex flex-wrap gap-2">
                @foreach(explode(',', $article->tags) as $tag)
                <span class="px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-full hover:bg-gray-200 transition-colors">
                    {{ trim($tag) }}
                </span>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Share Section -->
        <div class="mt-12 pt-8 border-t border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                </svg>
                Share this article
            </h3>
            <div class="flex flex-wrap gap-3">
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($article->title) }}"
                    target="_blank"
                    class="flex items-center space-x-2 px-4 py-2 bg-gray-100 rounded-lg text-gray-600 hover:bg-black hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                    </svg>
                    <span class="font-medium">Twitter</span>
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                    target="_blank"
                    class="flex items-center space-x-2 px-4 py-2 bg-gray-100 rounded-lg text-gray-600 hover:bg-black hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                    </svg>
                    <span class="font-medium">Facebook</span>
                </a>
                <a href="https://wa.me/?text={{ urlencode($article->title . ' - ' . request()->url()) }}"
                    target="_blank"
                    class="flex items-center space-x-2 px-4 py-2 bg-gray-100 rounded-lg text-gray-600 hover:bg-black hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                    </svg>
                    <span class="font-medium">WhatsApp</span>
                </a>
                <button onclick="copyToClipboard()"
                    class="flex items-center space-x-2 px-4 py-2 bg-gray-100 rounded-lg text-gray-600 hover:bg-black hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    <span class="font-medium">Copy Link</span>
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Related Articles -->
@if($relatedArticles->count() > 0)
<section class="py-16 bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-3">Related Articles</h2>
            <p class="text-gray-600">Continue reading with these related posts</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($relatedArticles as $related)
            <article class="group bg-white rounded-2xl overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-200">
                <div class="aspect-video bg-gradient-to-br from-gray-100 to-gray-200 overflow-hidden relative">
                    @if($related->featured_image)
                    <img src="{{ Storage::url($related->featured_image) }}"
                        alt="{{ $related->title }}"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    @else
                    <div class="w-full h-full flex items-center justify-center">
                        <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                    </div>
                    @endif
                    <div class="absolute top-3 right-3">
                        @if($related->category)
                        <span class="px-3 py-1 bg-white/90 backdrop-blur-sm text-gray-900 text-xs font-semibold rounded-full">
                            {{ $related->category->name }}
                        </span>
                        @endif
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-indigo-600 transition-colors line-clamp-2 leading-tight">
                        <a href="{{ route('articles.show', $related->slug) }}">{{ $related->title }}</a>
                    </h3>
                    <p class="text-gray-600 text-sm line-clamp-3 mb-4 leading-relaxed">
                        {{ $related->excerpt ?? Str::limit(strip_tags($related->content), 120) }}
                    </p>
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ $related->published_at->format('d M Y') }}
                        </span>
                        <a href="{{ route('articles.show', $related->slug) }}"
                            class="text-indigo-600 font-medium hover:text-indigo-700 flex items-center group/link">
                            Read more
                            <svg class="w-4 h-4 ml-1 transform group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif

@push('scripts')
<script>
    function copyToClipboard() {
        const url = window.location.href;
        navigator.clipboard.writeText(url).then(function() {
            // Create toast notification
            const toast = document.createElement('div');
            toast.className = 'fixed bottom-4 right-4 bg-gray-900 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform transition-all duration-300';
            toast.innerHTML = `
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Link copied to clipboard!</span>
                </div>
            `;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }, function() {
            alert('Failed to copy link');
        });
    }
</script>
@endpush
@endsection