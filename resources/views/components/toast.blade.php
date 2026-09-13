{{-- Stackway Toast Notifications --}}
<div x-data="swToast()" x-on:toast.window="addToast($event.detail)" class="sw-toast-container" x-cloak>
    <template x-for="toast in toasts" :key="toast.id">
        <div class="sw-toast" :class="'sw-alert-' + toast.type"
             x-show="toast.visible"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-x-full"
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-x-0"
             x-transition:leave-end="opacity-0 translate-x-full">
            <span x-text="toast.message" class="flex-1"></span>
            <button @click="removeToast(toast.id)" class="shrink-0 opacity-60 hover:opacity-100" type="button">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
            </button>
        </div>
    </template>
</div>

<script>
function swToast() {
    return {
        toasts: [],
        addToast(detail) {
            const id = Date.now();
            this.toasts.push({ id, ...detail, visible: true });
            setTimeout(() => this.removeToast(id), detail.duration || 4000);
        },
        removeToast(id) {
            const toast = this.toasts.find(t => t.id === id);
            if (toast) toast.visible = false;
            setTimeout(() => { this.toasts = this.toasts.filter(t => t.id !== id); }, 300);
        }
    };
}
</script>
