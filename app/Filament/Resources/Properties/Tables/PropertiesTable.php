<?php

namespace App\Filament\Resources\Properties\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PropertiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('type')
                    ->badge(),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('listing_type')
                    ->badge(),
                TextColumn::make('price')
                    ->money()
                    ->sortable(),
                TextColumn::make('price_per_sqft')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('address')
                    ->searchable()
                    ->wrap(),
                TextColumn::make('city')
                    ->searchable(),
                TextColumn::make('state')
                    ->searchable(),
                TextColumn::make('country')
                    ->searchable(),
                TextColumn::make('postal_code')
                    ->searchable(),
                TextColumn::make('latitude')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('longitude')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('bedrooms')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('bathrooms')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('area_sqft')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('year_built')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('has_garage')
                    ->boolean(),
                IconColumn::make('is_furnished')
                    ->boolean(),
                TextColumn::make('parking_spaces')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('slug')
                    ->searchable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('meta_title')
                    ->searchable() ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('is_featured')
                    ->boolean(),
                IconColumn::make('is_active')
                    ->boolean(),
                TextColumn::make('featured_until')
                    ->dateTime()
                    ->sortable(),
                
                TextColumn::make('owner_name')
                    ->searchable(),
                TextColumn::make('owner_email')
                    ->searchable(),
                TextColumn::make('owner_phone')
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
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
