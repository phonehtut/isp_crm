<?php

namespace App\Filament\Resources\TicketResource\Pages;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\TicketResource;
use Parallax\FilamentComments\Actions\CommentsAction;

class ViewTicket extends ViewRecord
{
    protected static string $resource = TicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CommentsAction::make(),
        ];
    }
}
