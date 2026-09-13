{{-- Stackway Avatar --}}
@props(['src' => null, 'name' => '', 'size' => 'md'])

@if($src)
    <img src="{{ $src }}" alt="{{ $name }}" class="sw-avatar sw-avatar-{{ $size }}">
@else
    <div class="sw-avatar-placeholder sw-avatar-{{ $size }}"
         style="font-size: {{ $size === 'sm' ? '0.7rem' : ($size === 'lg' ? '1.2rem' : '0.875rem') }};">
        {{ mb_substr($name, 0, 2) }}
    </div>
@endif
