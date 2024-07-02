<?php

namespace App\Services\Components\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;


class DepartmentTableComponents
{
    public static function userAvatarColumn()
    {
        return ImageColumn::make('users.avatar_url')
            ->circular()
            ->stacked()
            ->limit(3);
    }

    public static function departmentNamColumn()
    {
        return TextColumn::make('name')
            ->searchable()
            ->sortable()
            ->badge();
    }

}
