<?php

namespace App\Filament\Resources\Businesses\Pages;

use App\Filament\Resources\Businesses\BusinessResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBusiness extends EditRecord
{
    protected static string $resource = BusinessResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('visit_zitypage')
                ->label('Visit ZityPage')
                ->icon('heroicon-m-arrow-top-right-on-square')
                ->color('success')
                ->url(fn ($record) => $record->getUrl())
                ->openUrlInNewTab(),
            DeleteAction::make(),
        ];
    }
}
