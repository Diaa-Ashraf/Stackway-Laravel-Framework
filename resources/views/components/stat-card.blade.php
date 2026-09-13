{{-- Stackway Stat Card --}}
{{-- Usage: <x-sw-stat-card title="المستخدمين" value="1,245" icon="users" color="primary" change="+12%" direction="up" /> --}}

@props([
    'title' => '',
    'value' => '0',
    'icon' => 'chart',
    'color' => 'primary',
    'change' => null,
    'direction' => 'up',
])

@php
    $colorMap = [
        'primary'   => 'var(--sw-primary)',
        'secondary' => 'var(--sw-secondary)',
        'success'   => 'var(--sw-success)',
        'danger'    => 'var(--sw-danger)',
        'warning'   => 'var(--sw-warning)',
        'info'      => 'var(--sw-info)',
    ];
    $badgeBgMap = [
        'primary'   => 'var(--sw-primary-50)',
        'secondary' => 'rgba(2, 132, 199, 0.12)',
        'success'   => 'var(--sw-success-50)',
        'danger'    => 'var(--sw-danger-50)',
        'warning'   => 'rgba(217, 119, 6, 0.12)',
        'info'      => 'rgba(2, 132, 199, 0.12)',
    ];
    $iconColor = $colorMap[$color] ?? $colorMap['primary'];
    $iconBg = $badgeBgMap[$color] ?? $badgeBgMap['primary'];
@endphp

<div class="sw-card p-5 flex items-center gap-4 transition-all"
     style="background: var(--sw-surface-card); border: 1px solid var(--sw-border);">
    <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
         style="background: {{ $iconBg }}; color: {{ $iconColor }};">
        @switch($icon)
            @case('users')
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                @break
            @case('orders')
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                @break
            @case('revenue')
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                @break
            @case('chart')
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
                @break
            @case('products')
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
                @break
            @default
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
        @endswitch
    </div>
    <div class="flex-1 min-w-0">
        <div class="text-xl font-bold font-mono tracking-tight" style="color: var(--sw-text-primary); line-height: 1.2;">{{ $value }}</div>
        <div class="text-xs mt-0.5 truncate" style="color: var(--sw-text-muted); font-weight: 500;">{{ $title }}</div>
        @if($change)
            <div class="text-xs font-semibold mt-1 inline-flex items-center gap-1"
                 style="color: {{ $direction === 'up' ? 'var(--sw-success)' : 'var(--sw-danger)' }};">
                @if($direction === 'up')
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m18 15-6-6-6 6"/></svg>
                @else
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m6 9 6 6 6-6"/></svg>
                @endif
                {{ $change }}
            </div>
        @endif
    </div>
</div>
