<?php

namespace App\Services\Components\Forms;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;


class DepartmentFormComponents
{

    public static function departmentNameInput()
    {
        return TextInput::make('name')
            ->label('Department Name')
            ->placeholder('Please enter daperment name')
            ->required();
    }

    public static function departmentUserSelect()
    {
        return Select::make('user_id')
            ->relationship('users', 'name')
            ->multiple()
            ->searchable()
            ->preload()
            ->placeholder('Please Select User');
    }

}
