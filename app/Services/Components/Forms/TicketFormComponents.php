<?php

namespace App\Services\Components\Forms;

use App\Models\Type;
use App\Models\Customer;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

class TicketFormComponents
{
    public static function ticketTitleInput()
    {
        return TextInput::make('title')
            ->label('Ticket Title')
            ->required();
    }

    public static function ticketCustomerIdSelect()
    {
        return Select::make('customer_id')
            ->relationship('customer', 'customer_id')
            ->searchable()
            ->preload()
            ->required();
    }

    public static function ticketTypeInput()
    {
        return Select::make('type_id')
            ->relationship('type', 'name')
            ->searchable()
            ->preload()
            ->required();
    }

    public static function ticketAsginSelect()
    {
        return Select::make('department_id')
            ->label('Asgin To')
            ->relationship('department', 'name')
            ->searchable()
            ->preload()
            ->required();
    }

    public static function ticketMaintainImageInput()
    {
        return FileUpload::make('mainten_image')
            ->label('Maintenance Image')
            ->multiple()
            ->image()
            ->directory(function (callable $get) {
                $customer = Customer::find($get('customer_id'));
                $customerID = $customer ? $customer->customer_id : null;
                $type = Type::find($get('type_id'));
                $typeName = $type ? $type->name : null;
                $currentDate = now()->format('m-d-Y');
                return "customers/{$customerID}/{$currentDate}_Service_{$typeName}/";
            })
            ->disk('public');
    }

    public static function ticketInstallationImageInput()
    {
        return FileUpload::make('install_image')
            ->label('Installation Image')
            ->multiple()
            ->image()
            ->directory(function (callable $get) {
                $customer = Customer::find($get('customer_id'));
                $customerID = $customer ? $customer->customer_id : null;
                $currentDate = now()->format('m-d-Y');
                return "customers/{$customerID}/_{$currentDate}_Installation/";
            })
            ->disk('public');
    }

    public static function ticketPriorityRadio()
    {
        return Radio::make('priority')
            ->options([
                '0' => 'low',
                '1' => 'middle',
                '2' => 'High',
                '3' => 'Urgent',
            ])->columns(1)
            ->required();
    }

    public static function ticketStatusRadio()
    {
        return Radio::make('status')
            ->options([
                '0' => 'open',
                '1' => 'resolved',
                '2' => 'close',
            ])->columns(1)
            ->required();
    }

    public static function ticketReasonInput()
    {
        return Textarea::make('reason')
            ->hiddenLabel()
            ->required();
    }
}
