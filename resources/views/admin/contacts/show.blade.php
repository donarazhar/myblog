@extends('layouts.admin')

@section('title', 'View Message')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.contacts.index') }}" class="text-slate-600 hover:text-slate-900 inline-flex items-center group">
        <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Kembali ke Daftar Pesan
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-slate-50 border-b border-slate-200 px-6 py-4">
                <h1 class="text-xl font-bold text-slate-900">{{ $contact->subject }}</h1>
            </div>

            <!-- Message Body -->
            <div class="p-6">
                <div class="prose max-w-none">
                    <p class="text-slate-700 whitespace-pre-wrap leading-relaxed">{{ $contact->message }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Sender Info -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-4">Pengirim</h3>

            <div class="flex items-center space-x-4 mb-4">
                <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center flex-shrink-0">
                    <span class="text-white font-bold text-xl">{{ strtoupper(substr($contact->name, 0, 1)) }}</span>
                </div>
                <div>
                    <p class="font-semibold text-slate-900 text-lg">{{ $contact->name }}</p>
                    <p class="text-slate-500">{{ $contact->email }}</p>
                </div>
            </div>

            <div class="border-t border-slate-100 pt-4 mt-4">
                <div class="flex items-center text-slate-600 text-sm mb-2">
                    <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ $contact->created_at->format('d M Y, H:i') }}
                </div>
                <div class="flex items-center text-slate-600 text-sm">
                    <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ $contact->is_read ? 'Sudah dibaca' : 'Belum dibaca' }}
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-4">Aksi</h3>

            <div class="space-y-4">
                <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}"
                    class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition-all hover:shadow-lg hover:shadow-indigo-500/25">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Balas via Email
                </a>

                <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-red-50 text-red-600 font-medium rounded-xl hover:bg-red-100 transition-all border border-red-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Hapus Pesan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection