<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ReplicateAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use App\Enums\ProductsStatusEnum;
use App\Models\Product;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(isIndividual: true, isGlobal: false),
                TextColumn::make('name')
                    ->label('Name')
                    ->sortable()
                    ->searchable(isIndividual: true, isGlobal: false),
                TextColumn::make('price')
                    ->label('Price')
                    ->money('brl', true)
                    ->sortable(),
                TextColumn::make('category.name')
                    ->label('Category')
                    ->searchable(isIndividual: true, isGlobal: false),
                TextColumn::make('status')
                    ->label('Status')
                    ->searchable(isIndividual: true, isGlobal: false),
            ])
            ->defaultSort('name')
            ->filters([
                //
            ])
            ->recordActions([
                ReplicateAction::make()
                    ->label('Copy')
                    ->beforeReplicaSaved(function (Product $replica, Product $original): void {
                        $replica->name = "{$replica->name} (Copy from {$original->id})";
                        $replica->status = ProductsStatusEnum::INACTIVE->value;
                    }),
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
