<?php

namespace App\Filament\Resources;

use App\Models\Plan;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\PlanResource\Pages;
use App\Services\Components\Forms\PlanFormComponents;
use App\Services\Components\Tables\PlanTableComponents;

class PlanResource extends Resource
{
    protected static ?string $model = Plan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                PlanFormComponents::planNameInput(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                PlanTableComponents::planNameColumn(),
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
            'index' => Pages\ListPlans::route('/'),
            // 'create' => Pages\CreatePlan::route('/create'),
            // 'edit' => Pages\EditPlan::route('/{record}/edit'),
        ];
    }
}
