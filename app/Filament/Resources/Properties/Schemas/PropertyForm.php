<?php

namespace App\Filament\Resources\Properties\Schemas;

use App\Models\Property;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PropertyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Property Details')
                ->schema([
                    TextInput::make('title')->required(),
                    Textarea::make('description')->default(null)->columnSpanFull(),

                    Select::make('type')
                        ->options(Property::getPropertyTypes())
                        ->required(),
                    Select::make('status')
                        ->options(Property::getStatuses())
                        ->default('available')
                        ->required(),
                    Select::make('listing_type')
                        ->options(Property::getListingTypes())
                        ->default('sale')
                        ->required(),
                    TextInput::make('price')->required()->numeric()->prefix('$'),
                    TextInput::make('price_per_sqft')->numeric()->default(null),
                    TextArea::make('address')->required(),
                    TextInput::make('city')->required(),
                    TextInput::make('state')->required(),
                    TextInput::make('country')->required(),
                    TextInput::make('postal_code')->default(null),
                    TextInput::make('latitude')->numeric()->default(null),
                    TextInput::make('longitude')->numeric()->default(null),
                ])
                ->columns(1),

            Section::make('Additional Information')->schema([

                TextInput::make('bedrooms')->numeric()->default(null),
                TextInput::make('bathrooms')->numeric()->default(null),
                TextInput::make('area_sqft')->numeric()->default(null),
                TextInput::make('year_built')->numeric()->default(null),
                Toggle::make('has_garage')->live()->required(),
                Toggle::make('is_furnished')->required(),
                TextInput::make('parking_spaces')->visible(fn($get) => (bool) $get('has_garage'))->numeric()->default(null),
                TagsInput::make('features')->helperText('Add features like pool, fireplace, garden, etc.')->columnSpanFull(),
                FileUpload::make('images')->image()->multiple()->disk('public')->maxFiles(10)->directory('properties/images')->default(null)->columnSpanFull()->panelLayout('grid'),
                TextInput::make('slug')->readOnly(),
                TextInput::make('meta_title')->default(null),
                Textarea::make('meta_description')->default(null)->columnSpanFull(),
                Toggle::make('is_featured')->live()->required(),
                Toggle::make('is_active')->required(),
                DateTimePicker::make('featured_until')->visible(fn($get) => (bool) $get('is_featured'))->default(null),

            ]),
            Section::make('contact_information')->schema([
                TextInput::make('owner_name')->default(null),
                TextInput::make('owner_email')->email()->default(null),
                TextInput::make('owner_phone')->tel()->default(null),
            ])->columnSpanFull(),
        ]);
    }
}
