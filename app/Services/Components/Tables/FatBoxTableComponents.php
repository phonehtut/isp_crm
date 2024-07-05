<?php

namespace App\Services\Components\Tables;

use Filament\Tables\Columns\TextColumn;

class FatBoxTableComponents
{
    public static function fatNameColumn()
    {
        return TextColumn::make('name')
            ->label('Box Name');
    }

    public static function fatPortColumn()
    {
        return TextColumn::make('ports.name')
            ->badge();
    }
}
