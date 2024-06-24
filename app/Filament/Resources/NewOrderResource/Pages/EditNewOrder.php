<?php

namespace App\Filament\Resources\NewOrderResource\Pages;

use App\Filament\Resources\NewOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNewOrder extends EditRecord
{
    protected static string $resource = NewOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
