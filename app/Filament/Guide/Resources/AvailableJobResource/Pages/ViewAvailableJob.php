<?php

namespace App\Filament\Guide\Resources\AvailableJobResource\Pages;

use App\Filament\Guide\Resources\AvailableJobResource;
use App\Models\Application;
use App\Models\TourJob;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Auth;

class ViewAvailableJob extends ViewRecord
{
    protected static string $resource = AvailableJobResource::class;

    protected function getHeaderActions(): array
    {
        $alreadyApplied = Application::where('tour_job_id', $this->record->id)
            ->where('guide_id', Auth::id())
            ->exists();

        if ($alreadyApplied) {
            return [
                Actions\Action::make('applied')
                    ->label('Already Applied')
                    ->icon('heroicon-o-check')
                    ->color('gray')
                    ->disabled(),
            ];
        }

        return [
            Actions\Action::make('apply')
                ->label('Apply Now')
                ->icon('heroicon-o-paper-airplane')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Apply for this job?')
                ->form([
                    Forms\Components\Textarea::make('cover_letter')
                        ->label('Cover Letter (optional)')
                        ->rows(4)
                        ->placeholder('Tell the agency why you are a good fit...'),
                ])
                ->action(function (array $data) {
                    $application = Application::create([
                        'tour_job_id' => $this->record->id,
                        'guide_id' => Auth::id(),
                        'status' => 'pending',
                        'cover_letter' => $data['cover_letter'] ?? null,
                        'applied_at' => now(),
                    ]);

                    $this->record->agency->notify(new \App\Notifications\NewApplication($application));

                    Notification::make()
                        ->title('Application submitted!')
                        ->body("You applied for: {$this->record->title}")
                        ->success()
                        ->send();
                }),
        ];
    }
}
