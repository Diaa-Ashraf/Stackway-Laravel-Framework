{{-- Stackway Loading Spinner --}}
@props(['size' => 'md', 'text' => ''])

<div class="flex items-center justify-center gap-2">
    <div class="sw-spinner {{ $size === 'lg' ? 'sw-spinner-lg' : '' }}"></div>
    @if($text)
        <span class="text-sm" style="color: var(--sw-text-muted);">{{ $text }}</span>
    @endif
</div>
