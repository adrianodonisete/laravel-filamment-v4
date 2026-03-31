@include('layout-twcss.header', ['title' => 'Query - Teste'])
@include('layout-twcss.menu')

<div class="flex-1 w-full">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex gap-6">

        <main class="flex-1">
            @include('layout-twcss.alert')

            <div class="flex items-center justify-between mb-4">
                <h1 class="text-xl font-semibold">Query de teste — (top 10 | teste)</h1>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                    <thead class="bg-gray-100 dark:bg-gray-800">
                        <tr>
                            <th class="px-4 py-3 text-left font-medium text-gray-600 dark:text-gray-300">ID</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-600 dark:text-gray-300">Código</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-600 dark:text-gray-300">Origem</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($items as $item)
                            <tr
                                class="bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $item->id }}</td>
                                <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $item->cod_prod }}</td>
                                <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $item->origem_produto }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-6 text-center text-gray-400 dark:text-gray-500">
                                    Nenhum registro encontrado.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

@include('layout-twcss.footer')
