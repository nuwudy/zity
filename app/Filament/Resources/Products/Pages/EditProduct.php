<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('add_new')
                ->label('Add New Product')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->url(ProductResource::getUrl('create')),
            Action::make('view_shop')
                ->label('View on Card')
                ->url(fn (): string => $this->record->business->getUrl())
                ->icon('heroicon-o-eye')
                ->openUrlInNewTab(),
            DeleteAction::make(),
        ];
    }
}
