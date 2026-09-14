{{-- Stackway Select Component --}}
@props([
    'name' => '',
    'label' => '',
    'options' => [],
    'selected' => null,
    'placeholder' => 'اختر من القائمة...',
    'required' => false,
    'disabled' => false,
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

    <div class="relative">
        <select
            name="{{ $name }}"
            id="{{ $name }}"
            {{ $required ? 'required' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            {{ $attributes->merge([
                'class' => 'sw-select w-full px-4 py-2.5 text-sm rounded-xl appearance-none transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-[var(--sw-primary)]/20 focus:border-[var(--sw-primary)] pe-10 ' . ($errors->has($name) ? 'border-rose-500 focus:border-rose-500 focus:ring-rose-500/20' : '')
            ]) }}
        >
            @if($placeholder)
                <option value="" {{ old($name, $selected) === null || old($name, $selected) === '' ? 'selected' : '' }} disabled>{{ $placeholder }}</option>
            @endif

            @if(is_array($options) && count($options) > 0)
                @foreach($options as $val => $text)
                    @php
                        $isSelected = old($name, $selected) == $val;
                    @endphp
                    <option value="{{ $val }}" {{ $isSelected ? 'selected' : '' }}>{{ $text }}</option>
                @endforeach
            @else
                {{ $slot }}
            @endif
        </select>

        <div class="absolute inset-y-0 end-0 flex items-center pe-3.5 pointer-events-none text-slate-400">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
    </div>

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
