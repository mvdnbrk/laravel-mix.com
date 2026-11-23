<template>
    <div v-if="! dismissed" class="relative flex items-center gap-x-6 bg-gray-900 px-6 py-2.5 after:absolute after:inset-x-0 after:bottom-0 after:h-px after:bg-white/10 sm:px-3.5 sm:before:flex-1 dark:bg-gray-800">
        <p class="text-sm/6 text-white">
            <a href="https://github.com/laravel/vite-plugin/blob/main/UPGRADE.md#migrating-from-laravel-mix-to-vite">
                <strong class="font-semibold">Laravel Mix is a legacy package</strong><svg viewBox="0 0 2 2" aria-hidden="true" class="mx-2 inline size-0.5 fill-current"><circle r="1" cx="1" cy="1" /></svg>It is no longer actively maintained. Vite may be used as a modern alternative&nbsp;<span aria-hidden="true">&rarr;</span>
            </a>
        </p>
        <div class="flex flex-1 justify-end">
            <button type="button" class="-m-3 p-3 focus-visible:-outline-offset-4" @click="dismiss">
                <span class="sr-only">Dismiss</span>
                <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-5 text-white">
                    <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                </svg>
            </button>
        </div>
    </div>
</template>

<script>
const storageKey = 'legacy-notice-dismissed';

export default {
    data() {
        let dismissed = false;

        try {
            dismissed = window.localStorage.getItem(storageKey) === '1';
        } catch (e) {}

        return { dismissed };
    },
    methods: {
        dismiss() {
            this.dismissed = true;

            try {
                window.localStorage.setItem(storageKey, '1');
            } catch (e) {}
        },
    },
}
</script>
