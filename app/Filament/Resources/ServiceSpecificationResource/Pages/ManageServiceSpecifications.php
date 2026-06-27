<?php

namespace App\Filament\Resources\ServiceSpecificationResource\Pages;

use App\Filament\Resources\ServiceSpecificationResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageServiceSpecifications extends ManageRecords
{
    protected static string $resource = ServiceSpecificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
