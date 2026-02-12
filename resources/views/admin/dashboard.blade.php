@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-slate-900">Dashboard</h1>
    <p class="text-slate-600">Welcome back! Here's an overview of your blog.</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
    <div class="bg-white rounded-xl shadow-lg p-5 border-l-4 border-indigo-600">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Articles</p>
                <p class="text-2xl font-bold text-slate-900 mt-1">{{ $stats['total_articles'] }}</p>
            </div>
            <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-5 border-l-4 border-green-600">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Published</p>
                <p class="text-2xl font-bold text-slate-900 mt-1">{{ $stats['published_articles'] }}</p>
            </div>
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-5 border-l-4 border-yellow-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Drafts</p>
                <p class="text-2xl font-bold text-slate-900 mt-1">{{ $stats['draft_articles'] }}</p>
            </div>
            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-5 border-l-4 border-cyan-600">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Total Views</p>
                <p class="text-2xl font-bold text-slate-900 mt-1">{{ number_format($stats['total_views']) }}</p>
            </div>
            <div class="w-10 h-10 bg-cyan-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-5 border-l-4 border-purple-600">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Categories</p>
                <p class="text-2xl font-bold text-slate-900 mt-1">{{ $stats['total_categories'] }}</p>
            </div>
            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-5 border-l-4 border-rose-600">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Messages</p>
                <p class="text-2xl font-bold text-slate-900 mt-1">{{ $stats['unread_messages'] }}</p>
            </div>
            <div class="w-10 h-10 bg-rose-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row 1: Articles per Month + Articles by Category -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-lg font-bold text-slate-900 mb-4">📊 Articles per Month</h2>
        <div class="relative" style="height: 300px;">
            <canvas id="articlesPerMonthChart"></canvas>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-lg font-bold text-slate-900 mb-4">📁 Articles by Category</h2>
        <div class="relative" style="height: 300px;">
            <canvas id="articlesByCategoryChart"></canvas>
        </div>
    </div>
</div>

<!-- Charts Row 2: Top Viewed + Status Distribution -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-lg font-bold text-slate-900 mb-4">🔥 Top 5 Most Viewed Articles</h2>
        <div class="relative" style="height: 280px;">
            <canvas id="topArticlesChart"></canvas>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-lg font-bold text-slate-900 mb-4">📈 Article Status</h2>
        <div class="relative flex items-center justify-center" style="height: 280px;">
            <canvas id="statusChart"></canvas>
        </div>
    </div>
</div>

<!-- Calendar + Recent Articles -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Publication Calendar -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-slate-900">📅 Publication Calendar</h2>
            <div class="flex items-center space-x-2">
                <button id="calPrev" class="p-2 rounded-lg hover:bg-slate-100 transition-colors text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <span id="calMonthYear" class="text-sm font-semibold text-slate-700 min-w-[120px] text-center"></span>
                <button id="calNext" class="p-2 rounded-lg hover:bg-slate-100 transition-colors text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </div>
        <div id="calendarGrid" class="select-none"></div>
        <div id="calTooltip" class="hidden absolute z-50 bg-slate-800 text-white text-xs rounded-lg px-3 py-2 shadow-lg max-w-[220px] pointer-events-none"></div>
    </div>

    <!-- Recent Articles -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-slate-900">📝 Recent Articles</h2>
            <a href="{{ route('admin.articles.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">View All</a>
        </div>

        @if($recentArticles->count() > 0)
        <div class="space-y-3">
            @foreach($recentArticles as $article)
            <div class="flex items-center space-x-4 p-3 rounded-lg hover:bg-slate-50 transition-colors">
                <div class="w-12 h-12 bg-slate-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    @if($article->featured_image)
                    <img src="{{ Storage::url($article->featured_image) }}" alt="" class="w-full h-full object-cover rounded-lg">
                    @else
                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-slate-900 truncate">{{ $article->title }}</p>
                    <div class="flex items-center space-x-3 mt-1">
                        <p class="text-xs text-slate-500">{{ $article->created_at->diffForHumans() }}</p>
                        <span class="text-xs text-slate-400">•</span>
                        <p class="text-xs text-slate-500">{{ number_format($article->views) }} views</p>
                    </div>
                </div>
                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $article->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                    {{ ucfirst($article->status) }}
                </span>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-slate-500 text-sm">No articles yet.</p>
        @endif
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-xl shadow-lg p-6 mb-8">
    <h2 class="text-lg font-bold text-slate-900 mb-4">⚡ Quick Actions</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('admin.articles.create') }}" class="flex items-center space-x-3 p-4 bg-indigo-50 rounded-xl hover:bg-indigo-100 transition-colors">
            <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
            </div>
            <span class="font-medium text-slate-700">New Article</span>
        </a>

        <a href="{{ route('admin.categories.create') }}" class="flex items-center space-x-3 p-4 bg-purple-50 rounded-xl hover:bg-purple-100 transition-colors">
            <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
            </div>
            <span class="font-medium text-slate-700">New Category</span>
        </a>

        <a href="{{ route('admin.portfolios.create') }}" class="flex items-center space-x-3 p-4 bg-teal-50 rounded-xl hover:bg-teal-100 transition-colors">
            <div class="w-10 h-10 bg-teal-600 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
            </div>
            <span class="font-medium text-slate-700">New Portfolio</span>
        </a>

        <a href="{{ route('admin.settings.index') }}" class="flex items-center space-x-3 p-4 bg-slate-50 rounded-xl hover:bg-slate-100 transition-colors">
            <div class="w-10 h-10 bg-slate-600 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <span class="font-medium text-slate-700">Settings</span>
        </a>
    </div>
