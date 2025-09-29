@include('includes.header', ['title' => 'Editar - Controle GLPI'])
@include('includes.menu')

<div class="flex-1 w-full">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @include('includes.breadcrumb', [
            'breadcrumbs' => [
                ['label' => 'Controle GLPI', 'url' => route('glpi.controle-glpi.index')],
                ['label' => 'Editar'],
            ],
        ])
        @include('includes.alert')

        <form method="POST" action="{{ route('glpi.controle-glpi.update', $item) }}" class="space-y-4">
            @csrf
            @method('PUT')
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm mb-1">Ticket</label>
                    <input type="number" name="id_ticket" value="{{ old('id_ticket', $item->id_ticket) }}"
                        class="w-full rounded border px-3 py-2 bg-white dark:bg-gray-900" required>
                </div>
                <div>
                    <label class="block text-sm mb-1">Status</label>
                    <input type="number" name="status" value="{{ old('status', $item->status) }}"
                        class="w-full rounded border px-3 py-2 bg-white dark:bg-gray-900" required>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm mb-1">Nome</label>
                    <input type="text" name="name" value="{{ old('name', $item->name) }}"
                        class="w-full rounded border px-3 py-2 bg-white dark:bg-gray-900" required>
                </div>
                <div>
                    <label class="block text-sm mb-1">Criado em</label>
                    <input type="datetime-local" name="date_creation"
                        value="{{ old('date_creation', optional($item->date_creation)->format('Y-m-d\TH:i')) }}"
                        class="w-full rounded border px-3 py-2 bg-white dark:bg-gray-900">
                </div>
                <div>
                    <label class="block text-sm mb-1">Modificado em</label>
                    <input type="datetime-local" name="date_mod"
                        value="{{ old('date_mod', optional($item->date_mod)->format('Y-m-d\TH:i')) }}"
                        class="w-full rounded border px-3 py-2 bg-white dark:bg-gray-900">
                </div>
                <div>
                    <label class="block text-sm mb-1">Prioridade Ordem</label>
                    <input type="number" name="priority_order"
                        value="{{ old('priority_order', $item->priority_order) }}"
                        class="w-full rounded border px-3 py-2 bg-white dark:bg-gray-900">
                </div>
                <div>
                    <label class="block text-sm mb-1">Prioridade Número</label>
                    <input type="number" step="0.000001" name="priority_number"
                        value="{{ old('priority_number', $item->priority_number) }}"
                        class="w-full rounded border px-3 py-2 bg-white dark:bg-gray-900">
                </div>
                <div>
                    <label class="block text-sm mb-1">Projeto</label>
                    <input type="text" name="proj" value="{{ old('proj', $item->proj) }}"
                        class="w-full rounded border px-3 py-2 bg-white dark:bg-gray-900">
                </div>
                <div>
                    <label class="block text-sm mb-1">Jira</label>
                    <input type="text" name="jira" value="{{ old('jira', $item->jira) }}"
                        class="w-full rounded border px-3 py-2 bg-white dark:bg-gray-900">
                </div>
                <div>
                    <label class="block text-sm mb-1">Área</label>
                    <input type="text" name="area" value="{{ old('area', $item->area) }}"
                        class="w-full rounded border px-3 py-2 bg-white dark:bg-gray-900">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm mb-1">Nota</label>
                    <textarea name="note" rows="4" class="w-full rounded border px-3 py-2 bg-white dark:bg-gray-900">{{ old('note', $item->note) }}</textarea>
                </div>
            </div>
            <div class="flex justify-end gap-2">
                <a href="{{ route('glpi.controle-glpi.index') }}" class="px-3 py-2 text-sm rounded border">Cancelar</a>
                <button type="submit" class="px-3 py-2 text-sm rounded bg-blue-600 text-white">Salvar</button>
            </div>
        </form>
    </div>
</div>

@include('includes.footer')
