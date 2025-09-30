@foreach ($items as $item)
    <tr class="border-t border-gray-200 dark:border-gray-800">
        <td class="px-3 py-2 whitespace-nowrap">
            <a href="https://helpdesk.systax.net/glpi/front/ticket.form.php?id={{ $item->id_ticket }}" target="_blank"
                rel="noopener noreferrer"
                class="text-blue-600 hover:text-blue-700 hover:underline underline-offset-4 dark:text-blue-400 whitespace-nowrap inline-flex items-center">
                {{ $item->id_ticket }}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                    class="inline-block ml-1 h-4 w-4 align-[-2px]">
                    <path d="M13 3h8v8h-2V6.414l-9.293 9.293-1.414-1.414L17.586 5H13V3Z" />
                    <path d="M5 5h6v2H7v10h10v-4h2v6H5V5Z" />
                </svg>
            </a>
        </td>
        <td class="px-3 py-2">{{ $item->name }}</td>
        <td class="px-3 py-2 whitespace-nowrap">
            @if (filled($item->jira))
                <a href="https://systax.atlassian.net/browse/{{ $item->jira }}" target="_blank"
                    rel="noopener noreferrer"
                    class="text-blue-600 hover:text-blue-700 hover:underline underline-offset-4 dark:text-blue-400 whitespace-nowrap inline-flex items-center">
                    {{ $item->jira }}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="inline-block ml-1 h-4 w-4 align-[-2px]">
                        <path d="M13 3h8v8h-2V6.414l-9.293 9.293-1.414-1.414L17.586 5H13V3Z" />
                        <path d="M5 5h6v2H7v10h10v-4h2v6H5V5Z" />
                    </svg>
                </a>
            @else
                - -
            @endif
        </td>
        <td class="px-3 py-2">{{ $item->proj }}</td>
        <td class="px-3 py-2">{{ optional($item->date_creation)->format('d/m/Y H:i') }}</td>
        <td class="px-3 py-2">
            <div class="flex items-center gap-2">
                <a class="text-yellow-600 hover:underline"
                    href="{{ route('glpi.controle-glpi.edit', $item) }}">Editar</a>
            </div>
        </td>
    </tr>
@endforeach
