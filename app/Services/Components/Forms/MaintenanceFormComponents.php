<?php

namespace App\Services\Components\Forms;

use Carbon\Carbon;
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
            ->timezone('Asia/Yangon')
            ->afterStateUpdated(fn ($state, callable $set, callable $get) => static::calculateDuration($set, $get('issues_at'), $get('finish_at')));
    }

    public static function maintainFinishDate()
    {
        return DateTimePicker::make('finish_at')
            ->native(false)
            ->seconds(false)
            ->reactive()
            ->timezone('Asia/Yangon')
            ->afterStateUpdated(fn ($state, callable $set, callable $get) => static::calculateDuration($set, $get('issues_at'), $get('finish_at')));
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

    protected static function calculateDuration(callable $set, $finishAt, $issuesAt)
    {
        if (empty($issuesAt) || empty($finishAt)) {
            $set('duration', 'Error: Missing input fields');
            return;
        }

        try {
            // Concatenate date and time strings correctly
            $startDateTimeString = $issuesAt ;
            $endDateTimeString = $finishAt ;

            // Parse concatenated strings into Carbon objects
            $startDateTime = Carbon::parse($startDateTimeString);
            $endDateTime = Carbon::parse($endDateTimeString);

            // Calculate the difference in minutes between the two DateTime objects
            $diffInMinutes = $endDateTime->diffInMinutes($startDateTime);

            // Calculate days, hours, and minutes from the difference in minutes
            $days = intdiv($diffInMinutes, 1440); // 1440 minutes in a day
            $hours = intdiv($diffInMinutes % 1440, 60);
            $minutes = $diffInMinutes % 60;

            // Format the duration string
            $durationString = "{$days} days, {$hours} hours, {$minutes} minutes";

            // Set the duration field in the form
            $set('duration', $durationString);
        } catch (\Exception $e) {
            // Handle any parsing or calculation errors
            $set('duration', 'Error: ' . $e->getMessage());
        }
    }

}
