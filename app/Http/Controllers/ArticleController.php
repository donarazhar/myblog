<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::published()
            ->with(['user', 'category'])
            ->latest('published_at')
            ->paginate(10);

        $categories = Category::withCount(['articles' => function ($query) {
            $query->published();
        }])->get();

        return view('articles.index', compact('articles', 'categories'));
    }

    public function show(string $slug)
    {
        $article = Article::where('slug', $slug)
            ->published()
            ->with(['user', 'category'])
            ->firstOrFail();

        // Increment views
        $article->increment('views');

        $relatedArticles = Article::published()
            ->where('id', '!=', $article->id)
            ->when($article->category_id, function ($query) use ($article) {
                return $query->where('category_id', $article->category_id);
            })
            ->take(3)
            ->get();

        return view('articles.show', compact('article', 'relatedArticles'));
    }

    public function category(string $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $articles = Article::published()
            ->where('category_id', $category->id)
            ->with(['user', 'category'])
            ->latest('published_at')
            ->paginate(9);

        $categories = Category::withCount(['articles' => function ($query) {
            $query->published();
        }])->get();

        return view('articles.index', compact('articles', 'categories', 'category'));
    }
}
