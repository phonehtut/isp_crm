<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FaultPointResource\Pages;
use App\Filament\Resources\FaultPointResource\RelationManagers;
use App\Models\FaultPoint;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Forms\Components\TextInput;

class FaultPointResource extends Resource
{
    protected static ?string $model = FaultPoint::class;

    protected static ?string $navigationGroup = 'Maintenances';

    protected static ?string $navigationIcon = 'heroicon-o-wrench';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextInputColumn::make('name')
                    ->searchable()
                    ->sortable()
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListFaultPoints::route('/'),
            // 'create' => Pages\CreateFaultPoint::route('/create'),
            // 'edit' => Pages\EditFaultPoint::route('/{record}/edit'),
        ];
    }
}
