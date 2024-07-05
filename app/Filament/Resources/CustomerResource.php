<?php

namespace App\Filament\Resources;

use Filament\Tables;
use App\Models\Customer;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Tables\Enums\FiltersLayout;
use App\Filament\Resources\CustomerResource\Pages;
use App\Services\Components\Forms\CustomerFormComponents;
use App\Services\Components\Tables\CustomerTableComponents;
use App\Services\Components\Filters\CustomerFilterComponents;
use App\Filament\Resources\CustomerResource\Api\Transformers\CustomerTransformer;


class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Customer Information')
                    ->schema([
                        CustomerFormComponents::customerIdInput(),
                        CustomerFormComponents::customerNameInput(),
                        CustomerFormComponents::customerEmailInput(),
                        CustomerFormComponents::customerPhoneInput(),
                        Section::make('NRC (Optical)')
                            ->schema([
                                CustomerFormComponents::customerNrcFrontPhoto(),
                                CustomerFormComponents::customerNrcBackPhoto(),
                            ])
                            ->collapsed()
                            ->columns(2),
                        CustomerFormComponents::customerTownshipSelect(),
                        CustomerFormComponents::customerLatlongInput(),
                        CustomerFormComponents::customerAddressInput(),
                    ])
                    ->collapsible()
                    ->columns(2),
                Section::make('Billing Information')
                    ->schema([
                        CustomerFormComponents::customerRegisterDate(),
                        CustomerFormComponents::customerPlanSelect()
                    ])
                    ->collapsible()
                    ->columns(2),
                Section::make('Site Information')
                    ->schema([
                        CustomerFormComponents::customerFatSelect(),
                        CustomerFormComponents::customerPortSelect(),
                        CustomerFormComponents::customerStartCableInput(),
                        CustomerFormComponents::customerEndCableInput(),
                        CustomerFormComponents::customerTotalCableInput(),
                        CustomerFormComponents::customerFatOpticalInput(),
                        CustomerFormComponents::customerCusResOpticalInput(),
                        CustomerFormComponents::customerOnuOpticalInput(),
                        CustomerFormComponents::customerSnInput(),
                    ])
                    ->collapsible()
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                CustomerTableComponents::customerRegisterDateColumn(),
                CustomerTableComponents::customerIdColumn(),
                CustomerTableComponents::customerNameColumn(),
                CustomerTableComponents::customerEmailColumn(),
                CustomerTableComponents::customerPhoneColumn(),
                CustomerTableComponents::customerAddressColumn(),
                CustomerTableComponents::customerTownshipColumn(),
                CustomerTableComponents::customerNrcFrontColumn(),
                CustomerTableComponents::customerNrcBackColumn(),
                CustomerTableComponents::customerPlanColumn(),
                CustomerTableComponents::customerLatLongColumn(),
                CustomerTableComponents::customerFatColumn(),
                CustomerTableComponents::customerPortColumn(),
                CustomerTableComponents::customerSnColumn(),
                CustomerTableComponents::customerStartCableColumn(),
                CustomerTableComponents::customerEndCableColumn(),
                CustomerTableComponents::customerTotalCableColumn(),
                CustomerTableComponents::customerFatOpticalColumn(),
                CustomerTableComponents::customerCusResOpticalColumn(),
                CustomerTableComponents::customerOnuOpticalColumn(),
                CustomerTableComponents::customerTicketColumn()
            ])
            ->filters([
                CustomerFilterComponents::customerPlanNameSelectFilter(),
                CustomerFilterComponents::customerFatNameSelectFilter(),

                CustomerFilterComponents::customerPortNameSelectFilter(),
                CustomerFilterComponents::customerRegisterDateFilter(),
            ], layout: FiltersLayout::AboveContentCollapsible)->filtersFormColumns(4)
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

    public static function getApiTransformer()
    {
        return CustomerTransformer::class;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
