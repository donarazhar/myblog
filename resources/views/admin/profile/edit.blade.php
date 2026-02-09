@extends('layouts.admin')

@section('title', 'Edit Profile')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-900">Profile</h1>
    <p class="text-slate-600">Kelola informasi profile dan password Anda</p>
</div>

<div class="space-y-6">
    <!-- Profile Information -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-slate-900 mb-1">Informasi Profile</h3>
        <p class="text-sm text-slate-500 mb-6">Perbarui nama dan email akun Anda.</p>

        <form action="{{ route('admin.profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Nama *</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror">
                    @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email *</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('email') border-red-500 @enderror">
                    @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <!-- Update Password -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-slate-900 mb-1">Ubah Password</h3>
        <p class="text-sm text-slate-500 mb-6">Pastikan akun Anda menggunakan password yang kuat dan aman.</p>

        <form action="{{ route('admin.profile.password') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <div class="max-w-md">
                    <label for="current_password" class="block text-sm font-medium text-slate-700 mb-2">Password Lama *</label>
                    <input type="password" id="current_password" name="current_password" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('current_password') border-red-500 @enderror">
                    @error('current_password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Password Baru *</label>
                        <input type="password" id="password" name="password" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('password') border-red-500 @enderror">
                        @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-2">Konfirmasi Password Baru *</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition-colors">
                    Ubah Password
                </button>
            </div>
        </form>
    </div>
</div>
@endsection