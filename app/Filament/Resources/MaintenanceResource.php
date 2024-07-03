<?php

namespace App\Filament\Resources;

use App\Services\Components\Forms\MaintenanceFormComponents;
use App\Services\Components\Tables\MaintenanceTableComponents;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Maintenance;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Section;
use Filament\Forms\Concerns\InteractsWithForms;
use App\Filament\Resources\MaintenanceResource\Pages;

class MaintenanceResource extends Resource
{
    use InteractsWithForms;

    protected static ?string $model = Maintenance::class;

    protected static ?string $navigationGroup = 'Maintenances';

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Maintenance Infomation')
                    ->schema([
                        MaintenanceFormComponents::maintainIssuesDate(),
                        MaintenanceFormComponents::maintainFinishDate(),
                        MaintenanceFormComponents::maintainTicketSelect(),
                        MaintenanceFormComponents::maintainCustomerSelect(),
                        MaintenanceFormComponents::maintainAsginSelect(),
                        MaintenanceFormComponents::maintainStatusSelect(),
                    ])
                    ->columns(2)
                    ->collapsible(),
                Section::make('Remark')
                    ->schema([
                        MaintenanceFormComponents::maintainCallCenterRemark(),
                        MaintenanceFormComponents::maintainNocRemark(),
                    ])
                    ->columns(2)
                    ->collapsible(),
                Section::make('Site Information')
                    ->schema([
                        MaintenanceFormComponents::maintainSiteEngineerSelect(),
                        MaintenanceFormComponents::maintainFaultPointSelect(),
                        MaintenanceFormComponents::maintainDuration(),
                        MaintenanceFormComponents::maintainIssuesDetailInput(),
                        MaintenanceFormComponents::maintainOnuInput(),
                        MaintenanceFormComponents::maintainAdapterInput(),
                        MaintenanceFormComponents::maintainDropCableInput(),
                        MaintenanceFormComponents::maintainPatchCordApcInput(),
                        MaintenanceFormComponents::maintainPatchCordUpcInput(),
                        MaintenanceFormComponents::maintainPigtailApcInput(),
                        MaintenanceFormComponents::maintainPigtailUpcInput(),
                        MaintenanceFormComponents::maintainSleeveInput(),
                        MaintenanceFormComponents::maintainSleeveClosureInput()
                    ])
                    ->columns(3)
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                MaintenanceTableComponents::maintainIssuesDateColumn(),
                MaintenanceTableComponents::maintainTicketColumn(),
                MaintenanceTableComponents::maintainCustomerColumn(),
                MaintenanceTableComponents::maintainDepartmentColumn(),
                MaintenanceTableComponents::maintainCallCenterColumn(),
                MaintenanceTableComponents::maintainNocColumn(),
                MaintenanceTableComponents::maintainCreateNocColumn(),
                MaintenanceTableComponents::maintainFinishNocColumn(),
                MaintenanceTableComponents::maintainStatusColumn(),
                MaintenanceTableComponents::maintainSiteEngineerColumn(),
                MaintenanceTableComponents::maintainFinishDateColumn(),
                MaintenanceTableComponents::maintainIssuesDetailColumn(),
                MaintenanceTableComponents::maintainFaultPointColumn(),
                MaintenanceTableComponents::maintainOnuColumn(),
                MaintenanceTableComponents::maintainAdapterColumn(),
                MaintenanceTableComponents::maintainDropCableColumn(),
                MaintenanceTableComponents::maintainPatchCordApcColumn(),
                MaintenanceTableComponents::maintainPatchCordUpcColumn(),
                MaintenanceTableComponents::maintainPigtailApcColumn(),
                MaintenanceTableComponents::maintainPigtailUpcColumn(),
                MaintenanceTableComponents::maintainSleeveColumn(),
                MaintenanceTableComponents::maintainSleeveClosureColumn(),
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
            'index' => Pages\ListMaintenances::route('/'),
            'create' => Pages\CreateMaintenance::route('/create'),
            'edit' => Pages\EditMaintenance::route('/{record}/edit'),
        ];
    }

    public function getMaxContentWidth(): MaxWidth
    {
        return MaxWidth::Full;
    }
}
