{{-- Stackway Badge --}}
@props(['type' => 'primary', 'dot' => false])

<span class="sw-badge sw-badge-{{ $type }}">
    @if($dot)
        <span class="w-1.5 h-1.5 rounded-full inline-block" style="background: currentColor; margin-inline-end: 0.375rem;"></span>
    @endif
    {{ $slot }}
</span>
