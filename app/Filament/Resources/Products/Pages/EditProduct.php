<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('view_shop')
                ->label('View in Shop')
                ->url(fn (): string => route('business.show', ['business' => $this->record->business->slug]))
                ->icon('heroicon-o-eye')
                ->openUrlInNewTab(),
            DeleteAction::make(),
        ];
    }
}
