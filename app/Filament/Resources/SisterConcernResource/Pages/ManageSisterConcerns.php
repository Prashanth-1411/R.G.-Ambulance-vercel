<?php

namespace App\Filament\Resources\SisterConcernResource\Pages;

use App\Filament\Resources\SisterConcernResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageSisterConcerns extends ManageRecords
{
    protected static string $resource = SisterConcernResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
