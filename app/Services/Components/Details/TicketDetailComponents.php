<?php

namespace App\Services\Components\Details;

use Filament\Infolists\Components\TextEntry;

class TicketDetailComponents
{
    public static function ticketIdDetail()
    {
        return TextEntry::make('id')
            ->label('Ticket ID')
            ->prefix('TKT');
    }

    public static function ticketTitleDetail()
    {
        return TextEntry::make('title');
    }

    public static function ticketReasonDetail()
    {
        return TextEntry::make('reason');
    }

    public static function ticketTypeDetail()
    {
        return TextEntry::make('type.name')
            ->badge();
    }

    public static function ticketCreateAtDetail()
    {
        return TextEntry::make('created_at')
            ->label('Issues date')
            ->date();
    }

    public static function ticketAsginToDetail()
    {
        return TextEntry::make('department.name')
            ->label('Asgin To')
            ->badge();
    }

    public static function ticketPriorityDetail()
    {
        return TextEntry::make('priority')
            ->formatStateUsing(fn(string $state): string => match ($state) {
                '0' => 'low',
                '1' => 'middle',
                '2' => 'High',
                '3' => 'Urgent',
            })
            ->badge()
            ->color(fn (string $state): string => match ($state) {
                '0' => 'success',
                '1' => 'primary',
                '2' => 'warning',
                '3' => 'danger',
                default => 'unknown',
            });
    }

    public static function ticketCreatedByDetail()
    {
        return TextEntry::make('user.name')
            ->label('Created By');
    }

    public static function ticketLastUpdateDetail()
    {
        return TextEntry::make('lastUser.name')
            ->label('Last Updated By');
    }

    public static function ticketCustomerIdDetail()
    {
        return TextEntry::make('customer.customer_id')
            ->label('Customer ID');
    }

    public static function ticketCustomerRegisterDatedetail()
    {
        return TextEntry::make('customer.register_date')
            ->label('Register Date');
    }

    public static function ticketCustomerNamedetail()
    {
        return TextEntry::make('customer.name')
            ->label('Customer Name');
    }

    public static function ticketCustomerPhoneDetail()
    {
        return TextEntry::make('customer.phone')
            ->label('Customer Phone Number')
            ->copyable()
            ->copyMessage('phone number Copied');
    }

    public static function ticketCustomerEmailDetail()
    {
        return TextEntry::make('customer.email')
            ->label('Customer Email')
            ->copyable()
            ->copyMessage('Email Copied');
    }

    public static function ticketCustomerAddressDetail()
    {
        return TextEntry::make('customer.address')
            ->label('Address');
    }

    public static function ticketCustomerPlanDetail()
    {
        return TextEntry::make('customer.plan.name')
            ->label('Plan')
            ->badge();
    }

    public static function ticketCustomerLatLongDetail()
    {
        return TextEntry::make('customer.lat_long')
            ->label('Lat/Long')
            ->copyable()
            ->copyMessage('Lat Long Copied');
    }

    public static function ticketCustomerTownshipDetail()
    {
        return TextEntry::make('customer.township.name')
            ->label('Township');
    }

    public static function ticketCustomerStartCableDetail()
    {
        return TextEntry::make('customer.start_cable')
            ->label('Start Cable')
            ->suffix(' Meter');
    }
}
