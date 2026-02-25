<?php

namespace App\Filament\Agency\Resources;

use App\Filament\Agency\Resources\ReviewResource\Pages;
use App\Models\Application;
use App\Models\Review;
use App\Models\TourJob;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationLabel = 'Reviews';

    protected static ?int $navigationSort = 3;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('agency_id', Auth::id());
    }

    public static function form(Form $form): Form
    {
        $agencyId = Auth::id();

        $completedJobIds = TourJob::where('agency_id', $agencyId)
            ->where('status', 'closed')
            ->orWhere(function ($q) use ($agencyId) {
                $q->where('agency_id', $agencyId)->where('end_date', '<', now());
            })
            ->pluck('id');

        $acceptedApps = Application::whereIn('tour_job_id', $completedJobIds)
            ->where('status', 'accepted')
            ->with(['guide', 'tourJob'])
            ->get();

        $alreadyReviewed = Review::where('agency_id', $agencyId)->pluck('tour_job_id')
            ->combine(Review::where('agency_id', $agencyId)->pluck('guide_id'));

        $jobOptions = [];
        $guideOptions = [];
        foreach ($acceptedApps as $app) {
            $jobOptions[$app->tour_job_id] = $app->tourJob->title;
            $guideOptions[$app->guide_id] = $app->guide->name;
        }

        return $form
            ->schema([
                Forms\Components\Section::make('Review Guide')
                    ->schema([
                        Forms\Components\Select::make('tour_job_id')
                            ->label('Job')
                            ->options($jobOptions)
                            ->required()
                            ->searchable(),
                        Forms\Components\Select::make('guide_id')
                            ->label('Guide')
                            ->options($guideOptions)
                            ->required()
                            ->searchable(),
                        Forms\Components\Select::make('rating')
                            ->options([
                                1 => '1 - Poor',
                                2 => '2 - Fair',
                                3 => '3 - Good',
                                4 => '4 - Very Good',
                                5 => '5 - Excellent',
                            ])
                            ->required(),
                        Forms\Components\Textarea::make('comment')
                            ->rows(4)
                            ->maxLength(1000)
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tourJob.title')
                    ->label('Job')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('guide.name')
                    ->label('Guide')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rating')
                    ->badge()
                    ->color(fn (int $state) => match (true) {
                        $state >= 4 => 'success',
                        $state >= 3 => 'warning',
                        default => 'danger',
                    })
                    ->formatStateUsing(fn (int $state) => $state . '/5'),
                Tables\Columns\TextColumn::make('comment')
                    ->limit(50),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReviews::route('/'),
            'create' => Pages\CreateReview::route('/create'),
            'edit' => Pages\EditReview::route('/{record}/edit'),
        ];
    }
}
