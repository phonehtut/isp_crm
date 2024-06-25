<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Ticket;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Exports\TicketExporter;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ExportAction;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Resources\TicketResource\Pages;
use Parallax\FilamentComments\Tables\Actions\CommentsAction;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'fas-ticket';

    protected static ?string $navigationGroup = 'Ticket Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Ganeral')
                    ->schema([
                        TextInput::make('title')
                            ->label('Ticket Title')
                            ->required(),
                        Select::make('customer_id')
                            ->relationship('customer', 'customer_id')
                            ->searchable()
                            ->preload(),
                        Select::make('new_order_id')
                            ->relationship('newOrder','name')
                            ->searchable()
                            ->preload(),
                        Select::make('type_id')
                            ->relationship('type', 'name')
                            ->searchable()
                            ->preload(),
                        Select::make('department_id')
                            ->label('Asgin To')
                            ->relationship('department','name')
                            ->searchable()
                            ->preload(),
                    ])
                    ->columns(2)
                    ->collapsible(),
                Section::make('Priority & Status')
                    ->schema([
                        Radio::make('priority')
                            ->options([
                                '0' => 'low',
                                '1' => 'middle',
                                '2' => 'High',
                                '3' => 'Urgent',
                            ])->columns(1),
                        Radio::make('status')
                            ->options([
                                '0' => 'open',
                                '1' => 'resolved',
                                '2' => 'close',
                            ])->columns(1),
                    ])->columns(2),
                Section::make('Reason')
                    ->schema([
                        Textarea::make('reason')
                            ->hiddenLabel(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->prefix('TKT')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('issues Date')
                    ->date(),
                TextColumn::make('customer.register_date')
                    ->label('Register Date')
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('customer.customer_id')
                    ->label('Customer ID')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('newOrder.phone')
                    ->label('Phone Number')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('newOrder.address')
                    ->label('Address')
                    ->html()
                    ->limit(50),
                TextColumn::make('newOrder.lat_long')
                    ->label('Lat/Long')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('newOrder.fat.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('newOrder.port.name')
                    ->searchable()
                    ->sortable()
            ])
            ->filters([
                //
            ])
            ->headerActions([
                ExportAction::make()
                    ->label('Export CSV, XLSX')
                    ->exporter(TicketExporter::class),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                CommentsAction::make(),
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

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                \Filament\Infolists\Components\Section::make('Detail Page')
                    ->schema([
                        TextEntry::make('title'),
                        TextEntry::make('customer.customer_id')
                            ->label('Customer ID'),
                        TextEntry::make('type.name')
                            ->badge(),
                        TextEntry::make('created_at')
                            ->label('Issues date')
                            ->date(),
                        TextEntry::make('department.name')
                            ->label('Asgin To')
                            ->badge(),
                        TextEntry::make('priority')
                            ->formatStateUsing(fn(string $state): string => match ($state) {
                                '0' => 'low',
                                '1' => 'middle',
                                '2' => 'High',
                                '3' => 'Urgent',
                            })
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                '0' => 'success',
                                '1' => 'primary',
                                '2' => 'warning',
                                '3' => 'danger',
                                default => 'unknown',
                            })

                    ])
                    ->columns(3)
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
            'view' => Pages\ViewTicket::route('/{record}/view'),
        ];
    }
}
