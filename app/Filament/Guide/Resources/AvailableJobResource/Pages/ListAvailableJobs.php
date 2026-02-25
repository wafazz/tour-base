<?php

namespace App\Filament\Guide\Resources\AvailableJobResource\Pages;

use App\Filament\Guide\Resources\AvailableJobResource;
use Filament\Resources\Pages\ListRecords;

class ListAvailableJobs extends ListRecords
{
    protected static string $resource = AvailableJobResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
