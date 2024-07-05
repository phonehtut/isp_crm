<?php

namespace App\Services\Components\Forms;

use Filament\Forms\Components\TextInput;
class FaultPointFormComponents
{
    public static function faultpointNameInput()
    {
        return TextInput::make('name')
            ->required();
    }

    public static function faultpointRemarkInput()
    {
        return TextInput::make('remark')
            ->required();
    }
}
