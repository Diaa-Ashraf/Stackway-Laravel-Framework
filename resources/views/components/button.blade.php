{{-- Stackway Button Component --}}
@props([
    'type' => 'button',
    'variant' => 'primary', // primary, secondary, danger, success, outline, ghost
    'size' => 'md', // sm, md, lg
    'icon' => null,
    'iconPosition' => 'start',
    'loading' => false,
    'href' => null,
])

@php
$baseClasses = 'inline-flex items-center justify-center font-medium rounded-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer';

$sizeClasses = match($size) {
    'sm' => 'px-3 py-1.5 text-xs gap-1.5',
    'lg' => 'px-6 py-3 text-base gap-2.5',
    default => 'px-4 py-2.5 text-sm gap-2',
};

$variantClasses = match($variant) {
    'primary' => 'bg-[var(--sw-primary)] hover:bg-[var(--sw-primary-hover)] text-white shadow-sm focus:ring-[var(--sw-primary)] focus:ring-2 focus:ring-offset-2',
    'secondary' => 'bg-[var(--sw-surface-hover)] hover:bg-[var(--sw-surface-pressed)] text-[var(--sw-text-primary)] border border-[var(--sw-border)] hover:border-[var(--sw-border-hover)] focus:ring-[var(--sw-primary)]',
    'danger' => 'bg-[var(--sw-danger)] hover:brightness-110 text-white shadow-sm focus:ring-[var(--sw-danger)]',
    'success' => 'bg-[var(--sw-success)] hover:brightness-110 text-white shadow-sm focus:ring-[var(--sw-success)]',
    'outline' => 'border border-[var(--sw-border)] hover:border-[var(--sw-border-hover)] hover:bg-[var(--sw-surface-hover)] text-[var(--sw-text-primary)] focus:ring-[var(--sw-primary)]',
    'ghost' => 'hover:bg-[var(--sw-surface-hover)] text-[var(--sw-text-secondary)] hover:text-[var(--sw-text-primary)] focus:ring-[var(--sw-primary)]',
    default => 'bg-[var(--sw-primary)] text-white',
};

$classes = "{$baseClasses} {$sizeClasses} {$variantClasses}";
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon && $iconPosition === 'start')
            <span class="flex-shrink-0">{!! $icon !!}</span>
        @endif
        <span>{{ $slot }}</span>
        @if($icon && $iconPosition === 'end')
            <span class="flex-shrink-0">{!! $icon !!}</span>
        @endif
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon && $iconPosition === 'start')
            <span class="flex-shrink-0">{!! $icon !!}</span>
        @endif
        <span>{{ $slot }}</span>
        @if($icon && $iconPosition === 'end')
            <span class="flex-shrink-0">{!! $icon !!}</span>
        @endif
    </button>
@endif
