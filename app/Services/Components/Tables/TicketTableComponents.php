<?php

namespace App\Services\Components\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;

class TicketTableComponents
{
    public static function ticketIdColumn()
    {
        return TextColumn::make('id')
            ->prefix('TKT')
            ->searchable()
            ->sortable();
    }

    public static function ticketCreateAtColumn()
    {
        return TextColumn::make('created_at')
            ->label('issues Date')
            ->date();
    }

    public static function ticketCustomerRegisterDateColumn()
    {
        return TextColumn::make('customer.register_date')
            ->label('Register Date')
            ->date()
            ->toggleable(isToggledHiddenByDefault: true);
    }

    public static function ticketTitleColumn()
    {
        return TextColumn::make('title')
            ->searchable()
            ->sortable();
    }

    public static function ticketCustomerIdColumn()
    {
        return TextColumn::make('customer.customer_id')
            ->label('Customer ID')
            ->searchable()
            ->sortable();
    }

    public static function ticketCustomerPhoneColumn()
    {
        return TextColumn::make('customer.phone')
            ->label('Phone Number')
            ->searchable()
            ->sortable();
    }

    public static function ticketCustomerAddressColumn()
    {
        return TextColumn::make('customer.address')
            ->label('Address')
            ->html()
            ->limit(50);
    }

    public static function ticketCustomerLatLongColumn()
    {
        return TextColumn::make('customer.lat_long')
            ->label('Lat/Long')
            ->toggleable(isToggledHiddenByDefault: true);
    }

    public static function ticketCustomerFatColumn()
    {
        return TextColumn::make('customer.fat.name')
            ->searchable()
            ->sortable();
    }

    public static function ticketCustomerPortColumn()
    {
        return TextColumn::make('customer.port.name')
            ->searchable()
            ->sortable();
    }

    public static function ticketCustomerStartCableColumn()
    {
        return TextInputColumn::make('customer.start_cable')
            ->label('Start Cable')
            ->toggleable(isToggledHiddenByDefault: true);
    }

    public static function ticketCustomerEndCableColumn()
    {
        return TextInputColumn::make('customer.end_cable')
            ->label('End Cable')
            ->toggleable(isToggledHiddenByDefault: true);
    }

    public static function ticketCustomerTotalCableColumn()
    {
        return TextInputColumn::make('customer.total_cable')
            ->label('Total Cable')
            ->toggleable(isToggledHiddenByDefault: true);
    }

    public static function ticketCustomerFatOpticalColumn()
    {
        return TextInputColumn::make('customer.fat_optical')
            ->label('Fat OPtical')
            ->toggleable(isToggledHiddenByDefault: true);
    }

    public static function ticketCustomerResOpticalcolumn()
    {
        return TextInputColumn::make('customer.cus_res_optical')
            ->label('Customer Recive Optical')
            ->toggleable(isToggledHiddenByDefault: true);
    }

    public static function ticketCustomerOnuOpticalColumn()
    {
        return TextInputColumn::make('customer.onu_optical')
            ->label('ONU Optical')
            ->toggleable(isToggledHiddenByDefault: true);
    }
}
