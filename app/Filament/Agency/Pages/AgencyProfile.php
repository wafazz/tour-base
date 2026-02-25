<?php

namespace App\Filament\Agency\Pages;

use App\Models\AgencyProfile as AgencyProfileModel;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class AgencyProfile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationLabel = 'My Profile';

    protected static ?int $navigationSort = 0;

    protected static string $view = 'filament.agency.pages.agency-profile';

    public ?array $data = [];

    public function mount(): void
    {
        $profile = Auth::user()->agencyProfile;

        $this->form->fill([
            'company_name' => $profile?->company_name,
            'motac_reg_no' => $profile?->motac_reg_no,
            'contact_person' => $profile?->contact_person,
            'company_address' => $profile?->company_address,
            'company_phone' => $profile?->company_phone,
            'company_logo' => $profile?->company_logo,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Company Information')
                    ->schema([
                        Forms\Components\TextInput::make('company_name')
                            ->label('Company Name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('motac_reg_no')
                            ->label('MOTAC Registration No.')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('contact_person')
                            ->label('Contact Person')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('company_phone')
                            ->label('Company Phone')
                            ->tel()
                            ->maxLength(20),
                        Forms\Components\Textarea::make('company_address')
                            ->label('Company Address')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('company_logo')
                            ->label('Company Logo')
                            ->image()
                            ->disk('public')
                            ->directory('agency-logos')
                            ->maxSize(2048),
                    ])->columns(2),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        AgencyProfileModel::updateOrCreate(
            ['user_id' => Auth::id()],
            $data,
        );

        Notification::make()
            ->title('Profile updated successfully')
            ->success()
            ->send();
    }
}
