@extends('stackway::layouts.dashboard')

@section('title', 'الملف الشخصي وإعدادات الحساب')

@section('content')
<div class="max-w-4xl mx-auto space-y-6" x-data="{ deleteModalOpen: false }">

    {{-- User Header Banner --}}
    <div class="rounded-2xl p-6 md:p-8"
         style="background: linear-gradient(135deg, #1E1B4B 0%, #0F172A 100%); border: 1px solid rgba(99, 102, 241, 0.2); box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.25);">
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5">
            {{-- User Avatar --}}
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center font-bold text-2xl text-white shadow-md flex-shrink-0"
                 style="background: var(--sw-primary); border: 2px solid rgba(255, 255, 255, 0.2);">
                {{ mb_substr(auth()->user()->name ?? 'U', 0, 1) }}
            </div>

            <div class="space-y-1.5 text-center sm:text-start flex-1">
                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2.5">
                    <h1 class="text-xl font-bold text-white">{{ auth()->user()->name }}</h1>
                    <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full"
                          style="background: rgba(99, 102, 241, 0.25); color: #C7D2FE; border: 1px solid rgba(165, 180, 252, 0.3);">
                        مدير النظام
                    </span>
                </div>
                <p class="text-sm text-slate-300 font-mono">{{ auth()->user()->email }}</p>
                <p class="text-xs text-slate-400">
                    تاريخ الانضمام: {{ auth()->user()->created_at ? auth()->user()->created_at->format('Y-m-d') : 'الآن' }}
                </p>
            </div>
        </div>
    </div>

    {{-- Flash Notifications --}}
    @if (session('status') === 'profile-updated')
        <x-sw-alert type="success" message="تم تحديث بيانات الملف الشخصي بنجاح." dismissible />
    @elseif (session('status') === 'password-updated')
        <x-sw-alert type="success" message="تم تحديث كلمة المرور بنجاح." dismissible />
    @endif

    {{-- Card 1: Profile Information --}}
    <x-sw-card title="المعلومات الشخصية" subtitle="تحديث اسم الحساب والبريد الإلكتروني">
        <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Name --}}
                <div>
                    <label for="name" class="block text-xs font-bold mb-1.5" style="color: var(--sw-text-primary);">الاسم الكامل</label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name', auth()->user()->name) }}"
                        required
                        class="sw-input"
                    />
                    @error('name')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-xs font-bold mb-1.5" style="color: var(--sw-text-primary);">البريد الإلكتروني</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email', auth()->user()->email) }}"
                        required
                        class="sw-input"
                    />
                    @error('email')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="pt-2 flex justify-end">
                <x-sw-button type="submit" variant="primary" size="md">
                    <span>حفظ التعديلات</span>
                </x-sw-button>
            </div>
        </form>
    </x-sw-card>

    {{-- Card 2: Update Password --}}
    <x-sw-card title="الأمان وكلمة المرور" subtitle="تغيير كلمة المرور الخاصة بحسابك">
        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Current Password --}}
                <div>
                    <label for="current_password" class="block text-xs font-bold mb-1.5" style="color: var(--sw-text-primary);">كلمة المرور الحالية</label>
                    <input
                        id="current_password"
                        type="password"
                        name="current_password"
                        placeholder="••••••••"
                        class="sw-input"
                    />
                    @error('current_password', 'updatePassword')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- New Password --}}
                <div>
                    <label for="password" class="block text-xs font-bold mb-1.5" style="color: var(--sw-text-primary);">كلمة المرور الجديدة</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        placeholder="••••••••"
                        class="sw-input"
                    />
                    @error('password', 'updatePassword')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label for="password_confirmation" class="block text-xs font-bold mb-1.5" style="color: var(--sw-text-primary);">تأكيد كلمة المرور</label>
                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        placeholder="••••••••"
                        class="sw-input"
                    />
                    @error('password_confirmation', 'updatePassword')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="pt-2 flex justify-end">
                <x-sw-button type="submit" variant="primary" size="md">
                    <span>تحديث كلمة المرور</span>
                </x-sw-button>
            </div>
        </form>
    </x-sw-card>

    {{-- Card 3: Danger Zone --}}
    <div class="rounded-2xl p-6 space-y-4"
         style="background: var(--sw-danger-50); border: 1px solid rgba(220, 38, 38, 0.25);">
        <div class="flex items-start justify-between flex-wrap gap-4">
            <div>
                <h3 class="text-base font-bold text-rose-700 dark:text-rose-400">
                    منطقة الحذف
                </h3>
                <p class="text-xs mt-1 max-w-xl text-rose-700/80 dark:text-rose-300/80 leading-relaxed">
                    بمجرد حذف حسابك، سيتم مسح كافة البيانات والسجلات المرتبطة به نهائياً ولا يمكن استرجاعها.
                </p>
            </div>

            <x-sw-button type="button" variant="danger" size="sm" @click="deleteModalOpen = true">
                حذف الحساب
            </x-sw-button>
        </div>
    </div>

    {{-- Delete Account Modal --}}
    <div x-show="deleteModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95">
        <div class="relative w-full max-w-md p-6 rounded-2xl shadow-xl"
             style="background: var(--sw-surface-card); border: 1px solid var(--sw-border);"
             @click.outside="deleteModalOpen = false">
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center mx-auto mb-4"
                 style="background: var(--sw-danger-50); color: var(--sw-danger);">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                    <line x1="12" y1="9" x2="12" y2="13"></line>
                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-center mb-1" style="color: var(--sw-text-primary);">تأكيد حذف الحساب</h3>
            <p class="text-xs text-center mb-5" style="color: var(--sw-text-muted);">
                يرجى إدخال كلمة المرور لتأكيد رغبتك في حذف الحساب نهائياً.
            </p>

            <form action="{{ route('profile.destroy') }}" method="POST" class="space-y-4">
                @csrf
                @method('DELETE')

                <div>
                    <input
                        type="password"
                        name="password"
                        placeholder="أدخل كلمة المرور الخاصة بك"
                        required
                        class="sw-input"
                    />
                    @error('password', 'userDeletion')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-center gap-3 pt-2">
                    <x-sw-button type="button" variant="secondary" size="md" @click="deleteModalOpen = false">
                        إلغاء
                    </x-sw-button>
                    <x-sw-button type="submit" variant="danger" size="md">
                        تأكيد الحذف
                    </x-sw-button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
