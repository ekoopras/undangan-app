<?php

namespace App\Filament\App\Pages;

use Filament\Pages\Page;
use App\Models\Invitation as InvitationModel;
use App\Models\Media;
use App\Models\Theme;
use Filament\Forms\Form;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Grid;
use Filament\Notifications\Notification;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;

class Invitation extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationLabel = 'Undangan Saya';
    protected static ?string $slug = 'invitation';
    protected static ?string $title = '';

    protected static string $view = 'filament.app.pages.invitation';

    public ?array $data = [];
    public ?InvitationModel $record = null;

    public function mount(): void
    {
        $userId = Auth::id();

        // 1. Cari data undangan milik user ini
        $this->record = InvitationModel::where('user_id', $userId)->first();

        // 2. Jika belum ada, buatkan data awal (fallback)
        if (! $this->record) {
            $this->record = InvitationModel::create([
                'user_id' => $userId,
                'theme_id' => Theme::first()?->id ?? 1,
                'slug' => 'undangan-' . strtolower(str_replace(' ', '-', Auth::user()->name)),
                'features' => [
                    'mempelai_pria' => '',
                    'mempelai_wanita' => '',
                    'gambar_sampul' => '',
                    'gambar_avatar' => '',
                    'sections' => [['type' => 'cover', 'is_active' => true]]
                ]
            ]);
        }

        // Isi form dengan data milik user
        $this->form->fill($this->record->toArray());
    }

    private static function makeMediaPickerField(string $fieldName, string $label)
    {
        return TextInput::make($fieldName)
            ->label($label)
            ->placeholder('Belum ada foto dipilih')
            ->readOnly()
            ->required()
            ->columnSpanFull()
            ->suffixAction(
                Action::make('bukaModalMedia')
                    ->label('Pilih / Upload')
                    ->icon('heroicon-m-photo')
                    ->color('primary')
                    ->modalHeading('Pustaka Media & Pengunggah')
                    ->modalWidth('5xl')
                    ->modalSubmitAction(false)
                    ->modalContent(function (Component $component) {
                        return view('filament.app.pages.media-modal-wrapper', [
                            'statePath' => $component->getStatePath(),
                        ]);
                    })
            );
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Repeater::make('features.sections')
                    ->label('')

                    ->itemLabel(fn(array $state): ?string => match ($state['type'] ?? null) {
                        'cover' => 'Cover',
                        'opening' => 'Opening',
                        'quote' => 'Quote',
                        'mempelai_pria' => 'Mempelai Pria',
                        'mempelai_wanita' => 'Mempelai Wanita',
                        'gallery' => 'Gallery',
                        'acara' => 'Acara',
                        'maps' => 'Maps',
                        'gift' => 'Gift',
                        'terimakasih' => 'Terimakasih',
                        'music' => 'Music',
                        default => '➕ Seksi Baru',
                    })
                    ->collapsible()
                    ->collapsed()
                    ->defaultItems(1)
                    ->schema([

                        Grid::make(2)->schema([
                            Select::make('type')
                                ->label('Jenis Seksi')
                                ->options([
                                    'cover' => 'Cover',
                                    'opening' => 'Opening',
                                    'quote' => 'Quote',
                                    'mempelai_pria' => 'Mempelai Pria',
                                    'mempelai_wanita' => 'Mempelai Wanita',
                                    'gallery' => 'Gallery',
                                    'acara' => 'Acara',
                                    'maps' => 'Maps',
                                    'gift' => 'Gift',
                                    'terimakasih' => 'Terimakasih',
                                    'music' => 'Music',

                                ])
                                ->required()
                                ->live(),

                            Toggle::make('is_active')
                                ->label('Tampilkan Seksi Ini')
                                ->default(true),

                        ]),

                        // ─── REVISI FORM: HAPUS PREFIX 'features.' DI DALAM REPEATER ───
                        Grid::make(1)
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('cover_mempelai_pria')
                                        ->label('Nama Mempelai Laki-laki')
                                        ->required(),

                                    TextInput::make('cover_mempelai_wanita')
                                        ->label('Nama Mempelai Perempuan')
                                        ->required(),
                                ]),

                                Grid::make(2)
                                    ->schema([
                                        // Cukup tulis nama field-nya tanpa prefix 'features.'
                                        self::makeMediaPickerField('cover_gambar_sampul', 'Gambar Sampul')->nullable(),
                                        self::makeMediaPickerField('cover_gambar_avatar', 'Gambar Avatar')->nullable(),
                                    ]),
                            ])
                            ->visible(fn(\Filament\Forms\Get $get) => $get('type') === 'cover'),

                        Grid::make(1)
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        self::makeMediaPickerField('opening_gambar_avatar', 'Gambar Avatar')->nullable(),
                                    ]),
                                Grid::make(2)->schema([
                                    TextInput::make('opening_mempelai_pria')
                                        ->label('Nama Mempelai')
                                        ->required(),

                                    TextInput::make('opening_mempelai_wanita')
                                        ->label('Nama Mempelai')
                                        ->required(),

                                    DatePicker::make('opening_tanggal_resepsi')
                                        ->label('tanggal resepsi'),
                                ]),
                            ])
                            ->visible(fn(\Filament\Forms\Get $get) => $get('type') === 'opening'),

                        Grid::make(1)
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        self::makeMediaPickerField('quote_gambar_avatar', 'Gambar Avatar')->nullable(),
                                    ]),
                                Grid::make(2)
                                    ->schema([
                                        Textarea::make('quote_text')
                                            ->rows(5) // Mengatur jumlah baris
                                            ->cols(10), // Mengatur lebar kolom
                                    ]),
                            ])
                            ->visible(fn(\Filament\Forms\Get $get) => $get('type') === 'quote'),

                        Grid::make(1)
                            ->schema([
                                Grid::make(2)
                                    ->schema([

                                        self::makeMediaPickerField('avatar_mempelai_pria', 'Gambar Avatar')->nullable(),

                                        TextInput::make('mempelai_pria')
                                            ->label('Nama Mempelai Laki-laki')
                                            ->required(),

                                        TextInput::make('ortu_mempelai_pria')
                                            ->label('Ortu Mempelai Laki-laki')
                                            ->required(),
                                    ]),

                            ])
                            ->visible(fn(\Filament\Forms\Get $get) => $get('type') === 'mempelai_pria'),

                        Grid::make(1)
                            ->schema([
                                Grid::make(2)
                                    ->schema([

                                        self::makeMediaPickerField('avatar_mempelai_wanita', 'Gambar Avatar')->nullable(),

                                        TextInput::make('mempelai_wanita')
                                            ->label('Nama Mempelai Wanita')
                                            ->required(),

                                        TextInput::make('ortu_mempelai_wanita')
                                            ->label('Ortu Mempelai Wanita')
                                            ->required(),
                                    ]),

                            ])
                            ->visible(fn(\Filament\Forms\Get $get) => $get('type') === 'mempelai_wanita'),

                        Grid::make(1)
                            ->schema([
                                Grid::make(1)
                                    ->schema([
                                        Repeater::make('daftar_foto')
                                            ->label('Daftar Foto Galeri')
                                            ->itemLabel(fn(array $state): ?string => $state['caption'] ?? 'Foto Galeri')
                                            ->maxItems(6) // 🔒 Membatasi maksimal 6 item foto saja
                                            ->schema([
                                                Grid::make(2)
                                                    ->schema([
                                                        // Menggunakan helper picker gambar yang kamu miliki
                                                        self::makeMediaPickerField('foto', 'File Foto')
                                                            ->required()
                                                            ->columnSpan(2),

                                                    ]),
                                            ])
                                            ->collapsible()
                                            ->defaultItems(1)
                                            ->addActionLabel('Tambah Foto (Maks. 6)'),
                                    ]),
                            ])
                            ->visible(fn(\Filament\Forms\Get $get) => $get('type') === 'gallery'),

                        Grid::make(1)
                            ->schema([
                                // REPEATER KHUSUS DAFTAR ACARA (Nested Repeater)
                                Repeater::make('daftar_acara')
                                    ->label('Daftar Acara / Rangkaian Kegiatan')
                                    ->itemLabel(fn(array $state): ?string => $state['nama_acara'] ?? 'Acara Baru')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('nama_acara')
                                                    ->label('Nama Acara')
                                                    ->placeholder('Contoh: Akad Nikah / Resepsi')
                                                    ->required()
                                                    ->columnSpan(2),

                                                DatePicker::make('tanggal_acara')
                                                    ->label('Tanggal Acara')
                                                    ->native(false)
                                                    ->displayFormat('d F Y')
                                                    ->required(),

                                                TextInput::make('waktu_acara')
                                                    ->label('Waktu Acara')
                                                    ->placeholder('Contoh: 10.00 WIB - Selesai')
                                                    ->required(),

                                                TextInput::make('lokasi_acara')
                                                    ->label('Nama Tempat / Lokasi')
                                                    ->placeholder('Contoh: Gedung Wanita Karanganyar')
                                                    ->columnSpan(2),

                                                TextInput::make('alamat')
                                                    ->label('Alamat')
                                                    ->columnSpan(2),
                                            ]),
                                    ])
                                    ->collapsible()
                                    ->defaultItems(1)
                                    ->addActionLabel('Tambah Acara Lain'),
                            ])
                            ->visible(fn(\Filament\Forms\Get $get) => $get('type') === 'acara'),

                        Grid::make(1)
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('nama_tempat')
                                            ->label('Nama Tempat / Gedung')
                                            ->placeholder('Contoh: Gedung Wanita Karanganyar / Kediaman Mempelai Pria')
                                            ->columnSpan(2),

                                        Textarea::make('alamat_lengkap')
                                            ->label('Alamat Lengkap')
                                            ->placeholder('Contoh: Jl. Lawu No. 123, Badran Asri, Karanganyar...')
                                            ->rows(3)
                                            ->columnSpan(2),

                                        TextInput::make('link_google_maps')
                                            ->label('Link Google Maps (Tombol Navigasi)')
                                            ->placeholder('https://maps.app.goo.gl/...')
                                            ->url()
                                            ->columnSpan(2),

                                        Textarea::make('embed_map_url')
                                            ->label('Embed Map (Iframe HTML / Link Embed)')
                                            ->placeholder('Paste kode <iframe> dari Google Maps atau link embed-nya di sini')
                                            ->helperText('Digunakan untuk menampilkan peta interaktif langsung di halaman undangan')
                                            ->rows(3)
                                            ->columnSpan(2),
                                    ]),
                            ])
                            ->visible(fn(\Filament\Forms\Get $get) => $get('type') === 'maps'),

                        Grid::make(1)
                            ->schema([
                                Grid::make(1)
                                    ->schema([
                                        Repeater::make('daftar_rekening')
                                            ->label('Daftar Rekening Bank & E-Wallet')
                                            ->itemLabel(fn(array $state): ?string => isset($state['nama_bank']) ? "{$state['nama_bank']} - {$state['atas_nama']}" : 'Rekening Baru')
                                            ->schema([
                                                Grid::make(2)
                                                    ->schema([
                                                        TextInput::make('nama_bank')
                                                            ->label('Nama Bank / E-Wallet')
                                                            ->placeholder('Contoh: BCA, Mandiri, BRI, GoPay, OVO')
                                                            ->required()
                                                            ->columnSpan(2),

                                                        TextInput::make('no_rekening')
                                                            ->label('Nomor Rekening / HP')
                                                            ->placeholder('Contoh: 1234567890')
                                                            ->required(),

                                                        TextInput::make('atas_nama')
                                                            ->label('Atas Nama')
                                                            ->placeholder('Contoh: Fulan / Fulanah')
                                                            ->required(),
                                                    ]),
                                            ])
                                            ->collapsible()
                                            ->defaultItems(1)
                                            ->addActionLabel('Tambah Rekening / E-Wallet'),
                                    ]),
                            ])
                            ->visible(fn(\Filament\Forms\Get $get) => $get('type') === 'gift'),

                        Grid::make(1)
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        self::makeMediaPickerField('avatar_terimakasih', 'Gambar Avatar')->nullable(),
                                    ]),
                                Grid::make(2)
                                    ->schema([
                                        Textarea::make('terimakasih_text')
                                            ->rows(5) // Mengatur jumlah baris
                                            ->cols(10), // Mengatur lebar kolom
                                    ]),
                            ])
                            ->visible(fn(\Filament\Forms\Get $get) => $get('type') === 'terimakasih'),

                        Grid::make(1)
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('music_url')
                                            ->label('Link Musik (URL MP3)')
                                            ->placeholder('https://domain.com/path-to-audio.mp3')
                                            ->url()
                                            ->prefixIcon('heroicon-o-musical-note')
                                            ->nullable(),
                                    ]),
                            ])
                            ->visible(fn(\Filament\Forms\Get $get) => $get('type') === 'music'),

                    ])
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan Perubahan')
                ->color('primary')
                ->submit('save'),
        ];
    }

    public function hasFullWidthFormActions(): bool
    {
        return false;
    }

    public function save(): void
    {
        try {
            $validatedData = $this->form->getState();

            // Simpan perubahan ke database
            $this->record->update($validatedData);

            Notification::make()
                ->title('Konten Undangan Anda Berhasil Disimpan!')
                ->success()
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Gagal menyimpan data: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }
}
