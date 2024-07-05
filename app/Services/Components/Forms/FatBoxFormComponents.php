<?php

namespace App\Services\Components\Forms;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class FatBoxFormComponents
{
    public static function fatNameInput()
    {
        return TextInput::make('name');
    }

    public static function fatPortSelect()
    {
        return Select::make('port_id')
            ->relationship('ports', 'name')
            ->multiple()
            ->searchable()
            ->preload();
    }
}
