<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Portfolio;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic stats
        $stats = [
            'total_articles' => Article::count(),
            'published_articles' => Article::published()->count(),
            'draft_articles' => Article::draft()->count(),
            'total_views' => Article::sum('views'),
            'total_categories' => Category::count(),
            'total_portfolios' => Portfolio::count(),
            'total_users' => User::count(),
            'unread_messages' => ContactMessage::unread()->count(),
        ];

        // Articles per month (last 12 months) - pre-computed arrays
        $chartMonthLabels = [];
        $chartMonthData = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $chartMonthLabels[] = $date->format('M Y');
            $chartMonthData[] = Article::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        // Articles per category - pre-computed arrays
        $categories = Category::withCount('articles')->orderByDesc('articles_count')->get();
        $chartCatLabels = $categories->pluck('name')->values()->toArray();
        $chartCatData = $categories->pluck('articles_count')->values()->toArray();

        // Top 5 most viewed articles - pre-computed arrays
        $topArticles = Article::select('title', 'views', 'slug')
            ->orderByDesc('views')
            ->take(5)
            ->get();
        $chartTopLabels = $topArticles->pluck('title')->map(function ($t) {
            return Str::limit($t, 35);
        })->values()->toArray();
        $chartTopData = $topArticles->pluck('views')->values()->toArray();

        // Article status distribution
        $statusDistribution = [
            'published' => Article::published()->count(),
            'draft' => Article::draft()->count(),
        ];

        // Publication dates for calendar
        $publicationDates = Article::published()
            ->select('title', 'published_at', 'slug')
            ->get()
            ->map(function ($a) {
                return [
                    'title' => $a->title,
                    'date' => $a->published_at->format('Y-m-d'),
                    'slug' => $a->slug,
                ];
            })
            ->values()
            ->toArray();

        // Recent articles
        $recentArticles = Article::with(['user', 'category'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'chartMonthLabels',
            'chartMonthData',
            'chartCatLabels',
            'chartCatData',
            'chartTopLabels',
            'chartTopData',
            'statusDistribution',
            'publicationDates',
            'recentArticles'
        ));
    }
}
