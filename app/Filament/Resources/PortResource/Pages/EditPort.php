<?php

namespace App\Filament\Resources\PortResource\Pages;

use App\Filament\Resources\PortResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPort extends EditRecord
{
    protected static string $resource = PortResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
