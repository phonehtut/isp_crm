<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\NewOrder;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Support\Enums\FontFamily;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\NewOrderResource\Pages;
use App\Filament\Resources\NewOrderResource\Pages\CreateNewOrder;

class NewOrderResource extends Resource
{
    protected static ?string $model = NewOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Ganeral Information')
                    ->schema([
                    TextInput::make('name')
                        ->label('Customer Name')
                        ->placeholder('Please enter customer name')
                        ->required()
                        ->columnSpan(1),
                    TextInput::make('email')
                        ->label('Customer Email')
                        ->placeholder('Please enter customer email')
                        ->required()
                        ->email()
                        ->unique(ignoreRecord: true)
                        ->columnSpan(1),
                    TextInput::make('phone')
                        ->label('Phone Number')
                        ->placeholder('Please enter customer phone number')
                        ->required()
                        ->columnSpan(1),
                    ])
                    ->columns(3),
                Section::make('NRC (Optional)')
                    ->schema([
                    FileUpload::make('nrc_front')
                        ->hiddenLabel()
                        ->placeholder('please select nrc front photo')
                        ->directory('nrc/front')
                        ->disk('public')
                        ->image(),
                    FileUpload::make('nrc_back')
                        ->hiddenLabel()
                        ->placeholder('please select nrc back photo')
                        ->directory('nrc/back')
                        ->disk('public')
                        ->image(),
                    ])
                    ->columns(2)
                    ->collapsed(),
                Section::make('Other')
                    ->schema([
                        Select::make('plan_id')
                            ->relationship('plan', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('lat_long')
                            ->label('Lat/Long')
                            ->placeholder('Please enter customer lag/long'),
                        Select::make('status')
                            ->options([
                                '0' => 'Pending',
                                '1' => 'Finish',
                            ])
                            ->searchable()
                            ->preload()
                            ->label('Status')
                            ->placeholder('Please Select Order Status')
                            ->required()
                    ])
                    ->columns(3),
                Section::make('Address')
                    ->schema([
                    RichEditor::make('address')
                        ->toolbarButtons([
                            'blockquote',
                            'bold',
                            'codeBlock',
                            'italic',
                            'link',
                            'redo',
                            'undo',
                            'strike',
                            'underline',
                        ])
                        ->hiddenLabel()
                        ->placeholder('Please enter customer address')
                        ->columnSpan('full'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Email Copied Successful')
                    ->color('info')
                    ->fontFamily(FontFamily::Mono),
                TextColumn::make('phone')
                    ->label('Phone Number')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Phone Copied Successful')
                    ->color('info')
                    ->fontFamily(FontFamily::Mono),
                TextColumn::make('plan.name')
                    ->badge()
                    ->color('warning')
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Order Status')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        '0' => 'Pending',
                        '1' => 'Finish'
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        '0' => 'danger',
                        '1' => 'success'
                    }),
                TextColumn::make('address')
                    ->limit(30)
                    ->fontFamily(FontFamily::Mono)
                    ->html(),
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
            'index' => Pages\ListNewOrders::route('/'),
            'create' => Pages\CreateNewOrder::route('/create'),
            'edit' => Pages\EditNewOrder::route('/{record}/edit'),
        ];
    }
}
