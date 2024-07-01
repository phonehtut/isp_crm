<?php

namespace App\Filament\Resources;


use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Services\Components\Forms\UserFormComponents;
use App\Services\Components\Tables\UserTableComponents;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationGroup = 'User Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Profile')
                    ->schema([
                        UserFormComponents::userAvatarImage(),
                    ])
                    ->collapsed(),
                Section::make('Information')
                    ->schema([
                        UserFormComponents::userNameInput(),
                        UserFormComponents::userEmailInput(),
                        UserFormComponents::userPhoneInput(),
                    ])
                    ->collapsible()
                    ->columns(3),
                Section::make('Password')
                    ->schema([
                        UserFormComponents::userPasswordInput(),
                        UserFormComponents::userPasswordConfirmsInput(),
                    ])
                    ->columns(2),
                Section::make('Permission And Department')
                    ->schema([
                        UserFormComponents::userIsAdmin(),
                        UserFormComponents::userDepartmentSelect(),
                        UserFormComponents::userRoleSelect()
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->columns([
                UserTableComponents::userImageColumn(),
                UserTableComponents::userNameColumn(),
                UserTableComponents::userEmailColumn(),
                UserTableComponents::userPhoneColumn(),
                UserTableComponents::userIsAdminColumn(),
                UserTableComponents::userRoleColumn(),
                UserTableComponents::userDepartmentColumn(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
