{{-- Stackway Card Component --}}
@props([
    'title' => null,
    'subtitle' => null,
    'headerActions' => null,
    'footer' => null,
    'padding' => 'p-6',
])

<div {{ $attributes->merge(['class' => 'sw-card rounded-2xl shadow-sm transition-all duration-200 overflow-hidden']) }}
     style="background: var(--sw-surface-card); border: 1px solid var(--sw-border);">
    @if($title || $headerActions || isset($header))
        <div class="px-6 py-4 flex items-center justify-between gap-4" style="border-bottom: 1px solid var(--sw-border);">
            @if(isset($header))
                {{ $header }}
            @else
                <div>
                    @if($title)
                        <h3 class="text-base font-bold" style="color: var(--sw-text-primary);">{{ $title }}</h3>
                    @endif
                    @if($subtitle)
                        <p class="text-xs mt-0.5" style="color: var(--sw-text-muted);">{{ $subtitle }}</p>
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

    <div class="{{ $padding }}" style="color: var(--sw-text-secondary);">
        {{ $slot }}
    </div>

    @if($footer || isset($footerSlot))
        <div class="px-6 py-3.5" style="background: var(--sw-surface-hover); border-top: 1px solid var(--sw-border); color: var(--sw-text-secondary);">
            @if(isset($footerSlot))
                {{ $footerSlot }}
            @else
                {!! $footer !!}
            @endif
        </div>
    @endif
</div>
