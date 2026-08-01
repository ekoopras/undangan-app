<?php

namespace App\Filament\App\Pages;

use App\Models\Wish;
use Filament\Pages\Page;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Ucapan extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';
    protected static ?string $navigationLabel = 'Ucapan & Doa';
    protected static ?string $title = '';
    protected static string $view = 'filament.app.pages.ucapan';

    public static function getEloquentQuery(): Builder
    {
        return Wish::query()
            ->whereHas('invitation', function (Builder $query) {
                $query->where('user_id', Auth::id());
            })
            ->latest();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(static::getEloquentQuery())
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->columns([
                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\Layout\Split::make([
                        Tables\Columns\TextColumn::make('name')
                            ->weight('bold')
                            ->size(Tables\Columns\TextColumn\TextColumnSize::Large)
                            ->searchable(),

                        Tables\Columns\TextColumn::make('created_at')
                            ->dateTime('d M Y, H:i')
                            ->size(Tables\Columns\TextColumn\TextColumnSize::ExtraSmall)
                            ->color('success')
                            ->badge()
                            ->grow(false),
                    ]),

                    // Tables\Columns\TextColumn::make('invitation.slug')
                    //     ->badge()
                    //     ->color('info')
                    //     ->size(Tables\Columns\TextColumn\TextColumnSize::ExtraSmall),

                    Tables\Columns\TextColumn::make('message')
                        ->color('gray')
                        ->wrap()
                        ->extraAttributes(['class' => 'mt-2 text-sm italic']),
                ])->space(2),
            ])
            ->paginationPageOptions([50])
            ->filters([
                // Tables\Filters\SelectFilter::make('invitation_id')
                //     ->label('Filter Undangan')
                //     ->relationship('invitation', 'title', fn(Builder $query) => $query->where('user_id', Auth::id())),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make()
                    ->modalHeading('Hapus Ucapan')
                    ->button()
                    ->label('')
                    ->modalDescription('Apakah Anda yakin ingin menghapus ucapan ini dari halaman undangan?')
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Berhasil')
                            ->body('Ucapan telah dihapus.')
                    ),
            ]);
    }
}
