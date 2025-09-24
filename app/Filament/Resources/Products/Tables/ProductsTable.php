<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ReplicateAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->sortable()
                    ->searchable(isIndividual: true, isGlobal: false),
                TextColumn::make('price')
                    ->label('Price')
                    ->money('brl', true)
                    ->sortable(),
                TextColumn::make('description')
                    ->label('Description')
                    ->limit(10)
                    ->wrap()
                    ->searchable(isIndividual: true, isGlobal: false),
            ])
            ->defaultSort('name')
            ->filters([
                //
            ])
            ->recordActions([
                ReplicateAction::make()
                    ->label('Duplicate'),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
