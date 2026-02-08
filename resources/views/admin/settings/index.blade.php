@extends('layouts.admin')

@section('title', 'Settings')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-900">Settings</h1>
    <p class="text-slate-600">Manage your website settings</p>
</div>

<form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf

    <div class="space-y-6">
        <!-- General Settings -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">General Settings</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="site_name" class="block text-sm font-medium text-slate-700 mb-2">Site Name *</label>
                    <input type="text" id="site_name" name="site_name" value="{{ $settings['site_name'] }}" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div>
                    <label for="site_tagline" class="block text-sm font-medium text-slate-700 mb-2">Tagline</label>
                    <input type="text" id="site_tagline" name="site_tagline" value="{{ $settings['site_tagline'] }}"
                        class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div class="md:col-span-2">
                    <label for="site_description" class="block text-sm font-medium text-slate-700 mb-2">Site Description</label>
                    <textarea id="site_description" name="site_description" rows="3"
                        class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 resize-none">{{ $settings['site_description'] }}</textarea>
                </div>
            </div>
        </div>

        <!-- Contact Settings -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Contact Information</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="contact_email" class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                    <input type="email" id="contact_email" name="contact_email" value="{{ $settings['contact_email'] }}"
                        class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div>
                    <label for="contact_phone" class="block text-sm font-medium text-slate-700 mb-2">Phone</label>
                    <input type="text" id="contact_phone" name="contact_phone" value="{{ $settings['contact_phone'] }}"
                        class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div class="md:col-span-2">
                    <label for="contact_address" class="block text-sm font-medium text-slate-700 mb-2">Address</label>
                    <textarea id="contact_address" name="contact_address" rows="2"
                        class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 resize-none">{{ $settings['contact_address'] }}</textarea>
                </div>
            </div>
        </div>

        <!-- Social Media -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Social Media</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="social_facebook" class="block text-sm font-medium text-slate-700 mb-2">Facebook</label>
                    <input type="url" id="social_facebook" name="social_facebook" value="{{ $settings['social_facebook'] }}"
                        class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="https://facebook.com/...">
                </div>

                <div>
                    <label for="social_twitter" class="block text-sm font-medium text-slate-700 mb-2">Twitter</label>
                    <input type="url" id="social_twitter" name="social_twitter" value="{{ $settings['social_twitter'] }}"
                        class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="https://twitter.com/...">
                </div>

                <div>
                    <label for="social_instagram" class="block text-sm font-medium text-slate-700 mb-2">Instagram</label>
                    <input type="url" id="social_instagram" name="social_instagram" value="{{ $settings['social_instagram'] }}"
                        class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="https://instagram.com/...">
                </div>

                <div>
                    <label for="social_linkedin" class="block text-sm font-medium text-slate-700 mb-2">LinkedIn</label>
                    <input type="url" id="social_linkedin" name="social_linkedin" value="{{ $settings['social_linkedin'] }}"
                        class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="https://linkedin.com/...">
                </div>

                <div>
                    <label for="social_github" class="block text-sm font-medium text-slate-700 mb-2">GitHub</label>
                    <input type="url" id="social_github" name="social_github" value="{{ $settings['social_github'] }}"
                        class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="https://github.com/...">
                </div>
            </div>
        </div>

        <!-- About -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">About Content</h3>

            <div class="space-y-6">
                <div>
                    <label for="about_short" class="block text-sm font-medium text-slate-700 mb-2">Short About</label>
                    <textarea id="about_short" name="about_short" rows="2"
                        class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 resize-none"
                        placeholder="Brief description for homepage">{{ $settings['about_short'] }}</textarea>
                </div>

                <div>
                    <label for="about_full" class="block text-sm font-medium text-slate-700 mb-2">Full About</label>
                    <textarea id="about_full" name="about_full" rows="6"
                        class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 resize-y"
                        placeholder="Full description for about page">{{ $settings['about_full'] }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition-colors">
                Save Settings
            </button>
        </div>
    </div>
</form>
@endsection