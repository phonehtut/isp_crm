<?php

namespace App\Filament\Resources\FatBoxResource\Pages;

use App\Filament\Resources\FatBoxResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFatBox extends EditRecord
{
    protected static string $resource = FatBoxResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
