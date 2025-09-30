<div x-data="{ open: false, title: '', message: '', action: null }"
    x-on:open-modal.window="open = true; title = $event.detail.title; message = $event.detail.message; action = $event.detail.action">
    <template x-teleport="body">
        <div x-show="open" x-transition class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="absolute inset-0 bg-black/50" @click="open = false"></div>
            <div
                class="relative bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg shadow p-6 w-full max-w-md">
                <h3 class="text-lg font-semibold mb-2" x-text="title"></h3>
                <p class="text-sm mb-4" x-text="message"></p>
                <div class="flex justify-end gap-2">
                    <button type="button" class="px-3 py-2 text-sm border rounded"
                        @click="open = false">Cancelar</button>
                    <button type="button" class="px-3 py-2 text-sm border rounded bg-red-600 text-white"
                        @click="if (action) action(); open = false;">Confirmar</button>
                </div>
            </div>
        </div>
    </template>
</div>
