@extends('layouts.admin')

@section('title', 'Portfolios')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Portfolios</h1>
        <p class="text-slate-600">Manage your project portfolios</p>
    </div>
    <a href="{{ route('admin.portfolios.create') }}" class="px-4 py-2 bg-teal-600 text-white font-medium rounded-lg hover:bg-teal-700 transition-colors inline-flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        New Portfolio
    </a>
</div>

<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <table class="w-full">
        <thead class="bg-slate-50">
            <tr>
                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase">Title</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase">Client</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase">Featured</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase">Date</th>
                <th class="px-6 py-4 text-right text-xs font-semibold text-slate-600 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200">
            @forelse($portfolios as $portfolio)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            @if($portfolio->featured_image)
                            <img src="{{ Storage::url($portfolio->featured_image) }}" alt="" class="w-full h-full object-cover rounded-lg">
                            @else
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            @endif
                        </div>
                        <p class="font-medium text-slate-900">{{ Str::limit($portfolio->title, 40) }}</p>
                    </div>
                </td>
                <td class="px-6 py-4 text-slate-600">{{ $portfolio->client_name ?? '-' }}</td>
                <td class="px-6 py-4">
                    @if($portfolio->is_featured)
                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs font-medium rounded-full">Featured</span>
                    @else
                    <span class="text-slate-400">-</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-slate-600 text-sm">{{ $portfolio->completed_at?->format('M Y') ?? '-' }}</td>
                <td class="px-6 py-4 text-right">
                    <div class="flex items-center justify-end space-x-2">
                        <a href="{{ route('admin.portfolios.edit', $portfolio) }}" class="p-2 text-slate-400 hover:text-teal-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </a>
                        <form action="{{ route('admin.portfolios.destroy', $portfolio) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-slate-400 hover:text-red-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-12 text-center text-slate-500">No portfolios found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">{{ $portfolios->links() }}</div>
@endsection