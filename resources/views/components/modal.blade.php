{{-- Stackway Modal --}}
@props(['id' => 'modal', 'title' => '', 'maxWidth' => 'md'])

@php
$maxWidthClass = match($maxWidth) {
    'sm' => 'max-w-sm',
    'md' => 'max-w-lg',
    'lg' => 'max-w-2xl',
    'xl' => 'max-w-4xl',
    default => 'max-w-lg',
};
@endphp

<div x-data="{ open: false }"
     x-on:open-modal-{{ $id }}.window="open = true"
     x-on:close-modal-{{ $id }}.window="open = false"
     x-on:keydown.escape.window="open = false"
     x-cloak>

    {{-- Overlay --}}
    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="sw-modal-overlay" @click="open = false">

        {{-- Modal --}}
        <div class="sw-modal {{ $maxWidthClass }}" @click.stop
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">

            <div class="sw-modal-header">
                <h3 class="sw-modal-title">{{ $title }}</h3>
                <button @click="open = false" class="sw-btn sw-btn-ghost sw-btn-icon" type="button">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="sw-modal-body">
                {{ $slot }}
            </div>

            @isset($footer)
                <div class="sw-modal-footer">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>
</div>
