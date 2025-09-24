<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Number;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    /**
     * Configuration for this especific page
     */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['name'] = str($data['name'])->upper();
        $data['price'] = Number::format($data['price'], 2);
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['name'] = str($data['name'])->upper();
        $data['price'] = Number::format($data['price'], 2);
        return $data;
    }
}
