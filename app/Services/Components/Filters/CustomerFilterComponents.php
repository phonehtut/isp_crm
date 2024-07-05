<?php

namespace App\Services\Components\Filters;

use App\Models\Port;
use Filament\Tables\Filters\SelectFilter;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class CustomerFilterComponents
{
    public static function customerPlanNameSelectFilter()
    {
        return SelectFilter::make('plan')
            ->relationship('plan' , 'name')
            ->searchable()
            ->preload()
            ->multiple();
    }

    public static function customerFatNameSelectFilter()
    {
        return SelectFilter::make('fat')
            ->label('Fat Box')
            ->relationship('fat', 'name')
            ->multiple()
            ->searchable()
            ->preload();
    }

    public static function customerPortNameSelectFilter()
    {
        return SelectFilter::make('port')
            ->label('Port')
            ->relationship('port', 'name')
            ->options(function (callable $get) {
                $fatIds = $get('fat');

                if (!$fatIds) {
                    return [];
                }

                return Port::whereIn('id', function ($query) use ($fatIds) {
                    $query->select('port_id')
                        ->from('fats_ports')
                        ->whereIn('fat_id', $fatIds);
                })->pluck('name', 'id')->toArray();
            })
            ->multiple()
            ->searchable()
            ->preload();
    }

    public static function customerRegisterDateFilter()
    {
        return DateRangeFilter::make('register_date');
    }
}
