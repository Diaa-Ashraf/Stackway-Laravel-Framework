{{-- Stackway Stat Card (InApp Design) --}}
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
    $validColors = ['primary', 'secondary', 'success', 'danger', 'warning', 'info'];
    $c = in_array($color, $validColors) ? $color : 'primary';
@endphp

<div class="card p-3 p-xl-4 bg-{{ $c }}-subtle border border-{{ $c }}-subtle rounded-3">
    <div class="d-flex align-items-center gap-3">
        <div class="icon-shape icon-md bg-{{ $c }} text-white rounded-2">
            @switch($icon)
                @case('users')
                    <i class="ti ti-users fs-4"></i>
                    @break
                @case('orders')
                @case('cart')
                    <i class="ti ti-shopping-cart fs-4"></i>
                    @break
                @case('revenue')
                    <i class="ti ti-currency-dollar fs-4"></i>
                    @break
                @case('products')
                    <i class="ti ti-box-seam fs-4"></i>
                    @break
                @case('repeat')
                    <i class="ti ti-repeat fs-4"></i>
                    @break
                @case('notes')
                    <i class="ti ti-notes fs-4"></i>
                    @break
                @default
                    <i class="ti ti-report-analytics fs-4"></i>
            @endswitch
        </div>
        <div class="flex-grow-1 min-w-0">
            <span class="text-secondary small fw-medium d-block text-truncate">{{ $title }}</span>
            <h4 class="fw-bold mb-0 text-dark">{{ $value }}</h4>
            @if($change)
                <small class="text-{{ $direction === 'up' ? 'success' : 'danger' }} fw-semibold d-inline-flex align-items-center gap-1">
                    <i class="ti ti-arrow-{{ $direction === 'up' ? 'up-left' : 'down-left' }}"></i>
                    {{ $change }}
                </small>
            @endif
        </div>
    </div>
</div>
