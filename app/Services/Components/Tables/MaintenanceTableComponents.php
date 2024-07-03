<?php

namespace App\Services\Components\Tables;

use Filament\Support\Enums\FontFamily;
use Filament\Tables\Columns\TextColumn;


class MaintenanceTableComponents
{

    public static function maintainIssuesDateColumn()
    {
        return TextColumn::make('issues_at')
            ->dateTime();
    }

    public static function maintainTicketColumn()
    {
        return TextColumn::make('ticket.id')
            ->prefix('TKT');
    }

    public static function maintainCustomerColumn()
    {
        return TextColumn::make('customer.customer_id')
            ->label('Customer ID')
            ->copyable()
            ->copyMessage('Customer ID Copied')
            ->fontFamily(FontFamily::Mono)
            ->color('info');
    }

    public static function maintainDepartmentColumn()
    {
        return TextColumn::make('department.name');
    }

    public static function maintainCallCenterColumn()
    {
        return TextColumn::make('cc_remark')
            ->label('Call Center Remark')
            ->limit(30);
    }

    public static function maintainNocColumn()
    {
        return TextColumn::make('noc_remark')
            ->label('NOC Remark')
            ->limit(30);
    }

    public static function maintainCreateNocColumn()
    {
        return TextColumn::make('noc.name')
            ->label('NOC Engineer');
    }

    public static function maintainFinishNocColumn()
    {
        return TextColumn::make('finishNoc.name')
            ->label('Fixed NOC engineer');
    }

    public static function maintainStatusColumn()
    {
        return TextColumn::make('status')
            ->formatStateUsing(fn(string $state): string => match ($state) {
                '0' => 'Pending',
                '1' => 'Finish',
                '2' => 'Need To Check',
                default => 'Unknow',
            })
            ->badge()
            ->color(fn (string $state): string => match ($state) {
                '0' => 'danger',
                '1' => 'success',
                '2' => 'warning',
                default => 'primary',
            });
    }

    public static function maintainSiteEngineerColumn()
    {
        return TextColumn::make('site_engineer')
            ->badge()
            ->formatStateUsing(fn(string $state): string => match ($state) {
                '0' => 'Sub Com Team',
                '1' => 'In House Team'
            })
            ->color(fn(string $state): string => match ($state) {
                '0' => 'info',
                '1' => 'success'
            });
    }

    public static function maintainFinishDateColumn()
    {
        return TextColumn::make('finish_at')
            ->dateTime();
    }

    public static function maintainIssuesDetailColumn()
    {
        return TextColumn::make('issues')
            ->limit(30)
            ->toggleable(isToggledHiddenByDefault: true);
    }

    public static function maintainFaultPointColumn()
    {
        return TextColumn::make('faultPoint.name')
            ->toggleable(isToggledHiddenByDefault: true);
    }

    public static function maintainOnuColumn()
    {
        return TextColumn::make('onu')
            ->toggleable(isToggledHiddenByDefault: true);
    }

    public static function maintainAdapterColumn()
    {
        return TextColumn::make('adapter')
            ->toggleable(isToggledHiddenByDefault: true);
    }

    public static function maintainDropCableColumn()
    {
        return TextColumn::make('drop_cable')
            ->toggleable(isToggledHiddenByDefault: true);
    }

    public static function maintainPatchCordApcColumn()
    {
        return TextColumn::make('patch_cord_apc')
            ->toggleable(isToggledHiddenByDefault: true);
    }

    public static function maintainPatchCordUpcColumn()
    {
        return TextColumn::make('patch_cord_upc')
            ->toggleable(isToggledHiddenByDefault: true);
    }

    public static function maintainPigtailApcColumn()
    {
        return TextColumn::make('pigtail_apc')
            ->toggleable(isToggledHiddenByDefault: true);
    }

    public static function maintainPigtailUpcColumn()
    {
        return TextColumn::make('pigtail_upc')
            ->toggleable(isToggledHiddenByDefault: true);
    }

    public static function maintainSleeveColumn()
    {
        return TextColumn::make('sleeve')
            ->toggleable(isToggledHiddenByDefault: true);
    }

    public static function maintainSleeveClosureColumn()
    {
        return TextColumn::make('sleeve_closure')
            ->toggleable(isToggledHiddenByDefault: true);
    }

}
