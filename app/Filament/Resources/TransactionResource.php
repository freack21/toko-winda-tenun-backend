<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Helpers\CurrencyFormatter;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use App\Models\Product;


class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Transaction';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // repeater for product gallery */
                // name username relationship to user table
                Select::make('username')
                    ->relationship('user', 'username')->disabled(),

                Forms\Components\Group::make()
                    ->schema([

                        Repeater::make('items')
                            ->relationship('items')

                            ->schema([
                                Select::make('products_id')->label("Product")->options(Product::all()->pluck('name', 'id'))->searchable()->disabled(),
                                TextInput::make('quantity')->readOnly(),
                            ])->columns(2),
                    ])->columnSpan(2),
                // TextInput::make('user.username')->required(),

                Select::make('status')->options(
                    [
                        "PENDING" => "PENDING",
                        "SUCCESS" => "SUCCESS",
                        "CANCELLED" => "CANCELLED",
                        "FAILED" => "FAILED",
                        "SHIPPING" => "SHIPPING",
                        "SHIPPED" => "SHIPPED"
                    ]
                )->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.username')->label("Buyer")->sortable(),
                TextColumn::make('address')->sortable(),
                TextColumn::make('total_price')->sortable()->formatStateUsing(fn ($state) => CurrencyFormatter::formatRupiah($state)),
                TextColumn::make('shipping_price')->sortable()->formatStateUsing(fn ($state) => CurrencyFormatter::formatRupiah($state)),
                TextColumn::make('status')->sortable()->badge()
                    ->colors([
                        'primary',
                        'secondary' => 'PENDING',
                        'warning' => 'SHIPPING',
                        'success' => 'SUCCESS',
                        'danger' => 'FAILED',
                    ])
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                // view
                Tables\Actions\ViewAction::make(),



                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function canDelete(Model $record): bool
    {
        return Auth::user()->hasRole('SUPERADMIN');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
