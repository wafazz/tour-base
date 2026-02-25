<?php

namespace App\Filament\Agency\Pages\Auth;

use App\Models\AgencyProfile;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\Register;
use Filament\Http\Responses\Auth\Contracts\RegistrationResponse;

class AgencyRegister extends Register
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getNameFormComponent(),
                $this->getEmailFormComponent(),
                TextInput::make('phone')
                    ->label('Phone Number')
                    ->tel(),
                TextInput::make('company_name')
                    ->label('Company Name')
                    ->required(),
                TextInput::make('motac_reg_no')
                    ->label('MOTAC Registration No.')
                    ->required(),
                TextInput::make('contact_person')
                    ->label('Contact Person'),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }

    protected function handleRegistration(array $data): \App\Models\User
    {
        $user = \App\Models\User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => $data['password'],
            'role' => 'agency',
            'status' => 'pending',
        ]);

        AgencyProfile::create([
            'user_id' => $user->id,
            'company_name' => $data['company_name'],
            'motac_reg_no' => $data['motac_reg_no'],
            'contact_person' => $data['contact_person'] ?? null,
        ]);

        return $user;
    }

    public function register(): ?RegistrationResponse
    {
        $this->callHook('beforeValidate');
        $data = $this->form->getState();
        $this->callHook('afterValidate');

        $this->callHook('beforeRegister');
        $user = $this->handleRegistration($data);
        $this->callHook('afterRegister');

        $this->redirect(route('pending-approval'));
        return null;
    }
}
