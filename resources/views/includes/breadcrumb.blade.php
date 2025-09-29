<nav class="text-sm text-gray-500 dark:text-gray-400" aria-label="Breadcrumb">
    <ol class="flex items-center gap-2">
        <li><a class="hover:underline" href="{{ route('glpi.controle-glpi.index') }}">Início</a></li>
        @isset($breadcrumbs)
            @foreach ($breadcrumbs as $crumb)
                <li>/</li>
                <li>
                    @if (isset($crumb['url']))
                        <a class="hover:underline" href="{{ $crumb['url'] }}">{{ $crumb['label'] }}</a>
                    @else
                        <span>{{ $crumb['label'] }}</span>
                    @endif
                </li>
            @endforeach
        @endisset
    </ol>
</nav>
