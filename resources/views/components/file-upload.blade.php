{{-- Stackway File Upload Component --}}
@props([
    'name' => '',
    'label' => '',
    'accept' => 'image/*',
    'multiple' => false,
    'preview' => true,
    'current' => null,
    'required' => false,
    'hint' => 'PNG, JPG, WebP بحد أقصى 5MB',
])

<div class="sw-form-group mb-4" x-data="{
    imageUrl: '{{ $current ? (Str::startsWith($current, ['http://', 'https://']) ? $current : asset('storage/' . $current)) : '' }}',
    fileName: '',
    handleFile(e) {
        const file = e.target.files[0];
        if (!file) return;
        this.fileName = file.name;
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = (ev) => { this.imageUrl = ev.target.result; };
            reader.readAsDataURL(file);
        }
    },
    removeImage() {
        this.imageUrl = '';
        this.fileName = '';
        this.$refs.fileInput.value = '';
    }
}">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium mb-1.5" style="color: var(--sw-text-primary);">
            {{ $label }}
            @if($required)
                <span class="text-rose-500 font-bold">*</span>
            @endif
        </label>
    @endif

    <div class="relative border-2 border-dashed rounded-2xl p-6 text-center transition-all duration-200 border-slate-300 dark:border-slate-700 hover:border-[var(--sw-primary)] bg-slate-50/50 dark:bg-slate-900/30">
        <input
            type="file"
            name="{{ $name }}{{ $multiple ? '[]' : '' }}"
            id="{{ $name }}"
            accept="{{ $accept }}"
            {{ $multiple ? 'multiple' : '' }}
            {{ $required && !$current ? 'required' : '' }}
            x-ref="fileInput"
            @change="handleFile"
            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
        />

        <template x-if="!imageUrl">
            <div class="flex flex-col items-center justify-center pointer-events-none">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-3 text-[var(--sw-primary)] bg-[var(--sw-primary)]/10">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <p class="text-sm font-medium text-slate-700 dark:text-slate-200">
                    اسحب الملف هنا أو <span class="text-[var(--sw-primary)] underline">تصفح جهازك</span>
                </p>
                @if($hint)
                    <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">{{ $hint }}</p>
                @endif
            </div>
        </template>

        <template x-if="imageUrl">
            <div class="flex items-center justify-center gap-4 relative z-20">
                <img :src="imageUrl" class="w-20 h-20 object-cover rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm" alt="Preview">
                <div class="text-start">
                    <p class="text-xs font-semibold text-slate-700 dark:text-slate-200 truncate max-w-[200px]" x-text="fileName || 'الصورة الحالية'"></p>
                    <button type="button" @click.stop="removeImage" class="mt-2 text-xs text-rose-500 hover:text-rose-600 font-medium flex items-center gap-1 cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        حذف الصورة
                    </button>
                </div>
            </div>
        </template>
    </div>

    @error($name)
        <p class="mt-1 text-xs text-rose-500 flex items-center gap-1 font-medium">
            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            {{ $message }}
        </p>
    @enderror
</div>
