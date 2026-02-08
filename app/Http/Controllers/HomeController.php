<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        $featuredArticles = Article::published()
            ->with(['user', 'category'])
            ->latest('published_at')
            ->take(5)
            ->get();

        $settings = Setting::getAllSettings();

        return view('pages.home', compact('featuredArticles', 'settings'));
    }

    public function about()
    {
        $settings = Setting::getAllSettings();
        return view('pages.about', compact('settings'));
    }

    public function contact()
    {
        $settings = Setting::getAllSettings();
        return view('pages.contact', compact('settings'));
    }
}
