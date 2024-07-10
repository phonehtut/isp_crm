<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Port;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\PortResource\Pages;
use App\Services\Components\Forms\PortFormComponents;
use App\Services\Components\Tables\PortTableComponents;

class PortResource extends Resource
{
    protected static ?string $model = Port::class;

    protected static ?string $navigationIcon = 'heroicon-o-stop-circle';

    protected static ?string $navigationGroup = 'FAT & Port';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                PortFormComponents::portNameInput(),
                Select::make('fat_id')
                    ->relationship('fat_boxes', 'name')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                PortTableComponents::portNameColumn(),
                PortTableComponents::portFatColumn()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListPorts::route('/'),
            // 'create' => Pages\CreatePort::route('/create'),
            // 'edit' => Pages\EditPort::route('/{record}/edit'),
        ];
    }
}
