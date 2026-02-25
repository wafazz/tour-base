<?php

namespace App\Filament\Agency\Resources\TourJobResource\RelationManagers;

use App\Models\Application;
use App\Models\Invoice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ApplicationsRelationManager extends RelationManager
{
    protected static string $relationship = 'applications';

    protected static ?string $title = 'Applicants';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('guide.name')
                    ->label('Guide')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('guide.email')
                    ->label('Email'),
                Tables\Columns\TextColumn::make('guide.phone')
                    ->label('Phone'),
                Tables\Columns\TextColumn::make('guide.guideProfile.license_no')
                    ->label('License'),
                Tables\Columns\TextColumn::make('guide.guideProfile.experience_years')
                    ->label('Exp (Yrs)'),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'info' => 'shortlisted',
                        'success' => 'accepted',
                        'danger' => 'rejected',
                    ]),
                Tables\Columns\TextColumn::make('applied_at')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('applied_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'shortlisted' => 'Shortlisted',
                        'accepted' => 'Accepted',
                        'rejected' => 'Rejected',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('viewProfile')
                    ->label('View Profile')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->modalHeading(fn (Application $record) => $record->guide->name . ' — Profile')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close')
                    ->infolist(fn (Infolist $infolist) => $infolist
                        ->schema([
                            Infolists\Components\Section::make('Guide Info')
                                ->schema([
                                    Infolists\Components\TextEntry::make('guide.name')->label('Name'),
                                    Infolists\Components\TextEntry::make('guide.email')->label('Email'),
                                    Infolists\Components\TextEntry::make('guide.phone')->label('Phone'),
                                ])->columns(3),
                            Infolists\Components\Section::make('Professional Details')
                                ->schema([
                                    Infolists\Components\TextEntry::make('guide.guideProfile.license_no')->label('License No'),
                                    Infolists\Components\TextEntry::make('guide.guideProfile.experience_years')->label('Experience (Years)'),
                                    Infolists\Components\TextEntry::make('guide.guideProfile.languages')
                                        ->label('Languages')
                                        ->badge(),
                                    Infolists\Components\TextEntry::make('guide.guideProfile.skills')
                                        ->label('Skills')
                                        ->badge(),
                                    Infolists\Components\TextEntry::make('guide.guideProfile.bio')
                                        ->label('Bio')
                                        ->columnSpanFull(),
                                ])->columns(2),
                            Infolists\Components\Section::make('Cover Letter')
                                ->schema([
                                    Infolists\Components\TextEntry::make('cover_letter')
                                        ->label('')
                                        ->placeholder('No cover letter provided'),
                                ]),
                        ])
                    ),
                Tables\Actions\Action::make('shortlist')
                    ->label('Shortlist')
                    ->icon('heroicon-o-star')
                    ->color('info')
                    ->requiresConfirmation()
                    ->visible(fn (Application $record) => $record->status === 'pending')
                    ->action(function (Application $record) {
                        $record->update(['status' => 'shortlisted']);
                        $record->guide->notify(new \App\Notifications\ApplicationStatusChanged($record, 'shortlisted'));

                        Notification::make()
                            ->title('Candidate shortlisted')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\Action::make('accept')
                    ->label('Accept')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalDescription('Accepting this candidate will auto-generate an invoice.')
                    ->visible(fn (Application $record) => in_array($record->status, ['pending', 'shortlisted']))
                    ->action(function (Application $record) {
                        $record->update(['status' => 'accepted']);

                        $tourJob = $record->tourJob;
                        $fee = $tourJob->fee;
                        $tax = round($fee * 0.06, 2);

                        $invoice = Invoice::create([
                            'application_id' => $record->id,
                            'agency_id' => $tourJob->agency_id,
                            'guide_id' => $record->guide_id,
                            'invoice_number' => Invoice::generateNumber(),
                            'amount' => $fee,
                            'tax' => $tax,
                            'total' => $fee + $tax,
                            'payment_status' => 'pending',
                            'issued_at' => now(),
                        ]);

                        $record->guide->notify(new \App\Notifications\ApplicationStatusChanged($record, 'accepted'));
                        $tourJob->agency->notify(new \App\Notifications\InvoiceGenerated($invoice));

                        Notification::make()
                            ->title('Candidate accepted & invoice generated')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (Application $record) => in_array($record->status, ['pending', 'shortlisted']))
                    ->action(function (Application $record) {
                        $record->update(['status' => 'rejected']);
                        $record->guide->notify(new \App\Notifications\ApplicationStatusChanged($record, 'rejected'));

                        Notification::make()
                            ->title('Candidate rejected')
                            ->danger()
                            ->send();
                    }),
            ])
            ->bulkActions([]);
    }
}
