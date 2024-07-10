<?php

namespace App\Services\Components\Tables;

use Filament\Tables\Columns\TextColumn;

class PortTableComponents
{
    public static function portNameColumn()
    {
        return TextColumn::make('name');
    }

    public static function portFatColumn()
    {
        return TextColumn::make('fat_boxes.name')
            ->badge();
    }
}
