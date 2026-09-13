{{-- Stackway Breadcrumb --}}
@props(['items' => []])

<nav class="sw-breadcrumb">
    <a href="{{ route('dashboard') }}" class="sw-breadcrumb-item">
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
    </a>
    @foreach($items as $item)
        <span class="sw-breadcrumb-separator">/</span>
        @if(isset($item['url']) && !($loop->last))
            <a href="{{ $item['url'] }}" class="sw-breadcrumb-item">{{ $item['label'] }}</a>
        @else
            <span class="sw-breadcrumb-item active">{{ $item['label'] }}</span>
        @endif
    @endforeach
</nav>
