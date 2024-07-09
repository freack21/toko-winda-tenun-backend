<?php

namespace App\Filament\Resources\ProductVariationValueResource\Pages;

use App\Filament\Resources\ProductVariationValueResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductVariationValue extends EditRecord
{
    protected static string $resource = ProductVariationValueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
