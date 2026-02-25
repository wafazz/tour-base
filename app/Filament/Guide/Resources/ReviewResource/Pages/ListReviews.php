<?php

namespace App\Filament\Guide\Resources\ReviewResource\Pages;

use App\Filament\Guide\Resources\ReviewResource;
use Filament\Resources\Pages\ListRecords;

class ListReviews extends ListRecords
{
    protected static string $resource = ReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
