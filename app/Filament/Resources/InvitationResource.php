<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvitationResource\Pages;
use App\Filament\Resources\InvitationResource\RelationManagers;
use App\Filament\Resources\InvitationResource\RelationManagers\WishesRelationManager;
use App\Models\Invitation;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InvitationResource extends Resource
{
    protected static ?string $model = Invitation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Undangan Hub')
                    ->tabs([
                        // TAB 1: PENGATURAN UTAMA (User, Tema, Link)
                        Tab::make('Informasi Utama')
                            ->schema([
                                Select::make('user_id')
                                    ->relationship('user', 'name')
                                    ->searchable()
                                    ->required()
                                    ->label('Client / Pemilik'),
                                Select::make('theme_id')
                                    ->relationship('theme', 'title')
                                    ->required()
                                    ->label('Pilihan Tema'),
                                TextInput::make('slug')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->label('Nama Link URL')
                                    ->placeholder('contoh: budi-dan-ani')
                                    ->prefix('undangan/'),
                                DateTimePicker::make('active_until')
                                    ->label('Masa Aktif')
                                    ->required(),
                            ])->columns(2),

                        // TAB 2: EDIT FITUR DI DALAMNYA (Konten Tema)
                        Tab::make('Konten & Fitur Tema')
                            ->schema([])->columns(2),
                    ])
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('Client')->searchable(),
                TextColumn::make('theme.title')->label('Tema'),
                TextColumn::make('slug')->label('Link URL')->prefix('/p/'),
                TextColumn::make('active_until')->label('Masa Aktif')->dateTime()->sortable(),
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
            WishesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInvitations::route('/'),
            'create' => Pages\CreateInvitation::route('/create'),
            'edit' => Pages\EditInvitation::route('/{record}/edit'),
        ];
    }
}
