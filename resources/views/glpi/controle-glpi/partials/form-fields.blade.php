<div class="grid sm:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm mb-1">Ticket</label>
        <input type="number" name="id_ticket" value="{{ old('id_ticket', $item->id_ticket ?? null) }}"
            class="w-full rounded border px-3 py-2 bg-white dark:bg-gray-900" required>
    </div>
    <div>
        <label class="block text-sm mb-1">Status</label>
        <input type="number" name="status" value="{{ old('status', $item->status ?? null) }}"
            class="w-full rounded border px-3 py-2 bg-white dark:bg-gray-900" required>
    </div>
    <div class="sm:col-span-2">
        <label class="block text-sm mb-1">Nome</label>
        <input type="text" name="name" value="{{ old('name', $item->name ?? null) }}"
            class="w-full rounded border px-3 py-2 bg-white dark:bg-gray-900" required>
    </div>
    <div>
        <label class="block text-sm mb-1">Criado em</label>
        <input type="datetime-local" name="date_creation"
            value="{{ old('date_creation', isset($item->date_creation) ? optional($item->date_creation)->format('Y-m-d\TH:i') : null) }}"
            class="w-full rounded border px-3 py-2 bg-white dark:bg-gray-900">
    </div>
    <div>
        <label class="block text-sm mb-1">Modificado em</label>
        <input type="datetime-local" name="date_mod"
            value="{{ old('date_mod', isset($item->date_mod) ? optional($item->date_mod)->format('Y-m-d\TH:i') : null) }}"
            class="w-full rounded border px-3 py-2 bg-white dark:bg-gray-900">
    </div>
    <div>
        <label class="block text-sm mb-1">Prioridade Ordem</label>
        <input type="number" name="priority_order" value="{{ old('priority_order', $item->priority_order ?? null) }}"
            class="w-full rounded border px-3 py-2 bg-white dark:bg-gray-900">
    </div>
    <div>
        <label class="block text-sm mb-1">Prioridade Número</label>
        <input type="number" step="0.000001" name="priority_number"
            value="{{ old('priority_number', $item->priority_number ?? null) }}"
            class="w-full rounded border px-3 py-2 bg-white dark:bg-gray-900">
    </div>
    <div>
        <label class="block text-sm mb-1">Projeto</label>
        <input type="text" name="proj" value="{{ old('proj', $item->proj ?? null) }}"
            class="w-full rounded border px-3 py-2 bg-white dark:bg-gray-900">
    </div>
    <div>
        <label class="block text-sm mb-1">Jira</label>
        <input type="text" name="jira" value="{{ old('jira', $item->jira ?? null) }}"
            class="w-full rounded border px-3 py-2 bg-white dark:bg-gray-900">
    </div>
    <div>
        <label class="block text-sm mb-1">Área</label>
        <input type="text" name="area" value="{{ old('area', $item->area ?? null) }}"
            class="w-full rounded border px-3 py-2 bg-white dark:bg-gray-900">
    </div>
    <div class="sm:col-span-2">
        <label class="block text-sm mb-1">Nota</label>
        <textarea name="note" rows="4" class="w-full rounded border px-3 py-2 bg-white dark:bg-gray-900">{{ old('note', $item->note ?? null) }}</textarea>
    </div>
</div>
