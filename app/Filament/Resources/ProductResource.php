<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Helpers\CurrencyFormatter;
use App\Models\Product;
use App\Models\ProductCategory;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    protected static ?string $navigationGroup = 'Products';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required(),
                Textarea::make('description')->nullable(),
                TextInput::make('price')->required()->extraAttributes(['id' => 'priceInput'])->prefix("Rp."),
                Select::make('categories_id')->label("Category")->options(ProductCategory::all()->pluck('name', 'id'))->searchable(),
                Textarea::make('tags')->nullable(),

                // repeater for product gallery */
                Repeater::make('galleries')
                    ->relationship('galleries')

                    ->schema([
                        FileUpload::make('image')->image()->required(),
                    ]),
                Repeater::make('variations')
                    ->relationship('variations')

                    ->schema([
                        Textarea::make('value')->nullable(),
                        ])


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // index
                TextColumn::make('id')->sortable(),
                TextColumn::make('name')->sortable(),
                TextColumn::make('price')->sortable()->formatStateUsing(fn ($state) => CurrencyFormatter::formatRupiah($state)),
                TextColumn::make('category.name')->label("Category")->sortable(),
            ])->defaultSort('created_at', 'asc')
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
