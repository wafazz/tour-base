<?php

namespace App\Filament\Agency\Resources\ReviewResource\Pages;

use App\Filament\Agency\Resources\ReviewResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateReview extends CreateRecord
{
    protected static string $resource = ReviewResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['agency_id'] = Auth::id();

        return $data;
    }
}
