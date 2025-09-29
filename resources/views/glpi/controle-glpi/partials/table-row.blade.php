@foreach ($items as $item)
    <tr class="border-t border-gray-200 dark:border-gray-800">
        <td class="px-3 py-2">
            <a href="https://helpdesk.systax.net/glpi/front/ticket.form.php?id={{ $item->id_ticket }}" target="_blank"
                rel="noopener noreferrer">
                {{ $item->id_ticket }}
            </a>
        </td>
        <td class="px-3 py-2">{{ $item->name }}</td>
        <td class="px-3 py-2">{{ $item->jira }}</td>
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
