<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $articles = Article::published()
            ->orderBy('published_at', 'desc')
            ->get();

        $categories = Category::has('articles')->get();

        $content = view('sitemap.index', compact('articles', 'categories'));

        return response($content, 200)
            ->header('Content-Type', 'application/xml');
    }
}
