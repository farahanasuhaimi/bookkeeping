@extends('layouts.main')

@section('dashboard-content')
<div class="px-6 py-12 max-w-4xl mx-auto">
    <div class="mb-8">
        <h2 class="text-3xl font-black text-text-main dark:text-white mb-2 italic">Settings</h2>
        <p class="text-text-muted dark:text-gray-400">Manage your account preferences and security.</p>
    </div>

    @include('settings.nav')

    <div class="bg-surface-light dark:bg-surface-dark rounded-3xl p-8 border border-border-light dark:border-border-dark shadow-sm">
        <h3 class="text-lg font-bold text-text-main dark:text-white mb-6 italic flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">tune</span>
            Display Preferences
        </h3>
        
        @if(session('success'))
            <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 px-4 py-3 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('settings.preferences.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PATCH')
            
            <!-- Show Tooltips Toggle -->
            <div class="flex items-start justify-between p-5 rounded-2xl bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1">
                        <label for="show_tooltips" class="text-sm font-bold text-text-main dark:text-white cursor-pointer">
                            Show Tooltips
                        </label>
                        <span class="material-symbols-outlined text-[16px] text-primary">help</span>
                    </div>
                    <p class="text-xs text-text-muted dark:text-gray-400 leading-relaxed">
                        Display helpful information icons throughout the app. Hover over these icons to see explanations of features, metrics, and functionality.
                    </p>
                </div>
                <div class="ml-4">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="show_tooltips" id="show_tooltips" value="1" 
                            {{ old('show_tooltips', $user->show_tooltips) ? 'checked' : '' }}
                            class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 dark:bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                    </label>
                </div>
            </div>

            <button type="submit" class="bg-primary hover:bg-primary/90 text-text-main font-black px-6 py-3 rounded-xl transition-all hover:scale-[1.02] italic">
                SAVE PREFERENCES
            </button>
        </form>
    </div>
</div>
@endsection
