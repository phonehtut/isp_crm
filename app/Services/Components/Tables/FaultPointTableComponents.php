<?php

namespace App\Services\Components\Tables;

use Filament\Tables\Columns\TextInputColumn;
class FaultPointTableComponents
{
    public static function faultpointNameColumn()
    {
        return TextInputColumn::make('name')
            ->searchable()
            ->sortable();
    }

    public static function faultpointRemarkColumn()
    {
        return TextInputColumn::make('remark')
            ->label('Remark');
    }
}
