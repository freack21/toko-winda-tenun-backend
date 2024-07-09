<?php

namespace App\Filament\Resources\ProductVariationOptionResource\Pages;

use App\Filament\Resources\ProductVariationOptionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductVariationOption extends EditRecord
{
    protected static string $resource = ProductVariationOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
