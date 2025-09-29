<div class="overflow-x-auto">
    <table class="min-w-full text-sm border border-gray-200 dark:border-gray-800 rounded-lg overflow-hidden">
        <thead class="bg-gray-100 dark:bg-gray-800">
            <tr>
                {{ $head ?? '' }}
            </tr>
        </thead>
        <tbody>
            {{ $slot }}
        </tbody>
    </table>
</div>
