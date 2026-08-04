<?php

namespace App\Filament\Resources\Businesses\Tables;

use App\Models\Business;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BusinessesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('slug')
                    ->searchable(),
                TextColumn::make('logo')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        Business::STATUS_ACTIVE => 'success',
                        Business::STATUS_SUSPENDED => 'danger',
                        default => 'gray',
                    })
                    ->searchable(),
                TextColumn::make('phone')
                    ->searchable(),

                TextColumn::make('categories.name')
                    ->badge()
                    ->searchable(),
                IconColumn::make('is_verified')
                    ->boolean(),
                TextColumn::make('whatsapp')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('suspend')
                    ->label('Suspend')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->hidden(fn (Business $record): bool => $record->status === Business::STATUS_SUSPENDED)
                    ->action(fn (Business $record) => $record->update(['status' => Business::STATUS_SUSPENDED]))
                    ->requiresConfirmation(),
                Action::make('activate')
                    ->label('Activate')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->hidden(fn (Business $record): bool => $record->status === Business::STATUS_ACTIVE)
                    ->action(fn (Business $record) => $record->update(['status' => Business::STATUS_ACTIVE]))
                    ->requiresConfirmation(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
