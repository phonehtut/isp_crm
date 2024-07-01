<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Port;
use Filament\Tables;
use App\Models\Customer;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextInputColumn;
use App\Filament\Resources\CustomerResource\Pages;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;


class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Customer Information')
                    ->schema([
                        TextInput::make('customer_id')
                            ->placeholder('Please Enter ID'),
                        TextInput::make('name')
                            ->label('Customer Name')
                            ->required()
                            ->placeholder('Please Enter Customer Name'),
                        TextInput::make('email')
                            ->label('Email')
                            ->placeholder('Please Enter Customer Email'),
                        TextInput::make('phone')
                            ->label('Phone Number')
                            ->placeholder('Please Enter Customer Phone Number')
                            ->tel(),
                        Section::make('NRC (Optical)')
                            ->schema([
                                FileUpload::make('nrc_front')
                                    ->hiddenLabel()
                                    ->placeholder('Please Select NRC Front Photo')
                                    ->directory(function (callable $get) {
                                        $customerID = $get('customer_id');
                                        return "customers/{$customerID}/nrc/front";
                                    })
                                    ->disk('public'),
                                FileUpload::make('nrc_back')
                                    ->hiddenLabel()
                                    ->placeholder('Please Select NRC Back Photo')
                                    ->directory(function (callable $get) {
                                        $customerID = $get('customer_id');
                                        return "customers/{$customerID}/nrc/back";
                                    })
                                    ->disk('public'),
                            ])
                            ->collapsed()
                            ->columns(2),
                        Select::make('township_id')
                            ->relationship('township','name')
                            ->searchable()
                            ->preload(),
                        TextInput::make('lat_long')
                            ->label('Lat/Long')
                            ->placeholder('Please Enter Customer Lat/Long'),
                        RichEditor::make('address')
                            ->label('Address')
                            ->placeholder('Please Enterb Customer Address')
                            ->required()
                            ->columnSpan('full'),
                    ])
                    ->collapsible()
                    ->columns(2),
                Section::make('Billing Information')
                    ->schema([
                        DatePicker::make('register_date')
                            ->native(false),
                        Select::make('plan_id')
                            ->relationship('plan','name')
                            ->searchable()
                            ->preload()
                    ])
                    ->collapsible()
                    ->columns(2),
                Section::make('Site Information')
                    ->schema([
                        Select::make('fat_id')
                            ->relationship('fat', 'name')
                            ->reactive()
                            ->searchable()
                            ->preload()
                            ->afterStateUpdated(fn ($state, callable $set) => $set('port_id', null))
                            ->columnSpan(2),
                        Select::make('port_id')
                            ->relationship('port', 'name')
                            ->options(function (callable $get) {
                                $fatId = $get('fat_id');

                                if (!$fatId) {
                                    return [];
                                }

                                return Port::whereHas('fat_boxes', function ($query) use ($fatId) {
                                    $query->where('fat_id', $fatId);
                                })->pluck('name', 'id');
                            })
                            ->required()
                            ->searchable()
                            ->preload()
                            ->columnSpan(1),
                        TextInput::make('start_cable')
                            ->label('Cable Start')
                            ->suffix('meter')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, $get) {
                                $endCable = $get('end_cable');
                                if (is_numeric($state) && is_numeric($endCable)) {
                                    $set('total_cable', $state - $endCable);
                                } else {
                                    $set('total_cable', 'start cable or end cable is not integer');
                                }
                            }),
                        TextInput::make('end_cable')
                            ->label('Cable End')
                            ->suffix('meter')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, $get) {
                                $startCable = $get('start_cable');
                                if (is_numeric($state) && is_numeric($startCable)) {
                                    $set('total_cable', $startCable - $state);
                                } else {
                                    $set('total_cable', 'start cable or end cable is not integer');
                                }
                            }),
                        TextInput::make('total_cable')
                            ->label('Total Cable')
                            ->suffix('meter')
                            ->readOnly()
                            ->label('Total Cable')
                            ->suffix('meter'),
                        TextInput::make('fat_optical')
                            ->label('FAT Optical')
                            ->suffix('dbm'),
                        TextInput::make('cus_res_optical')
                            ->label('Customer Recive Optical')
                            ->suffix('dbm'),
                        TextInput::make('onu_optical')
                            ->label('Onu Optical')
                            ->suffix('dbm'),
                        TextInput::make('sn')
                            ->required()
                            ->columnSpan('full'),
                    ])
                    ->collapsible()
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('register_date')
                    ->label('Register Date')
                    ->sortable(),
                TextColumn::make('customer_id')
                    ->badge()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->label('Phone Number')
                    ->searchable(),
                TextColumn::make('address')
                    ->limit(30)
                    ->html()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('township.name')
                    ->sortable()
                    ->searchable(),
                ImageColumn::make('nrc_front')
                    ->label('NRC Front')
                    ->disk('public')
                    ->size(50)
                    ->stacked()
                    ->toggleable(isToggledHiddenByDefault: true),
                ImageColumn::make('nrc_back')
                    ->label('NRC Back')
                    ->disk('public')
                    ->size(50)
                    ->stacked()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('plan.name')
                    ->badge()
                    ->color('warning'),
                TextColumn::make('lat_long')
                    ->label('Lat/Long')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('fat.name')
                    ->label('Fat box')
                    ->badge(),
                TextColumn::make('port.name')
                    ->label('Port')
                    ->badge()
                    ->color('info'),
                TextInputColumn::make('sn')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('start_cable')
                    ->label('Cable Start')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('end_cable')
                    ->label('Cable End')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('total_cable')
                    ->label('Total Cable')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('fat_optical')
                    ->label('FAT optical')
                    ->suffix(' dbm')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('cus_res_optical')
                    ->label('Customer Recive Optical')
                    ->suffix(' dbm')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('onu_optical')
                    ->label('ONU Optical')
                    ->suffix(' dbm')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('tickets.id')
                    ->badge()
                    ->prefix('TKT')
            ])
            ->filters([
                SelectFilter::make('plan')
                    ->relationship('plan' , 'name')
                    ->searchable()
                    ->preload()
                    ->multiple(),
                SelectFilter::make('fat')
                    ->label('Fat Box')
                    ->relationship('fat', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload(),

                SelectFilter::make('port')
                    ->label('Port')
                    ->relationship('port', 'name')
                    ->options(function (callable $get) {
                        $fatIds = $get('fat');

                        if (!$fatIds) {
                            return [];
                        }

                        return Port::whereIn('id', function ($query) use ($fatIds) {
                            $query->select('port_id')
                                ->from('fats_ports')
                                ->whereIn('fat_id', $fatIds);
                        })->pluck('name', 'id')->toArray();
                    })
                    ->multiple()
                    ->searchable()
                    ->preload(),
                // Filter::make('register_date')
                //     ->form([
                //         DatePicker::make('start_date')
                //             ->label('Register From')
                //             ->placeholder('Select start date'),
                //         DatePicker::make('Register To')
                //             ->label('End Date')
                //             ->placeholder('Select end date'),
                //     ])
                //     ->query(function ($query, $data) {
                //         if (!empty($data['start_date']) && !empty($data['end_date'])) {
                //             return $query->whereBetween('register_date', [$data['start_date'], $data['end_date']]);
                //         } elseif (!empty($data['start_date'])) {
                //             return $query->where('register_date', '>=', $data['start_date']);
                //         } elseif (!empty($data['end_date'])) {
                //             return $query->where('register_date', '<=', $data['end_date']);
                //         }

                //         return $query;
                //     }),
                    DateRangeFilter::make('register_date'),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
