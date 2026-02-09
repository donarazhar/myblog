@extends('layouts.app')

@section('title', 'About Us')
@section('meta_description', 'Learn more about our company and what we do')

@section('content')
<!-- Dark Divider -->
<div class="h-1 bg-black"></div>

<!-- About Content -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl font-bold text-black mb-6">Mengenal lebih dekat</h2>
                <p class="text-lg text-gray-600 mb-6">
                    {{ $settings['about_short'] ?? 'Seorang yang ingin terus bermanfaat bagi sesama.' }}
                </p>
                <div class="prose prose-gray max-w-none">
                    {!! nl2br(e($settings['about_full'] ?? 'Tiada kata terbaik hanya dengan kalimat bismillah dengan mengharap ridha ALLAH SWT.')) !!}
                </div>
            </div>

            <div class="relative">
                <div class="aspect-square bg-black rounded-3xl shadow-2xl flex items-center justify-center overflow-hidden">
                    <img src="{{ asset('img/about.png') }}" alt="About Us" class="w-full h-full object-cover">
                </div>
                <!-- Decorative elements -->
                <div class="absolute -top-4 -right-4 w-24 h-24 bg-gray-200 rounded-2xl -z-10"></div>
                <div class="absolute -bottom-4 -left-4 w-32 h-32 bg-gray-100 rounded-2xl -z-10"></div>
            </div>
        </div>
    </div>
</section>
@endsection