<?php

namespace App\Filament\Agency\Resources\ReviewResource\Pages;

use App\Filament\Agency\Resources\ReviewResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReviews extends ListRecords
{
    protected static string $resource = ReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Write Review'),
        ];
    }
}
