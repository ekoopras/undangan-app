<?php

namespace App\Filament\App\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use App\Models\SendLink as SendLinkModel;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Models\Invitation;

class SendLink extends Page implements HasForms, HasTable
{

    use InteractsWithForms;
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-paper-airplane';
    protected static ?string $navigationLabel = 'Kirim Link WA';
    protected static ?string $title = '';
    protected static string $view = 'filament.app.pages.send-link';

    // State Form
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Input Tamu')
                    ->schema([
                        Forms\Components\Hidden::make('invitation_id')
                            ->default(fn() => Invitation::where('user_id', Auth::id())->value('id'))
                            ->required(),

                        Forms\Components\TextInput::make('recipient_name')
                            ->label('Nama Tamu / Penerima')
                            ->placeholder('Contoh: Budi')
                            ->required(),

                        Forms\Components\TextInput::make('phone_number')
                            ->label('Nomor WhatsApp')
                            ->placeholder('Contoh: 081234567890')
                            ->tel()
                            ->required(),
                    ])->columns(3),
            ])
            ->statePath('data');
    }

    public function createLink(): void
    {
        $formData = $this->form->getState();

        $invitation = Invitation::find($formData['invitation_id']);

        if (!$invitation) {
            Notification::make()->danger()->title('Undangan tidak ditemukan.')->send();
            return;
        }

        // 1. Format Nomor HP (08123... -> 628123...)
        $phone = preg_replace('/[^0-9]/', '', $formData['phone_number']);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        // 2. Generate URL Undangan memakai 'slug'
        $baseUrl = config('app.url') . '/' . ltrim($invitation->slug, '/');
        $generatedUrl = $baseUrl . '?to=' . urlencode($formData['recipient_name']);

        // 3. Simpan ke Database
        SendLinkModel::create([
            'invitation_id'  => $invitation->id,
            'recipient_name' => $formData['recipient_name'],
            'phone_number'   => $phone,
            'generated_url'  => $generatedUrl,
        ]);

        // 🛠️ PERBAIKAN: Ganti $this->form->reset() menjadi $this->form->fill()
        $this->form->fill();

        Notification::make()
            ->success()
            ->title('Link Berhasil Dibuat!')
            ->body('Silakan klik tombol Kirim WA pada daftar di bawah.')
            ->send();
    }

    public static function getEloquentQuery(): Builder
    {
        return SendLinkModel::query()
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
                        Tables\Columns\TextColumn::make('recipient_name')
                            ->weight('bold')
                            ->size(Tables\Columns\TextColumn\TextColumnSize::Large)
                            ->searchable(),

                        // Badge Indikator Status Pengiriman
                        Tables\Columns\TextColumn::make('sent_at')
                            ->badge()
                            ->formatStateUsing(fn($state) => $state ? 'Sudah Terkirim' : 'Belum Terkirim')
                            ->color(fn($state) => $state ? 'success' : 'warning')
                            ->grow(false),
                    ]),

                    Tables\Columns\Layout\Split::make([
                        Tables\Columns\TextColumn::make('phone_number')
                            ->icon('heroicon-m-phone')
                            ->size(Tables\Columns\TextColumn\TextColumnSize::ExtraSmall)
                            ->color('gray'),

                        // Menampilkan Waktu Kirim (jika sudah dikirim)
                        Tables\Columns\TextColumn::make('sent_at')
                            ->dateTime('d M Y, H:i')
                            ->size(Tables\Columns\TextColumn\TextColumnSize::ExtraSmall)
                            ->color('gray')
                            ->grow(false),
                    ]),

                    // Tables\Columns\TextColumn::make('invitation.slug')
                    //     ->badge()
                    //     ->color('info')
                    //     ->size(Tables\Columns\TextColumn\TextColumnSize::ExtraSmall),

                ])->space(2),
            ])
            ->paginationPageOptions([20])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status Kirim')
                    ->options([
                        'belum' => 'Belum Terkirim',
                        'sudah' => 'Sudah Terkirim',
                    ])
                    ->query(function ($query, array $data) {
                        if ($data['value'] === 'belum') {
                            return $query->whereNull('sent_at');
                        }
                        if ($data['value'] === 'sudah') {
                            return $query->whereNotNull('sent_at');
                        }
                    }),
            ])
            ->actions([
                // Tombol Kirim WA (Hanya update database SAAT DIKLIK)
                Tables\Actions\Action::make('send_wa')
                    ->label(fn(SendLinkModel $record) => $record->sent_at ? 'Kirim Ulang WA' : 'Kirim WA')
                    ->icon('heroicon-o-chat-bubble-left-ellipsis')
                    ->color(fn(SendLinkModel $record) => $record->sent_at ? 'warning' : 'success')
                    ->button()
                    ->action(function (SendLinkModel $record) {
                        // 1. Update status hanya saat aksi benar-benar diklik oleh user
                        $record->update(['sent_at' => now()]);

                        // 2. Susun pesan WA
                        $pesan = "Yth. *" . $record->recipient_name . "*,\n\n"
                            . "Tanpa mengurangi rasa hormat, perkenankan kami mengundang Bapak/Ibu/Saudara/i untuk menghadiri acara pernikahan kami.\n\n"
                            . "Berikut detail informasi dan lokasi acara dapat diakses melalui link undangan berikut:\n"
                            . $record->generated_url . "\n\n"
                            . "Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu.\n\n"
                            . "Terima kasih.\n"
                            . "*Mempelai & Keluarga*";

                        $waUrl = "https://api.whatsapp.com/send?phone=" . $record->phone_number . "&text=" . urlencode($pesan);

                        // 3. Buka tab baru ke WhatsApp
                        $this->js("window.open('{$waUrl}', '_blank')");
                    }),

                Tables\Actions\DeleteAction::make()->button()->label(''),

            ]);
    }
}
