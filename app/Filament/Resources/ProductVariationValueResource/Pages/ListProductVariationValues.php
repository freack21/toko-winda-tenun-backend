<?php

namespace App\Filament\Resources\ProductVariationValueResource\Pages;

use App\Filament\Resources\ProductVariationValueResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductVariationValues extends ListRecords
{
    protected static string $resource = ProductVariationValueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
