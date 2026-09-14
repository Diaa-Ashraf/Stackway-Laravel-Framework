{{-- Stackway Textarea Component --}}
@props([
    'name' => '',
    'label' => '',
    'value' => '',
    'rows' => 4,
    'placeholder' => '',
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'hint' => '',
])

<div class="sw-form-group mb-4">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium mb-1.5" style="color: var(--sw-text-primary);">
            {{ $label }}
            @if($required)
                <span class="text-rose-500 font-bold">*</span>
            @endif
        </label>
    @endif

    <textarea
        name="{{ $name }}"
        id="{{ $name }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        {{ $readonly ? 'readonly' : '' }}
        {{ $attributes->merge([
            'class' => 'sw-input w-full px-4 py-2.5 text-sm rounded-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-[var(--sw-primary)]/20 focus:border-[var(--sw-primary)] ' . ($errors->has($name) ? 'border-rose-500 focus:border-rose-500 focus:ring-rose-500/20' : '')
        ]) }}
    >{{ old($name, $value) }}</textarea>

    @if($hint && !$errors->has($name))
        <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">{{ $hint }}</p>
    @endif

    @error($name)
        <p class="mt-1 text-xs text-rose-500 flex items-center gap-1 font-medium">
            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            {{ $message }}
        </p>
    @enderror
</div>
