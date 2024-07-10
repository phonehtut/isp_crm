<?php

namespace App\Services\Components\Tables;

use Filament\Tables\Columns\TextInputColumn;

class PlanTableComponents
{
    public static function planNameColumn()
    {
        return TextInputColumn::make('name')
            ->label('Plan Name')
            ->searchable()
            ->sortable();
    }
}
