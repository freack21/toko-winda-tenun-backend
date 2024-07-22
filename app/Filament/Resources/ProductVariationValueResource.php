<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductVariationValueResource\Pages;
use App\Filament\Resources\ProductVariationValueResource\RelationManagers;
use App\Models\ProductVariationValue;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductVariationValueResource extends Resource
{
    protected static ?string $model = ProductVariationValue::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    protected static ?string $navigationGroup = 'Products';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('product_id')
                    ->relationship('product', 'name')
                    ->required(),
                Select::make('option_id')
                    ->relationship('option', 'name')
                    ->required(),
                TextInput::make('value')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product.name')->label('Product')->sortable(),
                TextColumn::make('option.name')->label('Option')->sortable(),
                TextColumn::make('value')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductVariationValues::route('/'),
            'create' => Pages\CreateProductVariationValue::route('/create'),
            'edit' => Pages\EditProductVariationValue::route('/{record}/edit'),
        ];
    }
}
