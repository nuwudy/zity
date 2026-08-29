<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', \Illuminate\Support\Str::slug($state))),
                TextInput::make('slug')
                    ->required()
                    ->unique('categories', 'slug', ignoreRecord: true),
                \Filament\Forms\Components\Select::make('parent_id')
                    ->relationship('parent', 'name', modifyQueryUsing: fn ($query) => auth()->user()?->isMasterAdmin() ? $query : $query->where('user_id', auth()->id()))
                    ->searchable()
                    ->preload(),
                TextInput::make('icon')
                    ->placeholder('e.g. 🌿, 🧴, ✂️'),
            ]);
    }
}
