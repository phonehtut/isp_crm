<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Department;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\DepartmentResource\Pages;
use App\Services\Components\Forms\DepartmentFormComponents;
use App\Services\Components\Tables\DepartmentTableComponents;

class DepartmentResource extends Resource
{
    protected static ?string $model = Department::class;

    protected static ?string $navigationIcon = 'fas-users';

    protected static ?string $navigationGroup = 'User Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DepartmentFormComponents::departmentNameInput(),
                DepartmentFormComponents::departmentUserSelect()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                DepartmentTableComponents::userAvatarColumn(),
                DepartmentTableComponents::departmentNamColumn(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListDepartments::route('/'),
            // 'create' => Pages\CreateDepartment::route('/create'),
            // 'edit' => Pages\EditDepartment::route('/{record}/edit'),
        ];
    }
}

