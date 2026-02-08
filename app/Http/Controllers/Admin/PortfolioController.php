<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolios = Portfolio::ordered()
            ->latest()
            ->paginate(10);

        return view('admin.portfolios.index', compact('portfolios'));
    }

    public function create()
    {
        return view('admin.portfolios.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'client_name' => 'nullable|string|max:255',
            'project_url' => 'nullable|url|max:255',
            'technologies' => 'nullable|string',
            'completed_at' => 'nullable|date',
            'is_featured' => 'boolean',
            'order' => 'integer',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('portfolios', 'public');
        }

        // Convert technologies string to array
        if (!empty($validated['technologies'])) {
            $validated['technologies'] = array_map('trim', explode(',', $validated['technologies']));
        }

        $validated['is_featured'] = $request->has('is_featured');

        Portfolio::create($validated);

        return redirect()->route('admin.portfolios.index')
            ->with('success', 'Portfolio berhasil dibuat!');
    }

    public function edit(Portfolio $portfolio)
    {
        return view('admin.portfolios.edit', compact('portfolio'));
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'client_name' => 'nullable|string|max:255',
            'project_url' => 'nullable|url|max:255',
            'technologies' => 'nullable|string',
            'completed_at' => 'nullable|date',
            'is_featured' => 'boolean',
            'order' => 'integer',
        ]);

        if ($request->hasFile('featured_image')) {
            if ($portfolio->featured_image) {
                Storage::disk('public')->delete($portfolio->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('portfolios', 'public');
        }

        // Convert technologies string to array
        if (!empty($validated['technologies'])) {
            $validated['technologies'] = array_map('trim', explode(',', $validated['technologies']));
        }

        $validated['is_featured'] = $request->has('is_featured');

        $portfolio->update($validated);

        return redirect()->route('admin.portfolios.index')
            ->with('success', 'Portfolio berhasil diupdate!');
    }

    public function destroy(Portfolio $portfolio)
    {
        if ($portfolio->featured_image) {
            Storage::disk('public')->delete($portfolio->featured_image);
        }

        $portfolio->delete();

        return redirect()->route('admin.portfolios.index')
            ->with('success', 'Portfolio berhasil dihapus!');
    }
}
