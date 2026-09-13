{{-- Stackway Alert --}}
@props(['type' => 'info', 'message' => '', 'dismissible' => false])

<div x-data="{ show: true }" x-show="show" x-transition class="sw-alert sw-alert-{{ $type }} mb-4" role="alert">
    <div class="flex-1">
        {{ $message }}{{ $slot }}
    </div>
    @if($dismissible)
        <button @click="show = false" class="ml-auto shrink-0 opacity-60 hover:opacity-100 transition" type="button">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
        </button>
    @endif
</div>
