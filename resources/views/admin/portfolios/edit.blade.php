@extends('layouts.admin')

@section('title', 'Edit Portfolio')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.portfolios.index') }}" class="text-slate-600 hover:text-slate-900 inline-flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Back to Portfolios
    </a>
    <h1 class="text-2xl font-bold text-slate-900 mt-2">Edit Portfolio</h1>
</div>

<form action="{{ route('admin.portfolios.update', $portfolio) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-lg p-6 space-y-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-slate-700 mb-2">Title *</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $portfolio->title) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700 mb-2">Description *</label>
                    <textarea id="description" name="description" rows="3" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 resize-none">{{ old('description', $portfolio->description) }}</textarea>
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-slate-700 mb-2">Content</label>
                    <textarea id="content" name="content" rows="10"
                        class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 resize-y">{{ old('content', $portfolio->content) }}</textarea>
                </div>

                <div>
                    <label for="technologies" class="block text-sm font-medium text-slate-700 mb-2">Technologies</label>
                    <input type="text" id="technologies" name="technologies" value="{{ old('technologies', is_array($portfolio->technologies) ? implode(', ', $portfolio->technologies) : '') }}"
                        class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                        placeholder="Laravel, Vue.js, MySQL (comma separated)">
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-lg p-6 space-y-4">
                <h3 class="text-lg font-semibold text-slate-900">Details</h3>

                <div>
                    <label for="client_name" class="block text-sm font-medium text-slate-700 mb-2">Client Name</label>
                    <input type="text" id="client_name" name="client_name" value="{{ old('client_name', $portfolio->client_name) }}"
                        class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                </div>

                <div>
                    <label for="project_url" class="block text-sm font-medium text-slate-700 mb-2">Project URL</label>
                    <input type="url" id="project_url" name="project_url" value="{{ old('project_url', $portfolio->project_url) }}"
                        class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                </div>

                <div>
                    <label for="completed_at" class="block text-sm font-medium text-slate-700 mb-2">Completed Date</label>
                    <input type="date" id="completed_at" name="completed_at" value="{{ old('completed_at', $portfolio->completed_at?->format('Y-m-d')) }}"
                        class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                </div>

                <div>
                    <label for="order" class="block text-sm font-medium text-slate-700 mb-2">Order</label>
                    <input type="number" id="order" name="order" value="{{ old('order', $portfolio->order) }}"
                        class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $portfolio->is_featured) ? 'checked' : '' }}
                        class="w-4 h-4 text-teal-600 border-slate-300 rounded focus:ring-teal-500">
                    <label for="is_featured" class="ml-2 text-sm text-slate-700">Featured Project</label>
                </div>

                <button type="submit" class="w-full px-6 py-3 bg-teal-600 text-white font-medium rounded-xl hover:bg-teal-700 transition-colors">
                    Update Portfolio
                </button>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Featured Image</h3>
                @if($portfolio->featured_image)
                <div class="mb-4">
                    <img src="{{ Storage::url($portfolio->featured_image) }}" alt="" class="w-full h-32 object-cover rounded-lg">
                </div>
                @endif
                <input type="file" id="featured_image" name="featured_image" accept="image/*"
                    class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
            </div>
        </div>
    </div>
</form>
@endsection