@if (session('success'))
    <div
        class="mb-4 rounded border border-green-300 bg-green-50 text-green-800 dark:border-green-800 dark:bg-green-900/30 dark:text-green-200 px-3 py-2">
        {{ session('success') }}
    </div>
@endif
@if ($errors->any())
    <div
        class="mb-4 rounded border border-red-300 bg-red-50 text-red-800 dark:border-red-800 dark:bg-red-900/30 dark:text-red-200 px-3 py-2">
        <div class="font-semibold mb-1">Ocorreram erros:</div>
        <ul class="list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
