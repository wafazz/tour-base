<?php

namespace App\Filament\Agency\Resources\TourJobResource\Pages;

use App\Filament\Agency\Resources\TourJobResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateTourJob extends CreateRecord
{
    protected static string $resource = TourJobResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['agency_id'] = Auth::id();
        $data['status'] = 'pending';

        return $data;
    }
}
