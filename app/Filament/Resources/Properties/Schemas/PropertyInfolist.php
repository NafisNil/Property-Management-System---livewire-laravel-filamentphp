<?php

namespace App\Filament\Resources\Properties\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Schemas\Schema;

class PropertyInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('type')
                    ->badge(),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('listing_type')
                    ->badge(),
                TextEntry::make('price')
                    ->money(),
                TextEntry::make('price_per_sqft')
                    ->numeric()
                    ->placeholder('-')->money(),
                TextEntry::make('address'),
                TextEntry::make('city'),
                TextEntry::make('state'),
                TextEntry::make('country'),
                TextEntry::make('postal_code')
                    ->placeholder('-'),
                TextEntry::make('latitude')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('longitude')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('bedrooms')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('bathrooms')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('area_sqft')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('year_built')
                    ->numeric()
                    ->placeholder('-'),
                IconEntry::make('has_garage')
                    ->boolean(),
                IconEntry::make('is_furnished')
                    ->boolean(),
                TextEntry::make('parking_spaces')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('features')->badge()
                    ->placeholder('-')
                    ->columnSpanFull(),
                ImageEntry::make('images')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('slug'),
                TextEntry::make('meta_title')
                    ->placeholder('-'),
                TextEntry::make('meta_description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                IconEntry::make('is_featured')
                    ->boolean(),
                IconEntry::make('is_active')
                    ->boolean(),
                TextEntry::make('featured_until')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('owner_name')
                    ->placeholder('-'),
                TextEntry::make('owner_email')
                    ->placeholder('-'),
                TextEntry::make('owner_phone')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
