<?php

namespace App\Filament\Resources\NewOrderTicketResource\Pages;

use App\Filament\Resources\NewOrderTicketResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNewOrderTickets extends ListRecords
{
    protected static string $resource = NewOrderTicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
