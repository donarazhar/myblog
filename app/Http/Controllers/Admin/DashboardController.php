<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

        // Articles per month (last 12 months)
        $monthsBack = 12;
        $articlesPerMonth = [];
        for ($i = $monthsBack - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $count = Article::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $articlesPerMonth[] = [
                'label' => $date->format('M Y'),
                'count' => $count,
            ];
        }

        // Articles per category
        $articlesPerCategory = Category::withCount('articles')
            ->orderByDesc('articles_count')
            ->get()
            ->map(fn($cat) => [
                'name' => $cat->name,
                'count' => $cat->articles_count,
            ]);

        // Top 5 most viewed articles
        $topArticles = Article::select('title', 'views', 'slug')
            ->orderByDesc('views')
            ->take(5)
            ->get();

        // Article status distribution
        $statusDistribution = [
            'published' => Article::published()->count(),
            'draft' => Article::draft()->count(),
        ];

        // Publication dates for calendar (all published articles)
        $publicationDates = Article::published()
            ->select('title', 'published_at', 'slug')
            ->get()
            ->map(fn($a) => [
                'title' => $a->title,
                'date' => $a->published_at->format('Y-m-d'),
                'slug' => $a->slug,
            ]);

        // Recent articles
        $recentArticles = Article::with(['user', 'category'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'articlesPerMonth',
            'articlesPerCategory',
            'topArticles',
            'statusDistribution',
            'publicationDates',
            'recentArticles'
        ));
    }
}
