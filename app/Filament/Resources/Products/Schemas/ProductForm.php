<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Select::make('business_id')
                    ->relationship('business', 'name', modifyQueryUsing: fn ($query) => auth()->user()?->isMasterAdmin() ? $query : $query->where('user_id', auth()->id()))
                    ->required()
                    ->default(fn () => auth()->user()?->isMasterAdmin() ? null : \App\Models\Business::where('user_id', auth()->id())->first()?->id)
                    ->hidden(fn () => !auth()->user()?->isMasterAdmin() && \App\Models\Business::where('user_id', auth()->id())->count() === 1)
                    ->dehydrated(true),

                TextInput::make('category')
                    ->placeholder('e.g. Biryani, Meals veg, etc.')
                    ->maxLength(255),
                TextInput::make('name')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('price')
                    ->numeric()
                    ->prefix('$'),
                FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->directory('products'),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
