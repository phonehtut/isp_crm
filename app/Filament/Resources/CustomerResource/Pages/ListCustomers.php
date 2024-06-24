<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\CustomerResource;
use JoseEspinal\RecordNavigation\Traits\HasRecordsList;

class ListCustomers extends ListRecords
{
    use HasRecordsList;

    protected static string $resource = CustomerResource::class;

    protected function getHeaderActions(): array
    {

        return [
            Actions\CreateAction::make(),
        ];

    }

}
