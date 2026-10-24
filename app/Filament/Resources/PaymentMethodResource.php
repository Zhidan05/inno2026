<?php

namespace App\Filament\Resources;

use App\Enums\PaymentMethodType;
use App\Enums\UserRole;
use App\Filament\Resources\PaymentMethodResource\Pages;
use App\Models\PaymentMethod;
use App\Services\ImageOptimizationService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class PaymentMethodResource extends Resource
{
    protected static ?string $model = PaymentMethod::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationGroup = 'VERIFICATION';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Payment Methods';

    protected static ?string $modelLabel = 'Payment Method';

    protected static ?string $pluralModelLabel = 'Payment Methods';

    public static function canAccess(): bool
    {
        $user = auth()->user();

        return $user && ($user->hasRole(UserRole::ADMIN->value) || $user->can('view_any_payment_method'));
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Umum')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Metode Pembayaran')
                            ->placeholder('Misal: QRIS InnoElectrica atau Transfer Bank BCA')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('type')
                            ->label('Jenis Pembayaran')
                            ->options(PaymentMethodType::options())
                            ->default(PaymentMethodType::QRIS->value)
                            ->required()
                            ->live(),
                        Forms\Components\Textarea::make('instructions')
                            ->label('Instruksi Pembayaran')
                            ->placeholder('Petunjuk tambahan untuk peserta (opsional, misal berita transfer atau catatan pembayaran)')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->helperText('Metode nonaktif tidak akan ditampilkan kepada peserta.')
                            ->default(true),
                        Forms\Components\TextInput::make('sort_order')
                            ->label('Urutan Tampilan')
                            ->helperText('Angka lebih kecil tampil lebih awal pada pilihan peserta.')
                            ->numeric()
                            ->default(0)
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Detail QRIS')
                    ->description('Pengaturan gambar kode QRIS statis yang akan dipindai oleh peserta.')
                    ->visible(fn (Forms\Get $get): bool => $get('type') === PaymentMethodType::QRIS->value)
                    ->schema([
                        Forms\Components\FileUpload::make('qris_image')
                            ->label('Gambar Kode QRIS')
                            ->image()
                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/jpg', 'image/webp'])
                            ->maxSize(10240)
                            ->directory('payment-methods')
                            ->disk('public')
                            ->imagePreviewHeight('240')
                            ->required(fn (Forms\Get $get, ?PaymentMethod $record): bool => $get('type') === PaymentMethodType::QRIS->value && ! $record?->qris_image)
                            ->saveUploadedFileUsing(ImageOptimizationService::filamentUploadHandler('payment-methods', ['is_qris' => true]))
                            ->columnSpanFull()
                            ->helperText('Upload gambar kode QRIS (PNG, JPG, WEBP). Gambar otomatis dioptimalkan ke WebP berkualitas tinggi tanpa mengurangi ketajaman scan.'),
                    ]),

                Forms\Components\Section::make('Detail Rekening Bank')
                    ->description('Pengaturan informasi rekening untuk transfer bank manual.')
                    ->visible(fn (Forms\Get $get): bool => $get('type') === PaymentMethodType::BANK_TRANSFER->value)
                    ->schema([
                        Forms\Components\TextInput::make('bank_name')
                            ->label('Nama Bank')
                            ->placeholder('Contoh: BCA, Mandiri, BRI, BNI')
                            ->required(fn (Forms\Get $get): bool => $get('type') === PaymentMethodType::BANK_TRANSFER->value)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('account_number')
                            ->label('Nomor Rekening')
                            ->placeholder('Contoh: 0123456789')
                            ->required(fn (Forms\Get $get): bool => $get('type') === PaymentMethodType::BANK_TRANSFER->value)
                            ->maxLength(255)
                            ->helperText('Tersimpan sebagai teks string agar angka 0 di depan tetap utuh.'),
                        Forms\Components\TextInput::make('account_holder_name')
                            ->label('Nama Pemilik Rekening')
                            ->placeholder('Contoh: Panitia InnoElectrica')
                            ->required(fn (Forms\Get $get): bool => $get('type') === PaymentMethodType::BANK_TRANSFER->value)
                            ->maxLength(255),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Metode')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('type')
                    ->label('Jenis')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state instanceof PaymentMethodType ? $state->label() : ($state === 'qris' ? 'QRIS' : 'Transfer Bank'))
                    ->color(fn ($state) => ($state instanceof PaymentMethodType ? $state->value : $state) === 'qris' ? 'warning' : 'info'),
                Tables\Columns\TextColumn::make('detail')
                    ->label('Detail Rekening / QRIS')
                    ->state(function (PaymentMethod $record): string {
                        if ($record->isQris()) {
                            return $record->qris_image ? 'Kode QRIS Terlampir' : 'Belum Ada Gambar';
                        }

                        return "{$record->bank_name} - {$record->account_number} ({$record->account_holder_name})";
                    }),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Aktif'),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Jenis Pembayaran')
                    ->options(PaymentMethodType::options()),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function (PaymentMethod $record, Tables\Actions\DeleteAction $action) {
                        if ($record->registrations()->exists()) {
                            Notification::make()
                                ->danger()
                                ->title('Tidak Dapat Menghapus Metode Pembayaran')
                                ->body('Metode pembayaran ini tidak dapat dihapus karena sudah memiliki riwayat pendaftaran. Silakan nonaktifkan metode pembayaran ini daripada menghapusnya.')
                                ->persistent()
                                ->send();

                            $action->cancel();
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->before(function (Collection $records, Tables\Actions\DeleteBulkAction $action) {
                            foreach ($records as $record) {
                                if ($record->registrations()->exists()) {
                                    Notification::make()
                                        ->danger()
                                        ->title('Penghapusan Massal Dibatalkan')
                                        ->body('Satu atau lebih metode pembayaran terpilih sudah memiliki riwayat pendaftaran. Aksi dibatalkan untuk menjaga integritas data.')
                                        ->persistent()
                                        ->send();

                                    $action->cancel();

                                    return;
                                }
                            }
                        }),
                ]),
            ])
            ->defaultSort('sort_order', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePaymentMethods::route('/'),
        ];
    }
}
