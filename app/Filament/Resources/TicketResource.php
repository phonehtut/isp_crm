<?php

namespace App\Filament\Resources;

use Filament\Tables;
use App\Models\Ticket;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use App\Filament\Exports\TicketExporter;
use Filament\Tables\Actions\ExportAction;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Resources\TicketResource\Pages;
use App\Services\Components\Details\TicketDetailComponents;
use App\Services\Components\Forms\TicketFormComponents;
use App\Services\Components\Tables\TicketTableComponents;
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
                        TicketFormComponents::ticketTitleInput(),
                        TicketFormComponents::ticketCustomerIdSelect(),
                        TicketFormComponents::ticketTypeInput(),
                        TicketFOrmComponents::ticketAsginSelect(),
                    ])
                    ->columns(2)
                    ->collapsible(),
                Section::make('Image')
                    ->schema([
                        TicketFormComponents::ticketMaintainImageInput(),
                        TicketFormComponents::ticketInstallationImageInput(),
                    ])
                    ->columns(2),
                Section::make('Priority & Status')
                    ->schema([
                        TicketFormComponents::ticketPriorityRadio(),
                        TicketFormComponents::ticketStatusRadio(),
                    ])->columns(2),
                Section::make('Reason')
                    ->schema([
                        TicketFormComponents::ticketReasonInput(),
                     ])
             ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TicketTableComponents::ticketIdColumn(),
                TicketTableComponents::ticketCreateAtColumn(),
                TicketTableComponents::ticketCustomerRegisterDateColumn(),
                TicketTableComponents::ticketTitleColumn(),
                TicketTableComponents::ticketCustomerIdColumn(),
                TicketTableComponents::ticketCustomerPhoneColumn(),
                TicketTableComponents::ticketCustomerAddressColumn(),
                TicketTableComponents::ticketCustomerLatLongColumn(),
                TicketTableComponents::ticketCustomerFatColumn(),
                TicketTableComponents::ticketCustomerPortColumn(),
                TicketTableComponents::ticketCustomerStartCableColumn(),
                TicketTableComponents::ticketCustomerEndCableColumn(),
                TicketTableComponents::ticketCustomerTotalCableColumn(),
                TicketTableComponents::ticketCustomerFatOpticalColumn(),
                TicketTableComponents::ticketCustomerResOpticalcolumn(),
                TicketTableComponents::ticketCustomerOnuOpticalColumn(),
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
                        \Filament\Infolists\Components\Section::make('Ticket Information')
                            ->schema([
                                TicketDetailComponents::ticketIdDetail(),
                                TicketDetailComponents::ticketTitleDetail(),
                                TicketDetailComponents::ticketReasonDetail(),
                                TicketDetailComponents::ticketTypeDetail(),
                                TicketDetailComponents::ticketCreateAtDetail(),
                                TicketDetailComponents::ticketAsginToDetail(),
                                TicketDetailComponents::ticketPriorityDetail(),
                                TicketDetailComponents::ticketCreatedByDetail(),
                                TicketDetailComponents::ticketLastUpdateDetail()
                            ])
                            ->columns(3),
                        \Filament\Infolists\Components\Section::make('Customer Information')
                            ->schema([
                                TicketDetailComponents::ticketCustomerIdDetail(),
                                TicketDetailComponents::ticketCustomerRegisterDatedetail(),
                                TicketDetailComponents::ticketCustomerNamedetail(),
                                TicketDetailComponents::ticketCustomerPhoneDetail(),
                                TicketDetailComponents::ticketCustomerEmailDetail(),
                                TicketDetailComponents::ticketCustomerAddressDetail(),
                                TicketDetailComponents::ticketCustomerPlanDetail(),
                                TicketDetailComponents::ticketCustomerLatLongDetail(),
                                TicketDetailComponents::ticketCustomerTownshipDetail()
                            ])
                            ->columns(3),
                        \Filament\Infolists\Components\Section::make('Site Information')
                            ->schema([
                                TicketDetailComponents::ticketCustomerStartCableDetail(),
                                TextEntry::make('customer.end_cable')
                                    ->label('End Cable')
                                    ->suffix(' Meter'),
                                TextEntry::make('customer.total_cable')
                                    ->label('Total Cable')
                                    ->suffix(' Meter'),
                                TextEntry::make('customer.fat_optical')
                                    ->label('Fat Optical')
                                    ->suffix(' Dbm'),
                                TextEntry::make('customer.onu_optical')
                                    ->label('ONU Optical')
                                    ->suffix(' Dbm'),
                                TextEntry::make('customer.cus_res_optical')
                                    ->label('Customer Recive Optical')
                                    ->suffix(' Dbm'),
                                TextEntry::make('customer.fat.name')
                                    ->label('Fat Box')
                                    ->badge()
                                    ->color('success'),
                                TextEntry::make('customer.port.name')
                                    ->label('Port')
                                    ->badge()
                                    ->color('info')
                            ])
                            ->columns(4),
                    ])
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
