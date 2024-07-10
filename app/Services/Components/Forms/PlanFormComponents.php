<?php

namespace App\Services\Components\Forms;

use Filament\Forms\Components\TextInput;

class PlanFormComponents
{
    public static function planNameInput()
    {
        return TextInput::make('name')
            ->label('Plan Name')
            ->required()
            ->columnSpan('full');
    }
}
