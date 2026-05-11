<?php

declare(strict_types=1);

namespace App\Http\Controllers\Utils;

use App\Actions\Utils\PostConvertCsvToJsonAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Utils\PostCsvToJsonRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CsvToJsonController extends Controller
{
    public function index(): View
    {
        return view('utils.csv-to-json.index');
    }

    public function store(PostCsvToJsonRequest $request, PostConvertCsvToJsonAction $action): RedirectResponse
    {
        if ($request->hasFile('csv')) {
            $csvContent = $request->file('csv')->getContent();
            if ($csvContent === false) {
                return redirect()->route('utils.csv-to-json.index')
                    ->withErrors(['csv' => 'Não foi possível ler o arquivo CSV.']);
            }
        } else {
            $csvContent = (string) $request->input('csv_text');
        }

        try {
            $path = $action->handle($csvContent);
        } catch (\Exception $e) {
            return redirect()->route('utils.csv-to-json.index')
                ->withErrors(['csv' => 'Ocorreu um erro ao processar o arquivo: ' . $e->getMessage()]);
        }

        return redirect()
            ->route('utils.csv-to-json.index')
            ->with('success', 'Arquivo JSON gerado com sucesso!')
            ->with('download_url', asset($path));
    }
}
