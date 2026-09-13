{{-- Stackway Checkbox Component --}}
@props([
    'name' => '',
    'label' => '',
    'checked' => false,
    'value' => '1',
    'disabled' => false,
    'description' => '',
])

<div class="sw-form-group mb-4">
    <label class="inline-flex items-start gap-3 cursor-pointer select-none">
        <div class="flex items-center h-5">
            <input
                type="checkbox"
                name="{{ $name }}"
                id="{{ $name }}"
                value="{{ $value }}"
                {{ old($name, $checked) ? 'checked' : '' }}
                {{ $disabled ? 'disabled' : '' }}
                {{ $attributes->merge([
                    'class' => 'w-4 h-4 rounded text-[var(--sw-primary)] border-slate-300 dark:border-slate-700 focus:ring-[var(--sw-primary)]/20 focus:ring-2 dark:bg-slate-800'
                ]) }}
            />
        </div>
        <div class="text-sm">
            @if($label)
                <span class="font-medium text-slate-700 dark:text-slate-200">{{ $label }}</span>
            @endif
            @if($description)
                <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">{{ $description }}</p>
            @endif
        </div>
    </label>

    @error($name)
        <p class="mt-1 text-xs text-rose-500 flex items-center gap-1 font-medium">
            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            {{ $message }}
        </p>
    @enderror
</div>
