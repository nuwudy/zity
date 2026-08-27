<?php

namespace App\Filament\Resources\Businesses\Schemas;

use App\Models\Business;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Schema;

class BusinessForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Basic Information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', \Illuminate\Support\Str::slug($state))),
                        TextInput::make('slug')
                            ->required()
                            ->unique(Business::class, ignoreRecord: true),
                        Select::make('type')
                            ->label('Business Type')
                            ->options([
                                Business::TYPE_SHOP    => '🛍️ Product Shop',
                                Business::TYPE_SERVICE => '🔧 Service Provider',
                                Business::TYPE_BOTH    => '🛍️🔧 Both (Products & Services)',
                            ])
                            ->required()
                            ->default(Business::TYPE_SHOP)
                            ->live()
                            ->helperText('Choose whether this business sells products or provides services.'),
                        TextInput::make('url')
                            ->label('Website URL')
                            ->prefix(fn () => rtrim(config('app.url'), '/') . '/')
                            ->placeholder(fn ($record) => $record?->slug ?? 'yourbrand')
                            ->readOnly()
                            ->helperText('This is your website address.')
                            ->columnSpanFull()
                            ->hidden(fn ($record) => $record === null)
                            ->hintAction(
                                \Filament\Actions\Action::make('view_live')
                                    ->label('Open Website')
                                    ->icon('heroicon-m-arrow-top-right-on-square')
                                    ->url(fn ($record) => $record->getUrl())
                                    ->openUrlInNewTab()
                            ),
                    ])->columns(2),

                \Filament\Schemas\Components\Section::make('Contact & Details')
                    ->schema([
                        \Filament\Forms\Components\FileUpload::make('logo')
                            ->image()
                            ->avatar()
                            ->disk('public')
                            ->directory('business-logos'),
                        \Filament\Forms\Components\FileUpload::make('cover_image')
                            ->image()
                            ->disk('public')
                            ->directory('business-covers'),
                        TextInput::make('phone')
                            ->tel(),
                        TextInput::make('whatsapp')
                            ->tel(),
                        TextInput::make('email')
                            ->email(),
                        \Filament\Forms\Components\Select::make('categories')
                            ->relationship('categories', 'name')
                            ->multiple()
                            ->searchable()
                            ->preload(),

                        \Filament\Forms\Components\Select::make('status')
                            ->options([
                                Business::STATUS_ACTIVE    => 'Active',
                                Business::STATUS_SUSPENDED => 'Suspended',
                            ])
                            ->required()
                            ->default(Business::STATUS_ACTIVE)
                            ->hidden(fn () => !auth()->user()?->isMasterAdmin()),
                        Toggle::make('is_verified')
                            ->required()
                            ->default(false)
                            ->hidden(fn () => !auth()->user()?->isMasterAdmin()),
                    ])->columns(2),

                \Filament\Schemas\Components\Section::make('Service Details')
                    ->description('Fill in the details of the services you provide.')
                    ->schema([
                        TextInput::make('service_area')
                            ->label('Service Area')
                            ->placeholder('e.g. Kozhikode City, 10km radius')
                            ->helperText('Where do you provide your services?'),
                        TextInput::make('experience_years')
                            ->label('Years of Experience')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(99)
                            ->suffix('years'),
                        TextInput::make('availability')
                            ->label('Availability')
                            ->placeholder('e.g. Mon–Sat, 9am–7pm')
                            ->helperText('When are you available for work?')
                            ->columnSpanFull(),
                        Repeater::make('services')
                            ->label('Services Offered')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Service Name')
                                    ->placeholder('e.g. AC Repair, Wiring, Plumbing...')
                                    ->required(),
                            ])
                            ->addActionLabel('Add Service')
                            ->collapsible()
                            ->columnSpanFull()
                            ->defaultItems(1),
                    ])
                    ->columns(2)
                    ->visible(fn ($get) => in_array($get('type'), [Business::TYPE_SERVICE, Business::TYPE_BOTH])),

                \Filament\Schemas\Components\Section::make('Admins')
                    ->schema([
                        \Filament\Forms\Components\Select::make('admins')
                            ->relationship('admins', 'name')
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                \Filament\Forms\Components\TextInput::make('name')
                                     ->required(),
                                \Filament\Forms\Components\TextInput::make('email')
                                     ->required()
                                     ->email()
                                     ->unique('users', 'email'),
                                \Filament\Forms\Components\TextInput::make('password')
                                     ->password()
                                     ->required()
                                     ->dehydrated(fn ($state) => filled($state))
                                     ->required(fn (string $context): bool => $context === 'create'),
                            ]),
                    ])
                    ->hidden(fn () => !auth()->user()?->isMasterAdmin()),

                \Filament\Schemas\Components\Section::make('Social Media Links')
                    ->description('Links to your social media profiles.')
                    ->schema([
                        TextInput::make('facebook_url')
                            ->label('Facebook')
                            ->url()
                            ->placeholder('https://facebook.com/yourpage'),
                        TextInput::make('instagram_url')
                            ->label('Instagram')
                            ->url()
                            ->placeholder('https://instagram.com/yourhandle'),
                        TextInput::make('youtube_url')
                            ->label('YouTube')
                            ->url()
                            ->placeholder('https://youtube.com/@yourchannel'),
                        TextInput::make('twitter_url')
                            ->label('X (Twitter)')
                            ->url()
                            ->placeholder('https://x.com/yourhandle'),
                        TextInput::make('google_url')
                            ->label('Google (Business/Maps)')
                            ->url()
                            ->placeholder('Link to your Google review page or Maps location'),
                        TextInput::make('website_url')
                            ->label('External Website')
                            ->url()
                            ->placeholder('https://your-domain.com'),
                    ])
                    ->columns(2),

                \Filament\Schemas\Components\Section::make('About & Location')
                    ->schema([
                        Textarea::make('address')
                            ->columnSpanFull(),
                        TextInput::make('city'),
                        TextInput::make('state'),
                        Textarea::make('description')
                            ->label('About / Description')
                            ->columnSpanFull(),
                    ])->columns(2),

                \Filament\Schemas\Components\Section::make('Additional Branches / Shops')
                    ->description('If you have multiple locations, add them here.')
                    ->schema([
                        Repeater::make('branches')
                            ->label('Branches')
                            ->schema([
                                Textarea::make('address')
                                    ->required()
                                    ->placeholder('e.g. Branch Name, Street, City')
                                    ->rows(2),
                                TextInput::make('phone')
                                    ->tel()
                                    ->placeholder('Branch Phone Number'),
                                TextInput::make('whatsapp')
                                    ->tel()
                                    ->placeholder('Branch WhatsApp (optional)'),
                            ])
                            ->columns(2)
                            ->addActionLabel('Add Another Branch')
                            ->collapsible()
                            ->columnSpanFull()
                            ->defaultItems(0),
                    ]),
            ]);
    }
}
