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

                \Filament\Forms\Components\Select::make('category')
                    ->placeholder('Select or type a category')
                    ->options(function () {
                        if (auth()->user()?->isMasterAdmin()) {
                            return \App\Models\Category::pluck('name', 'name')->toArray();
                        }
                        return \App\Models\Category::where('user_id', auth()->id())
                            ->pluck('name', 'name')
                            ->toArray();
                    })
                    ->searchable()
                    ->createOptionForm([
                        \Filament\Forms\Components\TextInput::make('new_category')
                            ->label('New Category Name')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->createOptionUsing(function (array $data) {
                        $name = $data['new_category'];
                        $userId = auth()->id();
                        \App\Models\Category::firstOrCreate(
                            ['name' => $name, 'user_id' => $userId],
                            ['slug' => \Illuminate\Support\Str::slug($name) . ($userId ? '-' . $userId : '')]
                        );
                        return $name;
                    }),
                TextInput::make('name')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('price')
                    ->numeric()
                    ->prefix('₹'),
                FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->directory('products'),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
