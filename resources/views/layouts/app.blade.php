<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Company Profile & Portfolio - Pembuatan Aplikasi')">
    <title>@yield('title', 'DnrAzhr Blog') | {{ config('app.name') }}</title>

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'My Blog') | {{ config('app.name') }}">
    <meta property="og:description" content="@yield('meta_description', 'Company Profile & Portfolio - Pembuatan Aplikasi')">
    <meta property="og:image" content="@yield('meta_image', asset('img/myimage.png'))">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', 'My Blog') | {{ config('app.name') }}">
    <meta property="twitter:description" content="@yield('meta_description', 'Company Profile & Portfolio - Pembuatan Aplikasi')">
    <meta property="twitter:image" content="@yield('meta_image', asset('img/myimage.png'))">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">

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
    </script>

    @stack('scripts')
</body>

</html>