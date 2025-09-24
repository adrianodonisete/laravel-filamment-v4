<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\ModalTableSelect;
use App\Enums\ProductsStatusEnum;
use App\Filament\Tables\CategoriesTable;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('price')
                    ->label('Price')
                    ->required()
                    ->numeric()
                    ->minValue(0.01)
                    ->step(0.01)
                    ->prefix('$'),
                TextInput::make('description')
                    ->label('Description')
                    ->maxLength(600),

                // Select::make('category_id')
                //     ->label('Category')
                //     ->relationship('category', 'name')
                //     ->required(),
                ModalTableSelect::make('category_id')
                    ->label('Category (Modal Table Select)')
                    ->relationship('category', 'name')
                    ->columns(['name'])
                    ->required()
                    ->tableConfiguration(CategoriesTable::class),

                Radio::make('status')
                    ->label('Status')
                    ->options(ProductsStatusEnum::class)
                    ->required(),
            ]);
    }
}
