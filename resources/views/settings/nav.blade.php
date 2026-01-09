<div class="mb-8 border-b border-border-light dark:border-border-dark">
    <div class="flex gap-8">
        <a href="{{ route('settings.profile') }}" 
            class="group flex flex-col items-center justify-center border-b-[3px] {{ $active_tab === 'profile' ? 'border-b-primary' : 'border-b-transparent hover:border-b-border-light' }} pb-[13px] pt-4 px-2 outline-none focus:outline-none transition-all">
            <p class="{{ $active_tab === 'profile' ? 'text-text-main dark:text-white' : 'text-text-muted dark:text-gray-400 group-hover:text-text-main dark:group-hover:text-white' }} text-sm font-bold leading-normal tracking-[0.015em] transition-colors">Profile & Security</p>
        </a>
        <a href="{{ route('settings.payment-methods') }}" 
            class="group flex flex-col items-center justify-center border-b-[3px] {{ $active_tab === 'payment-methods' ? 'border-b-primary' : 'border-b-transparent hover:border-b-border-light' }} pb-[13px] pt-4 px-2 outline-none focus:outline-none transition-all">
            <p class="{{ $active_tab === 'payment-methods' ? 'text-text-main dark:text-white' : 'text-text-muted dark:text-gray-400 group-hover:text-text-main dark:group-hover:text-white' }} text-sm font-bold leading-normal tracking-[0.015em] transition-colors">Payment Methods</p>
        </a>
        <a href="{{ route('settings.categories') }}" 
            class="group flex flex-col items-center justify-center border-b-[3px] {{ $active_tab === 'categories' ? 'border-b-primary' : 'border-b-transparent hover:border-b-border-light' }} pb-[13px] pt-4 px-2 outline-none focus:outline-none transition-all">
            <p class="{{ $active_tab === 'categories' ? 'text-text-main dark:text-white' : 'text-text-muted dark:text-gray-400 group-hover:text-text-main dark:group-hover:text-white' }} text-sm font-bold leading-normal tracking-[0.015em] transition-colors">Categories</p>
        </a>
    </div>
</div>
