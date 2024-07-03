<?php

namespace App\Services\Components\Forms;

use App\Models\Port;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;


class CustomerFormComponents
{

    /**
     * Customer Information Section Start
     */
    public static function customerIdInput()
    {
        return TextInput::make('customer_id')
            ->placeholder('Please Enter ID');
    }

    public static function customerNameInput()
    {
        return TextInput::make('name')
            ->label('Customer Name')
            ->required()
            ->placeholder('Please Enter Customer Name');
    }

    public static function customerEmailInput()
    {
        return TextInput::make('email')
            ->label('Email')
            ->placeholder('Please Enter Customer Email');
    }

    public static function customerPhoneInput()
    {
        return TextInput::make('phone')
            ->label('Phone Number')
            ->placeholder('Please Enter Customer Phone Number')
            ->tel();
    }

    /**
     * NRC Section Start
     */
    public static function customerNrcFrontPhoto()
    {
        return FileUpload::make('nrc_front')
            ->hiddenLabel()
            ->placeholder('Please Select NRC Front Photo')
            ->directory(function (callable $get) {
                $customerID = $get('customer_id');
                return "customers/{$customerID}/nrc/front";
            })
            ->disk('public');
    }

    public static function customerNrcBackPhoto()
    {
        return FileUpload::make('nrc_back')
            ->hiddenLabel()
            ->placeholder('Please Select NRC Back Photo')
            ->directory(function (callable $get) {
                $customerID = $get('customer_id');
                return "customers/{$customerID}/nrc/back";
            })
            ->disk('public');
    }
    /**
     * NRC Section End
     */

    public static function customerTownshipSelect()
    {
        return Select::make('township_id')
            ->relationship('township','name')
            ->searchable()
            ->preload();
    }

    public static function customerLatlongInput()
    {
        return TextInput::make('lat_long')
            ->label('Lat/Long')
            ->placeholder('Please Enter Customer Lat/Long');
    }

    public static function customerAddressInput()
    {
        return RichEditor::make('address')
            ->label('Address')
            ->placeholder('Please Enterb Customer Address')
            ->required()
            ->columnSpan('full');
    }
    /**
     * Customer Inforation Section End
     */

    /**
     * Billing Information Section Start
     */
    public static function customerRegisterDate()
    {
        return DatePicker::make('register_date')
            ->native(false);
    }

    public static function customerPlanSelect()
    {
        return Select::make('plan_id')
            ->relationship('plan','name')
            ->searchable()
            ->preload();
    }
    /**
     * Billing Information Section End
     */

    /**
     * Site Informarion Section Start
     */
    public static function customerFatSelect()
    {
        return Select::make('fat_id')
            ->relationship('fat', 'name')
            ->reactive()
            ->searchable()
            ->preload()
            ->afterStateUpdated(fn ($state, callable $set) => $set('port_id', null))
            ->columnSpan(2);
    }

    public static function customerPortSelect()
    {
        return Select::make('port_id')
            ->relationship('port', 'name')
            ->options(function (callable $get) {
                $fatId = $get('fat_id');

                if (!$fatId) {
                    return [];
                }

                return Port::whereHas('fat_boxes', function ($query) use ($fatId) {
                    $query->where('fat_id', $fatId);
                })->pluck('name', 'id');
            })
            ->searchable()
            ->preload()
            ->columnSpan(1);
    }

    public static function customerStartCableInput()
    {
        return TextInput::make('start_cable')
            ->label('Cable Start')
            ->suffix('meter')
            ->reactive()
            ->afterStateUpdated(function ($state, callable $set, $get) {
                $endCable = $get('end_cable');
                if (is_numeric($state) && is_numeric($endCable)) {
                    $set('total_cable', $state - $endCable);
                } else {
                    $set('total_cable', 'start cable or end cable is not integer');
                }
            });
    }

    public static function customerEndCableInput()
    {
        return TextInput::make('end_cable')
            ->label('Cable End')
            ->suffix('meter')
            ->reactive()
            ->afterStateUpdated(function ($state, callable $set, $get) {
                $startCable = $get('start_cable');
                if (is_numeric($state) && is_numeric($startCable)) {
                    $set('total_cable', $startCable - $state);
                } else {
                    $set('total_cable', 'start cable or end cable is not integer');
                }
            });
    }

    public static function customerTotalCableInput()
    {
        return TextInput::make('total_cable')
            ->label('Total Cable')
            ->suffix('meter')
            ->readOnly()
            ->label('Total Cable')
            ->suffix('meter');
    }

    public static function customerFatOpticalInput()
    {
        return TextInput::make('fat_optical')
            ->label('FAT Optical')
            ->suffix('dbm');
    }

    public static function customerCusResOpticalInput()
    {
        return TextInput::make('cus_res_optical')
            ->label('Customer Recive Optical')
            ->suffix('dbm');
    }

    public static function customerOnuOpticalInput()
    {
        return TextInput::make('onu_optical')
            ->label('Onu Optical')
            ->suffix('dbm');
    }

    public static function customerSnInput()
    {
        return TextInput::make('sn')
            ->required()
            ->columnSpan('full');
    }
}
