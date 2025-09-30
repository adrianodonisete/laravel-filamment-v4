<header
    class="border-b border-gray-200 dark:border-gray-800 bg-white/80 dark:bg-gray-950/80 backdrop-blur sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="h-14 flex items-center justify-between">
            <a href="{{ route('glpi.controle-glpi.index') }}" class="font-semibold">GLPI Controle</a>
            <nav class="flex items-center gap-4">
                <a class="hover:underline" href="{{ route('glpi.controle-glpi.index') }}">Listar</a>
                <a class="hover:underline" href="{{ route('glpi.controle-glpi.create') }}">Criar</a>
                <button type="button" @click="dark = !dark"
                    :aria-label="dark ? 'Alternar para tema claro' : 'Alternar para tema escuro'"
                    :title="dark ? 'Tema claro' : 'Tema escuro'"
                    class="p-2 rounded border border-gray-300 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800">
                    <!-- Sun icon when dark = true (switch to light) -->
                    <svg x-show="dark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="h-5 w-5">
                        <path
                            d="M12 18a6 6 0 1 0 0-12 6 6 0 0 0 0 12Zm0 4a1 1 0 0 1-1-1v-1a1 1 0 1 1 2 0v1a1 1 0 0 1-1 1Zm0-18a1 1 0 0 1-1-1V2a1 1 0 1 1 2 0v1a1 1 0 0 1-1 1Zm10 7h-1a1 1 0 1 1 0-2h1a1 1 0 1 1 0 2ZM3 12H2a1 1 0 1 1 0-2h1a1 1 0 1 1 0 2Zm15.657 7.071-0.707-0.707a1 1 0 1 1 1.414-1.414l0.707 0.707a1 1 0 1 1-1.414 1.414ZM4.636 6.343 3.929 5.636A1 1 0 1 1 5.343 4.222l0.707 0.707A1 1 0 0 1 4.636 6.343Zm13.435-2.121 0.707-0.707A1 1 0 1 1 20.192 4.93l-0.707 0.707a1 1 0 0 1-1.414-1.414ZM4.636 19.364a1 1 0 0 1 0-1.414l0.707-0.707a1 1 0 1 1 1.414 1.414l-0.707 0.707a1 1 0 0 1-1.414 0Z" />
                    </svg>
                    <!-- Moon icon when dark = false (switch to dark) -->
                    <svg x-show="!dark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="h-5 w-5">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3a7 7 0 1 0 9.79 9.79Z" />
                    </svg>
                </button>
            </nav>
        </div>
    </div>
</header>
