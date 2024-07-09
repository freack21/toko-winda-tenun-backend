<?php

namespace App\Filament\Resources\ProductVariationOptionResource\Pages;

use App\Filament\Resources\ProductVariationOptionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductVariationOptions extends ListRecords
{
    protected static string $resource = ProductVariationOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
