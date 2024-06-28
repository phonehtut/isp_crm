<?php

namespace App\Filament\Resources\FaultPointResource\Pages;

use App\Filament\Resources\FaultPointResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFaultPoints extends ListRecords
{
    protected static string $resource = FaultPointResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
