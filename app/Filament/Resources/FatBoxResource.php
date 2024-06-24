<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\FatBox;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\FatBoxResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\FatBoxResource\RelationManagers;

class FatBoxResource extends Resource
{
    protected static ?string $model = FatBox::class;

    protected static ?string $navigationIcon = 'fas-network-wired';

    protected static ?string $navigationGroup = 'FAT & Port';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),
                Select::make('port_id')
                    ->relationship('ports', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Box Name'),
                TextColumn::make('ports.name')
                    ->badge()
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
            'index' => Pages\ListFatBoxes::route('/'),
            'create' => Pages\CreateFatBox::route('/create'),
            'edit' => Pages\EditFatBox::route('/{record}/edit'),
        ];
    }
}
