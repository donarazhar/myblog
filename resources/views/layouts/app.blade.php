<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Iqra bismi rabbikalladzi khalaq - Landasi setiap aktivitas literasi, riset, dan teknologi dengan niat karena Allah.')">
    <meta name="robots" content="index, follow">
    <meta name="author" content="DnrAzhr">
    <link rel="canonical" href="{{ url()->current() }}">
    <title>@yield('title', 'DnrAzhr Blog') | {{ config('app.name') }}</title>

    <!-- Google Analytics -->
    @if(config('services.google.analytics_id'))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.google.analytics_id') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', "{{ config('services.google.analytics_id') }}");
    </script>
    @endif


    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'My Blog') | {{ config('app.name') }}">
    <meta property="og:description" content="@yield('meta_description', 'Iqra bismi rabbikalladzi khalaq - Landasi setiap aktivitas literasi, riset, dan teknologi dengan niat karena Allah.')">
    <meta property="og:image" content="@yield('meta_image', asset('img/myimage.png'))">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', 'My Blog') | {{ config('app.name') }}">
    <meta property="twitter:description" content="@yield('meta_description', 'Iqra bismi rabbikalladzi khalaq - Landasi setiap aktivitas literasi, riset, dan teknologi dengan niat karena Allah.')">
    <meta property="twitter:image" content="@yield('meta_image', asset('img/myimage.png'))">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">

    <!-- JSON-LD Structured Data -->
    <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@@type": "WebSite",
            "name": "DnrAzhr Blog",
            "url": "{{ url('/') }}",
            "description": "Iqra bismi rabbikalladzi khalaq - Landasi setiap aktivitas literasi, riset, dan teknologi dengan niat karena Allah.",
            "potentialAction": {
                "@@type": "SearchAction",
                "target": "{{ url('/articles') }}?q={search_term_string}",
                "query-input": "required name=search_term_string"
            }
        }
    </script>
    @stack('structured_data')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .content-container {
            max-width: 85%;
            margin-left: auto;
            margin-right: auto;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</head>

<body class="bg-white text-gray-900 antialiased">
    <!-- Navigation - Full Width Background -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-lg border-b border-gray-200 transition-all duration-300" id="navbar">
        <div class="content-container px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-2 group">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center overflow-hidden shadow-lg group-hover:scale-105 transition-all duration-300">
                        <img src="{{ asset('img/favicon.png') }}" alt="Logo" class="w-full h-full object-cover">
                    </div>
                    <span class="text-xl font-bold text-black">DnrAzhr Blog</span>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-black font-medium transition-colors duration-200 {{ request()->routeIs('home') ? 'text-black' : '' }}">Beranda</a>
                    <a href="{{ route('about') }}" class="text-gray-600 hover:text-black font-medium transition-colors duration-200 {{ request()->routeIs('about') ? 'text-black' : '' }}">Tentang</a>
                    <a href="{{ route('articles.index') }}" class="text-gray-600 hover:text-black font-medium transition-colors duration-200 {{ request()->routeIs('articles.*') ? 'text-black' : '' }}">Artikel</a>

                    <!-- Animasi Dropdown -->
                    <div class="relative" id="animasi-dropdown">
                        <button type="button" class="flex items-center gap-1 text-gray-600 hover:text-black font-medium transition-colors duration-200 {{ request()->routeIs('handconnect') || request()->routeIs('xrayvision') || request()->routeIs('particletext') || request()->routeIs('airdrawer') || request()->routeIs('threejsparticle') || request()->routeIs('magicspells') || request()->routeIs('soundvisualizer') || request()->routeIs('solarsystem') || request()->routeIs('fireengine') || request()->routeIs('handpen') || request()->routeIs('narutohands') ? 'text-black' : '' }}" id="animasi-btn">
                            Animasi
                            <svg class="w-4 h-4 transition-transform duration-200" id="animasi-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div class="absolute top-full left-1/2 -translate-x-1/2 mt-2 bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden" id="animasi-menu" style="display:none; white-space:nowrap; min-width:200px;">
                            <div class="py-2">
                                <a href="{{ route('handconnect') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 hover:text-black transition-colors">
                                    <span class="w-6 h-6 rounded-lg bg-gradient-to-br from-cyan-400 to-blue-500 flex items-center justify-center text-white text-xs">🖐</span>
                                    Aura Tangan
                                </a>
                                <a href="{{ route('xrayvision') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 hover:text-black transition-colors">
                                    <span class="w-6 h-6 rounded-lg bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white text-xs">🔬</span>
                                    Pemindai X-Ray
                                </a>
                                <a href="{{ route('particletext') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 hover:text-black transition-colors">
                                    <span class="w-6 h-6 rounded-lg bg-gradient-to-br from-purple-400 to-pink-500 flex items-center justify-center text-white text-xs">✨</span>
                                    Teks Partikel
                                </a>
                                <a href="{{ route('airdrawer') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 hover:text-black transition-colors">
                                    <span class="w-6 h-6 rounded-lg bg-gradient-to-br from-orange-400 to-red-500 flex items-center justify-center text-white text-xs">🎨</span>
                                    Kanvas Udara
                                </a>
                                <a href="{{ route('threejsparticle') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 hover:text-black transition-colors">
                                    <span class="w-6 h-6 rounded-lg bg-gradient-to-br from-blue-400 to-indigo-600 flex items-center justify-center text-white text-xs">🌀</span>
                                    Partikel 3D
                                </a>
                                <a href="{{ route('magicspells') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 hover:text-black transition-colors">
                                    <span class="w-6 h-6 rounded-lg bg-gradient-to-br from-yellow-400 to-amber-600 flex items-center justify-center text-white text-xs">🔥</span>
                                    Lingkaran Sihir
                                </a>
                                <a href="{{ route('soundvisualizer') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 hover:text-black transition-colors">
                                    <span class="w-6 h-6 rounded-lg bg-gradient-to-br from-violet-400 to-fuchsia-600 flex items-center justify-center text-white text-xs">🎵</span>
                                    Visualisasi Suara
                                </a>
                                <a href="{{ route('solarsystem') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 hover:text-black transition-colors">
                                    <span class="w-6 h-6 rounded-lg bg-gradient-to-br from-sky-400 to-blue-700 flex items-center justify-center text-white text-xs">🪐</span>
                                    Tata Surya
                                </a>
                                <a href="{{ route('fireengine') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 hover:text-black transition-colors">
                                    <span class="w-6 h-6 rounded-lg bg-gradient-to-br from-red-500 to-orange-600 flex items-center justify-center text-white text-xs">🔥</span>
                                    Mesin Api
                                </a>
                                <a href="{{ route('handpen') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 hover:text-black transition-colors">
                                    <span class="w-6 h-6 rounded-lg bg-gradient-to-br from-yellow-400 to-yellow-600 flex items-center justify-center text-white text-xs">✍️</span>
                                    Pena Tangan
                                </a>
                                <a href="{{ route('narutohands') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 hover:text-black transition-colors">
                                    <span class="w-6 h-6 rounded-lg bg-gradient-to-br from-orange-500 to-blue-600 flex items-center justify-center text-white text-xs">🥷</span>
                                    Jutsu Tangan
                                </a>

                            </div>
                        </div>
                    </div>

                    <!-- Belajar Dropdown -->
                    <div class="relative" id="belajar-dropdown">
                        <button type="button" class="flex items-center gap-1 text-gray-600 hover:text-black font-medium transition-colors duration-200 {{ request()->routeIs('animath') ? 'text-black' : '' }}" id="belajar-btn">
                            Belajar
                            <svg class="w-4 h-4 transition-transform duration-200" id="belajar-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div class="absolute top-full left-1/2 -translate-x-1/2 mt-2 bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden" id="belajar-menu" style="display:none; white-space:nowrap; min-width:200px;">
                            <div class="py-2">
                                <a href="{{ route('animath') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 hover:text-black transition-colors">
                                    <span class="w-6 h-6 rounded-lg bg-gradient-to-br from-violet-500 to-fuchsia-600 flex items-center justify-center text-white text-xs">🧮</span>
                                    Animath (Matematika)
                                </a>
                                <span class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-300 cursor-not-allowed" title="Segera Hadir">
                                    <span class="w-6 h-6 rounded-lg bg-gray-200 flex items-center justify-center text-gray-400 text-xs">🇬🇧</span>
                                    English <span class="ml-auto text-xs bg-gray-100 text-gray-400 px-2 py-0.5 rounded-full">Soon</span>
                                </span>
                                <span class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-300 cursor-not-allowed" title="Segera Hadir">
                                    <span class="w-6 h-6 rounded-lg bg-gray-200 flex items-center justify-center text-gray-400 text-xs">🔬</span>
                                    Sains <span class="ml-auto text-xs bg-gray-100 text-gray-400 px-2 py-0.5 rounded-full">Soon</span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('contact') }}" class="text-gray-600 hover:text-black font-medium transition-colors duration-200 {{ request()->routeIs('contact') ? 'text-black' : '' }}">Kontak</a>
                </div>

                <!-- Mobile Menu Button -->
                <button type="button" class="md:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100 transition-colors" id="mobile-menu-button">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="hidden md:hidden bg-white border-t border-gray-200" id="mobile-menu">
            <div class="content-container px-4 py-4 space-y-2">
                <a href="{{ route('home') }}" class="block px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-black font-medium transition-colors">Beranda</a>
                <a href="{{ route('about') }}" class="block px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-black font-medium transition-colors">Tentang</a>
                <a href="{{ route('articles.index') }}" class="block px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-black font-medium transition-colors">Artikel</a>

                <!-- Mobile Animasi Submenu -->
                <div>
                    <button type="button" class="flex items-center justify-between w-full px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-black font-medium transition-colors" id="mobile-animasi-btn">
                        Animasi
                        <svg class="w-4 h-4 transition-transform duration-200" id="mobile-animasi-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="hidden pl-4 mt-1 space-y-1" id="mobile-animasi-menu">
                        <a href="{{ route('handconnect') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm text-gray-500 hover:bg-gray-100 hover:text-black transition-colors">
                            <span>🖐</span> Aura Tangan
                        </a>
                        <a href="{{ route('xrayvision') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm text-gray-500 hover:bg-gray-100 hover:text-black transition-colors">
                            <span>🔬</span> Pemindai X-Ray
                        </a>
                        <a href="{{ route('particletext') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm text-gray-500 hover:bg-gray-100 hover:text-black transition-colors">
                            <span>✨</span> Teks Partikel
                        </a>
                        <a href="{{ route('airdrawer') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm text-gray-500 hover:bg-gray-100 hover:text-black transition-colors">
                            <span>🎨</span> Kanvas Udara
                        </a>
                        <a href="{{ route('threejsparticle') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm text-gray-500 hover:bg-gray-100 hover:text-black transition-colors">
                            <span>🌀</span> Partikel 3D
                        </a>
                        <a href="{{ route('magicspells') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm text-gray-500 hover:bg-gray-100 hover:text-black transition-colors">
                            <span>🔥</span> Lingkaran Sihir
                        </a>
                        <a href="{{ route('soundvisualizer') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm text-gray-500 hover:bg-gray-100 hover:text-black transition-colors">
                            <span>🎵</span> Visualisasi Suara
                        </a>
                        <a href="{{ route('solarsystem') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm text-gray-500 hover:bg-gray-100 hover:text-black transition-colors">
                            <span>🪐</span> Tata Surya
                        </a>
                        <a href="{{ route('fireengine') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm text-gray-500 hover:bg-gray-100 hover:text-black transition-colors">
                            <span>🔥</span> Mesin Api
                        </a>
                        <a href="{{ route('handpen') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm text-gray-500 hover:bg-gray-100 hover:text-black transition-colors">
                            <span>✍️</span> Pena Tangan
                        </a>
                        <a href="{{ route('narutohands') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm text-gray-500 hover:bg-gray-100 hover:text-black transition-colors">
                            <span>🥷</span> Jutsu Tangan
                        </a>

                    </div>
                </div>

                <!-- Mobile Belajar Submenu -->
                <div>
                    <button type="button" class="flex items-center justify-between w-full px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-black font-medium transition-colors" id="mobile-belajar-btn">
                        Belajar
                        <svg class="w-4 h-4 transition-transform duration-200" id="mobile-belajar-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="hidden pl-4 mt-1 space-y-1" id="mobile-belajar-menu">
                        <a href="{{ route('animath') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm text-gray-500 hover:bg-gray-100 hover:text-black transition-colors">
                            <span>🧮</span> Animath (Matematika)
                        </a>
                        <span class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm text-gray-300 cursor-not-allowed">
                            <span>🇬🇧</span> English <span class="ml-auto text-xs bg-gray-100 text-gray-400 px-1.5 py-0.5 rounded-full">Soon</span>
                        </span>
                        <span class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm text-gray-300 cursor-not-allowed">
                            <span>🔬</span> Sains <span class="ml-auto text-xs bg-gray-100 text-gray-400 px-1.5 py-0.5 rounded-full">Soon</span>
                        </span>
                    </div>
                </div>

                <a href="{{ route('contact') }}" class="block px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-black font-medium transition-colors">Kontak</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-16">
        @yield('content')
    </main>

    <!-- Simple Footer - Full Width Background -->
    <footer class="bg-black">
        <div class="content-container px-4 sm:px-6 lg:px-8 py-12">
            <div class="text-center text-gray-400 text-sm">
                <p>&copy; {{ date('Y') }} DnrAzhr Blog. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Navbar background on scroll
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('shadow-lg');
            } else {
                navbar.classList.remove('shadow-lg');
            }
        });

        // Desktop Animasi Dropdown (click toggle + click outside to close)
        const animasiBtn = document.getElementById('animasi-btn');
        const animasiMenu = document.getElementById('animasi-menu');
        const animasiArrow = document.getElementById('animasi-arrow');
        const animasiDropdown = document.getElementById('animasi-dropdown');
        let animasiOpen = false;

        function openAnimasiMenu() {
            animasiOpen = true;
            animasiMenu.style.display = 'block';
            animasiArrow.style.transform = 'rotate(180deg)';
        }

        function closeAnimasiMenu() {
            animasiOpen = false;
            animasiMenu.style.display = 'none';
            animasiArrow.style.transform = '';
        }

        animasiBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            if (animasiOpen) { closeAnimasiMenu(); } else { openAnimasiMenu(); }
        });

        // Close when clicking anywhere outside
        document.addEventListener('click', function(e) {
            if (animasiOpen && !animasiDropdown.contains(e.target)) {
                closeAnimasiMenu();
            }
        });

        // Close on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && animasiOpen) closeAnimasiMenu();
        });

        // Mobile Animasi Submenu
        const mobileAnimasiBtn = document.getElementById('mobile-animasi-btn');
        const mobileAnimasiMenu = document.getElementById('mobile-animasi-menu');
        const mobileAnimasiArrow = document.getElementById('mobile-animasi-arrow');

        mobileAnimasiBtn.addEventListener('click', () => {
            mobileAnimasiMenu.classList.toggle('hidden');
            mobileAnimasiArrow.classList.toggle('rotate-180');
        });

        // Desktop Belajar Dropdown (click toggle + click outside to close)
        const belajarBtn = document.getElementById('belajar-btn');
        const belajarMenu = document.getElementById('belajar-menu');
        const belajarArrow = document.getElementById('belajar-arrow');
        const belajarDropdown = document.getElementById('belajar-dropdown');
        let belajarOpen = false;

        function openBelajarMenu() {
            belajarOpen = true;
            belajarMenu.style.display = 'block';
            belajarArrow.style.transform = 'rotate(180deg)';
            // Close Animasi if open
            if (animasiOpen) closeAnimasiMenu();
        }

        function closeBelajarMenu() {
            belajarOpen = false;
            belajarMenu.style.display = 'none';
            belajarArrow.style.transform = '';
        }

        belajarBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            if (belajarOpen) { closeBelajarMenu(); } else { openBelajarMenu(); }
        });

        document.addEventListener('click', function(e) {
            if (belajarOpen && !belajarDropdown.contains(e.target)) {
                closeBelajarMenu();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && belajarOpen) closeBelajarMenu();
        });

        // Mobile Belajar Submenu
        const mobileBelajarBtn = document.getElementById('mobile-belajar-btn');
        const mobileBelajarMenu = document.getElementById('mobile-belajar-menu');
        const mobileBelajarArrow = document.getElementById('mobile-belajar-arrow');

        mobileBelajarBtn.addEventListener('click', () => {
            mobileBelajarMenu.classList.toggle('hidden');
            mobileBelajarArrow.classList.toggle('rotate-180');
        });
    </script>

    @stack('scripts')
</body>

</html>