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
    'primary' => 'bg-[var(--sw-primary)] hover:bg-[var(--sw-primary-hover)] text-white shadow-sm shadow-[var(--sw-primary)]/25 focus:ring-[var(--sw-primary)]',
    'secondary' => 'bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 focus:ring-slate-400',
    'danger' => 'bg-rose-500 hover:bg-rose-600 text-white shadow-sm shadow-rose-500/25 focus:ring-rose-500',
    'success' => 'bg-emerald-500 hover:bg-emerald-600 text-white shadow-sm shadow-emerald-500/25 focus:ring-emerald-500',
    'outline' => 'border border-slate-300 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800/50 text-slate-700 dark:text-slate-200 focus:ring-[var(--sw-primary)]',
    'ghost' => 'hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-300 focus:ring-slate-400',
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
