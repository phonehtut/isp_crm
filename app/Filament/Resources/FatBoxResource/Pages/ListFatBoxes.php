<?php

namespace App\Filament\Resources\FatBoxResource\Pages;

use App\Filament\Resources\FatBoxResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFatBoxes extends ListRecords
{
    protected static string $resource = FatBoxResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
