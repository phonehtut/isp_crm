<?php

namespace App\Filament\Resources;

use App\Services\Components\Forms\FatBoxFormComponents;
use App\Services\Components\Tables\FatBoxTableComponents;
use Filament\Tables;
use App\Models\FatBox;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\FatBoxResource\Pages;

class FatBoxResource extends Resource
{
    protected static ?string $model = FatBox::class;

    protected static ?string $navigationIcon = 'fas-network-wired';

    protected static ?string $navigationGroup = 'FAT & Port';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FatBoxFormComponents::fatNameInput(),
                FatBoxFormComponents::fatPortSelect()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                FatBoxTableComponents::fatNameColumn(),
                FatBoxTableComponents::fatPortColumn()
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
            // 'create' => Pages\CreateFatBox::route('/create'),
            // 'edit' => Pages\EditFatBox::route('/{record}/edit'),
        ];
    }
}