</div>
@endsection

@push('scripts')
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ─── Color Palette ───
        const colors = {
            indigo: {
                bg: 'rgba(79, 70, 229, 0.15)',
                border: 'rgba(79, 70, 229, 1)',
                fill: 'rgba(79, 70, 229, 0.3)'
            },
            purple: {
                bg: 'rgba(147, 51, 234, 0.8)',
                border: 'rgba(147, 51, 234, 1)'
            },
            teal: {
                bg: 'rgba(20, 184, 166, 0.8)',
                border: 'rgba(20, 184, 166, 1)'
            },
            rose: {
                bg: 'rgba(244, 63, 94, 0.8)',
                border: 'rgba(244, 63, 94, 1)'
            },
            amber: {
                bg: 'rgba(245, 158, 11, 0.8)',
                border: 'rgba(245, 158, 11, 1)'
            },
            cyan: {
                bg: 'rgba(6, 182, 212, 0.8)',
                border: 'rgba(6, 182, 212, 1)'
            },
            emerald: {
                bg: 'rgba(16, 185, 129, 0.8)',
                border: 'rgba(16, 185, 129, 1)'
            },
            sky: {
                bg: 'rgba(14, 165, 233, 0.8)',
                border: 'rgba(14, 165, 233, 1)'
            },
        };
        const categoryColors = [colors.indigo, colors.purple, colors.teal, colors.rose, colors.amber, colors.cyan, colors.emerald, colors.sky];

        const defaultOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: {
                        font: {
                            family: "'Inter', sans-serif",
                            size: 12
                        },
                        padding: 16
                    }
                },
            },
        };

        // ─── 1. Articles per Month (Area Chart) ───
        const monthLabels = @json($chartMonthLabels);
        const monthData = @json($chartMonthData);

        new Chart(document.getElementById('articlesPerMonthChart'), {
            type: 'line',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'Articles',
                    data: monthData,
                    borderColor: colors.indigo.border,
                    backgroundColor: colors.indigo.fill,
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: colors.indigo.border,
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                }]
            },
            options: {
                ...defaultOptions,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            font: {
                                family: "'Inter', sans-serif",
                                size: 11
                            }
                        },
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        },
                    },
                    x: {
                        ticks: {
                            font: {
                                family: "'Inter', sans-serif",
                                size: 11
                            },
                            maxRotation: 45
                        },
                        grid: {
                            display: false
                        },
                    },
                },
                plugins: {
                    ...defaultOptions.plugins,
                    legend: {
                        display: false
                    }
                },
            }
        });

        // ─── 2. Articles by Category (Doughnut Chart) ───
        const catLabels = @json($chartCatLabels);
        const catData = @json($chartCatData);
        const catColors = categoryColors.slice(0, catLabels.length);

        new Chart(document.getElementById('articlesByCategoryChart'), {
            type: 'doughnut',
            data: {
                labels: catLabels,
                datasets: [{
                    data: catData,
                    backgroundColor: catColors.map(c => c.bg),
                    borderColor: catColors.map(c => c.border),
                    borderWidth: 2,
                    hoverOffset: 8,
                }]
            },
            options: {
                ...defaultOptions,
                cutout: '60%',
                plugins: {
                    ...defaultOptions.plugins,
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: {
                                family: "'Inter', sans-serif",
                                size: 11
                            },
                            padding: 12,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                },
            }
        });

        // ─── 3. Top 5 Most Viewed (Horizontal Bar Chart) ───
        const topLabels = @json($chartTopLabels);
        const topData = @json($chartTopData);
        const barColors = [colors.indigo, colors.purple, colors.teal, colors.rose, colors.amber];

        new Chart(document.getElementById('topArticlesChart'), {
            type: 'bar',
            data: {
                labels: topLabels,
                datasets: [{
                    label: 'Views',
                    data: topData,
                    backgroundColor: barColors.map(c => c.bg),
                    borderColor: barColors.map(c => c.border),
                    borderWidth: 2,
                    borderRadius: 6,
                    barThickness: 32,
                }]
            },
            options: {
                ...defaultOptions,
                indexAxis: 'y',
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            font: {
                                family: "'Inter', sans-serif",
                                size: 11
                            }
                        },
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        },
                    },
                    y: {
                        ticks: {
                            font: {
                                family: "'Inter', sans-serif",
                                size: 11
                            }
                        },
                        grid: {
                            display: false
                        },
                    },
                },
                plugins: {
                    ...defaultOptions.plugins,
                    legend: {
                        display: false
                    }
                },
            }
        });

        // ─── 4. Status Distribution (Pie Chart) ───
        new Chart(document.getElementById('statusChart'), {
            type: 'pie',
            data: {
                labels: ['Published', 'Draft'],
                datasets: [{
                    data: @json(array_values($statusDistribution)),
                    backgroundColor: [colors.emerald.bg, colors.amber.bg],
                    borderColor: [colors.emerald.border, colors.amber.border],
                    borderWidth: 2,
                    hoverOffset: 8,
                }]
            },
            options: {
                ...defaultOptions,
                plugins: {
                    ...defaultOptions.plugins,
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: {
                                family: "'Inter', sans-serif",
                                size: 12
                            },
                            padding: 16,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                },
            }
        });

        // ─── 5. Publication Calendar ───
        const pubDates = @json($publicationDates);
        let calDate = new Date();

        function renderCalendar(year, month) {
            const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            document.getElementById('calMonthYear').textContent = monthNames[month] + ' ' + year;

            const firstDay = new Date(year, month, 1).getDay(); // 0=Sun
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const today = new Date();

            // Build date map for this month
            const dateMap = {};
            pubDates.forEach(p => {
                const d = new Date(p.date);
                if (d.getFullYear() === year && d.getMonth() === month) {
                    const key = d.getDate();
                    if (!dateMap[key]) dateMap[key] = [];
                    dateMap[key].push(p.title);
                }
            });

            let html = '<div class="grid grid-cols-7 gap-1 text-center">';
            // Day headers
            ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'].forEach(d => {
                html += '<div class="text-xs font-semibold text-slate-400 py-2">' + d + '</div>';
            });
            // Empty cells before first day
            for (let i = 0; i < firstDay; i++) {
                html += '<div class="py-2"></div>';
            }
            // Day cells
            for (let day = 1; day <= daysInMonth; day++) {
                const isToday = (today.getFullYear() === year && today.getMonth() === month && today.getDate() === day);
                const hasArticle = dateMap[day];
                let classes = 'relative py-2 rounded-lg text-sm cursor-default transition-colors ';
                if (isToday) {
                    classes += 'bg-indigo-600 text-white font-bold ';
                } else if (hasArticle) {
                    classes += 'bg-indigo-50 text-indigo-700 font-semibold hover:bg-indigo-100 ';
                } else {
                    classes += 'text-slate-600 hover:bg-slate-50 ';
                }
                html += '<div class="' + classes + '" ' + (hasArticle ? 'data-articles="' + hasArticle.map(t => t.replace(/"/g, '&quot;')).join('|') + '"' : '') + '>';
                html += day;
                if (hasArticle) {
                    html += '<span class="absolute bottom-0.5 left-1/2 -translate-x-1/2 w-1.5 h-1.5 rounded-full ' + (isToday ? 'bg-white' : 'bg-indigo-500') + '"></span>';
                }
                html += '</div>';
            }
            html += '</div>';
            document.getElementById('calendarGrid').innerHTML = html;

            // Tooltips
            const tooltip = document.getElementById('calTooltip');
            document.querySelectorAll('[data-articles]').forEach(el => {
                el.addEventListener('mouseenter', function(e) {
                    const titles = this.dataset.articles.split('|');
                    tooltip.innerHTML = titles.map(t => '• ' + t).join('<br>');
                    tooltip.classList.remove('hidden');
                    const rect = this.getBoundingClientRect();
                    tooltip.style.left = rect.left + 'px';
                    tooltip.style.top = (rect.bottom + 6) + 'px';
                });
                el.addEventListener('mouseleave', function() {
                    tooltip.classList.add('hidden');
                });
            });
        }

        document.getElementById('calPrev').addEventListener('click', () => {
            calDate.setMonth(calDate.getMonth() - 1);
            renderCalendar(calDate.getFullYear(), calDate.getMonth());
        });
        document.getElementById('calNext').addEventListener('click', () => {
            calDate.setMonth(calDate.getMonth() + 1);
            renderCalendar(calDate.getFullYear(), calDate.getMonth());
        });

        renderCalendar(calDate.getFullYear(), calDate.getMonth());
    });
</script>
@endpush