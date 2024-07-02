<?php

namespace App\Services\Components\Forms;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;


class MaintenanceFormComponents
{
    public static function maintainIssuesDate()
    {
        return DateTimePicker::make('issues_at')
            ->native(false)
            ->seconds(false)
            ->placeholder('Select Issues Date')
            ->required()
            ->reactive()
            ->timezone('Asia/Yangon');
    }

    public static function maintainFinishDate()
    {
        return DateTimePicker::make('finish_at')
            ->native(false)
            ->seconds(false)
            ->reactive()
            ->timezone('Asia/Yangon');
    }

    public static function maintainTicketSelect()
    {
        return Select::make('ticket_id')
            ->relationship('ticket', 'id')
            ->searchable()
            ->preload()
            ->prefix('TKT');
    }

    public static function maintainCustomerSelect()
    {
        return Select::make('customer_id')
            ->relationship('customer', 'customer_id')
            ->searchable()
            ->preload();
    }

    public static function maintainAsginSelect()
    {
        return Select::make('department_id')
            ->relationship('department', 'name')
            ->searchable()
            ->preload();
    }

    public static function maintainStatusSelect()
    {
        return Select::make('status')
            ->options([
                '0' => 'pending',
                '1' => 'finish',
                '2' => 'Need To Check',
            ])
            ->searchable()
            ->preload();
    }

    public static function maintainCallCenterRemark()
    {
        return Textarea::make('cc_remark')
            ->label('Call Center Remark')
            ->placeholder('Please enter call center remark');
    }

    public static function maintainNocRemark()
    {
        return Textarea::make('noc_remark')
            ->label('Noc Remark')
            ->placeholder('Please enter NOC remark');
    }

    public static function maintainSiteEngineerSelect()
    {
        return Select::make('site_engineer')
            ->options([
                '0' => 'Sub Com Team',
                '1' => 'Home Team',
            ])
            ->searchable()
            ->preload();
    }

    public static function maintainFaultPointSelect()
    {
        return Select::make('fault_point_id')
            ->relationship('faultPoint', 'name')
            ->searchable()
            ->preload();
    }

    public static function maintainDuration()
    {
        return TextInput::make('duration')
            ->readOnly();
    }

    public static function maintainIssuesDetailInput()
    {
        return Textarea::make('issues')
            ->label('Issues Detail')
            ->placeholder('Please Enter Issues Detail')
            ->columnSpan('full');
    }

    public static function maintainOnuInput()
    {
        return TextInput::make('onu')
            ->label('ONU SN')
            ->placeholder('Please Enter ONU SN');
    }

    public static function maintainAdapterInput()
    {
        return TextInput::make('adapter');
    }

    public static function maintainDropCableInput()
    {
        return TextInput::make('drop_cable')
            ->label('Drop Cable')
            ->placeholder('Please Enter Drop Cable');
    }

    public static function maintainPatchCordApcInput()
    {
        return TextInput::make('patch_cord_apc')
            ->label('Patch Cord (APC)');
    }

    public static function maintainPatchCordUpcInput()
    {
        return TextInput::make('patch_cord_upc')
            ->label('Patch Cord (UPC)');
    }

    public static function maintainPigtailApcInput()
    {
        return TextInput::make('pigtail_apc')
            ->label('Pigtail (APC)');
    }

    public static function maintainPigtailUpcInput()
    {
        return TextInput::make('pigtail_upc')
            ->label('Pigtail (UPC)');
    }

    public static function maintainSleeveInput()
    {
        return TextInput::make('sleeve')
            ->label('Sleeve');
    }

    public static function maintainSleeveClosureInput()
    {
        return TextInput::make('sleeve_closure')
            ->label('Sleeve Closure');
    }


}
