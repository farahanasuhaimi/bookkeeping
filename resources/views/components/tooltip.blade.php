@props(['text'])

@if(auth()->check() && auth()->user()->show_tooltips)
<div class="group relative inline-flex items-center">
    <span class="material-symbols-outlined text-[16px] text-text-muted dark:text-gray-500 opacity-50 hover:opacity-100 transition-opacity duration-200 cursor-help">
        info
    </span>
    <span class="invisible group-hover:visible opacity-0 group-hover:opacity-100 absolute z-[1000] bg-slate-800 dark:bg-slate-700 text-slate-100 text-left px-3 py-2 rounded-lg text-xs font-medium leading-relaxed w-max max-w-[250px] sm:max-w-[250px] bottom-[125%] left-1/2 -translate-x-1/2 transition-all duration-300 shadow-lg pointer-events-none
        after:content-[''] after:absolute after:top-full after:left-1/2 after:-ml-[5px] after:border-[5px] after:border-solid after:border-slate-800 after:border-r-transparent after:border-b-transparent after:border-l-transparent
        dark:after:border-slate-700 dark:after:border-r-transparent dark:after:border-b-transparent dark:after:border-l-transparent">
        {{ $text }}
    </span>
</div>
@endif
