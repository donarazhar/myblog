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
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-black font-medium transition-colors duration-200 {{ request()->routeIs('home') ? 'text-black' : '' }}">Home</a>
                    <a href="{{ route('about') }}" class="text-gray-600 hover:text-black font-medium transition-colors duration-200 {{ request()->routeIs('about') ? 'text-black' : '' }}">About</a>
                    <a href="{{ route('articles.index') }}" class="text-gray-600 hover:text-black font-medium transition-colors duration-200 {{ request()->routeIs('articles.*') ? 'text-black' : '' }}">Articles</a>

                    <!-- Animasi Dropdown -->
                    <div class="relative" id="animasi-dropdown">
                        <button type="button" class="flex items-center gap-1 text-gray-600 hover:text-black font-medium transition-colors duration-200 {{ request()->routeIs('handconnect') || request()->routeIs('xrayvision') || request()->routeIs('particletext') || request()->routeIs('airdrawer') ? 'text-black' : '' }}" id="animasi-btn">
                            Animasi
                            <svg class="w-4 h-4 transition-transform duration-200" id="animasi-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div class="absolute top-full left-1/2 -translate-x-1/2 mt-2 w-52 bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden opacity-0 invisible translate-y-2 transition-all duration-200" id="animasi-menu">
                            <div class="py-2">
                                <a href="{{ route('handconnect') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 hover:text-black transition-colors">
                                    <span class="w-6 h-6 rounded-lg bg-gradient-to-br from-cyan-400 to-blue-500 flex items-center justify-center text-white text-xs">🖐</span>
                                    Hand Connect
                                </a>
                                <a href="{{ route('xrayvision') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 hover:text-black transition-colors">
                                    <span class="w-6 h-6 rounded-lg bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white text-xs">🔬</span>
                                    Xray Vision
                                </a>
                                <a href="{{ route('particletext') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 hover:text-black transition-colors">
                                    <span class="w-6 h-6 rounded-lg bg-gradient-to-br from-purple-400 to-pink-500 flex items-center justify-center text-white text-xs">✨</span>
                                    Particle Text
                                </a>
                                <a href="{{ route('airdrawer') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 hover:text-black transition-colors">
                                    <span class="w-6 h-6 rounded-lg bg-gradient-to-br from-orange-400 to-red-500 flex items-center justify-center text-white text-xs">🎨</span>
                                    Air Drawer
                                </a>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('contact') }}" class="text-gray-600 hover:text-black font-medium transition-colors duration-200 {{ request()->routeIs('contact') ? 'text-black' : '' }}">Contact</a>
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
                <a href="{{ route('home') }}" class="block px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-black font-medium transition-colors">Home</a>
                <a href="{{ route('about') }}" class="block px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-black font-medium transition-colors">About</a>
                <a href="{{ route('articles.index') }}" class="block px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-black font-medium transition-colors">Articles</a>

                <!-- Mobile Animasi Submenu -->
                <div>
                    <button type="button" class="flex items-center justify-between w-full px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-black font-medium transition-colors" id="mobile-animasi-btn">
                        Animasi
                        <svg class="w-4 h-4 transition-transform duration-200" id="mobile-animasi-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="hidden pl-4 mt-1 space-y-1" id="mobile-animasi-menu">
                        <a href="{{ route('handconnect') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm text-gray-500 hover:bg-gray-100 hover:text-black transition-colors">
                            <span>🖐</span> Hand Connect
                        </a>
                        <a href="{{ route('xrayvision') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm text-gray-500 hover:bg-gray-100 hover:text-black transition-colors">
                            <span>🔬</span> Xray Vision
                        </a>
                        <a href="{{ route('particletext') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm text-gray-500 hover:bg-gray-100 hover:text-black transition-colors">
                            <span>✨</span> Particle Text
                        </a>
                        <a href="{{ route('airdrawer') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm text-gray-500 hover:bg-gray-100 hover:text-black transition-colors">
                            <span>🎨</span> Air Drawer
                        </a>
                    </div>
                </div>

                <a href="{{ route('contact') }}" class="block px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-black font-medium transition-colors">Contact</a>
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

        // Desktop Animasi Dropdown
        const animasiDropdown = document.getElementById('animasi-dropdown');
        const animasiMenu = document.getElementById('animasi-menu');
        const animasiArrow = document.getElementById('animasi-arrow');
        let dropdownTimeout;

        animasiDropdown.addEventListener('mouseenter', () => {
            clearTimeout(dropdownTimeout);
            animasiMenu.classList.remove('opacity-0', 'invisible', 'translate-y-2');
            animasiMenu.classList.add('opacity-100', 'visible', 'translate-y-0');
            animasiArrow.classList.add('rotate-180');
        });
        animasiDropdown.addEventListener('mouseleave', () => {
            dropdownTimeout = setTimeout(() => {
                animasiMenu.classList.add('opacity-0', 'invisible', 'translate-y-2');
                animasiMenu.classList.remove('opacity-100', 'visible', 'translate-y-0');
                animasiArrow.classList.remove('rotate-180');
            }, 150);
        });

        // Mobile Animasi Submenu
        const mobileAnimasiBtn = document.getElementById('mobile-animasi-btn');
        const mobileAnimasiMenu = document.getElementById('mobile-animasi-menu');
        const mobileAnimasiArrow = document.getElementById('mobile-animasi-arrow');

        mobileAnimasiBtn.addEventListener('click', () => {
            mobileAnimasiMenu.classList.toggle('hidden');
            mobileAnimasiArrow.classList.toggle('rotate-180');
        });
    </script>

    @stack('scripts')
</body>

</html>