<?php

namespace App\Filament\Resources\NewOrderResource\Pages;

use App\Filament\Resources\NewOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateNewOrder extends CreateRecord
{
    protected static string $resource = NewOrderResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['create_user'] = auth()->id();

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'New Order Created Successful';
    }
}
