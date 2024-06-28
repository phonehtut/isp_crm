<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Support\Enums\FontFamily;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Maintenance;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MaintenanceResource\Pages;
use App\Filament\Resources\MaintenanceResource\RelationManagers;

class MaintenanceResource extends Resource
{
    use InteractsWithForms;

    protected static ?string $model = Maintenance::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Maintenance Infomation')
                    ->schema([
                        DateTimePicker::make('issues_at')
                            ->native(false)
                            ->seconds(false)
                            ->placeholder('Select Issues Date')
                            ->required()
                            ->reactive()
                            ->timezone('Asia/Yangon')
                            ->afterStateUpdated(fn ($state, callable $set, callable $get) => static::calculateDuration($set, $get('issues_at'), $get('finish_at'))),
                        DateTimePicker::make('finish_at')
                            ->native(false)
                            ->seconds(false)
                            ->reactive()
                            ->timezone('Asia/Yangon')
                            ->afterStateUpdated(fn ($state, callable $set, callable $get) => static::calculateDuration($set, $get('issues_at'), $get('finish_at'))),
                        Select::make('ticket_id')
                            ->relationship('ticket', 'id')
                            ->searchable()
                            ->preload()
                            ->prefix('TKT'),
                        Select::make('customer_id')
                            ->relationship('customer', 'customer_id')
                            ->searchable()
                            ->preload(),
                        Select::make('department_id')
                            ->relationship('department', 'name')
                            ->searchable()
                            ->preload(),
                        Select::make('status')
                            ->options([
                                '0' => 'pending',
                                '1' => 'finish',
                                '2' => 'Need To Check',
                            ])
                            ->searchable()
                            ->preload(),
                    ])
                    ->columns(2)
                    ->collapsible(),
                Section::make('Remark')
                    ->schema([
                        Textarea::make('cc_remark')
                            ->label('Call Center Remark')
                            ->placeholder('Please enter call center remark'),
                        Textarea::make('noc_remark')
                            ->label('Noc Remark')
                            ->placeholder('Please enter NOC remark'),
                    ])
                    ->columns(2)
                    ->collapsible(),
                Section::make('Site Information')
                    ->schema([
                        Select::make('site_engineer')
                            ->options([
                                '0' => 'Sub Com Team',
                                '1' => 'Home Team',
                            ])
                            ->searchable()
                            ->preload(),
                        Select::make('fault_point_id')
                            ->relationship('faultPoint', 'name')
                            ->searchable()
                            ->preload(),
                        TextInput::make('duration')
                            ->readOnly(),
                        Textarea::make('issues')
                            ->label('Issues Detail')
                            ->placeholder('Please Enter Issues Detail')
                            ->columnSpan('full'),
                        TextInput::make('onu')
                            ->label('ONU SN')
                            ->placeholder('Please Enter ONU SN'),
                        TextInput::make('adapter'),
                        TextInput::make('drop_cable')
                            ->label('Drop Cable')
                            ->placeholder('Please Enter Drop Cable'),
                        TextInput::make('patch_cord_apc')
                            ->label('Patch Cord (APC)'),
                        TextInput::make('patch_cord_upc')
                            ->label('Patch Cord (UPC)'),
                        TextInput::make('pigtail_apc')
                            ->label('Pigtail (APC)'),
                        TextInput::make('pigtail_upc')
                            ->label('Pigtail (UPC)'),
                        TextInput::make('sleeve')
                            ->label('Sleeve'),
                        TextInput::make('sleeve_closure')
                            ->label('Sleeve Closure')
                    ])
                    ->columns(3)
                    ->collapsible(),
            ]);
    }

    protected static function calculateDuration(callable $set, $finishAt, $issuesAt)
    {
        if (empty($issuesAt) || empty($finishAt)) {
            $set('duration', 'Error: Missing input fields');
            return;
        }

        try {
            // Concatenate date and time strings correctly
            $startDateTimeString = $issuesAt ;
            $endDateTimeString = $finishAt ;

            // Parse concatenated strings into Carbon objects
            $startDateTime = Carbon::parse($startDateTimeString);
            $endDateTime = Carbon::parse($endDateTimeString);

            // Calculate the difference in minutes between the two DateTime objects
            $diffInMinutes = $endDateTime->diffInMinutes($startDateTime);

            // Calculate days, hours, and minutes from the difference in minutes
            $days = intdiv($diffInMinutes, 1440); // 1440 minutes in a day
            $hours = intdiv($diffInMinutes % 1440, 60);
            $minutes = $diffInMinutes % 60;

            // Format the duration string
            $durationString = "{$days} days, {$hours} hours, {$minutes} minutes";

            // Set the duration field in the form
            $set('duration', $durationString);
        } catch (\Exception $e) {
            // Handle any parsing or calculation errors
            $set('duration', 'Error: ' . $e->getMessage());
        }
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('issues_at')
                    ->dateTime(),
                TextColumn::make('ticket.id')
                    ->prefix('TKT'),
                TextColumn::make('customer.customer_id')
                    ->label('Customer ID')
                    ->copyable()
                    ->copyMessage('Customer ID Copied')
                    ->fontFamily(FontFamily::Mono)
                    ->color('info'),
                TextColumn::make('department.name'),
                TextColumn::make('cc_remark')
                    ->label('Call Center Remark')
                    ->limit(30),
                TextColumn::make('noc_remark')
                    ->label('NOC Remark')
                    ->limit(30),
                TextColumn::make('noc.name')
                    ->label('NOC Engineer'),
                TextColumn::make('finishNoc.name')
                    ->label('Fixed NOC engineer'),
                TextColumn::make('status')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        '0' => 'Pending',
                        '1' => 'Finish',
                        '2' => 'Need To Check',
                        default => 'Unknow',
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        '0' => 'danger',
                        '1' => 'success',
                        '2' => 'warning',
                        default => 'primary',
                    }),
                TextColumn::make('site_engineer')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        '0' => 'Sub Com Team',
                        '1' => 'In House Team'
                    })
                    ->color(fn(string $state): string => match ($state) {
                        '0' => 'info',
                        '1' => 'success'
                    }),
                TextColumn::make('finish_at')
                    ->dateTime(),
                TextColumn::make('issues')
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('faultPoint.name')
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('onu')
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('adapter')
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('drop_cable')
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('patch_cord_apc')
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('patch_cord_upc')
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('pigtail_apc')
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('pigtail_upc')
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('sleeve')
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('sleeve_closure')
                    ->toggleable(isToggledHiddenByDefault: false),
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
