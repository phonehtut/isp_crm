<?php

namespace App\Filament\Resources\PortResource\Pages;

use App\Filament\Resources\PortResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPorts extends ListRecords
{
    protected static string $resource = PortResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
