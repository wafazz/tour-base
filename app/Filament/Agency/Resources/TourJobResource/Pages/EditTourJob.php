<?php

namespace App\Filament\Agency\Resources\TourJobResource\Pages;

use App\Filament\Agency\Resources\TourJobResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTourJob extends EditRecord
{
    protected static string $resource = TourJobResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
