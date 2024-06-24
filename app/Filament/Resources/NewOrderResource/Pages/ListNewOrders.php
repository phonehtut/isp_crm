<?php

namespace App\Filament\Resources\NewOrderResource\Pages;

use App\Filament\Resources\NewOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNewOrders extends ListRecords
{
    protected static string $resource = NewOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
