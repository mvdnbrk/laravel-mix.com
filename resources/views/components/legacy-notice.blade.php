<div id="legacy-notice" class="relative flex items-center gap-x-4 bg-gray-900 px-4 py-1 after:absolute after:inset-x-0 after:bottom-0 after:h-px after:bg-white/10 sm:px-3 sm:before:flex-1 dark:bg-gray-800">
    <p class="m-0 text-xs/5 sm:text-sm/5 text-gray-200">
        <a class="text-gray-200 hover:text-white" href="{{ route('migrating-to-vite') }}">
            <strong class="font-semibold">Laravel Mix is a legacy package</strong><svg viewBox="0 0 2 2" aria-hidden="true" class="mx-2 inline size-0.5 fill-current"><circle r="1" cx="1" cy="1" /></svg>It is no longer actively maintained. Vite may be used as a modern alternative&nbsp;<span aria-hidden="true">&rarr;</span>
        </a>
    </p>
    <div class="flex flex-1 justify-end">
        <button type="button" id="legacy-notice-dismiss" class="-m-1.5 p-1.5 text-gray-400 hover:text-white focus-visible:-outline-offset-4">
            <span class="sr-only">Dismiss</span>
            <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-4">
                <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
            </svg>
        </button>
    </div>
</div>
<script>
    (function () {
        var notice = document.getElementById('legacy-notice');
        var key = 'legacy-notice-dismissed';

        try {
            if (localStorage.getItem(key) === '1') {
                notice.remove();
                return;
            }
        } catch (e) {}

        document.getElementById('legacy-notice-dismiss').addEventListener('click', function () {
            notice.remove();

            try {
                localStorage.setItem(key, '1');
            } catch (e) {}
        });
    })();
</script>
