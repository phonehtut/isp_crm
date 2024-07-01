<?php

namespace App\Services\Components\Tables;


use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
class UserTableComponents
{
    public static function userImageColumn()
    {
        return ImageColumn::make('avatar_url')
            ->disk('public')
            ->circular();
    }

    public static function userNameColumn()
    {
        return TextColumn::make('name')
            ->searchable()
            ->sortable();
    }

    public static function userEmailColumn()
    {
        return TextColumn::make('email')
            ->searchable()
            ->sortable();
    }

    public static function userPhoneColumn()
    {
        return TextColumn::make('phone')
            ->label('Phone Number')
            ->searchable()
            ->sortable();
    }

    public static function userIsAdminColumn()
    {
        return TextColumn::make('is_admin')
            ->Label('User Type')
            ->formatStateUsing(fn($state) => $state === 1 ? 'Admin':'User')
            ->color(fn($state) => $state === 1 ? 'primary':'success')
            ->badge();
    }

    public static function userRoleColumn()
    {
        return TextColumn::make('roles.name')
            ->badge();
    }

    public static function userDepartmentColumn()
    {
        return TextColumn::make('departments.name')
            ->badge();
    }
}
