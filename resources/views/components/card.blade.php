{{-- Stackway Card Component --}}
@props([
    'title' => null,
    'subtitle' => null,
    'headerActions' => null,
    'footer' => null,
    'padding' => 'p-6',
])

<div {{ $attributes->merge(['class' => 'sw-card rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-sm transition-all duration-200 overflow-hidden']) }}>
    @if($title || $headerActions || isset($header))
        <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between gap-4">
            @if(isset($header))
                {{ $header }}
            @else
                <div>
                    @if($title)
                        <h3 class="text-base font-semibold text-slate-800 dark:text-slate-100">{{ $title }}</h3>
                    @endif
                    @if($subtitle)
                        <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">{{ $subtitle }}</p>
                    @endif
                </div>
                @if($headerActions)
                    <div class="flex items-center gap-2">
                        {!! $headerActions !!}
                    </div>
                @endif
            @endif
        </div>
    @endif

    <div class="{{ $padding }}">
        {{ $slot }}
    </div>

    @if($footer || isset($footerSlot))
        <div class="px-6 py-3.5 bg-slate-50/50 dark:bg-slate-900/50 border-t border-slate-100 dark:border-slate-800">
            @if(isset($footerSlot))
                {{ $footerSlot }}
            @else
                {!! $footer !!}
            @endif
        </div>
    @endif
</div>
