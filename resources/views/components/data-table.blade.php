{{-- Stackway Data Table --}}
@props([
    'headers' => [],
    'actions' => true,
    'searchable' => true,
    'searchPlaceholder' => 'بحث...',
])

<div class="sw-table-wrapper">
    @if($searchable)
    <div class="flex items-center justify-between gap-4 p-4 border-b" style="border-color: var(--sw-border-light);">
        <div class="relative flex-1 max-w-sm">
            <input type="text" placeholder="{{ $searchPlaceholder }}"
                   class="sw-input pl-10 text-sm"
                   style="border-radius: var(--sw-radius-full);">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color: var(--sw-text-muted);"
                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
        </div>
        @isset($tableActions)
            <div class="flex items-center gap-2">
                {{ $tableActions }}
            </div>
        @endisset
    </div>
    @endif

    <div class="overflow-x-auto">
        <table class="sw-table">
            @if(!empty($headers))
            <thead>
                <tr>
                    @foreach($headers as $header)
                        <th>{{ $header }}</th>
                    @endforeach
                    @if($actions)
                        <th class="text-center" style="width: 120px;">الإجراءات</th>
                    @endif
                </tr>
            </thead>
            @endif
            <tbody>
                {{ $slot }}
            </tbody>
        </table>
    </div>

    @isset($pagination)
        <div class="p-4 border-t flex items-center justify-between" style="border-color: var(--sw-border-light);">
            {{ $pagination }}
        </div>
    @endisset
</div>
