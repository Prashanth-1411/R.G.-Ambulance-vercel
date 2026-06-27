<?php

namespace App\Filament\Resources\ServiceBrochureResource\Pages;

use App\Filament\Resources\ServiceBrochureResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageServiceBrochures extends ManageRecords
{
    protected static string $resource = ServiceBrochureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
