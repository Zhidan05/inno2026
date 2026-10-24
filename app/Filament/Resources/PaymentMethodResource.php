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
                Forms\Components\Section::make('General Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Payment Method Name')
                            ->placeholder('e.g. InnoElectrica QRIS or Bank Transfer BCA')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('type')
                            ->label('Payment Type')
                            ->options(PaymentMethodType::options())
                            ->default(PaymentMethodType::QRIS->value)
                            ->required()
                            ->live(),
                        Forms\Components\Textarea::make('instructions')
                            ->label('Payment Instructions')
                            ->placeholder('Additional instructions for participants (optional, e.g. transfer notes or payment remarks)')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active Status')
                            ->helperText('Inactive methods will not be displayed to participants.')
                            ->default(true),
                        Forms\Components\TextInput::make('sort_order')
                            ->label('Display Order')
                            ->helperText('Lower numbers appear earlier in participant choices.')
                            ->numeric()
                            ->default(0)
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('QRIS Details')
                    ->description('Configuration for the static QRIS code image to be scanned by participants.')
                    ->visible(fn (Forms\Get $get): bool => $get('type') === PaymentMethodType::QRIS->value)
                    ->schema([
                        Forms\Components\FileUpload::make('qris_image')
                            ->label('QRIS Code Image')
                            ->image()
                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/jpg', 'image/webp'])
                            ->maxSize(10240)
                            ->directory('payment-methods')
                            ->disk('public')
                            ->imagePreviewHeight('240')
                            ->required(fn (Forms\Get $get, ?PaymentMethod $record): bool => $get('type') === PaymentMethodType::QRIS->value && ! $record?->qris_image)
                            ->saveUploadedFileUsing(ImageOptimizationService::filamentUploadHandler('payment-methods', ['is_qris' => true]))
                            ->columnSpanFull()
                            ->helperText('Upload QRIS code image (PNG, JPG, WEBP). Automatically optimized to high-quality WebP preserving scan sharpness.'),
                    ]),

                Forms\Components\Section::make('Bank Account Details')
                    ->description('Account information settings for manual bank transfer.')
                    ->visible(fn (Forms\Get $get): bool => $get('type') === PaymentMethodType::BANK_TRANSFER->value)
                    ->schema([
                        Forms\Components\TextInput::make('bank_name')
                            ->label('Bank Name')
                            ->placeholder('e.g. BCA, Mandiri, BRI, BNI')
                            ->required(fn (Forms\Get $get): bool => $get('type') === PaymentMethodType::BANK_TRANSFER->value)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('account_number')
                            ->label('Account Number')
                            ->placeholder('e.g. 0123456789')
                            ->required(fn (Forms\Get $get): bool => $get('type') === PaymentMethodType::BANK_TRANSFER->value)
                            ->maxLength(255)
                            ->helperText('Stored as a text string to preserve leading zeros.'),
                        Forms\Components\TextInput::make('account_holder_name')
                            ->label('Account Holder Name')
                            ->placeholder('e.g. InnoElectrica Committee')
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
                    ->label('Method Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state instanceof PaymentMethodType ? $state->label() : ($state === 'qris' ? 'QRIS' : 'Bank Transfer'))
                    ->color(fn ($state) => ($state instanceof PaymentMethodType ? $state->value : $state) === 'qris' ? 'warning' : 'info'),
                Tables\Columns\TextColumn::make('detail')
                    ->label('Account / QRIS Details')
                    ->state(function (PaymentMethod $record): string {
                        if ($record->isQris()) {
                            return $record->qris_image ? 'QRIS Code Attached' : 'No Image Uploaded';
                        }

                        return "{$record->bank_name} - {$record->account_number} ({$record->account_holder_name})";
                    }),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Active'),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Payment Type')
                    ->options(PaymentMethodType::options()),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function (PaymentMethod $record, Tables\Actions\DeleteAction $action) {
                        if ($record->registrations()->exists()) {
                            Notification::make()
                                ->danger()
                                ->title('Cannot Delete Payment Method')
                                ->body('This payment method cannot be deleted because it is referenced by existing registration records. Please deactivate this payment method instead of deleting it to preserve historical integrity.')
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
                                        ->title('Bulk Deletion Cancelled')
                                        ->body('One or more selected payment methods are referenced by existing registrations. The action was cancelled to preserve historical data integrity.')
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
