@extends('layouts.main')

@section('dashboard-content')
<div class="px-6 py-12 max-w-4xl mx-auto">
    <div class="mb-8">
        <h2 class="text-3xl font-black text-text-main dark:text-white mb-2 italic">Settings</h2>
        <p class="text-text-muted dark:text-gray-400">Manage your account preferences and security.</p>
    </div>

    @include('settings.nav')

    <div class="grid lg:grid-cols-2 gap-8">
        <!-- Profile Section -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-3xl p-8 border border-border-light dark:border-border-dark shadow-sm">
            <h3 class="text-lg font-bold text-text-main dark:text-white mb-6 italic flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">person</span>
                Personal Information
            </h3>
            
            <form action="{{ route('settings.profile.update') }}" method="POST" class="space-y-5">
                @csrf
                @method('PATCH')
                
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-text-muted mb-2">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full rounded-xl border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark text-text-main dark:text-white px-4 py-3 focus:border-primary focus:ring-primary">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-text-muted mb-2">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full rounded-xl border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark text-text-main dark:text-white px-4 py-3 focus:border-primary focus:ring-primary">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="bg-primary hover:bg-primary/90 text-text-main font-black px-6 py-3 rounded-xl transition-all hover:scale-[1.02] italic">
                    SAVE CHANGES
                </button>
            </form>
        </div>

        <!-- Password Section -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-3xl p-8 border border-border-light dark:border-border-dark shadow-sm">
            <h3 class="text-lg font-bold text-text-main dark:text-white mb-6 italic flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">security</span>
                Security & Password
            </h3>
            
            <form action="{{ route('settings.password.update') }}" method="POST" class="space-y-5">
                @csrf
                @method('PATCH')
                
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-text-muted mb-2">Current Password</label>
                    <input type="password" name="current_password" required
                        class="w-full rounded-xl border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark text-text-main dark:text-white px-4 py-3 focus:border-primary focus:ring-primary">
                    @error('current_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-text-muted mb-2">New Password</label>
                    <input type="password" name="password" required
                        class="w-full rounded-xl border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark text-text-main dark:text-white px-4 py-3 focus:border-primary focus:ring-primary">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-text-muted mb-2">Confirm New Password</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full rounded-xl border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark text-text-main dark:text-white px-4 py-3 focus:border-primary focus:ring-primary">
                </div>

                <button type="submit" class="bg-primary hover:bg-primary/90 text-text-main font-black px-6 py-3 rounded-xl transition-all hover:scale-[1.02] italic">
                    UPDATE PASSWORD
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
