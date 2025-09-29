<header
    class="border-b border-gray-200 dark:border-gray-800 bg-white/80 dark:bg-gray-950/80 backdrop-blur sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="h-14 flex items-center justify-between">
            <a href="{{ route('glpi.controle-glpi.index') }}" class="font-semibold">GLPI Controle</a>
            <nav class="flex items-center gap-4">
                <a class="hover:underline" href="{{ route('glpi.controle-glpi.index') }}">Listar</a>
                <a class="hover:underline" href="{{ route('glpi.controle-glpi.create') }}">Criar</a>
                <button type="button" @click="dark = !dark"
                    class="px-3 py-1 rounded text-sm border border-gray-300 dark:border-gray-700">Tema: <span
                        x-text="dark ? 'Escuro' : 'Claro'"></span></button>
            </nav>
        </div>
    </div>
</header>
