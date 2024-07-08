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

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
