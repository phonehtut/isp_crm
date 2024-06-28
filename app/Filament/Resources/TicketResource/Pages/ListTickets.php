<?php

namespace App\Filament\Resources\TicketResource\Pages;

use Filament\Actions;
use App\Models\Ticket;
use App\Models\NewOrderTicket;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\TicketResource;
use App\Filament\Resources\NewOrderTicketResource;

class ListTickets extends ListRecords
{
    protected static string $resource = TicketResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\CreateAction::make(),
    //         Actions\Action::make('createInstalationTicket') // Custom action for creating a customer
    //             ->label('Create New Installation Ticket') // Label for the action button
    //             ->url(route('filament.admin.resources.customers.create')) // URL to redirect when the action is clicked
    //             ->icon('heroicon-o-plus'),
    //     ];
    // }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

}
