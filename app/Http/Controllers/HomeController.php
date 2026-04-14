<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Setting;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

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

    public function animasi()
    {
        return view('pages.animasi');
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

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        ContactMessage::create($validated);

        return redirect()->route('contact')
            ->with('success', 'Pesan Anda berhasil dikirim! Kami akan segera menghubungi Anda.');
    }
}
