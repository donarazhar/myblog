@extends('layouts.admin')

@section('title', 'Backups')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Database Backups</h1>
        <p class="text-gray-500 mt-1">Kelola backup database ke Google Drive</p>
    </div>
    <form action="{{ route('admin.backups.create') }}" method="POST">
        @csrf
        <button type="submit" class="inline-flex items-center px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800 transition-colors font-medium" onclick="this.disabled=true; this.innerText='Membuat backup...'; this.form.submit();">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Buat Backup Baru
        </button>
    </form>
</div>

{{-- Google Drive Status --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
    <div class="flex items-center space-x-3">
        <div class="flex-shrink-0">
            <svg class="w-8 h-8 text-blue-500" viewBox="0 0 24 24" fill="currentColor">
                <path d="M7.71 3.5L1.15 15l3.43 6h6.4L4.56 9.5l3.15-6zM16.29 3.5l-3.15 6 6.43 12h3.43l-6.43-12-3.28-6zM8 14l3.15-6h6.4l-3.15 6H8z" />
            </svg>
        </div>
        <div>
            <h3 class="font-semibold text-gray-900">Google Drive</h3>
            @if($error)
            <p class="text-sm text-red-500">{{ $error }}</p>
            @else
            <p class="text-sm text-green-600">✅ Terhubung — {{ count($backups) }} backup tersimpan</p>
            @endif
        </div>
    </div>
</div>

{{-- Backup List --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    @if(count($backups) > 0)
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama File</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ukuran</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($backups as $backup)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                        </svg>
                        <span class="text-sm font-medium text-gray-900">{{ $backup['name'] }}</span>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $backup['size'] }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $backup['date'] }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                    <div class="flex items-center justify-end space-x-2">
                        <a href="{{ route('admin.backups.download', $backup['name']) }}"
                            class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition-colors text-xs font-medium">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Download
                        </a>
                        <form action="{{ route('admin.backups.destroy', $backup['name']) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus backup ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition-colors text-xs font-medium">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="text-center py-12">
        <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
        </svg>
        <p class="text-gray-500 text-sm">Belum ada backup. Klik "Buat Backup Baru" untuk memulai.</p>
    </div>
    @endif
</div>

{{-- Setup Guide --}}
@if($error)
<div class="mt-6 bg-amber-50 border border-amber-200 rounded-xl p-6">
    <h3 class="font-semibold text-amber-800 mb-3">📋 Cara Setup Google Drive</h3>
    <ol class="text-sm text-amber-700 space-y-2 list-decimal list-inside">
        <li>Buka <a href="https://console.cloud.google.com/" target="_blank" class="underline font-medium">Google Cloud Console</a></li>
        <li>Buat project baru atau pilih project yang ada</li>
        <li>Aktifkan <strong>Google Drive API</strong> di menu "APIs & Services"</li>
        <li>Buat <strong>OAuth 2.0 Client ID</strong> (tipe: Web Application)</li>
        <li>Set Redirect URI: <code class="bg-amber-100 px-1 rounded">https://developers.google.com/oauthplayground</code></li>
        <li>Buka <a href="https://developers.google.com/oauthplayground" target="_blank" class="underline font-medium">OAuth Playground</a></li>
        <li>Klik ⚙️ Settings → centang "Use your own OAuth credentials" → masukkan Client ID & Secret</li>
        <li>Authorize scope: <code class="bg-amber-100 px-1 rounded">https://www.googleapis.com/auth/drive.file</code></li>
        <li>Exchange authorization code → dapatkan <strong>Refresh Token</strong></li>
        <li>Buat folder di Google Drive untuk backup → salin Folder ID dari URL</li>
        <li>Tambahkan ke file <code class="bg-amber-100 px-1 rounded">.env</code>:</li>
    </ol>
    <pre class="mt-3 bg-amber-100 rounded-lg p-3 text-xs text-amber-900 overflow-x-auto">GOOGLE_DRIVE_CLIENT_ID=your-client-id
GOOGLE_DRIVE_CLIENT_SECRET=your-client-secret
GOOGLE_DRIVE_REFRESH_TOKEN=your-refresh-token
GOOGLE_DRIVE_FOLDER_ID=your-folder-id</pre>
</div>
@endif
@endsection