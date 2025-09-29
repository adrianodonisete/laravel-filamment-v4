<?php

namespace App\Http\Controllers\Glpi;

use App\Http\Controllers\Controller;
use App\Http\Requests\Glpi\CreateControleGlpiRequest;
use App\Http\Requests\Glpi\UpdateControleGlpiRequest;
use App\Models\Glpi\ControleGlpi;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ControleGlpiController extends Controller
{
    public function index(): View
    {
        $items = ControleGlpi::query()
            ->where('date_creation', '>', now()->subDays(7))
            ->orderByDesc('id')
            ->paginate(15);

        return view('glpi.controle-glpi.index', compact('items'));
    }

    public function create(): View
    {
        return view('glpi.controle-glpi.create');
    }

    public function store(CreateControleGlpiRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $item = ControleGlpi::query()->create($data);

        return redirect()
            ->route('glpi.controle-glpi.show', $item)
            ->with('success', 'Registro criado com sucesso.');
    }

    public function show(ControleGlpi $controleGlpi): View
    {
        return view('glpi.controle-glpi.show', ['item' => $controleGlpi]);
    }

    public function edit(ControleGlpi $controleGlpi): View
    {
        return view('glpi.controle-glpi.edit', ['item' => $controleGlpi]);
    }

    public function update(UpdateControleGlpiRequest $request, ControleGlpi $controleGlpi): RedirectResponse
    {
        $data = $request->validated();
        $controleGlpi->update($data);

        return redirect()
            ->route('glpi.controle-glpi.show', $controleGlpi)
            ->with('success', 'Registro atualizado com sucesso.');
    }

    public function destroy(ControleGlpi $controleGlpi): RedirectResponse
    {
        $controleGlpi->delete();

        return redirect()
            ->route('glpi.controle-glpi.index')
            ->with('success', 'Registro excluído com sucesso.');
    }
}
