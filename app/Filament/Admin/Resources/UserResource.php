<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Management';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('User Info')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->maxLength(20),
                        Forms\Components\Select::make('role')
                            ->options([
                                'admin' => 'Admin',
                                'agency' => 'Agency',
                                'guide' => 'Guide',
                            ])
                            ->required()
                            ->disabled(),
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'approved' => 'Approved',
                                'rejected' => 'Rejected',
                            ])
                            ->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('role')
                    ->colors([
                        'danger' => 'admin',
                        'warning' => 'agency',
                        'info' => 'guide',
                    ]),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'agency' => 'Agency',
                        'guide' => 'Guide',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (User $record) => $record->status === 'pending')
                    ->action(function (User $record) {
                        $record->update(['status' => 'approved']);
                        $record->notify(new \App\Notifications\AccountApproved());

                        \Filament\Notifications\Notification::make()
                            ->title("{$record->name} approved")
                            ->success()
                            ->send();
                    }),
                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (User $record) => $record->status === 'pending')
                    ->action(function (User $record) {
                        $record->update(['status' => 'rejected']);
                        $record->notify(new \App\Notifications\AccountRejected());

                        \Filament\Notifications\Notification::make()
                            ->title("{$record->name} rejected")
                            ->danger()
                            ->send();
                    }),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('User Info')
                    ->schema([
                        Infolists\Components\TextEntry::make('name'),
                        Infolists\Components\TextEntry::make('email'),
                        Infolists\Components\TextEntry::make('phone'),
                        Infolists\Components\TextEntry::make('role')
                            ->badge()
                            ->color(fn (string $state) => match ($state) {
                                'admin' => 'danger',
                                'agency' => 'warning',
                                'guide' => 'info',
                            }),
                        Infolists\Components\TextEntry::make('status')
                            ->badge()
                            ->color(fn (string $state) => match ($state) {
                                'pending' => 'warning',
                                'approved' => 'success',
                                'rejected' => 'danger',
                            }),
                        Infolists\Components\TextEntry::make('created_at')
                            ->dateTime('d M Y H:i'),
                    ])->columns(2),
                Infolists\Components\Section::make('Guide Profile')
                    ->schema([
                        Infolists\Components\TextEntry::make('guideProfile.license_no')
                            ->label('License No'),
                        Infolists\Components\TextEntry::make('guideProfile.experience_years')
                            ->label('Experience (Years)'),
                        Infolists\Components\TextEntry::make('guideProfile.bio')
                            ->label('Bio')
                            ->columnSpanFull(),
                    ])->columns(2)
                    ->visible(fn ($record) => $record->role === 'guide' && $record->guideProfile),
                Infolists\Components\Section::make('Agency Profile')
                    ->schema([
                        Infolists\Components\TextEntry::make('agencyProfile.company_name')
                            ->label('Company Name'),
                        Infolists\Components\TextEntry::make('agencyProfile.motac_reg_no')
                            ->label('MOTAC Reg No'),
                        Infolists\Components\TextEntry::make('agencyProfile.contact_person')
                            ->label('Contact Person'),
                        Infolists\Components\TextEntry::make('agencyProfile.company_phone')
                            ->label('Company Phone'),
                        Infolists\Components\TextEntry::make('agencyProfile.company_address')
                            ->label('Address')
                            ->columnSpanFull(),
                    ])->columns(2)
                    ->visible(fn ($record) => $record->role === 'agency' && $record->agencyProfile),
                Infolists\Components\Section::make('Documents')
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('documents')
                            ->schema([
                                Infolists\Components\TextEntry::make('type')
                                    ->badge(),
                                Infolists\Components\TextEntry::make('original_name')
                                    ->label('File'),
                                Infolists\Components\TextEntry::make('verified_at')
                                    ->label('Verified')
                                    ->dateTime('d M Y')
                                    ->placeholder('Not verified'),
                            ])->columns(3),
                    ])
                    ->visible(fn ($record) => $record->documents->isNotEmpty()),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
            'view' => Pages\ViewUser::route('/{record}'),
        ];
    }
}
