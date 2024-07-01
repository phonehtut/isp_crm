<?php

namespace App\Services\Components\Forms;

use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use App\Filament\Resources\UserResource\Pages\CreateUser;
class UserFormComponents
{
    public static function userAvatarImage()
    {
        return FileUpload::make('avatar_url')
            ->hiddenLabel()
            ->directory('agentPhotos')
            ->disk('public')
            ->avatar()
            ->image()
            ->alignCenter();
    }

    public static function userNameInput()
    {
        return TextInput::make('name')
            ->label('Agent Name')
            ->placeholder('Please Enter Agent Name')
            ->required();
    }

    public static function userEmailInput()
    {
        return TextInput::make('email')
            ->label('Email')
            ->placeholder('Please Enter Agent Email')
            ->required();
    }

    public static function userPhoneInput()
    {
        return TextInput::make('phone')
            ->label('Phone Number')
            ->placeholder('Please Enter Agent Phone Number')
            ->required();
    }

    public static function userPasswordInput()
    {
        return TextInput::make('password')
            ->placeholder('Please enter password')
            ->dehydrateStateUsing(fn($state) => Hash::make($state))
            ->dehydrated(fn($state) => !empty($state))
            ->password()
            ->revealable()
            ->confirmed()
            ->required(fn($livewire) => $livewire instanceof CreateUser);
    }

    public static function userPasswordConfirmsInput()
    {
        return TextInput::make('password_confirmation')
            ->label('Confirm Password')
            ->placeholder('Please enter password again')
            ->password()
            ->dehydrated(false)
            ->revealable()
            ->required(fn($livewire) => $livewire instanceof CreateUser);
    }

    public static function userIsAdmin()
    {
        return Toggle::make('is_admin')
            ->label('Make Admin');
    }

    public static function userDepartmentSelect()
    {
        return Select::make('department_id')
            ->relationship('departments', 'name')
            ->placeholder('Please Select Departments')
            ->multiple()
            ->searchable()
            ->preload()
            ->required();
    }

    public static function userRoleSelect()
    {
        return Select::make('roles')
            ->relationship('roles', 'name')
            ->multiple()
            ->preload()
            ->searchable();
    }
}
