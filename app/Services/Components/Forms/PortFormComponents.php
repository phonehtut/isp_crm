<?php

namespace App\Services\Components\Forms;

use Filament\Forms\Components\TextInput;

class PortFormComponents
{
    public static function portNameInput()
    {
        return TextInput::make('name')
            ->required();
    }
}
