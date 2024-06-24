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
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextInputColumn;
use App\Filament\Resources\CustomerResource\Pages;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('customer_id')
                    ->placeholder('Please Enter ID')
                    ->required(),
                Select::make('name')
                    ->label('Customer Name')
                    ->relationship('newOrder', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('township'),
                DatePicker::make('register_date'),
                Select::make('fat_id')
                    ->relationship('fat', 'name')
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $set) => $set('port_id', null)),

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
                    ->required(),
                TextInput::make('sn')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customer_id')
                    ->badge()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('newOrder.name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('newOrder.email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('newOrder.phone')
                    ->label('Phone Number')
                    ->searchable(),
                TextColumn::make('newOrder.address')
                    ->limit(30)
                    ->html()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('township')
                    ->sortable()
                    ->searchable(),
                ImageColumn::make('newOrder.nrc_front')
                    ->label('NRC Front')
                    ->disk('public')
                    ->size(50)
                    ->stacked()
                    ->toggleable(isToggledHiddenByDefault: true),
                ImageColumn::make('newOrder.nrc_back')
                    ->label('NRC Back')
                    ->disk('public')
                    ->size(50)
                    ->stacked()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('newOrder.plan.name')
                    ->badge()
                    ->color('warning'),
                TextColumn::make('newOrder.lat_long')
                    ->label('Lat/Long')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('fat.name')
                    ->label('Fat box')
                    ->badge(),
                TextColumn::make('port.name')
                    ->badge()
                    ->color('info'),
                TextInputColumn::make('sn')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('register_date')
                    ->date()
            ])
            ->filters([
                SelectFilter::make('plan')
                    ->relationship('newOrder.plan' , 'name')
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
            ], layout: FiltersLayout::AboveContentCollapsible)->filtersFormColumns(4)
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
