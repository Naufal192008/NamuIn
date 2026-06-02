<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StafResource\Pages;
use App\Models\Pegawai;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StafResource extends Resource
{
    protected static ?string $model = Pegawai::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Staf Sekolah';
    protected static ?string $modelLabel = 'Staf';
    protected static ?string $pluralModelLabel = 'Staf Sekolah';
    protected static ?string $navigationGroup = 'Manajemen';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Staf')
                ->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('nama')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('Drs. Ahmad Fauzi, M.Pd'),

                        Forms\Components\TextInput::make('nip')
                            ->label('NIP')
                            ->maxLength(20)
                            ->placeholder('196501011990031001')
                            ->nullable(),

                        Forms\Components\TextInput::make('jabatan')
                            ->label('Jabatan')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('Kepala Sekolah'),

                        Forms\Components\TextInput::make('departemen')
                            ->label('Departemen / Bidang')
                            ->maxLength(100)
                            ->placeholder('Kurikulum')
                            ->nullable(),
                    ]),
                ]),

            Forms\Components\Section::make('Kontak')
                ->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('no_wa')
                            ->label('Nomor WhatsApp')
                            ->required()
                            ->tel()
                            ->maxLength(20)
                            ->placeholder('081234567890')
                            ->helperText('Notifikasi WhatsApp dikirim ke nomor ini saat ada tamu.'),

                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(100)
                            ->placeholder('nama@sekolah.sch.id')
                            ->nullable(),
                    ]),
                ]),

            Forms\Components\Toggle::make('aktif')
                ->label('Aktif')
                ->helperText('Staf nonaktif tidak muncul di pilihan form tamu.')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Staf')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Pegawai $r) => $r->email ?? ''),

                Tables\Columns\TextColumn::make('nip')
                    ->label('NIP')
                    ->searchable()
                    ->fontFamily('mono')
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('jabatan')
                    ->label('Jabatan')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('departemen')
                    ->label('Departemen')
                    ->badge()
                    ->color('gray')
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('no_wa')
                    ->label('WhatsApp')
                    ->icon('heroicon-o-phone')
                    ->copyable()
                    ->copyMessage('Nomor disalin'),

                Tables\Columns\TextColumn::make('tamu_count')
                    ->label('Kunjungan')
                    ->counts('tamu')
                    ->sortable()
                    ->badge()
                    ->color('warning'),

                Tables\Columns\ToggleColumn::make('aktif')
                    ->label('Aktif'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('aktif')
                    ->label('Status')
                    ->trueLabel('Aktif')
                    ->falseLabel('Nonaktif'),

                Tables\Filters\SelectFilter::make('departemen')
                    ->label('Departemen')
                    ->options(fn () => Pegawai::query()->distinct()->pluck('departemen', 'departemen')->filter()->toArray()),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('nama');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListStaf::route('/'),
            'create' => Pages\CreateStaf::route('/create'),
            'edit'   => Pages\EditStaf::route('/{record}/edit'),
        ];
    }
}
