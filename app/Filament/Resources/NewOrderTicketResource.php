<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\NewOrderTicket;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\NewOrderTicketResource\Pages;
use App\Filament\Resources\NewOrderTicketResource\RelationManagers;

class NewOrderTicketResource extends Resource
{
    protected static ?string $model = NewOrderTicket::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Title')
                    ->required(),
            ]);

            // 'title',
            // 'new_order_id',
            // 'type_id',
            // 'reason',
            // 'department_id',
            // 'fat_optical',
            // 'onu_optical',
            // 'priority',
            // 'status',
            // 'create_by',
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),
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
            'index' => Pages\ListNewOrderTickets::route('/'),
            'create' => Pages\CreateNewOrderTicket::route('/create'),
            'edit' => Pages\EditNewOrderTicket::route('/{record}/edit'),
        ];
    }
}
