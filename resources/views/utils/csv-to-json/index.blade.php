@include('layout-twcss.header', ['title' => 'CSV para JSON'])
@include('layout-twcss.menu')

<div class="flex-1 w-full">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex gap-6">
        @include('layout-twcss.sidebar')

        <main class="flex-1">
            @include('layout-twcss.breadcrumb', [
                'breadcrumbs' => [['label' => 'Utilitários', 'url' => '#'], ['label' => 'CSV para JSON']],
            ])
            @include('layout-twcss.alert')

            <h1 class="text-2xl font-semibold mb-4">Conversor CSV para JSON</h1>

            <form id="csv-to-json-form" action="{{ route('utils.csv-to-json.store') }}" method="POST"
                enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label for="csv_text" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Colar
                        conteúdo CSV</label>
                    <textarea name="csv_text" id="csv_text" rows="10"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white"
                        placeholder="Cole aqui o conteúdo do CSV..."></textarea>
                </div>

                <div>
                    <label for="csv" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ou envie um
                        arquivo CSV</label>
                    <input type="file" name="csv" id="csv" accept=".csv"
                        class="mt-1 block w-full text-sm text-gray-900 dark:text-gray-300 file:mr-4 file:rounded-md file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900 dark:file:text-blue-100">
                </div>

                <div id="client-error"
                    class="hidden rounded border border-red-300 bg-red-50 text-red-800 dark:border-red-800 dark:bg-red-900/30 dark:text-red-200 px-3 py-2">
                </div>

                <div class="flex gap-2">
                    <button type="submit"
                        class="px-4 py-2 text-sm rounded bg-blue-600 text-white hover:bg-blue-700">Converter</button>
                    <button type="reset" id="reset-btn"
                        class="px-4 py-2 text-sm rounded bg-gray-200 text-gray-800 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">Limpar</button>
                </div>
            </form>

            @if (session('success') && session('download_url'))
                <div
                    class="mt-6 rounded border border-green-300 bg-green-50 text-green-800 dark:border-green-800 dark:bg-green-900/30 dark:text-green-200 px-3 py-2">
                    <p class="font-semibold">{{ session('success') }}</p>
                    <a href="{{ session('download_url') }}"
                        class="mt-2 inline-block px-4 py-2 text-sm rounded bg-green-600 text-white hover:bg-green-700"
                        download>Baixar JSON</a>
                </div>
            @endif
        </main>
    </div>
</div>

@include('layout-twcss.footer')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('csv-to-json-form');
        const errorDiv = document.getElementById('client-error');
        const resetBtn = document.getElementById('reset-btn');

        form.addEventListener('submit', function(event) {
            const csvText = document.getElementById('csv_text').value.trim();
            const csvFile = document.getElementById('csv').files.length > 0;

            if ((csvText && csvFile) || (!csvText && !csvFile)) {
                event.preventDefault();
                errorDiv.textContent =
                    'Preencha apenas um dos campos: colar o conteúdo CSV ou enviar um arquivo CSV.';
                errorDiv.classList.remove('hidden');
            } else {
                errorDiv.classList.add('hidden');
            }
        });

        resetBtn.addEventListener('click', function() {
            errorDiv.classList.add('hidden');
        });
    });
</script>
