<?php

namespace App\Filament\Admin\Resources\TourJobResource\Pages;

use App\Filament\Admin\Resources\TourJobResource;
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
