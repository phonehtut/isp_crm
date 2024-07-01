<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Type;
use Filament\Tables;
use App\Models\Ticket;
use App\Models\Customer;
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
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\ExportAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\CheckboxList;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Columns\TextInputColumn;
use App\Filament\Resources\TicketResource\Pages;
use Filament\Infolists\Components\Actions\Action;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Resources\TicketResource\RelationManagers;
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
                            ->preload()
                            ->required(),
                        Select::make('type_id')
                            ->relationship('type', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('department_id')
                            ->label('Asgin To')
                            ->relationship('department','name')
                            ->searchable()
                            ->preload()
                            ->required(),
                    ])
                    ->columns(2)
                    ->collapsible(),
                Section::make('Image')
                    ->schema([
                        FileUpload::make('mainten_image')
                            ->label('Maintenance Image')
                            ->multiple()
                            ->image()
                            ->directory(function (callable $get) {
                                $customer = Customer::find($get('customer_id'));
                                $customerID = $customer ? $customer->customer_id : null;
                                $type = Type::find($get('type_id'));
                                $typeName = $type ? $type->name : null;
                                $currentDate = now()->format('m-d-Y');
                                return "customers/{$customerID}/{$currentDate}_Service_{$typeName}/";
                            })
                            ->disk('public'),
                        FileUpload::make('install_image')
                            ->label('Installation Image')
                            ->multiple()
                            ->image()
                            ->directory(function (callable $get) {
                                $customer = Customer::find($get('customer_id'));
                                $customerID = $customer ? $customer->customer_id : null;
                                $currentDate = now()->format('m-d-Y');
                                return "customers/{$customerID}/Installation/";
                            })
                            ->disk('public'),
                    ])
                    ->columns(2),
                Section::make('Priority & Status')
                    ->schema([
                        Radio::make('priority')
                            ->options([
                                '0' => 'low',
                                '1' => 'middle',
                                '2' => 'High',
                                '3' => 'Urgent',
                            ])->columns(1)
                            ->required(),
                        Radio::make('status')
                            ->options([
                                '0' => 'open',
                                '1' => 'resolved',
                                '2' => 'close',
                            ])->columns(1)
                            ->required(),
                    ])->columns(2),
                Section::make('Reason')
                    ->schema([
                        Textarea::make('reason')
                            ->hiddenLabel()
                            ->required(),
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
                TextColumn::make('customer.phone')
                    ->label('Phone Number')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('customer.address')
                    ->label('Address')
                    ->html()
                    ->limit(50),
                TextColumn::make('customer.newOrder.lat_long')
                    ->label('Lat/Long')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('customer.fat.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('customer.port.name')
                    ->searchable()
                    ->sortable(),
                TextInputColumn::make('customer.start_cable')
                    ->label('Start Cable')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextInputColumn::make('customer.end_cable')
                    ->label('End Cable')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextInputColumn::make('customer.total_cable')
                    ->label('Total Cable')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextInputColumn::make('customer.fat_optical')
                    ->label('Fat OPtical')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextInputColumn::make('customer.cus_res_optical')
                    ->label('Customer Recive Optical')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextInputColumn::make('customer.onu_optical')
                    ->label('ONU Optical')
                    ->toggleable(isToggledHiddenByDefault: true),
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
                                TextEntry::make('id')
                                    ->label('Ticket ID')
                                    ->prefix('TKT'),
                                TextEntry::make('title'),
                                TextEntry::make('reason'),
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
                                    }),
                                TextEntry::make('user.name')
                                    ->label('Created By'),
                                TextEntry::make('lastUser.name')
                                    ->label('Last Updated By')
                            ])
                            ->columns(3),
                        \Filament\Infolists\Components\Section::make('Customer Information')
                            ->schema([
                                TextEntry::make('customer.customer_id')
                                    ->label('Customer ID'),
                                TextEntry::make('customer.register_date')
                                    ->label('Register Date'),
                                TextEntry::make('customer.name')
                                    ->label('Customer Name'),
                                TextEntry::make('customer.phone')
                                    ->label('Customer Phone Number')
                                    ->copyable()
                                    ->copyMessage('phone number Copied'),
                                TextEntry::make('customer.email')
                                    ->label('Customer Email')
                                    ->copyable()
                                    ->copyMessage('Email Copied'),
                                TextEntry::make('customer.address')
                                    ->label('Address'),
                                TextEntry::make('customer.plan.name')
                                    ->label('Plan')
                                    ->badge(),
                                TextEntry::make('lat_long')
                                    ->label('Lat/Long')
                                    ->copyable()
                                    ->copyMessage('Lat Long Copied'),
                                TextEntry::make('customer.township.name')
                                    ->label('Township')
                            ])
                            ->columns(3),
                        \Filament\Infolists\Components\Section::make('Site Information')
                            ->schema([
                                TextEntry::make('customer.start_cable')
                                    ->label('Start Cable')
                                    ->suffix(' Meter'),
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
