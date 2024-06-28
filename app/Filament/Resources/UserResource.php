<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationGroup = 'User Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->deferLoading()
            ->schema([
                Section::make('Profile')
                    ->schema([
                        FileUpload::make('avatar_url')
                            ->hiddenLabel()
                            ->directory('agentPhotos')
                            ->disk('public')
                            ->avatar()
                            ->image()
                            ->alignCenter(),
                    ])
                    ->collapsed(),
                Section::make('Information')
                    ->schema([
                        TextInput::make('name')
                            ->label('Agent Name')
                            ->placeholder('Please Enter Agent Name')
                            ->required(),
                        TextInput::make('email')
                            ->label('Email')
                            ->placeholder('Please Enter Agent Email')
                            ->required(),
                        TextInput::make('phone')
                            ->label('Phone Number')
                            ->placeholder('Please Enter Agent Phone Number')
                            ->required(),
                    ])
                    ->collapsible()
                    ->columns(3),
                Section::make('Password')
                    ->schema([
                        TextInput::make('password')
                            ->placeholder('Please enter password')
                            ->dehydrateStateUsing(fn($state) => Hash::make($state))
                            ->dehydrated(fn($state) => !empty($state))
                            ->password()
                            ->revealable()
                            ->confirmed()
                            ->required(fn($livewire) => $livewire instanceof CreateUser),
                        TextInput::make('password_confirmation')
                            ->label('Confirm Password')
                            ->placeholder('Please enter password again')
                            ->password()
                            ->dehydrated(false)
                            ->revealable()
                            ->required(fn($livewire) => $livewire instanceof CreateUser),
                    ])
                    ->columns(2),
                Section::make('Permission And Department')
                    ->schema([
                        Toggle::make('is_admin')
                            ->label('Make Admin'),
                        Select::make('department_id')
                            ->relationship('departments', 'name')
                            ->placeholder('Please Select Departments')
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('roles')
                            ->relationship('roles', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar_url')
                    ->disk('public')
                    ->circular(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->label('Phone Number')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('is_admin')
                    ->formatStateUsing(fn($state) => $state === 1 ? 'Admin':'User')
                    ->color(fn($state) => $state === 1 ? 'primary':'success')
                    ->badge(),
                TextColumn::make('roles.name')
                    ->badge(),
                TextColumn::make('departments.name')
                    ->badge(),

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
