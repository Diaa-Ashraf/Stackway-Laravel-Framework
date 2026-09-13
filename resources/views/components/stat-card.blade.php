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
    $bgColor = $colorMap[$color] ?? $colorMap['primary'];
@endphp

<div class="sw-stat-card">
    <div class="sw-stat-icon" style="background: {{ $bgColor }}15; color: {{ $bgColor }};">
        @switch($icon)
            @case('users')
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                @break
            @case('orders')
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                @break
            @case('revenue')
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                @break
            @case('chart')
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
                @break
            @case('products')
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                @break
            @default
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
        @endswitch
    </div>
    <div class="flex-1">
        <div class="sw-stat-value">{{ $value }}</div>
        <div class="sw-stat-label">{{ $title }}</div>
        @if($change)
            <div class="sw-stat-change {{ $direction }}">
                @if($direction === 'up')
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m18 15-6-6-6 6"/></svg>
                @else
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
                @endif
                {{ $change }}
            </div>
        @endif
    </div>
</div>
