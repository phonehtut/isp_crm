<?php

namespace App\Filament\Resources\DepartmentResource\Pages;

use Illuminate\Support\Facades\Auth;
use App\Notifications\DepartmentCreated;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\DepartmentResource;

class CreateDepartment extends CreateRecord
{
    protected static string $resource = DepartmentResource::class;

}
