{{-- Stackway Empty State --}}
@props(['title' => 'لا توجد بيانات', 'description' => '', 'icon' => 'inbox'])

<div class="sw-empty-state">
    <div class="sw-empty-icon">
        @if($icon === 'inbox')
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" width="80" height="80">
                <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/>
            </svg>
        @elseif($icon === 'search')
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" width="80" height="80">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
        @endif
    </div>
    <h3 class="sw-empty-title">{{ $title }}</h3>
    @if($description)
        <p class="sw-empty-text">{{ $description }}</p>
    @endif
    @if($slot->isNotEmpty())
        {{ $slot }}
    @endif
</div>
