@include('includes.header', ['title' => 'Controle GLPI - Lista'])
@include('includes.menu')

<div class="flex-1 w-full">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex gap-6">
        @include('includes.sidebar')

        <main class="flex-1">
            @include('includes.breadcrumb', ['breadcrumbs' => [['label' => 'Controle GLPI']]])
            @include('includes.alert')

            <div class="flex items-center justify-between mb-4">
                <h1 class="text-xl font-semibold">Controle GLPI</h1>
                <a href="{{ route('glpi.controle-glpi.create') }}"
                    class="px-3 py-2 text-sm rounded bg-blue-600 text-white">Novo</a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm border border-gray-200 dark:border-gray-800 rounded-lg overflow-hidden">
                    <thead class="bg-gray-100 dark:bg-gray-800">
                        <tr>
                            @include('glpi.controle-glpi.partials.table-head')
                        </tr>
                    </thead>
                    <tbody>
                        @include('glpi.controle-glpi.partials.table-row')
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $items->links() }}
            </div>
        </main>
    </div>
</div>

@include('includes.modal')
@include('includes.footer')
