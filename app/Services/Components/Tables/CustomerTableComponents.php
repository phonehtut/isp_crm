<?php

namespace App\Services\Components\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextInputColumn;


class CustomerTableComponents
{
    public static function customerRegisterDateColumn()
    {
        return TextColumn::make('register_date')
            ->label('Register Date')
            ->sortable();
    }

    public static function customerIdColumn()
    {
        return TextColumn::make('customer_id')
            ->badge()
            ->searchable()
            ->sortable();
    }

    public static function customerNameColumn()
    {
        return TextColumn::make('name')
            ->label('Name')
            ->searchable()
            ->sortable();
    }

    public static function customerEmailColumn()
    {
        return TextColumn::make('email')
            ->label('Email')
            ->searchable()
            ->sortable();
    }

    public static function customerPhoneColumn()
    {
        return TextColumn::make('phone')
            ->label('Phone Number')
            ->searchable();
    }

    public static function customerAddressColumn()
    {
        return TextColumn::make('address')
            ->limit(30)
            ->html()
            ->toggleable(isToggledHiddenByDefault: false);
    }

    public static function customerTownshipColumn()
    {
        return TextColumn::make('township.name')
            ->sortable()
            ->searchable();
    }

    public static function customerNrcFrontColumn()
    {
        return ImageColumn::make('nrc_front')
            ->label('NRC Front')
            ->disk('public')
            ->size(50)
            ->stacked()
            ->toggleable(isToggledHiddenByDefault: true);
    }

    public static function customerNrcBackColumn()
    {
        return ImageColumn::make('nrc_back')
            ->label('NRC Back')
            ->disk('public')
            ->size(50)
            ->stacked()
            ->toggleable(isToggledHiddenByDefault: true);
    }

    public static function customerPlanColumn()
    {
        return TextColumn::make('plan.name')
            ->badge()
            ->color('warning');
    }

    public static function customerLatLongColumn()
    {
        return TextColumn::make('lat_long')
            ->label('Lat/Long')
            ->toggleable(isToggledHiddenByDefault: true);
    }

    public static function customerFatColumn()
    {
        return TextColumn::make('fat.name')
            ->label('Fat box')
            ->badge();
    }

    public static function customerPortColumn()
    {
        return TextColumn::make('port.name')
            ->label('Port')
            ->badge()
            ->color('info');
    }

    public static function customerSnColumn()
    {
        return TextInputColumn::make('sn')
            ->toggleable(isToggledHiddenByDefault: true);
    }

    public static function customerStartCableColumn()
    {
        return TextColumn::make('start_cable')
            ->label('Cable Start')
            ->toggleable(isToggledHiddenByDefault: true);
    }

    public static function customerEndCableColumn()
    {
        return TextColumn::make('end_cable')
            ->label('Cable End')
            ->toggleable(isToggledHiddenByDefault: true);
    }

    public static function customerTotalCableColumn()
    {
        return TextColumn::make('total_cable')
            ->label('Total Cable')
            ->toggleable(isToggledHiddenByDefault: true);
    }

    public static function customerFatOpticalColumn()
    {
        return TextColumn::make('fat_optical')
            ->label('FAT optical')
            ->suffix(' dbm')
            ->toggleable(isToggledHiddenByDefault: true);
    }

    public static function customerCusResOpticalColumn()
    {
        return TextColumn::make('cus_res_optical')
            ->label('Customer Recive Optical')
            ->suffix(' dbm')
            ->toggleable(isToggledHiddenByDefault: true);
    }

    public static function customerOnuOpticalColumn()
    {
        return TextColumn::make('onu_optical')
            ->label('ONU Optical')
            ->suffix(' dbm')
            ->toggleable(isToggledHiddenByDefault: true);
    }

    public static function customerTicketColumn()
    {
        return TextColumn::make('tickets.id')
            ->badge()
            ->prefix('TKT');
    }

}
