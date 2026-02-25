<?php

namespace App\Filament\Admin\Resources\TourJobResource\Pages;

use App\Filament\Admin\Resources\TourJobResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTourJobs extends ListRecords
{
    protected static string $resource = TourJobResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
