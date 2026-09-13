{{-- Stackway Badge --}}
@props(['type' => 'primary', 'dot' => false])

<span class="sw-badge sw-badge-{{ $type }}">
    @if($dot)
        <span class="w-1.5 h-1.5 rounded-full mr-1.5" style="background: currentColor;"></span>
    @endif
    {{ $slot }}
</span>
