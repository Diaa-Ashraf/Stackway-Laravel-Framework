@extends('stackway::layouts.dashboard')

@section('title', 'الملف الشخصي وإعدادات الحساب')

@section('content')
<div class="max-w-4xl mx-auto space-y-8" x-data="{ deleteModalOpen: false }">

    {{-- User Header Banner --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-violet-900 via-indigo-900 to-slate-900 text-white p-6 md:p-8 shadow-xl border border-violet-800/40">
        <div class="absolute -end-10 -bottom-10 w-60 h-60 bg-violet-600/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col sm:flex-row items-center sm:items-start gap-5">
            {{-- Big User Avatar --}}
            <div class="w-20 h-20 rounded-2xl bg-gradient-to-tr from-violet-500 to-cyan-500 text-white flex items-center justify-center font-bold text-3xl shadow-lg shadow-violet-500/30 border-2 border-white/20 flex-shrink-0">
                {{ mb_substr(auth()->user()->name ?? 'U', 0, 1) }}
            </div>

            <div class="space-y-1.5 text-center sm:text-start flex-1">
                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2.5">
                    <h1 class="text-2xl font-bold tracking-tight">{{ auth()->user()->name }}</h1>
                    <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full bg-violet-500/30 text-violet-200 border border-violet-400/30">
                        مدير النظام 🛡️
                    </span>
                </div>
                <p class="text-sm text-slate-300 font-mono">{{ auth()->user()->email }}</p>
                <p class="text-xs text-slate-400">
                    عضو منذ: {{ auth()->user()->created_at ? auth()->user()->created_at->format('Y-m-d') : 'الآن' }}
                </p>
            </div>
        </div>
    </div>

    {{-- Flash Notifications --}}
    @if (session('status') === 'profile-updated')
        <x-sw-alert type="success" message="تم تحديث بيانات الملف الشخصي بنجاح! ✨" dismissible />
    @elseif (session('status') === 'password-updated')
        <x-sw-alert type="success" message="تم تحديث كلمة المرور بنجاح! 🔒" dismissible />
    @endif

    {{-- Card 1: Profile Information --}}
    <x-sw-card title="المعلومات الشخصية" subtitle="تحديث اسم الحساب والبريد الإلكتروني">
        <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Name --}}
                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">الاسم الكامل</label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name', auth()->user()->name) }}"
                        required
                        class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-[var(--sw-primary)]/20"
                    />
                    @error('name')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">البريد الإلكتروني</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email', auth()->user()->email) }}"
                        required
                        class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-[var(--sw-primary)]/20"
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
    <x-sw-card title="الأمان وكلمة المرور" subtitle="تغيير كلمة المرور الخاصة بحسابك للحفاظ على الأمان">
        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Current Password --}}
                <div>
                    <label for="current_password" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">كلمة المرور الحالية</label>
                    <input
                        id="current_password"
                        type="password"
                        name="current_password"
                        placeholder="••••••••"
                        class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-[var(--sw-primary)]/20"
                    />
                    @error('current_password', 'updatePassword')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- New Password --}}
                <div>
                    <label for="password" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">كلمة المرور الجديدة</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        placeholder="••••••••"
                        class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-[var(--sw-primary)]/20"
                    />
                    @error('password', 'updatePassword')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label for="password_confirmation" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">تأكيد كلمة المرور</label>
                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        placeholder="••••••••"
                        class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-[var(--sw-primary)]/20"
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
    <div class="rounded-2xl border border-rose-200 dark:border-rose-900/40 bg-rose-50/40 dark:bg-rose-950/20 p-6 space-y-4">
        <div class="flex items-start justify-between flex-wrap gap-4">
            <div>
                <h3 class="text-base font-bold text-rose-700 dark:text-rose-400 flex items-center gap-2">
                    <span>⚠️ منطقة الحذف (Danger Zone)</span>
                </h3>
                <p class="text-xs text-rose-600/80 dark:text-rose-400/70 mt-1 max-w-xl">
                    بمجرد حذف حسابك، سيتم مسح كافة البيانات والملاحظات والمشاريع المرتبطة به نهائياً ولا يمكن استرجاعها.
                </p>
            </div>

            <x-sw-button type="button" variant="danger" size="sm" @click="deleteModalOpen = true">
                حذف الحساب نهائياً
            </x-sw-button>
        </div>
    </div>

    {{-- Delete Account Modal --}}
    <div x-show="deleteModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95">
        <div class="relative w-full max-w-md p-6 bg-white dark:bg-slate-900 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-800" @click.outside="deleteModalOpen = false">
            <div class="w-12 h-12 rounded-2xl bg-rose-100 dark:bg-rose-900/30 text-rose-600 flex items-center justify-center mx-auto mb-4 font-bold text-xl">
                ⚠️
            </div>
            <h3 class="text-lg font-bold text-center text-slate-800 dark:text-slate-100 mb-2">تأكيد حذف الحساب</h3>
            <p class="text-xs text-center text-slate-500 dark:text-slate-400 mb-6">
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
                        class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-rose-500/20"
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
                        نعم، حذف الحساب
                    </x-sw-button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
