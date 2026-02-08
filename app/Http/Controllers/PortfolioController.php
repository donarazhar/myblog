<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolios = Portfolio::ordered()
            ->latest()
            ->paginate(12);

        return view('portfolios.index', compact('portfolios'));
    }

    public function show(string $slug)
    {
        $portfolio = Portfolio::where('slug', $slug)->firstOrFail();

        $relatedPortfolios = Portfolio::where('id', '!=', $portfolio->id)
            ->ordered()
            ->take(3)
            ->get();

        return view('portfolios.show', compact('portfolio', 'relatedPortfolios'));
    }
}
